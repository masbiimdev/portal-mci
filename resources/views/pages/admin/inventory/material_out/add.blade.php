@extends('layouts.admin')
@section('title', 'Tambah Material Masuk')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-3">➕ Tambah Material Keluar</h4>

        <form action="{{ route('material_out.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Material</label>
                <select name="material_id" class="form-control" required>
                    <option value="">-- Pilih Material --</option>
                    @foreach ($materials as $m)
                        <option value="{{ $m->id }}">
                            {{ $m->valves->pluck('valve_name')->implode(', ') ?: '-' }}
                            \ {{ $m->sparePart->spare_part_name ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Keluar</label>
                <input type="date" name="date_out" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="qty_out" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Catatan</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('material_out.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
