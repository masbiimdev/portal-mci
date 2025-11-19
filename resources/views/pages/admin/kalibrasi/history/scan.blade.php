<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>History Kalibrasi Tool | QC Calibration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd, #f0f4f8);
            font-family: 'Segoe UI', sans-serif;
        }

        .tool-info {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .card-history {
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-history:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .badge-status-ok {
            background-color: #a5d6a7;
            color: #1b5e20;
            font-weight: 500;
        }

        .badge-status-proses {
            background-color: #ffe082;
            color: #ff6f00;
            font-weight: 500;
        }

        .timeline {
            position: relative;
            margin-left: 20px;
            padding-left: 20px;
            border-left: 3px solid #1976d2;
        }

        .timeline-dot {
            position: absolute;
            left: -10px;
            width: 16px;
            height: 16px;
            background: #1976d2;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 3px #1976d2;
            top: 10px;
        }

        .timeline-item:first-child .timeline-dot {
            background: #43a047;
            box-shadow: 0 0 0 3px #43a047;
        }

        /* Modal PDF */
        .modal-backdrop-custom {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1050;
            padding: 10px;
        }

        .modal-backdrop-custom.active {
            display: flex;
        }

        .modal-pdf {
            width: 100%;
            max-width: 800px;
            height: 80vh;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
        }

        .modal-pdf iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .modal-close-btn {
            position: absolute;
            top: 8px;
            right: 12px;
            background: transparent;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        .modal-close-btn:hover {
            color: #d32f2f;
        }

        .btn-view-pdf {
            background: #eef2ff;
            color: #3f51b5;
            border: 1px solid #c5cae9;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .btn-view-pdf:hover {
            background: #3f51b5;
            color: white;
            border-color: #3f51b5;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(63, 81, 181, 0.3);
        }

        @media (max-width: 576px) {
            .timeline {
                margin-left: 10px;
                padding-left: 10px;
            }

            .timeline-dot {
                left: -6px;
                width: 12px;
                height: 12px;
            }

            .card-history {
                font-size: 14px;
            }

            .tool-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .modal-pdf {
                height: 70vh;
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h3 class="fw-bold mb-4">
            <span class="text-muted">QC / Kalibrasi /</span> History
            <span class="text-primary">{{ $tool->nama_alat }}</span>
        </h3>

        <!-- Tool Info -->
        <div class="tool-info d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <p class="mb-1"><strong>No Seri:</strong> {{ $tool->no_seri }}</p>
                <p class="mb-0"><strong>Kapasitas:</strong> {{ $tool->kapasitas }}</p>
            </div>
            <div>
                <img src="{{ $tool->qr_code_path ? asset('storage/' . $tool->qr_code_path) : 'https://dummyimage.com/100x100/1976d2/ffffff&text=QR' }}"
                    width="100" height="100" alt="QR Code">
            </div>
        </div>

        <!-- TIMELINE -->
        <div class="timeline mt-4">
            @if ($tool->histories->isEmpty())
                <div class="text-center py-5">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background:#e3f2fd; display:flex; justify-content:center; align-items:center; margin:0 auto 20px auto;">
                        <span style="font-size:40px; color:#1976d2;">📄</span>
                    </div>
                    <h5 class="fw-bold text-primary">Belum Ada Riwayat Kalibrasi</h5>
                    <p class="text-muted">Data akan muncul setelah alat menjalani kalibrasi pertama.</p>
                </div>
            @else
                @foreach ($tool->histories as $h)
                    <div class="timeline-item">
                        <span class="timeline-dot"></span>
                        <div class="card card-history shadow-sm @if($loop->first) border border-primary @endif mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>{{ $h->tgl_kalibrasi ? \Carbon\Carbon::parse($h->tgl_kalibrasi)->format('d-m-Y') : '-' }}</span>
                                @if ($h->status_kalibrasi === 'OK')
                                    <span class="badge badge-status-ok">OK</span>
                                @else
                                    <span class="badge badge-status-proses">Proses</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <p><strong>No Sertifikat:</strong> {{ $h->no_sertifikat ?? '-' }}</p>
                                <p><strong>Lembaga:</strong> {{ $h->lembaga_kalibrasi ?? '-' }}</p>
                                <p><strong>Interval:</strong> {{ $h->interval_kalibrasi ?? '-' }}</p>
                                <p><strong>Eksternal:</strong> {{ $h->eksternal_kalibrasi ?? '-' }}</p>
                                <p><strong>Keterangan:</strong> {{ $h->keterangan ?? '-' }}</p>

                                @if ($h->file_sertifikat)
                                    <button class="btn btn-view-pdf w-100 mt-2"
                                        onclick="openPDFModal('{{ asset('storage/' . $h->file_sertifikat) }}')">
                                        <span class="me-2">📄</span> Lihat Sertifikat
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Modal PDF -->
    <div id="pdfModal" class="modal-backdrop-custom">
        <div class="modal-pdf">
            <button class="modal-close-btn" onclick="closePDFModal()">&times;</button>
            <iframe id="pdfFrame" src="" allowfullscreen></iframe>
        </div>
    </div>

    <script>
        function openPDFModal(url) {
            document.getElementById('pdfFrame').src = url;
            document.getElementById('pdfModal').classList.add('active');
        }

        function closePDFModal() {
            document.getElementById('pdfFrame').src = '';
            document.getElementById('pdfModal').classList.remove('active');
        }

        document.getElementById('pdfModal').addEventListener('click', function(e) {
            if (e.target === this) closePDFModal();
        });
    </script>
</body>

</html>
