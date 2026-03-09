@extends('layouts.admin')
@section('title', 'History Kalibrasi | QC Calibration')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        :root {
            --primary-blue: #4361ee;
            --soft-bg: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--soft-bg);
        }

        /* Card & Container */
        .card-history {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            background: #ffffff;
            padding: 1.5rem;
        }

        /* Table Styling */
        #historyTable {
            border: none !important;
            width: 100% !important;
        }

        #historyTable thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid var(--border-color);
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 12px 15px;
        }

        #historyTable tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border-color);
        }

        #historyTable tbody tr:hover {
            background-color: #f1f5f9 !important;
            transform: scale(1.002);
        }

        #historyTable td {
            padding: 15px;
            vertical-align: middle;
            color: #334155;
            border: none;
        }

        /* Status Badge Soft UI */
        .status-pill {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .pill-info {
            background: #e0f2fe;
            color: #0369a1;
        }

        .pill-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .pill-success {
            background: #dcfce7;
            color: #166534;
        }

        .pill-process {
            background: #e0e7ff;
            color: #4338ca;
        }

        .pill-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        /* PDF & Action Buttons */
        .btn-view-pdf {
            background: #ffffff;
            border: 1px solid var(--border-color);
            color: #475569;
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-view-pdf:hover {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }

        /* Modal Premium */
        .modal-premium .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .modal-premium .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-premium .modal-title {
            font-weight: 800;
            color: #1e293b;
        }

        .iframe-wrapper {
            background: #f8fafc;
            border-radius: 0 0 20px 20px;
            overflow: hidden;
            height: 75vh;
        }

        /* Custom scrollbar for DataTable */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 8px 12px;
            outline: none;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-extrabold mb-1">History Kalibrasi</h4>
                <p class="text-muted small mb-0">Manajemen records dan sertifikasi QC Calibration</p>
            </div>
            <div class="bg-white p-2 rounded-3 shadow-sm border">
                <span class="text-muted small px-2">Total Item: <strong>{{ $tools->count() }}</strong></span>
            </div>
        </div>

        <div class="card card-history">
            <div class="table-responsive">
                <table id="historyTable" class="table">
                    <thead>
                        <tr>
                            <th>Item & Identitas</th>
                            <th>Status Kalibrasi</th>
                            <th>Jadwal Ulang</th>
                            <th>Interval</th>
                            <th>Sertifikat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tools as $tool)
                            @php
                                $lastHistory = $tool->histories->sortByDesc('tgl_kalibrasi_ulang')->first();
                                $diff = 0;
                                if ($lastHistory && $lastHistory->tgl_kalibrasi_ulang) {
                                    $today = \Carbon\Carbon::now();
                                    $kalibrasi = \Carbon\Carbon::parse($lastHistory->tgl_kalibrasi_ulang);
                                    $diff = $today->diffInDays($kalibrasi, false);
                                }
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark"
                                            style="font-size: 0.95rem;">{{ $tool->nama_alat }}</span>
                                        <span class="text-muted extra-small">{{ $tool->merek ?? '-' }} &bull; SN:
                                            {{ $tool->no_seri ?? '-' }}</span>
                                    </div>
                                </td>

                                <td>
                                    @if ($lastHistory && $lastHistory->tgl_kalibrasi_ulang)
                                        @if ($diff > 0 && $diff <= 30)
                                            <span class="status-pill pill-warning"><i class='bx bxs-bell-ring'></i>
                                                Penjadwalan</span>
                                        @elseif($diff > 30)
                                            <span class="status-pill pill-info"><i class='bx bxs-calendar-check'></i>
                                                {{ $diff }} Hari Lagi</span>
                                        @elseif($diff >= -7 && $diff <= 7)
                                            <span class="status-pill pill-process"><i class='bx bx-sync bx-spin'></i> Di
                                                Proses</span>
                                        @elseif($diff < 0 && abs($diff) > 8)
                                            <span class="status-pill pill-success"><i class='bx bxs-check-shield'></i>
                                                Selesai</span>
                                        @else
                                            <span class="status-pill pill-secondary">-</span>
                                        @endif
                                    @else
                                        <span class="status-pill pill-secondary">Belum Ada History</span>
                                    @endif
                                </td>

                                <td class="fw-bold">
                                    {{ $lastHistory ? \Carbon\Carbon::parse($lastHistory->tgl_kalibrasi_ulang)->format('d/m/Y') : '-' }}
                                </td>

                                <td>
                                    <span class="badge bg-label-primary px-3">{{ $lastHistory->interval_kalibrasi ?? '-' }}
                                        Bulan</span>
                                </td>

                                <td>
                                    @if ($lastHistory && $lastHistory->file_sertifikat)
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-success small fw-bold">Tersedia</span>
                                            <button class="btn-view-pdf" data-bs-toggle="modal"
                                                data-bs-target="#pdfModal_{{ $lastHistory->id }}">
                                                <i class="bx bx-show-alt"></i>
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-muted small">N/A</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if ($tool->histories->count() == 0)
                                        <a href="{{ route('histories.create', ['tool_id' => $tool->id, 'from' => 'index']) }}"
                                            class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="bx bx-plus-circle me-1"></i> Tambah
                                        </a>
                                    @else
                                        <a href="{{ route('histories.show', $tool->id) }}"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                            <i class="bx bx-history me-1"></i> Update
                                        </a>
                                    @endif
                                </td>
                            </tr>

                            {{-- Modal PDF Premium --}}
                            @if ($lastHistory && $lastHistory->file_sertifikat)
                                <div class="modal fade modal-premium" id="pdfModal_{{ $lastHistory->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title d-flex align-items-center">
                                                    <i class="bx bxs-file-pdf text-danger fs-3 me-2"></i>
                                                    Sertifikat: {{ $tool->nama_alat }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#historyTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari item atau serial number...",
                    paginate: {
                        previous: "<i class='bx bx-chevron-left'></i>",
                        next: "<i class='bx bx-chevron-right'></i>"
                    }
                },
                columnDefs: [{
                    orderable: false,
                    targets: [4, 5]
                }]
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 2300,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-20'
                    }
                });
            @endif
        });
    </script>
@endpush
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        