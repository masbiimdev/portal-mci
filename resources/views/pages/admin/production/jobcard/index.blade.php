@extends('layouts.admin')
@section('title')
    Jobcards | MCI
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Jobcards /</span>
            List
        </h4>

        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Daftar Jobcard</h4>
                <a href="{{ route('jobcards.create') }}" class="btn btn-primary">+ Tambah Jobcard</a>
            </div>

            {{-- 🔍 Filter Section --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="filterType" class="form-label fw-semibold">Tipe Jobcard</label>
                    <select id="filterType" class="form-select">
                        <option value="">Semua</option>
                        @foreach ($jobcards->pluck('type_jobcard')->unique() as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterCustomer" class="form-label fw-semibold">Customer</label>
                    <select id="filterCustomer" class="form-select">
                        <option value="">Semua</option>
                        @foreach ($jobcards->pluck('customer')->unique() as $cust)
                            <option value="{{ $cust }}">{{ $cust }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterTanggal" class="form-label fw-semibold">Tanggal</label>
                    <input type="date" id="filterTanggal" class="form-control">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button id="resetFilter" class="btn btn-secondary w-100">Reset Filter</button>
                </div>
            </div>

            {{-- 🧾 Table --}}
            <div class="table-responsive">
                <table id="jobcardsTable" class="table table-striped table-bordered table-hover">
                    <thead style="background-color: #f8f9fa; color: #212529; font-weight: 600;">
                        <tr>
                            <th class="text-center">ID. Jobcard</th>
                            <th class="text-center">Tipe Jobcard</th>
                            <th class="text-center">Part Type</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">WS No</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobcards as $job)
                            <tr>
                                <td>{{ $job->jobcard_id }}</td>
                                <td>{{ $job->type_jobcard }}</td>
                                <td>{{ $job->type_valve ?? '-' }}</td>
                                <td>{{ $job->customer ?? '-' }}</td>
                                <td>{{ $job->ws_no ?? '-' }}</td>
                                <td>{{ $job->creator->name ?? '-' }}</td>
                                <td>{{ $job->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('jobcards.show', $job->id) }}" class="btn btn-sm btn-info">Detail</a>
                                        <a href="{{ route('jobcards.edit', $job->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('jobcards.print', $job->id) }}" target="_blank"
                                            class="btn btn-sm btn-success">Print</a>
                                        <form action="{{ route('jobcards.destroy', $job->id) }}" method="POST"
                                            class="delete-form">
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
            // 🧩 Inisialisasi DataTable
            const table = $('#jobcardsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                columnDefs: [{
                    orderable: false,
                    targets: 7
                }]
            });

            // 🔍 Filter logika
            $('#filterType, #filterCustomer, #filterTanggal').on('change keyup', function() {
                const type = $('#filterType').val().toLowerCase();
                const customer = $('#filterCustomer').val().toLowerCase();
                const tanggal = $('#filterTanggal').val();

                table.rows().every(function() {
                    const data = this.data();
                    const matchType = type === "" || data[1].toLowerCase().includes(type);
                    const matchCustomer = customer === "" || data[3].toLowerCase().includes(customer);
                    const matchTanggal = tanggal === "" || data[6].includes(tanggal);

                    if (matchType && matchCustomer && matchTanggal) {
                        $(this.node()).show();
                    } else {
                        $(this.node()).hide();
                    }
                });
            });

            // 🔁 Reset Filter
            $('#resetFilter').on('click', function() {
                $('#filterType').val('');
                $('#filterCustomer').val('');
                $('#filterTanggal').val('');
                table.rows().show();
            });

            // 🗑️ Konfirmasi Delete
            $('#jobcardsTable tbody').on('submit', '.delete-form', function(e) {
                e.preventDefault();
                var form = this;

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Jobcard yang dihapus tidak bisa dikembalikan!",
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

            // ✅ Notifikasi sukses
            @if (session('success'))
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
