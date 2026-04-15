@extends('layouts.admin')
@section('title', 'Daftar Laporan NCR')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* --- GLOBAL BENTO VARIABLES --- */
        :root {
            --bento-bg: #f3f4f6;
            --bento-surface: #ffffff;
            --bento-radius: 24px;
            --bento-radius-sm: 16px;
            --bento-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.06);
            --bento-shadow-hover: 0 15px 50px -10px rgba(15, 23, 42, 0.12);
            --bento-border: 1px solid rgba(226, 232, 240, 0.8);

            --brand-primary: #4f46e5;
            --brand-dark: #0f172a;
            --text-main: #334155;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--bento-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
        }

        /* --- BENTO GRID SYSTEM --- */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .bento-box {
            background: var(--bento-surface);
            border-radius: var(--bento-radius);
            box-shadow: var(--bento-shadow);
            border: var(--bento-border);
            padding: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .bento-box:hover {
            transform: translateY(-3px) scale(1.005);
            box-shadow: var(--bento-shadow-hover);
        }

        .bento-span-12 {
            grid-column: span 12;
        }

        .bento-span-6 {
            grid-column: span 6;
        }

        .bento-span-4 {
            grid-column: span 4;
        }

        .bento-span-3 {
            grid-column: span 3;
        }

        .bento-span-2 {
            grid-column: span 2;
        }

        @media (max-width: 992px) {

            .bento-span-4,
            .bento-span-3,
            .bento-span-2 {
                grid-column: span 6;
            }

            .bento-span-6 {
                grid-column: span 12;
            }
        }

        @media (max-width: 576px) {

            .bento-span-6,
            .bento-span-4,
            .bento-span-3,
            .bento-span-2 {
                grid-column: span 12;
            }
        }

        /* --- WELCOME / ACTION BENTO --- */
        .bento-action {
            background: linear-gradient(135deg, #4f46e5 0%, #38bdf8 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .bento-action::after {
            content: '';
            position: absolute;
            right: -10%;
            top: -20%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .btn-bento-white {
            background: white;
            color: var(--brand-primary);
            font-weight: 800;
            border-radius: 99px;
            padding: 0.75rem 1.5rem;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: max-content;
        }

        .btn-bento-white:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            color: var(--brand-primary);
        }

        /* --- STATS BENTO --- */
        .bento-stat {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--brand-dark);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* --- BENTO TABLE --- */
        .bento-table-wrapper {
            padding: 0.5rem;
        }

        .table-bento {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 1rem !important;
        }

        .table-bento th {
            background: transparent !important;
            color: #94a3b8 !important;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            border-bottom: 1px dashed var(--bento-border);
        }

        .table-bento td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px dashed #f1f5f9;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .table-bento tbody tr {
            transition: background-color 0.2s;
        }

        .table-bento tbody tr:hover {
            background-color: #f8fafc;
        }

        .table-bento tbody tr:last-child td {
            border-bottom: none;
        }

        .issue-text {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
            color: #475569;
            max-width: 320px;
        }

        .tindakan-text {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: #64748b;
            font-size: 0.75rem;
            margin-top: 6px;
        }

        /* --- BADGES & DOTS --- */
        .bento-badge {
            padding: 0.4rem 0.85rem;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            letter-spacing: 0.03em;
        }

        .bg-soft-danger {
            background-color: #fee2e2;
            color: #e11d48;
        }

        .bg-soft-warning {
            background-color: #fef3c7;
            color: #d97706;
        }

        .bg-soft-success {
            background-color: #d1fae5;
            color: #059669;
        }

        .bg-soft-dark {
            background-color: #f1f5f9;
            color: #475569;
        }

        .bg-soft-primary {
            background-color: #e0e7ff;
            color: #4f46e5;
        }

        .sev-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.8);
        }

        .sev-Critical {
            background-color: #e11d48;
        }

        .sev-High {
            background-color: #d97706;
        }

        .sev-Medium {
            background-color: #4f46e5;
        }

        .sev-Low {
            background-color: #059669;
        }

        /* --- DATATABLES UI OVERRIDES --- */
        .dataTables_wrapper .row {
            align-items: center;
            padding: 0 1rem;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            border: 1px solid var(--bento-border);
            border-radius: 99px;
            padding: 0.5rem 1.25rem;
            font-size: 0.875rem;
            color: var(--text-main);
            background: #f8fafc;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: 0.2s;
            width: 260px;
        }

        div.dataTables_wrapper div.dataTables_filter input:focus {
            border-color: var(--brand-primary);
            background: white;
            box-shadow: 0 0 0 4px #e0e7ff;
            outline: none;
        }

        div.dataTables_wrapper div.dataTables_length select {
            border: 1px solid var(--bento-border);
            border-radius: 12px;
            padding: 0.4rem 2rem 0.4rem 1rem;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--text-main);
            cursor: pointer;
        }

        .page-item .page-link {
            border: none;
            border-radius: 12px;
            margin: 0 3px;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.85rem;
            background: #f8fafc;
        }

        .page-item.active .page-link {
            background-color: var(--brand-dark);
            color: white;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.2);
        }

        .page-item.disabled .page-link {
            background-color: transparent;
            color: #cbd5e1;
        }

        .btn-dots {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: var(--text-muted);
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-dots:hover {
            background: var(--brand-primary);
            color: white;
            border-color: var(--brand-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
        }

        .dropdown-menu {
            border-radius: 16px;
            border: 1px solid var(--bento-border);
            box-shadow: var(--bento-shadow-hover);
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: 0.2s;
            margin-bottom: 2px;
        }

        .dropdown-item:hover {
            background-color: #f8fafc;
            color: var(--brand-primary);
        }
    </style>
@endpush

@section('content')
    {{-- ==== PERHITUNGAN STATISTIK DARI DATABASE ==== --}}
    @php
        $totalNcr = $ncrs->count();
        $statusOpen = $ncrs->where('status', 'Open')->count();
        $criticalOpen = $ncrs->where('severity', 'Critical')->where('status', 'Open')->count();
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y pb-4">

        <div class="mb-4 px-2">
            <h4 class="fw-bolder text-dark mb-1" style="font-size: 1.5rem; letter-spacing: -0.5px;">Master Data NCR</h4>
            <span class="text-muted fw-bold" style="font-size: 0.85rem;">Pusat Log Non-Conformance Report</span>
        </div>

        {{-- Alert Notifikasi Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show fw-bold shadow-sm" role="alert"
                style="border-radius: 16px;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="bento-grid">

            <div class="bento-box bento-action bento-span-6">
                <div class="position-relative z-1">
                    <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-25 rounded-pill px-3 py-1 mb-3"
                        style="backdrop-filter: blur(4px);">
                        <span class="spinner-grow spinner-grow-sm text-white" style="width: 8px; height: 8px;"></span>
                        <span class="text-white fw-bold"
                            style="font-size: 0.7rem; letter-spacing: 1px; text-transform: uppercase;">Live Database</span>
                    </div>
                    <h3 class="fw-bolder text-white mb-2" style="font-size: 1.75rem; letter-spacing: -0.5px;">Kelola Laporan
                        NCR</h3>
                    <p class="text-white-50 fw-medium mb-4" style="font-size: 0.95rem; max-width: 90%;">Buat laporan
                        ketidaksesuaian baru untuk mendokumentasikan temuan audit dan inspeksi.</p>

                    <a href="{{ route('ncr.create') }}" class="btn-bento-white text-decoration-none">
                        <i class="bi bi-plus-circle-fill fs-5"></i> Tambah NCR Baru
                    </a>
                </div>
            </div>

            <div class="bento-box bento-stat bento-span-2">
                <div class="stat-icon bg-soft-dark text-dark"><i class="bi bi-folder2-open"></i></div>
                <div>
                    <div class="stat-value">{{ $totalNcr }}</div>
                    <div class="stat-label">Total Data</div>
                </div>
            </div>

            <div class="bento-box bento-stat bento-span-2">
                <div class="stat-icon bg-soft-danger text-danger"><i class="bi bi-fire"></i></div>
                <div>
                    <div class="stat-value text-danger">{{ $statusOpen }}</div>
                    <div class="stat-label">Status Open</div>
                </div>
            </div>

            <div class="bento-box bento-stat bento-span-2">
                <div class="stat-icon bg-soft-warning text-warning"><i class="bi bi-exclamation-triangle"></i></div>
                <div>
                    <div class="stat-value text-warning">{{ $criticalOpen }}</div>
                    <div class="stat-label">Critical Open</div>
                </div>
            </div>

            <div class="bento-box bento-span-12 p-0 pb-3">
                <div class="bento-table-wrapper pt-4">
                    <table id="ncrTable" class="table table-bento">
                        <thead>
                            <tr>
                                <th width="20%">Dokumen & Kode</th>
                                <th width="30%">Detail Temuan</th>
                                <th width="14%">Scope & Reff</th>
                                <th width="12%">Severity</th>
                                <th width="12%">Status</th>
                                <th width="12%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ncrs as $ncr)
                                @php
                                    $issueDate = \Carbon\Carbon::parse($ncr->issue_date);

                                    // Styling Scope (Ikon)
                                    $scopeIcon = 'bi-building';
                                    if ($ncr->audit_scope == 'External') {
                                        $scopeIcon = 'bi-globe';
                                    } elseif ($ncr->audit_scope == 'Supplier') {
                                        $scopeIcon = 'bi-box-seam';
                                    }

                                    // Styling Status
                                    $statusBadge = '';
                                    $statusIcon = '';
                                    if ($ncr->status == 'Open') {
                                        $statusBadge = 'bg-soft-danger';
                                        $statusIcon = 'bi-fire';
                                    } elseif ($ncr->status == 'Monitoring') {
                                        $statusBadge = 'bg-soft-warning';
                                        $statusIcon = 'bi-search';
                                    } else {
                                        $statusBadge = 'bg-soft-success';
                                        $statusIcon = 'bi-check2-all';
                                    }

                                    // Styling Severity Text Color
                                    $sevColor = '';
                                    if ($ncr->severity == 'Critical') {
                                        $sevColor = 'text-danger';
                                    } elseif ($ncr->severity == 'High') {
                                        $sevColor = 'text-warning';
                                    } elseif ($ncr->severity == 'Medium') {
                                        $sevColor = 'text-primary';
                                    } else {
                                        $sevColor = 'text-success';
                                    }
                                @endphp
                                <tr>
                                    <td data-sort="{{ $issueDate->format('Y-m-d H:i:s') }}">
                                        <div class="fw-bolder text-dark" style="font-size: 0.95rem;">
                                            {{ $ncr->no_ncr }}
                                        </div>
                                        <div class="text-primary fw-bold mt-1 d-inline-block px-2 py-1 rounded-2 bg-soft-primary"
                                            style="font-size: 0.7rem;">
                                            <i class="bi bi-upc-scan me-1"></i> {{ $ncr->id_ncr ?? '-' }}
                                        </div>
                                        <div class="text-muted fw-bold mt-2" style="font-size: 0.75rem;">
                                            <i class="bi bi-receipt me-1"></i> {{ $ncr->no_po ?? '-' }} &bull;
                                            {{ $ncr->qty ?? 0 }} Pcs
                                        </div>
                                        <div class="text-muted fw-bold mt-1" style="font-size: 0.75rem;">
                                            <i class="bi bi-calendar2-event me-1"></i> {{ $issueDate->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="issue-text" title="{{ $ncr->issue }}">
                                            {{ $ncr->issue }}
                                        </div>
                                        <div class="tindakan-text" title="Tindakan: {{ $ncr->tindakan }}">
                                            <span class="text-primary fw-bold">Act:</span>
                                            {{ $ncr->tindakan ?? 'Belum ada tindakan' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="bento-badge bg-soft-dark text-muted mb-1 w-100 justify-content-center">
                                            <i class="bi {{ $scopeIcon }}"></i> {{ $ncr->audit_scope }}
                                        </span>
                                        <div class="text-center text-muted fw-bold mt-1"
                                            style="font-size: 0.7rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                            title="{{ $ncr->report_reff }}">
                                            <i class="bi bi-link-45deg"></i> {{ $ncr->report_reff ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2 fw-bolder {{ $sevColor }}"
                                            style="font-size: 0.8rem;">
                                            <span class="sev-dot sev-{{ $ncr->severity }}"></span>
                                            {{ $ncr->severity }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="bento-badge {{ $statusBadge }}">
                                            <i class="bi {{ $statusIcon }}"></i> {{ $ncr->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn-dots" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end mt-2">
                                                {{-- Tombol Lihat Detail yang sudah diubah menjadi trigger Modal --}}
                                                <button type="button"
                                                    class="dropdown-item btn-show-modal text-start w-100 border-0 bg-transparent"
                                                    data-bs-toggle="modal" data-bs-target="#ncrDetailModal"
                                                    data-id_ncr="{{ $ncr->id_ncr ?? '-' }}"
                                                    data-no_ncr="{{ $ncr->no_ncr }}"
                                                    data-no_po="{{ $ncr->no_po ?? '-' }}"
                                                    data-issue="{{ $ncr->issue }}"
                                                    data-tindakan="{{ $ncr->tindakan ?? 'Belum ada tindakan' }}"
                                                    data-audit_scope="{{ $ncr->audit_scope }}"
                                                    data-report_reff="{{ $ncr->report_reff ?? '-' }}"
                                                    data-severity="{{ $ncr->severity }}"
                                                    data-status="{{ $ncr->status }}"
                                                    data-issue_date="{{ $issueDate->format('d M Y') }}"
                                                    data-qty="{{ $ncr->qty ?? 0 }}">
                                                    <i class="bi bi-eye text-primary me-2"></i> Lihat Detail
                                                </button>

                                                <a class="dropdown-item" href="{{ route('ncr.edit', $ncr->id) }}">
                                                    <i class="bi bi-pencil-square text-warning me-2"></i> Edit Laporan
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('ncr.destroy', $ncr->id) }}" method="POST"
                                                    class="m-0"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus NCR ini? Aksi ini tidak dapat dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                                        <i class="bi bi-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ==== MODAL DETAIL NCR ==== --}}
    <div class="modal fade" id="ncrDetailModal" tabindex="-1" aria-labelledby="ncrDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content"
                style="border-radius: var(--bento-radius); border: none; box-shadow: var(--bento-shadow-hover);">
                <div class="modal-header border-bottom-0 pt-4 px-4 pb-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-soft-dark text-dark m-0" style="width: 48px; height: 48px;">
                            <i class="bi bi-file-earmark-text fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bolder mb-1" id="ncrDetailModalLabel" style="font-size: 1.25rem;">
                                Detail Laporan NCR</h5>
                            <span class="text-muted fw-bold" style="font-size: 0.8rem;">
                                <i class="bi bi-upc-scan"></i> <span id="modal-id_ncr"></span> &bull; Doc: <span
                                    id="modal-no_ncr"></span>
                            </span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <span class="text-muted fw-bold d-block mb-1"
                                style="font-size: 0.75rem; text-transform: uppercase;">Tanggal Issue</span>
                            <div class="fw-bolder text-dark" style="font-size: 0.95rem;" id="modal-issue_date"></div>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted fw-bold d-block mb-1"
                                style="font-size: 0.75rem; text-transform: uppercase;">No. PO</span>
                            <div class="fw-bolder text-dark" style="font-size: 0.95rem;" id="modal-no_po"></div>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted fw-bold d-block mb-1"
                                style="font-size: 0.75rem; text-transform: uppercase;">Quantity</span>
                            <div class="fw-bolder text-dark" style="font-size: 0.95rem;" id="modal-qty"></div>
                        </div>

                        <div class="col-md-4">
                            <span class="text-muted fw-bold d-block mb-1"
                                style="font-size: 0.75rem; text-transform: uppercase;">Scope Audit</span>
                            <div class="fw-bolder text-dark" style="font-size: 0.95rem;" id="modal-audit_scope"></div>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted fw-bold d-block mb-1"
                                style="font-size: 0.75rem; text-transform: uppercase;">Severity</span>
                            <div class="fw-bolder" style="font-size: 0.95rem;" id="modal-severity"></div>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted fw-bold d-block mb-1"
                                style="font-size: 0.75rem; text-transform: uppercase;">Status</span>
                            <div class="fw-bolder text-dark" style="font-size: 0.95rem;" id="modal-status"></div>
                        </div>

                        <div class="col-12">
                            <span class="text-muted fw-bold d-block mb-2"
                                style="font-size: 0.75rem; text-transform: uppercase;">Report Reference</span>
                            <div class="p-3 bg-light rounded-3 fw-medium text-dark" style="font-size: 0.85rem;"
                                id="modal-report_reff"></div>
                        </div>

                        <div class="col-12">
                            <span class="text-muted fw-bold d-block mb-2"
                                style="font-size: 0.75rem; text-transform: uppercase;">Detail Temuan (Issue)</span>
                            <div class="p-3 bg-soft-danger bg-opacity-10 border rounded-3 fw-medium text-dark"
                                style="font-size: 0.9rem; line-height: 1.6;" id="modal-issue"></div>
                        </div>

                        <div class="col-12">
                            <span class="text-muted fw-bold d-block mb-2"
                                style="font-size: 0.75rem; text-transform: uppercase;">Tindakan Perbaikan</span>
                            <div class="p-3 bg-soft-success bg-opacity-10 border rounded-3 fw-medium text-dark"
                                style="font-size: 0.9rem; line-height: 1.6;" id="modal-tindakan"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill fw-bold px-4 border"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#ncrTable').DataTable({
                pageLength: 10,
                ordering: true,
                order: [
                    [0, 'desc']
                ],
                dom: '<"row mt-1 mb-4"<"col-md-6"l><"col-md-6 d-flex justify-content-end"f>>t<"row mt-4 mb-2"<"col-md-6 text-muted"i><"col-md-6 d-flex justify-content-end"p>>',
                language: {
                    search: "",
                    searchPlaceholder: "Cari ID NCR, Dokumen, PO...",
                    lengthMenu: "Tampil _MENU_ baris",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data tersedia",
                    zeroRecords: "Pencarian tidak ditemukan",
                    paginate: {
                        next: '<i class="bi bi-chevron-right"></i>',
                        previous: '<i class="bi bi-chevron-left"></i>'
                    }
                },
                drawCallback: function() {
                    $('.dataTables_paginate .pagination').addClass('gap-1');
                }
            });

            // Event listener untuk tombol "Lihat Detail" memunculkan Modal
            $(document).on('click', '.btn-show-modal', function() {
                // Ambil data dari atribut data-*
                let id_ncr = $(this).data('id_ncr');
                let no_ncr = $(this).data('no_ncr');
                let no_po = $(this).data('no_po');
                let issue = $(this).data('issue');
                let tindakan = $(this).data('tindakan');
                let audit_scope = $(this).data('audit_scope');
                let report_reff = $(this).data('report_reff');
                let severity = $(this).data('severity');
                let status = $(this).data('status');
                let issue_date = $(this).data('issue_date');
                let qty = $(this).data('qty');

                // Masukkan data ke dalam elemen Modal
                $('#modal-id_ncr').text(id_ncr);
                $('#modal-no_ncr').text(no_ncr);
                $('#modal-no_po').text(no_po);
                $('#modal-qty').text(qty + ' Pcs');
                $('#modal-issue_date').text(issue_date);
                $('#modal-audit_scope').text(audit_scope);
                $('#modal-report_reff').text(report_reff);
                $('#modal-issue').text(issue);
                $('#modal-tindakan').text(tindakan);
                $('#modal-status').text(status);

                // Styling khusus untuk teks Severity di dalam modal
                let modalSev = $('#modal-severity');
                modalSev.text(severity);
                modalSev.removeClass('text-danger text-warning text-primary text-success'); // reset class

                if (severity === 'Critical') {
                    modalSev.addClass('text-danger');
                } else if (severity === 'High') {
                    modalSev.addClass('text-warning');
                } else if (severity === 'Medium') {
                    modalSev.addClass('text-primary');
                } else {
                    modalSev.addClass('text-success');
                }
            });
        });
    </script>
@endpush
