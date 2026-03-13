@extends('layouts.admin')
@section('title', 'Pengumuman | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        /* ================= CSS VARIABLES ================= */
        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --surface: #ffffff;
            --bg-body: #f8fafc;
            --border: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(15, 23, 42, 0.05);
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
        }

        /* ================= HEADER & FILTER ================= */
        .header-title {
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .btn-add {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: #fff !important;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 0.6rem 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
        }

        .filter-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .filter-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .form-select-custom {
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-main);
            padding: 0.6rem 1rem;
            background-color: #f8fafc;
            transition: all 0.2s;
        }

        .form-select-custom:focus {
            background-color: var(--surface);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            outline: none;
        }

        .btn-search {
            background-color: var(--text-main);
            color: white;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.6rem;
            transition: all 0.2s;
        }

        .btn-search:hover {
            background-color: #0f172a;
            color: white;
            transform: translateY(-1px);
        }

        /* ================= TABLE DESIGN ================= */
        .table-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-custom {
            margin-bottom: 0;
            width: 100% !important;
        }

        .table-custom thead th {
            background-color: #f1f5f9;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid var(--border);
        }

        .table-custom tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            font-size: 0.9rem;
            color: var(--text-main);
            border-bottom: 1px solid #f1f5f9;
        }

        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Title & Meta */
        .title-text {
            font-weight: 700;
            color: var(--text-main);
            font-size: 0.95rem;
            margin-bottom: 2px;
            display: block;
        }

        .meta-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Modern Badges */
        .badge-modern {
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            letter-spacing: 0.3px;
            text-transform: capitalize;
        }

        .badge-type-info {
            background: #e0f2fe;
            color: #0284c7;
        }

        .badge-type-maintenance {
            background: #fffbeb;
            color: #b45309;
        }

        .badge-type-production {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .badge-type-training {
            background: #ecfdf5;
            color: #047857;
        }

        .badge-type-event {
            background: #f3f4f6;
            color: #475569;
        }

        .badge-pri-high {
            background: #fef2f2;
            color: #dc2626;
        }

        .badge-pri-medium {
            background: #fffbeb;
            color: #d97706;
        }

        .badge-pri-low {
            background: #ecfdf5;
            color: #059669;
        }

        .status-active {
            color: #10b981;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .status-inactive {
            color: #94a3b8;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Action Buttons */
        .action-cell {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
            background: #f1f5f9;
            color: var(--text-muted);
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-action i {
            font-size: 1.1rem;
        }

        .btn-action.edit:hover {
            background: #fffbeb;
            color: #d97706;
            border-color: #fde68a;
            transform: translateY(-2px);
        }

        .btn-action.delete:hover {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
            transform: translateY(-2px);
        }

        /* Override DataTables */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            outline: none;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--primary);
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.3rem 1.5rem 0.3rem 0.8rem;
        }

        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 6px;
        }

        .page-item .page-link {
            border-radius: 6px;
            margin: 0 2px;
            color: var(--text-main);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="header-title mb-1">
                    <i class="bx bx-megaphone fs-3 align-middle text-primary me-2"></i>Daftar Pengumuman
                </h4>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Kelola dan pantau semua pengumuman sistem di sini.</p>
            </div>
            <a href="{{ route('announcements.create') }}" class="btn-add">
                <i class="bx bx-plus"></i> Buat Pengumuman
            </a>
        </div>

        {{-- FILTER CARD --}}
        <div class="filter-card">
            <form method="GET" action="{{ route('announcements.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3 col-sm-6">
                    <label class="filter-label">Kategori</label>
                    <select name="type" class="form-select form-select-custom w-100">
                        <option value="">Semua Kategori</option>
                        <option value="info" {{ request('type') == 'info' ? 'selected' : '' }}>Info</option>
                        <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance
                        </option>
                        <option value="production" {{ request('type') == 'production' ? 'selected' : '' }}>Production
                        </option>
                        <option value="training" {{ request('type') == 'training' ? 'selected' : '' }}>Training</option>
                        <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Event</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="filter-label">Departemen Target</label>
                    <select name="department" class="form-select form-select-custom w-100">
                        <option value="">Semua Departemen</option>
                        <option value="QC" {{ request('department') == 'QC' ? 'selected' : '' }}>QC</option>
                        <option value="Machining" {{ request('department') == 'Machining' ? 'selected' : '' }}>Machining
                        </option>
                        <option value="Assembling" {{ request('department') == 'Assembling' ? 'selected' : '' }}>Assembling
                        </option>
                        <option value="Packing" {{ request('department') == 'Packing' ? 'selected' : '' }}>Packing</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="filter-label">Level Prioritas</label>
                    <select name="priority" class="form-select form-select-custom w-100">
                        <option value="">Semua Level</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi (High)</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang (Medium)
                        </option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah (Low)</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 d-flex gap-2">
                    <button class="btn btn-search flex-grow-1" type="submit">
                        <i class="bx bx-filter-alt me-1"></i> Terapkan
                    </button>
                    @if (request()->anyFilled(['type', 'department', 'priority']))
                        <a href="{{ route('announcements.index') }}" class="btn btn-light border text-muted"
                            data-bs-toggle="tooltip" title="Reset Filter" style="border-radius: 8px;">
                            <i class="bx bx-reset"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- TABLE CARD --}}
        <div class="table-card">
            <div class="table-responsive p-3">
                <table id="announcementsTable" class="table table-custom">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Informasi Pengumuman</th>
                            <th width="15%">Kategori</th>
                            <th width="15%">Prioritas</th>
                            <th width="15%">Batas Waktu</th>
                            <th width="10%">Status</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($annons as $index => $a)
                            <tr>
                                <td class="text-muted fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <span class="title-text">{{ $a->title }}</span>
                                    <span class="meta-text">
                                        <i class='bx bx-user-circle'></i> {{ $a->author->name ?? 'Admin System' }}
                                        <span class="mx-1">•</span>
                                        {{ $a->department ?? 'Semua Dept.' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $typeClass = 'badge-type-' . strtolower($a->type);
                                        // Fallback jika tipe tidak sesuai dengan class css
                                        if (
                                            !in_array(strtolower($a->type), [
                                                'info',
                                                'maintenance',
                                                'production',
                                                'training',
                                                'event',
                                            ])
                                        ) {
                                            $typeClass = 'badge-type-event';
                                        }
                                    @endphp
                                    <span class="badge-modern {{ $typeClass }}">
                                        {{ $a->type }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $priorityData = [
                                            'high' => ['class' => 'badge-pri-high', 'icon' => 'bxs-up-arrow-circle'],
                                            'medium' => ['class' => 'badge-pri-medium', 'icon' => 'bxs-minus-circle'],
                                            'low' => ['class' => 'badge-pri-low', 'icon' => 'bxs-down-arrow-circle'],
                                        ];
                                        $p = $priorityData[$a->priority] ?? [
                                            'class' => 'bg-light text-dark',
                                            'icon' => 'bxs-circle',
                                        ];
                                    @endphp
                                    <span class="badge-modern {{ $p['class'] }}">
                                        <i class="bx {{ $p['icon'] }}"></i> {{ $a->priority }}
                                    </span>
                                </td>
                                <td>
                                    @if ($a->expiry_date)
                                        @if (\Carbon\Carbon::parse($a->expiry_date)->isPast())
                                            <span class="text-danger fw-bold" style="font-size: 0.85rem;">
                                                <i class="bx bx-time me-1"></i>Expired
                                            </span>
                                            <div class="text-muted" style="font-size: 0.75rem;">
                                                {{ date('d M Y', strtotime($a->expiry_date)) }}</div>
                                        @else
                                            <span class="fw-semibold" style="font-size: 0.85rem; color: var(--text-main);">
                                                <i
                                                    class="bx bx-calendar me-1 text-muted"></i>{{ date('d M Y', strtotime($a->expiry_date)) }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-muted" style="font-size: 0.85rem;">Tanpa Batas</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($a->is_active)
                                        <span class="status-active"><i class='bx bxs-check-circle'></i> Aktif</span>
                                    @else
                                        <span class="status-inactive"><i class='bx bxs-x-circle'></i> Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-cell">
                                        <a href="{{ route('announcements.edit', $a->id) }}" class="btn-action edit"
                                            data-bs-toggle="tooltip" title="Edit Data">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                        <form action="{{ route('announcements.destroy', $a->id) }}" method="POST"
                                            class="delete-form m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action delete" data-bs-toggle="tooltip"
                                                title="Hapus Data">
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
                    [10, 25, 50, -1],
                    [10, 25, 50, "Semua"]
                ],
                order: [
                    [0, 'asc']
                ], // Urutkan berdasarkan kolom No secara default
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                    search: "_INPUT_",
                    searchPlaceholder: "Cari data pengumuman..."
                },
                columnDefs: [{
                        orderable: false,
                        targets: 6
                    }, // Kolom Aksi tidak bisa di-sort
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
            });

            // SweetAlert untuk Konfirmasi Hapus
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault();
                let form = this;

                Swal.fire({
                    title: 'Hapus Pengumuman?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626', // Merah Tailwind
                    cancelButtonColor: '#64748b', // Slate 500
                    confirmButtonText: 'Ya, Hapus Permanen!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });

            // SweetAlert untuk Notifikasi Sukses
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
