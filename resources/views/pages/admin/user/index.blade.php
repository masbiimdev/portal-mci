@extends('layouts.admin')

@section('title')
    Users | MCI
@endsection


@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <style>
        .card {
            border: none;
            border-radius: 12px;
        }

        .table thead th {
            text-align: center;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background: #f5f7fa;
        }

        .badge-role {
            padding: 6px 12px;
            font-size: 0.75rem;
            border-radius: 20px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #696cff;
            color: white;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Users /</span> Management
            </h4>

            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bx bx-user-plus"></i> Tambah User
            </a>

        </div>



        <div class="card shadow-sm p-3">

            <div class="table-responsive">

                <table id="usersTable" class="table table-hover table-bordered">

                    <thead class="table-light">

                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">NIK</th>
                            <th class="text-center">Departemen</th>
                            <th class="text-center">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($users as $user)
                            <tr>

                                <td>

                                    <div class="user-info">

                                        <div class="avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>

                                    </div>

                                </td>

                                <td>{{ $user->email }}</td>

                                <td class="text-center">

                                    @if ($user->role == 'admin')
                                        <span class="badge bg-danger badge-role">
                                            Admin
                                        </span>
                                    @elseif($user->role == 'qc')
                                        <span class="badge bg-success badge-role">
                                            QC
                                        </span>
                                    @else
                                        <span class="badge bg-info badge-role">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    @endif

                                </td>

                                <td class="text-center">{{ $user->nik }}</td>

                                <td class="text-center">{{ $user->departemen }}</td>

                                <td>

                                    <div class="d-flex justify-content-center gap-1">

                                        <button class="btn btn-sm btn-info btn-action viewUser"
                                            data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}" data-nik="{{ $user->nik }}"
                                            data-dept="{{ $user->departemen }}">

                                            <i class="bx bx-show"></i>

                                        </button>


                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning btn-action">

                                            <i class="bx bx-edit"></i>

                                        </a>


                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-danger btn-action">

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



    {{-- MODAL VIEW USER --}}

    <div class="modal fade" id="userModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">User Detail</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <table class="table">

                        <tr>
                            <th>Nama</th>
                            <td id="mName"></td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td id="mEmail"></td>
                        </tr>

                        <tr>
                            <th>Role</th>
                            <td id="mRole"></td>
                        </tr>

                        <tr>
                            <th>NIK</th>
                            <td id="mNik"></td>
                        </tr>

                        <tr>
                            <th>Departemen</th>
                            <td id="mDept"></td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection




@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        $(document).ready(function() {


            $('#usersTable').DataTable({

                responsive: true,

                pageLength: 10,

                dom: 'Bfrtip',

                buttons: [
                    'copy', 'csv', 'excel', 'print'
                ],

                columnDefs: [{
                    orderable: false,
                    targets: 5
                }]

            });



            /*
            DELETE CONFIRM
            */

            $('.delete-form').submit(function(e) {

                e.preventDefault();

                var form = this;

                Swal.fire({

                    title: 'Delete User?',

                    text: 'User tidak bisa dikembalikan',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#d33',

                    confirmButtonText: 'Delete'

                }).then((result) => {

                    if (result.isConfirmed) {

                        form.submit();

                    }

                });

            });



            /*
            VIEW USER MODAL
            */

            $('.viewUser').click(function() {

                $('#mName').text($(this).data('name'));
                $('#mEmail').text($(this).data('email'));
                $('#mRole').text($(this).data('role'));
                $('#mNik').text($(this).data('nik'));
                $('#mDept').text($(this).data('dept'));

                $('#userModal').modal('show');

            });



            @if (session('success'))

                Swal.fire({

                    icon: 'success',

                    title: 'Success',

                    text: '{{ session('success') }}',

                    timer: 2000,

                    showConfirmButton: false

                });
            @endif



        });
    </script>
@endpush
