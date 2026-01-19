@extends('layouts.admin')
@section('title', 'Dashboard | Main')

@push('css')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root{
            --bg-card: #ffffff;
            --muted: #6b7280;
            --glass: rgba(255,255,255,0.85);
            --accent: #5166ff;
            --success: #22c55e;
            --danger: #ef4444;
            --radius: 12px;
        }

        /* Layout */
        .container-xxl { padding-top: 1.25rem; padding-bottom: 1.25rem; }

        /* Header */
        .dashboard-header {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:1rem;
            margin-bottom:1.25rem;
        }
        .greeting {
            display:flex;
            flex-direction:column;
            gap:.15rem;
        }
        .greeting h4 { margin:0; font-size:1.25rem; }
        .greeting .sub { color:var(--muted); font-size:.95rem; }

        /* Quick access */
        .quick-card {
            border-radius: var(--radius);
            transition: transform .18s ease, box-shadow .18s ease;
            background: linear-gradient(180deg, var(--bg-card), #fbfbff);
            min-height:110px;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .quick-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(16,24,40,0.06);
        }
        .quick-card .icon {
            width:56px; height:56px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.45rem;
            background: linear-gradient(135deg, rgba(81,102,255,0.08), rgba(81,102,255,0.02));
            color: var(--accent);
        }
        .quick-card .title { margin-top:.6rem; font-weight:700; }
        .quick-card .meta { color:var(--muted); font-size:.85rem; }

        /* KPI tiles */
        .kpi {
            border-radius: 12px;
            padding:1rem;
            background: linear-gradient(180deg, var(--bg-card), #fff);
            box-shadow: 0 8px 20px rgba(8,15,30,0.03);
        }
        .kpi .kpi-head { display:flex; align-items:center; gap:12px; }
        .kpi .kpi-icon { width:48px; height:48px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; }
        .kpi .kpi-value { font-weight:700; font-size:1.25rem; }
        .kpi .kpi-sub { color:var(--muted); font-size:.88rem; }

        /* Statistics badges */
        .stat-pill {
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:.28rem .6rem;
            border-radius:999px;
            font-weight:600;
            font-size:.82rem;
            background:#f1f5f9;
            color:#0f172a;
        }

        /* History / cards */
        .history-day {
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 8px 30px rgba(8,15,30,0.04);
            overflow:hidden;
            margin-bottom: 0.9rem;
        }
        .history-day .hd-head {
            padding:.9rem 1rem;
            display:flex;
            align-items:center;
            justify-content:space-between;
            border-bottom: 1px solid rgba(15,23,42,0.04);
        }
        .history-table thead th { position: sticky; top: 0; backdrop-filter: blur(4px); background: linear-gradient(180deg,#fff,#fbfbff); z-index:2; }

        /* Activity chart card */
        .card-chart {
            border-radius: 12px;
            background: linear-gradient(180deg, #fff, #fbfdff);
            box-shadow: 0 10px 30px rgba(8,15,30,0.05);
            padding:1rem;
        }
        .chart-actions { display:flex; gap:.5rem; align-items:center; }

        /* responsive tweaks */
        @media (max-width: 767px) {
            .greeting h4 { font-size:1.05rem; }
            .quick-card { min-height:94px; }
            .kpi .kpi-value { font-size:1.05rem; }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="dashboard-header">
            <div class="greeting">
                <h4 class="fw-bold mb-0">🏠 Dashboard</h4>
                <div class="sub small-muted">
                    Selamat datang{{ Auth::user() ? ', ' . Auth::user()->name : '' }} — {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <div class="me-2 text-end">
                    <div class="small-muted">Server</div>
                    <div class="fw-semibold">UP • <small class="text-muted">{{ \Illuminate\Support\Str::limit(gethostname() ?? '–', 18) }}</small></div>
                </div>

                {{-- <a href="{{ route('profile') }}" class="btn btn-outline-secondary btn-sm">Profil Saya</a> --}}
            </div>
        </div>

        <!-- QUICK ACCESS -->
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('announcements.index') }}" class="text-decoration-none">
                    <div class="card quick-card text-center h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="icon bg-warning text-white"><i class="bx bx-news"></i></div>
                            <div class="title mt-2">Pengumuman</div>
                            <div class="meta">{{ $totalAnnon ?? 0 }} item</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('activities.index') }}" class="text-decoration-none">
                    <div class="card quick-card text-center h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="icon bg-primary text-white"><i class="bx bx-calendar"></i></div>
                            <div class="title mt-2">Schedule</div>
                            <div class="meta">{{ $totalSchedules ?? 0 }} jadwal</div>
                        </div>
                    </div>
                </a>
            </div>
{{-- 
            <div class="col-6 col-md-3">
                <a href="{{ route('jobcards.index') }}" class="text-decoration-none">
                    <div class="card quick-card text-center h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="icon bg-warning text-white"><i class="bx bx-cog"></i></div>
                            <div class="title mt-2">Production</div>
                            <div class="meta">{{ $totalJobcard ?? 0 }} jobcard</div>
                        </div>
                    </div>
                </a>
            </div> --}}

            <div class="col-6 col-md-3">
                <a href="{{ route('inventory.index') }}" class="text-decoration-none">
                    <div class="card quick-card text-center h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="icon bg-danger text-white"><i class="bx bx-box"></i></div>
                            <div class="title mt-2">Inventory</div>
                            <div class="meta">{{ $totalMaterial ?? 0 }} material</div>
                        </div>
                    </div>
                </a>
            </div>

            @if (Auth::user()->role === 'SUP')
                <div class="col-6 col-md-3">
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="card quick-card text-center h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <div class="icon bg-success text-white"><i class="bx bx-user"></i></div>
                                <div class="title mt-2">Users</div>
                                <div class="meta">{{ $totalUsers ?? 0 }} aktif</div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>

        <!-- KPIs -->
        <div class="row mt-4 g-3">
            <div class="col-6 col-md-3">
                <div class="kpi p-3 h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon bg-light text-primary"><i class="bx bx-archive"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalMaterial ?? '0' }}</div>
                            <div class="kpi-sub">Total Material</div>
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div class="stat-pill"><i class="bx bx-up-arrow"></i> Active</div>
                        <canvas id="sparkMaterials" width="90" height="30"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="kpi p-3 h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon bg-light text-success"><i class="bx bx-layer"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalUsers ?? '0' }}</div>
                            <div class="kpi-sub">User Aktif</div>
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div class="stat-pill"><i class="bx bx-check-double"></i> Verified</div>
                        <canvas id="sparkUsers" width="90" height="30"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="kpi p-3 h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon bg-light text-warning"><i class="bx bx-calendar-event"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalSchedules ?? '0' }}</div>
                            <div class="kpi-sub">Total Jadwal</div>
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div class="stat-pill"><i class="bx bx-time-five"></i> Upcoming</div>
                        <canvas id="sparkSched" width="90" height="30"></canvas>
                    </div>
                </div>
            </div>
{{-- 
            <div class="col-6 col-md-3">
                <div class="kpi p-3 h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon bg-light text-danger"><i class="bx bx-package"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalJobcard ?? '0' }}</div>
                            <div class="kpi-sub">Total Jobcard</div>
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div class="stat-pill"><i class="bx bx-loader"></i> In Progress</div>
                        <canvas id="sparkJobs" width="90" height="30"></canvas>
                    </div>
                </div>
            </div> --}}
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sparklines (tiny)
            function spark(elId, data = [], color = 'rgba(81,102,255,0.9)') {
                const el = document.getElementById(elId);
                if (!el) return;
                new Chart(el.getContext('2d'), {
                    type: 'line',
                    data: { labels: data.map((_,i) => i+1), datasets: [{ data, borderColor: color, backgroundColor: 'transparent', tension: 0.35, borderWidth: 1.2, pointRadius: 0 }] },
                    options: { responsive: false, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: { enabled: false } }, scales: { x: { display: false }, y: { display: false } } }
                });
            }

            // Provide example spark data if none passed from controller
            const exampleSparkA = {!! json_encode($sparkA ?? [3,5,4,6,5,7,6]) !!};
            const exampleSparkB = {!! json_encode($sparkB ?? [2,4,3,5,4,3,4]) !!};
            spark('sparkMaterials', exampleSparkA, 'rgba(81,102,255,0.9)');
            spark('sparkUsers', exampleSparkB, 'rgba(16,185,129,0.9)');
            spark('sparkSched', exampleSparkA, 'rgba(250,184,60,0.9)');
            spark('sparkJobs', exampleSparkB, 'rgba(239,68,68,0.9)');

            // Activity chart (7 days)
            (function () {
                const ctx = document.getElementById('activityChart');
                if (!ctx) return;

                const labels = {!! json_encode($chartLabels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']) !!};
                const dataIn = {!! json_encode($chartMasuk ?? [5,9,7,10,8,6,4]) !!};
                const dataOut = {!! json_encode($chartKeluar ?? [3,5,6,8,5,7,9]) !!};
                const netData = dataIn.map((v,i) => (v || 0) - (dataOut[i] || 0));

                const ctx2d = ctx.getContext('2d');

                const gradIn = ctx2d.createLinearGradient(0,0,0,220);
                gradIn.addColorStop(0,'rgba(34,197,94,0.16)');
                gradIn.addColorStop(1,'rgba(34,197,94,0.02)');

                const gradOut = ctx2d.createLinearGradient(0,0,0,220);
                gradOut.addColorStop(0,'rgba(239,68,68,0.16)');
                gradOut.addColorStop(1,'rgba(239,68,68,0.02)');

                const gradNet = ctx2d.createLinearGradient(0,0,0,220);
                gradNet.addColorStop(0,'rgba(81,102,255,0.14)');
                gradNet.addColorStop(1,'rgba(81,102,255,0.02)');

                const chart = new Chart(ctx2d, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [
                            { type:'bar', label: 'Masuk', data: dataIn, backgroundColor: 'rgba(34,197,94,0.9)', borderRadius:8, maxBarThickness:28 },
                            { type:'bar', label: 'Keluar', data: dataOut, backgroundColor: 'rgba(239,68,68,0.9)', borderRadius:8, maxBarThickness:28 },
                            { type:'line', label: 'Net', data: netData, borderColor: 'rgba(81,102,255,0.95)', backgroundColor: gradNet, fill:true, tension:0.35, pointRadius:3, borderWidth:2 }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            x: { grid: { display: false } },
                            y: { beginAtZero: true, grid: { color: 'rgba(15,23,42,0.06)' } }
                        },
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: {
                                callbacks: {
                                    label: function(ctx) {
                                        const label = ctx.dataset.label || '';
                                        return label + ': ' + new Intl.NumberFormat().format(ctx.parsed.y ?? ctx.parsed);
                                    }
                                }
                            }
                        }
                    }
                });

                // download
                document.getElementById('downloadActivity')?.addEventListener('click', function() {
                    const a = document.createElement('a');
                    a.href = ctx.toDataURL('image/png', 1);
                    a.download = 'activity-7days.png';
                    a.click();
                });
            })();

            // Simple client-side history search
            const searchInput = document.getElementById('historySearch');
            const historyList = document.getElementById('historyList');

            function applySearch() {
                const q = (searchInput?.value || '').trim().toLowerCase();
                if (!historyList) return;
                const tables = historyList.querySelectorAll('table.history-table');
                tables.forEach(tbl => {
                    const rows = Array.from(tbl.tBodies[0].rows);
                    let any = false;
                    rows.forEach(r => {
                        const txt = r.innerText.toLowerCase();
                        const ok = q === '' ? true : txt.indexOf(q) !== -1;
                        r.style.display = ok ? '' : 'none';
                        if (ok) any = true;
                    });
                    // hide parent date block if no visible rows
                    const dayBlock = tbl.closest('.mb-3');
                    if (dayBlock) dayBlock.style.display = any ? '' : 'none';
                });
            }

            searchInput?.addEventListener('input', applySearch);
        });
    </script>
@endpush