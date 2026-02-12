@extends('layouts.admin')
@section('title', 'Master Project | Document')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        table.dataTable td,
        table.dataTable th {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Document / Master /</span> Project
    </h4>

    <div class="card p-3">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Daftar Project</h4>

            <a href="{{ route('document.project.create') }}" class="btn btn-primary">
                + Tambah Project
            </a>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table id="projectsTable" class="table table-striped table-bordered table-hover">
                <thead style="background-color: #f8f9fa; font-weight: 600;">
                    <tr>
                        <th>Kode Project</th>
                        <th>No Project</th>
                        <th>Nama Project</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>{{ $project->project_code }}</td>
                            <td>{{ $project->project_number }}</td>
                            <td>{{ $project->project_name }}</td>
                            <td>
                                <span class="badge bg-{{ $project->status === 'PENDING' ? 'warning' : 'success' }}">
                                    {{ $project->status }}
                                </span>
                            </td>
                            <td>
                                {{ $project->start_date
                                    ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y')
                                    : '-' }}
                            </td>
                            <td>
                                {{ $project->end_date
                                    ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y')
                                    : '-' }}
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">

                                    <a href="#"
                                       class="btn btn-sm btn-info">
                                        Detail
                                    </a>

                                    <a href="{{ route('document.project.edit', $project->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>

                                    <form action="#"
                                          method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger">
                                            Delete
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
$(document).ready(function () {

    $('#projectsTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
    });

    $('#projectsTable').on('submit', '.delete-form', function(e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
            title: 'Hapus Project?',
            text: 'Data tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });

    @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false
    });
    @endif

});
</script>
@endpush
