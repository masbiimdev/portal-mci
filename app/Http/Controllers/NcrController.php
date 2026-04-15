<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ncr; // Sesuaikan dengan path model Anda (App\Ncr atau App\Models\Ncr)
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NcrController extends Controller
{
    // =========================================================
    // 1. HALAMAN CUSTOM (PORTAL & DASHBOARD)
    // =========================================================

    public function indexHome()
    {
        $ncrs = Ncr::orderBy('issue_date', 'desc')->get();

        $totalNcr = $ncrs->count();
        $statusOpen = $ncrs->where('status', 'Open')->count();
        $statusMonitoring = $ncrs->where('status', 'Monitoring')->count();
        $statusClosed = $ncrs->where('status', 'Closed')->count();

        $pieData = [
            'open' => $statusOpen,
            'monitoring' => $statusMonitoring,
            'closed' => $statusClosed
        ];

        return view('pages.ncr', compact('ncrs', 'totalNcr', 'statusOpen', 'statusMonitoring', 'statusClosed', 'pieData'));
    }

    public function dashboard()
    {
        $ncrs = Ncr::orderBy('issue_date', 'desc')->get();

        $totalNcr = $ncrs->count();
        $statusOpen = $ncrs->where('status', 'Open')->count();
        $statusMonitoring = $ncrs->where('status', 'Monitoring')->count();
        $statusClosed = $ncrs->where('status', 'Closed')->count();
        $criticalOpen = $ncrs->where('status', 'Open')->where('severity', 'Critical')->count();

        $scopeData = [
            $ncrs->where('audit_scope', 'Internal')->count(),
            $ncrs->where('audit_scope', 'External')->count(),
            $ncrs->where('audit_scope', 'Supplier')->count(),
        ];

        $sevData = [
            $ncrs->where('severity', 'Critical')->count(),
            $ncrs->where('severity', 'High')->count(),
            $ncrs->where('severity', 'Medium')->count(),
            $ncrs->where('severity', 'Low')->count(),
        ];

        $currentYear = date('Y');
        $trendData = Ncr::select(DB::raw('MONTH(issue_date) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('issue_date', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $barLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $barValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $barValues[] = $trendData[$i] ?? 0;
        }

        return view('pages.admin.ncr.dashboard', compact(
            'ncrs',
            'totalNcr',
            'statusOpen',
            'statusMonitoring',
            'statusClosed',
            'criticalOpen',
            'scopeData',
            'sevData',
            'barLabels',
            'barValues'
        ));
    }


    // =========================================================
    // 2. FUNGSI CRUD STANDAR (ADMIN)
    // =========================================================

    public function index()
    {
        $ncrs = Ncr::orderBy('issue_date', 'desc')->get();
        return view('pages.admin.ncr.index', compact('ncrs'));
    }

    public function create()
    {
        return view('pages.admin.ncr.add');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (id_ncr tidak perlu divalidasi karena digenerate otomatis)
        $validatedData = $request->validate([
            'no_ncr'      => 'required|string|max:255',
            'issue_date'  => 'required|date',
            'no_po'       => 'nullable|string|max:255',
            'qty'         => 'nullable|integer|min:1',
            'report_reff' => 'nullable|string|max:255',
            'audit_scope' => 'required|in:Internal,External,Supplier',
            'severity'    => 'required|in:Critical,High,Medium,Low',
            'status'      => 'required|in:Open,Monitoring,Closed',
            'issue'       => 'required|string',
            'tindakan'    => 'nullable|string',
        ]);

        // 2. Auto-Generate id_ncr (Format: NCR-XXXXXX)
        do {
            // Menghasilkan angka acak 6 digit
            $randomNumber = mt_rand(100000, 999999);
            $generateId = 'NCR-' . $randomNumber;

            // Cek ke database apakah ID tersebut sudah pernah terpakai
            $idExists = Ncr::where('id_ncr', $generateId)->exists();
        } while ($idExists); // Akan terus mengulang jika kebetulan angka acaknya sama

        // 3. Masukkan ID yang sudah unik ke dalam array data yang akan disimpan
        $validatedData['id_ncr'] = $generateId;

        // 4. Simpan ke Database
        Ncr::create($validatedData);

        return redirect()->route('ncr.index')->with('success', 'Data NCR berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $ncr = Ncr::findOrFail($id);
        return view('pages.admin.ncr.show', compact('ncr'));
    }

    public function edit(string $id)
    {
        $ncr = Ncr::findOrFail($id);
        return view('pages.admin.ncr.update', compact('ncr'));
    }

    public function update(Request $request, string $id)
    {
        $ncr = Ncr::findOrFail($id);

        // Validasi saat update (id_ncr tidak diubah)
        $validatedData = $request->validate([
            'no_ncr'      => 'required|string|max:255',
            'issue_date'  => 'required|date',
            'no_po'       => 'nullable|string|max:255',
            'qty'         => 'nullable|integer|min:1',
            'report_reff' => 'nullable|string|max:255',
            'audit_scope' => 'required|in:Internal,External,Supplier',
            'severity'    => 'required|in:Critical,High,Medium,Low',
            'status'      => 'required|in:Open,Monitoring,Closed',
            'issue'       => 'required|string',
            'tindakan'    => 'nullable|string',
        ]);

        $ncr->update($validatedData);

        return redirect()->route('ncr.index')->with('success', 'Data NCR berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $ncr = Ncr::findOrFail($id);
        $ncr->delete();

        return redirect()->route('ncr.index')->with('success', 'Data NCR berhasil dihapus.');
    }
}
