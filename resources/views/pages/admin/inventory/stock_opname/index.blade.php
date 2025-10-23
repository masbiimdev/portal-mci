@extends('layouts.admin')

@section('title', 'Stock Opname | MCI')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Stock Management /</span>
        Stock Opname
    </h4>

    <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Daftar Stock Opname</h4>
            <a href="{{ route('stock-opname.create') }}" class="btn btn-primary">+ Tambah Opname</a>
        </div>

        <div class="table-responsive">
            <table id="stockOpnameTable" class="table table-striped table-bordered table-hover">
                <thead style="background-color: #f8f9fa; color: #212529; font-weight: 600;">
                    <tr>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Kode Material</th>
                        <th class="text-center">Nama Material</th>
                        <th class="text-center">Stok Sistem</th>
                        <th class="text-center">Stok Aktual</th>
                        <th class="text-center">Selisih</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($opnames as $item)
                        @php
                            $valves = $item->material->valves->pluck('valve_name')->implode(', ');
                            $spare = $item->material->sparePart->spare_part_name ?? '-';
                        @endphp
                        <tr>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->date_opname)->format('d M Y') }}</td>
                            <td>{{ $item->material->material_code ?? '-' }}</td>
                            <td>{{ $valves ?: '-' }} / {{ $spare }}</td>
                            <td class="text-center">{{ $item->stock_system }}</td>
                            <td class="text-center">{{ $item->stock_actual }}</td>
                            <td class="text-center 
                                {{ $item->selisih < 0 ? 'text-danger fw-bold' : ($item->selisih > 0 ? 'text-success fw-bold' : '') }}">
                                {{ $item->selisih }}
                            </td>
                            <td>{{ $item->warning ?? '-' }}</td>
                            <td class="text-center">
                                @if($item->warning !== 'Sudah disesuaikan')
                                    <form action="{{ route('stock-opname.adjust', $item->id) }}" method="POST" class="d-inline-block adjust-form">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">
                                            Adjustment
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Sudah Disesuaikan</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#stockOpnameTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        columnDefs: [{ orderable: false, targets: 7 }]
    });

    // Konfirmasi sebelum adjustment
    $('.adjust-form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: 'Konfirmasi Adjustment',
            text: "Stok sistem akan disesuaikan dengan stok aktual. Lanjutkan?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Sesuaikan!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Notifikasi sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
});
</script>
@endpush
