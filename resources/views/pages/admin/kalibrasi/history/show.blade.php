@extends('layouts.admin')
@section('title', 'History Kalibrasi Item')

@push('css')
    <style>
        .icon-btn {
            width: 34px;
            height: 34px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.25s ease;
            padding: 0;
        }

        .icon-btn i {
            font-size: 16px;
            color: #4b5563;
            transition: 0.25s ease;
        }

        /* Hover elegan */
        .icon-btn:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .icon-btn:hover i {
            color: #111827;
        }

        /* Tombol delete warna merah halus */
        .icon-btn.delete:hover {
            background: #fee2e2;
            border-color: #fecaca;
        }

        .icon-btn.delete:hover i {
            color: #dc2626;
        }

        .icon-btn {
            width: 40px;
            /* sebelumnya 34px */
            height: 40px;
            /* sedikit lebih besar */
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            /* lebih modern */
            cursor: pointer;
            transition: 0.25s ease;
            padding: 0;
        }

        /* Icon agak lebih besar */
        .icon-btn i {
            font-size: 18px;
            /* sebelumnya 16px */
            color: #4b5563;
            transition: 0.25s ease;
        }

        /* Hover elegan */
        .icon-btn:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.07);
        }

        .icon-btn:hover i {
            color: #1f2937;
        }

        /* Tombol delete warna merah soft */
        .icon-btn.delete:hover {
            background: #fee2e2;
            border-color: #fecaca;
        }

        .icon-btn.delete:hover i {
            color: #dc2626;
        }

        .icon-btn {
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            cursor: pointer;
            border: none;
            transition: 0.25s ease;
            padding: 0;
        }

        /* icon */
        .icon-btn i {
            font-size: 18px;
            color: white;
        }


        /* ===========================
           🎨  WARNA TOMBOL
           =========================== */

        /* PDF - Biru */
        .icon-blue {
            background: #3b82f6;
            /* blue-500 */
        }

        .icon-blue:hover {
            background: #2563eb;
            /* blue-600 */
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        /* Edit - Orange */
        .icon-orange {
            background: #f59e0b;
            /* amber-500 */
        }

        .icon-orange:hover {
            background: #d97706;
            /* amber-600 */
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
        }

        /* Delete - Red */
        .icon-red {
            background: #ef4444;
            /* red-500 */
        }

        .icon-red:hover {
            background: #dc2626;
            /* red-600 */
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        }
    </style>
@endpush
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
                    <p class="mb-1"><strong>Kapasitas:</strong> {{ $tool->kapasitas ?? '-' }}</p>
                    <p class="mb-0"><strong>Lokasi:</strong> {{ $tool->lokasi ?? '-' }}</p>
                </div>

                @if ($tool->qr_code_path)
                    <div class="d-flex flex-column align-items-center">
                        <a href="{{ route('histories.index') }}" class="btn btn-light btn-sm mb-2">
                            <i class="bx bx-left-arrow-alt"></i> Kembali
                        </a>
                        <img src="{{ asset('storage/' . $tool->qr_code_path) }}" width="110" height="110"
                            class="border rounded">
                    </div>
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
                                <th>Kalibrasi Ulang</th>
                                <th style="width: 140px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($tool->histories as $h)
                                <tr>
                                    <td>{{ $h->tgl_kalibrasi ? \Carbon\Carbon::parse($h->tgl_kalibrasi)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>{{ $h->no_sertifikat ?? '-' }}</td>
                                    <td>{{ $h->lembaga_kalibrasi ?? '-' }}</td>
                                    <td>
                                        @if ($h->status_kalibrasi === 'OK')
                                            <span class="badge bg-success">OK</span>
                                        @elseif ($h->status_kalibrasi === 'PROSES')
                                            <span class="badge bg-warning text-dark">Proses</span>
                                        @elseif ($h->status_kalibrasi === 'DUE SOON')
                                            <span class="badge bg-info text-dark">Akan Jatuh Tempo</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif

                                    </td>
                                    <td>{{ $h->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($h->tgl_kalibrasi_ulang)->format('d-m-Y') : '-' }}
                                    </td>

                                    <td class="d-flex gap-2">

                                        @if ($h->file_sertifikat)
                                            <button type="button" class="icon-btn icon-blue"
                                                onclick="openPDFModal('{{ asset('storage/' . $h->file_sertifikat) }}')"
                                                title="Lihat PDF">
                                                <i class="bx bx-file-find"></i>
                                            </button>
                                        @endif

                                        <a href="{{ route('histories.edit', $h->id) }}" class="icon-btn icon-orange"
                                            title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <form action="{{ route('histories.destroy', $h->id) }}" method="POST"
                                            class="delete-form m-0 p-0">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="icon-btn icon-red" title="Hapus">
                                                <i class="bx bx-trash"></i>
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
        pdfModalEl.addEventListener('hidden.bs.modal', function() {
            document.getElementById('pdfFrame').src = '';
        });
    </script>
@endpush
