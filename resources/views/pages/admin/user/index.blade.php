@extends('layouts.admin')

@section('title')
    Users Management | MCI
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    <style>
        /* Card & Table Styling */
        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.05);
        }

        .table> :not(caption)>*>* {
            padding: 1rem 1.2rem;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.001);
            transition: all 0.2s ease-in-out;
        }

        /* Avatar Styling */
        .avatar-wrapper {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 2px 6px rgba(102, 126, 234, 0.4);
        }

        /* Soft Badges */
        .badge-soft-danger {
            background-color: #fce4e4;
            color: #ea5455;
        }

        .badge-soft-success {
            background-color: #d1f2eb;
            color: #28c76f;
        }

        .badge-soft-info {
            background-color: #dcf6fb;
            color: #00cfe8;
        }

        .badge-custom {
            padding: 6px 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
            border-radius: 6px;
        }

        /* Action Buttons */
        .btn-action-group .btn {
            width: 35px;
            height: 35px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-action-group .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Modal Profile Styling */
        .modal-profile-header {
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            border-bottom: 1px solid #eee;
            text-align: center;
            padding: 2rem 1rem;
            border-radius: 12px 12px 0 0;
        }

        .modal-avatar {
            width: 80px;
            height: 80px;
            font-size: 2rem;
            margin: 0 auto 15px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Users Management</h4>
                <span class="text-muted text-sm">Kelola akses dan data pengguna portal Metinca</span>
            </div>
            <a href="{{ route('users.create') }}"
                class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4 shadow-sm">
                <i class="bx bx-user-plus"></i> Tambah User
            </a>
        </div>

        <div class="card card-custom">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="usersTable" class="table table-hover border-top w-100">
                        <thead class="table-light">
                            <tr>
                                <th>USER INFO</th>
                                <th>EMAIL</th>
                                <th class="text-center">ROLE</th>
                                <th class="text-center">DEPARTEMEN</th>
                                <th class="text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-wrapper">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark">{{ $user->name }}</h6>
                                                <small class="text-muted">NIK: {{ $user->nik ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td class="text-center">
                                        @if (strtolower($user->role) == 'admin')
                                            <span class="badge badge-soft-danger badge-custom">Admin</span>
                                        @elseif(strtolower($user->role) == 'qc')
                                            <span class="badge badge-soft-success badge-custom">QC</span>
                                        @else
                                            <span
                                                class="badge badge-soft-info badge-custom">{{ ucfirst($user->role) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-medium text-secondary">{{ $user->departemen ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 btn-action-group">
                                            <button type="button" class="btn btn-light text-info viewUser border"
                                                data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                                data-role="{{ $user->role }}" data-nik="{{ $user->nik }}"
                                                data-dept="{{ $user->departemen }}" title="Detail User">
                                                <i class="bx bx-show fs-5"></i>
                                            </button>

                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-light text-warning border" title="Edit User">
                                                <i class="bx bx-edit fs-5"></i>
                                            </a>

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="delete-form m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-light text-danger border btn-delete"
                                                    title="Hapus User">
                                                    <i class="bx bx-trash fs-5"></i>
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
    </div>

    {{-- MODAL VIEW USER PRETTY --}}
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-profile-header position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <div class="avatar-wrapper modal-avatar" id="mAvatarInitials">U</div>
                    <h4 class="modal-title fw-bold mb-1" id="mName">Nama User</h4>
                    <span class="badge bg-primary px-3 py-2 rounded-pill" id="mRole">Role</span>
                </div>

                <div class="modal-body p-4">
                    <h6 class="text-muted fw-bold mb-3 text-uppercase" style="font-size: 0.8rem;">Informasi Detail</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted"><i class="bx bx-envelope me-2"></i>Email</span>
                            <span class="fw-semibold text-dark" id="mEmail">-</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted"><i class="bx bx-id-card me-2"></i>NIK</span>
                            <span class="fw-semibold text-dark" id="mNik">-</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom-0">
                            <span class="text-muted"><i class="bx bx-building-house me-2"></i>Departemen</span>
                            <span class="fw-semibold text-dark" id="mDept">-</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables dengan styling Bootstrap 5
            var table = $('#usersTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ user",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Lanjut",
                        previous: "Kembali"
                    }
                },
                dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'B><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [{
                        extend: 'copy',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm btn-outline-success'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-outline-primary'
                    }
                ],
                columnDefs: [{
                        orderable: false,
                        targets: 4
                    } // Nonaktifkan sorting pada kolom action
                ]
            });

            // SweetAlert Delete Confirm
            $('.btn-delete').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                Swal.fire({
                    title: 'Hapus User?',
                    text: 'Data user ini akan dihapus permanen dari sistem.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ea5455',
                    cancelButtonColor: '#82868b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger me-2',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // View User Modal Mapping
            $('.viewUser').click(function() {
                var name = $(this).data('name');

                // Ambil inisial huruf pertama
                $('#mAvatarInitials').text(name.charAt(0).toUpperCase());

                $('#mName').text(name);
                $('#mEmail').text($(this).data('email') ? $(this).data('email') : '-');
                $('#mRole').text($(this).data('role').toUpperCase());
                $('#mNik').text($(this).data('nik') ? $(this).data('nik') : '-');
                $('#mDept').text($(this).data('dept') ? $(this).data('dept') : '-');

                $('#userModal').modal('show');
            });

            // Notifikasi Sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-4'
                    }
                });
            @endif
        });
    </script>
@endpush
