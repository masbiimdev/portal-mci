@extends('layouts.admin')

@section('title', 'Edit Alat | QC')

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
            box-shadow: none;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #696cff;
            /* Primary color focus */
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
            <span class="text-muted fw-light">Quality Control / Master Alat /</span> Edit Alat
        </h4>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bx bx-error-circle fs-4 me-2"></i>
                    <strong class="mb-0">Gagal menyimpan pembaruan!</strong>
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
                            <i class="bx bx-edit-alt fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Perbarui Data Alat</h5>
                            <p class="mb-0 text-muted small">Ubah informasi spesifikasi alat untuk sistem kalibrasi.</p>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('tools.update', $tool->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6 class="fw-semibold text-primary mb-3"><i class="bx bx-tag-alt me-1"></i> Identitas
                                        Alat</h6>

                                    {{-- Nama Alat --}}
                                    <div class="mb-3">
                                        <label class="form-label">Nama Item <span class="required-asterisk">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-box"></i></span>
                                            <input type="text" name="nama_alat" class="form-control"
                                                placeholder="Misal: Digital Flowmeter"
                                                value="{{ old('nama_alat', $tool->nama_alat) }}" required autofocus>
                                        </div>
                                    </div>

                                    {{-- Merek --}}
                                    <div class="mb-3">
                                        <label class="form-label">Merek Pabrikan</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-purchase-tag"></i></span>
                                            <input type="text" name="merek" class="form-control"
                                                placeholder="Misal: SIARGO" value="{{ old('merek', $tool->merek) }}">
                                        </div>
                                    </div>

                                    {{-- Nomor Seri --}}
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Seri (SN)</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                                            <input type="text" name="no_seri" class="form-control"
                                                placeholder="Misal: 246137" value="{{ old('no_seri', $tool->no_seri) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="fw-semibold text-primary mb-3"><i class="bx bx-sliders me-1"></i> Spesifikasi
                                        & Posisi</h6>

                                    {{-- Kapasitas --}}
                                    <div class="mb-3">
                                        <label class="form-label">Kapasitas / Range</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-tachometer"></i></span>
                                            <input type="text" name="kapasitas" class="form-control"
                                                placeholder="Misal: 0~20 SCFH"
                                                value="{{ old('kapasitas', $tool->kapasitas) }}">
                                        </div>
                                    </div>

                                    {{-- Lokasi --}}
                                    <div class="mb-3">
                                        <label class="form-label">Lokasi Penyimpanan</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                                            <input type="text" name="lokasi" class="form-control"
                                                placeholder="Misal: Rak Penyimpanan QC"
                                                value="{{ old('lokasi', $tool->lokasi) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 border-light">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('tools.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bx bx-arrow-back me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                    <i class="bx bx-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
