@extends('layouts.admin')

@section('title', 'Update Pengumuman | MCI')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Pengumuman /</span> Update
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
            <h5 class="mb-0"><i class="bx bx-bell"></i> Update Pengumuman</h5>
            <a href="{{ route('announcements.index') }}" class="btn btn-light btn-sm">
                <i class="bx bx-left-arrow-alt"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title', $announcement->title) }}" required>
                    </div>
                </div>

                {{-- Isi Pengumuman --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Isi Pengumuman</label>
                    <div class="col-sm-10">
                        <textarea name="content" class="form-control" rows="5" required>{{ old('content', $announcement->content) }}</textarea>
                    </div>
                </div>

                {{-- Jenis Pengumuman --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Jenis</label>
                    <div class="col-sm-10">
                        <select name="type" class="form-select" required>
                            <option value="info" {{ old('type', $announcement->type) == 'info' ? 'selected' : '' }}>Info</option>
                            <option value="maintenance" {{ old('type', $announcement->type) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="production" {{ old('type', $announcement->type) == 'production' ? 'selected' : '' }}>Production</option>
                            <option value="training" {{ old('type', $announcement->type) == 'training' ? 'selected' : '' }}>Training</option>
                            <option value="event" {{ old('type', $announcement->type) == 'event' ? 'selected' : '' }}>Event</option>
                        </select>
                    </div>
                </div>

                {{-- Departemen Tujuan --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Departemen Tujuan</label>
                    <div class="col-sm-10">
                        <select name="department" class="form-select">
                            <option value="">Semua Departemen</option>
                            <option value="QC" {{ old('department', $announcement->department) == 'QC' ? 'selected' : '' }}>QC</option>
                            <option value="Machining" {{ old('department', $announcement->department) == 'Machining' ? 'selected' : '' }}>Machining</option>
                            <option value="Assembling" {{ old('department', $announcement->department) == 'Assembling' ? 'selected' : '' }}>Assembling</option>
                            <option value="Packing" {{ old('department', $announcement->department) == 'Packing' ? 'selected' : '' }}>Packing</option>
                        </select>
                    </div>
                </div>

                {{-- Prioritas --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Prioritas</label>
                    <div class="col-sm-10">
                        <select name="priority" class="form-select" required>
                            <option value="low" {{ old('priority', $announcement->priority) == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $announcement->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', $announcement->priority) == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>

                {{-- Lampiran (Opsional) --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Lampiran (opsional)</label>
                    <div class="col-sm-10">
                        @if ($announcement->attachment)
                            <p>File saat ini: <a href="{{ asset('storage/'.$announcement->attachment) }}" target="_blank">{{ basename($announcement->attachment) }}</a></p>
                        @endif
                        <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.png,.docx">
                        <small class="text-muted">Maks. 2MB — file PDF, JPG, PNG, DOCX diperbolehkan.</small>
                    </div>
                </div>

                {{-- Tanggal Kadaluarsa --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-semibold">Berlaku sampai</label>
                    <div class="col-sm-10">
                        <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $announcement->expiry_date) }}">
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-save"></i> Update Pengumuman
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
