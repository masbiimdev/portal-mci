@extends('layouts.admin')
@section('title', 'History Detail Kalibrasi')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
        }

        /* ========== INFO CARD STYLING ========== */
        .info-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            background: #ffffff;
        }

        .info-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 1.5rem 2rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
        }

        /* ========== TABLE STYLING ========== */
        .table-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            background: #ffffff;
        }

        .table thead th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            color: #64748b;
            border-top: none;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #334155;
            font-size: 0.9rem;
        }

        /* ========== ICON BUTTONS ========== */
        .icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            color: white;
            text-decoration: none;
        }

        .icon-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .icon-blue {
            background: linear-gradient(135deg, #6366f1, #4338ca);
        }

        .icon-orange {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .icon-red {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }

        /* ========== STATUS BADGES ========== */
        .badge-modern {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.75rem;
        }

        .bg-success-soft {
            background-color: #dcfce7;
            color: #166534;
        }

        .bg-warning-soft {
            background-color: #fef3c7;
            color: #92400e;
        }

        .bg-info-soft {
            background-color: #e0f2fe;
            color: #075985;
        }

        /* ========== MODAL STYLING ========== */
        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
        }

        .btn-add-history {
            border-radius: 10px;
            font-weight: 700;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s;
        }

        .btn-add-history:hover {
            transform: scale(1.05);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Riwayat Detail Kalibrasi</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('histories.index') }}">History List</a></li>
                        <li class="breadcrumb-item active">{{ $tool->nama_alat }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('histories.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bx bx-chevron-left"></i> Kembali
            </a>
        </div>

        <div class="card info-card mb-4">
            <div class="info-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white p-2 rounded-3">
                        <i class="bx bx-wrench text-dark fs-3"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-0 fw-bold">{{ $tool->nama_alat }}</h5>
                        <span class="text-light small">ID: {{ $tool->no_seri ?? 'N/A' }}</span>
                    </div>
                </div>
                @if ($tool->qr_code_path)
                    <div class="bg-white p-1 rounded-3">
                        <img src="{{ asset('storage/' . $tool->qr_code_path) }}" width="60" height="60"
                            class="rounded">
                    </div>
                @endif
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Merek / Brand</span>
                    <span class="info-value">{{ $tool->merek ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nomor Seri</span>
                    <span class="info-value">{{ $tool->no_seri ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Kapasitas Alat</span>
                    <span class="info-value">{{ $tool->kapasitas ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Lokasi Penyimpanan</span>
                    <span class="info-value">{{ $tool->lokasi ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-0 p-4">
                <h5 class="mb-0 fw-bold"><i class="bx bx-history me-2 text-primary"></i>Log Kalibrasi</h5>
                <a href="{{ route('histories.create', ['tool_id' => $tool->id, 'redirect_to' => 'show']) }}"
                    class="btn btn-primary btn-add-history shadow">
                    <i class="bx bx-plus-circle me-1"></i> Tambah History
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Tanggal Kalibrasi</th>
                                <th>No Sertifikat</th>
                                <th>Lembaga / Vendor</th>
                                <th>Status Akhir</th>
                                <th>Jadwal Ulang</th>
                                <th class="text-center pe-4">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tool->histories->sortByDesc('tgl_kalibrasi') as $h)
                                <tr>
                                    <td class="ps-4 fw-bold">
                                        {{ $h->tgl_kalibrasi ? \Carbon\Carbon::parse($h->tgl_kalibrasi)->format('d M Y') : '-' }}
                                    </td>
                                    <td><code class="text-primary fw-bold">{{ $h->no_sertifikat ?? '-' }}</code></td>
                                    <td>{{ $h->lembaga_kalibrasi ?? '-' }}</td>
                                    <td>
                                        @if ($h->status_kalibrasi === 'OK')
                                            <span class="badge-modern bg-success-soft">Verified OK</span>
                                        @elseif ($h->status_kalibrasi === 'PROSES')
                                            <span class="badge-modern bg-warning-soft text-dark">In Progress</span>
                                        @elseif ($h->status_kalibrasi === 'DUE SOON')
                                            <span class="badge-modern bg-info-soft">Due Soon</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                    <td class="text-danger fw-bold">
                                        {{ $h->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($h->tgl_kalibrasi_ulang)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            @if ($h->file_sertifikat)
                                                <button type="button" class="icon-btn icon-blue"
                                                    onclick="openPDFModal('{{ asset('storage/' . $h->file_sertifikat) }}')"
                                                    title="Lihat Sertifikat">
                                                    <i class="bx bxs-file-pdf"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route('histories.edit', $h->id) }}" class="icon-btn icon-orange"
                                                title="Edit Data">
                                                <i class="bx bxs-edit"></i>
                                            </a>

                                            <form action="{{ route('histories.destroy', $h->id) }}" method="POST"
                                                class="delete-form m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="icon-btn icon-red" title="Hapus Data">
                                                    <i class="bx bxs-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bx bx-info-circle fs-1 d-block mb-2"></i>
                                            Belum ada riwayat kalibrasi untuk alat ini.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bx bxs-file-pdf text-danger me-2"></i>Pratinjau Sertifikat
                        Kalibrasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="pdfFrame" src="" frameborder="0"
                        style="width:100%; height:85vh; display: block;"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Konfirmasi Delete dengan SweetAlert yang lebih cantik
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data history kalibrasi ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    borderRadius: '15px'
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

        // Reset iframe saat modal ditutup agar tidak membebani memori
        const pdfModalEl = document.getElementById('pdfModal');
        pdfModalEl.addEventListener('hidden.bs.modal', function() {
            document.getElementById('pdfFrame').src = '';
        });
    </script>
@endpush
