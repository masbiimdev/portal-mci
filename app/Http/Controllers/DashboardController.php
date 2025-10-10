<?php

namespace App\Http\Controllers;

use App\Jobcard;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Jumlah User
        // Total user
        $totalUsers = User::count();

        // Jumlah user per departemen
        $engineeringCount = User::where('departemen', 'QC')->count();
        $productionCount  = User::where('departemen', 'ASSEMBLING')->count();
        $qaCount          = User::where('departemen', 'MACHINING')->count();
        $adminCount       = User::where('departemen', 'PACKING')->count();
        // Jumlah Jobcard
        $totalMachining = Jobcard::where('type_jobcard', 'Jobcard Machining')->count();
        $totalAssembling = Jobcard::where('type_jobcard', 'Jobcard Assembling')->count();

        // Ambil data bulanan yang ada
        $monthlyDataDb = DB::table('jobcards')
            ->selectRaw('
            MONTH(created_at) as month_num,
            SUM(CASE WHEN type_jobcard = "Jobcard Machining" THEN 1 ELSE 0 END) as machining,
            SUM(CASE WHEN type_jobcard = "Jobcard Assembling" THEN 1 ELSE 0 END) as assembling
        ')
            ->whereYear('created_at', now()->year)
            ->groupBy('month_num')
            ->orderBy('month_num')
            ->get()
            ->keyBy('month_num'); // supaya mudah dicari per bulan

        // Buat array 12 bulan
        $monthlyData = collect(range(1, 12))->map(function ($m) use ($monthlyDataDb) {
            return [
                'month_num' => $m,
                'month_name' => \Carbon\Carbon::create()->month($m)->format('F'),
                'machining' => $monthlyDataDb[$m]->machining ?? 0,
                'assembling' => $monthlyDataDb[$m]->assembling ?? 0,
            ];
        });

        return view('pages.admin.dashboard', compact(
            'totalMachining',
            'totalAssembling',
            'monthlyData',
            'totalUsers',
            'engineeringCount',
            'productionCount',
            'qaCount',
            'adminCount'
        ));
    }

    public function jadwal_witness()
    {
        return view('pages.admin.jadwal.witness.index');
    }
}
