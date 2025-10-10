@extends('layouts.admin')
@section('title', 'Pengumuman | MCI')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">📢 Daftar Pengumuman</h4>
        <a href="{{ route('announcements.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Tambah Pengumuman
        </a>
    </div>

    {{-- Filter Section --}}
    <form method="GET" action="{{ route('announcements.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="type" class="form-select">
                <option value="">Semua Jenis</option>
                <option value="info" {{ request('type')=='info'?'selected':'' }}>Info</option>
                <option value="maintenance" {{ request('type')=='maintenance'?'selected':'' }}>Maintenance</option>
                <option value="production" {{ request('type')=='production'?'selected':'' }}>Production</option>
                <option value="training" {{ request('type')=='training'?'selected':'' }}>Training</option>
                <option value="event" {{ request('type')=='event'?'selected':'' }}>Event</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="department" class="form-select">
                <option value="">Semua Departemen</option>
                <option value="QC" {{ request('department')=='QC'?'selected':'' }}>QC</option>
                <option value="Machining" {{ request('department')=='Machining'?'selected':'' }}>Machining</option>
                <option value="Assembling" {{ request('department')=='Assembling'?'selected':'' }}>Assembling</option>
                <option value="Packing" {{ request('department')=='Packing'?'selected':'' }}>Packing</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="priority" class="form-select">
                <option value="">Semua Prioritas</option>
                <option value="low" {{ request('priority')=='low'?'selected':'' }}>Low</option>
                <option value="medium" {{ request('priority')=='medium'?'selected':'' }}>Medium</option>
                <option value="high" {{ request('priority')=='high'?'selected':'' }}>High</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-outline-primary w-100" type="submit">
                <i class="bx bx-filter-alt"></i> Filter
            </button>
        </div>
    </form>

    {{-- Tabel Pengumuman --}}
    <div class="card p-3">
        <div class="table-responsive">
            <table id="announcementsTable" class="table table-striped table-bordered table-hover text-nowrap">
                <thead style="background-color: #f8f9fa; font-weight: 600;">
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Departemen</th>
                        <th>Prioritas</th>
                        <th>Author</th>
                        <th>Berlaku Hingga</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($annons as $index => $a)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $a->title }}</td>
                            <td><span class="badge bg-info text-dark text-capitalize">{{ $a->type }}</span></td>
                            <td>{{ $a->department ?? 'Semua Departemen' }}</td>
                            <td>
                                @php
                                    $priorityColors = ['low'=>'success','medium'=>'warning','high'=>'danger'];
                                @endphp
                                <span class="badge bg-{{ $priorityColors[$a->priority] ?? 'secondary' }}">
                                    {{ ucfirst($a->priority) }}
                                </span>
                            </td>
                            <td>{{ $a->author->name ?? 'Admin' }}</td>
                            <td>{{ $a->expiry_date ? date('d M Y', strtotime($a->expiry_date)) : '-' }}</td>
                            <td>
                                @if($a->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    {{-- <a href="{{ route('announcements.show', $a->id) }}" class="btn btn-sm btn-info">
                                        <i class="bx bx-show"></i>
                                    </a> --}}
                                    <a href="{{ route('announcements.edit', $a->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('announcements.destroy', $a->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
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
    $('#announcementsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [[0, 'asc']],
        columnDefs: [{ orderable: false, targets: 8 }] // Kolom aksi tidak bisa di-sort
    });

    // SweetAlert untuk tombol Delete
    $('#announcementsTable').on('submit', '.delete-form', function(e) {
        e.preventDefault();
        let form = this;

        Swal.fire({
            title: 'Yakin hapus pengumuman?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if(result.isConfirmed) form.submit();
        });
    });

    // SweetAlert untuk session success
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
