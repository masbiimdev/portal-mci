@extends('layouts.admin')
@section('title', 'Dashboard | Main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">🏠 Dashboard</h4>

        <!-- QUICK ACCESS -->
        <div class="row g-3">

            <div class="col-6 col-md-3">
                <a href="{{ route('announcements.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 text-center h-100 quick-card">
                        <div class="card-body">
                            <i class="bx bx-news text-warning fs-1"></i>
                            <h6 class="fw-bold mt-2 mb-0">Pengumuman</h6>
                            <small class="text-muted">Data Pengguna</small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Schedule -->
            <div class="col-6 col-md-3">
                <a href="{{ route('activities.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 text-center h-100 quick-card">
                        <div class="card-body">
                            <i class="bx bx-calendar text-primary fs-1"></i>
                            <h6 class="fw-bold mt-2 mb-0">Schedule</h6>
                            <small class="text-muted">Jadwal Produksi</small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Production -->
            <div class="col-6 col-md-3">
                <a href="{{ route('jobcards.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 text-center h-100 quick-card">
                        <div class="card-body">
                            <i class="bx bx-cog text-warning fs-1"></i>
                            <h6 class="fw-bold mt-2 mb-0">Production</h6>
                            <small class="text-muted">Proses Produksi</small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Inventory -->
            <div class="col-6 col-md-3">
                <a href="{{ route('inventory.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 text-center h-100 quick-card">
                        <div class="card-body">
                            <i class="bx bx-box text-danger fs-1"></i>
                            <h6 class="fw-bold mt-2 mb-0">Inventory</h6>
                            <small class="text-muted">Manajemen Stok</small>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Users -->
            <div class="col-6 col-md-3">
                @if (Auth::user()->role === 'SUP')
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="card shadow-sm border-0 text-center h-100 quick-card">
                            <div class="card-body">
                                <i class="bx bx-user text-success fs-1"></i>
                                <h6 class="fw-bold mt-2 mb-0">Users</h6>
                                <small class="text-muted">Data Pengguna</small>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </div>

        <!-- INFO STATISTICS -->
        <div class="row mt-4 g-3">
            <div class="col-6 col-md-3">
                <div class="card border-start border-success border-3 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">User Aktif</h6>
                        <h4 class="fw-bold mb-0">{{ $totalUsers ?? '0' }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-start border-primary border-3 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Total Jadwal</h6>
                        <h4 class="fw-bold mb-0">{{ $totalSchedules ?? '0' }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-start border-warning border-3 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Total Jobcard</h6>
                        <h4 class="fw-bold mb-0">{{ $totalJobcard ?? '0' }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-start border-danger border-3 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Total Material</h6>
                        <h4 class="fw-bold mb-0">{{ $totalMaterial ?? '0' }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-start border-success border-3 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Total Pengumuman</h6>
                        <h4 class="fw-bold mb-0">{{ $totalAnnon ?? '0' }}</h4>
                    </div>
                </div>
            </div>
        </div>
        {{-- <!-- UPCOMING SCHEDULE -->
        <div class="card mt-4 shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">📅 Jadwal Terdekat</h6>
                <ul class="list-unstyled mb-0">
                    @forelse($upcomingSchedules ?? [] as $schedule)
                        <li class="mb-3 border-bottom pb-2">
                            <strong>{{ $schedule->kegiatan }}</strong><br>
                            <small class="text-muted">{{ $schedule->start_date }}</small>
                        </li>
                    @empty
                        <li class="text-muted">Tidak ada jadwal terdekat</li>
                    @endforelse
                </ul>
            </div>
        </div> --}}

        <!-- CHART -->
        {{-- <div class="bg-white border rounded-xl p-4 mt-4 shadow-sm">
            <h6 class="fw-bold text-primary mb-3">📈 Aktivitas 7 Hari Terakhir</h6>
            <canvas id="activityChart" height="120"></canvas>
        </div> --}}
    </div>

    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('activityChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
                    datasets: [{
                        label: 'Barang Masuk',
                        data: {!! json_encode($chartMasuk ?? [5, 9, 7, 10, 8, 6, 4]) !!},
                        borderColor: 'rgba(34,197,94,1)',
                        backgroundColor: 'rgba(34,197,94,0.2)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    }, {
                        label: 'Barang Keluar',
                        data: {!! json_encode($chartKeluar ?? [3, 5, 6, 8, 5, 7, 9]) !!},
                        borderColor: 'rgba(239,68,68,1)',
                        backgroundColor: 'rgba(239,68,68,0.2)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

    @push('css')
        <style>
            .quick-card {
                transition: all 0.2s ease-in-out;
            }

            .quick-card:hover {
                transform: translateY(-6px) scale(1.02);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            }

            .quick-card i {
                display: block;
            }

            .card h6 {
                font-size: 0.85rem;
            }
        </style>
    @endpush
@endsection
