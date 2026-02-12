<?php

namespace App\Http\Controllers;

use App\Project;
use App\Folder;
use Illuminate\Http\Request;

class FolderDocController extends Controller
{
    /**
     * INDEX
     * List project + folder (accordion)
     */
    public function index()
    {
        $projects = Project::with(['folders' => function ($q) {
            $q->orderBy('folder_name');
        }])->orderBy('project_name')->get();

        return view('pages.admin.dokumen.folder.index', compact('projects'));
    }

    /**
     * FORM TAMBAH FOLDER (per project)
     */
    public function create(Project $project)
    {
        // dd($project);
        return view('pages.admin.dokumen.folder.add', compact('project'));
    }

    /**
     * SIMPAN FOLDER
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'folder_name' => 'required|string|max:100',
            'folder_code' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        Folder::create([
            'document_project_id' => $project->id,
            'folder_name'          => $request->folder_name,
            'folder_code'          => $request->folder_code,
            'description'          => $request->description,
        ]);

        return redirect()
            ->route('folders.create')
            ->with('success', 'Folder berhasil ditambahkan');
    }

    /**
     * FORM EDIT FOLDER
     */
    public function edit(Project $project, Folder $folder)
    {
        return view('pages.admin.dokumen.folder.edit', compact('project', 'folder'));
    }

    /**
     * UPDATE FOLDER
     */
    public function update(Request $request, Project $project, Folder $folder)
    {
        $request->validate([
            'folder_name' => 'required|string|max:100',
            'folder_code' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $folder->update($request->only(
            'folder_name',
            'folder_code',
            'description'
        ));

        return redirect()
            ->route('folders.create')
            ->with('success', 'Folder berhasil diperbarui');
    }

    /**
     * HAPUS FOLDER
     */
    public function destroy(Project $project, Folder $folder)
    {
        if ($folder->documents()->exists()) {
            return back()->with('error', 'Folder masih memiliki dokumen');
        }

        $folder->delete();

        return redirect()
            ->route('folders.create')
            ->with('success', 'Folder berhasil dihapus');
    }
}
