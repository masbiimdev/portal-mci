@extends('layouts.home')

@section('title', 'MCI | Portal Kalibrasi')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #e0f2fe;
            --surface: #ffffff;
            --bg-color: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        /* ============== SUMMARY CARDS ============== */
        .summary-card {
            background: var(--surface);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            border-radius: 4px 0 0 4px;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: transparent;
        }

        .card-total::before {
            background: var(--primary);
        }

        .card-ok::before {
            background: #10b981;
        }

        .card-proses::before {
            background: #f59e0b;
        }

        .card-due::before {
            background: #ef4444;
        }

        .summary-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .summary-value {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.2;
        }

        .summary-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        /* ============== CONTROLS ============== */
        .controls-wrapper {
            background: var(--surface);
            padding: 1rem 1.25rem;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: space-between;
            align-items: center;
        }

        .input-styled {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            color: var(--text-main);
            background: var(--bg-color);
            transition: all 0.2s;
            outline: none;
        }

        .input-styled:focus {
            background: var(--surface);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--surface);
            border: 1px solid var(--border-color);
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background: var(--bg-color);
            border-color: #cbd5e1;
        }

        /* ============== TABLE STYLES ============== */
        .table-container {
            background: var(--surface);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-header-wrapper {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafafa;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table.modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 1000px;
        }

        table.modern-table th {
            background: var(--surface);
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        table.modern-table td {
            padding: 1rem 1.5rem;
            font-size: 0.9rem;
            color: var(--text-main);
            border-bottom: 1px solid var(--bg-color);
            vertical-align: middle;
        }

        table.modern-table tbody tr {
            transition: background 0.2s;
        }

        table.modern-table tbody tr:hover {
            background: var(--primary-light);
        }

        /* Badges */
        .badge-status {
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-ok {
            background: #dcfce7;
            color: #059669;
        }

        .badge-proses {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-due {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-unknown {
            background: #f1f5f9;
            color: #475569;
        }

        /* Button Detail */
        .btn-detail {
            background: var(--bg-color);
            color: var(--primary);
            border: 1px solid transparent;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-detail:hover {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 6px rgba(14, 165, 233, 0.2);
        }

        /* ============== PAGINATION ============== */
        .pagination-wrapper {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--surface);
        }

        .pagination {
            display: flex;
            gap: 0.25rem;
        }

        .pagination button {
            min-width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: var(--surface);
            color: var(--text-main);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination button:hover:not(:disabled) {
            background: var(--bg-color);
            border-color: #cbd5e1;
        }

        .pagination button.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: var(--bg-color);
        }

        /* ============== MODAL ============== */
        .modal-backdrop {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
        }

        .modal-card {
            max-height: 85vh;
            overflow-y: auto;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: modalPop 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalPop {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        @media(min-width: 640px) {
            .detail-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .detail-item {
            background: var(--bg-color);
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-1">Portal Kalibrasi</h1>
                <p class="text-slate-500 text-sm">Dashboard pemantauan status dan jadwal kalibrasi instrumen secara
                    real-time.</p>
            </div>

            <div
                class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl text-sm flex gap-3 items-start max-w-md shadow-sm">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-amber-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <strong class="font-semibold block mb-0.5">Informasi Sistem</strong>
                    Sistem aktif sejak Oktober 2025. Data riwayat sebelum periode ini mungkin tidak ter-record sepenuhnya.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            @php
                $statusOk = $statusOk ?? 0;
                $statusProses = $statusProses ?? 0;
                $dueSoon = $dueSoon ?? 0;
                $totalTools = $totalTools ?? 0;
            @endphp

            <div class="summary-card card-total">
                <div class="summary-title">Total Instrumen</div>
                <div class="summary-value">{{ number_format($totalTools) }}</div>
                <div class="summary-desc">Item terdaftar dalam sistem</div>
            </div>

            <div class="summary-card card-ok">
                <div class="summary-title">Status OK</div>
                <div class="summary-value text-emerald-600">{{ number_format($statusOk) }}</div>
                <div class="summary-desc">Instrumen siap digunakan</div>
            </div>

            <div class="summary-card card-proses">
                <div class="summary-title">Proses Kalibrasi</div>
                <div class="summary-value text-amber-500">{{ number_format($statusProses) }}</div>
                <div class="summary-desc">Sedang dalam pengerjaan</div>
            </div>

            <div class="summary-card card-due">
                <div class="summary-title">Due &lt; 15 Hari</div>
                <div class="summary-value text-red-500">{{ number_format($dueSoon) }}</div>
                <div class="summary-desc">Mendekati batas kalibrasi</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h2 class="text-base font-bold text-slate-800 mb-4">Distribusi Status</h2>
                <div class="h-48 relative">
                    <canvas id="statusPie"></canvas>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h2 class="text-base font-bold text-slate-800 mb-4">Tren Penjadwalan Kalibrasi</h2>
                <div class="h-48 relative">
                    <canvas id="trendLine"></canvas>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="controls-wrapper">
                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-72">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input id="searchInput" type="search" placeholder="Cari nama, no seri..."
                            class="input-styled w-full pl-9" />
                    </div>
                    <select id="statusFilter" class="input-styled w-full sm:w-auto">
                        <option value="">Semua Status</option>
                        <option value="OK">OK</option>
                        <option value="PROSES">Proses</option>
                        <option value="DUE SOON">Due Soon / Jatuh Tempo</option>
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <select id="perPage" class="input-styled py-1.5" aria-label="Items per page">
                        <option value="10">10 Baris</option>
                        <option value="25">25 Baris</option>
                        <option value="50">50 Baris</option>
                    </select>
                    <button id="refreshBtn" class="btn-action" title="Refresh Data">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="table-wrapper">
                <table id="toolsTable" class="modern-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Instrumen</th>
                            <th width="15%">No. Seri / Merk</th>
                            <th width="15%">Status</th>
                            <th width="15%">Tgl Kalibrasi</th>
                            <th width="15%">Tgl Ulang</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="toolsTbody">
                        @php
                            $toolsData = $tools
                                ->map(function ($t, $i) {
                                    $history = optional($t->latestHistory);
                                    return [
                                        'id' => $t->id,
                                        'nama' => $t->nama_alat ?? '',
                                        'merek' => $t->merek ?? '',
                                        'no_seri' => $t->no_seri ?? '',
                                        'status' => $history->status_kalibrasi ?? '-',
                                        'tgl_kalibrasi' => $history->tgl_kalibrasi
                                            ? $history->tgl_kalibrasi->format('d/m/Y')
                                            : null,
                                        'tgl_kalibrasi_ulang' => $history->tgl_kalibrasi_ulang
                                            ? $history->tgl_kalibrasi_ulang->format('d/m/Y')
                                            : null,
                                        'keterangan' => $history->keterangan ?? '-',
                                    ];
                                })
                                ->toArray();
                        @endphp

                        @forelse($tools as $index => $tool)
                            @php
                                $history = $tool->latestHistory;
                                $status = optional($history)->status_kalibrasi ?? '-';

                                if (strcasecmp($status, 'OK') === 0) {
                                    $statusClass = 'badge-status badge-ok';
                                    $icon = '✓';
                                } elseif (strcasecmp($status, 'Proses') === 0) {
                                    $statusClass = 'badge-status badge-proses';
                                    $icon = '⚙';
                                } elseif (stripos($status, 'Jatuh Tempo') !== false) {
                                    $statusClass = 'badge-status badge-due';
                                    $icon = '⚠';
                                } else {
                                    $statusClass = 'badge-status badge-unknown';
                                    $icon = '-';
                                }
                            @endphp

                            <tr data-tool='@json($toolsData[$index])'>
                                <td class="text-slate-500 font-medium">{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-bold text-slate-800">{{ e($tool->nama_alat) }}</div>
                                </td>
                                <td>
                                    <div class="font-mono text-sm text-slate-700">{{ e($tool->no_seri) }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">{{ e($tool->merek ?? 'Tanpa Merk') }}</div>
                                </td>
                                <td>
                                    <span class="{{ $statusClass }}">{{ $icon }} {{ $status }}</span>
                                </td>
                                <td class="font-mono text-sm text-slate-600">
                                    {{ $toolsData[$index]['tgl_kalibrasi'] ?? '-' }}</td>
                                <td class="font-mono text-sm font-semibold text-slate-700">
                                    {{ $toolsData[$index]['tgl_kalibrasi_ulang'] ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn-detail" data-action="detail">Lihat</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="text-4xl mb-3">📭</div>
                                    <h3 class="text-lg font-semibold text-slate-700">Data Kosong</h3>
                                    <p class="text-slate-500 text-sm">Belum ada instrumen yang terdaftar untuk kalibrasi.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                <div id="paginationInfo" class="text-sm font-medium text-slate-500">Memuat data...</div>
                <div id="paginationControls" class="pagination"></div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="fixed inset-0 hidden items-center justify-center z-[100]" role="dialog"
        aria-modal="true">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative modal-card bg-white w-full max-w-2xl m-4 z-10 flex flex-col">

            <div
                class="px-6 py-4 border-b border-slate-100 flex justify-between items-center sticky top-0 bg-white/90 backdrop-blur z-20">
                <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Detail Instrumen</h3>
                <button id="modalClose"
                    class="p-2 hover:bg-slate-100 rounded-full transition-colors text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <div id="modalBody" class="detail-grid">
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 text-right rounded-b-2xl sticky bottom-0 z-20">
                <button id="modalClose2"
                    class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-lg transition-colors">Tutup</button>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global Data
        window._pieData = @json($pieData ?? ['ok' => 0, 'proses' => 0, 'due' => 0]);
        window.__BAR_LABELS__ = @json($barLabels ?? []);
        window.__BAR_VALUES__ = @json($barValues ?? []);

        document.addEventListener('DOMContentLoaded', function() {
            // ================= CHARTS =================
            const initCharts = () => {
                Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
                Chart.defaults.color = '#64748b';

                // Pie Chart
                const pieCtx = document.getElementById('statusPie');
                if (pieCtx) {
                    new Chart(pieCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['OK', 'Proses', 'Due / Jatuh Tempo'],
                            datasets: [{
                                data: [window._pieData.ok, window._pieData.proses, window
                                    ._pieData.due
                                ],
                                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                                borderWidth: 0,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '70%',
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        usePointStyle: true,
                                        boxWidth: 8
                                    }
                                }
                            }
                        }
                    });
                }

                // Line Chart
                const lineCtx = document.getElementById('trendLine');
                if (lineCtx) {
                    const gradient = lineCtx.getContext('2d').createLinearGradient(0, 0, 0, 200);
                    gradient.addColorStop(0, 'rgba(14, 165, 233, 0.2)');
                    gradient.addColorStop(1, 'rgba(14, 165, 233, 0)');

                    new Chart(lineCtx, {
                        type: 'line',
                        data: {
                            labels: window.__BAR_LABELS__,
                            datasets: [{
                                label: 'Jadwal Kalibrasi',
                                data: window.__BAR_VALUES__,
                                borderColor: '#0ea5e9',
                                backgroundColor: gradient,
                                borderWidth: 2,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#0ea5e9',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        borderDash: [4, 4],
                                        color: '#f1f5f9'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }
            };
            initCharts();

            // ================= TABLE LOGIC =================
            const tbody = document.getElementById('toolsTbody');
            const rows = Array.from(tbody.querySelectorAll('tr[data-tool]'));

            let filteredRows = [...rows];
            let currentPage = 1;
            let perPage = 10;

            const applyFilters = () => {
                const search = document.getElementById('searchInput').value.toLowerCase();
                const status = document.getElementById('statusFilter').value.toLowerCase();

                filteredRows = rows.filter(row => {
                    const text = row.innerText.toLowerCase();
                    const statusCell = row.cells[3].innerText.toLowerCase();

                    const matchSearch = search === '' || text.includes(search);
                    const matchStatus = status === '' || statusCell.includes(status);

                    return matchSearch && matchStatus;
                });

                currentPage = 1;
                renderTable();
            };

            const renderTable = () => {
                rows.forEach(r => r.style.display = 'none');

                const start = (currentPage - 1) * perPage;
                const paginatedRows = filteredRows.slice(start, start + perPage);

                paginatedRows.forEach(r => r.style.display = '');

                // Info text
                const infoEl = document.getElementById('paginationInfo');
                if (filteredRows.length === 0) {
                    infoEl.textContent = 'Tidak ada data ditemukan.';
                } else {
                    infoEl.textContent =
                        `Menampilkan ${start + 1}-${Math.min(start + perPage, filteredRows.length)} dari ${filteredRows.length} data`;
                }

                renderPagination();
            };

            const renderPagination = () => {
                const controls = document.getElementById('paginationControls');
                controls.innerHTML = '';
                const totalPages = Math.ceil(filteredRows.length / perPage);

                if (totalPages <= 1) return;

                // Prev Button
                const btnPrev = document.createElement('button');
                btnPrev.innerHTML =
                    '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>';
                btnPrev.disabled = currentPage === 1;
                btnPrev.onclick = () => {
                    currentPage--;
                    renderTable();
                };
                controls.appendChild(btnPrev);

                // Page Numbers
                for (let i = 1; i <= totalPages; i++) {
                    // Logic for simple ellipsis if pages > 5 can be added here
                    const btnPage = document.createElement('button');
                    btnPage.textContent = i;
                    if (i === currentPage) btnPage.classList.add('active');
                    btnPage.onclick = () => {
                        currentPage = i;
                        renderTable();
                    };
                    controls.appendChild(btnPage);
                }

                // Next Button
                const btnNext = document.createElement('button');
                btnNext.innerHTML =
                    '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>';
                btnNext.disabled = currentPage === totalPages;
                btnNext.onclick = () => {
                    currentPage++;
                    renderTable();
                };
                controls.appendChild(btnNext);
            };

            // Event Listeners for Filters
            document.getElementById('searchInput').addEventListener('input', applyFilters);
            document.getElementById('statusFilter').addEventListener('change', applyFilters);
            document.getElementById('perPage').addEventListener('change', (e) => {
                perPage = parseInt(e.target.value);
                applyFilters();
            });
            document.getElementById('refreshBtn').addEventListener('click', () => window.location.reload());

            // Initial Render
            renderTable();

            // ================= MODAL LOGIC =================
            const modal = document.getElementById('detailModal');

            const openModal = (data) => {
                document.getElementById('modalTitle').textContent = data.nama;

                let statusColor = 'text-slate-800';
                if (data.status === 'OK') statusColor = 'text-emerald-600';
                if (data.status === 'Proses') statusColor = 'text-amber-500';
                if (data.status.includes('Jatuh Tempo')) statusColor = 'text-red-500';

                document.getElementById('modalBody').innerHTML = `
                    <div class="detail-item">
                        <div class="detail-label">Nomor Seri</div>
                        <div class="detail-value font-mono">${data.no_seri || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Merk</div>
                        <div class="detail-value">${data.merek || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Status Terkini</div>
                        <div class="detail-value ${statusColor}">${data.status}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tanggal Kalibrasi Terakhir</div>
                        <div class="detail-value font-mono">${data.tgl_kalibrasi || '-'}</div>
                    </div>
                    <div class="detail-item sm:col-span-2 bg-primary-light border-blue-200">
                        <div class="detail-label text-blue-700">Jadwal Kalibrasi Ulang (DUE DATE)</div>
                        <div class="detail-value text-blue-900 text-lg font-mono">${data.tgl_kalibrasi_ulang || '-'}</div>
                    </div>
                    <div class="detail-item sm:col-span-2">
                        <div class="detail-label">Keterangan / Catatan</div>
                        <div class="detail-value font-normal text-slate-600">${data.keterangan || 'Tidak ada catatan.'}</div>
                    </div>
                `;

                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden'; // prevent background scrolling
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            };

            // Modal Listeners
            tbody.addEventListener('click', (e) => {
                if (e.target.closest('.btn-detail')) {
                    const tr = e.target.closest('tr');
                    const data = JSON.parse(tr.dataset.tool);
                    openModal(data);
                }
            });

            document.getElementById('modalClose').addEventListener('click', closeModal);
            document.getElementById('modalClose2').addEventListener('click', closeModal);
            document.getElementById('modalBackdrop').addEventListener('click', closeModal);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModal();
            });
        });
    </script>
@endpush
