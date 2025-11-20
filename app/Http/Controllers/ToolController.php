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

        // simpan alat
        $tool = Tool::create($request->only(['nama_alat', 'merek', 'no_seri', 'kapasitas']));

        // generate token unik untuk QR
        $tool->qr_token = (string) Str::uuid();

        try {
            if (class_exists(\SimpleSoftwareIO\QrCode\Facades\QrCode::class)) {

                // path folder public/qrcodes
                $qrDir = public_path('qrcodes');

                // buat folder jika belum ada
                if (!file_exists($qrDir)) {
                    mkdir($qrDir, 0755, true);
                }

                // full path lokasi file PNG
                $qrFullPath = $qrDir . '/tool-' . $tool->id . '.png';

                // generate QR langsung ke file PNG
                \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                    ->size(300)
                    ->generate(route('tools.scan', $tool->qr_token), $qrFullPath);

                // simpan path relatif ke public (untuk ditampilkan di web)
                $tool->qr_code_path = 'qrcodes/tool-' . $tool->id . '.png';
            }
        } catch (\Throwable $e) {
            // jika gagal, jangan hentikan proses
            // dd($e->getMessage()); // aktifkan jika ingin debug
        }

        // simpan perubahan
        $tool->save();

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
