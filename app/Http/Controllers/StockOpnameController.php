<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\MaterialIn;
use App\MaterialOut;
use App\StockOpname;
use Illuminate\Support\Facades\DB;

class StockOpnameController extends Controller
{
    public function index()
    {
        $opnames = StockOpname::with([
            'material.valves',  // relasi many-to-many valve
            'material.sparePart' // relasi ke spare part
        ])->latest()->get();

        return view('pages.admin.inventory.stock_opname.index', compact('opnames'));
    }

    public function create()
    {
        $materials = Material::with('valves', 'sparePart')->get();
        return view('pages.admin.inventory.stock_opname.add', compact('materials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'date_opname' => 'required|date',
            'stock_actual' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $material = Material::find($validated['material_id']);
        $stock_system = $material->current_stock ?? $material->stock_awal;

        $selisih = $validated['stock_actual'] - $stock_system;
        $stockSystem = $material->current_stock ?? 0; // ambil stok sistem dari database

        // Bandingkan stok fisik vs sistem vs minimum
        if ($validated['stock_actual'] < $material->stock_minimum) {
            $warning = '⚠️ Stok di bawah batas minimum';
        } elseif ($validated['stock_actual'] > $stockSystem) {
            $warning = 'Stok fisik lebih banyak dari sistem';
        } elseif ($validated['stock_actual'] < $stockSystem) {
            $warning = 'Stok fisik lebih sedikit dari sistem';
        } else {
            $warning = 'Stok sesuai';
        }
        StockOpname::create([
            'material_id' => $validated['material_id'],
            'date_opname' => $validated['date_opname'],
            'stock_system' => $stock_system,
            'stock_actual' => $validated['stock_actual'],
            'selisih' => $selisih,
            'warning' => $warning,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('stock-opname.index')->with('success', 'Stock opname berhasil disimpan.');
    }

    public function destroy($id)
    {
        $opname = StockOpname::findOrFail($id);
        $opname->delete();

        return back()->with('success', 'Data opname berhasil dihapus.');
    }

    public function adjust($id)
    {
        $opname = StockOpname::with('material')->findOrFail($id);
        $material = $opname->material;

        if (!$material) {
            return redirect()->back()->with('error', 'Data material tidak ditemukan.');
        }

        $selisih = $opname->stock_actual - $material->current_stock;

        // 🔹 Update stok material
        $material->update(['current_stock' => $opname->stock_actual]);

        // 🔹 Simpan ke stok card
        if ($selisih > 0) {
            MaterialIn::create([
                'material_id' => $material->id,
                'user_id' => auth()->id(),
                'date_in' => now(),
                'qty_in' => $selisih,
                'stock_after' => $opname->stock_actual,
                'notes' => 'Penyesuaian stok (Adjustment) dari Stock Opname',
            ]);
        } elseif ($selisih < 0) {
            MaterialOut::create([
                'material_id' => $material->id,
                'user_id' => auth()->id(),
                'date_out' => now(),
                'qty_out' => abs($selisih),
                'stock_after' => $opname->stock_actual,
                'notes' => 'Penyesuaian stok (Adjustment) dari Stock Opname',
            ]);
        }

        // 🔹 Update status opname agar tidak muncul lagi
        $opname->update(['warning' => 'Sudah disesuaikan']);

        return redirect()->back()->with('success', '✅ Stok berhasil disesuaikan melalui Adjustment!');
    }
}
