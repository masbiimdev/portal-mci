@extends('layouts.admin')
@section('title', 'Log Material Keluar')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --brand: #2563eb;
            --surface: #ffffff;
            --bg-body: #f4f7fb;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            --border-dark: #cbd5e1;

            --danger-main: #dc2626;
            --danger-hover: #b91c1c;
            --danger-soft: #fee2e2;

            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.04);
            --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
        }

        .container-p-y {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }

        /* ============== PAGE HEADER ============== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .page-title h4 {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 0.25rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .page-title p {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
        }

        /* ============== BUTTONS ============== */
        .btn-add {
            background: linear-gradient(135deg, var(--danger-main), var(--danger-hover));
            color: white;
            border: none;
            padding: 0.6rem 1.25rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px rgba(220, 38, 38, 0.2);
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(220, 38, 38, 0.3);
            color: white;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--border-light);
            background: var(--surface);
            color: var(--text-muted);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-action.edit:hover {
            background: #fef3c7;
            color: #d97706;
            border-color: #fde68a;
        }

        .btn-action.delete:hover {
            background: var(--danger-soft);
            color: var(--danger-main);
            border-color: #fecaca;
        }

        /* ============== ALERTS ============== */
        .custom-alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--shadow-sm);
        }

        .custom-alert.success {
            background: #dcfce7;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .custom-alert.danger {
            background: var(--danger-soft);
            color: #991b1b;
            border-left: 4px solid var(--danger-main);
        }

        /* ============== MAIN CARD & TABLE ============== */
        .main-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            border-collapse: collapse;
        }

        .table thead th {
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-dark);
            border-top: none;
        }

        .table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            font-size: 0.9rem;
            color: var(--text-main);
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }

        .table tbody tr:hover td {
            background-color: #fcfcfd;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Data Formatting */
        .mono-text {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-qty {
            background: var(--danger-soft);
            color: var(--danger-main);
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 800;
            font-size: 0.85rem;
            display: inline-block;
        }

        .badge-stock {
            background: #f1f5f9;
            color: var(--text-main);
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 0.85rem;
            border: 1px solid var(--border-light);
        }

        /* Empty State */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: #f8fafc;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 2.5rem;
            color: var(--border-dark);
            margin-bottom: 1.5rem;
        }

        /* Pagination Wrapper styling for clean UI */
        .pagination-wrapper {
            background: #ffffff;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: flex-end;
        }

        .pagination-wrapper nav {
            margin-bottom: 0;
        }

        .pagination-wrapper .pagination {
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-add {
                width: 100%;
                justify-content: center;
            }

            .table-responsive {
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .pagination-wrapper {
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header Section --}}
        <div class="page-header">
            <div class="page-title">
                <h4><i class="bi bi-box-arrow-up text-danger me-2"></i> Log Material Keluar</h4>
                <p>Riwayat seluruh transaksi pengeluaran (pemakaian) material dan spare part.</p>
            </div>
            <a href="{{ route('material_out.create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Pengeluaran
            </a>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="custom-alert success mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
        @elseif(session('error'))
            <div class="custom-alert danger mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        {{-- Main Table Card --}}
        <div class="main-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="20%">Material / Spare Part</th>
                            <th width="10%" class="text-center">Qty Keluar</th>
                            <th width="15%">Tgl Transaksi</th>
                            <th width="12%" class="text-center">Sisa Stok</th>
                            <th width="15%">User Input</th>
                            <th width="15%">Catatan / Ref</th>
                            <th width="8%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materialOuts as $index => $m)
                            <tr>
                                <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>

                                <td>
                                    <div class="fw-bold text-dark">
                                        {{ $m->material->sparePart->spare_part_name ?? ($m->material->material_code ?? '-') }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.75rem; margin-top: 2px;">
                                        SN/Batch: <span class="mono-text">{{ $m->material->heat_lot_no ?? '-' }}</span>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="badge-qty" title="Dikeluarkan">
                                        -{{ number_format($m->qty_out) }}
                                    </span>
                                </td>

                                <td class="mono-text text-muted">
                                    @php
                                        // Menggunakan operator fallback standar (Aman dari null error)
                                        $date = $m->date_out ? \Carbon\Carbon::parse($m->date_out) : null;
                                    @endphp
                                    {{ $date ? $date->translatedFormat('d M Y') : '-' }}
                                    @if ($date)
                                        <div style="font-size: 0.7rem; font-weight: 500;">{{ $date->format('H:i') }}</div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="badge-stock" title="Stok tersisa setelah transaksi">
                                        {{ number_format($m->stock_after ?? 0) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div
                                            style="width: 24px; height: 24px; border-radius: 50%; background: var(--border-light); display: grid; place-items: center; font-size: 0.7rem; font-weight: 800; color: var(--text-muted);">
                                            {{ strtoupper(substr($m->user->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <span class="fw-semibold"
                                            style="font-size: 0.85rem;">{{ $m->user->name ?? 'System' }}</span>
                                    </div>
                                </td>

                                <td>
                                    <span class="text-muted" style="font-size: 0.85rem; font-style: italic;">
                                        {{ $m->notes ?: 'Tidak ada catatan' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- <a href="{{ route('material_out.edit', $m->id) }}" class="btn-action edit"
                                            title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> --}}

                                        <form action="{{ route('material_out.destroy', $m->id) }}" method="POST"
                                            class="m-0 p-0 d-inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action delete" title="Hapus Data"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data log keluar ini? Perubahan stok mungkin perlu disesuaikan kembali secara manual.')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="bi bi-inbox"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">Belum Ada Transaksi Keluar</h5>
                                        <p class="text-muted mb-4">Gunakan fitur input harian untuk mulai mencatat
                                            pengeluaran material dan spare part.</p>
                                        <a href="{{ route('material_out.create') }}" class="btn-add">
                                            <i class="bi bi-arrow-right"></i> Mulai Catat Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Menggunakan bootstrap-4 sebagai fallback teraman untuk menghindari error view not found --}}
            @if (method_exists($materialOuts, 'links') && $materialOuts->hasPages())
                <div class="border-top pagination-wrapper">
                    {{ $materialOuts->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
