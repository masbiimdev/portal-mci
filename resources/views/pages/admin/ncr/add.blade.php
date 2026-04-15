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

        /* CSS Tambahan untuk Error Validasi */
        .form-control-premium.is-invalid,
        .form-select-premium.is-invalid {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        .form-control-premium.is-invalid:focus,
        .form-select-premium.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
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

        {{-- Alert Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 16px;">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 16px;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Terdapat kesalahan pada isian form. Silakan periksa
                kembali kolom berwarna merah.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bolder text-dark mb-1" style="font-size: 1.5rem; letter-spacing: -0.5px;">Formulir NCR Baru
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 0.85rem; font-weight: 600;">
                        <li class="breadcrumb-item"><a href="#"
                                class="text-primary text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ncr.index') }}"
                                class="text-primary text-decoration-none">Log NCR</a>
                        </li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Tambah Laporan</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('ncr.index') }}" class="btn btn-bento-outline text-decoration-none">
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
                        {{-- Menggunakan col-md-6 agar baris pertama terisi penuh dengan 2 kolom ini --}}
                        <div class="col-md-6 position-relative">
                            <label class="form-label-premium">Nomor Dokumen <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-hash input-group-text-premium"></i>
                                <input type="text" name="no_ncr"
                                    class="form-control-premium has-icon @error('no_ncr') is-invalid @enderror"
                                    placeholder="Contoh: NCR-2601-001" value="{{ old('no_ncr') }}" required>
                            </div>
                            @error('no_ncr')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 position-relative">
                            <label class="form-label-premium">Tanggal Terbit <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-calendar-event input-group-text-premium"></i>
                                <input type="date" name="issue_date"
                                    class="form-control-premium has-icon @error('issue_date') is-invalid @enderror"
                                    value="{{ old('issue_date', date('Y-m-d')) }}" required>
                            </div>
                            @error('issue_date')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Baris kedua tetap col-md-4 agar terbagi 3 secara rapi --}}
                        <div class="col-md-4 position-relative">
                            <label class="form-label-premium">Nomor PO</label>
                            <div class="position-relative">
                                <i class="bi bi-receipt input-group-text-premium"></i>
                                <input type="text" name="no_po"
                                    class="form-control-premium has-icon @error('no_po') is-invalid @enderror"
                                    placeholder="Contoh: PO-2023-..." value="{{ old('no_po') }}">
                            </div>
                            @error('no_po')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4 position-relative">
                            <label class="form-label-premium">Qty Barang <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-boxes input-group-text-premium"></i>
                                <input type="number" name="qty"
                                    class="form-control-premium has-icon @error('qty') is-invalid @enderror"
                                    placeholder="Jumlah item" min="1" value="{{ old('qty') }}" required>
                            </div>
                            @error('qty')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Report Reff</label>
                            <select name="report_reff"
                                class="form-select-premium @error('report_reff') is-invalid @enderror">
                                <option value="" disabled {{ old('report_reff') ? '' : 'selected' }}>-- Pilih
                                    Referensi --</option>
                                <option value="PBM" {{ old('report_reff') == 'PBM' ? 'selected' : '' }}>PBM</option>
                                <option value="IVD" {{ old('report_reff') == 'IVD' ? 'selected' : '' }}>IVD</option>
                                <option value="MCH" {{ old('report_reff') == 'MCH' ? 'selected' : '' }}>MCH</option>
                                <option value="WLD" {{ old('report_reff') == 'WLD' ? 'selected' : '' }}>WLD</option>
                                <option value="DPT" {{ old('report_reff') == 'DPT' ? 'selected' : '' }}>DPT</option>
                                <option value="MPT" {{ old('report_reff') == 'MPT' ? 'selected' : '' }}>MPT</option>
                                <option value="ASSY" {{ old('report_reff') == 'ASSY' ? 'selected' : '' }}>ASSY</option>
                                <option value="Others" {{ old('report_reff') == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('report_reff')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Audit Scope <span class="text-danger">*</span></label>
                            <select name="audit_scope"
                                class="form-select-premium @error('audit_scope') is-invalid @enderror" required>
                                <option value="" disabled {{ old('audit_scope') ? '' : 'selected' }}>-- Pilih Scope
                                    --</option>
                                <option value="Internal" {{ old('audit_scope') == 'Internal' ? 'selected' : '' }}>Internal
                                </option>
                                <option value="External" {{ old('audit_scope') == 'External' ? 'selected' : '' }}>External
                                </option>
                                <option value="Supplier" {{ old('audit_scope') == 'Supplier' ? 'selected' : '' }}>Supplier
                                </option>
                            </select>
                            @error('audit_scope')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Severity <span class="text-danger">*</span></label>
                            <select name="severity" class="form-select-premium @error('severity') is-invalid @enderror"
                                required>
                                <option value="Medium" {{ old('severity', 'Medium') == 'Medium' ? 'selected' : '' }}>
                                    Medium (Default)</option>
                                <option value="Low" {{ old('severity') == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="High" {{ old('severity') == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Critical" {{ old('severity') == 'Critical' ? 'selected' : '' }}>Critical
                                </option>
                            </select>
                            @error('severity')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Status Awal <span class="text-danger">*</span></label>
                            <select name="status" class="form-select-premium @error('status') is-invalid @enderror"
                                required>
                                <option value="Open" {{ old('status', 'Open') == 'Open' ? 'selected' : '' }}>Open
                                </option>
                                <option value="Monitoring" {{ old('status') == 'Monitoring' ? 'selected' : '' }}>
                                    Monitoring</option>
                                <option value="Closed" {{ old('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            @error('status')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label-premium">Deskripsi Temuan (Issue) <span
                                    class="text-danger">*</span></label>
                            <textarea name="issue" class="form-control-premium @error('issue') is-invalid @enderror"
                                placeholder="Jelaskan secara detail ketidaksesuaian yang ditemukan, lokasi, dan dampaknya..." required>{{ old('issue') }}</textarea>
                            @error('issue')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @else
                                <small class="text-muted fw-semibold mt-2 d-block"><i class="bi bi-info-circle me-1"></i>
                                    Berikan deskripsi yang spesifik agar memudahkan proses RCA (Root Cause Analysis).</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label-premium">Tindakan / Correction <span
                                    class="text-danger">*</span></label>
                            <textarea name="tindakan" class="form-control-premium @error('tindakan') is-invalid @enderror"
                                placeholder="Jelaskan tindakan perbaikan atau penanganan awal yang dilakukan terhadap temuan di atas..." required>{{ old('tindakan') }}</textarea>
                            @error('tindakan')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @else
                                <small class="text-muted fw-semibold mt-2 d-block"><i class="bi bi-check2-square me-1"></i>
                                    Tuliskan koreksi langsung yang sudah dilakukan di lapangan.</small>
                            @enderror
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
