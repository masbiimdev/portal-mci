<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialIn;
use App\Material;
use Illuminate\Support\Facades\Auth;

class MaterialInController extends Controller
{
    public function index()
    {
        $materialIns = MaterialIn::with('material','user')->latest()->paginate(10);
        return view('pages.admin.inventory.material_in.index', compact('materialIns'));
    }

    public function create()
    {
        $materials = Material::all();
        return view('pages.admin.inventory.material_in.add', compact('materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'qty_in' => 'required|integer|min:1',
            'date_in' => 'required|date',
        ]);

        $material = Material::findOrFail($request->material_id);

        // Update stok
        $newStock = $material->current_stock + $request->qty_in;
        $material->update(['current_stock' => $newStock]);

        // Simpan ke tabel material_in
        MaterialIn::create([
            'material_id' => $request->material_id,
            'user_id' => Auth::id(),
            'date_in' => $request->date_in,
            'qty_in' => $request->qty_in,
            'stock_after' => $newStock,
            'notes' => $request->notes,
        ]);

        return redirect()->route('material_in.index')->with('success', 'Data material masuk berhasil disimpan!');
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
