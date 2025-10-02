@extends('layouts.admin')
@section('title')
    User | MCI | {{ isset($user) ? 'Edit Data' : 'Tambah Data' }}
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">User /</span>
            {{ isset($user) ? 'Edit' : 'Tambah' }}
        </h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ isset($user) ? 'Edit' : 'Tambah' }} User</h5>
            </div>
            <div class="card-body">
                <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                    @csrf
                    @if (isset($user))
                        @method('PUT')
                    @endif

                    {{-- Name --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $user->name ?? '') }}" required>
                        </div>
                    </div>


                    {{-- NIK --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" name="nik" class="form-control"
                                value="{{ old('name', $user->nik ?? '') }}" required>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email ?? '') }}" required>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control"
                                {{ isset($user) ? '' : 'required' }}>
                            @if (isset($user))
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            @endif
                        </div>
                    </div>

                    {{-- Password Confirmation --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Konfirmasi Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password_confirmation" class="form-control"
                                {{ isset($user) ? '' : 'required' }}>
                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select name="role" class="form-select" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}"
                                        {{ old('role', $user->role ?? '') == $role ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    {{-- Departemen --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Departemen</label>
                        <div class="col-sm-10">
                            <select name="departemen" class="form-select" required>
                                @foreach ($departemens as $departemen)
                                    <option value="{{ $departemen }}"
                                        {{ old('departemen', $user->departemen ?? '') == $departemen ? 'selected' : '' }}>
                                        {{ ucfirst($departemen) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
