@extends('layouts.home')

@section('title', 'MCI | Portal Inventory')

@section('content')

    <div class="max-w-7xl mx-auto py-10 px-4">
        <!-- Hero -->
        <header class="mb-8">
            <div class="rounded-2xl bg-gradient-to-r from-sky-50 via-white to-indigo-50 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-sky-700 mb-1 leading-tight">📦 Portal Inventory</h1>
                    <p class="text-gray-500 text-sm sm:text-base">Pantau stok gudang secara real-time — filter, cari, dan ekspor data tanpa ribet.</p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- View toggle -->
                    {{-- <div class="inline-flex items-center bg-white border border-gray-100 rounded-lg shadow-sm p-1">
                        <button id="btnViewTable" class="px-3 py-1 text-xs rounded-md bg-sky-600 text-white font-semibold focus:outline-none">Tabel</button>
                        <button id="btnViewCards" class="px-3 py-1 text-xs rounded-md text-sky-600 hover:bg-sky-50 focus:outline-none">Kartu</button>
                    </div>

                    <!-- Export -->
                    <button id="btnExport" aria-label="Ekspor CSV"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-sky-600 to-indigo-600 text-white px-4 py-2 rounded-lg shadow-md text-sm font-semibold hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"></path>
                        </svg>
                        Ekspor CSV
                    </button> --}}
                </div>
            </div>
        </header>

        <!-- Summary -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-gradient-to-br from-sky-100 to-sky-50">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M7 7v10a1 1 0 001 1h8a1 1 0 001-1V7M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-xs text-gray-500">Total Barang</div>
                    <div class="text-2xl font-bold text-sky-700" id="totalBarang">—</div>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-gradient-to-br from-emerald-100 to-emerald-50">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h3l3 9 4-18 3 9h4"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-xs text-gray-500">Masuk Bulan Ini</div>
                    <div class="text-2xl font-bold text-emerald-600" id="totalMasuk">—</div>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-gradient-to-br from-rose-100 to-rose-50">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12H3m12 8l-4-8 4-8"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-xs text-gray-500">Keluar Bulan Ini</div>
                    <div class="text-2xl font-bold text-rose-600" id="totalKeluar">—</div>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-white shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-gradient-to-br from-amber-100 to-amber-50">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12A9 9 0 1112 3a9 9 0 019 9z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-xs text-gray-500">Stok Di Bawah Minimum</div>
                    <div class="text-2xl font-bold text-amber-600" id="belowMinimum">—</div>
                </div>
            </div>
        </section>

        <!-- Chart + Filter -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-sky-700">📈 Grafik Barang Masuk & Keluar</h2>
                    <div class="text-sm text-gray-500">Periode: <span id="chartPeriod" class="font-medium">—</span></div>
                </div>
                <div class="h-64 sm:h-80">
                    <canvas id="inventoryChart" role="img" aria-label="Grafik barang masuk dan keluar"></canvas>
                </div>
            </div>

            <aside class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Filter Cepat</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Bulan</label>
                        <select id="bulan" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sky-200">
                            <option value="">Semua</option>
                            @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $key => $nama)
                                <option value="{{ $key }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Tahun</label>
                        <select id="tahun" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sky-200">
                            <option value="">Semua</option>
                            @for ($t = date('Y'); $t >= date('Y') - 5; $t--)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- <div>
                        <label class="block text-xs text-gray-500 mb-1">Rak / Posisi</label>
                        <input id="rak" type="text" placeholder="Nama rak..." class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sky-200" />
                    </div> --}}

                    <div class="flex gap-2">
                        <button id="btnFilter" class="flex-1 bg-sky-600 text-white py-2 rounded-lg text-sm font-semibold hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-sky-300">🔎 Tampilkan</button>
                        <button id="btnClear" class="flex-1 bg-white border border-gray-200 py-2 rounded-lg text-sm hover:shadow focus:outline-none">Reset</button>
                    </div>
                </div>
            </aside>
        </div>

        <!-- Search + Table / Cards -->
        <section class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                <h2 class="text-lg font-semibold text-sky-700">📋 Data Inventory</h2>

                <div class="flex items-center gap-2 w-full md:w-1/2">
                    <div class="relative w-full">
                        <input id="searchInput" type="text" placeholder="🔍 Cari Heat/Lot, No Drawing, Spare Part..." class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sky-200 focus:outline-none" aria-label="Cari data inventaris" />
                        <button id="btnClearSearch" title="Hapus pencarian" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden">✕</button>
                    </div>

                    <button id="btnSearch" class="bg-white border border-gray-200 px-4 py-2 rounded-lg text-sm hover:shadow focus:outline-none">Cari</button>
                </div>
            </div>

            <!-- mobile cards -->
            <div id="inventoryCards" class="grid grid-cols-1 gap-3 sm:hidden" aria-live="polite"></div>

            <!-- desktop table -->
            <div class="overflow-x-auto rounded-lg border border-gray-100 hidden sm:block">
                <table id="inventoryTable" class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gradient-to-r from-sky-600 to-indigo-600 text-white text-xs uppercase tracking-wide sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-3 text-left w-12">No</th>
                            <th class="px-4 py-3 text-left min-w-[160px]">Heat/Lot No</th>
                            <th class="px-4 py-3 text-left min-w-[140px]">No Drawing</th>
                            <th class="px-4 py-3 text-left min-w-[180px]">Tipe Valve</th>
                            <th class="px-4 py-3 text-left min-w-[180px]">Spare Part</th>
                            <th class="px-4 py-3 text-left min-w-[100px]">Dimensi</th>
                            <th class="px-4 py-3 text-left min-w-[120px]">Posisi</th>
                            <th class="px-4 py-3 text-center w-28">Stok Awal</th>
                            <th class="px-4 py-3 text-center w-28">Masuk</th>
                            <th class="px-4 py-3 text-center w-28">Keluar</th>
                            <th class="px-4 py-3 text-center w-28">Stok Akhir</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryBody" class="bg-white divide-y divide-gray-100">
                        {{-- JS render --}}
                    </tbody>
                </table>
            </div>

            <!-- footer / pagination -->
            <div id="tableFooter" class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-sm text-gray-600 hidden">
                <div>Menampilkan <span id="showingRange">0</span> dari <span id="totalCount">0</span> baris</div>
                <div class="flex items-center gap-2">
                    <button id="btnPrev" class="px-3 py-1 rounded border border-gray-200 bg-white text-gray-700 disabled:opacity-50">Sebelumnya</button>
                    <div class="text-xs text-gray-500 px-2">Halaman <span id="currentPage">1</span> / <span id="totalPages">1</span></div>
                    <button id="btnNext" class="px-3 py-1 rounded border border-gray-200 bg-white text-gray-700 disabled:opacity-50">Berikutnya</button>

                    <div class="ml-2 flex items-center gap-2">
                        <label for="pageSize" class="text-xs text-gray-500">Baris / halaman</label>
                        <select id="pageSize" class="border rounded px-2 py-1 text-sm">
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chartInstance;
        let lastFetchedTableData = [];
        let debounceTimer;
        let currentPage = 1;
        let pageSize = 25;

        $(function() {
            // init defaults
            const now = new Date();
            $('#bulan').val(now.getMonth() + 1);
            $('#tahun').val(now.getFullYear());

            // initial load
            loadSummary();
            loadTable();
            loadChart();

            // events
            $('#btnFilter').on('click', () => { loadTable(); loadChart(); });
            $('#btnClear').on('click', () => {
                $('#bulan').val('');
                $('#tahun').val('');
                $('#rak').val('');
                $('#searchInput').val('');
                $('#btnClearSearch').addClass('hidden');
                loadTable();
                loadChart();
            });

            $('#btnExport').on('click', exportCsv);
            $('#btnSearch').on('click', loadTable);

            $('#searchInput').on('input', function() {
                clearTimeout(debounceTimer);
                if ($(this).val()) $('#btnClearSearch').removeClass('hidden'); else $('#btnClearSearch').addClass('hidden');
                debounceTimer = setTimeout(loadTable, 450);
            });
            $('#searchInput').on('keypress', function(e){ if (e.which === 13) { clearTimeout(debounceTimer); loadTable(); }});
            $('#btnClearSearch').on('click', function(){ $('#searchInput').val(''); $(this).addClass('hidden'); loadTable(); });

            $('#btnPrev').on('click', () => { if (currentPage > 1) { currentPage--; renderTableRows(lastFetchedTableData); }});
            $('#btnNext').on('click', () => { const totalPages = Math.max(1, Math.ceil((lastFetchedTableData?.length || 0) / pageSize)); if (currentPage < totalPages) { currentPage++; renderTableRows(lastFetchedTableData); }});
            $('#pageSize').on('change', function(){ pageSize = Number($(this).val()) || 25; currentPage = 1; renderTableRows(lastFetchedTableData); });

            // view toggle
            $('#btnViewTable').on('click', function(){
                $('#inventoryTable').closest('.overflow-x-auto').removeClass('hidden');
                $('#inventoryCards').addClass('hidden');
                $(this).addClass('bg-sky-600 text-white').siblings().removeClass('bg-sky-600 text-white');
            });
            $('#btnViewCards').on('click', function(){
                $('#inventoryTable').closest('.overflow-x-auto').addClass('hidden');
                $('#inventoryCards').removeClass('hidden');
                $(this).addClass('bg-sky-600 text-white').siblings().removeClass('bg-sky-600 text-white');
            });
        });

        // count animation helper
        function animateCount(elSelector, toValue) {
            const el = document.querySelector(elSelector);
            if(!el) return;
            const start = Number(el.textContent.replace(/[^0-9]/g,'')) || 0;
            const end = Number(toValue) || 0;
            const duration = 600;
            const stepTime = 20;
            const steps = Math.ceil(duration / stepTime);
            let currentStep = 0;
            const increment = (end - start) / steps;
            const timer = setInterval(() => {
                currentStep++;
                const val = Math.round(start + increment * currentStep);
                el.textContent = (end >= 1000) ? val.toLocaleString() : val;
                if (currentStep >= steps) {
                    clearInterval(timer);
                    el.textContent = end.toLocaleString();
                }
            }, stepTime);
        }

        function formatNumber(n) {
            if (n === null || n === undefined || isNaN(Number(n))) return '-';
            return Number(n).toLocaleString();
        }

        function toast(message, type = 'info') {
            const colors = { info: 'bg-sky-600', error: 'bg-rose-600', success: 'bg-emerald-600' };
            const bg = colors[type] || colors.info;
            const $t = $('<div>').addClass(`${bg} text-white px-4 py-2 rounded shadow fixed right-6 bottom-6 z-50`).text(message).hide();
            $('body').append($t);
            $t.fadeIn(200).delay(2200).fadeOut(400, function(){ $(this).remove(); });
        }

        // fetch summary
        function loadSummary() {
            $('.summary-card, #totalBarang, #totalMasuk, #totalKeluar, #belowMinimum').addClass('opacity-60');
            $.get("{{ route('inventory.summary') }}")
                .done(function(data){
                    $('.summary-card, #totalBarang, #totalMasuk, #totalKeluar, #belowMinimum').removeClass('opacity-60');
                    animateCount('#totalBarang', data.total_barang ?? 0);
                    animateCount('#totalMasuk', data.total_masuk ?? 0);
                    animateCount('#totalKeluar', data.total_keluar ?? 0);
                    animateCount('#belowMinimum', data.below_minimum ?? 0);
                })
                .fail(function(){ $('.summary-card, #totalBarang, #totalMasuk, #totalKeluar, #belowMinimum').removeClass('opacity-60'); toast('Gagal memuat ringkasan inventory.', 'error'); });
        }

        // table data
        function loadTable() {
            const bulan = $('#bulan').val();
            const tahun = $('#tahun').val();
            const search = $('#searchInput').val();
            const rak = $('#rak').val();

            $('#inventoryBody, #inventoryCards').empty();
            $('#tableFooter').addClass('hidden');
            $('#inventoryCards').html(''); // clear

            $('#inventoryBody').html(`<tr><td colspan="11" class="py-6 text-center text-gray-400">Memuat data...</td></tr>`);
            $.get("{{ route('inventory.data') }}", { bulan, tahun, search, rak })
                .done(function(data){
                    lastFetchedTableData = Array.isArray(data) ? data : [];
                    currentPage = 1;
                    renderTableRows(lastFetchedTableData);
                })
                .fail(function(){
                    $('#inventoryBody').html(`<tr><td colspan="11" class="py-6 text-center text-rose-500">Gagal memuat data.</td></tr>`);
                    toast('Gagal memuat data tabel. Coba lagi.', 'error');
                });
        }

        function renderTableRows(data){
            const total = Array.isArray(data) ? data.length : 0;
            $('#totalCount').text(total);

            if (total === 0) {
                $('#inventoryBody').html(`<tr><td colspan="11" class="py-8 text-gray-400 text-center">Tidak ada data untuk periode ini.</td></tr>`);
                $('#inventoryCards').html(`<div class="py-8 text-center text-gray-400">Tidak ada data untuk periode ini.</div>`);
                $('#showingRange').text(0);
                $('#currentPage').text(1);
                $('#totalPages').text(1);
                $('#tableFooter').removeClass('hidden');
                $('#btnPrev, #btnNext').prop('disabled', true);
                return;
            }

            const totalPages = Math.max(1, Math.ceil(total / pageSize));
            if (currentPage > totalPages) currentPage = totalPages;
            const startIdx = (currentPage - 1) * pageSize;
            const pageItems = data.slice(startIdx, startIdx + pageSize);

            // responsive decision
            const isMobile = window.innerWidth < 640;

            if (isMobile) {
                let cardsHtml = '';
                pageItems.forEach((item, idx) => {
                    const i = startIdx + idx + 1;
                    const valveNames = Array.isArray(item.material?.valve_name) ? item.material.valve_name.join(', ') : (item.material?.valve_name ?? '-');
                    const heatLot = escapeHtml(item.material?.heat_lot_no ?? '-');
                    const noDrawing = escapeHtml(item.material?.no_drawing ?? '-');
                    const sparePart = escapeHtml(item.material?.spare_part_name ?? '-');
                    const rack = escapeHtml(item.material?.rack_name ?? '-');
                    const stockAwal = formatNumber(item.material?.stock_awal ?? 0);
                    const qtyIn = formatNumber(item.qty_in ?? 0);
                    const qtyOut = formatNumber(item.qty_out ?? 0);
                    const stock = formatNumber(item.stock_akhir ?? 0);

                    cardsHtml += `
                        <article class="p-4 border border-gray-100 rounded-xl shadow-sm bg-white">
                            <div class="flex justify-between items-start gap-3">
                                <div>
                                    <div class="text-xs text-gray-400 mb-1">#${i} — <span class="font-medium">${heatLot}</span></div>
                                    <div class="text-sm text-gray-600 mb-1 truncate">${noDrawing}</div>
                                    <div class="text-xs text-gray-500">Valve: <span class="text-gray-700">${escapeHtml(valveNames)}</span></div>
                                    <div class="text-xs text-gray-500">Spare: <span class="text-gray-700">${sparePart}</span></div>
                                    <div class="text-xs mt-2"><span class="inline-block bg-sky-50 text-sky-700 px-2 py-0.5 rounded text-xs">${rack}</span></div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-400">Stok Akhir</div>
                                    <div class="text-lg font-semibold text-gray-800">${stock}</div>
                                    <div class="mt-2 text-xs text-green-600">+${qtyIn} in</div>
                                    <div class="text-xs text-rose-600">-${qtyOut} out</div>
                                    <div class="text-xs text-gray-400 mt-1">Awal: ${stockAwal}</div>
                                </div>
                            </div>
                        </article>
                    `;
                });
                $('#inventoryCards').html(cardsHtml);
                $('#inventoryTable').closest('.overflow-x-auto').addClass('hidden');
            } else {
                let rowsHtml = '';
                pageItems.forEach((item, idx) => {
                    const i = startIdx + idx + 1;
                    const valveNames = Array.isArray(item.material?.valve_name) ? item.material.valve_name.join(', ') : (item.material?.valve_name ?? '-');
                    const heatLot = escapeHtml(item.material?.heat_lot_no ?? '-');
                    const noDrawing = escapeHtml(item.material?.no_drawing ?? '-');
                    const sparePart = escapeHtml(item.material?.spare_part_name ?? '-');
                    const dimensi = escapeHtml(item.material?.dimensi ?? '-');
                    const rack = escapeHtml(item.material?.rack_name ?? '-');
                    const stockAwal = formatNumber(item.material?.stock_awal ?? 0);
                    const qtyIn = formatNumber(item.qty_in ?? 0);
                    const qtyOut = formatNumber(item.qty_out ?? 0);
                    const stock = formatNumber(item.stock_akhir ?? 0);

                    rowsHtml += `
                        <tr class="hover:bg-sky-50 transition">
                            <td class="px-4 py-3">${i}</td>
                            <td class="px-4 py-3"><div class="max-w-[180px] truncate" title="${heatLot}">${heatLot}</div></td>
                            <td class="px-4 py-3"><div class="max-w-[160px] truncate" title="${noDrawing}">${noDrawing}</div></td>
                            <td class="px-4 py-3"><div class="max-w-[220px] truncate" title="${escapeHtml(valveNames)}">${escapeHtml(valveNames)}</div></td>
                            <td class="px-4 py-3"><div class="max-w-[220px] truncate" title="${sparePart}">${sparePart}</div></td>
                            <td class="px-4 py-3"><div class="max-w-[120px] truncate" title="${dimensi}">${dimensi}</div></td>
                            <td class="px-4 py-3"><span class="inline-block bg-sky-50 text-sky-700 px-2 py-0.5 rounded text-xs">${rack}</span></td>
                            <td class="px-4 py-3 text-center">${stockAwal}</td>
                            <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-sm font-semibold text-emerald-700 bg-emerald-50">${qtyIn}</span></td>
                            <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-sm font-semibold text-rose-700 bg-rose-50">${qtyOut}</span></td>
                            <td class="px-4 py-3 text-center"><strong>${stock}</strong></td>
                        </tr>
                    `;
                });
                $('#inventoryBody').html(rowsHtml);
                $('#inventoryTable').closest('.overflow-x-auto').removeClass('hidden');
                $('#inventoryCards').html('');
            }

            const showingFrom = startIdx + 1;
            const showingTo = Math.min(startIdx + pageItems.length, total);
            $('#showingRange').text(`${showingFrom}–${showingTo}`);
            $('#currentPage').text(currentPage);
            $('#totalPages').text(totalPages);
            $('#totalCount').text(total);

            $('#tableFooter').removeClass('hidden');
            $('#btnPrev').prop('disabled', currentPage <= 1);
            $('#btnNext').prop('disabled', currentPage >= totalPages);

            // ensure responsive re-render on resize
            if (!window._invResize) {
                let timer;
                window._invResize = () => {
                    clearTimeout(timer);
                    timer = setTimeout(() => renderTableRows(lastFetchedTableData), 200);
                };
                window.addEventListener('resize', window._invResize);
            }
        }

        // chart
        function loadChart() {
            const bulan = $('#bulan').val();
            const tahun = $('#tahun').val();
            $.get("{{ route('inventory.chart') }}", { bulan, tahun })
                .done(function(data) {
                    const labels = data.labels || [];
                    const masuk = data.masuk || [];
                    const keluar = data.keluar || [];
                    $('#chartPeriod').text((bulan ? bulan : 'Semua Bulan') + ' / ' + (tahun ? tahun : 'Semua Tahun'));

                    const ctx = document.getElementById('inventoryChart').getContext('2d');
                    if (chartInstance) chartInstance.destroy();

                    chartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                { label: 'Masuk', data: masuk, backgroundColor: 'rgba(34,197,94,0.9)', borderRadius: 6 },
                                { label: 'Keluar', data: keluar, backgroundColor: 'rgba(239,68,68,0.9)', borderRadius: 6 },
                                { type: 'line', label: 'Tren Masuk', data: masuk, borderColor: '#16a34a', backgroundColor: 'transparent', tension: 0.25, pointRadius: 3 },
                                { type: 'line', label: 'Tren Keluar', data: keluar, borderColor: '#dc2626', backgroundColor: 'transparent', tension: 0.25, pointRadius: 3 }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { mode: 'index', intersect: false },
                            scales: {
                                y: { beginAtZero: true, ticks: { callback: v => Number(v).toLocaleString() }, grid: { color: 'rgba(0,0,0,0.05)' } },
                                x: { grid: { color: 'rgba(0,0,0,0.03)' } }
                            },
                            plugins: {
                                legend: { position: 'top' },
                                title: { display: true, text: '📊 Tren Barang Masuk & Keluar per Hari', font: { size: 15 } },
                                tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${Number(ctx.parsed.y ?? ctx.parsed).toLocaleString()} unit` } }
                            },
                            animation: { duration: 700, easing: 'easeOutQuart' }
                        }
                    });
                })
                .fail(function(){ toast('Gagal memuat data chart.', 'error'); });
        }

        // export CSV with BOM
        function exportCsv() {
            if (!Array.isArray(lastFetchedTableData) || lastFetchedTableData.length === 0) { toast('Tidak ada data untuk diekspor.', 'info'); return; }
            const rows = [];
            const header = ['No','Heat/Lot No','No Drawing','Tipe Valve','Spare Part','Dimensi','Posisi','Qty Masuk','Qty Keluar','Stock Akhir'];
            rows.push(header.join(','));
            lastFetchedTableData.forEach((item, idx) => {
                const valveNames = Array.isArray(item.material?.valve_name) ? item.material.valve_name.join('; ') : (item.material?.valve_name ?? '-');
                const row = [
                    idx+1,
                    sanitizeCsv(item.material?.heat_lot_no),
                    sanitizeCsv(item.material?.no_drawing),
                    sanitizeCsv(valveNames),
                    sanitizeCsv(item.material?.spare_part_name),
                    sanitizeCsv(item.material?.dimensi),
                    sanitizeCsv(item.material?.rack_name),
                    item.qty_in ?? 0,
                    item.qty_out ?? 0,
                    item.stock_akhir ?? 0
                ];
                rows.push(row.join(','));
            });
            const csvContent = '\uFEFF' + rows.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a'); a.href = url; a.download = `inventory_export_${new Date().toISOString().slice(0,10)}.csv`;
            document.body.appendChild(a); a.click(); document.body.removeChild(a); URL.revokeObjectURL(url);
            toast('Ekspor CSV berhasil.', 'success');
        }

        function sanitizeCsv(v) { if (v === null || v === undefined) return ''; const s = String(v).replace(/"/g, '""'); return /[\n,",;]/.test(s) ? `"${s}"` : s; }
        function escapeHtml(text) { if (text === null || text === undefined) return ''; return String(text).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;'); }
    </script>

@endsection