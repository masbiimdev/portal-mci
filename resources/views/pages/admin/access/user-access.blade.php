@extends('layouts.admin')
@section('title', 'User Access Control | MCI')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        /* ========== ULTRA PREMIUM BENTO SYSTEM ========== */
        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --primary-soft: #eff6ff;
            --success: #10b981;
            --surface: rgba(255, 255, 255, 0.95);
            --bg-body: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-light: rgba(226, 232, 240, 0.8);

            --radius-bento: 24px;
            --radius-md: 16px;

            --shadow-bento: 0 10px 40px -10px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 20px 40px -10px rgba(59, 130, 246, 0.15);
            --shadow-floating: 0 25px 50px -12px rgba(0, 0, 0, 0.15);

            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 32px 32px;
            -webkit-font-smoothing: antialiased;
        }

        .container-p-y {
            padding-top: 2.5rem !important;
            padding-bottom: 6rem !important;
        }

        /* ================= PAGE HEADER ================= */
        .page-header {
            margin-bottom: 2rem;
        }

        .header-title {
            font-size: 2rem;
            font-weight: 900;
            color: var(--text-main);
            letter-spacing: -0.04em;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
        }

        .header-desc {
            color: var(--text-muted);
            font-size: 1rem;
            font-weight: 500;
            margin-top: 6px;
        }

        /* ================= BENTO GRID LAYOUT ================= */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
        }

        .bento-card {
            background: var(--surface);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-bento);
            padding: 2rem;
            box-shadow: var(--shadow-bento);
            transition: var(--transition);
        }

        .col-span-4 {
            grid-column: span 4;
        }

        .col-span-8 {
            grid-column: span 8;
        }

        /* ================= USER CONTEXT CARD ================= */
        .user-card {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            position: sticky;
            top: 2rem;
            /* Membuatnya tetap terlihat saat scroll ke bawah */
        }

        .stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .stat-box {
            background: #f8fafc;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .stat-box .label {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .stat-box .val {
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--primary);
            line-height: 1;
        }

        /* ================= MODULES WORKSPACE ================= */
        .toolbar-bento {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            background: #f8fafc;
            padding: 1rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-light);
        }

        .search-wrapper {
            background: white;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            max-width: 300px;
            border: 1px solid var(--border-light);
            transition: var(--transition);
        }

        .search-wrapper:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-soft);
        }

        .search-wrapper input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .btn-toolbar {
            padding: 0.6rem 1.25rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.85rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-toolbar-outline {
            border: 1px solid var(--border-light);
            background: white;
            color: var(--text-main);
        }

        .btn-toolbar-outline:hover {
            background: var(--bg-body);
            border-color: #cbd5e1;
        }

        /* Module Grid */
        .module-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.25rem;
        }

        .module-checkbox {
            display: none;
        }

        .module-tile {
            cursor: pointer;
            padding: 1.5rem;
            border-radius: 1.5rem;
            border: 2px solid var(--border-light);
            background: white;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            transition: var(--transition);
            position: relative;
            height: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .module-tile:hover {
            transform: translateY(-3px);
            border-color: #cbd5e1;
            box-shadow: var(--shadow-hover);
        }

        .module-tile::after {
            content: '\eb7a';
            font-family: 'boxicons';
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 1.5rem;
            color: var(--primary);
            opacity: 0;
            transform: scale(0.5);
            transition: var(--transition);
        }

        .module-checkbox:checked+.module-tile {
            border-color: var(--primary);
            background-color: var(--primary-soft);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.1);
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
            border-radius: 14px;
            background: #f1f5f9;
            color: var(--text-muted);
            font-weight: 900;
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .module-checkbox:checked+.module-tile .module-icon {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .module-title {
            font-weight: 800;
            font-size: 1rem;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .module-desc {
            color: var(--text-muted);
            font-size: 0.8rem;
            line-height: 1.5;
            font-weight: 500;
        }

        /* ================= SELECT2 MODERNIZATION ================= */
        .select2-container--default .select2-selection--single {
            height: 54px;
            border: 2px solid var(--border-light);
            border-radius: 16px;
            display: flex;
            align-items: center;
            font-family: inherit;
            font-weight: 700;
            color: var(--text-main);
            padding-left: 0.5rem;
            transition: var(--transition);
        }

        .select2-container--default .select2-selection--single:focus,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 52px;
            right: 10px;
        }

        /* ================= FLOATING DYNAMIC ISLAND ================= */
        .floating-island {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 1rem;
            border-radius: 99px;
            box-shadow: var(--shadow-floating);
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            width: auto;
            min-width: 500px;
            transition: var(--transition);
        }

        .island-text {
            display: flex;
            flex-direction: column;
            margin-left: 1rem;
        }

        .island-title {
            font-weight: 800;
            color: var(--text-main);
            font-size: 0.9rem;
        }

        .island-subtitle {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .btn-island {
            padding: 0.8rem 1.5rem;
            border-radius: 99px;
            font-weight: 800;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            transition: var(--transition);
        }

        .btn-island-preview {
            background: #f1f5f9;
            color: var(--text-main);
        }

        .btn-island-preview:hover:not(:disabled) {
            background: #e2e8f0;
        }

        .btn-island-save {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-island-save:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.5);
        }

        .btn-island:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .col-span-4 {
                grid-column: span 5;
            }

            .col-span-8 {
                grid-column: span 7;
            }
        }

        @media (max-width: 768px) {

            .col-span-4,
            .col-span-8 {
                grid-column: span 12;
            }

            .user-card {
                position: relative;
                top: 0;
            }

            .toolbar-bento {
                flex-direction: column;
                align-items: stretch;
            }

            .search-wrapper {
                max-width: 100%;
            }

            .floating-island {
                width: calc(100% - 40px);
                min-width: 0;
                flex-direction: column;
                border-radius: 24px;
                gap: 1rem;
                text-align: center;
            }

            .island-text {
                margin-left: 0;
            }

            .island-actions {
                display: flex;
                width: 100%;
                gap: 10px;
            }

            .btn-island {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="page-header">
            <h4 class="header-title">
                <i class="bx bx-shield-quarter text-primary"></i> Access Control
            </h4>
            <p class="header-desc">Manajemen hak akses modul eksklusif untuk setiap pengguna sistem.</p>
        </div>

        <form id="accessForm" action="{{ route('access.user.update') }}" method="POST">
            @csrf

            <div class="bento-grid">

                <div class="col-span-4">
                    <div class="bento-card user-card">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="fw-bolder text-muted text-uppercase"
                                    style="font-size: 0.75rem; letter-spacing: 1px;">Target Pengguna</label>
                                <i class="bx bx-user-circle text-muted fs-4"></i>
                            </div>
                            <select name="user_id" id="user_id" class="form-select select2" required>
                                <option value="">Pilih Pengguna...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role ?? 'User' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <hr class="my-1 border-light">

                        <div class="stat-grid">
                            <div class="stat-box">
                                <span class="label">Level Akses</span>
                                <span class="val" id="selectedRole">-</span>
                            </div>
                            <div class="stat-box">
                                <span class="label">Modul Aktif</span>
                                <span class="val" id="selectedCount">0</span>
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded-4 mt-2 border border-light">
                            <p class="text-muted mb-0" style="font-size: 0.75rem; font-weight: 600;">
                                <i class="bx bx-info-circle text-primary"></i> Pilih pengguna dari dropdown di atas untuk
                                memuat konfigurasi hak akses saat ini.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-8">
                    <div class="bento-card">

                        <div class="toolbar-bento">
                            <div class="search-wrapper shadow-sm">
                                <i class='bx bx-search text-muted fs-5'></i>
                                <input id="moduleSearch" type="search" placeholder="Cari modul spesifik...">
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" id="selectAllBtn" class="btn-toolbar btn-toolbar-outline shadow-sm">
                                    <i class="bx bx-check-double text-success"></i> Select All
                                </button>
                                <button type="button" id="clearAllBtn" class="btn-toolbar btn-toolbar-outline shadow-sm">
                                    <i class="bx bx-reset text-danger"></i> Clear All
                                </button>
                            </div>
                        </div>

                        <div id="moduleContainer" class="module-grid">
                            @foreach ($modules as $module)
                                <div class="module-wrapper">
                                    <input class="module-checkbox" type="checkbox" name="modules[]"
                                        value="{{ $module->id }}" id="mod{{ $module->id }}">
                                    <label class="module-tile" for="mod{{ $module->id }}">
                                        <div class="module-icon">{{ strtoupper(substr($module->name, 0, 2)) }}</div>
                                        <div class="module-meta">
                                            <div class="module-title">{{ $module->name }}</div>
                                            <div class="module-desc">
                                                {{ Str::limit($module->description ?? 'Tidak ada deskripsi tersedia.', 60) }}
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>

            <div class="floating-island">
                <div class="island-text d-none d-md-flex">
                    <span class="island-title"><i class="bx bx-cog text-primary me-1"></i> Perubahan Terdeteksi</span>
                    <span class="island-subtitle">Tinjau atau simpan pembaruan akses.</span>
                </div>
                <div class="island-actions d-flex gap-3">
                    <button id="previewBtn" type="button" class="btn-island btn-island-preview" data-bs-toggle="modal"
                        data-bs-target="#previewModal" disabled>
                        <i class='bx bx-list-ul'></i> Preview
                    </button>
                    <button id="submitBtn" type="submit" class="btn-island btn-island-save" disabled>
                        <i class="bx bx-save"></i> Save Changes
                    </button>
                </div>
            </div>

        </form>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
                <div class="modal-header bg-light border-0 p-4 pb-3">
                    <h5 class="modal-title fw-bolder fs-5 text-dark"><i
                            class="bx bx-check-shield text-success me-2"></i>Review Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2 bg-white">
                    <p class="text-muted small fw-bolder mb-3 text-uppercase tracking-wider border-bottom pb-2">Modul yang
                        akan Diberikan:</p>
                    <ul id="pvModules" class="list-unstyled mb-0" style="max-height: 300px; overflow-y: auto;">
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
        // PHP 7.4 Safe Data Parsing
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

            // Select2 Init
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

            // Update State Logic
            function updateState() {
                const selectedIds = $('.module-checkbox:checked').map(function() {
                    return Number($(this).val());
                }).get().sort((a, b) => a - b);

                $selectedCount.text(selectedIds.length);

                const hasChanged = JSON.stringify(selectedIds) !== JSON.stringify(originalSelection);

                $submitBtn.prop('disabled', !$userSelect.val() || !hasChanged);
                $previewBtn.prop('disabled', !$userSelect.val());
            }

            // User Selection Event
            $userSelect.on('change', function() {
                const userId = $(this).val();
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

            $(document).on('change', '.module-checkbox', updateState);

            // Select All / Clear All
            $('#selectAllBtn').on('click', () => {
                $('.module-checkbox').prop('checked', true);
                updateState();
            });
            $('#clearAllBtn').on('click', () => {
                $('.module-checkbox').prop('checked', false);
                updateState();
            });

            // Live Search Modules
            $('#moduleSearch').on('input', function() {
                const q = $(this).val().toLowerCase().trim();
                $('.module-wrapper').each(function() {
                    const title = $(this).find('.module-title').text().toLowerCase();
                    $(this).toggle(title.includes(q));
                });
            });

            // Preview Logic
            $('#previewBtn').on('click', () => {
                const list = $('#pvModules').empty();
                const checked = $('.module-checkbox:checked');

                if (checked.length === 0) {
                    list.append(
                        '<li class="text-danger fw-bold py-3 text-center"><i class="bx bx-x-circle fs-3 d-block mb-1"></i>Akses Kosong</li>'
                        );
                    return;
                }

                checked.each(function() {
                    const title = $(this).closest('.module-wrapper').find('.module-title').text();
                    list.append(
                        `<li class="py-2 text-dark fw-bold d-flex align-items-center border-bottom border-light"><div class="bg-primary-subtle text-primary rounded-circle p-1 me-3 d-flex"><i class="bx bx-check"></i></div> ${title}</li>`
                        );
                });
            });

            // Save Confirmation
            $('#accessForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Terapkan Akses?',
                    text: "Sistem akan memperbarui izin modul untuk pengguna ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3b82f6',
                    customClass: {
                        popup: 'rounded-[2rem]'
                    }
                }).then(res => {
                    if (res.isConfirmed) this.submit();
                });
            });

            // Success Flash Message
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000,
                    customClass: {
                        popup: 'rounded-[2rem]'
                    }
                });
            @endif
        });
    </script>
@endpush
