@extends('layouts.admin')

@section('title', 'Edit Alat | QC')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">QC / Tools /</span> Edit
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
                <h5 class="mb-0"><i class="bx bx-edit-alt"></i> Edit Alat</h5>
                <a href="{{ route('tools.index') }}" class="btn btn-light btn-sm">
                    <i class="bx bx-left-arrow-alt"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('tools.update', $tool->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama Alat --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">Nama Item</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_alat" class="form-control"
                                value="{{ old('nama_alat', $tool->nama_alat) }}" required>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">Lokasi</label>
                        <div class="col-sm-10">
                            <input type="text" name="lokasi" class="form-control"
                                value="{{ old('lokasi', $tool->lokasi) }}">
                        </div>
                    </div>

                    {{-- Merek --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">Merek</label>
                        <div class="col-sm-10">
                            <input type="text" name="merek" class="form-control"
                                value="{{ old('merek', $tool->merek) }}">
                        </div>
                    </div>

                    {{-- Nomor Seri --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">No Seri</label>
                        <div class="col-sm-10">
                            <input type="text" name="no_seri" class="form-control"
                                value="{{ old('no_seri', $tool->no_seri) }}">
                        </div>
                    </div>

                    {{-- Kapasitas --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">Kapasitas</label>
                        <div class="col-sm-10">
                            <input type="text" name="kapasitas" class="form-control"
                                value="{{ old('kapasitas', $tool->kapasitas) }}">
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-save"></i> Update Alat
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection
