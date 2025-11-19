@extends('layouts.admin')

@section('title', 'Detail Alat | QC')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Kalibrasi / Tools /</span> Detail
        </h4>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center text-white">
                <h5 class="mb-0"><i class="bx bx-package"></i> Detail Alat: {{ $tool->nama_alat }}</h5>
                <a href="{{ route('tools.index') }}" class="btn btn-light btn-sm">
                    <i class="bx bx-left-arrow-alt"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama Alat:</strong> {{ $tool->nama_alat }}<br>
                        <strong>Merek:</strong> {{ $tool->merek ?? '-' }}<br>
                        <strong>No. Seri:</strong> {{ $tool->no_seri ?? '-' }}<br>
                        <strong>Kapasitas:</strong> {{ $tool->kapasitas ?? '-' }}<br>
                    </div>

                    <div class="col-md-4">
                        <strong>QR Code:</strong><br>
                        @if ($tool->qr_code_path)
                            <img src="{{ asset('storage/' . $tool->qr_code_path) }}" width="100"
                                height="100" alt="QR Code">
                        @else
                            <span class="text-muted">Belum ada QR Code</span>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <strong>Latest Calibration:</strong><br>
                        @if ($tool->latestHistory)
                            <ul class="mb-0">
                                <li><strong>Tanggal Kalibrasi:</strong>
                                    {{ $tool->latestHistory->tgl_kalibrasi ? \Carbon\Carbon::parse($tool->latestHistory->tgl_kalibrasi)->format('d M Y') : '-' }}
                                </li>
                                <li><strong>Tanggal Kalibrasi Ulang:</strong>
                                    {{ $tool->latestHistory->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($tool->latestHistory->tgl_kalibrasi_ulang)->format('d M Y') : '-' }}
                                </li>
                                <li><strong>No Sertifikat:</strong> {{ $tool->latestHistory->no_sertifikat ?? '-' }}</li>
                                <li><strong>Lembaga Kalibrasi:</strong>
                                    {{ $tool->latestHistory->lembaga_kalibrasi ?? '-' }}</li>
                                <li><strong>Eksternal Kalibrasi:</strong>
                                    {{ $tool->latestHistory->eksternal_kalibrasi ?? '-' }}</li>
                                <li><strong>Status:</strong> {{ $tool->latestHistory->status_kalibrasi }}</li>
                                <li><strong>Keterangan:</strong> {{ $tool->latestHistory->keterangan ?? '-' }}</li>
                            </ul>
                        @else
                            <span class="text-muted">Belum ada history kalibrasi</span>
                        @endif
                    </div>
                </div>

                {{-- Tombol Tambah History --}}
                {{-- <div class="mb-3 text-end">
                    <a href="{{ route('histories.create', ['tool_id' => $tool->id]) }}" class="btn btn-success btn-sm">
                        <i class="bx bx-plus"></i> Tambah History Kalibrasi
                    </a>
                </div> --}}

                {{-- List Semua History --}}
                <hr>
                <h6>History Kalibrasi</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>Tanggal Kalibrasi</th>
                                <th>Tanggal Kalibrasi Ulang</th>
                                <th>No Sertifikat</th>
                                <th>Lembaga</th>
                                <th>Eksternal</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tool->histories as $history)
                                <tr>
                                    <td>{{ $history->tgl_kalibrasi ? \Carbon\Carbon::parse($history->tgl_kalibrasi)->format('d M Y') : '-' }}
                                    </td>
                                    <td>{{ $history->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($history->tgl_kalibrasi_ulang)->format('d M Y') : '-' }}
                                    </td>
                                    <td>{{ $history->no_sertifikat ?? '-' }}</td>
                                    <td>{{ $history->lembaga_kalibrasi ?? '-' }}</td>
                                    <td>{{ $history->eksternal_kalibrasi }}</td>
                                    <td>{{ $history->status_kalibrasi }}</td>
                                    <td>{{ $history->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada history kalibrasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
