@extends('layouts.admin')
@section('title', 'Tambah Material | MCI')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Tambah Material</h4>

        <form action="{{ route('materials.store') }}" method="POST">
            @csrf
            <div class="card p-3">
                <div class="mb-3">
                    <label>Kode Material</label>
                    <input type="text" name="material_code" class="form-control" required>
                </div>
                {{-- <div class="mb-3">
                <label>Nama Material</label>
                <input type="text" name="material_name" class="form-control" required>
            </div> --}}
                <div class="mb-3">
                    <label for="valve_id" class="form-label fw-bold">Pilih Valve</label>
                    <select name="valve_id[]" id="valve_id" class="form-select select2" multiple>
                        @foreach ($valves as $v)
                            <option value="{{ $v->id }}">{{ $v->valve_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Spare Part</label>
                    <select name="spare_part_id" class="form-control">
                        <option value="">-- Pilih Spare Part --</option>
                        @foreach ($spareParts as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->spare_part_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>No Drawing</label>
                    <input type="text" name="no_drawing" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Heat/Lot No</label>
                    <input type="text" name="heat_lot_no" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Dimensi</label>
                    <input type="text" name="dimensi" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Stok Awal</label>
                        <input type="number" name="stock_awal" class="form-control" value="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Stok Minimum</label>
                        <input type="number" name="stock_minimum" class="form-control" value="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Rak</label>
                    <select name="rack_id" class="form-control">
                        <option value="">-- Pilih Rak --</option>
                        @foreach ($racks as $r)
                            <option value="{{ $r->id }}">{{ $r->rack_code }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('materials.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
@endsection
