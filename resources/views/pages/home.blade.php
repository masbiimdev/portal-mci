@extends('layouts.home')

@section('title', 'Home — Portal MCI')

@push('css')
    <style>
        /* Balanced blue & white theme */
        :root {
            --bg-1: #f3f8ff;
            --panel: #ffffff;
            --accent: #1e40af;
            --accent-soft: #60a5fa;
            --muted: #6b7280;
            --card-radius: 12px;
            --glass: rgba(255, 255, 255, 0.75);
            --shadow: 0 10px 30px rgba(20, 33, 60, 0.08);
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: linear-gradient(180deg, #eaf4ff 0%, var(--bg-1) 60%);
            color: #07203a;
        }

        .container {
            max-width: 1120px;
            margin: 28px auto;
            padding: 20px;
        }

        /* HERO */
        .hero { display:flex; gap:18px; align-items:center; background: linear-gradient(180deg, var(--panel), rgba(255,255,255,0.94)); border-radius:var(--card-radius); padding:18px; box-shadow:var(--shadow); }
        .hero .meta { flex:1; }
        .hero h1{ margin:0; color:var(--accent); font-weight:700; font-size:1.25rem; }
        .hero p{ margin:6px 0 0 0; color:var(--muted); }
        .kpis{ display:flex; gap:12px; margin-top:12px; flex-wrap:wrap; }
        .kpi{ background:linear-gradient(180deg, rgba(96,165,250,0.06), rgba(96,165,250,0.02)); padding:10px 14px; border-radius:10px; min-width:130px; color:var(--accent); border:1px solid rgba(37,99,235,0.06); }
        .kpi .label{ font-size:.85rem; color:var(--muted); } .kpi .value{ font-size:1.05rem; font-weight:800; margin-top:6px; color:#08306b; }

        /* layout */
        .layout { display:grid; grid-template-columns:1fr 360px; gap:16px; margin-top:18px; }
        @media (max-width:980px){ .layout{ grid-template-columns:1fr; } }
        .card{ background:var(--panel); border-radius:10px; padding:14px; box-shadow:var(--shadow); }

        /* ANNOUNCEMENTS */
        .ann-list{ display:grid; gap:10px; margin-top:10px; }
        .ann{ display:flex; gap:12px; padding:12px; border-radius:10px; background:linear-gradient(180deg,#fff,#fbfdff); border:1px solid rgba(30,64,175,0.04); transition: transform .12s ease, box-shadow .12s ease; }
        .ann:hover{ transform:translateY(-6px); box-shadow:0 12px 30px rgba(16,32,80,0.06); }
        .ann .avatar{ width:48px; height:48px; border-radius:8px; display:grid; place-items:center; background:linear-gradient(135deg,var(--accent-soft),var(--accent)); color:#fff; font-weight:700; }
        .ann .title{ font-weight:700; color:#06234a; margin:0; } .ann .excerpt{ margin:.35rem 0 0 0; color:var(--muted); font-size:.95rem; }
        .ann .meta{ margin-top:8px; display:flex; gap:8px; align-items:center; color:var(--muted); font-size:.82rem; }
        .badge-prio{ padding:4px 8px; border-radius:999px; font-weight:700; font-size:.78rem; }
        .prio-high{ background:#fee2e2; color:#991b1b; } .prio-medium{ background:#fff7ed; color:#92400e; } .prio-low{ background:#eef2ff; color:#1e3a8a; }

        /* Quick actions */
        .quick{ display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-top:8px; } @media (max-width:640px){ .quick{ grid-template-columns:repeat(2,1fr); } }
        .quick .item{ padding:12px; text-align:center; border-radius:10px; cursor:pointer; font-weight:700; background:transparent; border:1px solid rgba(30,64,175,0.06); color:#08306b; }
        .quick .item:hover{ background: linear-gradient(90deg, rgba(96,165,250,0.06), rgba(59,130,246,0.03)); transform:translateY(-6px); }

        /* Table */
        .table-wrap{ overflow:auto; margin-top:10px; } table{ width:100%; border-collapse:collapse; min-width:720px; }
        th, td{ padding:10px 12px; border-bottom:1px solid #eef6ff; text-align:left; vertical-align:middle; } thead th{ position:sticky; top:0; background:transparent; color:#08306b; font-weight:700; }
        .badge{ padding:6px 8px; border-radius:999px; font-weight:700; font-size:.82rem; } .badge.ok{ background:#ecfdf5; color:#027a3b; } .badge.proses{ background:#fffbeb; color:#9a5b03; } .badge.due{ background:#fff1f2; color:#9b1e1e; }

        /* Prayer times list */
        .pray-card .pray-row{ display:flex; justify-content:space-between; align-items:center; padding:6px 8px; border-radius:8px; }
        .pray-card .next{ background:linear-gradient(90deg,var(--accent-soft),var(--accent)); color:#fff; font-weight:700; }

        .muted{ color:var(--muted); } .center{text-align:center; } .toast{ position:fixed; right:18px; bottom:18px; background:var(--accent); color:#fff; padding:8px 12px; border-radius:8px; display:none; z-index:99; }

        @media (max-width:520px){ .hero{ flex-direction:column; align-items:stretch; } .kpis{ justify-content:flex-start; } }
    </style>
@endpush

@section('content')
    <div class="container">
        <!-- Hero -->
        <div class="hero">
            <div class="meta">
                <h1>Halo, {{ Auth::user()->name ?? 'Pengguna' }} — Portal MCI</h1>
                <p class="muted">Ringkasan cepat status kalibrasi, pengumuman penting, dan akses ke modul utama.</p>

                <div class="kpis" aria-hidden="false">
                    <div class="kpi"><div class="label">Total Item</div><div class="value">{{ number_format($totalTools ?? 0) }}</div></div>
                    <div class="kpi"><div class="label">Status OK</div><div class="value">{{ number_format($statusOk ?? 0) }}</div></div>
                    <div class="kpi"><div class="label">Sedang Kalibrasi</div><div class="value">{{ number_format($statusProses ?? 0) }}</div></div>
                    <div class="kpi"><div class="label">Due &lt; 15 hari</div><div class="value">{{ number_format($dueSoon ?? 0) }}</div></div>
                    <div class="kpi"><div class="label">Inventory Total</div><div class="value">{{ number_format($inventoryTotalCount ?? 0) }}</div></div>
                    <div class="kpi"><div class="label">Low Stock</div><div class="value">{{ number_format($lowStockCount ?? 0) }}</div></div>
                </div>
            </div>

            <div style="width:320px;">
                <div class="card center">
                    <div style="font-size:.85rem; color:var(--muted)">Waktu Lokal</div>
                    <div id="localTime" style="font-family:ui-monospace, monospace; font-weight:700; font-size:1.15rem;">--:--:--</div>
                    <div id="localDate" class="muted" style="font-size:.82rem; margin-top:6px;">—</div>

                    <div style="margin-top:10px; display:flex; justify-content:center; gap:8px; align-items:center;">
                        <div id="weatherIcon" style="font-size:20px;">⛅</div>
                        <div id="temp" style="font-weight:700;">--°C</div>
                    </div>
                    <div id="weatherDesc" class="muted" style="margin-top:8px; font-size:.9rem;">Memuat cuaca...</div>
                </div>
            </div>
        </div>

        <!-- MAIN LAYOUT -->
        <div class="layout" aria-live="polite">
            <!-- left -->
            <div>
                <!-- Announcements -->
                <div class="card">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <h3 style="margin:0">Pengumuman</h3>
                        <a href="{{ route('announcements.index') ?? '#' }}" class="muted" style="font-size:.9rem">Lihat Semua</a>
                    </div>

                    <div class="ann-list">
                        @forelse($announcements as $a)
                            @php
                                $prio = strtolower($a->priority ?? 'low');
                                $prioClass = $prio === 'high' ? 'prio-high' : ($prio === 'medium' ? 'prio-medium' : 'prio-low');
                                $author = optional($a->author)->name ?? 'Admin';
                                $excerpt = \Illuminate\Support\Str::limit(strip_tags($a->content), 160);
                                $date = \Carbon\Carbon::parse($a->created_at)->translatedFormat('d M Y');
                            @endphp

                            <article class="ann" role="article" aria-labelledby="ann-{{ $a->id }}">
                                <div class="avatar" aria-hidden="true">{{ strtoupper(substr($author, 0, 2)) }}</div>

                                <div class="body">
                                    <h4 id="ann-{{ $a->id }}" class="title">{{ $a->title }}</h4>
                                    <div class="excerpt">{{ $excerpt }}</div>

                                    <div class="meta">
                                        <span class="badge-prio {{ $prioClass }}">{{ strtoupper($prio) }}</span>
                                        <span>{{ $author }}</span>
                                        <span>•</span>
                                        <time datetime="{{ $a->created_at }}">{{ $date }}</time>
                                        <span style="margin-left:auto"><a href="{{ url('pengumuman/show/' . \Illuminate\Support\Str::slug($a->title)) }}" style="color:var(--accent); font-weight:700; text-decoration:none;">Lihat</a></span>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="muted">Belum ada pengumuman.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick actions -->
                <div class="card" style="margin-top:12px;">
                    <h4 style="margin:0 0 8px 0">Akses Cepat</h4>
                    <div class="quick">
                        <div class="item" onclick="location.href='/schedule'">📅 Jadwal</div>
                        <div class="item" onclick="location.href='/kalibrasi'">🛠 Kalibrasi</div>
                        <div class="item" onclick="location.href='/portal/inventory'">📦 Inventory</div>
                        <div class="item" onclick="location.href='/export'">⬇ Export</div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card" style="margin-top:12px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <h4 style="margin:0">Upcoming / Due</h4>
                        <div class="muted" style="font-size:.9rem">Terbaru</div>
                    </div>

                    <div class="table-wrap" style="margin-top:10px;">
                        <table role="table" aria-label="Daftar alat">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Merk</th>
                                    <th>Status</th>
                                    <th>Tanggal Kalibrasi</th>
                                    <th>Tanggal Kalibrasi Ulang</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="toolsTbody">
                                @forelse($tools->take(5) as $i => $t)
                                    @php
                                        $h = $t->latestHistory;
                                        $s = strtolower(optional($h)->status_kalibrasi ?? '-');
                                        $badge = $s === 'ok' ? 'ok' : ($s === 'proses' ? 'proses' : 'due');

                                        $toolJson = [
                                            'id' => $t->id,
                                            'nama' => $t->nama_alat,
                                            'merek' => $t->merek,
                                            'no_seri' => $t->no_seri,
                                            'history' => $h
                                                ? [
                                                    'status' => $h->status_kalibrasi,
                                                    'tgl_kalibrasi_ulang' => $h->tgl_kalibrasi_ulang ? $h->tgl_kalibrasi_ulang->format('d/m/Y') : null,
                                                    'keterangan' => $h->keterangan,
                                                ]
                                                : null,
                                        ];
                                    @endphp
                                    <tr data-tool='@json($toolJson)'>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ e($t->nama_alat) }}</td>
                                        <td>{{ e($t->merek ?? '-') }}</td>
                                        <td><span class="badge {{ $badge }}">{{ optional($h)->status_kalibrasi ?? '-' }}</span></td>
                                        <td>{{ optional($h)->tgl_kalibrasi ? $h->tgl_kalibrasi->format('d/m/Y') : '-' }}</td>
                                        <td>{{ optional($h)->tgl_kalibrasi_ulang ? $h->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}</td>
                                        <td><button class="action" data-action="detail">Detail</button></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="muted center">Tidak ada item.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- right -->
            <aside>
                <!-- PRAYER TIMES (GPS-based) -->
                <div class="card pray-card" style="margin-bottom:12px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <h4 style="margin:0">Jadwal Sholat — Lokasi Anda</h4>
                        <div>
                            <button id="prayerRefreshBtn" class="action" title="Refresh" style="padding:6px 8px;border-radius:8px;border:1px solid rgba(2,6,23,0.06);background:transparent;">↻</button>
                        </div>
                    </div>

                    <div style="margin-top:10px;">
                        <div id="prayerLocation" class="muted" style="font-size:.9rem; margin-bottom:8px;">Lokasi: —</div>
                        <div id="prayerDate" class="muted" style="font-size:.9rem; margin-bottom:8px;">—</div>
                        <div id="prayerList" style="display:flex; flex-direction:column; gap:6px;">
                            <div class="pray-row" id="row-Fajr"><span>Fajr</span><span id="pray-Fajr">--:--</span></div>
                            <div class="pray-row" id="row-Sunrise"><span>Sunrise</span><span id="pray-Sunrise">--:--</span></div>
                            <div class="pray-row" id="row-Dhuhr"><span>Dhuhr</span><span id="pray-Dhuhr">--:--</span></div>
                            <div class="pray-row" id="row-Asr"><span>Asr</span><span id="pray-Asr">--:--</span></div>
                            <div class="pray-row" id="row-Maghrib"><span>Maghrib</span><span id="pray-Maghrib">--:--</span></div>
                            <div class="pray-row" id="row-Isha"><span>Isha</span><span id="pray-Isha">--:--</span></div>
                        </div>

                        <div id="prayerNext" style="margin-top:10px; display:flex; align-items:center; gap:8px;">
                            <div class="muted">Sholat berikutnya:</div>
                            <div id="prayerNextLabel" class="pray-next" style="font-weight:700">—</div>
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-bottom:12px;">
                    <h4 style="margin:0 0 8px 0">Ringkasan</h4>
                    <div style="display:flex; gap:12px; align-items:center;">
                        <div style="width:180px; height:160px;">
                            <canvas id="statusPie" style="width:100%; height:100%;"></canvas>
                        </div>
                        <div style="flex:1;" class="summary-legend">
                            <div class="muted" style="display:flex; justify-content:space-between;"><span>OK</span><strong id="legendOk">{{ $pieData['ok'] ?? 0 }}</strong></div>
                            <div class="muted" style="display:flex; justify-content:space-between;"><span>Proses</span><strong id="legendProses">{{ $pieData['proses'] ?? 0 }}</strong></div>
                            <div class="muted" style="display:flex; justify-content:space-between;"><span>Penjadwalan</span><strong id="legendDue">{{ $pieData['due'] ?? 0 }}</strong></div>
                            <div style="margin-top:12px;"><a href="/kalibrasi" style="display:inline-block;background:var(--accent); color:#fff; padding:8px 12px; border-radius:8px; text-decoration:none; font-weight:700;">Lihat Semua</a></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h4 style="margin:0 0 8px 0">Tren (7 hari)</h4>
                    <div style="height:160px;">
                        <canvas id="trendLine" style="width:100%; height:100%;"></canvas>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- modal & toast -->
    <div id="detailModal" class="modal" role="dialog" aria-modal="true">
        <div class="backdrop" aria-hidden="true"></div>
        <div class="modal-card" role="document">
            <header style="display:flex; justify-content:space-between; align-items:center;">
                <h3 id="modalTitle" style="margin:0">Detail</h3>
                <button id="modalClose" aria-label="Tutup">✕</button>
            </header>
            <div id="modalBody" style="margin-top:12px;"></div>
            <div style="margin-top:12px; text-align:right;"><button id="modalClose2" class="action">Tutup</button></div>
        </div>
    </div>

    <div id="mciToast" class="toast" role="status" aria-live="polite"></div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Server data
        window._tools = @json($toolsData ?? []);
        window._pieData = @json($pieData ?? ['ok' => 0, 'proses' => 0, 'due' => 0]);
        window._trend = @json($trend ?? ['labels' => [], 'values' => []]);
        window._stockTrend = @json($stockTrend ?? []);

        (function () {
            // Time update
            function updateTime() {
                const now = new Date();
                const tEl = document.getElementById('localTime');
                const dEl = document.getElementById('localDate');
                if (tEl) tEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
                if (dEl) dEl.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
            }
            updateTime();
            setInterval(updateTime, 1000);

            // Weather (fallback)
            function renderWeather(data) {
                const iconEl = document.getElementById('weatherIcon'),
                    tempEl = document.getElementById('temp'),
                    descEl = document.getElementById('weatherDesc');
                if (!tempEl || !descEl) return;
                if (!data || !data.current_weather) {
                    tempEl.textContent = '--°C';
                    descEl.textContent = 'Cuaca tidak tersedia';
                    return;
                }
                const cw = data.current_weather;
                tempEl.textContent = Math.round(cw.temperature) + '°C';
                const code = cw.weathercode;
                const icon = (code === 0) ? '☀️' : (code <= 3 ? '⛅' : (code <= 48 ? '🌫️' : (code <= 77 ? '🌧️' : '🌦️')));
                if (iconEl) iconEl.textContent = icon;
                descEl.textContent = (code === 0 ? 'Cerah' : 'Berawan / Hujan ringan');
            }
            function fetchWeather(lat, lon) {
                fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`)
                    .then(r => r.json()).then(renderWeather).catch(() => renderWeather(null));
            }
            // Try to fetch weather from user location; fallback Jakarta
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(p => fetchWeather(p.coords.latitude, p.coords.longitude), () => fetchWeather(-6.2088, 106.8456), { timeout: 5000 });
            } else fetchWeather(-6.2088, 106.8456);

            // --- Prayer times (GPS-based using Aladhan) ---
            function padZero(n) { return n.toString().padStart(2, '0'); }

            function parseTimeToDate(timeStr) {
                const m = timeStr.match(/(\d{1,2}):(\d{2})/);
                if (!m) return null;
                const h = parseInt(m[1], 10);
                const min = parseInt(m[2], 10);
                const d = new Date();
                d.setHours(h, min, 0, 0);
                return d;
            }

            function getNextPrayerLabel(timings) {
                const order = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                const now = new Date();
                for (const name of order) {
                    const t = parseTimeToDate(timings[name] || '');
                    if (t && t.getTime() > now.getTime()) return name;
                }
                return 'Fajr';
            }

            function displayPrayerTimes(timings, dateReadable, locationLabel) {
                document.getElementById('prayerDate').textContent = dateReadable || '';
                document.getElementById('prayerLocation').textContent = locationLabel || '';
                const keys = ['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                keys.forEach(k => {
                    const el = document.getElementById('pray-' + k);
                    if (el) el.textContent = (timings[k] || '--:--').replace(/\s*\(.*\)$/, '');
                });

                const next = getNextPrayerLabel(timings);
                document.getElementById('prayerNextLabel').textContent = next + ' — ' + (timings[next] || '--:--').replace(/\s*\(.*\)$/, '');

                keys.forEach(k => {
                    const row = document.getElementById('row-' + k);
                    if (!row) return;
                    row.classList.toggle('next', k === next);
                });
            }

            async function fetchPrayerTimesByCoords(lat, lon) {
                const url = `https://api.aladhan.com/v1/timings?latitude=${lat}&longitude=${lon}&method=2`;
                try {
                    const res = await fetch(url);
                    const json = await res.json();
                    if (json && json.data && json.data.timings) {
                        const timings = json.data.timings;
                        const dateReadable = json.data.date.readable || new Date().toLocaleDateString('id-ID');
                        // Try reverse geocode for a friendly location label (OpenStreetMap Nominatim)
                        let locationLabel = `${lat.toFixed(3)}, ${lon.toFixed(3)}`;
                        try {
                            const r = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`, { headers: { 'Accept': 'application/json' } });
                            if (r.ok) {
                                const loc = await r.json();
                                if (loc && loc.address) {
                                    const parts = [];
                                    if (loc.address.city) parts.push(loc.address.city);
                                    else if (loc.address.town) parts.push(loc.address.town);
                                    else if (loc.address.village) parts.push(loc.address.village);
                                    if (loc.address.state) parts.push(loc.address.state);
                                    if (loc.address.country) parts.push(loc.address.country);
                                    if (parts.length) locationLabel = parts.join(', ');
                                }
                            }
                        } catch (err) {
                            // ignore reverse geocode errors
                        }
                        displayPrayerTimes(timings, dateReadable, locationLabel);
                    } else {
                        displayPrayerTimes({}, '', '');
                    }
                } catch (err) {
                    console.warn('prayer fetch err', err);
                    displayPrayerTimes({}, '', '');
                }
            }

            async function initPrayerTimes() {
                // Try geolocation first
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(async (pos) => {
                        const lat = pos.coords.latitude;
                        const lon = pos.coords.longitude;
                        // fetch weather for this location too
                        fetchWeather(lat, lon);
                        await fetchPrayerTimesByCoords(lat, lon);
                    }, async (err) => {
                        console.warn('geo failed', err);
                        // fallback to Bekasi coords
                        await fetchPrayerTimesByCoords(-6.2383, 106.9892); // Bekasi center
                        fetchWeather(-6.2383, 106.9892);
                    }, { timeout: 8000, maximumAge: 60 * 1000 });
                } else {
                    // no geolocation -> fallback Bekasi
                    await fetchPrayerTimesByCoords(-6.2383, 106.9892);
                    fetchWeather(-6.2383, 106.9892);
                }
            }

            // Refresh button
            document.getElementById('prayerRefreshBtn')?.addEventListener('click', () => {
                initPrayerTimes();
                showToast('Memperbarui jadwal sholat berdasarkan lokasi Anda...');
            });

            // initial
            initPrayerTimes();

            // Charts (unchanged)
            function initCharts() {
                const pd = window._pieData || { ok: 0, proses: 0, due: 0 };
                const pieEl = document.getElementById('statusPie');
                if (pieEl && window.Chart) {
                    const ctx = pieEl.getContext('2d');
                    if (pieEl.__chart) pieEl.__chart.destroy();
                    const centerText = {
                        id: 'centerText',
                        afterDraw(chart) {
                            const total = chart.data.datasets[0].data.reduce((a, b) => a + (b || 0), 0) || 0;
                            const ctx = chart.ctx;
                            const x = (chart.chartArea.left + chart.chartArea.right) / 2;
                            const y = (chart.chartArea.top + chart.chartArea.bottom) / 2;
                            ctx.save();
                            ctx.fillStyle = '#08306b';
                            ctx.font = '600 16px Inter, system-ui, Arial';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillText(total, x, y - 6);
                            ctx.font = '500 11px Inter, system-ui, Arial';
                            ctx.fillStyle = '#6b7280';
                            ctx.fillText('Total', x, y + 14);
                            ctx.restore();
                        }
                    };
                    pieEl.__chart = new Chart(ctx, {
                        type: 'doughnut',
                        data: { labels: ['OK', 'Proses', 'Due'], datasets: [{ data: [pd.ok || 0, pd.proses || 0, pd.due || 0], backgroundColor: ['#16a34a', '#f59e0b', '#dc2626'] }] },
                        options: { responsive: true, maintainAspectRatio: false, cutout: '60%', plugins: { legend: { display: false } } },
                        plugins: [centerText]
                    });
                }

                const labels = window._trend.labels || [];
                const values = window._trend.values || [];
                const trendEl = document.getElementById('trendLine');
                if (trendEl && window.Chart) {
                    const ctx2 = trendEl.getContext('2d');
                    if (trendEl.__chart) trendEl.__chart.destroy();
                    const grad = ctx2.createLinearGradient(0, 0, 0, 180);
                    grad.addColorStop(0, 'rgba(96,165,250,0.12)');
                    grad.addColorStop(1, 'rgba(96,165,250,0.02)');
                    trendEl.__chart = new Chart(ctx2, {
                        type: 'line',
                        data: { labels: labels, datasets: [{ label: 'Trend', data: values, fill: true, backgroundColor: grad, borderColor: '#60a5fa', tension: 0.32 }] },
                        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
                    });
                }
            }
            initCharts();

            // Modal + utilities (unchanged)
            const tbody = document.getElementById('toolsTbody');
            const modal = document.getElementById('detailModal');
            const modalBody = document.getElementById('modalBody');
            const modalClose = document.getElementById('modalClose');
            const modalClose2 = document.getElementById('modalClose2');
            const toast = document.getElementById('mciToast');

            function showToast(msg, ms = 1800) { if (!toast) return; toast.textContent = msg; toast.style.display = 'block'; setTimeout(() => toast.style.display = 'none', ms); }

            tbody?.addEventListener('click', e => {
                const btn = e.target.closest('[data-action="detail"], .action');
                if (!btn) return;
                const tr = btn.closest('tr[data-tool]');
                if (!tr) return;
                const data = JSON.parse(tr.getAttribute('data-tool') || '{}');
                openModal(data);
            });

            function openModal(data) {
                document.getElementById('modalTitle').textContent = data.nama || 'Detail';
                modalBody.innerHTML = `
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                        <div><strong>Nama</strong><div class="muted">${escapeHtml(data.nama || '-')}</div></div>
                        <div><strong>Merk</strong><div class="muted">${escapeHtml(data.merek || '-')}</div></div>
                        <div><strong>No. Seri</strong><div class="muted">${escapeHtml(data.no_seri || '-')}</div></div>
                        <div><strong>Status</strong><div class="muted">${escapeHtml(data.history?.status || '-')}</div></div>
                        <div><strong>Tgl Ulang</strong><div class="muted">${escapeHtml(data.history?.tgl_kalibrasi_ulang || '-')}</div></div>
                        <div style="grid-column:1/-1"><strong>Keterangan</strong><div class="muted">${escapeHtml(data.history?.keterangan || '-')}</div></div>
                    </div>`;
                modal.classList.add('show');
            }
            function closeModal() { modal.classList.remove('show'); }
            modalClose?.addEventListener('click', closeModal);
            modalClose2?.addEventListener('click', closeModal);
            modal?.addEventListener('click', e => { if (e.target === modal) closeModal(); });
            document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

            function escapeHtml(s) { if (s === null || s === undefined) return ''; return String(s).replace(/[&<>"'`]/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;', '`': '&#96;' }[m])); }
        })();
    </script>
@endpush