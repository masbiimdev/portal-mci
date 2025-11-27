@extends('layouts.admin')

@section('title', 'Detail Alat | QC')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Kalibrasi / Tools /</span> Detail
        </h4>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center text-white">
                <h5 class="mb-0"><i class="bx bx-package"></i> Detail Item: {{ $tool->nama_alat }}</h5>
                <a href="{{ route('tools.index') }}" class="btn btn-light btn-sm">
                    <i class="bx bx-left-arrow-alt"></i> Kembali
                </a>
            </div>

            <div class="card-body">

                {{-- INFORMASI ALAT --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama Item:</strong> {{ $tool->nama_alat }}<br>
                        <strong>Merek:</strong> {{ $tool->merek ?? '-' }}<br>
                        <strong>No. Seri:</strong> {{ $tool->no_seri ?? '-' }}<br>
                        <strong>Kapasitas:</strong> {{ $tool->kapasitas ?? '-' }}<br>
                        <strong>Lokasi Item:</strong> {{ $tool->lokasi }}<br>
                    </div>

                    <div class="col-md-4">
                        <strong>QR Code:</strong><br>
                        @if ($tool->qr_code_path)
                            <img src="{{ asset('storage/' . $tool->qr_code_path) }}" width="100" height="100"
                                alt="QR Code">
                        @else
                            <span class="text-muted">Belum ada QR Code</span>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <strong>Latest Calibration:</strong><br>
                        @if ($tool->latestHistory)
                            <ul class="mb-0">
                                <li><strong>Tanggal Kalibrasi:</strong>
                                    {{ $tool->latestHistory->tgl_kalibrasi ? \Carbon\Carbon::parse($tool->latestHistory->tgl_kalibrasi)->format('d/m/Y') : '-' }}
                                </li>
                                <li><strong>Tanggal Kalibrasi Ulang:</strong>
                                    {{ $tool->latestHistory->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($tool->latestHistory->tgl_kalibrasi_ulang)->format('d/m/Y') : '-' }}
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

                <hr>
                <h6>History Kalibrasi</h6>

                {{-- TABEL HISTORY --}}
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tool->histories as $h)
                                <tr>
                                    <td>{{ $h->tgl_kalibrasi ? \Carbon\Carbon::parse($h->tgl_kalibrasi)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $h->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($h->tgl_kalibrasi_ulang)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $h->no_sertifikat ?? '-' }}</td>
                                    <td>{{ $h->lembaga_kalibrasi ?? '-' }}</td>
                                    <td>{{ $h->eksternal_kalibrasi }}</td>
                                    <td>{{ $h->status_kalibrasi }}</td>
                                    <td>{{ $h->keterangan ?? '-' }}</td>

                                    <td>
                                        @if ($h->file_sertifikat)
                                            <button class="btn btn-primary w-100 mt-2"
                                                onclick="openPDFModal('{{ asset('storage/' . $h->file_sertifikat) }}')">
                                                <span class="me-2">📄</span> Lihat Sertifikat
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada history kalibrasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div> {{-- end card-body --}}
        </div> {{-- end card --}}
    </div> {{-- end container --}}

    {{-- ======== MODAL PDF VIEWER ========= --}}
    <div class="modal fade" id="pdfViewerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Preview Sertifikat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-0" style="height: 80vh;">
                    <embed id="pdfFrame" src="" type="application/pdf" width="100%" height="100%">
                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function openPDFModal(pdfUrl) {
            document.getElementById('pdfFrame').src = pdfUrl;
            let modal = new bootstrap.Modal(document.getElementById('pdfViewerModal'));
            modal.show();
        }
    </script>
@endpush
