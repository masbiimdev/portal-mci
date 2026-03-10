<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
    <title>History Kalibrasi — {{ $tool->nama_alat ?? 'Alat' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-body: #f1f5f9;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --surface: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;

            --success-bg: #dcfce7;
            --success-text: #16a34a;
            --warning-bg: #fef3c7;
            --warning-text: #d97706;
            --danger-bg: #fee2e2;
            --danger-text: #dc2626;

            --radius-lg: 16px;
            --radius-md: 12px;
            --shadow-card: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            --shadow-hover: 0 12px 30px -5px rgba(15, 23, 42, 0.08);
        }

        body {
            height: 100%;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        .container-main {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 24px;
        }

        /* Topbar */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .topbar h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .topbar p {
            margin: 4px 0 0 0;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Tool Header Card */
        .tool-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-card);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            gap: 20px;
        }

        .tool-identity h2 {
            font-size: 1.35rem;
            font-weight: 800;
            margin-bottom: 12px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tool-specs {
            display: flex;
            flex-wrap: wrap;
            gap: 16px 24px;
        }

        .spec-item {
            display: flex;
            flex-direction: column;
        }

        .spec-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 2px;
        }

        .spec-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .qr-wrapper {
            background: #fff;
            padding: 8px;
            border-radius: var(--radius-md);
            border: 1px dashed #cbd5e1;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-shrink: 0;
        }

        .qr-wrapper img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Timeline Layout */
        .timeline-container {
            position: relative;
            padding-left: 32px;
            margin-top: 16px;
        }

        /* Garis Vertikal */
        .timeline-container::before {
            content: "";
            position: absolute;
            left: 22px;
            /* Disesuaikan agar pas di tengah bullet */
            top: 24px;
            bottom: 24px;
            width: 3px;
            background: linear-gradient(to bottom, #93c5fd, #e2e8f0);
            border-radius: 4px;
        }

        .timeline-item {
            position: relative;
            margin-left: 56px;
            margin-bottom: 24px;
        }

        /* Lingkaran Indikator */
        .timeline-bullet {
            position: absolute;
            left: -88px;
            /* Ditarik ke garis */
            top: 16px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            border: 4px solid var(--bg-body);
            /* Memberi efek terpotong pada garis */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 2;
        }

        .timeline-bullet.latest {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .timeline-bullet.ok {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }

        .timeline-bullet.proses {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .timeline-bullet.due {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .timeline-bullet span {
            font-size: 0.75rem;
            line-height: 1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .timeline-bullet i {
            font-size: 1.25rem;
        }

        /* Card Riwayat */
        .history-card {
            background: var(--surface);
            border-radius: var(--radius-md);
            padding: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: var(--shadow-card);
            transition: all 0.25s ease;
        }

        .history-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
            border-color: #cbd5e1;
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 12px;
        }

        .cal-date {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .cal-agency {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Custom Badge Status */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.ok {
            background-color: var(--success-bg);
            color: var(--success-text);
            border: 1px solid #bbf7d0;
        }

        .status-badge.proses {
            background-color: var(--warning-bg);
            color: var(--warning-text);
            border: 1px solid #fde68a;
        }

        .status-badge.due {
            background-color: var(--danger-bg);
            color: var(--danger-text);
            border: 1px solid #fecdd3;
        }

        .history-body {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }

        /* Tombol PDF */
        .btn-pdf {
            background-color: #eff6ff;
            color: var(--primary);
            border: 1px solid #bfdbfe;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            width: 100%;
            justify-content: center;
        }

        .btn-pdf:hover {
            background-color: var(--primary);
            color: #fff;
        }

        /* Empty State */
        .empty-state {
            background: #ffffff;
            border: 2px dashed #cbd5e1;
            border-radius: var(--radius-lg);
            padding: 40px 20px;
            text-align: center;
            color: var(--text-muted);
        }

        /* Modal Tweaks */
        .modal-content {
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: none;
        }

        .modal-header {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .modal-body.pdf-dark {
            background-color: #334155;
        }

        /* Responsif Mobile */
        @media (max-width: 768px) {
            .tool-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .qr-wrapper {
                align-self: flex-start;
                flex-direction: row;
                gap: 16px;
                width: 100%;
                justify-content: flex-start;
            }

            .timeline-container {
                padding-left: 16px;
            }

            .timeline-container::before {
                left: 16px;
            }

            .timeline-item {
                margin-left: 40px;
            }

            .timeline-bullet {
                left: -64px;
                width: 40px;
                height: 40px;
            }

            .timeline-bullet i {
                font-size: 1rem;
            }

            .timeline-bullet span {
                display: none;
                /* Sembunyikan teks di bullet saat mobile */
            }

            .history-header {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="container-main">

        <div class="topbar">
            <div>
                <h1>Riwayat Kalibrasi</h1>
                <p>Detail spesifikasi dan jejak rekam sertifikasi alat</p>
            </div>
            <a href="{{ route('histories.index') }}" class="btn btn-outline-secondary btn-sm fw-bold px-3 py-2"
                style="border-radius: 8px;">
                <i class='bx bx-left-arrow-alt fs-5 align-middle me-1'></i> Kembali
            </a>
        </div>

        <div class="tool-header">
            <div class="tool-identity">
                <h2><i class='bx bx-check-shield fs-3'></i> {{ e($tool->nama_alat) }}</h2>
                <div class="tool-specs">
                    <div class="spec-item">
                        <span class="spec-label">Merek</span>
                        <span class="spec-value">{{ e($tool->merek) ?? '-' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Nomor Seri</span>
                        <span class="spec-value">{{ e($tool->no_seri) ?? '-' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Kapasitas</span>
                        <span class="spec-value">{{ e($tool->kapasitas) ?? '-' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Lokasi</span>
                        <span class="spec-value"><i class='bx bx-map text-muted'></i>
                            {{ e($tool->lokasi) ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="qr-wrapper">
                <img src="{{ $tool->qr_code_path ? asset('storage/' . $tool->qr_code_path) : 'https://dummyimage.com/100x100/e2e8f0/64748b&text=No+QR' }}"
                    alt="QR Code">
                <span class="mt-2 text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">SYSTEM QR</span>
            </div>
        </div>

        <h5 class="fw-bold mb-4 ms-2"><i class='bx bx-list-ul text-primary me-2'></i> Jejak Kalibrasi</h5>

        <div class="timeline-container">
            @php $histories = $tool->histories->sortByDesc('tgl_kalibrasi'); @endphp

            @if ($histories->isEmpty())
                <div class="empty-state">
                    <i class='bx bx-folder-open mb-3' style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h5 class="fw-bold text-slate-700">Belum Ada Riwayat</h5>
                    <p class="mb-0">Alat ini belum pernah dikalibrasi atau datanya belum dimasukkan ke sistem.</p>
                </div>
            @else
                @foreach ($histories as $h)
                    @php
                        $isLatest = $loop->first;
                        $certUrl = $h->file_sertifikat ? asset('storage/' . $h->file_sertifikat) : null;
                        $statusRaw = strtoupper($h->status_kalibrasi ?? '');

                        // Menentukan UI berdasarkan status
                        $statusClass = 'due';
                        $bulletIcon = 'bx-x';
                        if (
                            str_contains($statusRaw, 'PASS') ||
                            str_contains($statusRaw, 'OK') ||
                            str_contains($statusRaw, 'BAIK')
                        ) {
                            $statusClass = 'ok';
                            $bulletIcon = 'bx-check';
                        } elseif (str_contains($statusRaw, 'PROSES')) {
                            $statusClass = 'proses';
                            $bulletIcon = 'bx-time-five';
                        }

                        $bulletTheme = $isLatest ? 'latest' : $statusClass;
                    @endphp

                    <div class="timeline-item">

                        <div class="timeline-bullet {{ $bulletTheme }}"
                            title="{{ $isLatest ? 'Kalibrasi Terakhir' : 'Riwayat Terdahulu' }}">
                            @if ($isLatest)
                                <i class='bx bx-star'></i>
                                <span>New</span>
                            @else
                                <i class='bx {{ $bulletIcon }}'></i>
                            @endif
                        </div>

                        <article class="history-card">
                            <div class="history-header">
                                <div>
                                    <div class="cal-date">
                                        {{ \Carbon\Carbon::parse($h->tgl_kalibrasi)->format('d F Y') }}</div>
                                    <div class="cal-agency"><i class='bx bx-buildings me-1'></i>
                                        {{ e($h->lembaga_kalibrasi ?? 'Lembaga Tidak Diketahui') }}</div>
                                </div>
                                <div>
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class='bx {{ $bulletIcon }}'></i> {{ $statusRaw ?? '-' }}
                                    </span>
                                </div>
                            </div>

                            <div class="history-body">
                                <div class="spec-item">
                                    <span class="spec-label">Jatuh Tempo Selanjutnya</span>
                                    <span class="spec-value text-danger">
                                        {{ $h->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($h->tgl_kalibrasi_ulang)->format('d M Y') : '-' }}
                                    </span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Nomor Sertifikat</span>
                                    <span class="spec-value"
                                        style="font-family: monospace;">{{ e($h->no_sertifikat ?? '-') }}</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Keterangan / Catatan</span>
                                    <span class="spec-value">{{ e($h->keterangan ?? '-') }}</span>
                                </div>
                            </div>

                            @if ($certUrl)
                                <div class="border-top pt-3 mt-2">
                                    <button type="button" class="btn-pdf" data-pdf="{{ $certUrl }}">
                                        <i class='bx bxs-file-pdf fs-5 text-danger'></i> Lihat Sertifikat PDF
                                    </button>
                                </div>
                            @endif
                        </article>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold d-flex align-items-center">
                        <i class='bx bxs-file-pdf text-danger fs-4 me-2'></i> Pratinjau Dokumen Sertifikat
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-0 pdf-dark" style="height: 85vh;">
                    <iframe id="pdfFrame" src="" width="100%" height="100%" style="border: none;"
                        allow="fullscreen"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup Modal
            const pdfModalEl = document.getElementById('pdfModal');
            const pdfFrame = document.getElementById('pdfFrame');
            let bsModal = null;

            if (pdfModalEl) {
                bsModal = new bootstrap.Modal(pdfModalEl, {
                    keyboard: true
                });

                // Bersihkan iframe saat ditutup agar RAM ringan
                pdfModalEl.addEventListener('hidden.bs.modal', function() {
                    if (pdfFrame) pdfFrame.src = '';
                });
            }

            // Event listener untuk semua tombol "Lihat Sertifikat"
            document.addEventListener('click', function(ev) {
                const btn = ev.target.closest(".btn-pdf");
                if (!btn) return;
                ev.preventDefault();

                const url = btn.getAttribute("data-pdf");
                if (!url) return;

                pdfFrame.src = url;
                if (bsModal) bsModal.show();
            });
        });
    </script>
</body>

</html>
