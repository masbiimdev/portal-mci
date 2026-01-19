@extends('layouts.admin')
@section('title')
    User Access | MCI
@endsection

@push('css')
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Layout */
    .access-card { border-radius: 12px; box-shadow: 0 8px 26px rgba(11,20,40,0.04); background: #fff; }
    .module-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 0.8rem; }

    /* Module tile */
    .module-tile {
        padding: .7rem .8rem;
        border-radius: 10px;
        border: 1px solid rgba(15,23,42,0.04);
        background: linear-gradient(180deg, #fff, #fbfdff);
        display: flex;
        align-items: center;
        gap: .75rem;
        transition: transform .12s ease, box-shadow .12s ease, border-color .12s ease;
    }
    .module-tile:hover { transform: translateY(-4px); box-shadow: 0 8px 18px rgba(11,20,40,0.05); border-color: rgba(81,102,255,0.09); }
    .module-icon {
        width:44px; height:44px; display:flex; align-items:center; justify-content:center; border-radius:8px;
        background: linear-gradient(135deg, rgba(81,102,255,0.06), rgba(81,102,255,0.01));
        color: #5166ff; font-weight:700;
        flex: 0 0 44px;
    }
    .module-meta { flex: 1 1 auto; min-width:0; }
    .module-title { font-weight:700; font-size:.95rem; margin-bottom:.15rem; white-space:nowrap; text-overflow:ellipsis; overflow:hidden; }
    .module-desc { color: #6b7280; font-size:.82rem; white-space:nowrap; text-overflow:ellipsis; overflow:hidden; }

    /* custom checkbox (switch-like) */
    .form-check .form-check-input {
        width: 38px; height: 20px; cursor: pointer; margin-left: .25rem;
    }
    .form-actions { display:flex; gap:.5rem; align-items:center; }

    /* helpers */
    .muted-sm { color:#6b7280; font-size:.9rem; }
    .user-badge { font-weight:700; color:#0f172a; background:#eef2ff; padding:.25rem .5rem; border-radius:999px; }
    .controls-row { display:flex; gap:.5rem; align-items:center; flex-wrap:wrap; }

    @media (max-width: 575px) {
        .module-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
    }
</style>
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Access /</span>
        User Access
    </h4>

    <div class="card p-4 access-card">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
            <div>
                <h5 class="mb-0">Atur Hak Akses per User</h5>
                <div class="muted-sm">Pilih user untuk melihat/mengubah modul yang dapat diakses.</div>
            </div>
        </div>

        <form id="accessForm" action="{{ route('access.user.update') }}" method="POST" class="row g-3">
            @csrf

            <div class="col-12 col-md-12">
                <label for="user_id" class="form-label">Pilih User</label>
                <select name="user_id" id="user_id" class="form-select select2" required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                                data-role="{{ $user->role ?? '' }}">
                            {{ $user->name }} ({{ ucfirst($user->role ?? '-') }})
                        </option>
                    @endforeach
                </select>

                <div class="mt-2 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted">Role:</small>
                        <div id="selectedRole" class="user-badge ms-1" style="display:inline-block;">-</div>
                    </div>

                    <div class="text-end">
                        <small class="text-muted">Modul dipilih:</small>
                        <div id="selectedCount" class="ms-1" style="display:inline-block;">0</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12">
                <label class="form-label d-block">Pilih Modul</label>

                <div class="d-flex align-items-center justify-content-between mb-2 controls-row">
                    <div class="form-actions">
                        <button type="button" id="selectAllBtn" class="btn btn-sm btn-outline-primary">Pilih Semua</button>
                        <button type="button" id="clearAllBtn" class="btn btn-sm btn-outline-secondary">Kosongkan</button>
                        <button type="button" id="resetBtn" class="btn btn-sm btn-outline-warning">Reset</button>
                    </div>

                    <div style="min-width:280px;">
                        <input id="moduleSearch" type="search" class="form-control form-control-sm" placeholder="Cari modul...">
                    </div>
                </div>

                <div id="moduleContainer" class="module-grid">
                    @foreach ($modules as $module)
                        <label class="module-tile" for="mod{{ $module->id }}" title="{{ $module->description ?? '' }}">
                            <div class="module-icon">{{ strtoupper(substr($module->name,0,1)) }}</div>
                            <div class="module-meta">
                                <div class="module-title">{{ $module->name }}</div>
                                <div class="module-desc">{{ \Illuminate\Support\Str::limit($module->description ?? '-', 60) }}</div>
                            </div>

                            <div class="form-check form-switch me-1">
                                <input class="form-check-input module-checkbox" type="checkbox"
                                       name="modules[]" value="{{ $module->id }}"
                                       id="mod{{ $module->id }}">
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="mt-3 d-flex gap-2">
                    <button id="submitBtn" type="submit" class="btn btn-primary" disabled>
                        <i class="bx bx-save"></i> Simpan Perubahan
                    </button>

                    <button id="previewBtn" type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#previewModal" disabled>
                        <i class="bx bx-show"></i> Pratinjau
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Pratinjau Hak Akses</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p class="mb-1"><strong>User:</strong> <span id="pvUser">-</span></p>
        <p class="mb-1"><strong>Role:</strong> <span id="pvRole">-</span></p>
        <p class="mb-1"><strong>Modul terpilih:</strong></p>
        <ul id="pvModules" class="list-group list-group-flush"></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<!-- Dependencies -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: {!! json_encode(session('success')) !!},
    timer: 2200,
    showConfirmButton: false
});
</script>
@endif

@php
    // Prepare safe JS payloads to avoid inline JSON parsing issues in attributes.
    $usersForJs = $users->map(function($u) {
        return [
            'id' => $u->id,
            'name' => $u->name,
            'role' => $u->role ?? null,
            'modules' => optional($u->modules)->pluck('id')->values()->all()
        ];
    })->values();
    $modulesForJs = $modules->map(function($m) {
        return [
            'id' => $m->id,
            'name' => $m->name,
            'description' => $m->description ?? null
        ];
    })->values();
@endphp

<script>
$(function () {
    // Load server data
    const usersData = @json($usersForJs);
    const modulesData = @json($modulesForJs);

    // init select2
    $('.select2').select2({
        placeholder: "Cari atau pilih user...",
        allowClear: true,
        width: '100%'
    });

    // helper DOM
    const $userSelect = $('#user_id');
    const $selectedRole = $('#selectedRole');
    const $selectedCount = $('#selectedCount');
    const $submitBtn = $('#submitBtn');
    const $previewBtn = $('#previewBtn');
    let originalSelection = [];

    // utility functions
    function updateSelectedCount() {
        const count = $('.module-checkbox:checked').length;
        $selectedCount.text(count);
        const current = getSelectedModuleIds();
        const userSelected = !!$userSelect.val();
        const changed = !arraysEqual(current, originalSelection);
        $submitBtn.prop('disabled', !userSelected || !changed);
        $previewBtn.prop('disabled', current.length === 0 && !userSelected);
    }

    function getSelectedModuleIds() {
        return $('.module-checkbox:checked').map(function(){ return Number($(this).val()); }).get().sort((a,b) => a-b);
    }

    function arraysEqual(a,b){
        if (!Array.isArray(a) || !Array.isArray(b)) return false;
        if (a.length !== b.length) return false;
        for (let i=0;i<a.length;i++){
            if (a[i] !== b[i]) return false;
        }
        return true;
    }

    function applyUserModules(userId) {
        $('.module-checkbox').prop('checked', false);
        originalSelection = [];
        if (!userId) {
            $selectedRole.text('-');
            updateSelectedCount();
            return;
        }

        const user = usersData.find(u => u.id == Number(userId));
        $selectedRole.text(user && user.role ? user.role.toUpperCase() : '-');

        if (user && user.modules && user.modules.length) {
            user.modules.forEach(id => {
                $(`#mod${id}`).prop('checked', true);
            });
            originalSelection = user.modules.map(x => Number(x)).sort((a,b)=>a-b);
        }
        updateSelectedCount();
    }

    // When user changes
    $userSelect.on('change', function(){
        const userId = $(this).val();
        applyUserModules(userId);
    });

    // Module checkbox changes
    $(document).on('change', '.module-checkbox', function(){
        updateSelectedCount();
    });

    // Select/Clear/Reset buttons
    $('#selectAllBtn').on('click', function(){
        $('.module-checkbox').prop('checked', true);
        updateSelectedCount();
    });
    $('#clearAllBtn').on('click', function(){
        $('.module-checkbox').prop('checked', false);
        updateSelectedCount();
    });
    $('#resetBtn').on('click', function(){
        applyUserModules($userSelect.val());
    });

    // Module search filter
    $('#moduleSearch').on('input', function(){
        const q = $(this).val().toLowerCase().trim();
        if (!q) {
            $('.module-tile').show();
            return;
        }
        $('.module-tile').each(function(){
            const title = $(this).find('.module-title').text().toLowerCase();
            const desc = $(this).find('.module-desc').text().toLowerCase();
            $(this).toggle(title.indexOf(q) !== -1 || desc.indexOf(q) !== -1);
        });
    });

    // Preview modal
    $('#previewBtn').on('click', function(){
        const userId = $userSelect.val();
        const user = usersData.find(u => u.id == Number(userId)) || {name:'-', role:'-'};
        $('#pvUser').text(user.name ?? '-');
        $('#pvRole').text(user.role ? user.role.toUpperCase() : '-');

        const ids = getSelectedModuleIds();
        const list = $('#pvModules').empty();
        if (ids.length === 0) {
            list.append('<li class="list-group-item small text-muted">Tidak ada modul terpilih</li>');
        } else {
            ids.forEach(id => {
                const m = modulesData.find(mm => Number(mm.id) === Number(id));
                list.append(`<li class="list-group-item small">${m ? m.name : ('#' + id)}</li>`);
            });
        }
    });

    // confirm on submit
    $('#accessForm').on('submit', function (e) {
        if (!$userSelect.val()) {
            e.preventDefault();
            Swal.fire({ icon:'warning', title:'Pilih user', text:'Silakan pilih user sebelum menyimpan.' });
            return;
        }

        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Simpan perubahan?',
            html: 'Perubahan akses akan diterapkan ke user yang dipilih.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // initialize state (if old user selected or page reloaded)
    applyUserModules($('#user_id').val());
});
</script>
@endpush