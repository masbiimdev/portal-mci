@extends('layouts.admin')
@section('title', 'User Access Control | MCI')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .access-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            background: #fff;
        }

        .module-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.2rem;
        }

        .module-tile {
            cursor: pointer;
            padding: 1.2rem;
            border-radius: 14px;
            border: 1.5px solid #edf2f7;
            background: #fff;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .module-tile:hover {
            border-color: #cbd5e1;
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.05);
        }

        .module-checkbox {
            display: none;
        }

        .module-checkbox:checked+.module-tile {
            border-color: #4f46e5;
            background-color: #f5f3ff;
        }

        .module-checkbox:checked+.module-tile .module-icon {
            background: #4f46e5;
            color: #fff;
        }

        .module-icon {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #f1f5f9;
            color: #64748b;
            font-weight: 800;
            transition: 0.2s;
        }

        .module-meta {
            flex: 1;
            min-width: 0;
        }

        .module-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: #1e293b;
            margin-bottom: 3px;
        }

        .module-desc {
            color: #64748b;
            font-size: 0.8rem;
            line-height: 1.4;
        }

        .sticky-action {
            position: sticky;
            bottom: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid #e2e8f0;
            padding: 1rem;
            border-radius: 15px;
            box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.05);
            z-index: 100;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-extrabold mb-4 text-dark">User Access Control</h4>

        <div class="card access-card mb-4">
            <form id="accessForm" action="{{ route('access.user.update') }}" method="POST">
                @csrf
                <div class="card-header border-bottom p-4">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Pilih Pengguna</label>
                            <select name="user_id" id="user_id" class="form-select select2" required>
                                <option value="">-- Cari Nama Pengguna --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role ?? 'User' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 text-md-end pt-3">
                            <span class="text-muted small fw-bold">ROLE: <span id="selectedRole"
                                    class="text-primary">-</span></span>
                            <span class="mx-2 text-muted opacity-25">|</span>
                            <span class="text-muted small fw-bold">AKTIF: <span id="selectedCount"
                                    class="text-primary">0</span></span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                        <div class="btn-group shadow-sm">
                            <button type="button" id="selectAllBtn"
                                class="btn btn-outline-primary btn-sm px-3">Semua</button>
                            <button type="button" id="clearAllBtn"
                                class="btn btn-outline-secondary btn-sm px-3">Bersihkan</button>
                        </div>
                        <div class="search-input-group" style="position: relative;">
                            <input id="moduleSearch" type="search" class="form-control form-control-sm"
                                placeholder="Cari modul..." style="width: 250px;">
                        </div>
                    </div>

                    <div id="moduleContainer" class="module-grid">
                        @foreach ($modules as $module)
                            <div class="module-wrapper">
                                <input class="module-checkbox" type="checkbox" name="modules[]" value="{{ $module->id }}"
                                    id="mod{{ $module->id }}">
                                <label class="module-tile" for="mod{{ $module->id }}">
                                    <div class="module-icon">{{ strtoupper(substr($module->name, 0, 1)) }}</div>
                                    <div class="module-meta">
                                        <div class="module-title text-truncate">{{ $module->name }}</div>
                                        <div class="module-desc">
                                            {{ Str::limit($module->description ?? 'No description', 45) }}</div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="sticky-action mt-5 d-flex justify-content-between align-items-center">
                        <p class="mb-0 text-muted small d-none d-md-block">Simpan untuk memperbarui akses user secara
                            instan.</p>
                        <div class="d-flex gap-2">
                            <button id="previewBtn" type="button" class="btn btn-outline-info px-4 fw-bold"
                                data-bs-toggle="modal" data-bs-target="#previewModal" disabled>Pratinjau</button>
                            <button id="submitBtn" type="submit" class="btn btn-primary px-5 fw-bold shadow"
                                disabled>Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Review Akses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="bg-light rounded-3 p-3 text-start">
                        <p class="small fw-bold text-dark border-bottom pb-2 mb-2">Modul yang akan diaktifkan:</p>
                        <ul id="pvModules" class="list-unstyled mb-0 small" style="max-height: 200px; overflow-y: auto;">
                        </ul>
                    </div>
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
        // Kita proses datanya di blok PHP murni agar tidak merusak parsing Blade
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
            // Inject data yang sudah bersih dari PHP
            const usersData = {!! json_encode($jsonUsers) !!};

            $('.select2').select2({
                width: '100%'
            });

            const $userSelect = $('#user_id'),
                $selectedRole = $('#selectedRole'),
                $selectedCount = $('#selectedCount'),
                $submitBtn = $('#submitBtn'),
                $previewBtn = $('#previewBtn');

            let originalSelection = [];

            function updateState() {
                const selectedIds = $('.module-checkbox:checked').map(function() {
                    return Number($(this).val());
                }).get().sort((a, b) => a - b);

                $selectedCount.text(selectedIds.length);

                const hasChanged = JSON.stringify(selectedIds) !== JSON.stringify(originalSelection);

                $submitBtn.prop('disabled', !$userSelect.val() || !hasChanged);
                $previewBtn.prop('disabled', !$userSelect.val());
            }

            $userSelect.on('change', function() {
                const userId = $(this).val();
                $('.module-checkbox').prop('checked', false);
                originalSelection = [];

                if (userId) {
                    const user = usersData.find(u => u.id == userId);
                    if (user) {
                        $selectedRole.text(user.role.toUpperCase());
                        user.modules.forEach(id => {
                            document.getElementById('mod' + id).checked = true;
                        });
                        originalSelection = user.modules.map(Number).sort((a, b) => a - b);
                    }
                } else {
                    $selectedRole.text('-');
                }
                updateState();
            });

            $(document).on('change', '.module-checkbox', updateState);

            $('#selectAllBtn').on('click', () => {
                $('.module-checkbox').prop('checked', true);
                updateState();
            });

            $('#clearAllBtn').on('click', () => {
                $('.module-checkbox').prop('checked', false);
                updateState();
            });

            $('#resetBtn').on('click', () => $userSelect.trigger('change'));

            $('#moduleSearch').on('input', function() {
                const q = $(this).val().toLowerCase().trim();
                $('.module-wrapper').each(function() {
                    const title = $(this).find('.module-title').text().toLowerCase();
                    $(this).toggle(title.indexOf(q) > -1);
                });
            });

            $('#previewBtn').on('click', () => {
                const list = $('#pvModules').empty();
                $('.module-checkbox:checked').each(function() {
                    const title = $(this).closest('.module-wrapper').find('.module-title').text();
                    list.append('<li><i class="bx bx-check text-success me-2"></i>' + title +
                        '</li>');
                });
            });

            $('#accessForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Simpan?',
                    text: "Akses user akan diperbarui.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    confirmButtonColor: '#4f46e5'
                }).then(res => {
                    if (res.isConfirmed) this.submit();
                });
            });
        });
    </script>
@endpush
