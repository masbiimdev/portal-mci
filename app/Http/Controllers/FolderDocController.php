<?php

namespace App\Http\Controllers;

use App\Project;
use App\Folder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Pastikan untuk import class Rule

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
        return view('pages.admin.dokumen.folder.add', compact('project'));
    }

    /**
     * SIMPAN FOLDER
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'folder_name' => 'required|string|max:100',
            'folder_code' => [
                'required', 
                'string', 
                'max:50',
                // Mencegah kode folder ganda di dalam project yang sama (menggunakan tabel document_folders)
                Rule::unique('document_folders')->where(function ($query) use ($project) {
                    return $query->where('document_project_id', $project->id);
                })
            ],
            'description' => 'nullable|string',
        ]);

        Folder::create([
            'document_project_id' => $project->id,
            'folder_name'         => $request->folder_name,
            'folder_code'         => $request->folder_code,
            'description'         => $request->description,
        ]);

        // Ubah redirect ke halaman index (Daftar Folder)
        return redirect()->route('folders.index')
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
            'folder_code' => [
                'required', 
                'string', 
                'max:50',
                // Mencegah kode ganda, namun abaikan folder yang sedang diedit ini
                Rule::unique('document_folders')->where(function ($query) use ($project) {
                    return $query->where('document_project_id', $project->id);
                })->ignore($folder->id)
            ],
            'description' => 'nullable|string',
        ]);

        $folder->update($request->only(
            'folder_name',
            'folder_code',
            'description'
        ));

        // BUG FIXED: Sebelumnya redirect ke 'folders.create' tanpa parameter.
        // Seharusnya dikembalikan ke halaman index.
        return redirect()
            ->route('folders.index')
            ->with('success', 'Folder berhasil diperbarui');
    }

    /**
     * HAPUS FOLDER
     */
    public function destroy(Project $project, Folder $folder)
    {
        if ($folder->documents()->exists()) {
            return back()->with('error', 'Folder masih memiliki dokumen, tidak dapat dihapus!');
        }

        $folder->delete();

        // BUG FIXED: Gunakan back() agar tetap berada di halaman index/accordion.
        // Jika pakai route('folders.create') akan menyebabkan error parameter.
        return back()->with('success', 'Folder berhasil dihapus');
    }
} 