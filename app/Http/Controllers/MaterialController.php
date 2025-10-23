<?php

namespace App\Http\Controllers;

use App\Material;
use App\Valve;
use App\SparePart;
use App\Rack;

use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with(['valves', 'sparePart', 'rack'])->get();
        return view('pages.admin.inventory.material.index', compact('materials'));
    }

    public function create()
    {
        $valves = Valve::all();
        $spareParts = SparePart::all();
        $racks = Rack::all();
        return view('pages.admin.inventory.material.add', compact('valves', 'spareParts', 'racks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_code' => 'required|unique:materials',
            'valve_id' => 'required|array', // karena multiple
            'valve_id.*' => 'exists:valves,id',
            'spare_part_id' => 'nullable|exists:spare_parts,id',
            'no_drawing' => 'nullable|string',
            'heat_lot_no' => 'nullable|string',
            'dimensi' => 'nullable|string',
            'stock_awal' => 'required|integer|min:0',
            'stock_minimum' => 'required|integer|min:0',
            'rack_id' => 'nullable|exists:racks,id',
        ]);

        // 1️⃣ Simpan data utama ke tabel materials
        $material = Material::create([
            'material_code' => $validated['material_code'],
            'spare_part_id' => $validated['spare_part_id'] ?? null,
            'no_drawing' => $validated['no_drawing'] ?? null,
            'heat_lot_no' => $validated['heat_lot_no'] ?? null,
            'dimensi' => $validated['dimensi'] ?? null,
            'stock_awal' => $validated['stock_awal'] ?? 0,
            'stock_minimum' => $validated['stock_minimum'] ?? 0,
            'rack_id' => $validated['rack_id'] ?? null,
        ]);

        // simpan relasi valve
        $material->valves()->sync($validated['valve_id']);
        return redirect()->route('materials.index')->with('success', 'Material berhasil ditambahkan.');
    }

    public function edit(Material $material)
    {
        $valves = Valve::all();
        $spareParts = SparePart::all();
        $racks = Rack::all();
        return view('pages.admin.inventory.material.update', compact('material', 'valves', 'spareParts', 'racks'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'material_code' => 'required|unique:materials,material_code,' . $material->id,
            'valve_id' => 'required|array',
            'valve_id.*' => 'exists:valves,id',
            'spare_part_id' => 'nullable|exists:spare_parts,id',
            'no_drawing' => 'nullable|string',
            'heat_lot_no' => 'nullable|string',
            'dimensi' => 'nullable|string',
            'stock_awal' => 'required|integer|min:0',
            'stock_minimum' => 'required|integer|min:0',
            'rack_id' => 'nullable|exists:racks,id',
        ]);
        $material->update([
            'material_code' => $validated['material_code'],
            'spare_part_id' => $validated['spare_part_id'] ?? null,
            'no_drawing' => $validated['no_drawing'] ?? null,
            'heat_lot_no' => $validated['heat_lot_no'] ?? null,
            'dimensi' => $validated['dimensi'] ?? null,
            'stock_awal' => $validated['stock_awal'] ?? 0,
            'stock_minimum' => $validated['stock_minimum'] ?? 0,
            'rack_id' => $validated['rack_id'] ?? null,
        ]);

        // update relasi valve
        $material->valves()->sync($validated['valve_id']);
        return redirect()->route('materials.index')->with('success', 'Material berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material berhasil dihapus.');
    }
}
