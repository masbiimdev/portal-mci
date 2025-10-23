<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\MaterialOut;
use Illuminate\Support\Facades\Auth;

class MaterialOutController extends Controller
{
    public function index()
    {
        $materialOuts = MaterialOut::with('material','user')->latest()->paginate(10);
        return view('pages.admin.inventory.material_out.index', compact('materialOuts'));
    }

    public function create()
    {
        $materials = Material::all();
        return view('pages.admin.inventory.material_out.add', compact('materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'qty_out' => 'required|integer|min:1',
            'date_out' => 'required|date',
        ]);

        $material = Material::findOrFail($request->material_id);

        // Pastikan stok cukup
        if ($request->qty_out > $material->current_stock) {
            return back()->with('error', 'Stok tidak mencukupi untuk pengeluaran ini.');
        }

        // Update stok
        $newStock = $material->current_stock - $request->qty_out;
        $material->update(['current_stock' => $newStock]);

        // Simpan transaksi keluar
        MaterialOut::create([
            'material_id' => $request->material_id,
            'user_id' => Auth::id(),
            'date_out' => $request->date_out,
            'qty_out' => $request->qty_out,
            'stock_after' => $newStock,
            'notes' => $request->notes,
        ]);

        return redirect()->route('material_out.index')->with('success', 'Data material keluar berhasil disimpan!');
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
