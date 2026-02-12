<?php

namespace App\Http\Controllers;

use App\Project;

use Illuminate\Http\Request;

class ProjectDocController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->get();
        return view('pages.admin.dokumen.project.index', compact('projects'));
    }

    // Form buat project baru
    public function create()
    {
        return view('pages.admin.dokumen.project.add');
    }

    // Simpan project baru
    public function store(Request $request)
    {
        $request->validate([
            'project_number' => 'required',
            'project_name'   => 'required',
            'status'         => 'required',
        ]);

        $year = now()->year;

        $lastProject = Project::whereYear('created_at', $year)
            ->orderBy('project_code', 'desc')
            ->first();

        $lastNumber = $lastProject
            ? (int) substr($lastProject->project_code, -3)
            : 0;

        $nextNumber = $lastNumber + 1; // PASTI mulai dari 1

        $projectCode = sprintf('PRJ-%s-%03d', $year, $nextNumber);

        Project::create([
            'project_code'   => $projectCode,
            'project_number' => $request->project_number,
            'project_name'   => $request->project_name,
            'description'    => $request->description,
            'status'         => $request->status,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
        ]);

        return redirect()
            ->route('document.project.index')
            ->with('success', 'Project berhasil ditambahkan');
    }

    // Tampilkan detail project
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('pages.admin.dokumen.project.show', compact('project'));
    }

    // Form edit project
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('pages.admin.dokumen.project.update', compact('project'));
    }

    // Update project
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'project_number' => 'required|string',
            'project_name'   => 'required|string',
            'description'    => 'nullable|string',
            'status'         => 'required|in:PENDING,ACTIVE,ARCHIVED',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
        ]);

        $project->update([
            'project_number' => $request->project_number,
            'project_name'   => $request->project_name,
            'description'    => $request->description,
            'status'         => $request->status,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
        ]);

        return redirect()
            ->route('document.project.index')
            ->with('success', 'Project berhasil diperbarui');
    }


    // Hapus project
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dihapus');
    }
}
