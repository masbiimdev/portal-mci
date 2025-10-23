<?php

namespace App\Http\Controllers;

use App\Activity;
use Carbon\Carbon;
use App\Annon;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $announcements = Annon::where('is_active', true)
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('created_at', 'desc')
            ->take(3) // tampilkan 3 pengumuman terbaru
            ->get();

        return view('pages.home', compact('announcements'));
    }
    public function jadwal()
    {
        // Ambil semua activities
        $activities = Activity::all();

        // Hitung ringkasan untuk sidebar
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $todayCount = Activity::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->count();

        $weekCount = Activity::whereBetween('start_date', [$weekStart, $weekEnd])
            ->orWhereBetween('end_date', [$weekStart, $weekEnd])
            ->count();

        $weekActivities = Activity::whereBetween('start_date', [$weekStart, $weekEnd])
            ->orWhereBetween('end_date', [$weekStart, $weekEnd])
            ->get();

        return view('pages.jadwal', compact(
            'activities',
            'todayCount',
            'weekCount',
            'weekActivities'
        ));
    }
}
