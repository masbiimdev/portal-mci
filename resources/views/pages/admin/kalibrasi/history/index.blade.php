@extends('layouts.admin')
@section('title', 'History Kalibrasi | QC Calibration')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        table.dataTable td,
        table.dataTable th {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Highlight row berdasarkan status */
        .row-no-history {
            background-color: #f8f9fa;
        }

        .row-history-no-pdf {
            background-color: #fff3cd;
            /* oranye muda */
        }

        .row-history-pdf {
            background-color: #d1e7dd;
            /* hijau muda */
        }

        /* Modal premium putih bersih */
        .modal-premium .modal-content {
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            background: #ffffff;
            overflow: hidden;
        }

        /* Header putih bersih */
        .modal-premium .modal-header {
            background: #ffffff;
            border-bottom: 1px solid #e6e6e6;
            padding: 14px 20px;
        }

        /* Title */
        .modal-premium .modal-title {
            font-weight: 600;
            color: #333;
        }

        /* Close button abu (bukan putih/biru) */
        .modal-premium .btn-close {
            filter: brightness(0);
            opacity: 0.6;
        }

        .modal-premium .btn-close:hover {
            opacity: 1;
        }

        /* Body */
        .modal-premium .modal-body {
            padding: 0 !important;
            background: #fafafa;
        }

        .custom-close-btn {
            filter: none !important;
            /* Hilangkan filter bawaan Bootstrap */
            opacity: 1 !important;
            /* Biar tidak transparan */
            background-size: 16px !important;
        }

        .custom-close-btn:hover {
            opacity: 0.7 !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">QC / Kalibrasi /</span> History Kalibrasi
        </h4>

        <div class="card p-3">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Daftar History Kalibrasi Item</h4>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table id="historyTable" class="table table-striped table-bordered table-hover">
                    <thead style="background-color: #f8f9fa; font-weight: 600;">
                        <tr>
                            <th>Nama Item</th>
                            <th>Merek</th>
                            <th>No Seri</th>
                            <th>Status Kalibrasi Item</th>
                            <th>Tanggal Kalibrasi Ulang</th>
                            <th>Interval Kalibrasi</th>
                            <th>Sertifikat</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tools as $tool)
                            @php
                                // Ambil history terakhir (tgl_kalibrasi_ulang terbaru)
                                $lastHistory = $tool->histories->sortByDesc('tgl_kalibrasi_ulang')->first();

                                // Tentukan kelas row
                                $rowClass = '';
                                if (!$lastHistory) {
                                    $rowClass = 'row-no-history';
                                } elseif ($lastHistory && !$lastHistory->file_sertifikat) {
                                    $rowClass = 'row-history-no-pdf';
                                } else {
                                    $rowClass = 'row-history-pdf';
                                }
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>{{ $tool->nama_alat }}</td>
                                <td>{{ $tool->merek ?? '-' }}</td>
                                <td>{{ $tool->no_seri ?? '-' }}</td>

                                {{-- Status Item --}}
                                <td>
                                    @if ($lastHistory && $lastHistory->tgl_kalibrasi_ulang)
                                        @php
                                            $today = \Carbon\Carbon::now();
                                            $kalibrasi = \Carbon\Carbon::parse($lastHistory->tgl_kalibrasi_ulang);
                                            $diff = $today->diffInDays($kalibrasi, false); // negatif jika sudah lewat
                                        @endphp

                                        @if ($diff > 0 && $diff <= 30)
                                            <span class="badge bg-warning text-white ms-1">
                                                <i class='bx bx-calendar-event'></i> Penjadwalan
                                            </span>
                                        @elseif($diff > 30)
                                            <span class="badge bg-info text-white ms-1">
                                                <i class='bx bx-calendar-event'></i> {{ $diff }} hari lagi
                                            </span>
                                        @elseif($diff >= -7 && $diff <= 7)
                                            <span class="badge bg-primary text-white ms-1">
                                                <i class='bx bx-time-five'></i> Di Proses
                                            </span>
                                        @elseif($diff < 0 && abs($diff) > 8)
                                            <span class="badge bg-success text-white ms-1">
                                                <i class='bx bx-check-circle'></i> Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-secondary text-white ms-1">
                                                <i class='bx bx-minus-circle'></i> -
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary text-white ms-1">
                                            <i class='bx bx-minus-circle'></i> -
                                        </span>
                                    @endif
                                </td>

                                {{-- Tanggal Kalibrasi Terakhir --}}
                                <td>
                                    @if ($lastHistory && $lastHistory->tgl_kalibrasi_ulang)
                                        {{ \Carbon\Carbon::parse($lastHistory->tgl_kalibrasi_ulang)->format('d/m/Y') }}
                                    @endif
                                </td>
                                <td>
                                    {{ $lastHistory->interval_kalibrasi ?? '-' }}
                                </td>


                                {{-- Status PDF --}}
                                <td>
                                    @if ($lastHistory && $lastHistory->file_sertifikat)
                                        <span class="badge bg-success">Tersedia</span>

                                        <button class="btn btn-sm btn-outline-primary rounded-pill ms-1 px-2 py-1"
                                            data-bs-toggle="modal" data-bs-target="#pdfModal_{{ $lastHistory->id }}">
                                            <i class="bx bx-show bx-xs"></i>
                                        </button>
                                    @elseif($lastHistory)
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Ada History</span>
                                    @endif

                                </td>
                                @if ($lastHistory && $lastHistory->file_sertifikat)
                                    <div class="modal fade" id="pdfModal_{{ $lastHistory->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                            <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">

                                                <div class="modal-header"
                                                    style="background: #ffffff; border-bottom: 1px solid #eee;">
                                                    <h5 class="modal-title fw-semibold">Preview Sertifikat PDF</h5>

                                                    <!-- Tombol Close yang lebih jelas -->
                                                    <button type="button" class="btn-close custom-close-btn"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body p-0" style="height: 80vh; background: #fff;">
                                                    <iframe src="{{ asset('storage/' . $lastHistory->file_sertifikat) }}"
                                                        width="100%" height="100%" style="border: none;">
                                                    </iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif



                                {{-- Aksi --}}
                                <td class="text-center">
                                    @if ($tool->histories->count() == 0)
                                        <a href="{{ route('histories.create', ['tool_id' => $tool->id, 'from' => 'index']) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-plus-circle"></i> Tambah
                                        </a>
                                    @else
                                        <a href="{{ route('histories.show', $tool->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Update
                                        </a>
                                    @endif
                                </td>
                            </tr>
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

            // DataTable
            $('#historyTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                order: [] // Urutkan berdasarkan kolom Tanggal Kalibrasi Terakhir
            });

            // Success alert
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 2300,
                    showConfirmButton: false
                });
            @endif

        });
    </script>
@endpush
