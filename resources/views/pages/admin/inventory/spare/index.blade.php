@extends('layouts.admin')

@section('title')
    Spare Parts | MCI
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Spare Parts /</span>
        List
    </h4>

    <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Daftar Spare Parts</h4>
            <a href="{{ route('spare-parts.create') }}" class="btn btn-primary">+ Tambah Spare Part</a>
        </div>

        <div class="table-responsive">
            <table id="sparePartsTable" class="table table-striped table-bordered table-hover">
                <thead style="background-color: #f8f9fa; color: #212529; font-weight: 600;">
                    <tr>
                        <th class="text-center">Kode Spare Part</th>
                        <th class="text-center">Nama Spare Part</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spareParts as $sp)
                        <tr>
                            <td>{{ $sp->spare_part_code }}</td>
                            <td>{{ $sp->spare_part_name }}</td>
                            <td>{{ $sp->description ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('spare-parts.edit', $sp->id) }}" class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                    <form action="{{ route('spare-parts.destroy', $sp->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
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
    $('#sparePartsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        columnDefs: [{ orderable: false, targets: 3 }]
    });

    $('#sparePartsTable tbody').on('submit', '.delete-form', function(e) {
        e.preventDefault();
        var form = this;

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Spare part yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

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
