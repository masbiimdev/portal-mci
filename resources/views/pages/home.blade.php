@extends('layouts.home')

@section('title', 'Home — Portal MCI')

@push('css')
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        /* ============== CSS VARIABLES ============== */
        :root {
            --bg-main: #f8fafc;
            --panel: #ffffff;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-soft: #eff6ff;
            --primary-glow: rgba(37, 99, 235, 0.15);
            --accent: #6366f1;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius-xl: 24px;
            --radius-lg: 16px;
            --radius-md: 12px;
            --shadow-sm: 0 2px 5px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 4px 12px rgba(15, 23, 42, 0.06);
            --shadow-lg: 0 10px 25px rgba(15, 23, 42, 0.08);
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
            background-image: radial-gradient(var(--border) 1px, transparent 0);
            background-size: 32px 32px;
        }

        .container {
            max-width: 1280px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* ============== ANIMATIONS ============== */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============== HERO & KPI ============== */
        .header-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -20%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
            opacity: 0.2;
            filter: blur(40px);
            z-index: 0;
        }

        .hero h1 {
            margin: 0;
            font-weight: 800;
            font-size: 2.2rem;
            letter-spacing: -0.03em;
            z-index: 1;
            position: relative;
        }

        .hero p {
            margin: 0.5rem 0 2.5rem 0;
            color: #94a3b8;
            font-size: 1.05rem;
            z-index: 1;
            position: relative;
            font-weight: 500;
        }

        .kpis {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 1rem;
            position: relative;
            z-index: 1;
        }

        .kpi {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.25rem;
            border-radius: var(--radius-lg);
            transition: all 0.3s ease;
        }

        .kpi:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .kpi .label {
            font-size: 0.75rem;
            color: #cbd5e1;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kpi .value {
            font-size: 1.8rem;
            font-weight: 800;
            color: #ffffff;
            font-family: 'JetBrains Mono', monospace;
            margin-top: 4px;
        }

        /* ============== WEATHER CARD ============== */
        .weather-time-card {
            background: var(--panel);
            border-radius: var(--radius-xl);
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .weather-time-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .clock-wrapper {
            margin: 1rem 0;
        }

        .time-display {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 800;
            font-size: 3rem;
            letter-spacing: -2px;
            color: var(--text-dark);
            line-height: 1;
            margin: 0;
            text-shadow: 0 4px 10px rgba(15, 23, 42, 0.05);
        }

        .date-display {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        .weather-widget {
            margin-top: 1rem;
            padding-top: 1.25rem;
            border-top: 1px dashed var(--border);
            display: flex;
            justify-content: center;
            gap: 15px;
            align-items: center;
            width: 100%;
        }

        .weather-widget .icon {
            font-size: 2.2rem;
            line-height: 1;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .weather-widget .info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .weather-widget .temp {
            font-weight: 800;
            font-size: 1.4rem;
            line-height: 1.1;
            color: var(--text-dark);
        }

        .weather-widget .desc {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ============== MAIN LAYOUT GRID ============== */
        .layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.5rem;
        }

        .card {
            background: var(--panel);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
        }

        .card-header h3 {
            margin: 0;
            color: var(--text-dark);
            font-weight: 800;
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ============== PREMIUM TABS SYSTEM ============== */
        .modern-tabs-wrapper {
            padding: 0 1.5rem 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .modern-tabs-container {
            display: inline-flex;
            background: #f1f5f9;
            padding: 0.35rem;
            border-radius: 999px;
            gap: 0.25rem;
            overflow-x: auto;
            white-space: nowrap;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.03);
            max-width: 100%;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .modern-tabs-container::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            background: transparent;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tab-btn:hover {
            color: var(--text-dark);
        }

        .tab-btn.active {
            background: white;
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.04);
            transform: scale(1.02);
        }

        .tab-btn i {
            font-size: 1.25rem;
            transition: transform 0.3s ease;
        }

        .tab-btn.active i {
            transform: scale(1.15);
        }

        .tab-badge {
            background: #e2e8f0;
            color: var(--text-muted);
            padding: 2px 10px;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 800;
            transition: all 0.3s;
        }

        .tab-btn.active .tab-badge {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .tab-content {
            padding: 1.5rem;
        }

        .tab-pane {
            display: none;
            animation: fadeInUpTab 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(15px);
        }

        .tab-pane.active {
            display: block;
        }

        @keyframes fadeInUpTab {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============== CONTENT STYLING ============== */
        .table-wrap {
            overflow-x: auto;
            border-radius: 14px;
            border: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        tbody tr {
            transition: background 0.2s;
        }

        tbody tr:hover {
            background-color: var(--primary-soft);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border: 1px solid transparent;
        }

        .badge.ok {
            background: #dcfce7;
            color: #059669;
        }

        .badge.proses {
            background: #fef3c7;
            color: #d97706;
        }

        .badge.due {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-action {
            padding: 0.5rem 1.25rem;
            border: none;
            background: white;
            border: 1px solid var(--border);
            color: var(--text-dark);
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-action:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        /* NCR List */
        .ncr-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .ncr-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.25rem;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid var(--border);
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .ncr-row:hover {
            background: white;
            border-color: var(--primary-glow);
            box-shadow: var(--shadow-sm);
            transform: translateX(4px);
        }

        .ncr-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            max-width: 70%;
        }

        .ncr-id {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--primary);
        }

        .ncr-issue {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
        }

        .badge.due .status-dot {
            background: #dc2626;
            animation: pulse 1.5s infinite;
        }

        .badge.proses .status-dot {
            background: #d97706;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(currentColor, 0.4);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(currentColor, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(currentColor, 0);
            }
        }

        /* ============== QUICK ACCESS & DOCS ============== */
        .document-card {
            background: linear-gradient(135deg, var(--primary) 0%, #4338ca 100%);
            color: white;
            border-radius: var(--radius-lg);
            padding: 2rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 25px var(--primary-glow);
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .document-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px var(--primary-glow);
        }

        .document-card::before {
            content: '\eb32';
            font-family: 'boxicons';
            position: absolute;
            right: -10px;
            bottom: -30px;
            font-size: 12rem;
            opacity: 0.1;
            transform: rotate(-15deg);
            pointer-events: none;
        }

        .document-card-content h3 {
            margin: 0 0 0.5rem;
            font-size: 1.5rem;
            font-weight: 800;
            position: relative;
            z-index: 1;
        }

        .document-card-content p {
            margin: 0 0 1.25rem;
            opacity: 0.9;
            font-size: 0.95rem;
            max-width: 80%;
            position: relative;
            z-index: 1;
        }

        .btn-document {
            background: white;
            color: var(--primary);
            padding: 0.75rem 1.5rem;
            border-radius: 99px;
            font-weight: 700;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: var(--shadow-md);
            position: relative;
            z-index: 1;
        }

        .btn-document:hover {
            background: #f8fafc;
            transform: scale(1.03);
            box-shadow: var(--shadow-lg);
        }

        .quick {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            padding: 0 1.5rem 1.5rem;
        }

        .quick .item {
            padding: 1.25rem 1rem;
            text-align: center;
            border-radius: var(--radius-md);
            cursor: pointer;
            font-weight: 600;
            background: #f8fafc;
            border: 1px solid transparent;
            color: var(--text-dark);
            font-size: 0.85rem;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }

        .quick .item:hover {
            background: var(--panel);
            border-color: var(--primary-glow);
            transform: translateY(-5px);
            color: var(--primary);
            box-shadow: var(--shadow-lg);
        }

        .quick .icon {
            font-size: 2rem;
            color: var(--primary);
        }

        /* ============== SIDEBAR (PRAYER & ANN) ============== */
        .ann-list {
            display: grid;
            gap: 1rem;
            padding: 0 1.5rem 1.5rem;
        }

        .ann {
            display: flex;
            gap: 1rem;
            padding: 1.25rem;
            border-radius: var(--radius-md);
            background: #f8fafc;
            border: 1px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .ann:hover {
            background: white;
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: var(--border);
        }

        .ann .avatar {
            width: 44px;
            height: 44px;
            min-width: 44px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: var(--primary-soft);
            color: var(--primary);
            font-weight: 800;
            font-size: 1rem;
        }

        /* ============== PRAYER WIDGET (REDESIGNED) ============== */
        .pray-card {
            position: sticky;
            top: 20px;
        }

        .prayer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .prayer-header .location {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .prayer-header .hijri {
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--primary);
            background: var(--primary-soft);
            padding: 4px 10px;
            border-radius: 8px;
        }

        .next-prayer-block {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            color: white;
            text-align: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
            position: relative;
            overflow: hidden;
        }

        .next-prayer-block::after {
            content: '';
            position: absolute;
            right: -20px;
            top: -20px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .np-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 800;
            opacity: 0.8;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
        }

        .np-name {
            font-size: 1.4rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
            position: relative;
            z-index: 1;
        }

        .np-time {
            font-family: 'JetBrains Mono', monospace;
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .np-countdown {
            font-size: 0.85rem;
            font-weight: 700;
            background: rgba(0, 0, 0, 0.2);
            display: inline-block;
            padding: 0.35rem 1rem;
            border-radius: 99px;
            backdrop-filter: blur(4px);
            position: relative;
            z-index: 1;
        }

        .np-progress {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 1rem;
            position: relative;
            z-index: 1;
        }

        .np-bar {
            height: 100%;
            width: 0%;
            background: #ffffff;
            border-radius: 4px;
            transition: width 1s linear;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
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
            padding: 0.85rem 1.25rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            background: #f8fafc;
            border: 1px solid var(--border);
            transition: all 0.2s;
        }

        .pray-row:hover {
            background: white;
            transform: translateX(4px);
            box-shadow: var(--shadow-sm);
            border-color: var(--primary-soft);
        }

        .pray-row.next {
            background: #ecfdf5;
            color: #065f46;
            border-color: #a7f3d0;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.1);
        }

        .pray-row.next .pray-name {
            font-weight: 800;
        }

        .pray-row.next .pray-time {
            color: #059669;
            font-weight: 800;
        }

        .pray-time {
            font-family: 'JetBrains Mono', monospace;
            color: var(--text-muted);
            font-weight: 700;
        }

        /* ============== MODAL ============== */
        #detailModal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
            justify-content: center;
            align-items: center;
        }

        #detailModal.show {
            display: flex;
            opacity: 1;
        }

        #detailModal .backdrop {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            cursor: pointer;
        }

        #detailModal .modal-card {
            position: relative;
            z-index: 2;
            background: var(--panel);
            width: 90%;
            max-width: 500px;
            border-radius: var(--radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            transform: translateY(30px) scale(0.95);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        #detailModal.show .modal-card {
            transform: translateY(0) scale(1);
        }

        @media (max-width: 1024px) {

            .header-grid,
            .layout {
                grid-template-columns: 1fr;
            }

            .pray-card {
                position: relative;
                top: 0;
            }
        }
    </style>
@endpush

@section('content')
    @php
        // 1. Ambil Data NCR
        $portalNcrs =
            \App\Ncr::whereIn('status', ['Open', 'Monitoring'])
                ->orderBy('issue_date', 'desc')
                ->take(5)
                ->get() ?? collect([]);
        // 2. Ambil Data Tools/Kalibrasi (Asumsi $tools dikirim dari controller)
        $toolsData = optional($tools)->take(5) ?? [];

        // Hitung Count untuk Badge Tab
        $countKalibrasi = count($toolsData);
        $countNcr = $portalNcrs->count();
    @endphp

    <div class="container">

        <div class="header-grid fade-in-up">
            <div class="hero">
                <h1>Halo, {{ Auth::user()->name ?? 'Tim MCI' }} 👋</h1>
                <p>Ringkasan sistem operasional, inventaris, dan jadwal hari ini.</p>
                <div class="kpis">
                    <div class="kpi">
                        <div class="label">Total Item</div>
                        <div class="value">{{ number_format($totalTools ?? 0) }}</div>
                    </div>
                    <div class="kpi">
                        <div class="label">Status OK</div>
                        <div class="value text-success">{{ number_format($statusOk ?? 0) }}</div>
                    </div>
                    <div class="kpi">
                        <div class="label">Due Soon</div>
                        <div class="value text-danger">{{ number_format($dueSoon ?? 0) }}</div>
                    </div>
                </div>
            </div>

            <div class="weather-time-card fade-in-up delay-1">
                <div class="text-primary fw-bold small text-uppercase tracking-wider"><i class='bx bx-time-five'></i> Waktu
                    Lokal</div>
                <div class="clock-wrapper">
                    <div id="localTime" class="time-display">--:--:--</div>
                    <div id="localDate" class="date-display">Mendeteksi...</div>
                </div>
                <div class="weather-widget">
                    <div id="weatherIcon" class="icon">⛅</div>
                    <div class="info">
                        <div id="temp" class="temp">--°C</div>
                        <div id="weatherDesc" class="desc">Memuat cuaca...</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="layout fade-in-up delay-2">
            <div class="main-content">
                <div class="document-card shadow-lg">
                    <div class="document-card-content">
                        <h3>Pusat Dokumen & Laporan</h3>
                        <p>Akses terpusat ke seluruh dokumen inventaris, form standar operasional (SOP), dan sertifikat
                            kalibrasi MCI.</p>
                        <a href="/portal/document" class="btn-document">
                            Buka Ruang Dokumen <i class='bx bx-right-arrow-alt fs-5'></i>
                        </a>
                    </div>
                </div>

                <div class="card border-0">
                    <div class="card-header">
                        <h3><i class='bx bx-grid-alt text-primary fs-4'></i> Akses Cepat</h3>
                    </div>
                    <div class="quick">
                        <div class="item" onclick="location.href='/schedule'"><i class='bx bx-calendar icon'></i>
                            <span>Jadwal</span>
                        </div>
                        <div class="item" onclick="location.href='/kalibrasi'"><i class='bx bx-wrench icon'></i>
                            <span>Kalibrasi</span>
                        </div>
                        <div class="item" onclick="location.href='/portal/inventory'"><i class='bx bx-package icon'></i>
                            <span>Inventory</span></div>
                        <div class="item" onclick="location.href='/export'"><i class='bx bx-export icon'></i>
                            <span>Export Data</span>
                        </div>
                    </div>
                </div>

                <div class="card border-0">
                    <div class="card-header">
                        <h3><i class='bx bx-bell text-warning fs-4'></i> Pengumuman Internal</h3>
                        <a href="{{ route('announcements.index') ?? '#' }}" class="btn-action"
                            style="padding: 0.3rem 0.8rem; background: var(--primary-soft);">Lihat Semua</a>
                    </div>
                    <div class="ann-list">
                        @forelse($announcements ?? [] as $a)
                            @php
                                $prio = strtolower($a->priority ?? 'low');
                                $prioClass =
                                    $prio === 'high' ? 'prio-high' : ($prio === 'medium' ? 'prio-medium' : 'prio-low');
                                $author = optional($a->author)->name ?? 'Admin';
                            @endphp
                            <article class="ann {{ $prioClass }}"
                                onclick="window.location='{{ url('pengumuman/show/' . \Illuminate\Support\Str::slug($a->title)) }}'">
                                <div class="avatar">{{ strtoupper(substr($author, 0, 1)) }}</div>
                                <div class="body">
                                    <h4 class="title">{{ $a->title }}</h4>
                                    <div class="excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($a->content), 80) }}
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="text-center py-4 text-muted border rounded" style="background:#f8fafc;">Belum ada
                                pengumuman</div>
                        @endforelse
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-header pb-3" style="border-bottom: none;">
                        <h3><i class='bx bx-layer text-primary fs-4'></i> Pantauan Operasional</h3>
                    </div>

                    <div class="modern-tabs-wrapper">
                        <div class="modern-tabs-container">
                            <button class="tab-btn active" data-target="tab-kalibrasi">
                                <i class='bx bx-target-lock'></i> Kalibrasi Mendatang
                                @if ($countKalibrasi > 0)
                                    <span class="tab-badge">{{ $countKalibrasi }}</span>
                                @endif
                            </button>
                            <button class="tab-btn" data-target="tab-ncr">
                                <i class='bx bx-error-circle'></i> Log NCR Aktif
                                @if ($countNcr > 0)
                                    <span class="tab-badge">{{ $countNcr }}</span>
                                @endif
                            </button>
                        </div>
                    </div>

                    <div class="tab-content">

                        <div id="tab-kalibrasi" class="tab-pane active">
                            <div class="table-wrap">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Info Alat</th>
                                            <th>Status</th>
                                            <th>Due Date</th>
                                            <th style="text-align:right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="toolsTbody">
                                        @forelse($toolsData as $t)
                                            @php
                                                $h = $t->latestHistory;
                                                $s = strtolower(optional($h)->status_kalibrasi ?? '-');
                                                $badge = $s === 'ok' ? 'ok' : ($s === 'proses' ? 'proses' : 'due');
                                            @endphp
                                            <tr data-nama="{{ $t->nama_alat }}" data-merek="{{ $t->merek ?? '-' }}"
                                                data-seri="{{ $t->no_seri ?? '-' }}"
                                                data-tgl="{{ optional($h)->tgl_kalibrasi_ulang ? $h->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}">
                                                <td>
                                                    <div
                                                        style="font-weight:700; color:var(--text-dark); font-size:0.95rem;">
                                                        {{ e($t->nama_alat) }}</div>
                                                    <div
                                                        style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                                                        <i class='bx bx-barcode'></i> SN: {{ e($t->no_seri ?? '-') }}
                                                    </div>
                                                </td>
                                                <td><span
                                                        class="badge {{ $badge }}">{{ optional($h)->status_kalibrasi ?? '-' }}</span>
                                                </td>
                                                <td
                                                    style="font-family:'JetBrains Mono', monospace; font-size:0.85rem; font-weight:700; color: var(--danger);">
                                                    {{ optional($h)->tgl_kalibrasi_ulang ? $h->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}
                                                </td>
                                                <td style="text-align:right"><button class="btn-action"
                                                        data-action="detail"><i class='bx bx-search-alt-2'></i>
                                                        Detail</button></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    style="text-align:center; padding: 4rem 1rem; color: var(--text-muted);">
                                                    <i class='bx bx-check-shield'
                                                        style="font-size: 3rem; color: var(--success); margin-bottom: 10px;"></i><br><span
                                                        style="font-weight: 700; color: var(--text-dark); font-size: 1.1rem;">Semua
                                                        Aman!</span><br>Tidak ada jadwal mendesak.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="tab-ncr" class="tab-pane">
                            <div class="ncr-list">
                                @forelse($portalNcrs as $ncr)
                                    @php $statusClass = $ncr->status == 'Open' ? 'badge-danger' : 'badge-warning'; @endphp
                                    <a href="{{ route('ncr.home') ?? '#' }}" class="ncr-row">
                                        <div class="ncr-info">
                                            <span class="ncr-id">{{ $ncr->no_ncr }}</span>
                                            <span class="ncr-issue">{{ $ncr->issue }}</span>
                                        </div>
                                        <div><span class="badge {{ $statusClass }}"><span class="status-dot"></span>
                                                {{ $ncr->status }}</span></div>
                                    </a>
                                @empty
                                    <div
                                        style="text-align:center; padding:4rem 1rem; color:var(--text-muted); border: 1px dashed var(--border); border-radius: var(--radius-lg); background: #f8fafc;">
                                        <i class='bx bx-check-shield'
                                            style="font-size: 3rem; color: var(--success); margin-bottom: 10px;"></i><br><span
                                            style="display:block; font-weight: 700; font-size: 1.1rem; color: var(--text-dark);">Tidak
                                            Ada Masalah Aktif</span><span style="font-size: 0.9rem;">Semua proses
                                            operasional berjalan dengan standar mutu.</span>
                                    </div>
                                @endforelse
                            </div>
                            @if ($countNcr > 0)
                                <div style="margin-top: 1.5rem; text-align: center;">
                                    <a href="{{ route('ncr.home') ?? '#' }}" class="btn-action"
                                        style="padding: 0.7rem 1.5rem; border-radius: 99px;">Buka Penuh Log NCR <i
                                            class='bx bx-right-arrow-alt fs-5'></i></a>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

            <aside class="sidebar fade-in-up delay-3">
                <div class="card border-0 shadow-sm pray-card">
                    <div class="card-header pb-0 border-0 d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fs-5"><i class='bx bx-moon text-indigo-500'></i> Jadwal Sholat</h3>
                        <button id="prayerRefreshBtn" class="btn-action p-2" title="Refresh Lokasi"
                            style="border-radius: 8px;"><i class='bx bx-refresh fs-5'></i></button>
                    </div>
                    <div class="p-4 pt-2">
                        <div class="prayer-header">
                            <div class="location" id="prayerLocation"><i class='bx bx-map text-primary'></i>
                                Mendeteksi...</div>
                            <div class="hijri" id="prayerHijri">—</div>
                        </div>

                        <div class="next-prayer-block">
                            <div class="np-label">Waktu Berikutnya</div>
                            <div class="np-name" id="prayerNextLabel">—</div>
                            <div class="np-time" id="nextPrayerTime">--:--</div>
                            <div class="np-countdown" id="nextPrayerCountdown">Menghitung mundur...</div>
                            <div class="np-progress">
                                <div class="np-bar" id="countdownBar"></div>
                            </div>
                        </div>

                        <div class="prayer-list">
                            <div class="pray-row" id="row-Imsak"><span class="pray-name">Imsak</span><span
                                    class="pray-time" id="pray-Imsak">--:--</span></div>
                            <div class="pray-row" id="row-Fajr"><span class="pray-name">Subuh</span><span
                                    class="pray-time" id="pray-Fajr">--:--</span></div>
                            <div class="pray-row" id="row-Sunrise"><span class="pray-name">Terbit</span><span
                                    class="pray-time" id="pray-Sunrise">--:--</span></div>
                            <div class="pray-row" id="row-Dhuhr"><span class="pray-name">Dzuhur</span><span
                                    class="pray-time" id="pray-Dhuhr">--:--</span></div>
                            <div class="pray-row" id="row-Asr"><span class="pray-name">Ashar</span><span
                                    class="pray-time" id="pray-Asr">--:--</span></div>
                            <div class="pray-row" id="row-Maghrib"><span class="pray-name">Maghrib</span><span
                                    class="pray-time" id="pray-Maghrib">--:--</span></div>
                            <div class="pray-row" id="row-Isha"><span class="pray-name">Isya</span><span
                                    class="pray-time" id="pray-Isha">--:--</span></div>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>

    <div id="detailModal" role="dialog" aria-modal="true">
        <div class="backdrop" role="button"></div>
        <div class="modal-card">
            <header
                style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #f1f5f9; padding-bottom:1rem;">
                <h3 style="margin:0; font-weight:800; font-size:1.25rem;"><i class='bx bx-info-circle text-primary'></i>
                    Detail Instrumen</h3>
                <button id="modalClose" class="btn-action" style="padding:0.4rem; border-radius:50%;"><i
                        class='bx bx-x fs-5'></i></button>
            </header>

            <div id="modalBody" style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin:1.5rem 0;">
            </div>

            <div style="text-align:right; border-top:1px solid #f1f5f9; padding-top:1.5rem;">
                <button id="modalClose2" class="btn-action">Tutup Panel</button>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // ========== 1. TAB INTERACTION LOGIC ==========
        document.addEventListener('DOMContentLoaded', () => {

            // Logika Tabs
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabPanes.forEach(p => p.classList.remove('active'));

                    btn.classList.add('active');
                    const targetPane = document.getElementById(btn.dataset.target);
                    if (targetPane) targetPane.classList.add('active');
                });
            });

            // Logika Modal Detail Kalibrasi
            const modal = document.getElementById('detailModal');

            // Menggunakan event delegation pada body agar aman
            document.body.addEventListener('click', function(e) {
                // Buka Modal
                const btnDetail = e.target.closest('[data-action="detail"]');
                if (btnDetail) {
                    e.preventDefault();
                    e.stopPropagation();
                    const tr = btnDetail.closest('tr');

                    // Ambil Data Lewat Dataset HTML murni (anti error JSON)
                    const nama = tr.getAttribute('data-nama') || '-';
                    const merek = tr.getAttribute('data-merek') || '-';
                    const seri = tr.getAttribute('data-seri') || '-';
                    const tgl = tr.getAttribute('data-tgl') || '-';

                    document.getElementById('modalBody').innerHTML = `
                        <div><strong style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase;">Nama Instrumen</strong><div style="font-weight:700; color:var(--text-dark); font-size:1rem; margin-top:4px;">${nama}</div></div>
                        <div><strong style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase;">Merek/Pabrikan</strong><div style="font-weight:600; color:var(--text-dark); margin-top:4px;">${merek}</div></div>
                        <div><strong style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase;">Nomor Seri</strong><div style="font-family:'JetBrains Mono', monospace; font-weight:600; color:var(--text-dark); margin-top:4px;">${seri}</div></div>
                        <div style="grid-column:1/-1;"><strong style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase;">Due Date Kalibrasi</strong><div style="font-size:1.25rem; font-weight:800; color:var(--danger); margin-top:4px;">${tgl}</div></div>
                    `;
                    modal.classList.add('show');
                }

                // Tutup Modal (Bisa klik tombol X, Tutup Panel, atau area gelap)
                if (e.target.closest('#modalClose') || e.target.closest('#modalClose2') || e.target
                    .classList.contains('backdrop')) {
                    modal.classList.remove('show');
                }
            });
        });

        // ========== 2. LOCAL TIME LOGIC ==========
        function updateTime() {
            const now = new Date();
            const timeEl = document.getElementById('localTime');
            const dateEl = document.getElementById('localDate');

            if (timeEl) timeEl.textContent = now.toLocaleTimeString('id-ID', {
                hour12: false
            });
            if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }
        setInterval(updateTime, 1000);
        updateTime();

        // ========== 3. PRAYER TIMES FULL MODULE ==========
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
                    const icon = this.dom.refreshBtn.querySelector('i');
                    if (icon) {
                        icon.style.transform = 'rotate(360deg)';
                        icon.style.transition = 'transform 0.5s ease';
                    }
                    setTimeout(() => {
                        if (icon) {
                            icon.style.transform = 'none';
                            icon.style.transition = 'none';
                        }
                    }, 500);
                    this.fetchPrayerTimes();
                });
            },
            async fetchPrayerTimes() {
                // Lokasi Default: Jakarta
                const defaultLat = -6.200000;
                const defaultLon = 106.816666;
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (pos) => this.getPrayerData(pos.coords.latitude, pos.coords.longitude),
                        (err) => this.getPrayerData(defaultLat, defaultLon, "Jakarta (Default)"), {
                            timeout: 8000,
                            maximumAge: 60000
                        }
                    );
                } else {
                    this.getPrayerData(defaultLat, defaultLon, "Jakarta (Default)");
                }
            },
            async getPrayerData(lat, lon, fallbackName = null) {
                try {
                    // Menggunakan Method 20 (Kemenag RI) agar jadwal sholat sangat akurat untuk Indonesia
                    const res = await fetch(
                        `https://api.aladhan.com/v1/timings?latitude=${lat}&longitude=${lon}&method=20`);
                    const json = await res.json();
                    if (!json?.data?.timings) return;

                    const timings = json.data.timings;
                    const hijriInfo = json.data.date.hijri || null;
                    let locationLabel = fallbackName || `${lat.toFixed(2)}, ${lon.toFixed(2)}`;

                    if (!fallbackName) {
                        try {
                            const r = await fetch(
                                `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`
                            );
                            if (r.ok) {
                                const loc = await r.json();
                                if (loc?.address) {
                                    const parts = [];
                                    if (loc.address.city) parts.push(loc.address.city);
                                    else if (loc.address.town) parts.push(loc.address.town);
                                    else if (loc.address.county) parts.push(loc.address.county);
                                    if (loc.address.state) parts.push(loc.address.state);
                                    if (parts.length) locationLabel = parts.join(', ');
                                }
                            }
                        } catch (e) {
                            console.warn("Reverse geocode failed");
                        }
                    }
                    this.displayPrayerTimes(timings, locationLabel, hijriInfo);
                } catch (err) {
                    if (this.dom.location) this.dom.location.textContent = "Gagal memuat API Jadwal";
                }
            },
            displayPrayerTimes(timings, locationLabel, hijriInfo) {
                this.currentTimings = timings;
                if (this.dom.location) this.dom.location.innerHTML =
                    `<i class='bx bx-map text-primary'></i> ${locationLabel}`;
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
                this.dom.countdown.textContent = `Tersisa ${text}`;

                if (this.dom.progressBar && prevTime) {
                    let percent = Math.max(0, Math.min(((now - prevTime) / (target - prevTime)) * 100, 100));
                    this.dom.progressBar.style.width = percent + '%';
                    if (totalSeconds <= 600) this.dom.progressBar.classList.add('warning');
                    else this.dom.progressBar.classList.remove('warning');
                }
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => PrayerTimes.init());
        } else {
            PrayerTimes.init();
        }
    </script>
@endpush
