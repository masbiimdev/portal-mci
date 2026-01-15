<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\MaterialIn;
use App\MaterialOut;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaterialOutController extends Controller
{
    public function index()
    {
        $materialOuts = MaterialOut::with('material', 'user')->latest()->paginate(10);
        return view('pages.admin.inventory.material_out.index', compact('materialOuts'));
    }
    public function create(Request $r)
    {
        $month = $r->month ?? now()->format('m');
        $year  = $r->year ?? now()->year;

        $materials = Material::with(['valves', 'sparePart'])->get();

        // ===============================
        // 1️⃣ Hitung Stok Awal Per Material
        // ===============================
        $stokAwalPerMaterial = [];

        foreach ($materials as $material) {
            $currentMonthStart = Carbon::create($year, $month, 1);
            $prevMonthEnd = $currentMonthStart->copy()->subDay()->format('Y-m-d');

            $totalInPrev = MaterialIn::where('material_id', $material->id)
                ->whereDate('date_in', '<=', $prevMonthEnd)
                ->sum('qty_in');

            $totalOutPrev = MaterialOut::where('material_id', $material->id)
                ->whereDate('date_out', '<=', $prevMonthEnd)
                ->sum('qty_out');

            $stokAwalPerMaterial[$material->id] =
                $material->stock_awal + $totalInPrev - $totalOutPrev;
        }

        // ===============================
        // 2️⃣ Ambil transaksi harian OUT untuk bulan ini
        // ===============================
        $dailyInputs = MaterialOut::selectRaw("material_id, DATE(date_out) as date_out, qty_out")
            ->whereYear('date_out', $year)
            ->whereMonth('date_out', $month)
            ->get()
            ->groupBy('material_id');

        // ===============================
        // 3️⃣ Jumlah hari dalam bulan
        // ===============================
        $days = Carbon::create($year, $month)->daysInMonth;

        return view('pages.admin.inventory.material_out.add', compact(
            'materials',
            'dailyInputs',
            'stokAwalPerMaterial',
            'month',
            'year',
            'days'
        ));
    }

    public function getCurrentStock($materialId)
    {
        $material = Material::findOrFail($materialId);

        $totalIn = MaterialIn::where('material_id', $materialId)->sum('qty_in');
        $totalOut = MaterialOut::where('material_id', $materialId)->sum('qty_out');

        return $material->stock_awal + $totalIn - $totalOut;
    }
    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'qty_out'     => 'required|integer|min:1',
            'date_out'    => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $materialId = $request->material_id;

                $existing = MaterialOut::where('material_id', $materialId)
                    ->whereDate('date_out', $request->date_out)
                    ->lockForUpdate()
                    ->first();

                // stok dari ledger
                $currentStock = $this->getCurrentStock($materialId);

                if ($existing) {
                    // EDIT TRANSAKSI
                    $diff = $request->qty_out - $existing->qty_out;

                    // stok setelah edit
                    $stockAfter = $currentStock - $diff;

                    if ($stockAfter < 0) {
                        throw new \Exception('Stok tidak mencukupi');
                    }

                    $existing->update([
                        'qty_out'     => $request->qty_out,
                        'stock_after' => $stockAfter,
                        'notes'       => $request->notes ?? '-',
                        'user_id'     => Auth::id(),
                    ]);
                } else {
                    // TRANSAKSI BARU
                    if ($currentStock < $request->qty_out) {
                        throw new \Exception('Stok tidak mencukupi');
                    }

                    $stockAfter = $currentStock - $request->qty_out;

                    MaterialOut::create([
                        'material_id' => $materialId,
                        'qty_out'     => $request->qty_out,
                        'date_out'    => $request->date_out,
                        'stock_after' => $stockAfter,
                        'notes'       => $request->notes ?? '-',
                        'user_id'     => Auth::id(),
                    ]);
                }
            });

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy(MaterialOut $materialOut)
    {
        $materialOut->delete();

        return redirect()
            ->route('material_out.index')
            ->with('success', 'Data material Masuk berhasil dihapus.');
    }
}
