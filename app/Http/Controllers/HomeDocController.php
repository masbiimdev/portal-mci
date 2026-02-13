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
            'file'        => 'required|mimes:pdf|max:20480',
            'is_final'    => 'sometimes|boolean',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('file');

        $originalName = $file->getClientOriginalName();
        $fileNameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
        $title = ucwords(str_replace('_', ' ', $fileNameWithoutExt));

        $safeFileName = time() . '_' . preg_replace('/\s+/', '_', $originalName);

        $destinationPath = public_path(
            "documents/project_{$project->id}/folder_{$folder->id}"
        );

        // Buat folder kalau belum ada
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Pindahkan file
        $file->move($destinationPath, $safeFileName);

        $relativePath = "documents/project_{$project->id}/folder_{$folder->id}/{$safeFileName}";

        $document = Document::create([
            'document_project_id' => $project->id,
            'document_folder_id'  => $folder->id,
            'title'               => $title,
            'document_no'         => $request->document_no,
            'revision'            => $request->revision,
            'file_name'           => $originalName,
            'file_path'           => $relativePath,
            'is_final'            => $request->boolean('is_final'),
            'uploaded_by'         => Auth::id(),
        ]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'Initial Upload',
            'revision'    => $request->revision,
            'note'        => $request->input('description', 'File pertama diupload'),
            'user_id'     => Auth::id(),
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

        $destinationPath = public_path(
            "documents/project_{$document->document_project_id}/folder_{$document->document_folder_id}"
        );

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Upload file baru dulu
        $file->move($destinationPath, $safeFileName);

        $relativePath = "documents/project_{$document->document_project_id}/folder_{$document->document_folder_id}/{$safeFileName}";

        // Hapus file lama
        if ($document->file_path && file_exists(public_path($document->file_path))) {
            unlink(public_path($document->file_path));
        }

        $document->update([
            'title'       => pathinfo($originalName, PATHINFO_FILENAME),
            'document_no' => $request->document_no,
            'revision'    => $request->revision,
            'file_name'   => $originalName,
            'file_path'   => $relativePath,
            'is_final'    => $request->boolean('is_final'),
        ]);

        DocumentHistory::create([
            'document_id' => $document->id,
            'action'      => 'Update Dokumen',
            'revision'    => $request->revision,
            'note'        => $request->input('description', 'Dokumen diperbarui'),
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
        $fullPath = $document->file_path
            ? public_path($document->file_path)
            : null;

        if (!$fullPath || !file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan.');
        }

        $mimeType = mime_content_type($fullPath);
        $fileName = $document->file_name ?? basename($fullPath);

        return response()->file($fullPath, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }



    /**
     * Download single document.
     */
    public function download(Document $document)
    {
        $fullPath = $document->file_path
            ? public_path($document->file_path)
            : null;

        if (!$fullPath || !file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($fullPath, $document->file_name);
    }


    /**
     * Download all files in a folder as a ZIP.
     */
    public function downloadAll(Project $project, Folder $folder)
    {
        $folderPath = public_path(
            "documents/project_{$project->id}/folder_{$folder->id}"
        );

        if (!file_exists($folderPath) || !is_dir($folderPath)) {
            return back()->with('error', 'Folder tidak ditemukan.');
        }

        $files = array_diff(scandir($folderPath), ['.', '..']);

        if (empty($files)) {
            return back()->with('error', 'Tidak ada dokumen untuk diunduh.');
        }

        $zipFileName = "documents_folder_{$folder->id}_" . time() . ".zip";
        $zipPath = public_path($zipFileName);

        $zip = new \ZipArchive;

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {

            foreach ($files as $file) {

                $absolutePath = $folderPath . '/' . $file;

                if (file_exists($absolutePath)) {
                    // Isi zip langsung file saja (tanpa struktur folder)
                    $zip->addFile($absolutePath, $file);
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
        if ($document->file_path && file_exists(public_path($document->file_path))) {
            unlink(public_path($document->file_path));
        }

        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
