@extends('layouts.admin')
@section('title', 'Tambah Laporan NCR')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* --- GLOBAL BENTO VARIABLES --- */
        :root {
            --bento-bg: #f8fafc;
            --bento-surface: #ffffff;
            --bento-radius: 24px;
            --bento-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.06);
            --bento-shadow-hover: 0 15px 50px -10px rgba(15, 23, 42, 0.12);
            --bento-border: 1px solid rgba(226, 232, 240, 0.8);

            --brand-primary: #4f46e5;
            --brand-primary-soft: #e0e7ff;
            --text-main: #334155;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
        }

        body {
            background-color: var(--bento-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
        }

        /* --- BENTO GRID SYSTEM --- */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .bento-box {
            background: var(--bento-surface);
            border-radius: var(--bento-radius);
            box-shadow: var(--bento-shadow);
            border: var(--bento-border);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .bento-span-8 {
            grid-column: span 8;
        }

        .bento-span-4 {
            grid-column: span 4;
        }

        @media (max-width: 992px) {

            .bento-span-8,
            .bento-span-4 {
                grid-column: span 12;
            }
        }

        /* --- MODERN FORM CONTROLS --- */
        .form-label-premium {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.6rem;
            display: block;
        }

        .form-control-premium,
        .form-select-premium {
            border: 1px solid var(--border-light);
            border-radius: 14px;
            padding: 0.8rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
            background-color: #f8fafc;
            transition: all 0.25s ease;
            width: 100%;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.01);
        }

        .form-select-premium {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1.2rem center;
            background-size: 14px;
            padding-right: 3rem;
            cursor: pointer;
        }

        .form-control-premium:focus,
        .form-select-premium:focus {
            background-color: #ffffff;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px var(--brand-primary-soft);
            outline: none;
        }

        textarea.form-control-premium {
            min-height: 120px;
            resize: vertical;
            line-height: 1.6;
        }

        .input-group-text-premium {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            z-index: 5;
        }

        .has-icon {
            padding-left: 3rem !important;
        }

        /* --- BUTTONS --- */
        .btn-bento-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            color: white;
            font-weight: 800;
            border-radius: 12px;
            padding: 0.8rem 2rem;
            border: none;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-bento-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.35);
            color: white;
        }

        .btn-bento-outline {
            background: white;
            color: var(--text-muted);
            font-weight: 700;
            border-radius: 12px;
            padding: 0.8rem 1.5rem;
            border: 1px solid var(--border-light);
            transition: 0.3s;
        }

        .btn-bento-outline:hover {
            background: #f1f5f9;
            color: var(--text-main);
            border-color: #cbd5e1;
        }

        /* --- GUIDELINE CARD (GLASSMORPHISM) --- */
        .guideline-card {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            color: white;
        }

        .guideline-card::before {
            content: '';
            position: absolute;
            right: -20%;
            top: -10%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.4) 0%, transparent 70%);
            border-radius: 50%;
        }

        .sev-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
        }

        .sev-dot-lg {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }
    </style>
