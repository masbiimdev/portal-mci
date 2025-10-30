@extends('layouts.admin')
@section('title')
    Tambah Spare Part | MCI
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Spare Parts /</span>
        Tambah
    </h4>

    <div class="card p-3">
        <h5 class="card-header">Form Tambah Spare Part</h5>
        <div class="card-body">
            <form action="{{ route('spare-parts.store') }}" method="POST">
                @csrf

                {{-- ✅ Kode Spare Part dihapus karena otomatis dibuat di controller --}}

                <div class="mb-3">
                    <label for="spare_part_name" class="form-label">Nama Spare Part</label>
                    <input 
                        type="text" 
                        class="form-control @error('spare_part_name') is-invalid @enderror" 
                        id="spare_part_name" 
                        name="spare_part_name" 
                        value="{{ old('spare_part_name') }}" 
                        placeholder="Masukkan nama spare part" 
                        required>
                    @error('spare_part_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea 
                        class="form-control @error('description') is-invalid @enderror" 
                        id="description" 
                        name="description" 
                        rows="3" 
                        placeholder="Deskripsi spare part (opsional)">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('spare-parts.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Spare Part</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
