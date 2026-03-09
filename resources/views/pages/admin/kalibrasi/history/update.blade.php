@extends('layouts.admin')
@section('title', 'Edit History Kalibrasi')

@push('css')
    <style>
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .form-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--bs-primary);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0f2f4;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-label {
            font-weight: 600;
            color: #566a7f;
        }

        .input-group-text {
            background-color: #f8f9fa;
        }

        .file-preview-box {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px dashed #d9dee3;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">QC / Kalibrasi /</span> Edit History
            </h4>
            <a href="{{ route('histories.show', $tool->id) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-body p-4">
                        <form action="{{ route('histories.update', $history->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-section-title">
                                <i class="bx bx-info-circle"></i> Identitas Alat
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Nama Alat</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-wrench"></i></span>
                                    <input type="text" class="form-control bg-light" value="{{ $tool->nama_alat }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="form-section-title">
                                <i class="bx bx-calendar"></i> Jadwal Kalibrasi
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="tgl_kalibrasi">Tanggal Kalibrasi</label>
                                    <input type="date" name="tgl_kalibrasi" id="tgl_kalibrasi"
                                        class="form-control @error('tgl_kalibrasi') is-invalid @enderror"
                                        value="{{ old('tgl_kalibrasi', $history->tgl_kalibrasi ? $history->tgl_kalibrasi->format('Y-m-d') : '') }}">
                                    @error('tgl_kalibrasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="tgl_kalibrasi_ulang">Tanggal Kalibrasi Ulang</label>
                                    <input type="date" name="tgl_kalibrasi_ulang" id="tgl_kalibrasi_ulang"
                                        class="form-control @error('tgl_kalibrasi_ulang') is-invalid @enderror"
                                        value="{{ old('tgl_kalibrasi_ulang', $history->tgl_kalibrasi_ulang ? $history->tgl_kalibrasi_ulang->format('Y-m-d') : '') }}">
                                    @error('tgl_kalibrasi_ulang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Interval Kalibrasi</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" name="interval_kalibrasi" class="form-control"
                                            placeholder="Contoh: 12"
                                            value="{{ old('interval_kalibrasi', $history->interval_kalibrasi) }}">
                                        <span class="input-group-text">Bulan</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Kalibrasi</label>
                                    <select name="status_kalibrasi"
                                        class="form-select @error('status_kalibrasi') is-invalid @enderror">
                                        <option value="OK"
                                            {{ old('status_kalibrasi', $history->status_kalibrasi) == 'OK' ? 'selected' : '' }}>
                                            🟢 OK</option>
                                        <option value="PROSES"
                                            {{ old('status_kalibrasi', $history->status_kalibrasi) == 'PROSES' ? 'selected' : '' }}>
                                            🟡 Proses</option>
                                        <option value="DUE SOON"
                                            {{ old('status_kalibrasi', $history->status_kalibrasi) == 'DUE SOON' ? 'selected' : '' }}>
                                            🔴 Akan Jatuh Tempo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-section-title">
                                <i class="bx bx-certification"></i> Sertifikasi & Lembaga
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Sertifikat</label>
                                    <input type="text" name="no_sertifikat" class="form-control"
                                        value="{{ old('no_sertifikat', $history->no_sertifikat) }}"
                                        placeholder="Masukkan nomor sertifikat">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Eksternal Kalibrasi</label>
                                    <select name="eksternal_kalibrasi" class="form-select">
                                        <option value="YA"
                                            {{ $history->eksternal_kalibrasi == 'YA' ? 'selected' : '' }}>YA (Pihak Ke-3)
                                        </option>
                                        <option value="TIDAK"
                                            {{ $history->eksternal_kalibrasi == 'TIDAK' ? 'selected' : '' }}>TIDAK
                                            (Internal)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Lembaga Kalibrasi</label>
                                <input type="text" name="lembaga_kalibrasi" class="form-control"
                                    value="{{ old('lembaga_kalibrasi', $history->lembaga_kalibrasi) }}"
                                    placeholder="Nama vendor/lembaga">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Perbarui Sertifikat (PDF)</label>
                                <input type="file" name="file_sertifikat" class="form-control" accept="application/pdf">
                                @if ($history->file_sertifikat)
                                    <div class="file-preview-box">
                                        <i class="bx bxs-file-pdf text-danger fs-4"></i>
                                        <div class="overflow-hidden">
                                            <div class="text-dark fw-semibold small">Sertifikat Saat Ini:</div>
                                            <div class="text-muted small text-truncate">
                                                {{ basename($history->file_sertifikat) }}</div>
                                        </div>
                                        <a href="{{ asset('storage/' . $history->file_sertifikat) }}" target="_blank"
                                            class="btn btn-xs btn-outline-primary ms-auto">Lihat</a>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Keterangan Tambahan</label>
                                <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan jika ada...">{{ old('keterangan', $history->keterangan) }}</textarea>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-label-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
