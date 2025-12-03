<?php

namespace App\Http\Controllers;

use App\Tool;
use App\CalibrationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class CalibrationHistoryController extends Controller
{
    // index for a 

    public function index()
    {
        $today = Carbon::now();

        $tools = Tool::with(['histories' => function ($q) {
            $q->orderBy('tgl_kalibrasi_ulang', 'desc'); // urut history tiap tool
        }])->get();

        // Urutkan tools berdasarkan tgl_kalibrasi_ulang paling dekat dengan hari ini
        $tools = $tools->sortBy(function ($tool) use ($today) {
            $latestDate = optional($tool->histories->first())->tgl_kalibrasi_ulang;

            if (!$latestDate) {
                return PHP_INT_MAX; // kalau null, taruh paling bawah
            }

            return abs(Carbon::parse($latestDate)->diffInDays($today));
        });

        return view('pages.admin.kalibrasi.history.index', compact('tools'));
    }


    public function create(Request $request)
    {
        $tool = null;
        $tools = null;

        if ($request->tool_id) {
            $tool = Tool::find($request->tool_id);
            if (!$tool) abort(404);
        } else {
            $tools = Tool::all();
        }

        return view('pages.admin.kalibrasi.history.add', compact('tool', 'tools'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'tool_id'           => 'required',
            'file_sertifikat'   => 'nullable|mimes:pdf|max:5000',
        ]);

        $file = null;
        if ($r->hasFile('file_sertifikat')) {
            $file = $r->file('file_sertifikat')->store('sertifikat-kalibrasi', 'public');
        }

        // Mutator akan mengatur status_kalibrasi & keterangan
        CalibrationHistory::create([
            'tool_id'               => $r->tool_id,
            'tgl_kalibrasi'         => $r->tgl_kalibrasi,
            'tgl_kalibrasi_ulang'   => $r->tgl_kalibrasi_ulang,
            'no_sertifikat'         => $r->no_sertifikat,
            'file_sertifikat'       => $file,
            'lembaga_kalibrasi'     => $r->lembaga_kalibrasi,
            'interval_kalibrasi'    => $r->interval_kalibrasi,
            'eksternal_kalibrasi'   => $r->eksternal_kalibrasi,
            'status_kalibrasi'      => $r->status_kalibrasi, // MUTATOR yang mengolah
        ]);

        $redirectTo = $r->input('redirect_to', 'show');

        if ($redirectTo === 'index') {
            return redirect()->route('histories.index')->with('success', 'History berhasil ditambahkan');
        }

        return redirect()->route('histories.show', $r->tool_id)
            ->with('success', 'History berhasil ditambahkan');
    }


    public function edit($id)
    {
        $history = CalibrationHistory::findOrFail($id);
        $tool = $history->tool;
        return view('pages.admin.kalibrasi.history.update', compact('tool', 'history'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tgl_kalibrasi' => 'nullable|date',
            'tgl_kalibrasi_ulang' => 'nullable|date',
            'no_sertifikat' => 'nullable|string',
            'file_sertifikat' => 'nullable|mimes:pdf|max:5000',
            'lembaga_kalibrasi' => 'nullable|string',
            'interval_kalibrasi' => 'nullable|string',
            'eksternal_kalibrasi' => 'nullable|string',
            'status_kalibrasi' => 'nullable|string', // MUTATOR akan olah
        ]);

        $history = CalibrationHistory::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('file_sertifikat')) {
            if ($history->file_sertifikat && Storage::disk('public')->exists($history->file_sertifikat)) {
                Storage::disk('public')->delete($history->file_sertifikat);
            }

            $file = $request->file('file_sertifikat')->store('uploads', 'public');
            $data['file_sertifikat'] = $file;
        }

        // Mutator otomatis update status & keterangan
        $history->fill($data);
        $history->save();

        return redirect()->route('histories.show', $history->tool_id)
            ->with('success', 'History kalibrasi berhasil diperbarui!');
    }


    public function destroy(Tool $tool, CalibrationHistory $history)
    {
        if ($history->file_sertifikat && Storage::disk('public')->exists($history->file_sertifikat)) {
            Storage::disk('public')->delete($history->file_sertifikat);
        }

        $history->delete();

        return redirect()->route('histories.index', $tool->id)
            ->with('success', 'History kalibrasi dihapus.');
    }

    public function show($tool_id)
    {
        $tool = Tool::with('histories')->findOrFail($tool_id);
        return view('pages.admin.kalibrasi.history.show', compact('tool'));
    }
}
