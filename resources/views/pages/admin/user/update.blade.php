@extends('layouts.admin')

@section('title')
    User | MCI | {{ isset($user) ? 'Edit Data' : 'Tambah Data' }}
@endsection

@push('css')
    <style>
        .card-header-custom {
            background-color: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.5rem;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            letter-spacing: 0.3px;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-right: none;
            color: #94a3b8;
        }

        .form-control,
        .form-select {
            border-left: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #d9dee3;
            /* Menyesuaikan border template bawaan */
            box-shadow: none;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control,
        .input-group:focus-within .form-select {
            border-color: #696cff;
            /* Primary color */
        }

        .input-group:focus-within .input-group-text {
            color: #696cff;
        }

        .required-asterisk {
            color: #ff3e1d;
            margin-left: 2px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Access Control / User /</span> {{ isset($user) ? 'Edit' : 'Tambah' }} Pengguna
        </h4>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bx bx-error-circle fs-4 me-2"></i>
                    <strong class="mb-0">Mohon periksa kembali form Anda!</strong>
                </div>
                <ul class="mb-0 ps-4 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-lg-10 col-xl-9">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header-custom d-flex align-items-center">
                        <div
                            class="avatar avatar-sm me-3 bg-label-primary rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bx {{ isset($user) ? 'bx-user-check' : 'bx-user-plus' }} fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">
                                {{ isset($user) ? 'Edit Profil Pengguna' : 'Informasi Pengguna Baru' }}</h5>
                            <p class="mb-0 text-muted small">Lengkapi data di bawah ini untuk mengatur hak akses ke dalam
                                sistem.</p>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($user))
                                @method('PUT')
                            @endif

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6 class="fw-semibold text-primary mb-3"><i class="bx bx-id-card me-1"></i> Data
                                        Personal</h6>

                                    {{-- NIK --}}
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Induk Karyawan (NIK) <span
                                                class="required-asterisk">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                                            <input type="text" name="nik" class="form-control"
                                                placeholder="Contoh: 10293847" value="{{ old('nik', $user->nik ?? '') }}"
                                                required>
                                        </div>
                                    </div>

                                    {{-- Name --}}
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap <span
                                                class="required-asterisk">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Sesuai KTP / ID Card"
                                                value="{{ old('name', $user->name ?? '') }}" required>
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="mb-3">
                                        <label class="form-label">Alamat Email <span
                                                class="required-asterisk">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="email@perusahaan.com"
                                                value="{{ old('email', $user->email ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="fw-semibold text-primary mb-3"><i class="bx bx-shield-quarter me-1"></i>
                                        Akses & Keamanan</h6>

                                    <div class="row">
                                        {{-- Departemen --}}
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Departemen <span
                                                    class="required-asterisk">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                                <select name="departemen" class="form-select" required>
                                                    <option value="" disabled {{ !isset($user) ? 'selected' : '' }}>
                                                        Pilih...</option>
                                                    @foreach ($departemens as $departemen)
                                                        <option value="{{ $departemen }}"
                                                            {{ old('departemen', $user->departemen ?? '') == $departemen ? 'selected' : '' }}>
                                                            {{ ucfirst($departemen) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Role --}}
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Jabatan (Role) <span
                                                    class="required-asterisk">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-briefcase-alt-2"></i></span>
                                                <select name="role" class="form-select" required>
                                                    <option value="" disabled {{ !isset($user) ? 'selected' : '' }}>
                                                        Pilih...</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role }}"
                                                            {{ old('role', $user->role ?? '') == $role ? 'selected' : '' }}>
                                                            {{ ucfirst($role) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-3 border-light">

                                    {{-- Password --}}
                                    <div class="mb-3">
                                        <label class="form-label">Password
                                            {{ isset($user) ? '' : '<span class="required-asterisk">*</span>' }}</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="••••••••" {{ isset($user) ? '' : 'required' }}>
                                        </div>
                                        @if (isset($user))
                                            <small class="text-muted mt-1 d-block"><i class="bx bx-info-circle"></i> Biarkan
                                                kosong jika tidak ingin mengubah password.</small>
                                        @endif
                                    </div>

                                    {{-- Password Confirmation --}}
                                    <div class="mb-3">
                                        <label class="form-label">Konfirmasi Password
                                            {{ isset($user) ? '' : '<span class="required-asterisk">*</span>' }}</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="••••••••" {{ isset($user) ? '' : 'required' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 border-light">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bx bx-arrow-back me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                    <i class="bx bx-save me-1"></i> Simpan Data Pengguna
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
