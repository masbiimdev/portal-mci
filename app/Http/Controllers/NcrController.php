<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ncr; // Pastikan model Ncr sudah menggunakan $fillable yang baru
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NcrController extends Controller
{
    // =========================================================
    // 1. HALAMAN CUSTOM (PORTAL & DASHBOARD)
    // =========================================================

    /**
     * Menampilkan halaman portal public/user biasa
     */
    public function indexHome()
    {
        $ncrs = Ncr::orderBy('issue_date', 'desc')->get();

        $totalNcr = $ncrs->count();
        $statusOpen = $ncrs->where('status', 'Open')->count();
        $statusMonitoring = $ncrs->where('status', 'Monitoring')->count();
        $statusClosed = $ncrs->where('status', 'Closed')->count();

        // Persiapan data pie chart
        $pieData = [
            'open' => $statusOpen,
            'monitoring' => $statusMonitoring,
            'closed' => $statusClosed
        ];

        return view('pages.ncr', compact('ncrs', 'totalNcr', 'statusOpen', 'statusMonitoring', 'statusClosed', 'pieData'));
    }

    /**
     * Menampilkan halaman dashboard analytics admin
     */
    public function dashboard()
    {
        $ncrs = Ncr::orderBy('issue_date', 'desc')->get();

        // Metrik KPI
        $totalNcr = $ncrs->count();
        $statusOpen = $ncrs->where('status', 'Open')->count();
        $statusMonitoring = $ncrs->where('status', 'Monitoring')->count();
        $statusClosed = $ncrs->where('status', 'Closed')->count();
        $criticalOpen = $ncrs->where('status', 'Open')->where('severity', 'Critical')->count();

        // Data untuk Grafik Audit Scope (Doughnut)
        $scopeData = [
            $ncrs->where('audit_scope', 'Internal')->count(),
            $ncrs->where('audit_scope', 'External')->count(),
            $ncrs->where('audit_scope', 'Supplier')->count(),
        ];

        // Data untuk Grafik Severity (Bar)
        $sevData = [
            $ncrs->where('severity', 'Critical')->count(),
            $ncrs->where('severity', 'High')->count(),
            $ncrs->where('severity', 'Medium')->count(),
            $ncrs->where('severity', 'Low')->count(),
        ];

        // Data untuk Grafik Tren Bulanan (Tahun Berjalan)
        $currentYear = date('Y');
        $trendData = Ncr::select(DB::raw('MONTH(issue_date) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('issue_date', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $barLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $barValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $barValues[] = $trendData[$i] ?? 0; // Jika bulan kosong, isi dengan 0
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

    /**
     * Display a listing of the resource. (READ - Menampilkan tabel)
     */
    public function index()
    {
        $ncrs = Ncr::orderBy('issue_date', 'desc')->get();
        return view('pages.admin.ncr.index', compact('ncrs'));
    }

    /**
     * Show the form for creating a new resource. (Form Tambah Data)
     */
    public function create()
    {
        return view('pages.admin.ncr.add');
    }

    /**
     * Store a newly created resource in storage. (CREATE - Simpan Data Baru)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input ketat sesuai migration baru
        $validatedData = $request->validate([
            'no_ncr'      => 'required|string|max:255|unique:ncrs,no_ncr',
            'issue_date'  => 'required|date',
            'no_po'       => 'required|string|max:255',
            'qty'         => 'required|integer|min:1',
            'report_reff' => 'nullable|string|max:255',
            'audit_scope' => 'required|in:Internal,External,Supplier',
            'severity'    => 'required|in:Critical,High,Medium,Low',
            'status'      => 'required|in:Open,Monitoring,Closed',
            'issue'       => 'required|string',
            'tindakan'    => 'required|string',
        ], [
            // Kustomisasi pesan error (opsional)
            'no_ncr.unique' => 'Nomor NCR ini sudah digunakan, silakan masukkan nomor lain.'
        ]);

        // 2. Simpan ke Database
        Ncr::create($validatedData);

        // 3. Redirect kembali ke index dengan pesan sukses
        return redirect()->route('ncr.index')->with('success', 'Data NCR berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (READ - Detail Satu Data)
     */
    public function show(string $id)
    {
        $ncr = Ncr::findOrFail($id);
        return view('pages.admin.ncr.show', compact('ncr'));
    }

    /**
     * Show the form for editing the specified resource. (Form Edit Data)
     */
    public function edit(string $id)
    {
        $ncr = Ncr::findOrFail($id);
        return view('pages.admin.ncr.update', compact('ncr'));
    }

    /**
     * Update the specified resource in storage. (UPDATE - Simpan Perubahan Data)
     */
    public function update(Request $request, string $id)
    {
        $ncr = Ncr::findOrFail($id);

        // 1. Validasi Input (mengabaikan unique rule untuk ID yang sedang di-edit)
        $validatedData = $request->validate([
            'no_ncr'      => 'required|string|max:255|unique:ncrs,no_ncr,' . $id,
            'issue_date'  => 'required|date',
            'no_po'       => 'required|string|max:255',
            'qty'         => 'required|integer|min:1',
            'report_reff' => 'nullable|string|max:255',
            'audit_scope' => 'required|in:Internal,External,Supplier',
            'severity'    => 'required|in:Critical,High,Medium,Low',
            'status'      => 'required|in:Open,Monitoring,Closed',
            'issue'       => 'required|string',
            'tindakan'    => 'required|string',
        ]);

        // 2. Update Database
        $ncr->update($validatedData);

        // 3. Redirect
        return redirect()->route('ncr.index')->with('success', 'Data NCR berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE - Hapus Data)
     */
    public function destroy(string $id)
    {
        $ncr = Ncr::findOrFail($id);
        $ncr->delete();

        return redirect()->route('ncr.index')->with('success', 'Data NCR berhasil dihapus.');
    }
}
