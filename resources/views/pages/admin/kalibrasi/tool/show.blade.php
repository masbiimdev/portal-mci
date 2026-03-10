@extends('layouts.admin')

@section('title', 'Detail Alat | QC')

@push('css')
    <style>
        /* Modern Card Styling */
        .card-custom {
            border: 0;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
            border-radius: 16px;
            overflow: hidden;
        }

        .card-header-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
        }

        /* Detail Blocks */
        .detail-block {
            padding: 1.5rem;
            height: 100%;
            border-radius: 12px;
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
        }

        .detail-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Status Highlight Card */
        .status-highlight {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid #bbf7d0;
        }

        .status-highlight.warning {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fecdd3;
        }

        /* QR Code Container */
        .qr-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            height: 100%;
        }

        .qr-container img {
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .qr-container img:hover {
            transform: scale(1.1);
        }

        /* Table Modern */
        .table-modern {
            width: 100%;
            margin-bottom: 0;
        }

        .table-modern thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem;
            white-space: nowrap;
        }

        .table-modern tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #475569;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 0.9rem;
        }

        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }

        .table-modern tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* Status Badges */
        .badge-status {
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-pass {
            background-color: #d1fae5;
            color: #059669;
        }

        .badge-fail {
            background-color: #fee2e2;
            color: #e11d48;
        }

        .badge-progress {
            background-color: #fef3c7;
            color: #d97706;
        }

        .btn-pdf {
            background-color: #eff6ff;
            color: #0284c7;
            font-weight: 600;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            transition: all 0.2s;
        }

        .btn-pdf:hover {
            background-color: #0284c7;
            color: #ffffff;
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Quality Control / Master Alat /</span> Detail
        </h4>

        <div class="card card-custom mb-4">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div
                        class="avatar avatar-md me-3 bg-label-primary rounded d-flex align-items-center justify-content-center">
                        <i class="bx bx-cog fs-3"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">{{ $tool->nama_alat }}</h5>
                        <span class="text-muted small">SN: {{ $tool->no_seri ?? 'Tidak ada SN' }}</span>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('tools.edit', $tool->id) }}" class="btn btn-outline-primary btn-sm fw-semibold">
                        <i class="bx bx-edit-alt me-1"></i> Edit Alat
                    </a>
                    <a href="{{ route('tools.index') }}" class="btn btn-secondary btn-sm fw-semibold shadow-sm">
                        <i class="bx bx-left-arrow-alt me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body p-4">

                @php
                    $latest = $tool->latestHistory;
                    $isWarning = false;
                    if ($latest && $latest->tgl_kalibrasi_ulang) {
                        $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($latest->tgl_kalibrasi_ulang), false);
                        if ($daysLeft <= 30) {
                            $isWarning = true;
                        }
                    }
                @endphp

                <div class="row g-4 mb-5">

                    <div class="col-lg-4 col-md-6">
                        <div class="detail-block">
                            <h6 class="fw-bold text-dark mb-4 d-flex align-items-center">
                                <i class="bx bx-list-ul text-primary me-2"></i> Spesifikasi Alat
                            </h6>

                            <div class="detail-label">Merek / Pabrikan</div>
                            <div class="detail-value">{{ $tool->merek ?? '-' }}</div>

                            <div class="detail-label">Kapasitas / Range</div>
                            <div class="detail-value">{{ $tool->kapasitas ?? '-' }}</div>

                            <div class="detail-label">Lokasi Penyimpanan</div>
                            <div class="detail-value mb-0 d-flex align-items-center">
                                <i class="bx bx-map-pin text-muted me-1"></i> {{ $tool->lokasi ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="detail-block status-highlight {{ $isWarning ? 'warning' : '' }}">
                            <h6
                                class="fw-bold {{ $isWarning ? 'text-danger' : 'text-success' }} mb-4 d-flex align-items-center">
                                <i class="bx bx-calendar-check me-2"></i> Status Kalibrasi
                            </h6>

                            @if ($latest)
                                <div class="detail-label">Kalibrasi Terakhir</div>
                                <div class="detail-value">
                                    {{ $latest->tgl_kalibrasi ? \Carbon\Carbon::parse($latest->tgl_kalibrasi)->format('d F Y') : '-' }}
                                </div>

                                <div class="detail-label {{ $isWarning ? 'text-danger' : '' }}">Kalibrasi Berikutnya (Jatuh
                                    Tempo)</div>
                                <div class="detail-value {{ $isWarning ? 'text-danger fw-black' : '' }}">
                                    {{ $latest->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($latest->tgl_kalibrasi_ulang)->format('d F Y') : '-' }}
                                    @if ($isWarning)
                                        <span class="ms-2 badge bg-danger" style="font-size: 0.65rem;">Segera!</span>
                                    @endif
                                </div>

                                <div class="detail-label">Lembaga & Status</div>
                                <div class="detail-value mb-0">
                                    {{ $latest->lembaga_kalibrasi ?? '-' }}
                                    <span class="mx-1">•</span>
                                    <span class="text-primary">{{ $latest->status_kalibrasi }}</span>
                                </div>
                            @else
                                <div class="d-flex flex-column align-items-center justify-content-center h-75 text-center">
                                    <i class="bx bx-info-circle text-muted fs-1 mb-2"></i>
                                    <span class="text-muted fw-medium">Alat ini belum pernah dikalibrasi.</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="qr-container">
                            <h6 class="fw-bold text-slate-600 mb-3">Sistem QR Code</h6>
                            @if ($tool->qr_code_path)
                                <img src="{{ asset('storage/' . $tool->qr_code_path) }}" width="120" height="120"
                                    alt="QR Code">
                                <span
                                    class="badge bg-label-dark text-monospace mt-2">{{ $tool->no_seri ?? 'QR-READY' }}</span>
                            @else
                                <div class="p-4 bg-light rounded-circle mb-3">
                                    <i class="bx bx-qr text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <span class="text-muted small">QR Code belum digenerate</span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="d-flex align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="bx bx-history text-primary me-2"></i> Riwayat Kalibrasi
                        Lengkap</h5>
                    <div class="flex-grow-1 border-bottom ms-3" style="border-color: #e2e8f0 !important;"></div>
                </div>

                <div class="table-responsive rounded-3 border" style="border-color: #f1f5f9;">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Tgl Pelaksanaan</th>
                                <th>Jatuh Tempo</th>
                                <th>No. Sertifikat</th>
                                <th>Lembaga</th>
                                <th class="text-center">Eksternal</th>
                                <th class="text-center">Status</th>
                                <th>Keterangan</th>
                                <th class="text-center">Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tool->histories as $h)
                                @php
                                    // Menentukan warna badge status
                                    $statusClass = 'badge-progress';
                                    $statusText = strtolower($h->status_kalibrasi);
                                    if (
                                        str_contains($statusText, 'pass') ||
                                        str_contains($statusText, 'ok') ||
                                        str_contains($statusText, 'baik')
                                    ) {
                                        $statusClass = 'badge-pass';
                                    }
                                    if (str_contains($statusText, 'fail') || str_contains($statusText, 'rusak')) {
                                        $statusClass = 'badge-fail';
                                    }
                                @endphp
                                <tr>
                                    <td class="fw-semibold text-dark">
                                        {{ $h->tgl_kalibrasi ? \Carbon\Carbon::parse($h->tgl_kalibrasi)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        {{ $h->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($h->tgl_kalibrasi_ulang)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td><span class="text-monospace text-muted">{{ $h->no_sertifikat ?? '-' }}</span></td>
                                    <td>{{ $h->lembaga_kalibrasi ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($h->eksternal_kalibrasi == 'Ya')
                                            <span class="badge bg-label-info">Eksternal</span>
                                        @else
                                            <span class="badge bg-label-secondary">Internal</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-status {{ $statusClass }}">{{ $h->status_kalibrasi }}</span>
                                    </td>
                                    <td class="small">{{ \Illuminate\Support\Str::limit($h->keterangan ?? '-', 30) }}</td>
                                    <td class="text-center">
                                        @if ($h->file_sertifikat)
                                            <button class="btn-pdf d-inline-flex align-items-center"
                                                onclick="openPDFModal('{{ asset('storage/' . $h->file_sertifikat) }}')">
                                                <i class="bx bxs-file-pdf me-1 fs-6"></i> Lihat
                                            </button>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bx bx-folder-open text-muted fs-1 mb-2"></i>
                                            <span class="text-muted fw-medium">Belum ada catatan riwayat kalibrasi untuk
                                                alat ini.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- ======== MODAL PDF VIEWER ========= --}}
    <div class="modal fade" id="pdfViewerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light border-bottom-0 pb-3">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center">
                        <i class="bx bxs-file-pdf text-danger me-2 fs-4"></i> Preview Sertifikat Kalibrasi
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-dark" style="height: 80vh;">
                    <embed id="pdfFrame" src="" type="application/pdf" width="100%" height="100%"
                        style="border: none;">
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

        // Bersihkan iframe saat modal ditutup untuk menghemat memori browser
        document.getElementById('pdfViewerModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('pdfFrame').src = "";
        });
    </script>
@endpush
