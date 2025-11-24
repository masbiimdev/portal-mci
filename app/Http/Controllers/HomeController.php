<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Annon;
use App\ActivityItemResult;
use App\Material;
use App\MaterialIn;
use App\MaterialOut;
use App\CalibrationHistory;
use App\Tool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Home Page — Portal tanpa login
     */
    public function index()
    {
        $announcements = Annon::where('is_active', true)
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('pages.home', compact('announcements'));
    }

        public function under()
    {
        return view('pages.under');
    }

    /**
     * Halaman Jadwal & hasil inspeksi
     */
    public function jadwal()
    {
        $activities = Activity::all();

        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $todayCount = Activity::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->count();

        $weekCount = Activity::whereBetween('start_date', [$weekStart, $weekEnd])
            ->orWhereBetween('end_date', [$weekStart, $weekEnd])
            ->count();

        $weekActivities = Activity::whereBetween('start_date', [$weekStart, $weekEnd])
            ->orWhereBetween('end_date', [$weekStart, $weekEnd])
            ->get();

        $activityResults = ActivityItemResult::whereIn('activity_id', $activities->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->get();

        $resultsData = $activityResults->map(function ($r) {
            return [
                'id' => $r->id,
                'activity_id' => $r->activity_id,
                'part_name' => $r->part_name,
                'material' => $r->material,
                'qty' => $r->qty,
                'inspector_name' => $r->inspector_name,
                'pic' => $r->pic,
                'inspection_time' => $r->inspection_time,
                'result' => $r->result,
                'status' => $r->status,
                'remarks' => $r->remarks,
                'user_name' => optional($r->user)->name ?? '-',
            ];
        })->toArray();

        return view('pages.jadwal', compact(
            'activities',
            'todayCount',
            'weekCount',
            'weekActivities',
            'activityResults',
            'resultsData'
        ));
    }

    /**
     * Simpan atau update hasil inspeksi
     */
    public function storeOrUpdateResult(Request $request)
    {
        $validated = $request->validate([
            'result_id' => 'nullable|exists:activity_item_results,id',
            'activity_id' => 'required|exists:activities,id',
            'part_name' => 'required|string',
            'material' => 'nullable|string',
            'qty' => 'nullable|integer',
            'inspector_name' => 'required|string',
            'pic' => 'required|string',
            'inspection_time' => 'nullable|date_format:Y-m-d H:i:s',
            'result' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        if (!empty($validated['result_id'])) {
            $res = ActivityItemResult::findOrFail($validated['result_id']);
            $res->update([
                'activity_id' => $validated['activity_id'],
                'part_name' => $validated['part_name'],
                'material' => $validated['material'] ?? null,
                'qty' => $validated['qty'] ?? null,
                'inspector_name' => $validated['inspector_name'],
                'pic' => $validated['pic'],
                'result' => $validated['result'],
                'status' => 'Checked',
                'remarks' => $validated['remarks'] ?? null,
                'user_id' => Auth::check() ? Auth::id() : null,
            ]);
            $message = 'Hasil pemeriksaan berhasil diperbarui!';
        } else {
            $inspectionTime = $validated['inspection_time'] ?? now()->toDateTimeString();

            $res = ActivityItemResult::create([
                'activity_id' => $validated['activity_id'],
                'part_name' => $validated['part_name'],
                'material' => $validated['material'] ?? null,
                'qty' => $validated['qty'] ?? null,
                'inspector_name' => $validated['inspector_name'],
                'pic' => $validated['pic'],
                'inspection_time' => $inspectionTime,
                'result' => $validated['result'],
                'status' => 'Checked',
                'remarks' => $validated['remarks'] ?? null,
                'user_id' => Auth::check() ? Auth::id() : null,
            ]);
            $message = 'Hasil pemeriksaan berhasil disimpan!';
        }

        $activity = Activity::find($validated['activity_id']);
        if ($activity) {
            $activity->update(['has_result' => true]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Ambil hasil inspeksi via AJAX
     */
    public function getActivityResults(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'part_name' => 'required|string',
        ]);

        $results = ActivityItemResult::with('user:id,name')
            ->where('activity_id', $request->activity_id)
            ->where('part_name', $request->part_name)
            ->orderBy('inspection_time', 'desc')
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'activity_id' => $r->activity_id,
                    'part_name' => $r->part_name,
                    'material' => $r->material,
                    'qty' => $r->qty,
                    'inspector_name' => $r->inspector_name,
                    'pic' => $r->pic,
                    'inspection_time' => $r->inspection_time,
                    'result' => $r->result,
                    'status' => $r->status,
                    'remarks' => $r->remarks,
                    'user_name' => optional($r->user)->name ?? '-',
                ];
            });

        return response()->json($results);
    }

    /**
     * Halaman publik inventory
     */
    public function inventory()
    {
        return view('pages.inventory');
    }

    /**
     * Data inventory (JSON)
     */
    public function getData(Request $request)
    {
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $search = $request->get('search');

        $materials = Material::with(['rack', 'incomings', 'outgoings', 'stockOpnameLatest', 'valves', 'sparePart'])
            // 🔍 Filter pencarian
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('heat_lot_no', 'like', "%{$search}%")
                        ->orWhere('no_drawing', 'like', "%{$search}%")
                        ->orWhere('dimensi', 'like', "%{$search}%")
                        ->orWhere('stock_minimum', 'like', "%{$search}%")
                        ->orWhereHas('rack', fn($r) => $r->where('rack_name', 'like', "%{$search}%"))
                        ->orWhereHas('sparePart', fn($s) => $s->where('spare_part_name', 'like', "%{$search}%"))
                        ->orWhereHas('valves', fn($v) => $v->where('valve_name', 'like', "%{$search}%"));
                });
            })
            ->get()
            ->map(function ($item) use ($bulan, $tahun) {
                // Filter data masuk (Incoming)
                $filteredIncomings = $item->incomings->when($bulan && $tahun, function ($query) use ($bulan, $tahun) {
                    return $query->filter(function ($in) use ($bulan, $tahun) {
                        return Carbon::parse($in->created_at)->month == $bulan &&
                            Carbon::parse($in->created_at)->year == $tahun;
                    });
                }, fn($q) => $q);

                // Filter data keluar (Outgoing)
                $filteredOutgoings = $item->outgoings->when($bulan && $tahun, function ($query) use ($bulan, $tahun) {
                    return $query->filter(function ($out) use ($bulan, $tahun) {
                        return Carbon::parse($out->created_at)->month == $bulan &&
                            Carbon::parse($out->created_at)->year == $tahun;
                    });
                }, fn($q) => $q);

                // Hitung total in & out
                $qty_in = $filteredIncomings->sum('qty_in') ?? 0;
                $qty_out = $filteredOutgoings->sum('qty_out') ?? 0;
                $stock_akhir = $item->stock_awal + $qty_in - $qty_out;

                // Data opname terakhir
                $opname = optional($item->stockOpnameLatest)->stock_actual;
                $selisih = $opname ? $opname - $stock_akhir : null;

                // Tentukan status peringatan
                $warning = $stock_akhir < $item->stock_minimum ? 'Below Minimum Stock' : 'OK';

                // Format valve names jadi seperti GL.6.600 GL.8.300,150
                $valveNames = '-';
                $codes = $item->valves->pluck('valve_name');
                if ($codes->isNotEmpty()) {
                    $grouped = $codes->groupBy(function ($code) {
                        return substr($code, 0, strrpos($code, '.'));
                    });
                    $formattedGroups = $grouped->map(function ($items, $prefix) {
                        $suffixes = $items->map(function ($c) {
                            return substr($c, strrpos($c, '.') + 1);
                        });
                        return $prefix . '.' . $suffixes->join(',');
                    });
                    $valveNames = $formattedGroups->join(' ');
                }

                return [
                    'material' => [
                        'heat_lot_no' => $item->heat_lot_no,
                        'no_drawing' => $item->no_drawing,
                        'valve_name' => $valveNames,
                        'spare_part_name' => optional($item->sparePart)->spare_part_name ?? '-',
                        'dimensi' => $item->dimensi,
                        'stock_awal' => $item->stock_awal,
                        'stock_minimum' => $item->stock_minimum,
                        'rack_name' => optional($item->rack)->rack_name ?? '-',
                    ],
                    'qty_in' => $qty_in,
                    'qty_out' => $qty_out,
                    'stock_akhir' => $stock_akhir,
                    'opname' => $opname,
                    'selisih' => $selisih,
                    'balance' => $stock_akhir - $item->stock_minimum,
                    'warning' => $warning,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ];
            });

        return response()->json($materials);
    }


    /**
     * Summary data inventory
     */
    public function getSummary()
    {
        $materials = Material::with(['incomings', 'outgoings'])->get();

        $total_barang = $materials->count();
        $total_masuk = $materials->sum(function ($m) {
            return $m->incomings->sum('qty_in');
        });
        $total_keluar = $materials->sum(function ($m) {
            return $m->outgoings->sum('qty_out');
        });
        $below_minimum = $materials->filter(function ($m) {
            return $m->stock_awal < $m->stock_minimum;
        })->count();

        return response()->json([
            'total_barang' => $total_barang,
            'total_masuk' => $total_masuk,
            'total_keluar' => $total_keluar,
            'below_minimum' => $below_minimum,
        ]);
    }

    public function getChart(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $bulan = $request->get('bulan', date('m')); // default bulan sekarang

        // Ambil total qty_in & qty_out per bulan
        $dataMasuk = MaterialIn::selectRaw('MONTH(created_at) as bulan, SUM(qty_in) as total')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $dataKeluar = MaterialOut::selectRaw('MONTH(created_at) as bulan, SUM(qty_out) as total')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $masuk = [];
        $keluar = [];

        for ($i = 1; $i <= 12; $i++) {
            $masuk[] = $dataMasuk[$i] ?? 0;
            $keluar[] = $dataKeluar[$i] ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'masuk' => $masuk,
            'keluar' => $keluar,
            'current_month' => $bulan,
            'current_year' => $tahun
        ]);
    }

      public function kalibrasi()
    {
        // Ambil semua alat beserta history terbaru
        $tools = Tool::with('latestHistory')->orderBy('nama_alat')->get();

        // Summary
        $totalTools = $tools->count();
        $statusOk = $tools->filter(function ($t) {
            return optional($t->latestHistory)->status_kalibrasi === 'OK';
        })->count();

        $statusProses = $tools->filter(function ($t) {
            return optional($t->latestHistory)->status_kalibrasi === 'PROSES';
        })->count();

        // Akan jatuh tempo dalam 30 hari
        $dueSoon = $tools->filter(function ($t) {
            $tgl = optional($t->latestHistory)->tgl_kalibrasi_ulang;
            if (!$tgl) return false;
            $now = Carbon::now();
            return Carbon::parse($tgl)->between($now, $now->copy()->addDays(30));
        })->count();

        // Data pie chart
        $pieData = [
            'ok' => $statusOk,
            'proses' => $statusProses,
            'due' => $dueSoon,
        ];

        // Bar chart: jumlah alat jatuh tempo per bulan
        $barLabels = [];
        $barValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $barLabels[] = Carbon::create()->month($i)->translatedFormat('F');

            $count = $tools->filter(function ($t) use ($i) {
                $tgl = optional($t->latestHistory)->tgl_kalibrasi_ulang;
                return $tgl && Carbon::parse($tgl)->month === $i;
            })->count();

            $barValues[] = $count;
        }

        return view('pages.kalibrasi', compact(
            'tools',
            'totalTools',
            'statusOk',
            'statusProses',
            'dueSoon',
            'pieData',
            'barLabels',
            'barValues'
        ));
    }
}
