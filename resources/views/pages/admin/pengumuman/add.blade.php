@extends('layouts.admin')

@section('title', 'Tambah Pengumuman | MCI')

@push('css')
    <style>
        .form-label {
            font-weight: 600;
            color: #566a7f;
            margin-bottom: 0.5rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1);
        }

        .file-upload-wrapper {
            border: 2px dashed #d9dee3;
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.2s ease-in-out;
        }

        .file-upload-wrapper:hover {
            border-color: #696cff;
            background-color: rgba(105, 108, 255, 0.05);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold mb-1">
                    <span class="text-muted fw-light">Pengumuman /</span> Tambah Pengumuman Baru
                </h4>
                <p class="text-muted mb-0">Isi formulir di bawah ini untuk menyiarkan informasi kepada tim.</p>
            </div>
            <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bx bx-left-arrow-alt me-1"></i> Kembali ke Daftar
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bx bx-error-circle fs-4 me-2"></i>
                    <strong class="fs-6">Terjadi Kesalahan!</strong>
                </div>
                <ul class="mb-0 ms-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom pt-4 pb-3">
                <h5 class="mb-0 text-primary d-flex align-items-center">
                    <i class="bx bx-edit-alt fs-4 me-2"></i> Detail Informasi Pengumuman
                </h5>
            </div>

            <div class="card-body pt-4">
                <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-8">
                            {{-- Judul --}}
                            <div class="mb-3">
                                <label class="form-label" for="title">Judul Pengumuman <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control form-control-lg"
                                    placeholder="Contoh: Jadwal Maintenance Server Bulan Ini" value="{{ old('title') }}"
                                    required>
                            </div>

                            {{-- Isi Pengumuman --}}
                            <div class="mb-3">
                                <label class="form-label" for="content">Isi Pengumuman <span
                                        class="text-danger">*</span></label>
                                <textarea id="content" name="content" class="form-control" rows="8"
                                    placeholder="Tuliskan deskripsi atau isi pengumuman secara detail..." required>{{ old('content') }}</textarea>
                            </div>

                            {{-- Lampiran --}}
                            <div class="mb-3">
                                <label class="form-label d-block">Lampiran Dokumen (Opsional)</label>
                                <div class="file-upload-wrapper">
                                    <i class="bx bx-cloud-upload fs-1 text-muted mb-2"></i>
                                    <input type="file" name="attachment" id="attachment" class="form-control"
                                        accept=".pdf,.jpg,.png,.docx">
                                    <div class="form-text mt-2 text-muted">Maksimal ukuran file 2MB. Format yang didukung:
                                        PDF, JPG, PNG, DOCX.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded-3 border">
                                <h6 class="fw-bold mb-3 text-uppercase text-muted fs-7">Pengaturan Siaran</h6>

                                {{-- Jenis --}}
                                <div class="mb-3">
                                    <label class="form-label" for="type">Jenis Pengumuman <span
                                            class="text-danger">*</span></label>
                                    <select id="type" name="type" class="form-select" required>
                                        <option value="" disabled {{ old('type') ? '' : 'selected' }}>Pilih
                                            Kategori...</option>
                                        <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>Info Umum
                                        </option>
                                        <option value="maintenance" {{ old('type') == 'maintenance' ? 'selected' : '' }}>
                                            Maintenance</option>
                                        <option value="production" {{ old('type') == 'production' ? 'selected' : '' }}>
                                            Production</option>
                                        <option value="training" {{ old('type') == 'training' ? 'selected' : '' }}>Training
                                        </option>
                                        <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event/Acara
                                        </option>
                                    </select>
                                </div>

                                {{-- Departemen Tujuan --}}
                                <div class="mb-3">
                                    <label class="form-label" for="department">Departemen Tujuan</label>
                                    <select id="department" name="department" class="form-select">
                                        <option value="">Semua Departemen (Publik)</option>
                                        <option value="QC" {{ old('department') == 'QC' ? 'selected' : '' }}>QC
                                        </option>
                                        <option value="Machining" {{ old('department') == 'Machining' ? 'selected' : '' }}>
                                            Machining</option>
                                        <option value="Assembling"
                                            {{ old('department') == 'Assembling' ? 'selected' : '' }}>Assembling</option>
                                        <option value="Packing" {{ old('department') == 'Packing' ? 'selected' : '' }}>
                                            Packing</option>
                                    </select>
                                </div>

                                {{-- Prioritas --}}
                                <div class="mb-3">
                                    <label class="form-label" for="priority">Tingkat Prioritas <span
                                            class="text-danger">*</span></label>
                                    <select id="priority" name="priority" class="form-select" required>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>🟢 Low
                                            (Biasa)</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>🟡
                                            Medium (Penting)</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>🔴 High
                                            (Mendesak)</option>
                                    </select>
                                </div>

                                {{-- Tanggal Kadaluarsa --}}
                                <div class="mb-4">
                                    <label class="form-label" for="expiry_date">Masa Berlaku (Expired)</label>
                                    <input type="date" id="expiry_date" name="expiry_date" class="form-control"
                                        value="{{ old('expiry_date') }}">
                                    <div class="form-text mt-1 text-muted">Kosongkan jika pengumuman berlaku selamanya.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-label-secondary">Reset Form</button>
                        <button type="submit" class="btn btn-primary text-white shadow-sm px-4">
                            <i class="bx bx-send me-1"></i> Terbitkan Pengumuman
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
