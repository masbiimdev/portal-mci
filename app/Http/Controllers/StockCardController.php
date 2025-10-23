<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\MaterialIn;
use App\MaterialOut;
use Illuminate\Support\Collection;

class StockCardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua material
        $materials = Material::orderBy('material_code')->get();

        // Jika user memilih material tertentu
        $selectedMaterial = $request->get('material_id');
        $stockCard = collect();

        if ($selectedMaterial) {
            $material = Material::findOrFail($selectedMaterial);

            // Ambil transaksi masuk
            $in = MaterialIn::where('material_id', $material->id)
                ->select('date_in as tanggal', 'qty_in as qty', 'stock_after', 'notes')
                ->get()
                ->map(function ($item) {
                    $item->jenis = 'IN';
                    return $item;
                });

            // Ambil transaksi keluar
            $out = MaterialOut::where('material_id', $material->id)
                ->select('date_out as tanggal', 'qty_out as qty', 'stock_after', 'notes')
                ->get()
                ->map(function ($item) {
                    $item->jenis = 'OUT';
                    return $item;
                });

            // Gabungkan dua transaksi dan urutkan berdasarkan tanggal
            $stockCard = $in->concat($out)->sortBy('tanggal')->values();

            // Tambahkan stok awal di posisi pertama
            $stockCard->prepend((object)[
                'tanggal' => null,
                'jenis' => 'AWAL',
                'qty' => 0,
                'stock_after' => $material->stock_awal,
                'notes' => 'Stok Awal',
            ]);
        }

        return view('pages.admin.inventory.stock_card.index', compact('materials', 'stockCard', 'selectedMaterial'));
    }
}
