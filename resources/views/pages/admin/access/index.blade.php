@extends('layouts.admin')
@section('title', 'Manajemen Modul | MCI')

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
        }

        .table-modern tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            color: #475569;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 0.9rem;
        }

        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }

        .table-modern tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* Badge Styling for Routes & Slugs */
        .badge-route {
            background-color: #e0e7ff;
            /* light indigo */
            color: #4338ca;
            font-family: monospace;
            font-size: 0.8rem;
            padding: 0.35rem 0.6rem;
            border-radius: 6px;
            font-weight: 600;
            border: 1px solid #c7d2fe;
        }

        .text-slug {
            color: #64748b;
            font-family: monospace;
            background: #f1f5f9;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
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
        }

        .btn-action-edit {
            background-color: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .btn-action-edit:hover {
            background-color: #16a34a;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-action-delete {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecdd3;
        }

        .btn-action-delete:hover {
            background-color: #dc2626;
            color: #fff;
            transform: translateY(-2px);
        }

        /* Customizing DataTables elements */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
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
            <span class="text-muted fw-light">Access Control /</span> Modul
        </h4>

        <div class="card card-custom">
            <div
                class="card-header-custom d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <div>
                    <h5 class="card-title mb-1 fw-bold text-dark"><i class="bx bx-list-ul text-primary me-2"></i>Daftar Modul
                        Sistem</h5>
                    <p class="card-subtitle text-muted small mb-0">Kelola semua rute dan modul untuk mengatur hak akses
                        operator.</p>
                </div>
                <a href="{{ route('modules.create') }}" class="btn btn-primary shadow-sm rounded-3 fw-semibold">
                    <i class="bx bx-plus me-1"></i> Tambah Modul
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive p-4 pt-2">
                    <table id="modulesTable" class="table table-modern">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="30%">Nama Modul</th>
                                <th width="25%">Slug URL</th>
                                <th width="25%">Route Name</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modules as $index => $module)
                                <tr>
                                    <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-initial rounded-circle bg-label-primary"><i
                                                        class="bx bx-cube"></i></span>
                                            </div>
                                            <span class="fw-bold text-dark">{{ $module->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-slug">/{{ $module->slug }}</span>
                                    </td>
                                    <td>
                                        <span class="badge-route">{{ $module->route_name }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('modules.edit', $module->id) }}"
                                                class="btn-action btn-action-edit" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit Modul">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>

                                            <form action="{{ route('modules.destroy', $module->id) }}" method="POST"
                                                class="d-inline delete-form m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-delete"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Modul">
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

            // Inisialisasi Tooltip Bootstrap (Mencegah tampilan title bawaan browser yang jelek)
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Inisialisasi DataTables
            $('#modulesTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Semua"]
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json', // Bahasa Indonesia
                    search: "_INPUT_",
                    searchPlaceholder: "Cari modul..."
                },
                columnDefs: [{
                        orderable: false,
                        targets: [4]
                    } // Kolom aksi tidak bisa di-sort
                ]
            });

            // Custom SweetAlert Styling untuk Hapus
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    title: 'Hapus Modul?',
                    text: "Modul yang dihapus akan menghilangkan akses pengguna ke halaman tersebut!",
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
                        // Tampilkan loading saat proses hapus
                        Swal.fire({
                            title: 'Menghapus...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        form.submit();
                    }
                });
            });

            // Notifikasi Sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end', // Muncul di pojok kanan atas agar tidak mengganggu
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
            @endif
        });
    </script>
@endpush
