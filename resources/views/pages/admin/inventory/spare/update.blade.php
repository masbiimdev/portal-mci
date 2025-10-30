@extends('layouts.admin')
@section('title')
    Edit Spare Part | MCI
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Spare Parts /</span>
        Edit
    </h4>

    <div class="card p-3">
        <h5 class="card-header">Form Edit Spare Part</h5>
        <div class="card-body">
            <form action="{{ route('spare-parts.update', $sparePart->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ✅ Code tetap tampil tapi tidak bisa diubah --}}
                <div class="mb-3">
                    <label for="spare_part_code" class="form-label">Kode Spare Part</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="spare_part_code" 
                        value="{{ $sparePart->spare_part_code }}" 
                        readonly>

                    {{-- ✅ Hidden input untuk tetap mengirim code ke server --}}
                    <input type="hidden" name="spare_part_code" value="{{ $sparePart->spare_part_code }}">
                </div>

                <div class="mb-3">
                    <label for="spare_part_name" class="form-label">Nama Spare Part</label>
                    <input 
                        type="text" 
                        class="form-control @error('spare_part_name') is-invalid @enderror" 
                        id="spare_part_name" 
                        name="spare_part_name" 
                        value="{{ old('spare_part_name', $sparePart->spare_part_name) }}" 
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
                        rows="3">{{ old('description', $sparePart->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('spare-parts.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Perbarui Spare Part</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
