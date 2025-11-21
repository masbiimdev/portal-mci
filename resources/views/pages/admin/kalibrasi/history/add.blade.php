@extends('layouts.admin')
@section('title', 'Tambah History Kalibrasi')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">QC / Kalibrasi /</span> Tambah History
    </h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('histories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- INPUT UNTUK REDIRECT --}}
                <input type="hidden" name="redirect_to" value="{{ request('from') ?? 'show' }}">

                {{-- TOOL --}}
                <div class="mb-3">
                    <label class="form-label">Nama Item</label>

                    @if(request()->tool_id)
                        <input type="hidden" name="tool_id" value="{{ request()->tool_id }}">
                        <input type="text" class="form-control" value="{{ $tool->nama_alat }}" readonly>
                    @else
                        <select name="tool_id" class="form-select" required>
                            <option value="">-- Pilih Alat --</option>
                            @foreach ($tools as $t)
                                <option value="{{ $t->id }}">
                                    {{ $t->nama_alat }} ({{ $t->no_seri }})
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kalibrasi</label>
                        <input type="date" name="tgl_kalibrasi" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kalibrasi Ulang</label>
                        <input type="date" name="tgl_kalibrasi_ulang" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Sertifikat</label>
                    <input type="text" name="no_sertifikat" class="form-control" placeholder="Masukkan nomor sertifikat">
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Sertifikat (PDF)</label>
                    <input type="file" name="file_sertifikat" class="form-control" accept="application/pdf">
                </div>

                <div class="mb-3">
                    <label class="form-label">Lembaga Kalibrasi</label>
                    <input type="text" name="lembaga_kalibrasi" class="form-control" placeholder="Contoh: Sucofindo, B4T, dll">
                </div>

                <div class="mb-3">
                    <label class="form-label">Interval Kalibrasi</label>
                    <input type="text" name="interval_kalibrasi" class="form-control" placeholder="Contoh: 6 Bulan, 1 Tahun">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Eksternal Kalibrasi</label>
                        <select name="eksternal_kalibrasi" class="form-select">
                            <option value="YA">YA</option>
                            <option value="TIDAK">TIDAK</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status Kalibrasi</label>
                        <select name="status_kalibrasi" class="form-select">
                            <option value="OK">OK</option>
                            <option value="PROSES">Proses</option>
                            <option value="DUE SOON">Akan Jatuh Tempo</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Sudah dikirim 30-10-25"></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    {{-- Batal mengarah sesuai asal --}}
                    @if(request('from') === 'index')
                        <a href="{{ route('histories.index') }}" class="btn btn-secondary">Batal</a>
                    @else
                        <a href="{{ route('histories.show', request()->tool_id) }}" class="btn btn-secondary">Batal</a>
                    @endif

                    <button type="submit" class="btn btn-primary">Simpan History</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
