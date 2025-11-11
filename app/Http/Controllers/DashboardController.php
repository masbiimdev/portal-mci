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

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSchedules = Activity::count();
        $totalJobcard = Jobcard::count();
        $totalMaterial = Material::count();
        $totalAnnon = Annon::count();


        return view('pages.admin.dashboard', compact(
            'totalUsers',
            'totalSchedules',
            'totalJobcard',
            'totalMaterial',
            'totalAnnon',
        ));
    }

    public function jadwal_witness()
    {
        return view('pages.admin.jadwal.witness.index');
    }
}
