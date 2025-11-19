@extends('layouts.admin')
@section('title', 'History Kalibrasi Alat')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">QC / Kalibrasi /</span> History {{ $tool->nama_alat }}
    </h4>

    {{-- INFO ALAT --}}
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-start">
            <div>
                <h5 class="mb-2">{{ $tool->nama_alat }}</h5>
                <p class="mb-1"><strong>Merek:</strong> {{ $tool->merek ?? '-' }}</p>
                <p class="mb-1"><strong>No Seri:</strong> {{ $tool->no_seri ?? '-' }}</p>
                <p class="mb-0"><strong>Kapasitas:</strong> {{ $tool->kapasitas ?? '-' }}</p>
            </div>

            @if ($tool->qr_code_path)
                <img src="{{ asset('storage/app/public/uploads/' . $tool->qr_code_path) }}" width="110" height="110"
                    class="border rounded">
            @endif
        </div>
    </div>

    {{-- TABLE HISTORY --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Riwayat Kalibrasi</h5>

            <a href="{{ route('histories.create', ['tool_id' => $tool->id, 'redirect_to' => 'show']) }}"
                class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah History
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No Sertifikat</th>
                            <th>Lembaga</th>
                            <th>Status</th>
                            <th>Ulang</th>
                            <th style="width: 140px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tool->histories as $h)
                            <tr>
                                <td>{{ $h->tgl_kalibrasi ? \Carbon\Carbon::parse($h->tgl_kalibrasi)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $h->no_sertifikat ?? '-' }}</td>
                                <td>{{ $h->lembaga_kalibrasi ?? '-' }}</td>
                                <td>
                                    @if ($h->status_kalibrasi === 'OK')
                                        <span class="badge bg-success">OK</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Proses</span>
                                    @endif
                                </td>
                                <td>{{ $h->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($h->tgl_kalibrasi_ulang)->format('d-m-Y') : '-' }}</td>

                                <td class="d-flex gap-2">
                                    {{-- Lihat PDF (popup modal) --}}
                                    @if ($h->file_sertifikat)
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            onclick="openPDFModal('{{ asset('storage/app/public/uploads/' . $h->file_sertifikat) }}')">
                                            PDF
                                        </button>
                                    @endif

                                    {{-- EDIT --}}
                                    <a href="{{ route('histories.edit', $h->id) }}" class="btn btn-sm btn-primary">
                                        Edit
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('histories.destroy', $h->id) }}" method="POST" class="delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Belum ada history kalibrasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Modal PDF --}}
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdfModalLabel">Sertifikat PDF</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body p-0">
        <iframe id="pdfFrame" src="" frameborder="0" style="width:100%; height:80vh;"></iframe>
      </div>
    </div>
  </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfirmasi Delete
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus History?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    // Fungsi buka modal PDF
    function openPDFModal(url) {
        const pdfFrame = document.getElementById('pdfFrame');
        pdfFrame.src = url;
        const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
        pdfModal.show();
    }

    // Clear iframe ketika modal ditutup
    const pdfModalEl = document.getElementById('pdfModal');
    pdfModalEl.addEventListener('hidden.bs.modal', function () {
        document.getElementById('pdfFrame').src = '';
    });
</script>
@endpush
