<?php

namespace App\Http\Controllers;

use App\Tool;
use App\CalibrationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class CalibrationHistoryController extends Controller
{
    // index for a tool
    public function index()
    {
        $tools = Tool::with('histories')->get();
        return view('pages.admin.kalibrasi.history.index', compact('tools'));
    }

    public function create(Request $request)
    {
        $tool = null;
        $tools = null;

        if ($request->tool_id) {
            $tool = Tool::find($request->tool_id);
            if (!$tool) abort(404); // jika tool_id salah, tampilkan 404
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

        $history = CalibrationHistory::create([
            'tool_id'               => $r->tool_id,
            'tgl_kalibrasi'         => $r->tgl_kalibrasi,
            'tgl_kalibrasi_ulang'   => $r->tgl_kalibrasi_ulang,
            'no_sertifikat'         => $r->no_sertifikat,
            'file_sertifikat'       => $file,
            'lembaga_kalibrasi'     => $r->lembaga_kalibrasi,
            'interval_kalibrasi'    => $r->interval_kalibrasi,
            'eksternal_kalibrasi'   => $r->eksternal_kalibrasi,
            'status_kalibrasi'      => $r->status_kalibrasi,
            'keterangan'            => $r->keterangan,
        ]);

        // ===== Redirect otomatis =====
        // Gunakan input 'redirect_to' dari form, default ke show
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
        $tool = $history->tool; // relasi tool
        return view('pages.admin.kalibrasi.history.update', compact('tool', 'history'));
    }

    public function update(Request $request, $id)
    {
        $r = $request->validate([
            'tgl_kalibrasi' => 'nullable|date',
            'tgl_kalibrasi_ulang' => 'nullable|date',
            'no_sertifikat' => 'nullable|string',
            'file_sertifikat' => 'nullable|mimes:pdf|max:5000',
            'lembaga_kalibrasi' => 'nullable|string',
            'interval_kalibrasi' => 'nullable|string',
            'eksternal_kalibrasi' => 'nullable|string',
            'status_kalibrasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $history = CalibrationHistory::findOrFail($id);

        if ($request->hasFile('file_sertifikat')) {
            if ($history->file_sertifikat && file_exists(public_path('uploads/' . $history->file_sertifikat))) {
                unlink(public_path('uploads/' . $history->file_sertifikat));
            }
            $file = $request->file('file_sertifikat')->store('uploads', 'public');
            $history->file_sertifikat = $file;
        }

        $history->update($r);

        return redirect()->route('histories.show', $history->tool_id)
            ->with('success', 'History kalibrasi berhasil diperbarui!');
    }

    public function destroy(Tool $tool, CalibrationHistory $history)
    {
        // delete file if exist
        if ($history->file_sertifikat && Storage::disk('public')->exists($history->file_sertifikat)) {
            Storage::disk('public')->delete($history->file_sertifikat);
        }
        $history->delete();

        return redirect()->route('tools.histories.index', $tool->id)
            ->with('success', 'History kalibrasi dihapus.');
    }

    public function show($tool_id)
    {
        // Ambil data tool beserta history-nya
        $tool = Tool::with('histories')->findOrFail($tool_id);

        return view('pages.admin.kalibrasi.history.show', compact('tool'));
    }

    // download certificate
    // public function downloadCertificate(Tool $tool, CalibrationHistory $history)
    // {
    //     if (!$history->file_sertifikat) {
    //         return back()->with('error','File sertifikat tidak tersedia.');
    //     }
    //     if (!Storage::disk('public')->exists($history->file_sertifikat)) {
    //         return back()->with('error','File sertifikat tidak ditemukan di server.');
    //     }
    //     return Storage::disk('public')->stream($history->file_sertifikat, $history->no_sertifikat.'.pdf');
    // }
}
