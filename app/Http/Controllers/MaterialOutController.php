<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\MaterialOut;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MaterialOutController extends Controller
{
    public function index()
    {
        $materialOuts = MaterialOut::with('material', 'user')->latest()->paginate(10);
        return view('pages.admin.inventory.material_out.index', compact('materialOuts'));
    }

    public function create()
    {
        $month = $r->month ?? now()->format('m');
        $year = $r->year ?? now()->year;

        $materials = Material::with(['valves', 'sparePart'])->get();

        $dailyOutputs = MaterialOut::selectRaw("material_id, DATE(date_out) as date_out, qty_out")
            ->whereYear('date_out', $year)
            ->whereMonth('date_out', $month)
            ->get()
            ->groupBy('material_id');

        $days = \Carbon\Carbon::create($year, $month)->daysInMonth;

        return view(
            'pages.admin.inventory.material_out.add',
            compact('materials', 'dailyOutputs', 'month', 'year', 'days')
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required|exists:materials,id',
            'qty_out'      => 'required|integer|min:1',
            'date_out'     => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        $material = Material::findOrFail($request->material_id);

        $existing = MaterialOut::where('material_id', $material->id)
            ->whereDate('date_out', $request->date_out)
            ->first();

        DB::transaction(function () use ($existing, $material, $request) {

            if ($existing) {
                $existing->update([
                    'qty_out'   => $request->qty_out,
                    'notes'    => $request->notes ?? '-',
                    'user_id'  => Auth::id(),
                ]);

                $totalQty = MaterialOut::where('material_id', $material->id)->sum('qty_out');
                $material->update(['current_stock' => $totalQty]);
            } else {

                $newStock = $material->current_stock + $request->qty_out;

                $material->update(['current_stock' => $newStock]);

                MaterialOut::create([
                    'material_id' => $material->id,
                    'user_id'     => Auth::id(),
                    'date_out'     => $request->date_out,
                    'qty_out'      => $request->qty_out,
                    'stock_after' => $newStock,
                    'notes'       => $request->notes ?? '-',
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'qty_out'  => $request->qty_out
        ]);
    }


    public function edit(MaterialOut $materialOuts)
    {
        $materials = Material::all();
        return view('pages.admin.inventory.material_out.update', compact('materialOuts', 'materials'));
    }

    public function update(Request $request, MaterialOut $materialOuts)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'date_out' => 'required|date',
            'qty_out' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $materialOuts->update($request->all());

        return redirect()->route('material_out.index')->with('success', 'Data material Keluar berhasil diperbarui.');
    }

    public function destroy(MaterialOut $materialOuts)
    {
        $materialOuts->delete();
        return redirect()->route('material_out.index')->with('success', 'Data material Keluar berhasil dihapus.');
    }
}
