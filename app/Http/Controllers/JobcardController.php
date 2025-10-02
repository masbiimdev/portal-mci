<?php

namespace App\Http\Controllers;

use App\Jobcard;
use App\JobcardHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobcardController extends Controller
{
    /**
     * Tampilkan daftar jobcard
     */
    public function index()
    {
        $jobcards = Jobcard::with('creator')->latest()->paginate(10);
        return view('pages.admin.production.jobcard.index', compact('jobcards'));
    }

    /**
     * Form create jobcard
     */
    public function create()
    {
        return view('pages.admin.production.jobcard.add');
    }

    /**
     * Simpan jobcard baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'ws_no'        => 'required|string|max:50',
            'customer'     => 'required|string|max:100',
            'serial_no'    => 'required|string|max:100',
            'drawing_no'   => 'required|string|max:100',
            'disc'         => 'nullable|string|max:50',
            'body'         => 'nullable|string|max:50',
            'bonnet'       => 'nullable|string|max:50',
            'size_class'   => 'nullable|string|max:50',
            'type'         => 'nullable|string|max:100',
            'qty_acc_po'   => 'nullable|integer|min:0',
            'date_line'    => 'nullable|date',
            'category'     => 'required|in:Reused,Repair,New Manufacture,Supplied',
        ]);

        // Generate jobcard_no otomatis
        do {
            $jobcardNo = 'JC-' . rand(1000, 9999);
        } while (\App\Jobcard::where('jobcard_no', $jobcardNo)->exists());

        Jobcard::create([
            'jobcard_no'   => $jobcardNo,
            'ws_no'        => $request->ws_no,
            'customer'     => $request->customer,
            'serial_no'    => $request->serial_no,
            'drawing_no'   => $request->drawing_no,
            'disc'         => $request->disc,
            'body'         => $request->body,
            'bonnet'       => $request->bonnet,
            'size_class'   => $request->size_class,
            'type'         => $request->type,
            'qty_acc_po'   => $request->qty_acc_po ?? 0,
            'date_line'    => $request->date_line,
            'category'     => $request->category,
            'created_by'   => Auth::id(),
        ]);

        return redirect()->route('jobcards.index')
            ->with('success', 'Jobcard berhasil dibuat dengan nomor: ' . $jobcardNo);
    }


    /**
     * Detail jobcard
     */
    public function show($id)
    {
        $jobcard = Jobcard::with('creator')->findOrFail($id);
        return view('pages.admin.production.jobcard.show', compact('jobcard'));
    }

    /**
     * Form edit jobcard
     */
    public function edit($id)
    {
        $jobcard = Jobcard::findOrFail($id);
        return view('jobcards.edit', compact('jobcard'));
    }

    /**
     * Update jobcard
     */
    public function update(Request $request, $id)
    {
        $jobcard = Jobcard::findOrFail($id);

        $request->validate([
            'jobcard_no'   => 'required|string|max:50|unique:jobcards,jobcard_no,' . $jobcard->id,
            'ws_no'        => 'required|string|max:50',
            'customer'     => 'required|string|max:100',
            'serial_no'    => 'required|string|max:100',
            'drawing_no'   => 'required|string|max:100',
            'disc'         => 'nullable|string|max:50',
            'body'         => 'nullable|string|max:50',
            'bonnet'       => 'nullable|string|max:50',
            'size_class'   => 'nullable|string|max:50',
            'type'         => 'nullable|string|max:100',
            'qty_acc_po'   => 'nullable|integer|min:0',
            'date_line'    => 'nullable|date',
            'category'     => 'required|in:Reused,Repair,New Manufacture,Supplied',
        ]);

        $jobcard->update([
            'jobcard_no'   => $request->jobcard_no,
            'ws_no'        => $request->ws_no,
            'customer'     => $request->customer,
            'serial_no'    => $request->serial_no,
            'drawing_no'   => $request->drawing_no,
            'disc'         => $request->disc,
            'body'         => $request->body,
            'bonnet'       => $request->bonnet,
            'size_class'   => $request->size_class,
            'type'         => $request->type,
            'qty_acc_po'   => $request->qty_acc_po ?? 0,
            'date_line'    => $request->date_line,
            'category'     => $request->category,
        ]);

        return redirect()->route('jobcards.index')
            ->with('success', 'Jobcard berhasil diperbarui.');
    }

    /**
     * Hapus jobcard
     */
    public function destroy($id)
    {
        $jobcard = Jobcard::findOrFail($id);
        $jobcard->delete();

        return redirect()->route('jobcards.index')
            ->with('success', 'Jobcard berhasil dihapus.');
    }

    public function scan(Request $request, $id)
    {
        $jobcard = Jobcard::findOrFail($id);

        // Simpan history scan
        JobcardHistory::create([
            'jobcard_id'   => $jobcard->id,
            'process_name' => $request->process_name ?? 'Unknown', // bisa dikirim dari form atau fixed
            'action'       => $request->action ?? 'Scan',          // "Scan In" / "Scan Out"
            'scanned_by'   => Auth::id(),
            'remarks'      => $request->remarks,
            'scanned_at'   => now(),
        ]);

        return redirect()->back()->with('success', 'Scan berhasil dicatat.');
    }
}
