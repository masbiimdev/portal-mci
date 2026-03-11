@extends('layouts.home')

@section('title', 'Home — Portal MCI')

@push('css')
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700;800&display=swap"
        rel="stylesheet">
    <style>
        /* ============== CSS VARIABLES (MODERN COLOR PALETTE) ============== */
        :root {
            --bg-main: #f4f7fb;
            --panel: #ffffff;

            --primary: #1d4ed8;
            --primary-hover: #1e40af;
            --primary-soft: #eff6ff;
            --primary-glow: rgba(29, 78, 216, 0.15);

            --accent: #4f46e5;
            --accent-glow: rgba(79, 70, 229, 0.3);

            --text-dark: #0f172a;
            --text-muted: #64748b;

            --border: #e2e8f0;
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;

            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.02), 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.025);
            --shadow-float: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);

            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        /* ============== BASE STYLES ============== */
        * {
            box-sizing: border-box;
        }

        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            background-image: radial-gradient(at 0% 0%, var(--primary-glow) 0px, transparent 50%);
            background-attachment: fixed;
        }

        .container {
            max-width: 1240px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* ============== HERO SECTION & HEADER ============== */
        .header-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .hero {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .hero::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
            opacity: 0.3;
            filter: blur(40px);
        }

        .hero h1 {
            margin: 0;
            font-weight: 800;
            font-size: 2rem;
            letter-spacing: -0.02em;
            z-index: 1;
        }

        .hero p {
            margin: 0.5rem 0 2rem 0;
            color: #94a3b8;
            font-size: 1.05rem;
            z-index: 1;
        }

        .kpis {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 1rem;
            z-index: 1;
        }

        .kpi {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.25rem;
            border-radius: var(--radius-md);
            transition: transform 0.2s, background 0.2s;
        }

        .kpi:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.1);
        }

        .kpi .label {
            font-size: 0.75rem;
            color: #cbd5e1;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .kpi .value {
            font-size: 1.75rem;
            font-weight: 800;
            margin-top: 0.25rem;
            color: #ffffff;
            font-family: 'JetBrains Mono', monospace;
        }

        /* ============== WEATHER & TIME CARD ============== */
        .weather-time-card {
            background: var(--panel);
            border-radius: var(--radius-lg);
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .time-display {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 800;
            font-size: 2.5rem;
            color: var(--primary);
            line-height: 1;
            margin: 0.5rem 0;
            text-shadow: 0 2px 10px var(--primary-glow);
        }

        .weather-widget {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: center;
            gap: 15px;
            align-items: center;
            width: 100%;
        }

        .weather-widget .icon {
            font-size: 2.5rem;
            line-height: 1;
        }

        .weather-info {
            text-align: left;
        }

        .weather-widget .temp {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .weather-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ============== MAIN LAYOUT GRID ============== */
        .layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.5rem;
        }

        /* ============== DOCUMENT SPECIAL CARD ============== */
        .document-card {
            background: linear-gradient(135deg, var(--accent) 0%, #7c3aed 100%);
            color: white;
            border-radius: var(--radius-lg);
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 25px var(--accent-glow);
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .document-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px var(--accent-glow);
        }

        .document-card::before {
            content: '📄';
            position: absolute;
            right: -10px;
            bottom: -30px;
            font-size: 10rem;
            opacity: 0.15;
            transform: rotate(-15deg);
            pointer-events: none;
        }

        .document-card-content {
            position: relative;
            z-index: 2;
        }

        .document-card-content h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .document-card-content p {
            margin: 0 0 1.25rem 0;
            opacity: 0.9;
            font-size: 0.95rem;
            max-width: 80%;
        }

        .btn-document {
            background: white;
            color: var(--accent);
            padding: 0.6rem 1.5rem;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-document:hover {
            background: #f8fafc;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
        }

        /* ============== REGULAR CARDS & QUICK ACTIONS ============== */
        .card {
            background: var(--panel);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
            transition: box-shadow 0.3s ease;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .card-header h3 {
            margin: 0;
            color: var(--text-dark);
            font-weight: 800;
            font-size: 1.15rem;
            letter-spacing: -0.01em;
        }

        .card-header a {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            padding: 0.4rem 0.8rem;
            border-radius: var(--radius-sm);
            background: var(--primary-soft);
            transition: all 0.2s;
        }

        .card-header a:hover {
            background: var(--primary);
            color: white;
        }

        .quick {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .quick .item {
            padding: 1.25rem 1rem;
            text-align: center;
            border-radius: var(--radius-md);
            cursor: pointer;
            font-weight: 600;
            background: var(--panel);
            border: 1px solid var(--border);
            color: var(--text-dark);
            font-size: 0.85rem;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }

        .quick .item:hover {
            background: var(--primary-soft);
            border-color: var(--primary);
            transform: translateY(-4px);
            color: var(--primary-hover);
            box-shadow: var(--shadow-md);
        }

        .quick .icon {
            font-size: 1.75rem;
        }

        /* ============== ANNOUNCEMENTS ============== */
        .ann-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }

        .ann {
            display: flex;
            gap: 1rem;
            padding: 1.25rem;
            border-radius: var(--radius-md);
            background: #ffffff;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .ann::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary);
            transition: width 0.2s ease;
        }

        .ann:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: #cbd5e1;
        }

        .ann.prio-high::before {
            background: var(--danger);
        }

        .ann.prio-medium::before {
            background: var(--warning);
        }

        .ann.prio-low::before {
            background: var(--text-muted);
        }

        .ann .avatar {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: var(--primary-soft);
            color: var(--primary);
            font-weight: 800;
            font-size: 1.1rem;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .ann .body {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .ann .title {
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.25rem 0;
            font-size: 1.05rem;
            line-height: 1.3;
        }

        .ann .excerpt {
            margin: 0;
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ann .meta {
            margin-top: 0.75rem;
            display: flex;
            gap: 0.75rem;
            align-items: center;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-prio {
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
            font-weight: 800;
            font-size: 0.65rem;
            text-transform: uppercase;
        }

        .prio-high .badge-prio {
            background: #fee2e2;
            color: #991b1b;
        }

        .prio-medium .badge-prio {
            background: #fef9c3;
            color: #854d0e;
        }

        .prio-low .badge-prio {
            background: #f1f5f9;
            color: #475569;
        }

        /* ============== TABLE STYLING ============== */
        .table-wrap {
            overflow-x: auto;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            background: white;
            min-width: 600px;
        }

        th,
        td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            text-align: left;
            vertical-align: middle;
        }

        thead th {
            background: #f8fafc;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            display: inline-block;
            white-space: nowrap;
        }

        .badge.ok {
            background: #dcfce7;
            color: #065f46;
        }

        .badge.proses {
            background: #fef9c3;
            color: #854d0e;
        }

        .badge.due {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-action {
            padding: 0.4rem 1rem;
            border: none;
            background: var(--primary-soft);
            color: var(--primary);
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-action:hover {
            background: var(--primary);
            color: white;
        }

        /* ============== PRAYER WIDGET ============== */
        .prayer-head .action {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.25rem;
            transition: transform 0.3s;
        }

        .prayer-head .action:hover {
            transform: rotate(180deg);
        }

        .prayer-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            background: #f8fafc;
            border-radius: var(--radius-sm);
        }

        .next-prayer-block {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            color: white;
            text-align: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 10px 15px -3px var(--primary-glow);
            position: relative;
            overflow: hidden;
        }

        .np-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            opacity: 0.8;
            letter-spacing: 0.05em;
        }

        .np-name {
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0.25rem 0;
            letter-spacing: -0.01em;
        }

        .np-time {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1;
        }

        .np-countdown {
            font-size: 0.85rem;
            font-weight: 500;
            opacity: 0.9;
            margin-top: 0.5rem;
        }

        .np-progress {
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 1rem;
        }

        .np-bar {
            height: 100%;
            width: 0%;
            background: #ffffff;
            border-radius: 4px;
            transition: width 1s linear;
        }

        .np-bar.warning {
            background: #fca5a5;
            box-shadow: 0 0 10px #ef4444;
        }

        .prayer-list {
            display: grid;
            gap: 0.5rem;
        }

        .pray-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            background: #f8fafc;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .pray-row:hover {
            background: white;
            border-color: var(--border);
            box-shadow: var(--shadow-sm);
        }

        .pray-row.next {
            background: var(--primary-soft);
            color: var(--primary-hover);
            border-color: var(--primary-glow);
            font-weight: 800;
        }

        .pray-row.next .pray-time {
            color: var(--primary);
        }

        .pray-time {
            font-family: 'JetBrains Mono', monospace;
            color: var(--text-muted);
        }

        /* ============== MODAL & TOAST ============== */
        #detailModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 9999;
            display: none;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            justify-content: center;
            align-items: center;
        }

        #detailModal.show {
            display: flex;
            opacity: 1;
            pointer-events: auto;
        }

        #detailModal .backdrop {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1;
        }

        #detailModal .modal-card {
            position: relative;
            z-index: 2;
            background: var(--panel);
            width: 90%;
            max-width: 450px;
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-float);
            transform: translateY(20px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        #detailModal.show .modal-card {
            transform: translateY(0) scale(1);
        }

        #modalBody {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin: 1.5rem 0;
        }

        #modalBody>div {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        #modalBody strong {
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        #modalBody .muted {
            color: var(--text-dark);
            font-size: 0.95rem;
            font-weight: 600;
            word-break: break-word;
        }

        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: var(--text-dark);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.9rem;
            z-index: 10000;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-float);
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* ============== RESPONSIVE (HP) ============== */
        @media (max-width: 1024px) {
            .container {
                padding: 0 1rem;
                margin: 1rem auto;
            }

            .header-grid,
            .layout {
                grid-template-columns: 1fr;
            }

            .weather-time-card {
                padding: 1.5rem;
            }

            .hero {
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 1.5rem;
                text-align: center;
            }

            .hero::after {
                display: none;
            }

            .kpis {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }

            .document-card {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem;
            }

            .document-card::before {
                font-size: 6rem;
                bottom: -20px;
                right: -10px;
            }

            .document-card-content p {
                max-width: 100%;
            }

            .quick {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }

            .quick .item {
                padding: 1rem 0.5rem;
            }

            .ann {
                flex-direction: column;
                gap: 0.75rem;
                align-items: flex-start;
            }

            .ann .avatar {
                width: 40px;
                height: 40px;
                min-width: 40px;
                font-size: 1rem;
            }

            #modalBody {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            th,
            td {
                padding: 0.75rem 1rem;
            }

            .card {
                padding: 1.25rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">

        <div class="header-grid">
            <div class="hero">
                <h1>Halo, {{ Auth::user()->name ?? 'Pengguna' }}</h1>
                <p>Ringkasan sistem, kalibrasi, dan inventaris MCI hari ini.</p>

                <div class="kpis" aria-label="Key Performance Indicators">
                    <div class="kpi" title="Total jumlah alat dalam sistem">
                        <div class="label">Total Item</div>
                        <div class="value">{{ number_format($totalTools ?? 0) }}</div>
                    </div>
                    <div class="kpi" title="Alat dengan status kalibrasi OK">
                        <div class="label">Status OK</div>
                        <div class="value" style="color: #6ee7b7;">{{ number_format($statusOk ?? 0) }}</div>
                    </div>
                    <div class="kpi" title="Alat dengan jadwal kalibrasi < 15 hari">
                        <div class="label">Due Soon</div>
                        <div class="value" style="color: #fca5a5;">{{ number_format($dueSoon ?? 0) }}</div>
                    </div>
                    <div class="kpi" title="Jumlah item dengan stok rendah">
                        <div class="label">Low Stock</div>
                        <div class="value" style="color: #fcd34d;">{{ number_format($lowStockCount ?? 0) }}</div>
                    </div>
                </div>
            </div>

            <div class="weather-time-card">
                <div class="muted"
                    style="font-size:0.85rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em;">Waktu Lokal
                </div>
                <div id="localTime" class="time-display">--:--:--</div>
                <div id="localDate" class="muted" style="font-weight:500; font-size:0.9rem;">Mendeteksi tanggal...</div>

                <div class="weather-widget">
                    <div id="weatherIcon" class="icon">⛅</div>
                    <div class="weather-info">
                        <div id="temp" class="temp">--°C</div>
                        <div id="weatherDesc" class="weather-desc">Memuat cuaca...</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="layout" aria-live="polite">

            <div>
                <div class="document-card">
                    <div class="document-card-content">
                        <h3>Pusat Dokumen & Laporan</h3>
                        <p>Akses terpusat ke seluruh dokumen inventaris, form standar operasional, dan sertifikat kalibrasi
                            MCI.</p>
                        <button onclick="location.href='/documents'" class="btn-document">
                            Buka Dokumen <span>→</span>
                        </button>
                    </div>
                </div>

                <div class="card" style="padding-bottom: 24px;">
                    <div class="card-header">
                        <h3>Akses Cepat</h3>
                    </div>
                    <div class="quick">
                        <div class="item" onclick="location.href='/schedule'" role="button" tabindex="0">
                            <span class="icon">📅</span> <span>Jadwal</span>
                        </div>
                        <div class="item" onclick="location.href='/kalibrasi'" role="button" tabindex="0">
                            <span class="icon">🛠</span> <span>Kalibrasi</span>
                        </div>
                        <div class="item" onclick="location.href='/portal/inventory'" role="button" tabindex="0">
                            <span class="icon">📦</span> <span>Inventory</span>
                        </div>
                        <div class="item" onclick="location.href='/export'" role="button" tabindex="0">
                            <span class="icon">⬇</span> <span>Export</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Pengumuman Internal</h3>
                        <a href="{{ route('announcements.index') ?? '#' }}">Semua Pengumuman</a>
                    </div>
                    <div class="ann-list">
                        @forelse($announcements as $a)
                            @php
                                $prio = strtolower($a->priority ?? 'low');
                                $prioClass =
                                    $prio === 'high' ? 'prio-high' : ($prio === 'medium' ? 'prio-medium' : 'prio-low');
                                $author = optional($a->author)->name ?? 'Admin';
                                $excerpt = \Illuminate\Support\Str::limit(strip_tags($a->content), 80);
                            @endphp
                            <article class="ann {{ $prioClass }}"
                                onclick="window.location='{{ url('pengumuman/show/' . \Illuminate\Support\Str::slug($a->title)) }}'">
                                <div class="avatar">{{ strtoupper(substr($author, 0, 1)) }}</div>
                                <div class="body">
                                    <h4 class="title">{{ $a->title }}</h4>
                                    <div class="excerpt">{{ $excerpt }}</div>
                                    <div class="meta">
                                        <span class="badge-prio">{{ strtoupper($prio) }}</span>
                                        <span>{{ $a->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div
                                style="text-align:center; padding:3rem 1rem; color:var(--text-muted); width:100%; border: 1px dashed var(--border); border-radius: var(--radius-md);">
                                <span style="font-size: 2rem; display:block; margin-bottom: 10px;">📭</span>
                                <span style="font-weight: 500;">Belum ada pengumuman terbaru hari ini.</span>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3>Kalibrasi Mendatang</h3>
                            <div style="font-size:0.8rem; color:var(--text-muted); margin-top:2px;">Alat yang perlu
                                diperhatikan</div>
                        </div>
                    </div>

                    <div class="table-wrap">
                        <table role="table">
                            <thead>
                                <tr>
                                    <th>Info Alat</th>
                                    <th>Status</th>
                                    <th>Tgl Kalibrasi</th>
                                    <th>Due Date</th>
                                    <th style="text-align:right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="toolsTbody">
                                @forelse($tools->take(6) as $i => $t)
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
                                                    'tgl_kalibrasi_ulang' => $h->tgl_kalibrasi_ulang
                                                        ? $h->tgl_kalibrasi_ulang->format('d/m/Y')
                                                        : null,
                                                    'keterangan' => $h->keterangan,
                                                ]
                                                : null,
                                        ];
                                    @endphp
                                    <tr data-tool='@json($toolJson)'>
                                        <td>
                                            <div style="font-weight:700; color:var(--text-dark);">{{ e($t->nama_alat) }}
                                            </div>
                                            <div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">SN:
                                                {{ e($t->no_seri ?? '-') }}</div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $badge }}">{{ optional($h)->status_kalibrasi ?? '-' }}</span>
                                        </td>
                                        <td style="font-family:'JetBrains Mono', monospace; font-size:0.85rem;">
                                            {{ optional($h)->tgl_kalibrasi ? $h->tgl_kalibrasi->format('d/m/Y') : '-' }}
                                        </td>
                                        <td
                                            style="font-family:'JetBrains Mono', monospace; font-size:0.85rem; font-weight:700;">
                                            {{ optional($h)->tgl_kalibrasi_ulang ? $h->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}
                                        </td>
                                        <td style="text-align:right">
                                            <button class="btn-action" data-action="detail">Detail</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            style="text-align:center; padding: 2.5rem; color: var(--text-muted);">
                                            Tidak ada data jadwal kalibrasi saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="sidebar">
                <div class="card pray-card" style="position: sticky; top: 20px;">
                    <div class="card-header" style="margin-bottom:1rem; padding-bottom:0.5rem; border-bottom:none;">
                        <h3 style="display:flex; align-items:center; gap:8px;"><span style="font-size:1.3rem;">🕋</span>
                            Jadwal Sholat</h3>
                        <button id="prayerRefreshBtn" class="action"
                            style="padding:0.3rem 0.5rem; background:none; border:none; font-size:1.1rem;" title="Refresh"
                            aria-label="Refresh">↻</button>
                    </div>

                    <div class="prayer-info">
                        <span id="prayerLocation">Mendeteksi lokasi...</span>
                        <span id="prayerHijri" style="text-align:right;">—</span>
                    </div>

                    <div class="next-prayer-block">
                        <div class="np-label">Mendekati Waktu</div>
                        <div class="np-name" id="prayerNextLabel">—</div>
                        <div class="np-time" id="nextPrayerTime">--:--</div>
                        <div class="np-countdown" id="nextPrayerCountdown">Menghitung...</div>
                        <div class="np-progress">
                            <div class="np-bar" id="countdownBar"></div>
                        </div>
                    </div>

                    <div class="prayer-list">
                        <div class="pray-row" id="row-Imsak"><span class="pray-name">⏰ Imsak</span><span
                                class="pray-time" id="pray-Imsak">--:--</span></div>
                        <div class="pray-row" id="row-Fajr"><span class="pray-name">🌅 Subuh</span><span
                                class="pray-time" id="pray-Fajr">--:--</span></div>
                        <div class="pray-row" id="row-Sunrise"><span class="pray-name">🌄 Terbit</span><span
                                class="pray-time" id="pray-Sunrise">--:--</span></div>
                        <div class="pray-row" id="row-Dhuhr"><span class="pray-name">☀️ Dzuhur</span><span
                                class="pray-time" id="pray-Dhuhr">--:--</span></div>
                        <div class="pray-row" id="row-Asr"><span class="pray-name">🏜️ Ashar</span><span
                                class="pray-time" id="pray-Asr">--:--</span></div>
                        <div class="pray-row" id="row-Maghrib"><span class="pray-name">🌇 Maghrib</span><span
                                class="pray-time" id="pray-Maghrib">--:--</span></div>
                        <div class="pray-row" id="row-Isha"><span class="pray-name">🌃 Isya</span><span
                                class="pray-time" id="pray-Isha">--:--</span></div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <div id="detailModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="backdrop" role="button" tabindex="-1"></div>
        <div class="modal-card">
            <header
                style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #f1f5f9; padding-bottom:1rem; margin-bottom:1rem;">
                <h3 id="modalTitle" style="margin:0; font-weight:800; font-size:1.25rem; color:var(--text-dark);">Detail
                </h3>
                <button id="modalClose"
                    style="background:var(--bg-main); border:none; width:32px; height:32px; border-radius:50%; cursor:pointer; color:var(--text-muted); font-weight:bold;">✕</button>
            </header>
            <div id="modalBody"></div>
            <div style="margin-top:1.5rem; text-align:right; border-top:1px solid #f1f5f9; padding-top:1.5rem;">
                <button id="modalClose2" class="btn-action">Tutup</button>
            </div>
        </div>
    </div>
    <div id="mciToast" class="toast" role="status" aria-live="polite"></div>
@endsection

@push('js')
    <script>
        'use strict';

        // ========== PRAYER TIMES MODULE ==========
        const PrayerTimes = {
            countdownInterval: null,
            currentTimings: {},
            currentNextPrayer: null,
            dom: {},
            init() {
                this.cacheDom();
                this.bindEvents();
                this.fetchPrayerTimes();
                this.countdownInterval = setInterval(() => this.updateCountdown(), 1000);
            },
            cacheDom() {
                this.dom = {
                    refreshBtn: document.getElementById('prayerRefreshBtn'),
                    location: document.getElementById('prayerLocation'),
                    hijri: document.getElementById('prayerHijri'),
                    nextLabel: document.getElementById('prayerNextLabel'),
                    nextTime: document.getElementById('nextPrayerTime'),
                    countdown: document.getElementById('nextPrayerCountdown'),
                    progressBar: document.getElementById('countdownBar')
                };
            },
            bindEvents() {
                this.dom.refreshBtn?.addEventListener('click', () => {
                    this.fetchPrayerTimes();
                    if (window.AppDashboard?.showToast) AppDashboard.showToast('Memperbarui jadwal sholat...');
                });
            },
            async fetchPrayerTimes() {
                // Default location (Jakarta)
                const defaultLat = -6.200000;
                const defaultLon = 106.816666;

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (pos) => this.getPrayerData(pos.coords.latitude, pos.coords.longitude),
                        (err) => {
                            console.warn('Geolocation ditolak/gagal. Memuat data default.', err);
                            this.getPrayerData(defaultLat, defaultLon);
                        }, {
                            timeout: 8000,
                            maximumAge: 60000
                        }
                    );
                } else {
                    this.getPrayerData(defaultLat, defaultLon);
                }
            },
            async getPrayerData(lat, lon) {
                try {
                    const res = await fetch(
                        `https://api.aladhan.com/v1/timings?latitude=${lat}&longitude=${lon}&method=2`);
                    const json = await res.json();
                    if (!json?.data?.timings) return;

                    const timings = json.data.timings;
                    const hijriInfo = json.data.date.hijri || null;
                    let locationLabel = `${lat.toFixed(3)}, ${lon.toFixed(3)}`;

                    try {
                        const r = await fetch(
                            `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`);
                        if (r.ok) {
                            const loc = await r.json();
                            if (loc?.address) {
                                const parts = [];
                                if (loc.address.city) parts.push(loc.address.city);
                                else if (loc.address.town) parts.push(loc.address.town);
                                if (loc.address.state) parts.push(loc.address.state);
                                if (parts.length) locationLabel = parts.join(', ');
                            }
                        }
                    } catch (e) {}

                    this.displayPrayerTimes(timings, locationLabel, hijriInfo);
                } catch (err) {
                    console.error('Prayer fetch error:', err);
                    if (this.dom.location) this.dom.location.textContent = "Gagal memuat jadwal";
                }
            },
            displayPrayerTimes(timings, locationLabel, hijriInfo) {
                this.currentTimings = timings;
                if (this.dom.location) this.dom.location.textContent = locationLabel;
                if (hijriInfo && this.dom.hijri) this.dom.hijri.textContent =
                    `${hijriInfo.day} ${hijriInfo.month.en} ${hijriInfo.year}`;

                const keys = ['Imsak', 'Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                keys.forEach(k => {
                    const el = document.getElementById('pray-' + k);
                    if (el) el.textContent = (timings[k] || '--:--').replace(/\s*\(.*\)$/, '');
                });

                this.currentNextPrayer = this.getNextPrayer();
                this.updateNextPrayerUI();
                this.updateCountdown();
            },
            getNextPrayer() {
                const order = ['Imsak', 'Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                const now = new Date();
                for (const name of order) {
                    const t = this.parseTimeToDate(this.currentTimings[name]);
                    if (t && t > now) return name;
                }
                return 'Imsak';
            },
            updateNextPrayerUI() {
                const next = this.currentNextPrayer;
                const PRAY_LABELS = {
                    'Imsak': 'Imsak',
                    'Fajr': 'Subuh',
                    'Sunrise': 'Terbit',
                    'Dhuhr': 'Dzuhur',
                    'Asr': 'Ashar',
                    'Maghrib': 'Maghrib',
                    'Isha': 'Isya'
                };
                if (!next) return;

                if (this.dom.nextLabel) this.dom.nextLabel.textContent = PRAY_LABELS[next] || next;
                if (this.dom.nextTime) this.dom.nextTime.textContent = (this.currentTimings[next] || '--:--').replace(
                    /\s*\(.*\)$/, '');

                ['Imsak', 'Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'].forEach(k => {
                    const row = document.getElementById('row-' + k);
                    if (row) {
                        row.classList.remove('next');
                        if (k === next) row.classList.add('next');
                    }
                });
            },
            parseTimeToDate(timeStr) {
                if (!timeStr) return null;
                const m = timeStr.match(/(\d{1,2}):(\d{2})/);
                if (!m) return null;
                const d = new Date();
                d.setHours(parseInt(m[1], 10), parseInt(m[2], 10), 0, 0);
                return d;
            },
            updateCountdown() {
                if (!this.dom.countdown || !this.currentNextPrayer) return;
                const now = new Date();
                let target = this.parseTimeToDate(this.currentTimings[this.currentNextPrayer]);
                if (!target) return;
                if (target < now) target.setDate(target.getDate() + 1);

                const order = ['Imsak', 'Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                const prevName = order.indexOf(this.currentNextPrayer) > 0 ? order[order.indexOf(this
                    .currentNextPrayer) - 1] : 'Isha';
                let prevTime = this.parseTimeToDate(this.currentTimings[prevName]);
                if (prevTime && prevTime > target) prevTime.setDate(prevTime.getDate() - 1);

                let totalSeconds = Math.max(0, Math.floor((target - now) / 1000));
                const h = Math.floor(totalSeconds / 3600),
                    m = Math.floor((totalSeconds % 3600) / 60),
                    s = totalSeconds % 60;

                let text = (h > 0 ? `${h}j ` : '') + (m > 0 ? `${m}m ` : '') + `${s}s`;
                this.dom.countdown.textContent = `Tersisa: ${text}`;

                if (this.dom.progressBar && prevTime) {
                    let percent = Math.max(0, Math.min(((now - prevTime) / (target - prevTime)) * 100, 100));
                    this.dom.progressBar.style.width = percent + '%';
                    if (totalSeconds <= 600) this.dom.progressBar.classList.add('warning');
                    else this.dom.progressBar.classList.remove('warning');
                }
            }
        };

        // ========== APP DASHBOARD MODULE ==========
        const AppDashboard = {
            dom: {},
            init() {
                this.cacheDom();
                this.bindEvents();
                this.updateTime();
                setInterval(() => this.updateTime(), 1000);
                this.initWeather();
                PrayerTimes.init();
            },
            cacheDom() {
                this.dom = {
                    localTime: document.getElementById('localTime'),
                    localDate: document.getElementById('localDate'),
                    weatherIcon: document.getElementById('weatherIcon'),
                    temp: document.getElementById('temp'),
                    weatherDesc: document.getElementById('weatherDesc'),
                    toolsTbody: document.getElementById('toolsTbody'),
                    detailModal: document.getElementById('detailModal'),
                    detailModalBody: document.getElementById('modalBody'),
                    modalClose: document.getElementById('modalClose'),
                    modalClose2: document.getElementById('modalClose2'),
                    mciToast: document.getElementById('mciToast')
                };
            },
            bindEvents() {
                this.dom.modalClose?.addEventListener('click', () => this.closeModal());
                this.dom.modalClose2?.addEventListener('click', () => this.closeModal());
                this.dom.detailModal?.addEventListener('click', (e) => {
                    if (e.target.classList.contains('backdrop')) this.closeModal();
                });
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') this.closeModal();
                });

                this.dom.toolsTbody?.addEventListener('click', (e) => {
                    const btn = e.target.closest('[data-action="detail"]');
                    if (!btn) return;
                    const dataStr = btn.closest('tr').getAttribute('data-tool');
                    if (dataStr) this.openModal(JSON.parse(dataStr));
                });
            },
            updateTime() {
                const now = new Date();
                if (this.dom.localTime) this.dom.localTime.textContent = now.toLocaleTimeString('id-ID', {
                    hour12: false
                });
                if (this.dom.localDate) this.dom.localDate.textContent = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            },
            async initWeather() {
                // Default location (Jakarta)
                const defaultLat = -6.200000;
                const defaultLon = 106.816666;

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (pos) => this.fetchWeather(pos.coords.latitude, pos.coords.longitude),
                        (err) => this.fetchWeather(defaultLat, defaultLon), {
                            timeout: 6000,
                            maximumAge: 60000
                        }
                    );
                } else {
                    this.fetchWeather(defaultLat, defaultLon);
                }
            },
            async fetchWeather(lat, lon) {
                try {
                    const r = await fetch(
                        `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`
                    );
                    const data = await r.json();
                    if (data?.current_weather) {
                        const cw = data.current_weather;
                        if (this.dom.temp) this.dom.temp.textContent = Math.round(cw.temperature) + '°C';
                        const code = cw.weathercode;
                        const icon = code === 0 ? '☀️' : (code <= 3 ? '⛅' : (code <= 48 ? '🌫️' : (code <= 77 ?
                            '🌧️' : '🌦️')));
                        if (this.dom.weatherIcon) this.dom.weatherIcon.textContent = icon;
                        if (this.dom.weatherDesc) this.dom.weatherDesc.textContent = code === 0 ? 'Cerah' :
                            'Berawan / Hujan';
                    }
                } catch (e) {
                    if (this.dom.weatherDesc) this.dom.weatherDesc.textContent = "Gagal memuat cuaca";
                }
            },
            openModal(data) {
                if (!this.dom.detailModal || !this.dom.detailModalBody) return;
                document.getElementById('modalTitle').textContent = 'Info Spesifik Instrumen';
                this.dom.detailModalBody.innerHTML = `
                <div><strong>Nama Instrumen</strong><div class="muted">${this.escapeHtml(data.nama || '-')}</div></div>
                <div><strong>Merek/Pabrikan</strong><div class="muted">${this.escapeHtml(data.merek || '-')}</div></div>
                <div><strong>Nomor Seri</strong><div class="muted">${this.escapeHtml(data.no_seri || '-')}</div></div>
                <div><strong>Status Terakhir</strong><div class="muted" style="text-transform:uppercase;">${this.escapeHtml(data.history?.status || '-')}</div></div>
                <div style="grid-column:1/-1;"><strong>Batas Kalibrasi Berikutnya</strong><div class="muted">${this.escapeHtml(data.history?.tgl_kalibrasi_ulang || '-')}</div></div>
                <div style="grid-column:1/-1;"><strong>Catatan Teknisi</strong><div class="muted" style="background:#f8fafc; padding:10px; border-radius:8px; border:1px solid #e2e8f0; font-weight:normal; font-size:0.9rem;">${this.escapeHtml(data.history?.keterangan || 'Tidak ada catatan khusus.')}</div></div>
            `;
                this.dom.detailModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            },
            closeModal() {
                if (this.dom.detailModal) {
                    this.dom.detailModal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            },
            showToast(msg, ms = 2500) {
                if (!this.dom.mciToast) return;
                this.dom.mciToast.textContent = msg;
                this.dom.mciToast.classList.add('show');
                setTimeout(() => this.dom.mciToast.classList.remove('show'), ms);
            },
            escapeHtml(s) {
                if (!s) return '';
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                };
                return String(s).replace(/[&<>"']/g, m => map[m]);
            }
        };

        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', () => AppDashboard.init());
        else AppDashboard.init();
    </script>
@endpush
