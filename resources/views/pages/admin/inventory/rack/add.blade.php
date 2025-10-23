@extends('layouts.admin')
@section('title', 'Tambah Rack | MCI')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Racks /</span> Tambah
    </h4>

    <div class="card p-3">
        <h5 class="card-header">Form Tambah Rack</h5>
        <div class="card-body">
            <form action="{{ route('racks.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="rack_code" class="form-label">Kode Rack</label>
                    <input type="text" class="form-control @error('rack_code') is-invalid @enderror" name="rack_code" value="{{ old('rack_code') }}" placeholder="Contoh: R-01" required>
                    @error('rack_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="rack_name" class="form-label">Nama Rack</label>
                    <input type="text" class="form-control @error('rack_name') is-invalid @enderror" name="rack_name" value="{{ old('rack_name') }}" required>
                    @error('rack_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('racks.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Rack</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
