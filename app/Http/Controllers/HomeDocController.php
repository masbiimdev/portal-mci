<?php

namespace App\Http\Controllers;

use App\Project;
use App\Folder;
use App\Document;
use App\DocumentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeDocController extends Controller
{
    /**
     * ===============================
     * PROJECT LIST
     * /portal/document
     * ===============================
     */
    public function index()
    {
        $projects = Project::withCount([
            // hitung folder
            'folders',

            // hitung semua dokumen dalam project
            'documents'
        ])->orderBy('created_at', 'desc')->get();

        return view('pages.document.project', compact('projects'));
    }
    /**
     * ===============================
     * FOLDER LIST PER PROJECT
     * /portal/document/{project}
     * ===============================
     */
    public function folders(Project $project)
    {
        // $project SUDAH object hasil route model binding

        $folders = Folder::where('document_project_id', $project->id)
            ->withCount('documents')
            ->orderBy('folder_name')
            ->get();

        // dd($folders);
        return view('pages.document.folder', compact('project', 'folders'));
    }

    /**
     * ===============================
     * DOCUMENT LIST
     * /portal/document/{project}/folder/{folder}
     * ===============================
     */
    public function documents(Project $project, Folder $folder)
    {
        // Validasi folder belong ke project
        if ($folder->document_project_id != $project->id) {
            abort(404);
        }

        $documents = Document::where('document_project_id', $project->id)
            ->where('document_folder_id', $folder->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('pages.document.document.index', compact('project', 'folder', 'documents'));
    }

    /**
     * ===============================
     * STORE / INITIAL UPLOAD
     * ===============================
     */

    public function store(Request $request, Project $project, Folder $folder)
    {
        $request->validate([
            'document_no' => 'nullable|string|max:120',
            'revision'    => 'nullable|string|max:50',
            'file'        => 'required|mimes:pdf|max:20480', // max 20MB
            'is_final'    => 'sometimes|boolean',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('file');

        // Ambil nama asli file
        $originalName = $file->getClientOriginalName();

        // Ambil nama tanpa extension
        $fileNameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);

        // Rapikan jadi title (hapus underscore & capitalize)
        $title = ucwords(str_replace('_', ' ', $fileNameWithoutExt));

        // Buat nama file aman (hindari spasi & tabrakan nama)
        $safeFileName = time() . '_' . preg_replace('/\s+/', '_', $originalName);

        // Simpan file
        $path = $file->storeAs(
            "documents/project_{$project->id}/folder_{$folder->id}",
            $safeFileName,
            'public'
        );

        // Simpan document
        $document = Document::create([
            'document_project_id' => $project->id,
            'document_folder_id'  => $folder->id,
            'title'               => $title,
            'document_no'         => $request->document_no,
            'revision'            => $request->revision,
            'file_name'           => $originalName,
            'file_path'           => $path,
            'is_final'            => $request->boolean('is_final'),
            'uploaded_by'         => Auth::id(),
        ]);

        // Simpan history
        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'Initial Upload',
            'revision'    => $request->revision,
            'note'        => $request->input('description', 'File pertama diupload'),
            'user_id'     => Auth::id(),
            'created_at'  => now(),
        ]);

        return back()->with('success', 'Dokumen berhasil diupload');
    }

    /**
     * Update (overwrite) document's file.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'document_no' => 'nullable|string|max:120',
            'revision'    => 'nullable|string|max:50',
            'file'        => 'required|mimes:pdf|max:20480',
            'is_final'    => 'sometimes|boolean',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('file');

        $originalName = $file->getClientOriginalName();
        $safeFileName = time() . '_' . preg_replace('/\s+/', '_', $originalName);

        // Upload dulu
        $path = $file->storeAs(
            "documents/project_{$document->document_project_id}/folder_{$document->document_folder_id}",
            $safeFileName,
            'public'
        );

        // Hapus file lama (PAKAI DISK PUBLIC)
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Update document
        $document->update([
            'title'       => pathinfo($originalName, PATHINFO_FILENAME),
            'document_no' => $request->document_no,
            'revision'    => $request->revision,
            'file_name'   => $originalName,
            'file_path'   => $path,
            'is_final'    => $request->boolean('is_final'),
        ]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'Update Dokumen',
            'note'        => $request->description ?? 'Dokumen diperbarui',
            'user_id'     => Auth::id(),
        ]);

        return back()->with('success', 'Dokumen berhasil diperbarui');
    }




    /**
     * Show document detail + histories.
     */
    public function show(Document $document)
    {
        $document->load([
            'project',
            'folder',
            'histories.user'
        ]);

        return view('pages.document.document.show', compact('document'));
    }

    /**
     * Preview document inline (browser will handle supported types like PDF).
     * Uses storage path and response()->file so it works with files stored in storage/app.
     */
    public function preview(Document $document)
    {
        if (!$document->file_path || !Storage::exists($document->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $filePath = $document->file_path;
        $mimeType = Storage::mimeType($filePath);
        $fileName = $document->file_name ?? basename($filePath);

        return response()->stream(function () use ($filePath) {
            echo Storage::get($filePath);
        }, 200, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }


    /**
     * Download single document.
     */
    public function download(Document $document)
    {
        if (! $document->file_path || ! Storage::exists($document->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::download($document->file_path, $document->file_name);
    }

    /**
     * Download all files in a folder as a ZIP.
     */
    public function downloadAll(Project $project, Folder $folder)
    {
        $folderPath = "documents/project_{$project->id}/folder_{$folder->id}";

        if (!Storage::exists($folderPath)) {
            return back()->with('error', 'Folder tidak ditemukan.');
        }

        $files = Storage::files($folderPath);

        if (empty($files)) {
            return back()->with('error', 'Tidak ada dokumen untuk diunduh.');
        }

        $zipFileName = "documents_folder_{$folder->id}_" . time() . ".zip";
        $zipPath = storage_path("app/{$zipFileName}");

        $zip = new \ZipArchive;

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {

            foreach ($files as $file) {

                $absolutePath = storage_path("app/" . $file);

                if (file_exists($absolutePath)) {
                    // Ini bikin isi zip langsung file saja (tanpa struktur project)
                    $zip->addFile($absolutePath, basename($file));
                }
            }

            $zip->close();
        } else {
            return back()->with('error', 'Gagal membuat file zip.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function destroy(Document $document)
    {
        // Hapus file dari storage (pakai disk public)
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Hapus data dari database
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
