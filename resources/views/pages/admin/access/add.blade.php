@extends('layouts.admin')

@section('title', 'Tambah Modul Baru | MCI')

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

        .form-control {
            border-left: none;
        }

        .form-control:focus {
            border-color: #d9dee3;
            /* Menyesuaikan border bawaan template */
            box-shadow: none;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #696cff;
            /* Warna primary saat fokus */
        }

        .input-group:focus-within .input-group-text {
            color: #696cff;
        }

        .required-asterisk {
            color: #ff3e1d;
            margin-left: 2px;
        }

        .form-text {
            font-size: 0.75rem;
            color: #94a3b8;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Access Control / Modules /</span> Tambah Modul
        </h4>

        <div class="row">
            <div class="col-xl-8 col-lg-10 col-md-12">

                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header-custom d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark"><i class="bx bx-layer text-primary me-2"></i>Informasi Modul
                            </h5>
                            <p class="mb-0 text-muted small">Tambahkan rute dan modul baru untuk mengatur hak akses pengguna.
                            </p>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('modules.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label" for="name">Nama Modul <span
                                        class="required-asterisk">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-cube"></i></span>
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Contoh: Document Management" value="{{ old('name') }}" required
                                        autofocus autocomplete="off">
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="slug">Slug (URL) <span
                                        class="required-asterisk">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-link"></i></span>
                                    <input type="text" id="slug" name="slug"
                                        class="form-control @error('slug') is-invalid @enderror"
                                        placeholder="Contoh: document-management" value="{{ old('slug') }}" required>
                                </div>
                                <div class="form-text mt-1">Digunakan untuk parameter URL. Dihasilkan otomatis dari nama
                                    modul.</div>
                                @error('slug')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label class="form-label" for="route_name">Route Name <span
                                        class="required-asterisk">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-navigation"></i></span>
                                    <input type="text" id="route_name" name="route_name"
                                        class="form-control @error('route_name') is-invalid @enderror"
                                        placeholder="Contoh: document.index" value="{{ old('route_name') }}" required>
                                </div>
                                <div class="form-text mt-1">Nama rute pada file <code class="text-primary">web.php</code>
                                    Laravel Anda.</div>
                                @error('route_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4 text-light">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('modules.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bx bx-arrow-back me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                    <i class="bx bx-save me-1"></i> Simpan Modul
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            // Fitur Auto-Slug Pintar
            nameInput.addEventListener('keyup', function() {
                // Hanya auto-fill jika slug masih kosong atau user belum mengubah slug secara manual
                let nameValue = this.value;
                let slugValue = nameValue
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Hapus karakter non-alphanumeric
                    .replace(/[\s_-]+/g, '-') // Ganti spasi dengan strip
                    .replace(/^-+|-+$/g, ''); // Hapus strip di awal dan akhir

                slugInput.value = slugValue;
            });
        });
    </script>
@endpush
