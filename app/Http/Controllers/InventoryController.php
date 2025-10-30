<?php

namespace App\Http\Controllers;

use App\Material;
use App\MaterialIn;
use App\MaterialOut;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        // Total statistik
        $totalMaterials = Material::count();
        $totalStock = Material::all()->sum('current_stock');
        $totalIn = MaterialIn::sum('qty_in');
        $totalOut = MaterialOut::sum('qty_out');

        // Barang dengan stok di bawah minimum
        $materials = Material::with(['incomings', 'outgoings'])->get();

        $lowStock = $materials->filter(function ($material) {
            return $material->current_stock < $material->stock_minimum;
        })
            ->sortBy('current_stock')
            ->take(5)
            ->values();

        // Data untuk grafik per bulan (barang masuk dan keluar)
        $chartData = DB::table('material_in')
            ->selectRaw('MONTH(date_in) as month, SUM(qty_in) as total_in')
            ->groupBy('month')
            ->pluck('total_in', 'month')
            ->toArray();

        $chartDataOut = DB::table('material_out')
            ->selectRaw('MONTH(date_out) as month, SUM(qty_out) as total_out')
            ->groupBy('month')
            ->pluck('total_out', 'month')
            ->toArray();

        // Gabungkan data bulan 1–12
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = [
                'month' => date('M', mktime(0, 0, 0, $i, 1)),
                'in' => $chartData[$i] ?? 0,
                'out' => $chartDataOut[$i] ?? 0,
            ];
        }

        // 4️⃣ History transaksi terakhir
        // Barang masuk
        $in = MaterialIn::with(['material', 'user'])
            ->select('id', 'material_id', 'qty_in as qty', 'notes', 'created_at as tanggal', 'stock_after')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'in';
                $item->date_in = $item->tanggal;
                $item->stock_awal = $item->material->stock_awal ?? 0;
                $item->current_stock = $item->material->current_stock ?? 0;
                return $item;
            });

        // Barang keluar
        $out = MaterialOut::with(['material', 'user'])
            ->select('id', 'material_id', 'qty_out as qty', 'notes', 'created_at as tanggal', 'stock_after')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'out';
                $item->date_in = $item->tanggal;
                $item->stock_awal = $item->material->stock_awal ?? 0;
                $item->current_stock = $item->material->current_stock ?? 0;
                return $item;
            });

        $history = $in->concat($out)->sortByDesc('tanggal')->take(10);

        return view('pages.admin.inventory.dashboard', compact(
            'totalMaterials',
            'totalStock',
            'totalIn',
            'totalOut',
            'lowStock',
            'monthlyData',
            'history',
        ));
    }

    public function stockSummary()
    {
        $materials = Material::with(['rack', 'incomings', 'outgoings', 'stockOpnameLatest'])
            ->get()
            ->map(function ($item) {
                $qty_in = optional($item->incomings)->sum('qty_in') ?? 0;
                $qty_out = optional($item->outgoings)->sum('qty_out') ?? 0;
                $stock_akhir = $item->stock_awal + $qty_in - $qty_out;
                $opname = isset($item->stockOpnameLatest) ? $item->stockOpnameLatest->stock_actual : null;
                $selisih = $opname ? $opname - $stock_akhir : null;

                return [
                    'material' => $item,
                    'qty_in' => $qty_in,
                    'qty_out' => $qty_out,
                    'stock_akhir' => $stock_akhir,
                    'opname' => $opname,
                    'selisih' => $selisih,
                    'balance' => $stock_akhir - $item->stock_minimum,
                    'warning' => $stock_akhir < $item->stock_minimum ? 'Below Minimum Stock' : '-'
                ];
            });

        // dd($materials);
        return view('pages.admin.inventory.report.stock-summary', compact('materials'));
    }

    public function reportExcel(Request $request)
    {
        $bulanIndo = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $namaBulan = $bulanIndo[(int)$request->bulan];

        return Excel::download(
            new StockExport($request->bulan, $request->tahun),
            'Report Kontrol Barang ' . $namaBulan . ' ' . $request->tahun . '.xlsx'
        );
    }

    public function reportPdf(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Ambil semua data material dengan relasi
        $materials = Material::with(['rack', 'incomings', 'outgoings', 'stockOpnameLatest'])
            ->get()
            ->map(function ($item) {
                $qty_in = optional($item->incomings)->sum('qty_in') ?? 0;
                $qty_out = optional($item->outgoings)->sum('qty_out') ?? 0;
                $stock_akhir = $item->stock_awal + $qty_in - $qty_out;
                $opname = isset($item->stockOpnameLatest) ? $item->stockOpnameLatest->stock_actual : null;
                $selisih = $opname !== null ? $opname - $stock_akhir : null;

                return [
                    'material' => $item,
                    'qty_in' => $qty_in,
                    'qty_out' => $qty_out,
                    'stock_akhir' => $stock_akhir,
                    'opname' => $opname,
                    'selisih' => $selisih,
                    'balance' => $stock_akhir - $item->stock_minimum,
                    'warning' => $stock_akhir < $item->stock_minimum ? 'Below Minimum Stock' : '-'
                ];
            });

        // Jika ingin filter bulan & tahun
        if ($bulan) {
            $materials = $materials->filter(function ($item) use ($bulan) {
                $itemBulan = \Carbon\Carbon::parse($item['material']->created_at)->format('m');
                return $itemBulan === $bulan;
            });
        }

        if ($tahun) {
            $materials = $materials->filter(function ($item) use ($tahun) {
                $itemTahun = \Carbon\Carbon::parse($item['material']->created_at)->format('Y');
                return $itemTahun === $tahun;
            });
        }

        // Load view PDF, pastikan variable compact sama
        $pdf = Pdf::loadView('pages.admin.inventory.report.export.stock-pdf', [
            'materials' => $materials,
            'bulan' => $bulan,
            'tahun' => $tahun
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('Stock-Report.pdf');
    }
}
