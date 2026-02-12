@extends('layouts.admin')
@section('title', 'Tambah Folder')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Document / Project /</span>
        {{ $project->project_name }} / Tambah Folder
    </h4>

    <div class="card p-4">

        <div class="mb-3">
            <strong>Project Code:</strong>
            <span class="badge bg-label-primary">
                {{ $project->project_number }}
            </span>
        </div>

        <form action="{{ route('document.folders.store', $project->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Folder Name</label>
                <input type="text"
                       name="folder_name"
                       class="form-control @error('folder_name') is-invalid @enderror"
                       value="{{ old('folder_name') }}"
                       placeholder="Drawing, Specification, RFI"
                       required>
                @error('folder_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Folder Code</label>
                <input type="text"
                       name="folder_code"
                       class="form-control @error('folder_code') is-invalid @enderror"
                       value="{{ old('folder_code') }}"
                       placeholder="FDR-DWG"
                       required>
                @error('folder_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description"
                          class="form-control"
                          rows="3"
                          placeholder="Keterangan folder (opsional)">{{ old('description') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Simpan Folder
                </button>
                <a href="{{ route('document.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>
@endsection
