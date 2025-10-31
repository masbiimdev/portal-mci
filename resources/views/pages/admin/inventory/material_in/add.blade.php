@extends('layouts.admin')
@section('title', 'Tambah Material Masuk')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-3">➕ Tambah Material Masuk</h4>

        <form action="{{ route('material_in.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Material</label>
                <select name="material_id" id="material_id" class="form-select select2" required>
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
                <label>Tanggal Masuk</label>
                <input type="date" name="date_in" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="qty_in" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Catatan</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('material_in.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#material_id').select2({
            placeholder: "-- Pilih Material --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
