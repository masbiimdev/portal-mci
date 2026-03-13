@extends('layouts.admin')
@section('title', 'User Access Control | MCI')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --primary-light: #eff6ff;
            --surface: #ffffff;
            --bg-body: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            --radius-md: 12px;
            --radius-lg: 20px;
            --shadow-sm: 0 2px 4px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .header-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ================= USER SELECTION CARD ================= */
        .user-select-card {
            background: var(--surface);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }

        .stat-badge {
            background: var(--bg-body);
            border: 1px solid var(--border-light);
            padding: 0.75rem 1.25rem;
            border-radius: var(--radius-md);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }

        .stat-badge .label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-badge .val {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary);
        }

        /* ================= MODULES GRID ================= */
        .controls-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 0 0.5rem;
        }

        .module-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
            padding-bottom: 80px;
            /* Space for sticky footer */
        }

        .module-checkbox {
            display: none;
        }

        .module-tile {
            cursor: pointer;
            padding: 1.25rem;
            border-radius: var(--radius-md);
            border: 1.5px solid var(--border-light);
            background: var(--surface);
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-shadow: var(--shadow-sm);
            height: 100%;
        }

        /* Checkmark Icon (Hidden by default) */
        .module-tile::after {
            content: '\eb7a';
            /* Boxicon Check */
            font-family: 'boxicons';
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 1.2rem;
            color: var(--primary);
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.2s ease;
        }

        .module-tile:hover {
            border-color: #cbd5e1;
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        /* Checked State */
        .module-checkbox:checked+.module-tile {
            border-color: var(--primary);
            background-color: var(--primary-light);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.15);
        }

        .module-checkbox:checked+.module-tile::after {
            opacity: 1;
            transform: scale(1);
        }

        .module-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: var(--bg-body);
            color: var(--text-muted);
            font-weight: 800;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .module-checkbox:checked+.module-tile .module-icon {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: #fff;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        .module-meta {
            flex: 1;
            min-width: 0;
            padding-right: 10px;
        }

        .module-title {
            font-weight: 800;
            font-size: 0.95rem;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .module-desc {
            color: var(--text-muted);
            font-size: 0.8rem;
            line-height: 1.5;
            font-weight: 500;
        }

        /* ================= STICKY ACTION BAR ================= */
        .sticky-action {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 40px);
            max-width: 800px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 1rem 1.5rem;
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .btn-custom {
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-save:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .btn-save:disabled {
            background: var(--text-muted);
            box-shadow: none;
            transform: none;
        }

        /* Override Select2 Styling */
        .select2-container--default .select2-selection--single {
            height: 48px;
            border: 1.5px solid var(--border-light);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            color: var(--text-main);
        }

        .select2-container--default .select2-selection--single:focus,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }

        /* Search Input */
        .search-box {
            position: relative;
            width: 100%;
            max-width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border: 1px solid var(--border-light);
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            .sticky-action {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .sticky-action .d-flex {
                width: 100%;
            }

            .sticky-action button {
                flex: 1;
                justify-content: center;
            }

            .controls-wrapper {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                max-width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="page-header">
            <h4 class="header-title">
                <i class="bx bx-shield-quarter text-primary fs-2"></i> User Access Control
            </h4>
            <p class="text-muted mb-0 mt-1">Kelola hak akses modul untuk setiap pengguna sistem.</p>
        </div>

        <form id="accessForm" action="{{ route('access.user.update') }}" method="POST">
            @csrf

            {{-- USER SELECTION CARD --}}
            <div class="user-select-card">
                <div class="row align-items-center g-4">
                    <div class="col-md-7 col-lg-8">
                        <label class="form-label fw-bold text-muted text-uppercase"
                            style="font-size: 0.75rem; letter-spacing: 0.5px;">Target Pengguna</label>
                        <select name="user_id" id="user_id" class="form-select select2" required>
                            <option value="">Cari Nama Pengguna...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role ?? 'User' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 col-lg-4 d-flex justify-content-md-end gap-3">
                        <div class="stat-badge">
                            <span class="label">Level Akses</span>
                            <span class="val" id="selectedRole">-</span>
                        </div>
                        <div class="stat-badge">
                            <span class="label">Modul Aktif</span>
                            <span class="val" id="selectedCount">0</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTROLS & SEARCH --}}
            <div class="controls-wrapper">
                <div class="d-flex gap-2">
                    <button type="button" id="selectAllBtn"
                        class="btn btn-outline-primary btn-sm fw-bold px-3 rounded-pill">Pilih Semua</button>
                    <button type="button" id="clearAllBtn"
                        class="btn btn-outline-secondary btn-sm fw-bold px-3 rounded-pill">Bersihkan</button>
                </div>
                <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input id="moduleSearch" type="search" placeholder="Cari nama modul...">
                </div>
            </div>

            {{-- MODULES GRID --}}
            <div id="moduleContainer" class="module-grid">
                @foreach ($modules as $module)
                    <div class="module-wrapper">
                        <input class="module-checkbox" type="checkbox" name="modules[]" value="{{ $module->id }}"
                            id="mod{{ $module->id }}">
                        <label class="module-tile" for="mod{{ $module->id }}">
                            <div class="module-icon">{{ strtoupper(substr($module->name, 0, 1)) }}</div>
                            <div class="module-meta">
                                <div class="module-title">{{ $module->name }}</div>
                                <div class="module-desc">
                                    {{ Str::limit($module->description ?? 'Tidak ada deskripsi tersedia.', 60) }}</div>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>

            {{-- STICKY ACTION BAR --}}
            <div class="sticky-action">
                <div class="d-none d-md-block">
                    <div class="fw-bold text-dark" style="font-size: 0.95rem;">Perubahan Akses</div>
                    <div class="text-muted" style="font-size: 0.8rem;">Jangan lupa simpan perubahan yang Anda buat.</div>
                </div>
                <div class="d-flex gap-3">
                    <button id="previewBtn" type="button" class="btn-custom btn-back"
                        style="background: #f8fafc; border: 1px solid #e2e8f0; color: #475569;" data-bs-toggle="modal"
                        data-bs-target="#previewModal" disabled>
                        <i class='bx bx-list-check'></i> Pratinjau
                    </button>
                    <button id="submitBtn" type="submit" class="btn-custom btn-save" disabled>
                        <i class="bx bx-save"></i> Simpan Akses
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- PREVIEW MODAL --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header bg-light border-0 p-4 pb-3">
                    <h5 class="modal-title fw-bolder fs-5 text-dark">Review Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <p class="text-muted small fw-bold mb-3 text-uppercase border-bottom pb-2">Modul yang akan Aktif:</p>
                    <ul id="pvModules" class="list-unstyled mb-0" style="max-height: 250px; overflow-y: auto;">
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @php
        // Membersihkan data ke format JSON agar aman dibaca JS
        $jsonUsers = [];
        foreach ($users as $u) {
            $jsonUsers[] = [
                'id' => $u->id,
                'name' => $u->name,
                'role' => $u->role ?? 'User',
                'modules' => $u->modules->pluck('id')->toArray(),
            ];
        }
    @endphp

    <script>
        $(function() {
            const usersData = {!! json_encode($jsonUsers) !!};

            // Inisialisasi Select2
            $('.select2').select2({
                placeholder: "Cari Nama Pengguna...",
                allowClear: true,
                width: '100%'
            });

            const $userSelect = $('#user_id'),
                $selectedRole = $('#selectedRole'),
                $selectedCount = $('#selectedCount'),
                $submitBtn = $('#submitBtn'),
                $previewBtn = $('#previewBtn');

            let originalSelection = [];

            // Fungsi untuk update status Tombol & Counter
            function updateState() {
                const selectedIds = $('.module-checkbox:checked').map(function() {
                    return Number($(this).val());
                }).get().sort((a, b) => a - b);

                $selectedCount.text(selectedIds.length);

                // Cek apakah ada perubahan dari aslinya
                const hasChanged = JSON.stringify(selectedIds) !== JSON.stringify(originalSelection);

                $submitBtn.prop('disabled', !$userSelect.val() || !hasChanged);
                $previewBtn.prop('disabled', !$userSelect.val());
            }

            // Saat User Dipilih
            $userSelect.on('change', function() {
                const userId = $(this).val();

                // Reset semua centang
                $('.module-checkbox').prop('checked', false);
                originalSelection = [];

                if (userId) {
                    const user = usersData.find(u => u.id == userId);
                    if (user) {
                        $selectedRole.text(user.role.toUpperCase());
                        user.modules.forEach(id => {
                            const cb = document.getElementById('mod' + id);
                            if (cb) cb.checked = true;
                        });
                        originalSelection = user.modules.map(Number).sort((a, b) => a - b);
                    }
                } else {
                    $selectedRole.text('-');
                }
                updateState();
            });

            // Pantau setiap kali checkbox diklik
            $(document).on('change', '.module-checkbox', updateState);

            // Tombol Pilih Semua
            $('#selectAllBtn').on('click', () => {
                $('.module-checkbox').prop('checked', true);
                updateState();
            });

            // Tombol Bersihkan
            $('#clearAllBtn').on('click', () => {
                $('.module-checkbox').prop('checked', false);
                updateState();
            });

            // Fitur Live Search Modul
            $('#moduleSearch').on('input', function() {
                const q = $(this).val().toLowerCase().trim();
                $('.module-wrapper').each(function() {
                    const title = $(this).find('.module-title').text().toLowerCase();
                    $(this).toggle(title.includes(q));
                });
            });

            // Fitur Preview Modul
            $('#previewBtn').on('click', () => {
                const list = $('#pvModules').empty();
                const checked = $('.module-checkbox:checked');

                if (checked.length === 0) {
                    list.append(
                        '<li class="text-danger fw-bold py-2"><i class="bx bx-x-circle me-2"></i>Tidak ada akses modul.</li>'
                        );
                    return;
                }

                checked.each(function() {
                    const title = $(this).closest('.module-wrapper').find('.module-title').text();
                    list.append(
                        `<li class="py-2 text-dark fw-semibold d-flex align-items-center border-bottom border-light"><i class="bx bxs-check-circle text-primary me-2 fs-5"></i> ${title}</li>`
                        );
                });
            });

            // Konfirmasi Simpan
            $('#accessForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Simpan Hak Akses?',
                    text: "Sistem akan segera memperbarui akses untuk pengguna ini.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3b82f6',
                    customClass: {
                        popup: 'rounded-4'
                    }
                }).then(res => {
                    if (res.isConfirmed) this.submit();
                });
            });

            // Notifikasi Sukses dari Controller
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000,
                    customClass: {
                        popup: 'rounded-4'
                    }
                });
            @endif
        });
    </script>
@endpush
