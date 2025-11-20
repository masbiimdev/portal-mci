<?php

namespace App\Http\Controllers;

use App\Tool;
use App\CalibrationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::with('latestHistory')->orderBy('nama_alat')->get();
        return view('pages.admin.kalibrasi.tool.index', compact('tools'));
    }

    public function create()
    {
        return view('pages.admin.kalibrasi.tool.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'merek' => 'nullable|string|max:255',
            'no_seri' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|string|max:255',
        ]);

        // Simpan alat
        $tool = Tool::create($request->only(['nama_alat', 'merek', 'no_seri', 'kapasitas']));
        $tool->qr_token = (string) Str::uuid(); // token unik

        // ============ QR CODE ==============
        try {
            $qrDir = public_path('qrcodes');
            if (!file_exists($qrDir)) {
                mkdir($qrDir, 0755, true);
            }

            $qrPath = $qrDir . '/tool-' . $tool->id . '.png';

            // Gunakan API QR yang pasti bekerja
            $qrApi = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="
                . urlencode(route('tools.scan', $tool->qr_token));

            file_put_contents($qrPath, file_get_contents($qrApi));

            $tool->qr_code_path = 'qrcodes/tool-' . $tool->id . '.png';
        } catch (\Throwable $e) {
            // Bisa tambahkan logging jika mau
            // logger()->error($e->getMessage());
        }
        // ==================================

        $tool->save();

        return redirect()->route('tools.index')
            ->with('success', 'Alat berhasil ditambahkan.');
    }



    public function show(Tool $tool)
    {
        // eager load histories
        $tool->load(['histories' => function ($q) {
            $q->orderBy('tgl_kalibrasi', 'desc');
        }, 'latestHistory']);
        return view('pages.admin.kalibrasi.tool.show', compact('tool'));
    }

    public function edit(Tool $tool)
    {
        return view('tools.edit', compact('tool'));
    }

    public function update(Request $request, Tool $tool)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'merek' => 'nullable|string|max:255',
            'no_seri' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|string|max:255',
        ]);

        $tool->update($request->only(['nama_alat', 'merek', 'no_seri', 'kapasitas']));

        return redirect()->route('tools.index')->with('success', 'Alat diperbarui.');
    }

    public function destroy(Tool $tool)
    {
        // deleting tool will cascade delete histories due to FK onDelete cascade
        $tool->delete();
        return redirect()->route('tools.index')->with('success', 'Alat dihapus.');
    }

    // public scan route when QR scanned
    public function scan($token)
    {
        $tool = Tool::where('qr_token', $token)->firstOrFail();
        $tool->load(['histories' => function ($q) {
            $q->orderBy('tgl_kalibrasi', 'desc');
        }]);
        return view('pages.admin.kalibrasi.history.scan', compact('tool'));
    }

    // optional regenerate QR
    public function regenerateQr(Tool $tool)
    {
        $tool->qr_token = (string) Str::uuid(); // token baru

        try {
            $qrDir = public_path('qrcodes');
            if (!file_exists($qrDir)) {
                mkdir($qrDir, 0755, true);
            }

            $qrPath = $qrDir . '/tool-' . $tool->id . '.png';

            $qrApi = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="
                . urlencode(route('tools.scan', $tool->qr_token));

            file_put_contents($qrPath, file_get_contents($qrApi));

            $tool->qr_code_path = 'qrcodes/tool-' . $tool->id . '.png';
        } catch (\Throwable $e) {
        }

        $tool->save();

        return back()->with('success', 'QR code berhasil digenerate ulang.');
    }


    public function printAll()
    {
        $tools = Tool::all();

        $pdf = Pdf::loadView('pages.admin.kalibrasi.tool.print', compact('tools'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('label-kalibrasi.pdf');
    }
}
