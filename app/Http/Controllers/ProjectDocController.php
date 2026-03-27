<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectDocController extends Controller
{
    // --- FUNGSI BANTUAN UNTUK DETEKSI FOLDER PUBLIC OTOMATIS ---
    private function getPublicFolder()
    {
        // Jika diakses lewat browser (Local / Hosting), gunakan Document Root server
        if (isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) {
            return rtrim($_SERVER['DOCUMENT_ROOT'], '/');
        }
        // Fallback standar Laravel (berguna jika menjalankan php artisan di terminal)
        return public_path();
    }

    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->get();
        return view('pages.admin.dokumen.project.index', compact('projects'));
    }

    public function create()
    {
        return view('pages.admin.dokumen.project.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_number' => 'required',
            'project_name'   => 'required',
            'status'         => 'required',
            'project_image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $year = now()->year;

        $lastProject = Project::whereYear('created_at', $year)
            ->orderBy('project_code', 'desc')
            ->first();

        $lastNumber = $lastProject
            ? (int) substr($lastProject->project_code, -3)
            : 0;

        $nextNumber = $lastNumber + 1;

        $projectCode = sprintf('PRJ-%s-%03d', $year, $nextNumber);

        // Proses Upload Gambar
        $imagePath = null;
        if ($request->hasFile('project_image')) {
            $file = $request->file('project_image');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            // Gunakan fungsi otomatis yang kita buat di atas
            $destinationPath = $this->getPublicFolder() . '/project_images';

            // Pastikan folder tujuan ada
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            // Pindahkan file
            $file->move($destinationPath, $fileName);

            // Simpan path untuk database
            $imagePath = 'project_images/' . $fileName;
        }

        Project::create([
            'project_code'   => $projectCode,
            'project_number' => $request->project_number,
            'project_name'   => $request->project_name,
            'description'    => $request->description,
            'project_image'  => $imagePath,
            'status'         => $request->status,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
        ]);

        return redirect()
            ->route('document.project.index')
            ->with('success', 'Project berhasil ditambahkan');
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('pages.admin.dokumen.project.show', compact('project'));
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('pages.admin.dokumen.project.update', compact('project'));
    }

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
            'project_image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $updateData = [
            'project_number' => $request->project_number,
            'project_name'   => $request->project_name,
            'description'    => $request->description,
            'status'         => $request->status,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
        ];

        // Jika user mengunggah gambar baru
        if ($request->hasFile('project_image')) {
            $destinationPath = $this->getPublicFolder() . '/project_images';

            // Hapus gambar lama
            if ($project->project_image) {
                $oldImagePath = $this->getPublicFolder() . '/' . $project->project_image;
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Simpan gambar baru 
            $file = $request->file('project_image');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $file->move($destinationPath, $fileName);
            $updateData['project_image'] = 'project_images/' . $fileName;
        }

        $project->update($updateData);

        return redirect()
            ->route('document.project.index')
            ->with('success', 'Project berhasil diperbarui');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Hapus file gambar
        if ($project->project_image) {
            $oldImagePath = $this->getPublicFolder() . '/' . $project->project_image;
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        $project->delete();

        return redirect()->route('document.project.index')
            ->with('success', 'Project berhasil dihapus');
    }
}
