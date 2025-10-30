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
        // dd($materials);
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

        // ✅ Generate Kode Material Unik (MTR-001, MTR-002, dst)
        $lastCode = Material::orderBy('id', 'DESC')->value('material_code');
        $number = $lastCode ? (int) str_replace('MTR-', '', $lastCode) + 1 : 1;

        // ✅ Loop untuk memastikan kode unik (jika sudah ada, lanjut nomor berikutnya)
        do {
            $newCode = 'MTR-' . str_pad($number, 3, '0', STR_PAD_LEFT);
            $exists = Material::where('material_code', $newCode)->exists();
            if ($exists) {
                $number++;
            }
        } while ($exists);



        // ✅ Simpan data
        $material = Material::create([
            'material_code' => $newCode,
            'spare_part_id' => $validated['spare_part_id'] ?? null,
            'no_drawing' => $validated['no_drawing'] ?? null,
            'heat_lot_no' => $validated['heat_lot_no'] ?? null,
            'dimensi' => $validated['dimensi'] ?? null,
            'stock_awal' => $validated['stock_awal'] ?? 0,
            'stock_minimum' => $validated['stock_minimum'] ?? 0,
            'rack_id' => $validated['rack_id'] ?? null,
        ]);

        // ✅ Simpan relasi Valve
        $material->valves()->sync($validated['valve_id']);

        return redirect()->route('materials.index')->with('success', 'Material berhasil ditambahkan!');
    }

    public function edit(Material $material)
    {
        $valves = Valve::all();
        $spareParts = SparePart::all();
        $racks = Rack::all();

        // ubah JSON ke array biar bisa dipakai di Blade
        // Ambil semua valve_id yang terhubung di tabel pivot
        $selectedValves = $material->valves()->pluck('valves.id')->toArray();

        // dd($selectedValves);

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
            'stock_awal' => 'required|integer|min:0',
            'stock_minimum' => 'required|integer|min:0',
            'rack_id' => 'nullable|exists:racks,id',
        ]);

        // ✅ Update tanpa mengubah material_code
        $material->update([
            'spare_part_id' => $validated['spare_part_id'] ?? null,
            'no_drawing' => $validated['no_drawing'] ?? null,
            'heat_lot_no' => $validated['heat_lot_no'] ?? null,
            'dimensi' => $validated['dimensi'] ?? null,
            'stock_awal' => $validated['stock_awal'],
            'stock_minimum' => $validated['stock_minimum'],
            'rack_id' => $validated['rack_id'] ?? null,
        ]);

        // ✅ Update relasi Valve
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
