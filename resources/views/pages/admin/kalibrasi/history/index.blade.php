@extends('layouts.admin')
@section('title', 'History Kalibrasi | QC Calibration')

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
            <span class="text-muted fw-light">QC / Kalibrasi /</span> History Kalibrasi
        </h4>

        <div class="card p-3">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Daftar History Kalibrasi Alat</h4>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table id="historyTable" class="table table-striped table-bordered table-hover">
                    <thead style="background-color: #f8f9fa; font-weight: 600;">
                        <tr>
                            <th>Nama Item</th>
                            <th>Merek</th>
                            <th>No Seri</th>
                            <th>Status Item</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tools as $tool)
                            <tr>
                                <td>{{ $tool->nama_alat }}</td>
                                <td>{{ $tool->merek ?? '-' }}</td>
                                <td>{{ $tool->no_seri ?? '-' }}</td>

                                <td>
                                    @if ($tool->histories->count() > 0)
                                        <span class="badge bg-success">Sudah Ada History</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Ada History</span>
                                    @endif
                                </td>

                                <td class="text-center">

                                    @if ($tool->histories->count() == 0)
                                        <a href="{{ route('histories.create', ['tool_id' => $tool->id, 'from' => 'index']) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-plus-circle"></i> Tambah
                                        </a>
                                    @else
                                        <a href="{{ route('histories.show', $tool->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
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

            // DataTable
            $('#historyTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
            });

            // Success alert
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 2300,
                    showConfirmButton: false
                });
            @endif

        });
    </script>
@endpush
