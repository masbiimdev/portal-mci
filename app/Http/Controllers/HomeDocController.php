<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeDocController extends Controller
{
        public function index()
    {
        
        return view('pages.document.project');
    }
}
