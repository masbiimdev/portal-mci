@extends('layouts.admin')

@section('title', 'Edit Project | Document Portal')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Document / Master / Project /</span> Edit
        </h4>

        {{-- Alert Global Error --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bx bx-error-circle fs-4 me-2"></i>
                    <strong class="fs-6">Terjadi Kesalahan!</strong>
                </div>
                <ul class="mb-0 ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            {{-- Header Card --}}
            <div class="card-header border-bottom bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold text-primary d-flex align-items-center">
                    <i class="bx bx-edit-alt fs-4 me-2"></i> Edit Project
                </h5>
                <a href="{{ route('document.project.index') }}"
                    class="btn btn-outline-secondary btn-sm rounded-pill shadow-sm px-3">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>

            {{-- Body Card --}}
            <div class="card-body pt-4">
                {{-- PENTING: Tambahkan enctype="multipart/form-data" untuk upload file --}}
                <form action="{{ route('document.project.update', $project->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Project Code (Readonly) --}}
                    <div class="mb-3 row">
                        <label for="project_code" class="col-sm-2 col-form-label fw-semibold text-secondary">Project
                            Code</label>
                        <div class="col-sm-10">
                            <input type="text" id="project_code" class="form-control bg-light text-muted"
                                style="cursor: not-allowed;" value="{{ $project->project_code }}" readonly>
                            <small class="text-muted"><i class="bx bx-info-circle"></i> Kode project dibuat otomatis oleh
                                sistem.</small>
                        </div>
                    </div>

                    {{-- Project Number --}}
                    <div class="mb-3 row">
                        <label for="project_number" class="col-sm-2 col-form-label fw-semibold text-secondary">
                            No Project <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="project_number" name="project_number"
                                class="form-control @error('project_number') is-invalid @enderror"
                                value="{{ old('project_number', $project->project_number) }}"
                                placeholder="Masukkan nomor project..." required>
                            @error('project_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Project Name --}}
                    <div class="mb-3 row">
                        <label for="project_name" class="col-sm-2 col-form-label fw-semibold text-secondary">
                            Nama Project <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="project_name" name="project_name"
                                class="form-control @error('project_name') is-invalid @enderror"
                                value="{{ old('project_name', $project->project_name) }}"
                                placeholder="Masukkan nama project..." required>
                            @error('project_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Project Image --}}
                    <div class="mb-3 row">
                        <label for="project_image" class="col-sm-2 col-form-label fw-semibold text-secondary">
                            Gambar Project
                        </label>
                        <div class="col-sm-10">
                            {{-- Tampilkan gambar lama jika ada --}}
                            @if ($project->project_image)
                                <div class="mb-2">
                                    <img src="{{ asset($project->project_image) }}" alt="Current Project Image"
                                        class="img-thumbnail" style="max-height: 150px; border-radius: 8px;">
                                    <div class="mt-1">
                                        <small class="text-muted">Gambar saat ini. Biarkan kosong jika tidak ingin
                                            mengubahnya.</small>
                                    </div>
                                </div>
                            @endif

                            <input type="file" id="project_image" name="project_image"
                                class="form-control @error('project_image') is-invalid @enderror"
                                accept="image/jpeg, image/png, image/jpg">
                            <small class="text-muted">Format yang diizinkan: JPG, JPEG, PNG. Maksimal ukuran file:
                                2MB.</small>
                            @error('project_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Start Date --}}
                    <div class="mb-3 row">
                        <label for="start_date" class="col-sm-2 col-form-label fw-semibold text-secondary">Start
                            Date</label>
                        <div class="col-sm-10">
                            <input type="date" id="start_date" name="start_date"
                                class="form-control @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date', $project->start_date) }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- End Date --}}
                    <div class="mb-3 row">
                        <label for="end_date" class="col-sm-2 col-form-label fw-semibold text-secondary">End Date</label>
                        <div class="col-sm-10">
                            <input type="date" id="end_date" name="end_date"
                                class="form-control @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date', $project->end_date) }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4 row">
                        <label for="status" class="col-sm-2 col-form-label fw-semibold text-secondary">
                            Status <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <select id="status" name="status"
                                class="form-select @error('status') is-invalid @enderror" required>
                                @php
                                    $statuses = ['PENDING', 'ACTIVE', 'ARCHIVED'];
                                @endphp
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status', $project->status) === $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4 mx-n4">

                    {{-- Action Buttons --}}
                    <div class="row justify-content-end">
                        <div class="col-sm-10 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="bx bx-save me-1"></i> Update Project
                            </button>
                            <button type="reset" class="btn btn-label-secondary px-4">
                                <i class="bx bx-refresh me-1"></i> Reset
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
