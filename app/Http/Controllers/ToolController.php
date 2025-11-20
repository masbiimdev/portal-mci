<?php

namespace App\Http\Controllers;

use App\Tool;
use App\CalibrationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Mpdf;

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

        $tool = Tool::create($request->only(['nama_alat', 'merek', 'no_seri', 'kapasitas']));

        // generate qr_token and optionally QR image
        $tool->qr_token = (string) Str::uuid();

        // if simple-qrcode installed, generate png; otherwise skip
        try {
            if (class_exists(\SimpleSoftwareIO\QrCode\Facades\QrCode::class)) {
                $qrPath = 'qrcodes/tool-' . $tool->id . '.png';
                $png = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                    ->size(300)
                    ->generate(route('tools.scan', $tool->qr_token));
                Storage::disk('public')->put($qrPath, $png);
                $tool->qr_code_path = $qrPath;
            }
        } catch (\Throwable $e) {
            // ignore if QR generation fails
        }

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

        // Buat instance mPDF
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',      // sama dengan 'a4' di Dompdf
            'orientation' => 'P',  // 'P' = portrait, 'L' = landscape
        ]);

        // Render Blade view jadi HTML
        $html = view('pages.admin.kalibrasi.tool.print', compact('tools'))->render();

        // Tulis HTML ke PDF
        $mpdf->WriteHTML($html);

        // Download PDF langsung
        $mpdf->Output('label-kalibrasi.pdf', 'I');
    }
}
