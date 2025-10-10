@extends('layouts.admin')
@section('title')
    User Access | MCI
@endsection

@push('css')
<!-- Tambahkan CSS Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Access /</span>
        User Access
    </h4>

    <div class="card p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">Atur Hak Akses per User</h4>
        </div>

        <form action="{{ route('access.user.update') }}" method="POST">
            @csrf

            <!-- Dropdown user dengan search -->
            <div class="mb-3">
                <label for="user_id" class="form-label">Pilih User</label>
                <select name="user_id" id="user_id" class="form-select select2" required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ ucfirst($user->role) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Pilih Modul</label>
                <div class="d-flex flex-wrap gap-3" id="moduleContainer">
                    @foreach ($modules as $module)
                        <div class="form-check">
                            <input class="form-check-input module-checkbox" type="checkbox"
                                   name="modules[]" value="{{ $module->id }}"
                                   id="mod{{ $module->id }}">
                            <label class="form-check-label" for="mod{{ $module->id }}">
                                {{ $module->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Tambahkan JS Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    timer: 2500,
    showConfirmButton: false
});
</script>
@endif

<script>
$(document).ready(function () {
    // Aktifkan select2 pada dropdown user
    $('.select2').select2({
        placeholder: "Cari atau pilih user...",
        allowClear: true,
        width: '100%'
    });

    const usersData = @json($users);

    // Saat user dipilih, centang modul yang dimiliki user tersebut
    $('#user_id').on('change', function () {
        const userId = $(this).val();
        $('.module-checkbox').prop('checked', false); // reset semua

        if (userId) {
            const user = usersData.find(u => u.id == userId);
            if (user && user.modules) {
                user.modules.forEach(mod => {
                    $(`#mod${mod.id}`).prop('checked', true);
                });
            }
        }
    });
});
</script>
@endpush
