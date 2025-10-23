<?php

namespace App\Http\Controllers;

use App\Material;
use App\MaterialIn;
use App\MaterialOut;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        // Total statistik
        $totalMaterials = Material::count();
        $totalStock = Material::all()->sum('current_stock');
        $totalIn = MaterialIn::sum('qty_in');
        $totalOut = MaterialOut::sum('qty_out');

        // Barang dengan stok di bawah minimum
        $materials = Material::with(['incomings', 'outgoings'])->get();

        $lowStock = $materials->filter(function ($material) {
            return $material->current_stock < $material->stock_minimum;
        })
            ->sortBy('current_stock')
            ->take(5)
            ->values();

        // Data untuk grafik per bulan (barang masuk dan keluar)
        $chartData = DB::table('material_in')
            ->selectRaw('MONTH(date_in) as month, SUM(qty_in) as total_in')
            ->groupBy('month')
            ->pluck('total_in', 'month')
            ->toArray();

        $chartDataOut = DB::table('material_out')
            ->selectRaw('MONTH(date_out) as month, SUM(qty_out) as total_out')
            ->groupBy('month')
            ->pluck('total_out', 'month')
            ->toArray();

        // Gabungkan data bulan 1–12
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = [
                'month' => date('M', mktime(0, 0, 0, $i, 1)),
                'in' => $chartData[$i] ?? 0,
                'out' => $chartDataOut[$i] ?? 0,
            ];
        }

        // 4️⃣ History transaksi terakhir
        // Barang masuk
        $in = MaterialIn::with(['material', 'user'])
            ->select('id', 'material_id', 'qty_in as qty', 'notes', 'created_at as tanggal', 'stock_after')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'in';
                $item->date_in = $item->tanggal;
                $item->stock_awal = $item->material->stock_awal ?? 0;
                $item->current_stock = $item->material->current_stock ?? 0;
                return $item;
            });

        // Barang keluar
        $out = MaterialOut::with(['material', 'user'])
            ->select('id', 'material_id', 'qty_out as qty', 'notes', 'created_at as tanggal', 'stock_after')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'out';
                $item->date_in = $item->tanggal;
                $item->stock_awal = $item->material->stock_awal ?? 0;
                $item->current_stock = $item->material->current_stock ?? 0;
                return $item;
            });

        $history = $in->concat($out)->sortByDesc('tanggal')->take(10);

        return view('pages.admin.inventory.dashboard', compact(
            'totalMaterials',
            'totalStock',
            'totalIn',
            'totalOut',
            'lowStock',
            'monthlyData',
            'history',
        ));
    }
}
