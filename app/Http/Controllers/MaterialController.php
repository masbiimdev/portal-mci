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
            'valve_id' => 'required|array',
            'valve_id.*' => 'exists:valves,id',
            'spare_part_id' => 'nullable|exists:spare_parts,id',
            'no_drawing' => 'nullable|string',
            'heat_lot_no' => 'nullable|string',
            'dimensi' => 'nullable|string',
            'stock_awal' => 'required|integer|min:0', // stok awal hanya di sini
            'stock_minimum' => 'required|integer|min:0',
            'rack_id' => 'nullable|exists:racks,id',
        ]);

        // Generate kode material unik
        $lastCode = Material::orderBy('id', 'DESC')->value('material_code');
        $number = $lastCode ? (int) str_replace('MTR-', '', $lastCode) + 1 : 1;

        do {
            $newCode = 'MTR-' . str_pad($number, 3, '0', STR_PAD_LEFT);
            $exists = Material::where('material_code', $newCode)->exists();
            if ($exists) $number++;
        } while ($exists);

        // Simpan material baru
        $material = Material::create([
            'material_code' => $newCode,
            'spare_part_id' => $validated['spare_part_id'] ?? null,
            'no_drawing' => $validated['no_drawing'] ?? null,
            'heat_lot_no' => $validated['heat_lot_no'] ?? null,
            'dimensi' => $validated['dimensi'] ?? null,
            'stock_awal' => $validated['stock_awal'], // tetap disini
            'stock_minimum' => $validated['stock_minimum'],
            'rack_id' => $validated['rack_id'] ?? null,
        ]);

        // Simpan relasi valve
        $material->valves()->sync($validated['valve_id']);

        return redirect()->route('materials.index')->with('success', 'Material berhasil ditambahkan!');
    }

    public function edit(Material $material)
    {
        $valves = Valve::all();
        $spareParts = SparePart::all();
        $racks = Rack::all();

        $selectedValves = $material->valves()->pluck('valves.id')->toArray();

        return view('pages.admin.inventory.material.update', compact('material', 'valves', 'spareParts', 'racks', 'selectedValves'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'valve_id' => 'required|array',
            'valve_id.*' => 'exists:valves,id',
            'spare_part_id' => 'nullable|exists:spare_parts,id',
            'no_drawing' => 'nullable|string',
            'heat_lot_no' => 'nullable|string',
            'dimensi' => 'nullable|string',
            'stock_minimum' => 'required|integer|min:0',
            'rack_id' => 'nullable|exists:racks,id',
        ]);

        // Update material tanpa merubah stock_awal
        $material->update([
            'spare_part_id' => $validated['spare_part_id'] ?? null,
            'no_drawing' => $validated['no_drawing'] ?? null,
            'heat_lot_no' => $validated['heat_lot_no'] ?? null,
            'dimensi' => $validated['dimensi'] ?? null,
            'stock_minimum' => $validated['stock_minimum'],
            'rack_id' => $validated['rack_id'] ?? null,
        ]);

        $material->valves()->sync($validated['valve_id']);

        return redirect()->route('materials.index')
            ->with('success', 'Material berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material berhasil dihapus.');
    }
}
