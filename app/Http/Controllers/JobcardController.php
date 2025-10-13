<?php

namespace App\Http\Controllers;

use App\Jobcard;
use App\JobcardHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class JobcardController extends Controller
{
    public function index()
    {
        $jobcards = Jobcard::with('creator')->latest()->paginate(10);
        return view('pages.admin.production.jobcard.index', compact('jobcards'));
    }

    public function create()
    {
        return view('pages.admin.production.jobcard.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_joborder'   => 'required|string|max:100|unique:jobcards,no_joborder',
            'ws_no'         => 'required|string|max:50',
            'customer'      => 'required|string|max:100',
            'type_jobcard'  => 'required|in:Jobcard Machining,Jobcard Assembling',
            'type_valve'    => 'nullable|string|max:50',
            'size_class'    => 'nullable|string|max:50',
            'drawing_no'    => 'nullable|string|max:100',
            'remarks'       => 'nullable|string',
            'detail'        => 'nullable|string',
            'batch_no'      => 'nullable|string|max:50',
            'material'      => 'nullable|string|max:50',
            'qty'           => 'nullable|integer|min:0',
            'part_name'     => 'nullable|string|max:100',
            'serial_no'     => 'nullable|string|max:100',
            'body'          => 'nullable|string|max:50',
            'bonnet'        => 'nullable|string|max:50',
            'disc'          => 'nullable|string|max:50',
            'qty_acc_po'    => 'nullable|integer|min:0',
            'date_line'     => 'nullable|date',
            'category'      => 'required|in:Reused,Repair,New Manufacture,Supplied',
        ]);

        // Generate jobcard_id otomatis
        do {
            $jobcardId = 'JC-' . rand(1000, 9999);
        } while (Jobcard::where('jobcard_id', $jobcardId)->exists());

        $jobcard = Jobcard::create(array_merge(
            $request->only([
                'no_joborder',
                'ws_no',
                'customer',
                'type_jobcard',
                'type_valve',
                'size_class',
                'drawing_no',
                'remarks',
                'detail',
                'batch_no',
                'material',
                'qty',
                'part_name',
                'serial_no',
                'body',
                'bonnet',
                'disc',
                'qty_acc_po',
                'date_line',
                'category'
            ]),
            ['jobcard_id' => $jobcardId, 'created_by' => Auth::id()]
        ));

        return redirect()->route('jobcards.index')
            ->with('success', 'Jobcard berhasil dibuat dengan ID: ' . $jobcardId);
    }

    public function show($id)
    {
        $jobcard = Jobcard::with(['creator', 'histories'])->findOrFail($id);
        return view('pages.admin.production.jobcard.show', compact('jobcard'));
    }

    public function edit($id)
    {
        $jobcard = Jobcard::findOrFail($id);
        return view('pages.admin.production.jobcard.edit', compact('jobcard'));
    }

    public function update(Request $request, $id)
    {
        $jobcard = Jobcard::findOrFail($id);

        $request->validate([
            'no_joborder'   => 'required|string|max:100|unique:jobcards,no_joborder,' . $jobcard->id,
            'ws_no'         => 'required|string|max:50',
            'customer'      => 'required|string|max:100',
            'type_jobcard'  => 'required|in:Jobcard Machining,Jobcard Assembling',
            'type_valve'    => 'nullable|string|max:50',
            'size_class'    => 'nullable|string|max:50',
            'drawing_no'    => 'nullable|string|max:100',
            'remarks'       => 'nullable|string',
            'detail'        => 'nullable|string',
            'batch_no'      => 'nullable|string|max:50',
            'material'      => 'nullable|string|max:50',
            'qty'           => 'nullable|integer|min:0',
            'part_name'     => 'nullable|string|max:100',
            'serial_no'     => 'nullable|string|max:100',
            'body'          => 'nullable|string|max:50',
            'bonnet'        => 'nullable|string|max:50',
            'disc'          => 'nullable|string|max:50',
            'qty_acc_po'    => 'nullable|integer|min:0',
            'date_line'     => 'nullable|date',
            'category'      => 'required|in:Reused,Repair,New Manufacture,Supplied',
        ]);

        $jobcard->update($request->only([
            'no_joborder',
            'ws_no',
            'customer',
            'type_jobcard',
            'type_valve',
            'size_class',
            'drawing_no',
            'remarks',
            'detail',
            'batch_no',
            'material',
            'qty',
            'part_name',
            'serial_no',
            'body',
            'bonnet',
            'disc',
            'qty_acc_po',
            'date_line',
            'category'
        ]));

        return redirect()->route('jobcards.index')
            ->with('success', 'Jobcard berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jobcard = Jobcard::findOrFail($id);
        $jobcard->delete();

        return redirect()->route('jobcards.index')
            ->with('success', 'Jobcard berhasil dihapus.');
    }

    public function scanForm($id)
    {
        $jobcard = Jobcard::findOrFail($id);

        $lastScan = $jobcard->histories()->latest('scanned_at')->first();

        $action = 'Scan In';
        if ($lastScan && $lastScan->action === 'Scan In' && optional(auth()->user())->id === $lastScan->scanned_by) {
            $action = 'Scan Out';
        }
        $jobcard = Jobcard::findOrFail($id);
        return view('pages.admin.production.jobcard.scan', compact('jobcard', 'action'));
    }

    public function scan(Request $request, $id)
    {
        // Ambil jobcard
        $jobcard = Jobcard::findOrFail($id);

        // Ambil last scan untuk menentukan action
        $lastScan = $jobcard->histories()->latest('scanned_at')->first();
        $action = 'Scan In';

        if ($lastScan && Auth::check() && $lastScan->action === 'Scan In' && $lastScan->scanned_by === auth()->id()) {
            $action = 'Scan Out';
        }

        // Tentukan siapa yang melakukan scan (guest => null)
        $scannedBy = Auth::check() ? auth()->id() : null;

        // Simpan history scan
        $jobcard->histories()->create([
            'process_name' => $request->process_name ?? 'Proses',
            'action'       => $action,
            'scanned_by'   => $scannedBy,
            'remarks'      => $request->remarks,
            'scanned_at'   => now(),
        ]);

        // Redirect ke halaman success dengan flash message
        return redirect()->route('jobcards.scan.success', ['jobcard' => $id, 'action' => $action])
            ->with('success', "Berhasil $action Jobcard {$jobcard->jobcard_no}");
    }


    public function scanSuccess($id, $action)
    {
        $jobcard = Jobcard::findOrFail($id);
        return view('pages.admin.production.jobcard.scan-success', compact('jobcard', 'action'));
    }

    public function print($id)
    {
        $jobcard = Jobcard::with('creator')->findOrFail($id);
        $jobcardUrl = route('jobcards.scan', $jobcard->id);

        $qr = base64_encode(
            QrCode::format('svg')->size(150)->generate($jobcardUrl)
        );

        $pdf = PDF::loadView('pages.admin.production.jobcard.print', compact('jobcard', 'qr', 'jobcardUrl'))
            ->setPaper('A4', 'landscape')->set_option('defaultFont', 'DejaVu Sans');

        return $pdf->stream('Jobcard-' . $jobcard->jobcard_id . '.pdf');
    }

    public function exportPdf()
    {
        $jobcards = Jobcard::with('creator')->latest()->get();

        $pdf = Pdf::loadView('pages.admin.production.jobcard.export', compact('jobcards'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Daftar_Jobcard.pdf');
    }

    public function publicShow($id)
    {
        $jobcard = Jobcard::with(['creator', 'histories.user'])->findOrFail($id);

        // Cek role user
        if (Auth::check() && Auth::user()->role === 'KR') {
            // Jika role KR → arahkan ke scan form
            return redirect()->route('jobcards.scan.form', $jobcard->id);
        }

        return view('pages.admin.production.jobcard.detail', compact('jobcard'));
    }
}
