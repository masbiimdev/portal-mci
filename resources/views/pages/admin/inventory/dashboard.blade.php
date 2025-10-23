@extends('layouts.admin')
@section('title', 'Dashboard Inventory | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header & Action --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">📦 Dashboard Inventory</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('material_in.create') }}" class="btn btn-success">
                    <i class="bi bi-box-arrow-in-down"></i> Material In
                </a>
                <a href="{{ route('material_out.create') }}" class="btn btn-danger">
                    <i class="bi bi-box-arrow-up"></i> Material Out
                </a>
            </div>
        </div>

        {{-- Statistik Utama --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-secondary"><i class="bi bi-stack fs-3"></i></div>
                        <h6 class="mt-2">Total Material</h6>
                        <h3 class="fw-bold text-primary">{{ $totalMaterials }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-secondary"><i class="bi bi-box-seam fs-3"></i></div>
                        <h6 class="mt-2">Total Stok</h6>
                        <h3 class="fw-bold text-success">{{ number_format($totalStock) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-secondary"><i class="bi bi-arrow-down-square fs-3"></i></div>
                        <h6 class="mt-2">Barang Masuk</h6>
                        <h3 class="fw-bold text-info">{{ number_format($totalIn) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-secondary"><i class="bi bi-arrow-up-square fs-3"></i></div>
                        <h6 class="mt-2">Barang Keluar</h6>
                        <h3 class="fw-bold text-danger">{{ number_format($totalOut) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stok Minimum --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning fw-bold d-flex justify-content-between align-items-center">
                <span>⚠️ Stok Di Bawah Minimum</span>
                {{-- <a href="{{ route('materials.index') }}" class="btn btn-sm btn-dark">
                    <i class="bi bi-boxes"></i> Lihat Semua Material
                </a> --}}
            </div>
            <div class="card-body p-0">
                @if ($lowStock->isEmpty())
                    <p class="text-center text-muted py-3 mb-0">Semua stok aman</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-warning">
                                <tr>
                                    <th>Kode</th>
                                    <th>Material</th>
                                    <th>Stok Terbaru</th>
                                    <th>Minimum</th>
                                    <th>Posisi Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStock as $item)
                                    <tr>
                                        <td>{{ $item->material_code }}</td>
                                        <td>
                                            {{ $item->valves->pluck('valve_name')->join(', ') ?: '-' }} |
                                            {{ $item->sparePart->spare_part_name ?? '-' }}
                                        </td>

                                        <td class="fw-bold text-danger">{{ $item->current_stock }}</td>
                                        <td>{{ $item->stock_minimum }}</td>
                                        <td>{{ optional($item->rack)->rack_code ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        {{-- Riwayat Transaksi --}}
        <div class="card shadow-sm">
            {{-- <div class="card-header bg-secondary text-white fw-bold d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history"></i> Riwayat Transaksi Material</span>
                <a href="#" class="btn btn-sm btn-light">Lihat Semua</a>
            </div> --}}
            <div class="card-body p-0">
                @if ($history->isEmpty())
                    <p class="text-center text-muted py-3 mb-0">Belum ada transaksi</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Material</th>
                                    <th>Stok Awal</th>
                                    <th>Jumlah</th>
                                    <th>Stok Akhir</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $item)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($item->date_in)->translatedFormat('d F Y') }}</td>
                                        <td>
                                            @if ($item->jenis === 'in')
                                                <span class="badge bg-success">
                                                    <i class="bi bi-box-arrow-in-down"></i> Barang Masuk
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-box-arrow-up"></i> Barang Keluar
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->material->material_code }} |
                                            @php
                                                $valveNames = $item->material->valves->pluck('valve_name')->toArray();
                                                $valveList = implode(', ', $valveNames);
                                            @endphp
                                            {{ $valveList ?: '-' }} |
                                            {{ $item->material->sparePart->spare_part_name ?? '-' }}
                                        </td>
                                        <td>{{ $item->material->stock_awal ?? '-' }}</td>
                                        <td class="fw-bold {{ $item->jenis === 'in' ? 'text-success' : 'text-danger' }}">
                                            {{ $item->jenis === 'in' ? '+' : '-' }}{{ $item->qty }}
                                        </td>
                                        <td>{{ $item->stock_after ?? '-' }}</td>
                                        <td>{{ $item->notes ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        <br>

        {{-- Grafik --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
                📈 Grafik Barang Masuk & Keluar (Per Bulan)
            </div>
            <div class="card-body">
                <canvas id="inventoryChart" height="120"></canvas>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('inventoryChart').getContext('2d');
        const chartData = @json($monthlyData);

        const labels = chartData.map(item => item.month);
        const dataIn = chartData.map(item => item.in);
        const dataOut = chartData.map(item => item.out);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Barang Masuk',
                        data: dataIn,
                        backgroundColor: 'rgba(75, 192, 75, 0.7)',
                        borderRadius: 4,
                    },
                    {
                        label: 'Barang Keluar',
                        data: dataOut,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush
