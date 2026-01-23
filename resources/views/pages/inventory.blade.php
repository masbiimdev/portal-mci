@extends('layouts.home')

@section('title', 'MCI | Portal Inventory')

@push('css')
<style>
    /* Small visual polish to make the portal friendlier */
    .card-soft {
        background: linear-gradient(180deg,#ffffff,#fbfdff);
        border: 1px solid rgba(15,23,42,0.04);
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(11,20,40,0.04);
    }

    .chip {
        display:inline-flex;
        gap:.5rem;
        align-items:center;
        padding:.35rem .6rem;
        border-radius:999px;
        background:#f1f5f9;
        color:#0f172a;
        font-weight:600;
        font-size:.85rem;
    }

    .low-stock {
        background: linear-gradient(90deg, rgba(254,243,199,0.6), rgba(255,255,255,0));
    }

    .skeleton {
        background: linear-gradient(90deg, #f3f4f6 25%, #eceff1 37%, #f3f4f6 63%);
        background-size: 400% 100%;
        animation: shine 1.4s ease infinite;
        border-radius: 6px;
    }
    @keyframes shine { to { background-position: 200% 0; } }

    /* Compact details toggle */
    .row-action {
        cursor: pointer;
    }

    /* mobile card tweaks */
    .card-meta { font-size: .9rem; color: #6b7280; }
    .count-pill { background: #eef2ff; color: #0f172a; padding:.2rem .5rem; border-radius:999px; font-weight:700; font-size:.85rem; }

    /* Accessible focus outlines for keyboard users */
    a:focus, button:focus, input:focus { outline: 3px solid rgba(81,102,255,0.12); outline-offset: 2px; }
</style>
@endpush

@section('content')

<div class="max-w-7xl mx-auto py-8 px-4">

    <!-- HERO -->
    <header class="mb-6 card-soft p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-sky-700 mb-1">📦 Portal Inventory</h1>
            <p class="text-gray-500">Pantau stok gudang secara real-time. Gunakan filter cepat, pencarian bebas, dan ekspor data jika perlu.</p>
            <div class="mt-3 flex flex-wrap gap-2 items-center">
                <span class="chip" title="Jumlah item unik di inventaris">Items: <strong id="totalBarangSmall" class="ml-2">—</strong></span>
                {{-- <span class="chip" title="Jumlah item yang stoknya di bawah minimum">Low stock: <strong id="belowMinimumSmall" class="ml-2">—</strong></span> --}}
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button id="btnExport" class="bg-sky-600 text-white px-4 py-2 rounded-lg shadow-sm text-sm font-semibold hover:opacity-95 focus:outline-none" aria-label="Ekspor CSV">
                Ekspor CSV
            </button>

            <button id="btnHelp" class="bg-white border border-gray-200 px-3 py-2 rounded-lg text-sm hover:shadow focus:outline-none" aria-label="Bantuan singkat">
                Cara pakai
            </button>
        </div>
    </header>

    <!-- SUMMARY -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="p-4 card-soft flex items-center gap-4">
            <div class="p-3 rounded-lg bg-gradient-to-br from-sky-100 to-sky-50">
                <svg class="w-6 h-6 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M7 7v10a1 1 0 001 1h8a1 1 0 001-1V7M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2"/></svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-gray-500">Total Barang</div>
                <div class="text-2xl font-bold text-sky-700" id="totalBarang">—</div>
            </div>
        </div>

        <div class="p-4 card-soft flex items-center gap-4">
            <div class="p-3 rounded-lg bg-gradient-to-br from-emerald-100 to-emerald-50">
                <svg class="w-6 h-6 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h3l3 9 4-18 3 9h4"/></svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-gray-500">Masuk Bulan Ini</div>
                <div class="text-2xl font-bold text-emerald-600" id="totalMasuk">—</div>
            </div>
        </div>

        <div class="p-4 card-soft flex items-center gap-4">
            <div class="p-3 rounded-lg bg-gradient-to-br from-rose-100 to-rose-50">
                <svg class="w-6 h-6 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12H3m12 8l-4-8 4-8"/></svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-gray-500">Keluar Bulan Ini</div>
                <div class="text-2xl font-bold text-rose-600" id="totalKeluar">—</div>
            </div>
        </div>

        <div class="p-4 card-soft flex items-center gap-4">
            <div class="p-3 rounded-lg bg-gradient-to-br from-amber-100 to-amber-50">
                <svg class="w-6 h-6 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12A9 9 0 1112 3a9 9 0 019 9z"/></svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-gray-500">Di bawah minimum</div>
                <div class="text-2xl font-bold text-amber-600" id="belowMinimum">—</div>
            </div>
        </div>
    </section>

    <!-- CHART + FILTER -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 card-soft p-5">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="text-lg font-semibold text-sky-700">📈 Grafik Barang Masuk & Keluar</h2>
                    <div class="text-sm text-gray-500">Tren selama 30 hari terakhir. Gunakan filter untuk memperkecil jangka waktu.</div>
                </div>

                <div class="flex items-center gap-2">
                    <select id="presetRange" class="border rounded px-3 py-2 text-sm" aria-label="Pilih rentang cepat">
                        <option value="30">30 hari terakhir</option>
                        <option value="14">14 hari</option>
                        <option value="7">7 hari</option>
                        <option value="all">Semua</option>
                    </select>
                </div>
            </div>

            <div class="h-64 sm:h-80">
                <canvas id="inventoryChart" role="img" aria-label="Grafik barang masuk dan keluar"></canvas>
            </div>
        </div>

        <aside class="card-soft p-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Filter Cepat</h3>

            <label class="block text-xs text-gray-500 mb-1">Bulan</label>
            <select id="bulan" class="w-full border rounded-lg px-3 py-2 text-sm mb-3" aria-label="Filter bulan">
                <option value="">Semua</option>
                @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $key => $nama)
                    <option value="{{ $key }}">{{ $nama }}</option>
                @endforeach
            </select>

            <label class="block text-xs text-gray-500 mb-1">Tahun</label>
            <select id="tahun" class="w-full border rounded-lg px-3 py-2 text-sm mb-3" aria-label="Filter tahun">
                <option value="">Semua</option>
                @for ($t = date('Y'); $t >= date('Y') - 5; $t--)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endfor
            </select>

            <div class="flex gap-2 mt-2">
                <button id="btnFilter" class="flex-1 bg-sky-600 text-white py-2 rounded-lg text-sm font-semibold">Terapkan</button>
                <button id="btnClear" class="flex-1 bg-white border border-gray-200 py-2 rounded-lg text-sm">Reset</button>
            </div>

            <p class="text-xs text-gray-500 mt-3">Tip: gunakan pencarian untuk menemukan Heat/Lot, nomor drawing, nama spare part, atau tipe valve.</p>
        </aside>
    </div>

    <!-- SEARCH + TABLE / CARDS -->
    <section class="card-soft p-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <div>
                <h2 class="text-lg font-semibold text-sky-700">📋 Data Inventory</h2>
            </div>

            <div class="flex items-center gap-2 w-full md:w-1/2">
                <div class="relative w-full">
                    <input id="searchInput" type="text" placeholder="🔍 Cari Heat/Lot, No Drawing, Spare Part, atau Tipe Valve..." class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sky-200 focus:outline-none" aria-label="Cari data inventaris" />
                    <button id="btnClearSearch" title="Hapus pencarian" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden" aria-hidden="true">✕</button>
                </div>

                <button id="btnSearch" class="bg-white border border-gray-200 px-4 py-2 rounded-lg text-sm">Cari</button>
            </div>
        </div>

        <!-- MOBILE CARDS -->
        <div id="inventoryCards" class="grid grid-cols-1 gap-3 sm:hidden" aria-live="polite"></div>

        <!-- DESKTOP TABLE -->
        <div class="overflow-x-auto rounded-lg border border-gray-100 hidden sm:block">
            <table id="inventoryTable" class="min-w-full text-sm text-gray-700" role="table" aria-label="Tabel inventory">
                <thead class="bg-gradient-to-r from-sky-600 to-indigo-600 text-white text-xs uppercase tracking-wide sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-left w-12">No</th>
                        <th class="px-4 py-3 text-left min-w-[160px]">Heat/Lot No</th>
                        <th class="px-4 py-3 text-left min-w-[140px]">No Drawing</th>
                        <th class="px-4 py-3 text-left min-w-[180px]">Tipe Valve</th>
                        <th class="px-4 py-3 text-left min-w-[180px]">Spare Part</th>
                        <th class="px-4 py-3 text-left min-w-[120px]">Posisi</th>
                        <th class="px-4 py-3 text-center w-28">Stok Awal</th>
                        <th class="px-4 py-3 text-center w-28">Masuk</th>
                        <th class="px-4 py-3 text-center w-28">Keluar</th>
                        <th class="px-4 py-3 text-center w-28">Stok Akhir</th>
                    </tr>
                </thead>
                <tbody id="inventoryBody" class="bg-white divide-y divide-gray-100">
                    <!-- JS renders rows -->
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

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let chartInstance;
    let lastFetchedTableData = [];
    let currentPage = 1;
    let pageSize = 25;
    let debounceTimer;

    // helper to safely get valve names
    function getValveNames(item) {
        // try multiple shapes: item.material.valve_name (array or string) or item.material.valves (array of objects)
        const m = item && item.material ? item.material : null;
        if (!m) return '-';
        if (Array.isArray(m.valve_name)) return m.valve_name.join(', ');
        if (typeof m.valve_name === 'string' && m.valve_name.trim() !== '') return m.valve_name;
        if (Array.isArray(m.valves)) {
            return m.valves.map(v => v.valve_name || v.name || '').filter(Boolean).join(', ') || '-';
        }
        return '-';
    }

    $(function() {
        // sensible defaults
        const now = new Date();
        $('#bulan').val(now.getMonth() + 1);
        $('#tahun').val(now.getFullYear());

        // initial fetch
        loadSummary();
        loadTable();
        loadChart();

        // events
        $('#btnFilter').on('click', () => { currentPage = 1; loadTable(); loadChart(); });
        $('#btnClear').on('click', () => {
            $('#bulan').val(''); $('#tahun').val(''); $('#searchInput').val(''); $('#btnClearSearch').addClass('hidden');
            currentPage = 1;
            loadTable(); loadChart();
        });

        $('#presetRange').on('change', function(){ loadChart(); });

        $('#btnExport').on('click', exportCsv);
        $('#btnSearch').on('click', () => { currentPage = 1; loadTable(); });

        $('#searchInput').on('input', function() {
            clearTimeout(debounceTimer);
            if ($(this).val()) $('#btnClearSearch').removeClass('hidden'); else $('#btnClearSearch').addClass('hidden');
            debounceTimer = setTimeout(() => { currentPage = 1; loadTable(); }, 400);
        });
        $('#searchInput').on('keypress', function(e){ if (e.which === 13) { clearTimeout(debounceTimer); currentPage = 1; loadTable(); }});
        $('#btnClearSearch').on('click', function(){ $('#searchInput').val(''); $(this).addClass('hidden'); currentPage = 1; loadTable(); });

        $('#btnPrev').on('click', () => { if (currentPage > 1) { currentPage--; renderTableRows(lastFetchedTableData); }});
        $('#btnNext').on('click', () => {
            const totalPages = Math.max(1, Math.ceil((lastFetchedTableData?.length || 0) / pageSize));
            if (currentPage < totalPages) { currentPage++; renderTableRows(lastFetchedTableData); }
        });
        $('#pageSize').on('change', function(){ pageSize = Number($(this).val()) || 25; currentPage = 1; renderTableRows(lastFetchedTableData); });

        // quick help
        $('#btnHelp').on('click', () => {
            alert("Cara cepat:\n• Gunakan kotak pencarian untuk menemukan Heat/Lot, No Drawing, nama spare part, atau tipe valve.\n• Pilih rentang atau bulan/tahun untuk mempersempit hasil.\n• Klik 'Ekspor CSV' untuk mengunduh hasil yang ditampilkan.");
        });
    });

    function loadSummary() {
        $('#totalBarang, #totalMasuk, #totalKeluar, #belowMinimum, #totalBarangSmall, #belowMinimumSmall').text('—').addClass('opacity-60');
        $.get("{{ route('inventory.summary') }}")
            .done(function(data){
                $('#totalBarang').removeClass('opacity-60'); $('#totalBarangSmall').removeClass('opacity-60');
                animateCount('#totalBarang', data.total_barang ?? 0);
                animateCount('#totalMasuk', data.total_masuk ?? 0);
                animateCount('#totalKeluar', data.total_keluar ?? 0);
                animateCount('#belowMinimum', data.below_minimum ?? 0);
                $('#totalBarangSmall').text((data.total_barang || 0).toLocaleString());
                $('#belowMinimumSmall').text((data.below_minimum || 0).toLocaleString());
            })
            .fail(function(){ toast('Gagal memuat ringkasan inventory.', 'error'); });
    }

    function loadTable() {
        const bulan = $('#bulan').val();
        const tahun = $('#tahun').val();
        const search = $('#searchInput').val();

        // adjust colspan to 9 (No + Heat + Drawing + Valve + Spare + Posisi + Masuk + Keluar + Stok)
        $('#inventoryBody').html(`<tr><td colspan="10" class="py-8 text-center"><div class="skeleton h-6 w-72 mx-auto mb-3"></div><div class="skeleton h-6 w-40 mx-auto"></div></td></tr>`);
        $('#inventoryCards').html(`<div class="py-8 text-center"><div class="skeleton h-24 w-11/12 mx-auto mb-3"></div><div class="skeleton h-24 w-11/12 mx-auto"></div></div>`);
        $('#tableFooter').addClass('hidden');

        $.get("{{ route('inventory.data') }}", { bulan, tahun, search })
            .done(function(data){
                lastFetchedTableData = Array.isArray(data) ? data : [];
                currentPage = 1;
                renderTableRows(lastFetchedTableData);
            })
            .fail(function(){
                $('#inventoryBody').html(`<tr><td colspan="10" class="py-8 text-center text-rose-500">Gagal memuat data.</td></tr>`);
                $('#inventoryCards').html(`<div class="py-8 text-center text-rose-500">Gagal memuat data.</div>`);
                toast('Gagal memuat data tabel. Coba lagi.', 'error');
            });
    }

    function renderTableRows(data){
        const total = Array.isArray(data) ? data.length : 0;
        $('#totalCount').text(total);

        if (total === 0) {
            $('#inventoryBody').html(`<tr><td colspan="10" class="py-8 text-gray-400 text-center">Tidak ada data untuk periode ini.</td></tr>`);
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

        const isMobile = window.innerWidth < 640;
        if (isMobile) {
            let cardsHtml = '';
            pageItems.forEach((item, idx) => {
                const i = startIdx + idx + 1;
                const heatLot = escapeHtml(item.material?.heat_lot_no ?? '-');
                const noDrawing = escapeHtml(item.material?.no_drawing ?? '-');
                const sparePart = escapeHtml(item.material?.spare_part_name ?? '-');
                const valveNames = escapeHtml(getValveNames(item));
                const rack = escapeHtml(item.material?.rack_name ?? '-');
                const stockAwal = formatNumber(item.material?.stock_awal ?? 0);
                const qtyIn = formatNumber(item.qty_in ?? 0);
                const qtyOut = formatNumber(item.qty_out ?? 0);
                const stock = Number(item.stock_akhir ?? 0);
                const lowClass = (item.material?.min_stock && stock <= item.material.min_stock) ? 'low-stock' : '';

                cardsHtml += `
                    <article class="p-4 border border-gray-100 rounded-xl shadow-sm bg-white ${lowClass}" tabindex="0">
                        <div class="flex justify-between items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="text-xs text-gray-400 mb-1">#${i} — <span class="font-medium">${heatLot}</span></div>
                                <div class="text-sm text-gray-600 mb-1 truncate">${noDrawing}</div>
                                <div class="text-xs text-gray-500">Valve: <span class="text-gray-700">${valveNames}</span></div>
                                <div class="text-xs text-gray-500">Spare: <span class="text-gray-700">${sparePart}</span></div>
                                <div class="text-xs card-meta mt-2">Posisi: <span class="count-pill">${rack}</span></div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-400">Stok Akhir</div>
                                <div class="text-lg font-semibold text-gray-800">${formatNumber(stock)}</div>
                                <div class="mt-2 text-xs text-emerald-700">+${qtyIn} in</div>
                                <div class="text-xs text-rose-700">-${qtyOut} out</div>
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
                const heatLot = escapeHtml(item.material?.heat_lot_no ?? '-');
                const noDrawing = escapeHtml(item.material?.no_drawing ?? '-');
                const valveNames = escapeHtml(getValveNames(item));
                const sparePart = escapeHtml(item.material?.spare_part_name ?? '-');
                const rack = escapeHtml(item.material?.rack_name ?? '-');
                const stockAwal = formatNumber(item.material?.stock_awal ?? 0);
                const qtyIn = formatNumber(item.qty_in ?? 0);
                const qtyOut = formatNumber(item.qty_out ?? 0);
                const stock = Number(item.stock_akhir ?? 0);
                const lowClass = (item.material?.min_stock && stock <= item.material.min_stock) ? 'low-stock' : '';

                rowsHtml += `
                    <tr class="hover:bg-sky-50 transition ${lowClass}">
                        <td class="px-4 py-3">${i}</td>
                        <td class="px-4 py-3"><div class="max-w-[180px] truncate" title="${heatLot}">${heatLot}</div></td>
                        <td class="px-4 py-3"><div class="max-w-[160px] truncate" title="${noDrawing}">${noDrawing}</div></td>
                        <td class="px-4 py-3"><div class="max-w-[220px] truncate" title="${valveNames}">${valveNames}</div></td>
                        <td class="px-4 py-3"><div class="max-w-[220px] truncate" title="${sparePart}">${sparePart}</div></td>
                        <td class="px-4 py-3"><span class="inline-block bg-sky-50 text-sky-700 px-2 py-0.5 rounded text-xs">${rack}</span></td>
                        <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-sm font-semibold text-emerald-700 bg-emerald-50">${stockAwal}</span></td>
                        <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-sm font-semibold text-emerald-700 bg-emerald-50">${qtyIn}</span></td>
                        <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-sm font-semibold text-rose-700 bg-rose-50">${qtyOut}</span></td>
                        <td class="px-4 py-3 text-center"><strong>${formatNumber(stock)}</strong></td>
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

        // re-run accessibility: allow keyboard "Enter" on rows to open detail link if present
        $('#inventoryBody tr').attr('tabindex', 0).off('keypress').on('keypress', function(e){
            if (e.which === 13) {
                const link = $(this).find('a').first();
                if (link && link.attr('href') && link.attr('href') !== '#') window.location = link.attr('href');
            }
        });
    }

    function loadChart() {
        const preset = $('#presetRange').val();
        const bulan = $('#bulan').val();
        const tahun = $('#tahun').val();

        $.get("{{ route('inventory.chart') }}", { days: preset, bulan, tahun })
            .done(function(data){
                const labels = data.labels || [];
                const masuk = data.masuk || [];
                const keluar = data.keluar || [];

                const ctx = document.getElementById('inventoryChart').getContext('2d');
                if (chartInstance) chartInstance.destroy();

                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [
                            { label: 'Masuk', data: masuk, backgroundColor: 'rgba(34,197,94,0.9)', borderRadius: 6 },
                            { label: 'Keluar', data: keluar, backgroundColor: 'rgba(239,68,68,0.9)', borderRadius: 6 },
                            { type: 'line', label: 'Tren Masuk', data: masuk, borderColor: '#16a34a', backgroundColor: 'transparent', tension: 0.25, pointRadius: 2 },
                            { type: 'line', label: 'Tren Keluar', data: keluar, borderColor: '#dc2626', backgroundColor: 'transparent', tension: 0.25, pointRadius: 2 }
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
                            tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${Number(ctx.parsed.y ?? ctx.parsed).toLocaleString()} unit` } }
                        },
                        animation: { duration: 600, easing: 'easeOutQuart' }
                    }
                });
            })
            .fail(function(){ toast('Gagal memuat data chart.', 'error'); });
    }

    function exportCsv() {
        if (!Array.isArray(lastFetchedTableData) || lastFetchedTableData.length === 0) { toast('Tidak ada data untuk diekspor.'); return; }
        const rows = [];
        const header = ['No','Heat/Lot No','No Drawing','Tipe Valve','Spare Part','Posisi','Qty Masuk','Qty Keluar','Stok Akhir'];
        rows.push(header.join(','));
        lastFetchedTableData.forEach((item, idx) => {
            const valve = sanitizeCsv(getValveNames(item));
            const row = [
                idx+1,
                sanitizeCsv(item.material?.heat_lot_no),
                sanitizeCsv(item.material?.no_drawing),
                valve,
                sanitizeCsv(item.material?.spare_part_name),
                sanitizeCsv(item.material?.rack_name),
                item.stock_awal ?? 0,
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

    // UTILITIES
    function animateCount(elSelector, toValue) {
        const el = document.querySelector(elSelector);
        if(!el) return;
        const start = Number(el.textContent.replace(/[^0-9]/g,'')) || 0;
        const end = Number(toValue) || 0;
        const duration = 500;
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

    function sanitizeCsv(v) { if (v === null || v === undefined) return ''; const s = String(v).replace(/"/g, '""'); return /[\n,",;]/.test(s) ? `"${s}"` : s; }
    function escapeHtml(text) { if (text === null || text === undefined) return ''; return String(text).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;'); }
</script>
@endpush

@endsection