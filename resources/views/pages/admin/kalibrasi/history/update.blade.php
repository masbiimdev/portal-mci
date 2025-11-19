@extends('layouts.admin')
@section('title', 'Edit History Kalibrasi')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">QC / Kalibrasi /</span> Edit History {{ $tool->nama_alat }}
        </h4>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('histories.update', $history->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Alat</label>
                        <input type="text" class="form-control" value="{{ $tool->nama_alat }}" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kalibrasi</label>
                            <input type="date" name="tgl_kalibrasi" class="form-control"
                                value="{{ old('tgl_kalibrasi', $history->tgl_kalibrasi ? $history->tgl_kalibrasi->format('Y-m-d') : '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kalibrasi Ulang</label>
                            <input type="date" name="tgl_kalibrasi_ulang" class="form-control"
                                value="{{ old('tgl_kalibrasi_ulang', $history->tgl_kalibrasi_ulang ? $history->tgl_kalibrasi_ulang->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Sertifikat</label>
                        <input type="text" name="no_sertifikat" class="form-control"
                            value="{{ old('no_sertifikat', $history->no_sertifikat) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Sertifikat (PDF)</label>
                        <input type="file" name="file_sertifikat" class="form-control" accept="application/pdf">
                        @if ($history->file_sertifikat)
                            <small class="text-muted">File lama: {{ $history->file_sertifikat }}</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lembaga Kalibrasi</label>
                        <input type="text" name="lembaga_kalibrasi" class="form-control"
                            value="{{ old('lembaga_kalibrasi', $history->lembaga_kalibrasi) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Interval Kalibrasi</label>
                        <input type="text" name="interval_kalibrasi" class="form-control"
                            value="{{ old('interval_kalibrasi', $history->interval_kalibrasi) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Eksternal Kalibrasi</label>
                            <select name="eksternal_kalibrasi" class="form-select">
                                <option value="YA" {{ $history->eksternal_kalibrasi == 'YA' ? 'selected' : '' }}>YA
                                </option>
                                <option value="TIDAK" {{ $history->eksternal_kalibrasi == 'TIDAK' ? 'selected' : '' }}>
                                    TIDAK</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Kalibrasi</label>
                            <select name="status_kalibrasi" class="form-select">
                                <option value="OK" {{ $history->status_kalibrasi == 'OK' ? 'selected' : '' }}>OK
                                </option>
                                <option value="Proses" {{ $history->status_kalibrasi == 'Proses' ? 'selected' : '' }}>
                                    Proses</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $history->keterangan) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('histories.show', $tool->id) }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
