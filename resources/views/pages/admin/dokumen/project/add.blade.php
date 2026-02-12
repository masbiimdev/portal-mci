@extends('layouts.admin')

@section('title', 'Tambah Project | Document')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Document / Project /</span> Tambah
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
            <div class="card-header text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bx bx-folder-plus"></i> Tambah Project
                </h5>
                <a href="{{ route('document.project.index') }}" class="btn btn-light btn-sm">
                    <i class="bx bx-left-arrow-alt"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('document.project.store') }}" method="POST">
                    @csrf

                    {{-- Project Number --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">
                            Project Number
                        </label>
                        <div class="col-sm-10">
                            <input type="text" name="project_number" class="form-control"
                                value="{{ old('project_number') }}" placeholder="Misal: 001/MTC/I/2025" required>
                        </div>
                    </div>

                    {{-- Project Name --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">
                            Project Name
                        </label>
                        <div class="col-sm-10">
                            <input type="text" name="project_name" class="form-control" value="{{ old('project_name') }}"
                                placeholder="Misal: Pembangunan Line Produksi" required>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">
                            Description
                        </label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat project (opsional)">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">
                            Status
                        </label>
                        <div class="col-sm-10">
                            <select name="status" class="form-select" required>
                                <option value="PENDING" {{ old('status') == 'PENDING' ? 'selected' : '' }}>
                                    PENDING
                                </option>
                                <option value="ACTIVE" {{ old('status') == 'ACTIVE' ? 'selected' : '' }}>
                                    ACTIVE
                                </option>
                                <option value="ARCHIVED" {{ old('status') == 'ARCHIVED' ? 'selected' : '' }}>
                                    ARCHIVED
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- Start & End Date --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">
                            Start Date
                        </label>
                        <div class="col-sm-4">
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                        </div>

                        <label class="col-sm-2 col-form-label fw-semibold">
                            End Date
                        </label>
                        <div class="col-sm-4">
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                        </div>
                    </div>

                    {{-- Action --}}
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-save"></i> Simpan Project
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
