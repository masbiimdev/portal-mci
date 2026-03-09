@extends('layouts.admin')
@section('title', 'Tambah History Kalibrasi')

@push('css')
    <style>
        /* Memberikan efek fokus yang lebih lembut pada input */
        .form-control:focus,
        .form-select:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1);
        }

        /* Section Divider */
        .form-section-title {
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #566a7f;
            border-bottom: 1px solid #d9dee3;
            padding-bottom: 10px;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .card {
            border: none;
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">QC / Kalibrasi /</span> Tambah History Baru
            </h4>
            @if (request('from') === 'index')
                <a href="{{ route('histories.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Kembali ke Daftar
                </a>
            @else
                <a href="{{ route('histories.show', request()->tool_id) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Kembali ke Detail
                </a>
            @endif
        </div>

        <div class="row">
            <div class="col-md-10 col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                        <h5 class="mb-0">Form Record Kalibrasi</h5>
                        <small class="text-muted float-end">Input data sertifikasi terbaru</small>
                    </div>
                    <div class="card-body mt-4">

                        <form action="{{ route('histories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- INPUT UNTUK REDIRECT --}}
                            <input type="hidden" name="redirect_to" value="{{ request('from') ?? 'show' }}">

                            {{-- SECTION 1: INFORMASI ALAT --}}
                            <div class="form-section-title">
                                <i class="bx bx-wrench me-2"></i>Informasi Item
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Nama Item / Instrumen</label>
                                @if (request()->tool_id)
                                    <input type="hidden" name="tool_id" value="{{ request()->tool_id }}">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-package"></i></span>
                                        <input type="text" class="form-control bg-light"
                                            value="{{ $tool->nama_alat }} ({{ $tool->no_seri }})" readonly>
                                    </div>
                                @else
                                    <select name="tool_id" class="form-select @error('tool_id') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih Alat --</option>
                                        @foreach ($tools as $t)
                                            <option value="{{ $t->id }}"
                                                {{ old('tool_id') == $t->id ? 'selected' : '' }}>
                                                {{ $t->nama_alat }} ({{ $t->no_seri }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tool_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>

                            {{-- SECTION 2: JADWAL & SERTIFIKASI --}}
                            <div class="form-section-title">
                                <i class="bx bx-calendar-check me-2"></i>Jadwal & Sertifikasi
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Kalibrasi</label>
                                    <input type="date" name="tgl_kalibrasi"
                                        class="form-control @error('tgl_kalibrasi') is-invalid @enderror"
                                        value="{{ old('tgl_kalibrasi') }}">
                                    @error('tgl_kalibrasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-primary fw-bold">Tanggal Kalibrasi Ulang</label>
                                    <input type="date" name="tgl_kalibrasi_ulang"
                                        class="form-control @error('tgl_kalibrasi_ulang') is-invalid @enderror border-primary"
                                        value="{{ old('tgl_kalibrasi_ulang') }}">
                                    @error('tgl_kalibrasi_ulang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Sertifikat</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-hash"></i></span>
                                        <input type="text" name="no_sertifikat" class="form-control"
                                            placeholder="Contoh: CERT/2023/001" value="{{ old('no_sertifikat') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lembaga Kalibrasi</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                        <input type="text" name="lembaga_kalibrasi" class="form-control"
                                            placeholder="Contoh: Sucofindo, B4T" value="{{ old('lembaga_kalibrasi') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Interval Kalibrasi</label>
                                    <input type="text" name="interval_kalibrasi" class="form-control"
                                        placeholder="Contoh: 1 Tahun / 6 Bulan" value="{{ old('interval_kalibrasi') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Upload Sertifikat (PDF)</label>
                                    <input type="file" name="file_sertifikat" class="form-control"
                                        accept="application/pdf">
                                    <small class="text-muted italic">Maksimal ukuran file: 2MB</small>
                                </div>
                            </div>

                            {{-- SECTION 3: STATUS & KETERANGAN --}}
                            <div class="form-section-title">
                                <i class="bx bx-info-circle me-2"></i>Status Akhir
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Eksternal Kalibrasi</label>
                                    <select name="eksternal_kalibrasi" class="form-select">
                                        <option value="YA">YA (Pihak Ketiga)</option>
                                        <option value="TIDAK">TIDAK (Internal)</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Kalibrasi</label>
                                    <select name="status_kalibrasi" class="form-select fw-bold">
                                        <option value="OK" class="text-success">🟢 OK / Layak Pakai</option>
                                        <option value="PROSES" class="text-warning">🟡 Sedang Proses</option>
                                        <option value="DUE SOON" class="text-danger">🔴 Akan Jatuh Tempo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Keterangan Tambahan</label>
                                <textarea name="keterangan" class="form-control" rows="3"
                                    placeholder="Masukkan catatan atau alasan jika ada...">{{ old('keterangan') }}</textarea>
                            </div>

                            <div class="pt-3 d-flex justify-content-end gap-3 border-top">
                                @if (request('from') === 'index')
                                    <a href="{{ route('histories.index') }}" class="btn btn-label-secondary">Batal</a>
                                @else
                                    <a href="{{ route('histories.show', request()->tool_id) }}"
                                        class="btn btn-label-secondary">Batal</a>
                                @endif

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-save me-2"></i>Simpan Record
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
