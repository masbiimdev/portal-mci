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
        return view('projects.create');
    }

    // Simpan project baru
    public function store(Request $request)
    {
        $request->validate([
            'project_code' => 'required|unique:document_projects,project_code',
            'project_number' => 'required|string',
            'project_name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:PENDING,ONGOING,COMPLETED',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project = Project::create($request->all());

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dibuat');
    }

    // Tampilkan detail project
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', compact('project'));
    }

    // Form edit project
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    // Update project
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'project_code' => 'sometimes|required|unique:document_projects,project_code,' . $id,
            'project_number' => 'sometimes|required|string',
            'project_name' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:PENDING,ONGOING,COMPLETED',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')
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
