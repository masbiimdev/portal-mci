@extends('layouts.admin')
@section('title', 'Master Alat | QC Calibration')

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
            <span class="text-muted fw-light">QC / Kalibrasi /</span> List Tool
        </h4>

        <div class="card p-3">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Daftar Alat</h4>

                <div class="d-flex gap-2">
                    <a href="{{ route('tools.printAll') }}" target="_blank" class="btn btn-secondary">
                        Cetak Semua
                    </a>

                    <a href="{{ route('tools.create') }}" class="btn btn-primary">
                        + Tambah Alat
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table id="toolsTable" class="table table-striped table-bordered table-hover">
                    <thead style="background-color: #f8f9fa; font-weight: 600;">
                        <tr>
                            <th class="text-center">Nama Item</th>
                            <th class="text-center">Merek</th>
                            <th class="text-center">No Seri</th>
                            <th class="text-center">Lokasi</th>
                            <th class="text-center">Kapasitas</th>
                            <th class="text-center">QR</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tools as $tool)
                            <tr>
                                <td>{{ $tool->nama_alat }}</td>
                                <td>{{ $tool->merek ?? '-' }}</td>
                                <td>{{ $tool->no_seri ?? '-' }}</td>
                                <td>{{ $tool->lokasi ?? '-' }}</td>
                                <td>{{ $tool->kapasitas ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($tool->qr_code_path)
                                        <img src="{{ asset('storage/' . $tool->qr_code_path) }}"
                                            width="50" height="50" alt="QR Code">
                                    @else
                                        <span>Tidak ada QR Code</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">

                                        {{-- Detail --}}
                                        <a href="{{ route('tools.show', $tool->id) }}" class="btn btn-sm btn-info">
                                            Detail
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('tools.edit', $tool->id) }}" class="btn btn-sm btn-primary">
                                            Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('tools.destroy', $tool->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
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
        $(document).ready(function() {

            $('#toolsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
            });

            // Delete confirmation
            $('#toolsTable').on('submit', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Hapus Alat?',
                    text: "Data tidak bisa dikembalikan!",
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

            // Success alert
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
