@extends('layouts.admin')
@section('title', 'Master Project | Document')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        table.dataTable td {
            vertical-align: middle;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.85rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Document / Master /</span> Project
        </h4>

        <div class="card shadow-sm border-0">
            {{-- Header --}}
            <div class="card-header border-bottom bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="card-title mb-0 fw-bold text-primary">
                    <i class="fas fa-folder-open me-2"></i>Daftar Project
                </h5>
                <a href="{{ route('document.project.create') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i> Tambah Project
                </a>
            </div>

            {{-- Table Card Body --}}
            <div class="card-body pt-4">
                <table id="projectsTable" class="table table-hover table-striped border w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Project</th>
                            <th>No Project</th>
                            <th>Nama Project</th>
                            <th class="text-center">Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="fw-semibold text-primary">{{ $project->project_code }}</td>
                                <td>{{ $project->project_number }}</td>
                                <td>{{ $project->project_name }}</td>
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'PENDING' => 'warning',
                                            'ON PROGRESS' => 'info',
                                            'COMPLETED' => 'success',
                                            'CANCELLED' => 'danger',
                                        ];
                                        $currentStatus = strtoupper($project->status);
                                        $badgeColor = $statusColors[$currentStatus] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }} rounded-pill px-3 py-2 shadow-sm"
                                        style="font-size: 0.8rem;">
                                        {{ $currentStatus }}
                                    </span>
                                </td>
                                <td>
                                    {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">

                                        {{-- Tombol Detail Diubah menjadi trigger Modal --}}
                                        <button type="button" class="btn btn-sm btn-info action-btn text-white btn-detail"
                                            title="Detail" data-bs-toggle="modal" data-bs-target="#detailModal"
                                            data-code="{{ $project->project_code }}"
                                            data-number="{{ $project->project_number }}"
                                            data-name="{{ $project->project_name }}"
                                            data-status="{{ strtoupper($project->status) }}"
                                            data-start="{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->translatedFormat('d F Y') : '-' }}"
                                            data-end="{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->translatedFormat('d F Y') : '-' }}">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>

                                        <a href="{{ route('document.project.edit', $project->id) }}"
                                            class="btn btn-sm btn-primary action-btn" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <form action="{{ route('document.project.destroy', $project->id) }}" method="POST"
                                            class="delete-form m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger action-btn" title="Delete">
                                                <i class="fas fa-trash-alt"></i> Hapus
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

    {{-- MODAL DETAIL POP-UP --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light border-bottom py-3">
                    <h5 class="modal-title fw-bold text-primary" id="detailModalLabel">
                        <i class="fas fa-info-circle me-2"></i>Detail Project
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <table class="table table-borderless table-sm mb-0">
                        <tbody>
                            <tr>
                                <th class="text-secondary w-25">Project Code</th>
                                <th style="width: 2%">:</th>
                                <td class="fw-bold text-dark" id="modal-code"></td>
                            </tr>
                            <tr>
                                <th class="text-secondary">No Project</th>
                                <th>:</th>
                                <td id="modal-number"></td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Nama Project</th>
                                <th>:</th>
                                <td id="modal-name"></td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Status</th>
                                <th>:</th>
                                <td id="modal-status"></td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Start Date</th>
                                <th>:</th>
                                <td id="modal-start"></td>
                            </tr>
                            <tr>
                                <th class="text-secondary">End Date</th>
                                <th>:</th>
                                <td id="modal-end"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-light border-top py-2">
                    <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Tutup</button>
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

            // Inisialisasi DataTables
            $('#projectsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Semua"]
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari project...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // LOGIKA UNTUK MENAMPILKAN DATA DI MODAL
            // Gunakan event delegation (.on) agar tetap berfungsi saat fitur search/pagination DataTables digunakan
            $('#projectsTable').on('click', '.btn-detail', function() {
                // Ambil data dari atribut data-* tombol yang diklik
                let code = $(this).data('code');
                let number = $(this).data('number');
                let name = $(this).data('name');
                let status = $(this).data('status');
                let start = $(this).data('start');
                let end = $(this).data('end');

                // Masukkan data ke dalam element ID di dalam Modal
                $('#modal-code').text(code);
                $('#modal-number').text(number);
                $('#modal-name').text(name);
                $('#modal-start').text(start);
                $('#modal-end').text(end);

                // Styling badge status untuk di dalam Modal
                let badgeClass = 'bg-secondary';
                if (status === 'PENDING') badgeClass = 'bg-warning text-dark';
                else if (status === 'ON PROGRESS') badgeClass = 'bg-info';
                else if (status === 'COMPLETED') badgeClass = 'bg-success';
                else if (status === 'CANCELLED') badgeClass = 'bg-danger';

                $('#modal-status').html(
                    `<span class="badge ${badgeClass} rounded-pill px-3">${status}</span>`);
            });

            // SweetAlert untuk Konfirmasi Hapus
            $('#projectsTable').on('submit', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Hapus Project?',
                    text: 'Data yang dihapus tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash-alt me-1"></i> Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                        form.submit();
                    }
                });
            });

            // SweetAlert untuk Notifikasi Sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif

        });
    </script>
@endpush
