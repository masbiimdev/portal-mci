@extends('layouts.admin')
@section('title', 'Master Alat | QC Calibration')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        /* Card & Header Styling */
        .card-custom {
            border: 0;
            box-shadow: 0 4px 15px 0 rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }

        .card-header-custom {
            background-color: #fff;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.5rem;
            border-radius: 12px 12px 0 0;
        }

        /* Table Styling */
        .table-modern {
            width: 100% !important;
            margin-bottom: 0;
        }

        .table-modern thead th {
            background-color: #f8fafc !important;
            color: #64748b !important;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0 !important;
            padding: 1rem 1.25rem;
            white-space: nowrap;
        }

        .table-modern tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            color: #475569;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }

        .table-modern tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* Typography & Badges */
        .tool-name {
            font-weight: 700;
            color: #1e293b;
        }

        .text-meta {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .date-badge {
            display: inline-block;
            padding: 0.35rem 0.6rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .date-badge-warning {
            background-color: #fef2f2;
            color: #dc2626;
            border-color: #fecdd3;
        }

        /* QR Thumbnail */
        .qr-thumbnail {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
            background-color: #fff;
            padding: 2px;
        }

        .qr-thumbnail:hover {
            transform: scale(1.5);
            z-index: 10;
            position: relative;
        }

        /* Action Buttons */
        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            border: none;
        }

        .btn-action-detail {
            background-color: #e0f2fe;
            color: #0284c7;
        }

        .btn-action-detail:hover {
            background-color: #0284c7;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-action-edit {
            background-color: #f0fdf4;
            color: #16a34a;
        }

        .btn-action-edit:hover {
            background-color: #16a34a;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-action-delete {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .btn-action-delete:hover {
            background-color: #dc2626;
            color: #fff;
            transform: translateY(-2px);
        }

        /* Customizing DataTables Pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #696cff !important;
            color: white !important;
            border: none;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Quality Control / Kalibrasi /</span> Daftar Alat
        </h4>

        <div class="card card-custom">

            <div
                class="card-header-custom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h5 class="mb-1 fw-bold text-dark"><i class="bx bx-wrench text-primary me-2"></i>Master Data Alat</h5>
                    <p class="mb-0 text-muted small">Kelola informasi alat, jadwal kalibrasi, dan generate QR Code.</p>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('tools.printAll') }}" target="_blank"
                        class="btn btn-outline-secondary shadow-sm fw-semibold">
                        <i class="bx bx-printer me-1"></i> Cetak QR Massal
                    </a>
                    <a href="{{ route('tools.create') }}" class="btn btn-primary shadow-sm fw-semibold">
                        <i class="bx bx-plus-circle me-1"></i> Tambah Alat
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive p-4 pt-2">
                    <table id="toolsTable" class="table table-modern">
                        <thead>
                            <tr>
                                <th width="3%" class="text-center">No</th>
                                <th width="25%">Informasi Alat</th>
                                <th width="15%">Detail Spesifikasi</th>
                                <th width="15%" class="text-center">Kalibrasi Terakhir</th>
                                <th width="15%" class="text-center">Kalibrasi Berikutnya</th>
                                <th width="10%" class="text-center">QR Code</th>
                                <th width="17%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tools as $index => $tool)
                                @php
                                    $history = $tool->latestHistory;

                                    // Logika Peringatan Kalibrasi (Merah jika kurang dari 30 hari atau sudah lewat)
                                    $isWarning = false;
                                    if ($history && $history->tgl_kalibrasi_ulang) {
                                        $nextCalDate = \Carbon\Carbon::parse($history->tgl_kalibrasi_ulang);
                                        $daysLeft = now()->diffInDays($nextCalDate, false);
                                        if ($daysLeft <= 30) {
                                            $isWarning = true;
                                        }
                                    }
                                @endphp

                                <tr>
                                    <td class="text-center fw-semibold text-muted">{{ $index + 1 }}</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar avatar-sm me-3 bg-label-info rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bx bx-cog fs-5"></i>
                                            </div>
                                            <div>
                                                <div class="tool-name">{{ $tool->nama_alat }}</div>
                                                <div class="text-meta">Merek: {{ $tool->merek ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="text-dark fw-semibold">{{ $tool->no_seri ?? '-' }}</div>
                                        <div class="text-meta">
                                            <i class="bx bx-map text-muted"></i> {{ $tool->lokasi ?? '-' }} | Cap:
                                            {{ $tool->kapasitas ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        @if ($history && $history->tgl_kalibrasi)
                                            <span class="date-badge">
                                                <i class="bx bx-calendar-check me-1 text-success"></i>
                                                {{ \Carbon\Carbon::parse($history->tgl_kalibrasi)->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted italic">- Belum ada data -</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($history && $history->tgl_kalibrasi_ulang)
                                            <span class="date-badge {{ $isWarning ? 'date-badge-warning' : '' }}"
                                                {!! $isWarning ? 'data-bs-toggle="tooltip" title="Mendekati/Melewati Jadwal Kalibrasi!"' : '' !!}>
                                                <i class="bx bx-time-five me-1"></i>
                                                {{ \Carbon\Carbon::parse($history->tgl_kalibrasi_ulang)->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($tool->qr_code_path)
                                            <img src="{{ asset('storage/' . $tool->qr_code_path) }}" class="qr-thumbnail"
                                                alt="QR Code">
                                        @else
                                            <span class="badge bg-label-secondary" style="font-size: 0.65rem;">No QR</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{ route('tools.show', $tool->id) }}"
                                                class="btn-action btn-action-detail" data-bs-toggle="tooltip"
                                                title="Lihat History">
                                                <i class="bx bx-list-ul"></i>
                                            </a>

                                            <a href="{{ route('tools.edit', $tool->id) }}"
                                                class="btn-action btn-action-edit" data-bs-toggle="tooltip"
                                                title="Edit Data Alat">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>

                                            <form action="{{ route('tools.destroy', $tool->id) }}" method="POST"
                                                class="d-inline delete-form m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-delete"
                                                    data-bs-toggle="tooltip" title="Hapus Alat">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>

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
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // Inisialisasi Tooltips Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Setup DataTables
            $('#toolsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Semua"]
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                    searchPlaceholder: "Cari alat, merk, seri..."
                },
                columnDefs: [{
                        orderable: false,
                        targets: [5, 6]
                    } // Matikan sorting untuk kolom QR dan Aksi
                ]
            });

            // SweetAlert Konfirmasi Hapus
            $('#toolsTable').on('submit', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Hapus Data Alat?',
                    text: "Data alat dan seluruh history kalibrasinya akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        form.submit();
                    }
                });
            });

            // SweetAlert Notifikasi Sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
            @endif

        });
    </script>
@endpush
