<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Gunakan File, bukan Storage

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
            'project_image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar (maks 2MB)
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

        // Proses Upload Gambar ke folder public
        $imagePath = null;
        if ($request->hasFile('project_image')) {
            $file = $request->file('project_image');

            // Generate nama file unik
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            // Pindahkan file ke public/project_images
            $file->move(public_path('project_images'), $fileName);

            // Simpan path untuk di database
            $imagePath = 'project_images/' . $fileName;
        }

        Project::create([
            'project_code'   => $projectCode,
            'project_number' => $request->project_number,
            'project_name'   => $request->project_name,
            'description'    => $request->description,
            'project_image'  => $imagePath, // Menyimpan 'project_images/namafile.jpg'
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
            'project_image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar baru
        ]);

        // Persiapkan data yang akan diupdate
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
            // Hapus gambar lama dari folder public jika ada
            if ($project->project_image && File::exists(public_path($project->project_image))) {
                File::delete(public_path($project->project_image));
            }

            // Simpan gambar baru ke folder public
            $file = $request->file('project_image');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('project_images'), $fileName);

            // Update array dengan path baru
            $updateData['project_image'] = 'project_images/' . $fileName;
        }

        $project->update($updateData);

        return redirect()
            ->route('document.project.index')
            ->with('success', 'Project berhasil diperbarui');
    }

    // Hapus project
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Hapus file gambar secara fisik dari folder public sebelum menghapus data di database
        if ($project->project_image && File::exists(public_path($project->project_image))) {
            File::delete(public_path($project->project_image));
        }

        $project->delete();

        return redirect()->route('document.project.index')
            ->with('success', 'Project berhasil dihapus');
    }
}
