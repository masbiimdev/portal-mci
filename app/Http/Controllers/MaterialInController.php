<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialIn;
use App\Material;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MaterialInController extends Controller
{
    public function index()
    {
        $materialIns = MaterialIn::with('material', 'user')->latest()->paginate(10);
        return view('pages.admin.inventory.material_in.index', compact('materialIns'));
    }

    public function create(Request $r)
    {
        $month = $r->month ?? now()->format('m');
        $year = $r->year ?? now()->year;

        $materials = Material::with(['valves', 'sparePart'])->get();

        $dailyInputs = MaterialIn::selectRaw("material_id, DATE(date_in) as date_in, qty_in")
            ->whereYear('date_in', $year)
            ->whereMonth('date_in', $month)
            ->get()
            ->groupBy('material_id');

        $days = \Carbon\Carbon::create($year, $month)->daysInMonth;

        return view(
            'pages.admin.inventory.material_in.add',
            compact('materials', 'dailyInputs', 'month', 'year', 'days')
        );
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required|exists:materials,id',
            'qty_in'      => 'required|integer|min:1',
            'date_in'     => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        $material = Material::findOrFail($request->material_id);

        $existing = MaterialIn::where('material_id', $material->id)
            ->whereDate('date_in', $request->date_in)
            ->first();

        DB::transaction(function () use ($existing, $material, $request) {

            if ($existing) {
                $existing->update([
                    'qty_in'   => $request->qty_in,
                    'notes'    => $request->notes ?? '-',
                    'user_id'  => Auth::id(),
                ]);

                $totalQty = MaterialIn::where('material_id', $material->id)->sum('qty_in');
                $material->update(['current_stock' => $totalQty]);
            } else {

                $newStock = $material->current_stock + $request->qty_in;

                $material->update(['current_stock' => $newStock]);

                MaterialIn::create([
                    'material_id' => $material->id,
                    'user_id'     => Auth::id(),
                    'date_in'     => $request->date_in,
                    'qty_in'      => $request->qty_in,
                    'stock_after' => $newStock,
                    'notes'       => $request->notes ?? '-',
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'qty_in'  => $request->qty_in
        ]);
    }


    public function edit(MaterialIn $materialIn)
    {
        $materials = Material::all();
        return view('pages.admin.inventory.material_in.update', compact('materialIn', 'materials'));
    }

    public function update(Request $request, MaterialIn $materialIn)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'date_in' => 'required|date',
            'qty_in' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $materialIn->update($request->all());

        return redirect()->route('material_in.index')->with('success', 'Data material masuk berhasil diperbarui.');
    }

    public function destroy(MaterialIn $materialIn)
    {
        $materialIn->delete();
        return redirect()->route('material_in.index')->with('success', 'Data material masuk berhasil dihapus.');
    }
}
