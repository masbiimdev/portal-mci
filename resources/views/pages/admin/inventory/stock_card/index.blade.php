@extends('layouts.admin')
@section('title', 'Stock Card | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        .filter-card {
            background-color: #f8f9fa;
            border: 1px dashed #d9dee3;
            border-radius: 0.5rem;
        }

        .table> :not(caption)>*>* {
            padding: 1rem 1.25rem;
            vertical-align: middle;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
        }

        .empty-state i {
            font-size: 5rem;
            color: #d9dee3;
            margin-bottom: 1rem;
        }

        .btn-primary {
            color: #ffffff !important;
        }

        /* Styling khusus input picker agar terlihat bisa diklik */
        .input-picker {
            cursor: pointer;
            background-color: #ffffff !important;
        }

        .input-picker:hover {
            border-color: #696cff;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bx bx-list-ul fs-3 align-middle text-primary me-2"></i>Kartu Stok (Stock Card)
                </h4>
                <p class="text-muted mb-0">Pantau riwayat pergerakan masuk dan keluar barang/material.</p>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4 filter-card">
            <div class="card-body">
                <form method="GET" action="{{ route('stock-card.index') }}" id="stockCardForm">
                    <div class="row">
                        <div class="col-md-8 col-lg-6">
                            <label class="form-label fw-semibold text-muted small">Pilih Material</label>

                            @php
                                $selectedName = '';
                                if ($selectedMaterial) {
                                    $currentMat = $materials->firstWhere('id', $selectedMaterial);
                                    if ($currentMat) {
                                        $valveNames = implode(
                                            ', ',
                                            $currentMat->valves->pluck('valve_name')->toArray(),
                                        );
                                        $selectedName =
                                            $currentMat->material_code . ' — ' . ($valveNames ?: 'Tanpa Valve');
                                    }
                                }
                            @endphp

                            <div class="input-group input-group-merge shadow-sm">
                                <span class="input-group-text"><i class="bx bx-box"></i></span>
                                <input type="text" id="material_display" class="form-control input-picker"
                                    placeholder="Klik untuk mencari material..." readonly value="{{ $selectedName }}"
                                    data-bs-toggle="modal" data-bs-target="#modalMaterialPicker">

                                <input type="hidden" name="material_id" id="material_id" value="{{ $selectedMaterial }}">

                                <button class="btn btn-primary text-white px-4" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modalMaterialPicker">
                                    <i class="bx bx-search-alt me-1"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            @if ($selectedMaterial)
                <div class="card-header bg-white border-bottom pt-4 pb-3">
                    <h6 class="mb-0 text-primary fw-bold"><i class="bx bx-history me-2"></i>Riwayat Transaksi: <span
                            class="text-dark">{{ $selectedName }}</span></h6>
                </div>

                <div class="card-datatable table-responsive">
                    <table id="stockCardTable" class="table table-hover border-top w-100">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal & Waktu</th>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th class="text-end">Masuk (IN)</th>
                                <th class="text-end">Keluar (OUT)</th>
                                <th class="text-end">Stock Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stockCard as $row)
                                <tr>
                                    <td>
                                        <span
                                            class="d-block fw-semibold">{{ $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->format('d M Y') : '-' }}</span>
                                        <small
                                            class="text-muted">{{ $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->format('H:i') : '' }}
                                            WIB</small>
                                    </td>
                                    <td>
                                        {{-- PERBAIKAN: Menggunakan warna solid dan text-white agar teks 100% terbaca --}}
                                        @if ($row->jenis == 'IN')
                                            <span class="badge bg-success text-white px-3 rounded-pill"><i
                                                    class="bx bx-down-arrow-alt me-1"></i> IN</span>
                                        @elseif($row->jenis == 'OUT')
                                            <span class="badge bg-danger text-white px-3 rounded-pill"><i
                                                    class="bx bx-up-arrow-alt me-1"></i> OUT</span>
                                        @else
                                            <span class="badge bg-secondary text-white px-3 rounded-pill"><i
                                                    class="bx bx-minus me-1"></i> AWAL</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->notes)
                                            {{ $row->notes }}
                                        @else
                                            <span class="text-muted fst-italic">Tidak ada keterangan</span>
                                        @endif
                                    </td>
                                    <td class="text-end text-success fw-semibold">
                                        {{ $row->jenis == 'IN' ? '+ ' . number_format($row->qty, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-end text-danger fw-semibold">
                                        {{ $row->jenis == 'OUT' ? '- ' . number_format($row->qty, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-end fw-bold text-dark fs-6">
                                        {{ number_format($row->stock_after, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card-body empty-state">
                    <i class="bx bx-data"></i>
                    <h5 class="fw-bold text-dark">Pilih Material Terlebih Dahulu</h5>
                    <p class="text-muted mb-0">Klik tombol <strong>Cari</strong> di atas untuk membuka daftar
                        material,<br>lalu pilih material untuk melihat riwayat stoknya.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="modalMaterialPicker" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom pb-3">
                    <h5 class="modal-title fw-bold"><i class="bx bx-list-ul me-2 text-primary"></i>Daftar Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="table-responsive">
                        <table id="materialLookupTable" class="table table-hover table-bordered w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Material</th>
                                    <th>Valve</th>
                                    <th>Spare Part</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $m)
                                    @php
                                        $valveNames = implode(', ', $m->valves->pluck('valve_name')->toArray());
                                        $displayName = $m->material_code . ' — ' . ($valveNames ?: 'Tanpa Valve');
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold text-primary">{{ $m->material_code }}</td>
                                        <td>{{ $valveNames ?: '-' }}</td>
                                        <td>{{ $m->sparePart->spare_part_name ?? '-' }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-success text-white btn-pilih-mat"
                                                data-id="{{ $m->id }}" data-name="{{ $displayName }}">
                                                <i class="bx bx-check-circle me-1"></i> Pilih
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {

            // 1. Inisialisasi DataTable untuk Modal Material Picker
            if ($('#materialLookupTable').length) {
                $('#materialLookupTable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                    },
                    columnDefs: [{
                            orderable: false,
                            targets: 3
                        }, // Kolom Aksi tidak di-sort
                        {
                            className: "text-nowrap",
                            targets: "_all"
                        }
                    ]
                });
            }

            // 2. Inisialisasi DataTable untuk Tabel Kartu Stok (Jika material sudah dipilih)
            if ($('#stockCardTable').length) {
                $('#stockCardTable').DataTable({
                    responsive: true,
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "Semua"]
                    ],
                    order: [
                        [0, 'desc']
                    ], // Urut terbaru di atas
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                        emptyTable: "Belum ada transaksi untuk material ini."
                    },
                    columnDefs: [{
                        className: "text-nowrap",
                        targets: "_all"
                    }]
                });
            }

            // 3. Logika UX: Saat tombol "Pilih" di dalam Modal diklik
            $('.btn-pilih-mat').on('click', function() {
                // Ambil data dari atribut HTML tombol
                let matId = $(this).data('id');
                let matName = $(this).data('name');

                // Masukkan data ke input di halaman utama
                $('#material_id').val(matId);
                $('#material_display').val(matName);

                // Tutup modal secara otomatis menggunakan Bootstrap API
                let modalEl = document.getElementById('modalMaterialPicker');
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                modalInstance.hide();

                // Fitur Auto-Submit: Langsung submit form agar kartu stok langsung muncul
                $('#stockCardForm').submit();
            });
        });
    </script>
@endpush
