<?php

namespace App\Http\Controllers;

use App\Document;
use App\DocumentHistory;
use App\Project;
use App\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * List dokumen per project
     */
    public function index($projectId)
    {
        $project = Project::findOrFail($projectId);

        $documents = Document::with('folder')
            ->where('project_id', $projectId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.admin.dokumen.document.index', compact('project', 'documents'));
    }

    /**
     * Form upload dokumen
     */
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);
        $folders = Folder::orderBy('folder_name')->get();

        return view('pages.admin.dokumen.document.add', compact('project', 'folders'));
    }

    /**
     * Upload pertama (INITIAL)
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id'           => 'required|exists:document_projects,id',
            'document_folder_id'   => 'required|exists:document_folders,id',
            'document_no'          => 'required|string',
            'title'                => 'required|string',
            'file'                 => 'required|file|mimes:pdf',
        ]);

        $path = $request->file('file')->store('documents');

        $document = Document::create([
            'project_id'         => $request->project_id,
            'document_folder_id' => $request->document_folder_id,
            'document_no'        => $request->document_no,
            'title'              => $request->title,
            'revision'           => 'A',
            'file_path'          => $path,
            'is_final'           => false,
        ]);

        // 🔥 history otomatis
        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'Initial Upload',
            'revision'    => 'A',
            'note'        => 'Upload pertama',
            'user_id'     => auth()->id(),
            'created_at'  => now(),
        ]);

        return redirect()
            ->route('document.index', $request->project_id)
            ->with('success', 'Dokumen berhasil diupload');
    }

    /**
     * Detail dokumen + history
     */
    public function show($id)
    {
        $document = Document::with(['histories.user', 'folder', 'project'])
            ->findOrFail($id);

        return view('pages.admin.dokumen.document.show', compact('document'));
    }

    /**
     * Update file (REPLACE)
     */
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        if ($document->is_final) {
            return back()->with('error', 'Dokumen sudah FINAL dan tidak bisa diubah');
        }

        $request->validate([
            'file'     => 'required|file|mimes:pdf',
            'revision' => 'required|string',
            'note'     => 'nullable|string',
        ]);

        // hapus file lama
        if (Storage::exists($document->file_path)) {
            Storage::delete($document->file_path);
        }

        $path = $request->file('file')->store('documents');

        $document->update([
            'file_path' => $path,
            'revision'  => $request->revision,
        ]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'Update File',
            'revision'    => $request->revision,
            'note'        => $request->note,
            'user_id'     => auth()->id(),
            'created_at'  => now(),
        ]);

        return back()->with('success', 'Dokumen berhasil diperbarui');
    }

    /**
     * Set dokumen FINAL
     */
    public function setFinal($id)
    {
        $document = Document::findOrFail($id);

        $document->update([
            'revision' => 'FINAL',
            'is_final' => true,
        ]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'Set Final',
            'revision'    => 'FINAL',
            'note'        => 'Dokumen ditetapkan FINAL',
            'user_id'     => auth()->id(),
            'created_at'  => now(),
        ]);

        return back()->with('success', 'Dokumen ditetapkan sebagai FINAL');
    }

    /**
     * Hapus dokumen
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        if (Storage::exists($document->file_path)) {
            Storage::delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus');
    }
}
