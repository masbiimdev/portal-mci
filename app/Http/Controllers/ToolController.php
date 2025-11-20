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
        // 1. Validasi input
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'merek'     => 'nullable|string|max:255',
            'no_seri'   => 'nullable|string|max:255',
            'kapasitas' => 'nullable|string|max:255',
        ]);

        // 2. Simpan alat
        $tool = Tool::create($request->only(['nama_alat', 'merek', 'no_seri', 'kapasitas']));

        // 3. Generate token unik QR
        $tool->qr_token = (string) Str::uuid();

        try {
            // cek apakah package QR tersedia
            if (class_exists(\SimpleSoftwareIO\QrCode\Facades\QrCode::class)) {

                // folder tujuan: public/qrcodes
                $qrDir = public_path('qrcodes');

                // buat folder jika belum ada
                if (!file_exists($qrDir)) {
                    mkdir($qrDir, 0755, true);
                }

                // nama file QR
                $qrFileName = 'tool-' . $tool->id . '.png';
                $qrFullPath = $qrDir . '/' . $qrFileName;

                // generate QR dalam bentuk binary PNG
                $qrImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                    ->size(300)
                    ->generate(route('tools.scan', $tool->qr_token));

                // simpan ke file secara manual
                file_put_contents($qrFullPath, $qrImage);

                // simpan path relatif ke database (relatif ke public)
                $tool->qr_code_path = 'qrcodes/' . $qrFileName;
            }
        } catch (\Throwable $e) {
            // opsional: log error, jangan biarkan crash
            \Illuminate\Support\Facades\Log::error('QR Code gagal dibuat: ' . $e->getMessage());
        }

        // 4. Simpan perubahan di database
        $tool->save();

        // 5. Redirect dengan pesan sukses
        return redirect()->route('tools.index')->with('success', 'Alat berhasil ditambahkan.');
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
        $tool->qr_token = (string) Str::uuid();
        if (class_exists(\SimpleSoftwareIO\QrCode\Facades\QrCode::class)) {
            $qrPath = 'qrcodes/tool-' . $tool->id . '.png';
            $png = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->size(300)
                ->generate(route('tools.scan', $tool->qr_token));
            Storage::disk('public')->put($qrPath, $png);
            $tool->qr_code_path = $qrPath;
        }
        $tool->save();
        return back()->with('success', 'QR code regenerated.');
    }

    public function printAll()
    {
        $tools = Tool::all();

        $pdf = Pdf::loadView('pages.admin.kalibrasi.tool.print', compact('tools'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('label-kalibrasi.pdf');
    }
}
