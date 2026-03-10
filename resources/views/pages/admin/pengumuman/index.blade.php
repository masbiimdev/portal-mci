@extends('layouts.admin')
@section('title', 'Pengumuman | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        /* Custom Styling untuk mempermanis tabel */
        .table> :not(caption)>*>* {
            padding: 1rem 1.25rem;
            vertical-align: middle;
        }

        .filter-card {
            background-color: #f8f9fa;
            border: 1px dashed #d9dee3;
        }

        /* Memastikan teks di tombol primary selalu berwarna putih */
        .btn-primary {
            color: #ffffff !important;
        }

        .btn-primary:hover {
            color: #ffffff !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold mb-1"><i class="bx bx-megaphone fs-3 align-middle text-primary me-2"></i>Daftar Pengumuman
                </h4>
                <p class="text-muted mb-0">Kelola dan pantau semua pengumuman sistem di sini.</p>
            </div>
            <a href="{{ route('announcements.create') }}" class="btn btn-primary shadow-sm text-white">
                <i class="bx bx-plus me-1"></i> Tambah Pengumuman
            </a>
        </div>

        <div class="card mb-4 filter-card shadow-none">
            <div class="card-body">
                <form method="GET" action="{{ route('announcements.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-muted small">Jenis Pengumuman</label>
                        <select name="type" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="info" {{ request('type') == 'info' ? 'selected' : '' }}>Info</option>
                            <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance
                            </option>
                            <option value="production" {{ request('type') == 'production' ? 'selected' : '' }}>Production</option>
                            <option value="training" {{ request('type') == 'training' ? 'selected' : '' }}>Training</option>
                            <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Event</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-muted small">Departemen</label>
                        <select name="department" class="form-select">
                            <option value="">Semua Departemen</option>
                            <option value="QC" {{ request('department') == 'QC' ? 'selected' : '' }}>QC</option>
                            <option value="Machining" {{ request('department') == 'Machining' ? 'selected' : '' }}>Machining
                            </option>
                            <option value="Assembling" {{ request('department') == 'Assembling' ? 'selected' : '' }}>Assembling
                            </option>
                            <option value="Packing" {{ request('department') == 'Packing' ? 'selected' : '' }}>Packing</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-muted small">Prioritas</label>
                        <select name="priority" class="form-select">
                            <option value="">Semua Prioritas</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button class="btn btn-primary flex-grow-1 text-white" type="submit">
                            <i class="bx bx-search-alt me-1"></i> Cari
                        </button>
                        @if (request()->anyFilled(['type', 'department', 'priority']))
                            <a href="{{ route('announcements.index') }}" class="btn btn-secondary text-white"
                                data-bs-toggle="tooltip" title="Reset Filter">
                                <i class="bx bx-reset"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-datatable table-responsive">
                <table id="announcementsTable" class="table table-hover border-top w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul Pengumuman</th>
                            <th>Jenis</th>
                            <th>Departemen</th>
                            <th>Prioritas</th>
                            <th>Masa Berlaku</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($annons as $index => $a)
                            <tr>
                                <td class="text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <span class="fw-semibold text-heading">{{ $a->title }}</span>
                                    <br>
                                    <small class="text-muted">By: {{ $a->author->name ?? 'Admin' }}</small>
                                </td>
                                <td>
                                    @php
                                        $typeColors = [
                                            'info' => 'info',
                                            'maintenance' => 'warning',
                                            'production' => 'primary',
                                            'training' => 'success',
                                            'event' => 'secondary',
                                        ];
                                        $color = $typeColors[$a->type] ?? 'dark';
                                    @endphp
                                    <span
                                        class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} text-capitalize rounded-pill px-3">
                                        {{ $a->type }}
                                    </span>
                                </td>
                                <td>{{ $a->department ?? 'Semua Dept.' }}</td>
                                <td>
                                    @php
                                        $priorityData = [
                                            'low' => ['color' => 'success', 'icon' => 'bx-down-arrow-alt'],
                                            'medium' => ['color' => 'warning', 'icon' => 'bx-minus'],
                                            'high' => ['color' => 'danger', 'icon' => 'bx-up-arrow-alt'],
                                        ];
                                        $p = $priorityData[$a->priority] ?? [
                                            'color' => 'secondary',
                                            'icon' => 'bx-radio-circle',
                                        ];
                                    @endphp
                                    <span
                                        class="badge bg-{{ $p['color'] }} rounded-pill d-inline-flex align-items-center">
                                        <i class="bx {{ $p['icon'] }} me-1"></i> {{ ucfirst($a->priority) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($a->expiry_date)
                                        @if (Carbon\Carbon::parse($a->expiry_date)->isPast())
                                            <span class="text-danger small"><i class="bx bx-time-five me-1"></i>Expired
                                                ({{ date('d M Y', strtotime($a->expiry_date)) }})</span>
                                        @else
                                            <span class="small"><i
                                                    class="bx bx-calendar me-1"></i>{{ date('d M Y', strtotime($a->expiry_date)) }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($a->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success"><i
                                                class="bx bx-check-circle me-1"></i>Aktif</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary"><i
                                                class="bx bx-x-circle me-1"></i>Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('announcements.edit', $a->id) }}"
                                            class="btn btn-sm btn-icon btn-outline-warning" data-bs-toggle="tooltip"
                                            title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('announcements.destroy', $a->id) }}" method="POST"
                                            class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-icon btn-outline-danger" data-bs-toggle="tooltip"
                                                title="Hapus">
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

            // Inisialisasi DataTables
            $('#announcementsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Semua"]
                ],
                order: [
                    [0, 'asc']
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json', // Translate ke Bahasa Indonesia
                },
                columnDefs: [{
                        orderable: false,
                        targets: 7
                    }, // Kolom Aksi tidak bisa di-sort
                    {
                        className: "text-nowrap",
                        targets: "_all"
                    }
                ]
            });

            // SweetAlert untuk tombol Delete dengan warna default bawaan agar teks putih jelas
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault();
                let form = this;

                Swal.fire({
                    title: 'Hapus Pengumuman?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff3e1d', // Merah tegas
                    cancelButtonColor: '#8592a3', // Abu-abu
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });

            // SweetAlert untuk session success
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-4'
                    }
                });
            @endif
        });
    </script>
@endpush
