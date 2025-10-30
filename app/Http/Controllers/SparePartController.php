<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SparePart;

class SparePartController extends Controller
{
    public function index()
    {
        $spareParts = SparePart::latest()->paginate(10);
        return view('pages.admin.inventory.spare.index', compact('spareParts'));
    }

    public function create()
    {
        return view('pages.admin.inventory.spare.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'spare_part_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Ambil ID terakhir untuk penomoran otomatis
        $lastId = SparePart::max('id') ?? 0;
        $newCode = 'SP-' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        $validated['spare_part_code'] = $newCode;

        SparePart::create($validated);

        return redirect()->route('spare-parts.index')
            ->with('success', 'Spare Part berhasil ditambahkan!');
    }

    public function edit(SparePart $sparePart)
    {
        return view('pages.admin.inventory.spare.update', compact('sparePart'));
    }

    public function update(Request $request, SparePart $sparePart)
    {
        $validated = $request->validate([
            'spare_part_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $sparePart->update($validated);

        return redirect()->route('spare-parts.index')
            ->with('success', 'Spare Part berhasil diperbarui!');
    }

    public function destroy(SparePart $sparePart)
    {
        $sparePart->delete();

        return redirect()->route('spare-parts.index')->with('success', 'Spare Part berhasil dihapus!');
    }
}
