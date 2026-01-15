<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialIn;
use App\Material;
use App\MaterialOut;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MaterialInController extends Controller
{
    public function index()
    {
        $materialIns = MaterialIn::with('material', 'user')
            ->latest()
            ->paginate(10);

        return view('pages.admin.inventory.material_in.index', compact('materialIns'));
    }
    public function create(Request $r)
    {
        $month = $r->month ?? now()->format('m');
        $year  = $r->year ?? now()->year;

        $materials = Material::with(['valves', 'sparePart'])->get();

        // Hitung stok awal bulan
        $stokAwalPerMaterial = [];
        foreach ($materials as $material) {
            $currentMonthStart = \Carbon\Carbon::create($year, $month, 1);
            $prevMonthEnd = $currentMonthStart->copy()->subDay()->format('Y-m-d');

            $totalInPrev = MaterialIn::where('material_id', $material->id)
                ->whereDate('date_in', '<=', $prevMonthEnd)
                ->sum('qty_in');

            $totalOutPrev = MaterialOut::where('material_id', $material->id)
                ->whereDate('date_out', '<=', $prevMonthEnd)
                ->sum('qty_out');

            $stokAwalPerMaterial[$material->id] = $material->stock_awal + $totalInPrev - $totalOutPrev;
        }

        // Ambil transaksi harian untuk bulan ini
        $dailyInputs = MaterialIn::selectRaw("material_id, DATE(date_in) as date_in, qty_in")
            ->whereYear('date_in', $year)
            ->whereMonth('date_in', $month)
            ->get()
            ->groupBy('material_id');

        $days = Carbon::create($year, $month)->daysInMonth;

        return view('pages.admin.inventory.material_in.add', compact(
            'materials',
            'dailyInputs',
            'month',
            'year',
            'days',
            'stokAwalPerMaterial'
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
            'qty_in'      => 'required|integer|min:1',
            'date_in'     => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $materialId = $request->material_id;

                $existing = MaterialIn::where('material_id', $materialId)
                    ->whereDate('date_in', $request->date_in)
                    ->lockForUpdate()
                    ->first();

                // hitung stok dari ledger
                $currentStock = $this->getCurrentStock($materialId);

                if ($existing) {
                    $diff = $request->qty_in - $existing->qty_in;
                    $stockAfter = $currentStock + $diff;

                    if ($stockAfter < 0) {
                        throw new \Exception('Stok menjadi negatif');
                    }

                    $existing->update([
                        'qty_in'      => $request->qty_in,
                        'stock_after' => $stockAfter,
                        'notes'       => $request->notes ?? '-',
                        'user_id'     => Auth::id(),
                    ]);
                } else {
                    $stockAfter = $currentStock + $request->qty_in;

                    MaterialIn::create([
                        'material_id' => $materialId,
                        'qty_in'      => $request->qty_in,
                        'date_in'     => $request->date_in,
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

    public function destroy(MaterialIn $materialIn)
    {
        $materialIn->delete();

        return redirect()
            ->route('material_in.index')
            ->with('success', 'Data material Masuk berhasil dihapus.');
    }
}
