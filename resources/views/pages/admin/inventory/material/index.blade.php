@extends('layouts.admin')
@section('title', 'Materials | MCI')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
.badge-valve {
    background-color: #0d6efd;
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    margin: 1px;
    display: inline-block;
}
</style>
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Daftar Material</h4>

    <div class="card p-3 shadow-sm">
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <h5 class="mb-0">Master Material</h5>
            <a href="{{ route('materials.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Material
            </a>
        </div>

        <div class="table-responsive">
            <table id="materialsTable" class="table table-bordered table-striped align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Kode</th>
                        <th>Valve</th>
                        <th>Spare Part</th>
                        <th>No Drawing</th>
                        <th>Dimensi</th>
                        <th>Stok Awal</th>
                        <th>Minimum</th>
                        <th>Rak</th>
                        <th>Stok Terakhir</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materials as $m)
                    <tr>
                        <td>{{ $m->material_code }}</td>

                        {{-- ✅ Multiple valve tampil rapi --}}
                        <td>
                            @forelse ($m->valves as $v)
                                <span class="badge-valve">{{ $v->valve_name }}</span>
                            @empty
                                <em>-</em>
                            @endforelse
                        </td>

                        {{-- ✅ Spare part --}}
                        <td>{{ $m->spare_part->spare_part_name ?? '-' }}</td>

                        <td>{{ $m->no_drawing ?? '-' }}</td>
                        <td>{{ $m->dimensi ?? '-' }}</td>
                        <td class="text-center">{{ $m->stock_awal }}</td>
                        <td class="text-center">{{ $m->stock_minimum }}</td>
                        <td class="text-center">{{ $m->rack->rack_code ?? '-' }}</td>

                        {{-- ✅ Stok terakhir (jika belum ada field, bisa tampilkan stock_awal dulu) --}}
                        <td class="text-center">{{ $m->stock_after ?? $m->stock_awal }}</td>

                        {{-- ✅ Tombol aksi --}}
                        <td class="text-center">
                            <a href="{{ route('materials.edit', $m->id) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <form action="{{ route('materials.destroy', $m->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus material ini?')">
                                    <i class="bx bx-trash"></i> Hapus
                                </button>
                            </form>
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
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(function() {
    $('#materialsTable').DataTable({
        pageLength: 10,
        ordering: true,
        responsive: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Tidak ada data ditemukan",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
            infoFiltered: "(disaring dari total _MAX_ data)",
        }
    });
});
</script>
@endpush
