<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rack;

class RackController extends Controller
{
    public function index()
    {
        $racks = Rack::latest()->paginate(10);
        return view('pages.admin.inventory.rack.index', compact('racks'));
    }

    public function create()
    {
        return view('pages.admin.inventory.rack.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rack_code' => 'required|unique:racks,rack_code|max:50',
            'rack_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Rack::create($validated);

        return redirect()->route('racks.index')->with('success', 'Rack berhasil ditambahkan!');
    }

    public function edit(Rack $rack)
    {
        return view('pages.admin.inventory.rack.update', compact('rack'));
    }

    public function update(Request $request, Rack $rack)
    {
        $validated = $request->validate([
            'rack_code' => 'required|max:50|unique:racks,rack_code,' . $rack->id,
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
