<?php

namespace App\Http\Controllers;
use App\Project;
use App\Document;
use App\Folder;

use Illuminate\Http\Request;

class DashboardDocController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->get();
        $documents = Document::orderBy('created_at', 'desc')->get();
        $folders = Folder::orderBy('created_at', 'desc')->get();
        return view('pages.admin.dokumen.dashboard', compact('projects', 'documents', 'folders'));
    }
}
