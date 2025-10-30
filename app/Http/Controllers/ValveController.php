<?php

namespace App\Http\Controllers;

use App\Valve;
use Illuminate\Http\Request;

class ValveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $valves = Valve::all();
        return view('pages.admin.inventory.valve.index', compact('valves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.inventory.valve.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'valve_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // ✅ Ambil kode terakhir
        $lastCode = Valve::orderBy('id', 'DESC')->value('valve_code');

        // ✅ Generate code baru
        if ($lastCode) {
            $number = (int) str_replace('VLV-', '', $lastCode) + 1;
        } else {
            $number = 1;
        }

        $newCode = 'VLV-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        Valve::create([
            'valve_code' => $newCode,
            'valve_name' => $request->valve_name,
            'description' => $request->description,
        ]);

        return redirect()->route('valves.index')->with('success', 'Valve berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Valve $valve)
    {
        return view('pages.admin.inventory.valve.update', compact('valve'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Valve $valve)
    {
        $request->validate([
            'valve_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $valve->update([
            'valve_name' => $request->valve_name,
            'description' => $request->description,
        ]);

        return redirect()->route('valves.index')->with('success', 'Valve berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Valve $valve)
    {
        $valve->delete();
        return redirect()->route('valves.index')->with('success', 'Valve berhasil dihapus.');
    }
}
