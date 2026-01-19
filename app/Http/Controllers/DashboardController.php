<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Annon;
use App\Jobcard;
use App\User;
use App\Material;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Show main dashboard.
     *
     * Prepares:
     * - counts used by the dashboard cards
     * - recent transaction history (merged material_ins + material_outs if available)
     * - weekly chart data (last 7 days) for Masuk/Keluar
     * - small spark example arrays (for sparklines)
     */
    public function index()
    {
        // Basic counts
        $totalUsers = User::count();
        $totalSchedules = Activity::count();
        $totalJobcard = Jobcard::count();
        $totalMaterial = Material::count();
        $totalAnnon = Annon::count();

        // Prepare a safe, unified "history" collection from material_ins and material_outs tables
        $history = collect();

        // Defensive: only attempt if both tables exist. If not, history remains empty.
        if (Schema::hasTable('material_ins') || Schema::hasTable('material_outs')) {
            $items = collect();

            if (Schema::hasTable('material_ins')) {
                $ins = DB::table('material_ins')
                    ->select('id', 'material_id', 'qty', 'created_at as date_in', DB::raw("'in' as jenis"), DB::raw('COALESCE(stock_after, 0) as stock_after'))
                    ->orderBy('created_at', 'desc')
                    ->limit(100)
                    ->get()
                    ->map(function ($r) {
                        return (object) [
                            'id' => $r->id,
                            'material_id' => $r->material_id,
                            'qty' => (int) $r->qty,
                            'date_in' => $r->date_in ? Carbon::parse($r->date_in) : null,
                            'jenis' => 'in',
                            'stock_after' => isset($r->stock_after) ? (int) $r->stock_after : null,
                        ];
                    });

                $items = $items->merge($ins);
            }

            if (Schema::hasTable('material_outs')) {
                $outs = DB::table('material_outs')
                    ->select('id', 'material_id', 'qty', 'created_at as date_in', DB::raw("'out' as jenis"), DB::raw('COALESCE(stock_after, 0) as stock_after'))
                    ->orderBy('created_at', 'desc')
                    ->limit(100)
                    ->get()
                    ->map(function ($r) {
                        return (object) [
                            'id' => $r->id,
                            'material_id' => $r->material_id,
                            'qty' => (int) $r->qty,
                            'date_in' => $r->date_in ? Carbon::parse($r->date_in) : null,
                            'jenis' => 'out',
                            'stock_after' => isset($r->stock_after) ? (int) $r->stock_after : null,
                        ];
                    });

                $items = $items->merge($outs);
            }

            // Attach material model where possible (avoid N+1 with bulk fetch)
            $materialIds = $items->pluck('material_id')->unique()->filter()->values()->all();
            $materialsMap = Material::whereIn('id', $materialIds)->get()->keyBy('id');

            $history = $items->map(function ($it) use ($materialsMap) {
                $it->material = $materialsMap->get($it->material_id) ?? null;
                return $it;
            })
            ->sortByDesc(function ($it) {
                return $it->date_in ? $it->date_in->timestamp : 0;
            })
            ->values()
            ->take(50); // keep recent 50
        }

        // Weekly chart: last 7 days (including today)
        $today = Carbon::today();
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $d = $today->copy()->subDays($i);
            $days->push($d);
        }

        $chartLabels = $days->map(function (Carbon $d) {
            // short day names, can be adjusted to translatedFormat if needed
            return $d->translatedFormat('D'); // e.g. Sen, Sel, ...
        })->all();

        $chartMasuk = [];
        $chartKeluar = [];

        // If tables exist, aggregate per day; otherwise fill zeros
        foreach ($days as $d) {
            $start = $d->copy()->startOfDay();
            $end = $d->copy()->endOfDay();

            $inSum = 0;
            $outSum = 0;

            if (Schema::hasTable('material_ins')) {
                $inSum = (int) DB::table('material_ins')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('qty');
            }

            if (Schema::hasTable('material_outs')) {
                $outSum = (int) DB::table('material_outs')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('qty');
            }

            $chartMasuk[] = $inSum;
            $chartKeluar[] = $outSum;
        }

        // Example spark arrays (small series) — derive from chart data to keep consistent feel
        $sparkA = array_slice($chartMasuk, -7);
        $sparkB = array_slice($chartKeluar, -7);

        // Ensure arrays are not empty for the view
        if (empty($sparkA)) $sparkA = [0,0,0,0,0,0,0];
        if (empty($sparkB)) $sparkB = [0,0,0,0,0,0,0];

        return view('pages.admin.dashboard', compact(
            'totalUsers',
            'totalSchedules',
            'totalJobcard',
            'totalMaterial',
            'totalAnnon',
            'history',
            'chartLabels',
            'chartMasuk',
            'chartKeluar',
            'sparkA',
            'sparkB'
        ));
    }

    public function jadwal_witness()
    {
        return view('pages.admin.jadwal.witness.index');
    }
}