@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y pb-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bolder text-dark mb-1" style="font-size: 1.5rem; letter-spacing: -0.5px;">Formulir NCR Baru
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 0.85rem; font-weight: 600;">
                        <li class="breadcrumb-item"><a href="#"
                                class="text-primary text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-primary text-decoration-none">Log NCR</a>
                        </li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Tambah Laporan</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="#" class="btn btn-bento-outline text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="bento-grid">

            <div class="bento-box bento-span-8">
                <div class="mb-4 border-bottom pb-3">
                    <h5 class="fw-bolder text-dark mb-1"><i class="bi bi-file-earmark-plus text-primary me-2"></i>Rincian
                        Ketidaksesuaian</h5>
                    <p class="text-muted small fw-medium mb-0">Lengkapi data laporan dengan jelas dan detail sesuai temuan
                        lapangan.</p>
                </div>

                <form action="{{ route('ncr.store') }}" method="POST">
                    @csrf

                    <div class="row g-4 mb-4">
                        <div class="col-md-6 position-relative">
                            <label class="form-label-premium">Nomor Dokumen NCR <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-hash input-group-text-premium"></i>
                                <input type="text" name="no_ncr" class="form-control-premium has-icon"
                                    placeholder="Contoh: NCR-2601-001" required>
                            </div>
                        </div>

                        <div class="col-md-6 position-relative">
                            <label class="form-label-premium">Tanggal Terbit (Issue Date) <span
                                    class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-calendar-event input-group-text-premium"></i>
                                <input type="date" name="issue_date" class="form-control-premium has-icon"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4 position-relative">
                            <label class="form-label-premium">Nomor PO <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-receipt input-group-text-premium"></i>
                                <input type="text" name="no_po" class="form-control-premium has-icon"
                                    placeholder="Contoh: PO-2023-..." required>
                            </div>
                        </div>

                        <div class="col-md-4 position-relative">
                            <label class="form-label-premium">Qty Barang <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-boxes input-group-text-premium"></i>
                                <input type="number" name="qty" class="form-control-premium has-icon"
                                    placeholder="Jumlah item" min="1" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Report Reff</label>
                            <select name="report_reff" class="form-select-premium">
                                <option value="" disabled selected>-- Pilih Referensi --</option>
                                <option value="Laporan Internal">PBM</option>
                                <option value="Laporan Eksternal">IVD</option>
                                <option value="Audit Supplier">MCH</option>
                                <option value="Inspeksi Lapangan">WLD</option>
                                <option value="Keluhan Pelanggan">DPT</option>
                                <option value="Keluhan Pelanggan">MPT</option>
                                <option value="Keluhan Pelanggan">ASSY</option>
                                <option value="Lainnya">Others</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Audit Scope <span class="text-danger">*</span></label>
                            <select name="audit_scope" class="form-select-premium" required>
                                <option value="" disabled selected>-- Pilih Scope --</option>
                                <option value="Internal">Internal</option>
                                <option value="External">External</option>
                                <option value="Supplier">Supplier</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Tingkat Keparahan (Severity) <span
                                    class="text-danger">*</span></label>
                            <select name="severity" class="form-select-premium" required>
                                <option value="Medium" selected>Medium (Default)</option>
                                <option value="Low">Low</option>
                                <option value="High">High</option>
                                <option value="Critical">Critical</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Status Awal <span class="text-danger">*</span></label>
                            <select name="status" class="form-select-premium" required>
                                <option value="Open" selected>Open</option>
                                <option value="Monitoring">Monitoring</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label-premium">Deskripsi Temuan (Issue) <span
                                    class="text-danger">*</span></label>
                            <textarea name="issue" class="form-control-premium"
                                placeholder="Jelaskan secara detail ketidaksesuaian yang ditemukan, lokasi, dan dampaknya..." required></textarea>
                            <small class="text-muted fw-semibold mt-2 d-block"><i class="bi bi-info-circle me-1"></i>
                                Berikan deskripsi yang spesifik agar memudahkan proses RCA (Root Cause Analysis).</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label-premium">Tindakan / Correction <span
                                    class="text-danger">*</span></label>
                            <textarea name="tindakan" class="form-control-premium"
                                placeholder="Jelaskan tindakan perbaikan atau penanganan awal yang dilakukan terhadap temuan di atas..." required></textarea>
                            <small class="text-muted fw-semibold mt-2 d-block"><i class="bi bi-check2-square me-1"></i>
                                Tuliskan koreksi langsung yang sudah dilakukan di lapangan.</small>
                        </div>
                    </div>

                    <hr class="my-4 border-light">

                    <div class="d-flex justify-content-end gap-3">
                        <button type="reset" class="btn-bento-outline">Reset Form</button>
                        <button type="submit" class="btn-bento-primary">
                            <i class="bi bi-check2-circle fs-5"></i> Simpan Laporan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bento-box bento-span-4 guideline-card">
                <div class="position-relative z-1">
                    <h5 class="fw-bolder text-white mb-2"><i
                            class="bi bi-shield-exclamation text-warning me-2"></i>Panduan
                        Severity</h5>
                    <p class="text-white-50 small fw-medium mb-4">Gunakan panduan berikut untuk menentukan Tingkat
                        Keparahan (Severity) NCR secara akurat.</p>

                    <div class="sev-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="sev-dot-lg" style="background-color: #ef4444;"></span>
                            <span class="fw-bold text-white tracking-wide uppercase"
                                style="font-size: 0.85rem;">Critical</span>
                        </div>
                        <p class="text-white-50 mb-0" style="font-size: 0.8rem; line-height: 1.5;">Berdampak langsung pada
                            kegagalan fungsi produk, risiko keselamatan (safety), atau reject klien. <b>Stop proses
                                produksi/pengiriman.</b></p>
                    </div>

                    <div class="sev-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="sev-dot-lg" style="background-color: #f59e0b;"></span>
                            <span class="fw-bold text-white tracking-wide uppercase"
                                style="font-size: 0.85rem;">High</span>
                        </div>
                        <p class="text-white-50 mb-0" style="font-size: 0.8rem; line-height: 1.5;">Ketidaksesuaian major
                            pada dimensi/material yang butuh *rework* besar atau penggantian material. Menghambat jadwal.
                        </p>
                    </div>

                    <div class="sev-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="sev-dot-lg" style="background-color: #4f46e5;"></span>
                            <span class="fw-bold text-white tracking-wide uppercase"
                                style="font-size: 0.85rem;">Medium</span>
                        </div>
                        <p class="text-white-50 mb-0" style="font-size: 0.8rem; line-height: 1.5;">Dapat diperbaiki
                            (*repairable*) tanpa mempengaruhi fungsi utama. Contoh: kesalahan marking, dokumen ITP telat.
                        </p>
                    </div>

                    <div class="sev-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="sev-dot-lg" style="background-color: #10b981;"></span>
                            <span class="fw-bold text-white tracking-wide uppercase"
                                style="font-size: 0.85rem;">Low</span>
                        </div>
                        <p class="text-white-50 mb-0" style="font-size: 0.8rem; line-height: 1.5;">Masalah kosmetik minor
                            atau administrasi ringan yang masih dalam batas toleransi terima (*Accept as is*).</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
