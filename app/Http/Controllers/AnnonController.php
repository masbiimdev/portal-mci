<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Annon;

class AnnonController extends Controller
{
    public function index(Request $request)
    {
        $query = Annon::query();

        // Filter optional
        if ($request->type) $query->where('type', $request->type);
        if ($request->department) $query->where('department', $request->department);
        if ($request->priority) $query->where('priority', $request->priority);

        $annons = $query->orderBy('created_at', 'desc')->get(); // pastikan ini get(), bukan first()

        // dd($annons);

        return view('pages.admin.pengumuman.index', compact('annons'));
    }

    public function create()
    {
        return view('pages.admin.pengumuman.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,maintenance,production,training,event',
            'department' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|max:200048',
            'expiry_date' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['author_id'] = Auth::id();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        Annon::create($data);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit(Annon $announcement)
    {
        // $announcement otomatis berisi data pengumuman yang dipilih
        return view('pages.admin.pengumuman.update', compact('announcement'));
    }

    public function update(Request $request, Annon $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,maintenance,production,training,event',
            'department' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|max:200048',
            'expiry_date' => 'nullable|date',
        ]);

        $data = $request->all();

        // Jika ada file baru
        if ($request->hasFile('attachment')) {
            // Hapus file lama jika ada
            if ($announcement->attachment && Storage::disk('public')->exists($announcement->attachment)) {
                Storage::disk('public')->delete($announcement->attachment);
            }

            // Simpan file baru
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        } else {
            // Jika tidak upload file baru, tetap pakai file lama
            unset($data['attachment']);
        }

        $announcement->update($data);

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }


    public function show(Annon $announcement)
    {
        // $announcement sudah model tunggal via route model binding
        return view('pages.admin.pengumuman.show', compact('announcement'));
    }

    public function destroy(Annon $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
