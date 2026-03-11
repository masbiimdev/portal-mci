@extends('layouts.admin')
@section('title', 'History Kalibrasi | QC Calibration')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-main);
        }

        /* ============== WIDGET HEADER ============== */
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .stat-widget {
            background: var(--card-bg);
            border: 1px solid var(--border);
            padding: 0.75rem 1.5rem;
            border-radius: 14px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-widget .icon-box {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #e0e7ff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        /* ============== CARD & CUSTOM SEARCH ============== */
        .premium-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .card-toolbar {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Custom Search Input */
        .custom-search {
            position: relative;
            width: 100%;
            max-width: 350px;
        }

        .custom-search i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.2rem;
        }

        .custom-search input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #f8fafc;
            font-size: 0.9rem;
            transition: all 0.2s;
            outline: none;
        }

        .custom-search input:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        /* ============== TABLE PREMIUM STYLING ============== */
        /* Sembunyikan default element DataTables */
        .dataTables_filter {
            display: none;
        }

        .dataTables_length {
            padding: 1.5rem 1.5rem 0 1.5rem;
        }

        .dataTables_info {
            padding: 1.5rem;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .dataTables_paginate {
            padding: 1.5rem;
        }

        .table-premium {
            width: 100% !important;
            border-collapse: collapse;
            margin: 0 !important;
        }

        .table-premium thead th {
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .table-premium tbody tr {
            transition: all 0.2s ease;
            position: relative;
        }

        .table-premium tbody tr::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: transparent;
            transition: all 0.2s ease;
        }

        .table-premium tbody tr:hover {
            background-color: #f8fafc !important;
        }

        .table-premium tbody tr:hover::after {
            background: var(--primary);
        }

        .table-premium td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border);
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        /* ============== MODERN BADGES ============== */
        .badge-modern {
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        /* Dot Indicator within badge */
        .badge-modern::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-danger::before {
            background: #dc2626;
            box-shadow: 0 0 0 2px #fca5a5;
        }

        .badge-warning {
            background: #fef3c7;
            color: #b45309;
        }

        .badge-warning::before {
            background: #d97706;
            box-shadow: 0 0 0 2px #fcd34d;
        }

        .badge-info {
            background: #e0f2fe;
            color: #0369a1;
        }

        .badge-info::before {
            background: #0284c7;
            box-shadow: 0 0 0 2px #7dd3fc;
        }

        .badge-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        .badge-secondary::before {
            background: #64748b;
            box-shadow: 0 0 0 2px #cbd5e1;
        }

        /* ============== ACTION BUTTONS ============== */
        .action-group {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.2s;
            border: 1px solid transparent;
            text-decoration: none;
        }

        .btn-pdf {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-pdf:hover {
            background: #fca5a5;
            color: #991b1b;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(220, 38, 38, 0.2);
        }

        .btn-add {
            background: #e0e7ff;
            color: #4f46e5;
            border: 1px dashed #a5b4fc;
        }

        .btn-add:hover {
            background: #4f46e5;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
        }

        .btn-edit {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid var(--border);
        }

        .btn-edit:hover {
            background: #e2e8f0;
            color: #0f172a;
            transform: translateY(-2px);
        }

        /* Pagination Styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            padding: 0.4rem 0.8rem !important;
            border: 1px solid transparent !important;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary) !important;
            color: white !important;
            border-color: var(--primary) !important;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
            background: #f1f5f9 !important;
            color: var(--text-dark) !important;
        }

        /* Modal Iframe */
        .iframe-wrapper {
            background: #cbd5e1;
            height: 75vh;
            width: 100%;
            border-radius: 0 0 16px 16px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="page-header">
            <div>
                <h4 class="fw-extrabold mb-1" style="color: var(--text-dark); font-size: 1.6rem; letter-spacing: -0.02em;">
                    History Kalibrasi</h4>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">Pantau jadwal dan arsip sertifikat kalibrasi
                    instrumen Anda.</p>
            </div>

            <div class="stat-widget">
                <div class="icon-box"><i class="bx bx-slider-alt"></i></div>
                <div>
                    <span class="d-block text-muted"
                        style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">Total Instrumen</span>
                    <span class="d-block fw-extrabold" style="font-size: 1.2rem; color: var(--text-dark); line-height: 1;">
                        {{ $tools->count() }} <span
                            style="font-size: 0.8rem; font-weight: 500; color: var(--text-muted);">Item</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="premium-card">

            <div class="card-toolbar">
                <h5 class="m-0 fw-bold" style="font-size: 1.1rem; color: var(--text-dark);">Daftar Instrumen</h5>

                <div class="custom-search">
                    <i class="bx bx-search"></i>
                    <input type="text" id="customSearchBox" placeholder="Cari nama alat atau No. Seri...">
                </div>
            </div>

            <div class="table-responsive">
                <table id="historyTable" class="table-premium display dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>Instrumen</th>
                            <th>Status Jadwal</th>
                            <th>Jadwal Ulang</th>
                            <th>Interval</th>
                            <th class="text-center">Sertifikat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tools as $tool)
                            @php
                                $lastHistory = $tool->histories->sortByDesc('tgl_kalibrasi_ulang')->first();
                                $diff = 0;

                                // Set angka raksasa agar item tanpa tanggal jatuh di paling bawah tabel
                                $sortDate = 9999999999;

                                if ($lastHistory && $lastHistory->tgl_kalibrasi_ulang) {
                                    $today = \Carbon\Carbon::now()->startOfDay();
                                    $kalibrasi = \Carbon\Carbon::parse($lastHistory->tgl_kalibrasi_ulang)->startOfDay();
                                    $diff = $today->diffInDays($kalibrasi, false);

                                    // Set Timestamp untuk akurasi sorting
                                    $sortDate = $kalibrasi->timestamp;
                                }
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded-3"
                                            style="width: 40px; height: 40px; border: 1px solid var(--border);">
                                            <i class="bx bx-wrench text-muted fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="color: var(--text-dark);">{{ $tool->nama_alat }}
                                            </div>
                                            <div
                                                style="font-size: 0.8rem; color: var(--text-muted); font-family: monospace; margin-top: 2px;">
                                                {{ $tool->merek ?? 'No Brand' }} &bull; SN: <span
                                                    class="text-dark fw-semibold">{{ $tool->no_seri ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @if ($lastHistory && $lastHistory->tgl_kalibrasi_ulang)
                                        @if ($diff < 0)
                                            <span class="badge-modern badge-danger">Terlewat {{ abs($diff) }} Hari</span>
                                        @elseif ($diff >= 0 && $diff <= 30)
                                            <span class="badge-modern badge-warning">Segera ({{ $diff }}
                                                Hari)</span>
                                        @elseif($diff > 30)
                                            <span class="badge-modern badge-info">Aman ({{ $diff }} Hari)</span>
                                        @endif
                                    @else
                                        <span class="badge-modern badge-secondary">Belum ada jadwal</span>
                                    @endif
                                </td>

                                <td data-sort="{{ $sortDate }}">
                                    @if ($lastHistory && $lastHistory->tgl_kalibrasi_ulang)
                                        <div class="fw-bold text-dark">
                                            {{ \Carbon\Carbon::parse($lastHistory->tgl_kalibrasi_ulang)->format('d M Y') }}
                                        </div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            {{ \Carbon\Carbon::parse($lastHistory->tgl_kalibrasi_ulang)->diffForHumans() }}
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 rounded-2"
                                        style="font-weight: 600; font-size: 0.8rem;">
                                        <i
                                            class="bx bx-timer text-muted me-1"></i>{{ $lastHistory->interval_kalibrasi ?? '-' }}
                                        Bln
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if ($lastHistory && $lastHistory->file_sertifikat)
                                        <button class="btn-icon btn-pdf" data-bs-toggle="modal"
                                            data-bs-target="#pdfModal_{{ $lastHistory->id }}" title="Lihat Sertifikat PDF">
                                            <i class="bx bxs-file-pdf"></i>
                                        </button>
                                    @else
                                        <span class="text-muted" style="font-size: 0.8rem;">-</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="action-group">
                                        @if ($tool->histories->count() == 0)
                                            <a href="{{ route('histories.create', ['tool_id' => $tool->id, 'from' => 'index']) }}"
                                                class="btn-icon btn-add" title="Input Data Kalibrasi">
                                                <i class="bx bx-plus"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('histories.show', $tool->id) }}" class="btn-icon btn-edit"
                                                title="Update / Lihat Riwayat">
                                                <i class="bx bx-history"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @if ($lastHistory && $lastHistory->file_sertifikat)
                                <div class="modal fade modal-premium" id="pdfModal_{{ $lastHistory->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="bg-danger bg-opacity-10 p-2 rounded-3 text-danger fs-4">
                                                        <i class="bx bxs-file-pdf"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="modal-title m-0">Sertifikat Kalibrasi</h5>
                                                        <span class="text-muted"
                                                            style="font-size: 0.85rem;">{{ $tool->nama_alat }} (SN:
                                                            {{ $tool->no_seri ?? '-' }})</span>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0 iframe-wrapper">
                                                <iframe src="{{ asset('storage/' . $lastHistory->file_sertifikat) }}"
                                                    width="100%" height="100%" style="border: none;"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            var table = $('#historyTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                // MENGURUTKAN OTOMATIS: Kolom index 2 (Jadwal Ulang) secara Ascending
                order: [
                    [2, 'asc']
                ],
                language: {
                    lengthMenu: "Tampilkan _MENU_ baris",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ instrumen",
                    infoEmpty: "Tidak ada data tersedia",
                    zeroRecords: "Instrumen tidak ditemukan",
                    paginate: {
                        previous: "<i class='bx bx-chevron-left'></i>",
                        next: "<i class='bx bx-chevron-right'></i>"
                    }
                },
                columnDefs: [{
                    // Hilangkan panah sorting di kolom Sertifikat (4) dan Aksi (5)
                    orderable: false,
                    targets: [4, 5]
                }],
                drawCallback: function() {
                    // Merapikan dropdown length (Show entries)
                    $('.dataTables_length select').addClass('form-select form-select-sm').css({
                        'display': 'inline-block',
                        'width': 'auto',
                        'margin': '0 8px',
                        'border-radius': '8px'
                    });
                }
            });

            // Menyambungkan Custom Search Box buatan kita ke Engine DataTables
            $('#customSearchBox').on('keyup', function() {
                table.search(this.value).draw();
            });

            // SweetAlert untuk notifikasi sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false,
                    background: '#ffffff',
                    color: '#0f172a',
                    iconColor: '#10b981',
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0'
                    }
                });
            @endif
        });
    </script>
@endpush
