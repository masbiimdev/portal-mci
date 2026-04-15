@extends('layouts.admin')
@section('title', 'Edit Laporan NCR - ' . $ncr->no_ncr)

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* --- GLOBAL BENTO VARIABLES (Maintain Consistency) --- */
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

        /* Disabled Input Style */
        .form-control-premium:readonly,
        .form-control-premium[readonly],
        .form-control-premium:disabled,
        .form-select-premium:disabled {
            background-color: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            border-color: #e2e8f0;
        }

        textarea.form-control-premium {
            min-height: 140px;
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

    {{-- ==== DATA SIMULASI SESUAI MIGRATION BARU ==== --}}
    @php
        // Dalam Laravel nyata, data ini akan dikirim dari Controller: view('...', compact('ncr'))
        if (!isset($ncr)) {
            $ncr = (object) [
                'id' => 123,
                'no_ncr' => 'NCR-2601-001',
                'issue_date' => '2026-01-10',
                'no_po' => 'PO-2023-1029',
                'qty' => 50,
                'report_reff' => 'Laporan Eksternal - IVD',
                'issue' => 'Dimensi body Gate Valve 4" tidak masuk toleransi gambar teknik pada area seat pocket.',
                'tindakan' => 'Melakukan machining ulang pada area seat pocket dan kalibrasi ulang alat ukur.',
                'audit_scope' => 'Supplier',
                'severity' => 'High',
                'status' => 'Monitoring',
            ];
        }
    @endphp

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
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Terdapat kesalahan pada form. Silakan periksa kembali
                kolom berwarna merah.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bolder text-dark mb-1" style="font-size: 1.5rem; letter-spacing: -0.5px;">Edit Laporan NCR
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 0.85rem; font-weight: 600;">
                        <li class="breadcrumb-item"><a href="#"
                                class="text-primary text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ncr.index') }}"
                                class="text-primary text-decoration-none">Log NCR</a>
                        </li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Edit - {{ $ncr->no_ncr }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('ncr.index') }}" class="btn btn-bento-outline text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Batal / Kembali
                </a>
            </div>
        </div>

        <div class="bento-grid">

            <div class="bento-box bento-span-8">
                <div class="mb-4 border-bottom pb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bolder text-dark mb-1"><i class="bi bi-pencil-square text-warning me-2"></i>Update
                            Rincian Ketidaksesuaian</h5>
                        <p class="text-muted small fw-medium mb-0">Perbarui data laporan NCR jika terdapat revisi temuan
                            atau perubahan status.</p>
                    </div>
                    <span
                        class="badge bg-light border p-2 rounded-3 fw-bold text-muted font-monospace">{{ $ncr->no_ncr }}</span>
                </div>

                <form action="{{ route('ncr.update', $ncr->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- PENTING UNTUK EDIT/UPDATE --}}

                    <div class="row g-4 mb-4">
                        <div class="col-md-6 position-relative">
                            <label class="form-label-premium">Nomor Dokumen NCR <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-hash input-group-text-premium"></i>
                                <input type="text" readonly name="no_ncr" class="form-control-premium has-icon"
                                    value="{{ old('no_ncr', $ncr->no_ncr) }}" required>
                            </div>
                            <small class="text-muted fw-semibold mt-1 d-block" style="font-size: 0.7rem;"><i
                                    class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Nomor dokumen tidak dapat
                                diubah.</small>
                        </div>

                        <div class="col-md-6 position-relative">
                            <label class="form-label-premium">Tanggal Terbit (Issue Date) <span
                                    class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-calendar-event input-group-text-premium"></i>
                                <input type="date" name="issue_date"
                                    class="form-control-premium has-icon @error('issue_date') is-invalid @enderror"
                                    value="{{ old('issue_date', \Carbon\Carbon::parse($ncr->issue_date)->format('Y-m-d')) }}"
                                    required>
                            </div>
                            @error('issue_date')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4 position-relative">
                            <label class="form-label-premium">Nomor PO</label>
                            <div class="position-relative">
                                <i class="bi bi-receipt input-group-text-premium"></i>
                                <input type="text" name="no_po"
                                    class="form-control-premium has-icon @error('no_po') is-invalid @enderror"
                                    value="{{ old('no_po', $ncr->no_po) }}" placeholder="Contoh: PO-2023-...">
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
                                    value="{{ old('qty', $ncr->qty) }}" placeholder="Jumlah item" min="1" required>
                            </div>
                            @error('qty')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Report Reff</label>
                            <select name="report_reff"
                                class="form-select-premium @error('report_reff') is-invalid @enderror">
                                <option value="" disabled
                                    {{ empty(old('report_reff', $ncr->report_reff)) ? 'selected' : '' }}>-- Pilih Referensi
                                    --</option>
                                <option value="PBM"
                                    {{ old('report_reff', $ncr->report_reff) == 'PBM' ? 'selected' : '' }}>Laporan Internal
                                    - PBM</option>
                                <option value="IVD"
                                    {{ old('report_reff', $ncr->report_reff) == 'IVD' ? 'selected' : '' }}>Laporan
                                    Eksternal - IVD</option>
                                <option value="MCH"
                                    {{ old('report_reff', $ncr->report_reff) == 'MCH' ? 'selected' : '' }}>Audit Supplier -
                                    MCH</option>
                                <option value="WLD"
                                    {{ old('report_reff', $ncr->report_reff) == 'WLD' ? 'selected' : '' }}>Inspeksi
                                    Lapangan - WLD</option>
                                <option value="DPT"
                                    {{ old('report_reff', $ncr->report_reff) == 'DPT' ? 'selected' : '' }}>Keluhan
                                    Pelanggan - DPT</option>
                                <option value="MPT"
                                    {{ old('report_reff', $ncr->report_reff) == 'MPT' ? 'selected' : '' }}>Keluhan
                                    Pelanggan - MPT</option>
                                <option value="ASSY"
                                    {{ old('report_reff', $ncr->report_reff) == 'ASSY' ? 'selected' : '' }}>Keluhan
                                    Pelanggan - ASSY</option>
                                <option value="Others"
                                    {{ old('report_reff', $ncr->report_reff) == 'Others' ? 'selected' : '' }}>Lainnya -
                                    Others</option>
                            </select>
                            @error('report_reff')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Audit Scope <span class="text-danger">*</span></label>
                            <select name="audit_scope"
                                class="form-select-premium @error('audit_scope') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih Scope --</option>
                                <option value="Internal"
                                    {{ old('audit_scope', $ncr->audit_scope) == 'Internal' ? 'selected' : '' }}>Internal
                                </option>
                                <option value="External"
                                    {{ old('audit_scope', $ncr->audit_scope) == 'External' ? 'selected' : '' }}>External
                                </option>
                                <option value="Supplier"
                                    {{ old('audit_scope', $ncr->audit_scope) == 'Supplier' ? 'selected' : '' }}>Supplier
                                </option>
                            </select>
                            @error('audit_scope')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Tingkat Keparahan <span class="text-danger">*</span></label>
                            <select name="severity" class="form-select-premium @error('severity') is-invalid @enderror"
                                required>
                                <option value="Low" {{ old('severity', $ncr->severity) == 'Low' ? 'selected' : '' }}>
                                    Low</option>
                                <option value="Medium"
                                    {{ old('severity', $ncr->severity) == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ old('severity', $ncr->severity) == 'High' ? 'selected' : '' }}>
                                    High</option>
                                <option value="Critical"
                                    {{ old('severity', $ncr->severity) == 'Critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                            @error('severity')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-premium">Status Saat Ini <span class="text-danger">*</span></label>
                            <select name="status" class="form-select-premium @error('status') is-invalid @enderror"
                                required>
                                <option value="Open" {{ old('status', $ncr->status) == 'Open' ? 'selected' : '' }}>Open
                                </option>
                                <option value="Monitoring"
                                    {{ old('status', $ncr->status) == 'Monitoring' ? 'selected' : '' }}>Monitoring</option>
                                <option value="Closed" {{ old('status', $ncr->status) == 'Closed' ? 'selected' : '' }}>
                                    Closed</option>
                            </select>
                            @error('status')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label-premium">Deskripsi Temuan (Issue) <span
                                    class="text-danger">*</span></label>
                            <textarea name="issue" class="form-control-premium @error('issue') is-invalid @enderror"
                                placeholder="Jelaskan secara detail ketidaksesuaian..." required>{{ old('issue', $ncr->issue) }}</textarea>
                            @error('issue')
                                <small class="text-danger fw-semibold mt-1 d-block">{{ $message }}</small>
                            @else
                                <small class="text-muted fw-semibold mt-2 d-block"><i class="bi bi-info-circle me-1"></i>
                                    Pastikan deskripsi mencakup lokasi, dampak, dan standar yang dilanggar.</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label-premium">Tindakan / Correction <span
                                    class="text-danger">*</span></label>
                            <textarea name="tindakan" class="form-control-premium @error('tindakan') is-invalid @enderror"
                                placeholder="Jelaskan tindakan perbaikan atau penanganan awal..." required>{{ old('tindakan', $ncr->tindakan) }}</textarea>
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
                        <a href="{{ route('ncr.index') }}" class="btn-bento-outline text-decoration-none">Batal</a>
                        <button type="submit" class="btn-bento-primary">
                            <i class="bi bi-check2-all fs-5"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bento-box bento-span-4 guideline-card">
                <div class="position-relative z-1">
                    <h5 class="fw-bolder text-white mb-2"><i
                            class="bi bi-shield-exclamation text-warning me-2"></i>Panduan Severity</h5>
                    <p class="text-white-50 small fw-medium mb-4">Gunakan panduan berikut jika Anda ragu menentukan kembali
                        Tingkat Keparahan NCR.</p>

                    <div class="sev-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="sev-dot-lg" style="background-color: #ef4444;"></span>
                            <span class="fw-bold text-white tracking-wide uppercase"
                                style="font-size: 0.85rem;">Critical</span>
                        </div>
                        <p class="text-white-50 mb-0" style="font-size: 0.8rem; line-height: 1.5;">Gagal fungsi, risiko
                            keselamatan, reject klien. <b>Produksi/pengiriman berhenti.</b></p>
                    </div>

                    <div class="sev-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="sev-dot-lg" style="background-color: #f59e0b;"></span>
                            <span class="fw-bold text-white tracking-wide uppercase"
                                style="font-size: 0.85rem;">High</span>
                        </div>
                        <p class="text-white-50 mb-0" style="font-size: 0.8rem; line-height: 1.5;">Major defect
                            dimensi/material. Butuh rework besar/penggantian material. Mengganggu jadwal.</p>
                    </div>

                    <div class="sev-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="sev-dot-lg" style="background-color: #4f46e5;"></span>
                            <span class="fw-bold text-white tracking-wide uppercase"
                                style="font-size: 0.85rem;">Medium</span>
                        </div>
                        <p class="text-white-50 mb-0" style="font-size: 0.8rem; line-height: 1.5;">Repairable tanpa
                            pengaruhi fungsi. Kesalahan marking, ITP telat.</p>
                    </div>

                    <div class="sev-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="sev-dot-lg" style="background-color: #10b981;"></span>
                            <span class="fw-bold text-white tracking-wide uppercase"
                                style="font-size: 0.85rem;">Low</span>
                        </div>
                        <p class="text-white-50 mb-0" style="font-size: 0.8rem; line-height: 1.5;">Kosmetik minor,
                            administrasi ringan. Dapat diterima apa adanya (*Accept as is*).</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
