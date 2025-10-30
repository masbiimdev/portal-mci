<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rack;

class RackController extends Controller
{
    public function index()
    {
        $racks = Rack::all();
        return view('pages.admin.inventory.rack.index', compact('racks'));
    }

    public function create()
    {
        return view('pages.admin.inventory.rack.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rack_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        // ✅ Ambil kode terakhir dari tabel racks
        $lastCode = Rack::orderBy('id', 'DESC')->value('rack_code');

        // ✅ Generate kode baru
        if ($lastCode) {
            $number = (int) str_replace('RACK-', '', $lastCode) + 1;
        } else {
            $number = 1;
        }

        $newCode = 'RACK-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        Rack::create([
            'rack_code' => $newCode,
            'rack_name' => $request->rack_name,
            'description' => $request->description,
        ]);

        return redirect()->route('racks.create')->with('success', 'Rack berhasil ditambahkan!');
    }
    public function edit(Rack $rack)
    {
        return view('pages.admin.inventory.rack.update', compact('rack'));
    }

    public function update(Request $request, Rack $rack)
    {
        $validated = $request->validate([
            'rack_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $rack->update($validated);

        return redirect()->route('racks.index')->with('success', 'Rack berhasil diperbarui!');
    }

    public function destroy(Rack $rack)
    {
        $rack->delete();

        return redirect()->route('racks.index')->with('success', 'Rack berhasil dihapus!');
    }
}
