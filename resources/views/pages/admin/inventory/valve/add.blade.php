@extends('layouts.admin')
@section('title')
    Tambah Valve | MCI
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Valves /</span>
        Tambah
    </h4>

    <div class="card p-3">
        <h5 class="card-header">Form Tambah Valve</h5>
        <div class="card-body">
            <form action="{{ route('valves.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="valve_code" class="form-label">Kode Valve</label>
                    <input type="text" class="form-control @error('valve_code') is-invalid @enderror" id="valve_code" name="valve_code" value="{{ old('valve_code') }}" placeholder="Contoh: VLV-001" required>
                    @error('valve_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="valve_name" class="form-label">Nama Valve</label>
                    <input type="text" class="form-control @error('valve_name') is-invalid @enderror" id="valve_name" name="valve_name" value="{{ old('valve_name') }}" placeholder="Masukkan nama valve" required>
                    @error('valve_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Deskripsi valve (opsional)">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('valves.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Valve</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
