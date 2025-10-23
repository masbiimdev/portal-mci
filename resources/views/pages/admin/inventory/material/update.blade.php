@extends('layouts.admin')
@section('title', 'Edit Material | MCI')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Edit Material</h4>

    <form action="{{ route('materials.update', $material->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card p-3">
            <div class="mb-3">
                <label for="material_code" class="form-label">Kode Material</label>
                <input type="text" id="material_code" name="material_code"
                    class="form-control @error('material_code') is-invalid @enderror"
                    value="{{ old('material_code', $material->material_code) }}" required>
                @error('material_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="valve_id" class="form-label">Valve</label>
                    <select id="valve_id" name="valve_id" class="form-control @error('valve_id') is-invalid @enderror">
                        <option value="">-- Pilih Valve --</option>
                        @foreach ($valves as $v)
                            <option value="{{ $v->id }}" {{ old('valve_id', $material->valve_id) == $v->id ? 'selected' : '' }}>
                                {{ $v->valve_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('valve_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="spare_part_id" class="form-label">Spare Part</label>
                    <select id="spare_part_id" name="spare_part_id"
                        class="form-control @error('spare_part_id') is-invalid @enderror">
                        <option value="">-- Pilih Spare Part --</option>
                        @foreach ($spareParts as $sp)
                            <option value="{{ $sp->id }}" {{ old('spare_part_id', $material->spare_part_id) == $sp->id ? 'selected' : '' }}>
                                {{ $sp->spare_part_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('spare_part_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="no_drawing" class="form-label">No Drawing</label>
                    <input type="text" id="no_drawing" name="no_drawing" class="form-control"
                        value="{{ old('no_drawing', $material->no_drawing) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="heat_lot_no" class="form-label">Heat/Lot No</label>
                    <input type="text" id="heat_lot_no" name="heat_lot_no" class="form-control"
                        value="{{ old('heat_lot_no', $material->heat_lot_no) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="dimensi" class="form-label">Dimensi</label>
                    <input type="text" id="dimensi" name="dimensi" class="form-control"
                        value="{{ old('dimensi', $material->dimensi) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="stock_awal" class="form-label">Stok Awal</label>
                    <input type="number" id="stock_awal" name="stock_awal"
                        class="form-control @error('stock_awal') is-invalid @enderror"
                        value="{{ old('stock_awal', $material->stock_awal) }}" min="0">
                    @error('stock_awal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="stock_minimum" class="form-label">Stok Minimum</label>
                    <input type="number" id="stock_minimum" name="stock_minimum"
                        class="form-control @error('stock_minimum') is-invalid @enderror"
                        value="{{ old('stock_minimum', $material->stock_minimum) }}" min="0">
                    @error('stock_minimum')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="rack_id" class="form-label">Rak</label>
                <select id="rack_id" name="rack_id" class="form-control @error('rack_id') is-invalid @enderror">
                    <option value="">-- Pilih Rak --</option>
                    @foreach ($racks as $r)
                        <option value="{{ $r->id }}" {{ old('rack_id', $material->rack_id) == $r->id ? 'selected' : '' }}>
                            {{ $r->rack_code }}
                        </option>
                    @endforeach
                </select>
                @error('rack_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('materials.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update Material</button>
            </div>
        </div>
    </form>
</div>
@endsection
