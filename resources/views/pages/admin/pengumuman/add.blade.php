@extends('layouts.admin')

@section('title', 'Tambah Pengumuman | MCI')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Pengumuman /</span> Tambah
    </h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white">
            <h5 class="mb-0"><i class="bx bx-bell"></i> Tambah Pengumuman</h5>
            <a href="{{ route('announcements.index') }}" class="btn btn-light btn-sm">
                <i class="bx bx-left-arrow-alt"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Judul --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" placeholder="Masukkan judul pengumuman"
                               value="{{ old('title') }}" required>
                    </div>
                </div>

                {{-- Isi Pengumuman --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Isi Pengumuman</label>
                    <div class="col-sm-10">
                        <textarea name="content" class="form-control" rows="5" placeholder="Tuliskan isi pengumuman..." required>{{ old('content') }}</textarea>
                    </div>
                </div>

                {{-- Jenis Pengumuman --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Jenis</label>
                    <div class="col-sm-10">
                        <select name="type" class="form-select" required>
                            <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>Info</option>
                            <option value="maintenance" {{ old('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="production" {{ old('type') == 'production' ? 'selected' : '' }}>Production</option>
                            <option value="training" {{ old('type') == 'training' ? 'selected' : '' }}>Training</option>
                            <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                        </select>
                    </div>
                </div>

                {{-- Departemen Tujuan --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Departemen Tujuan</label>
                    <div class="col-sm-10">
                        <select name="department" class="form-select">
                            <option value="">Semua Departemen</option>
                            <option value="QC" {{ old('department') == 'QC' ? 'selected' : '' }}>QC</option>
                            <option value="Machining" {{ old('department') == 'Machining' ? 'selected' : '' }}>Machining</option>
                            <option value="Assembling" {{ old('department') == 'Assembling' ? 'selected' : '' }}>Assembling</option>
                            <option value="Packing" {{ old('department') == 'Packing' ? 'selected' : '' }}>Packing</option>
                        </select>
                    </div>
                </div>

                {{-- Prioritas --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Prioritas</label>
                    <div class="col-sm-10">
                        <select name="priority" class="form-select" required>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>

                {{-- Lampiran (Opsional) --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Lampiran (opsional)</label>
                    <div class="col-sm-10">
                        <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.png,.docx">
                        <small class="text-muted">Maks. 2MB — file PDF, JPG, PNG, DOCX diperbolehkan.</small>
                    </div>
                </div>

                {{-- Tanggal Kadaluarsa --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Berlaku sampai</label>
                    <div class="col-sm-10">
                        <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                        <small class="text-muted">Kosongkan jika pengumuman tidak memiliki batas waktu.</small>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-save"></i> Simpan Pengumuman
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
