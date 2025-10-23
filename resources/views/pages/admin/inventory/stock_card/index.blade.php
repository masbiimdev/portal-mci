@extends('layouts.admin')
@section('title', 'Stock Card | MCI')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Stock Card</h4>

        <div class="card p-4">
            <form method="GET" action="{{ route('stock-card.index') }}" class="row mb-4">
                <div class="col-md-6">
                    <label for="material_id" class="form-label fw-bold">Pilih Material</label>
                    <select name="material_id" id="material_id" class="form-select">
                        <option value="">-- Pilih Material --</option>
                        @foreach ($materials as $m)
                            @php
                                $valveNames = $m->valves->pluck('valve_name')->toArray();
                                $valveList = implode(', ', $valveNames);
                            @endphp
                            <option value="{{ $m->id }}" {{ $selectedMaterial == $m->id ? 'selected' : '' }}>
                                {{ $m->material_code }} -
                                {{ $valveList ?: 'Tanpa Valve' }} /
                                {{ $m->sparePart->spare_part_name ?? 'Tanpa Spare Part' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 align-self-end">
                    <button class="btn btn-primary w-100">Tampilkan</button>
                </div>
            </form>

            @if ($selectedMaterial)
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Stock Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockCard as $row)
                            <tr>
                                <td>{{ $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td>
                                    @if ($row->jenis == 'IN')
                                        <span class="badge bg-success">IN</span>
                                    @elseif($row->jenis == 'OUT')
                                        <span class="badge bg-danger">OUT</span>
                                    @else
                                        <span class="badge bg-secondary">AWAL</span>
                                    @endif
                                </td>
                                <td>{{ $row->notes ?? '-' }}</td>
                                <td class="text-success">{{ $row->jenis == 'IN' ? $row->qty : '' }}</td>
                                <td class="text-danger">{{ $row->jenis == 'OUT' ? $row->qty : '' }}</td>
                                <td class="fw-bold">{{ $row->stock_after }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-muted">Silakan pilih material untuk melihat kartu stok.</div>
            @endif
        </div>
    </div>
@endsection
