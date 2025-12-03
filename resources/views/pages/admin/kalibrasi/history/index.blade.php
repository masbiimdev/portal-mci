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

        /* Highlight row berdasarkan status */
        .row-no-history {
            background-color: #f8f9fa;
        }

        .row-history-no-pdf {
            background-color: #fff3cd;
            /* oranye muda */
        }

        .row-history-pdf {
            background-color: #d1e7dd;
            /* hijau muda */
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
                <h4 class="card-title">Daftar History Kalibrasi Item</h4>
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
                            <th>Tanggal Kalibrasi Terakhir</th>
                            <th>Status PDF</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tools as $tool)
                            @php
                                // Ambil history terakhir (tgl_kalibrasi_ulang terbaru)
                                $lastHistory = $tool->histories->sortByDesc('tgl_kalibrasi_ulang')->first();

                                // Tentukan kelas row
                                $rowClass = '';
                                if (!$lastHistory) {
                                    $rowClass = 'row-no-history';
                                } elseif ($lastHistory && !$lastHistory->file_sertifikat) {
                                    $rowClass = 'row-history-no-pdf';
                                } else {
                                    $rowClass = 'row-history-pdf';
                                }
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>{{ $tool->nama_alat }}</td>
                                <td>{{ $tool->merek ?? '-' }}</td>
                                <td>{{ $tool->no_seri ?? '-' }}</td>

                                {{-- Status Item --}}
                                <td>
                                    @if ($tool->histories->count() > 0)
                                        <span class="badge bg-success">Sudah Ada History</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Ada History</span>
                                    @endif
                                </td>

                                {{-- Tanggal Kalibrasi Terakhir --}}
<td>
    @if ($lastHistory && $lastHistory->tgl_kalibrasi_ulang)
        {{ \Carbon\Carbon::parse($lastHistory->tgl_kalibrasi_ulang)->format('d/m/Y') }}

        @php
            $today = \Carbon\Carbon::now();
            $kalibrasi = \Carbon\Carbon::parse($lastHistory->tgl_kalibrasi_ulang);
            $diff = $today->diffInDays($kalibrasi, false); // negatif jika sudah lewat
        @endphp

        @if ($diff > 0 && $diff <= 30)
            <span class="badge bg-warning text-white ms-1">
                <i class='bx bx-calendar-event'></i> Jadwalkan
            </span>
        @elseif($diff > 30)
            <span class="badge bg-info text-white ms-1">
                <i class='bx bx-calendar-event'></i> H-{{ $diff }} hari
            </span>
        @elseif($diff >= -7 && $diff <= 7)
            <span class="badge bg-primary text-white ms-1">
                <i class='bx bx-time-five'></i> Proses
            </span>
        @elseif($diff < 0 && abs($diff) > 8)
            <span class="badge bg-success text-white ms-1">
                <i class='bx bx-check-circle'></i> Selesai
            </span>
        @else
            <span class="badge bg-secondary text-white ms-1">
                <i class='bx bx-minus-circle'></i> -
            </span>
        @endif
    @else
        <span class="badge bg-secondary text-white ms-1">
            <i class='bx bx-minus-circle'></i> -
        </span>
    @endif
</td>


                                {{-- Status PDF --}}
                                <td>
                                    @if ($lastHistory && $lastHistory->file_sertifikat)
                                        <span class="badge bg-success">Sudah Ada PDF</span>
                                        <a href="{{ asset('storage/' . $lastHistory->file_sertifikat) }}"
                                            class="btn btn-sm btn-success ms-1" target="_blank">
                                            <i class=" bx bx-download"></i>
                                        </a>
                                    @elseif($lastHistory)
                                        <span class="badge bg-warning">Belum Ada PDF</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Ada History</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
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
                order: [] // Urutkan berdasarkan kolom Tanggal Kalibrasi Terakhir
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
