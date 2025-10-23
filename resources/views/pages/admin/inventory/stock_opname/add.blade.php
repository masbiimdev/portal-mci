@extends('layouts.admin')
@section('title', 'Tambah Stock Opname | MCI')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Tambah Stock Opname</h4>

    <form action="{{ route('stock-opname.store') }}" method="POST">
        @csrf
        <div class="card p-3">
            <div class="mb-3">
                <label for="material_id" class="form-label">Pilih Material</label>
                <select name="material_id" id="material_id" class="form-select">
                    <option value="">-- Pilih Material --</option>
                    @foreach ($materials as $m)
                        @php
                            $valves = $m->valves->pluck('valve_name')->implode(', ');
                        @endphp
                        <option value="{{ $m->id }}">
                            {{ $m->material_code }} - {{ $valves ?: 'Tanpa Valve' }} / {{ $m->sparePart->spare_part_name ?? 'Tanpa Spare Part' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="date_opname" class="form-label">Tanggal Opname</label>
                <input type="date" name="date_opname" id="date_opname" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="stock_actual" class="form-label">Stok Fisik (Aktual)</label>
                <input type="number" name="stock_actual" id="stock_actual" class="form-control" min="0" required>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Catatan</label>
                <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('stock-opname.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
