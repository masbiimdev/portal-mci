<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard');
    }
    public function jadwal_witness(){
        return view('pages.admin.jadwal.witness.index');
    }
}
