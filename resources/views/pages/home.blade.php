@extends('layouts.home')

@section('title', 'Home — Portal MCI')

@push('css')
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        /* ============== CSS VARIABLES (PREMIUM BENTO) ============== */
        :root {
            --bg-main: #f4f7fb;
            --panel: #ffffff;

            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-soft: #e0e7ff;
            --primary-glow: rgba(79, 70, 229, 0.15);

            --accent: #0ea5e9;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;

            --radius-xl: 28px;
            --radius-lg: 20px;
            --radius-md: 16px;
            --radius-sm: 10px;

            /* Ultra-soft shadows */
            --shadow-sm: 0 2px 4px rgba(15, 23, 42, 0.02), 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 4px 12px rgba(15, 23, 42, 0.05), 0 2px 4px rgba(15, 23, 42, 0.03);
            --shadow-lg: 0 15px 35px rgba(15, 23, 42, 0.08), 0 5px 15px rgba(15, 23, 42, 0.04);

            --success: #10b981;
            --success-soft: #d1fae5;
            --danger: #ef4444;
            --danger-soft: #fee2e2;
            --warning: #f59e0b;
            --warning-soft: #fef3c7;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
            background-image: radial-gradient(#cbd5e1 1px, transparent 0);
            background-size: 32px 32px;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1320px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
        }

        /* ============== ANIMATIONS ============== */
        .fade-in-up {
            animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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
            grid-template-columns: 1fr 360px;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: var(--radius-xl);
            padding: 2.5rem 3rem;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Ornamental Background Grid in Hero */
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.5;
            pointer-events: none;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--primary) 0%, transparent 60%);
            opacity: 0.3;
            filter: blur(50px);
            z-index: 0;
        }

        .hero h1 {
            margin: 0;
            font-weight: 800;
            font-size: 2.4rem;
            letter-spacing: -0.04em;
            z-index: 1;
            position: relative;
        }

        .hero p {
            margin: 0.5rem 0 2rem 0;
            color: #94a3b8;
            font-size: 1.1rem;
            z-index: 1;
            position: relative;
            font-weight: 500;
        }

        /* ============== HERO KPI PREMIUM GLASSMORPHISM ============== */
        .kpis {
            display: grid;
            gap: 1.25rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            margin-top: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .kpi {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            /* Animasi membal yang smooth */
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.3);
        }

        /* Efek kilau saat di-hover */
        .kpi::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .kpi:hover {
            transform: translateY(-8px) scale(1.02);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .kpi:hover::before {
            opacity: 1;
        }

        .kpi-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .kpi-icon-wrapper {
            padding: 10px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .kpi .label {
            font-size: 0.85rem;
            color: #cbd5e1;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kpi .value {
            font-size: 2.2rem;
            font-weight: 800;
            color: #ffffff;
            font-family: 'JetBrains Mono', monospace;
            line-height: 1.1;
            position: relative;
            z-index: 1;
        }

        .kpi-sub {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        /* Warna khusus untuk Icon di dalam Dark Mode */
        .icon-blue {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
        }

        .text-blue {
            color: #60a5fa;
        }

        .icon-red {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }

        .text-red {
            color: #f87171;
        }

        .icon-orange {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }

        .text-orange {
            color: #fbbf24;
        }

        .icon-green {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
        }

        .text-green {
            color: #34d399;
        }

        /* ============== QUICK ACCESS PREMIUM ============== */
        .quick {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            padding: 0 1.75rem 1.75rem;
        }

        .quick .item {
            padding: 1.5rem 1rem;
            text-align: center;
            border-radius: var(--radius-lg);
            cursor: pointer;
            font-weight: 700;
            background: var(--bg-main);
            border: 1px solid var(--border);
            color: var(--text-dark);
            font-size: 0.95rem;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Glow effect di background item saat dihover */
        .quick .item::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: radial-gradient(circle at center, var(--primary-glow) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .quick .item:hover {
            background: var(--panel);
            border-color: var(--primary);
            transform: translateY(-8px);
            color: var(--primary);
            box-shadow: 0 12px 24px var(--primary-glow);
        }

        .quick .item:hover::after {
            opacity: 1;
        }

        .quick .icon {
            font-size: 2.2rem;
            color: var(--primary);
            background: var(--panel);
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            z-index: 1;
        }

        .quick .item:hover .icon {
            transform: scale(1.15) rotate(8deg);
            background: var(--primary);
            color: white;
            box-shadow: 0 8px 20px var(--primary-glow);
            border-radius: 22px;
            /* Morphing shape */
        }

        /* ============== WEATHER & TIME CARD ============== */
        .weather-time-card {
            background: var(--panel);
            border-radius: var(--radius-xl);
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: var(--shadow-md);
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
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        }

        .clock-wrapper {
            margin: 0.5rem 0 1.5rem;
        }

        .time-display {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 800;
            font-size: 3.25rem;
            letter-spacing: -2px;
            color: var(--text-dark);
            line-height: 1;
            margin: 0;
            text-shadow: 0 4px 10px rgba(15, 23, 42, 0.03);
        }

        .date-display {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-top: 0.75rem;
        }

        .weather-widget {
            padding-top: 1.5rem;
            border-top: 1px dashed var(--border);
            display: flex;
            justify-content: center;
            gap: 15px;
            align-items: center;
            width: 100%;
        }

        .weather-widget .icon {
            font-size: 2.5rem;
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
            font-size: 1.5rem;
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
            grid-template-columns: 1fr 360px;
            gap: 1.5rem;
        }

        .card {
            background: var(--panel);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            padding: 1.75rem 1.75rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
        }

        .card-header h3 {
            margin: 0;
            color: var(--text-dark);
            font-weight: 800;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header h3 i {
            background: var(--primary-soft);
            color: var(--primary);
            padding: 8px;
            border-radius: 10px;
            font-size: 1.2rem;
        }

        /* ============== PREMIUM TABS SYSTEM ============== */
        .modern-tabs-wrapper {
            padding: 0 1.75rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .modern-tabs-container {
            display: inline-flex;
            background: #f1f5f9;
            padding: 0.4rem;
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
            padding: 0.7rem 1.5rem;
            border-radius: 999px;
            font-size: 0.9rem;
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
            background: rgba(255, 255, 255, 0.5);
        }

        .tab-btn.active {
            background: white;
            color: var(--primary);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
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
            padding: 1.5rem 1.75rem;
        }

        .tab-pane {
            display: none;
            animation: fadeInUpTab 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 600px;
        }

        th,
        td {
            padding: 1.15rem 1.25rem;
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
            cursor: pointer;
        }

        tbody tr:hover {
            background-color: var(--primary-soft);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid transparent;
            letter-spacing: 0.03em;
        }

        .badge.ok {
            background: var(--success-soft);
            color: var(--success);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .badge.proses {
            background: var(--warning-soft);
            color: var(--warning);
            border-color: rgba(245, 158, 11, 0.2);
        }

        .badge.due {
            background: var(--danger-soft);
            color: var(--danger);
            border-color: rgba(239, 68, 68, 0.2);
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
            font-size: 0.85rem;
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

        .btn-action-primary {
            background: var(--primary-soft);
            color: var(--primary);
            border-color: transparent;
        }

        .btn-action-primary:hover {
            background: var(--primary);
            color: white;
        }

        /* NCR List */
        .ncr-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ncr-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem;
            border-radius: var(--radius-md);
            background: #f8fafc;
            border: 1px solid var(--border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            position: relative;
            overflow: hidden;
        }

        /* Left border accent for NCR */
        .ncr-row::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            transition: 0.3s;
        }

        .ncr-row.due::before {
            background-color: var(--danger);
        }

        .ncr-row.proses::before {
            background-color: var(--warning);
        }

        .ncr-row:hover {
            background: white;
            border-color: var(--border);
            box-shadow: var(--shadow-md);
            transform: translateX(4px);
        }

        .ncr-row:hover::before {
            width: 6px;
        }

        .ncr-info {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            max-width: 70%;
            padding-left: 0.5rem;
        }

        .ncr-id {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ncr-issue {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.8);
        }

        .badge.due .status-dot {
            background: var(--danger);
            animation: pulse 1.5s infinite;
        }

        .badge.proses .status-dot {
            background: var(--warning);
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
            padding: 2.5rem;
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
            right: -5%;
            bottom: -40px;
            font-size: 14rem;
            opacity: 0.1;
            transform: rotate(-15deg);
            pointer-events: none;
        }

        .document-card-content h3 {
            margin: 0 0 0.5rem;
            font-size: 1.6rem;
            font-weight: 800;
            position: relative;
            z-index: 1;
        }

        .document-card-content p {
            margin: 0 0 1.5rem;
            opacity: 0.9;
            font-size: 1rem;
            max-width: 80%;
            position: relative;
            z-index: 1;
            line-height: 1.5;
        }

        .btn-document {
            background: white;
            color: var(--primary);
            padding: 0.85rem 1.75rem;
            border-radius: 99px;
            font-weight: 800;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: var(--shadow-md);
            position: relative;
            z-index: 1;
            text-decoration: none;
        }

        .btn-document:hover {
            background: #f8fafc;
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
            color: var(--primary-hover);
        }

        .quick {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            padding: 0 1.75rem 1.75rem;
        }

        .quick .item {
            padding: 1.5rem 1rem;
            text-align: center;
            border-radius: var(--radius-md);
            cursor: pointer;
            font-weight: 700;
            background: var(--bg-main);
            border: 1px solid transparent;
            color: var(--text-dark);
            font-size: 0.85rem;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            align-items: center;
        }

        .quick .item:hover {
            background: var(--panel);
            border-color: var(--primary-soft);
            transform: translateY(-5px);
            color: var(--primary);
            box-shadow: var(--shadow-md);
        }

        .quick .icon {
            font-size: 2.2rem;
            color: var(--primary);
            background: white;
            padding: 12px;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            transition: 0.3s;
        }

        .quick .item:hover .icon {
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }

        /* ============== SIDEBAR (PRAYER & ANN) ============== */
        .ann-list {
            display: grid;
            gap: 1rem;
            padding: 0 1.5rem 1.5rem;
        }

        .ann {
            display: flex;
            gap: 1.25rem;
            padding: 1.25rem;
            border-radius: var(--radius-md);
            background: var(--bg-main);
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
        }

        /* ============== PRAYER WIDGET (PREMIUM) ============== */
        .pray-card {
            position: sticky;
            top: 20px;
        }

        .prayer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .prayer-header .location {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
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
            padding: 1.75rem;
            color: white;
            text-align: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
            position: relative;
            overflow: hidden;
        }

        .next-prayer-block::after {
            content: '';
            position: absolute;
            right: -20px;
            top: -20px;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .next-prayer-block::before {
            content: '';
            position: absolute;
            left: -30px;
            bottom: -30px;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .np-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 800;
            opacity: 0.9;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
        }

        .np-name {
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
            position: relative;
            z-index: 1;
            letter-spacing: 1px;
        }

        .np-time {
            font-family: 'JetBrains Mono', monospace;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .np-countdown {
            font-size: 0.85rem;
            font-weight: 700;
            background: rgba(0, 0, 0, 0.2);
            display: inline-block;
            padding: 0.4rem 1.25rem;
            border-radius: 99px;
            backdrop-filter: blur(4px);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .np-progress {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 1.25rem;
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
            background: var(--bg-main);
            border: 1px solid transparent;
            transition: all 0.2s;
        }

        .pray-row:hover {
            background: white;
            transform: translateX(4px);
            box-shadow: var(--shadow-sm);
            border-color: var(--border);
        }

        .pray-row.next {
            background: var(--success-soft);
            color: #065f46;
            border-color: rgba(16, 185, 129, 0.2);
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
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(12px);
            cursor: pointer;
        }

        #detailModal .modal-card {
            position: relative;
            z-index: 2;
            background: var(--panel);
            width: 90%;
            max-width: 480px;
            border-radius: var(--radius-xl);
            padding: 2.5rem;
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

        @media (max-width: 768px) {
            .hero {
                padding: 2rem 1.5rem;
            }

            .quick {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
    <style>
        /* ============== ANIMASI KHUSUS HERO ============== */
        @keyframes breatheGlow {
            0% {
                transform: scale(1) translate(0, 0);
                opacity: 0.2;
            }

            33% {
                transform: scale(1.1) translate(-20px, 10px);
                opacity: 0.4;
            }

            66% {
                transform: scale(0.95) translate(20px, -10px);
                opacity: 0.3;
            }

            100% {
                transform: scale(1) translate(0, 0);
                opacity: 0.2;
            }
        }

        @keyframes moveGrid {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 30px 30px;
            }
        }

        @keyframes heroTextReveal {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============== HERO STYLING ============== */
        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: var(--radius-xl);
            padding: 2.5rem 3rem;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Ornamental Background Grid Bergerak */
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.6;
            pointer-events: none;
            /* Efek aliran grid ke arah bawah-kanan */
            animation: moveGrid 4s linear infinite;
        }

        /* Cahaya (Orb) yang Bergerak & Bernapas */
        .hero::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--primary) 0%, transparent 60%);
            filter: blur(50px);
            z-index: 0;
            pointer-events: none;
            /* Efek cahaya membesar & berpindah perlahan */
            animation: breatheGlow 12s ease-in-out infinite;
        }

        .hero h1 {
            margin: 0;
            font-weight: 800;
            font-size: 2.4rem;
            letter-spacing: -0.04em;
            z-index: 1;
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            /* Teks masuk lebih dulu */
            animation: heroTextReveal 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards;
        }

        .hero p {
            margin: 0.5rem 0 2rem 0;
            color: #94a3b8;
            font-size: 1.1rem;
            z-index: 1;
            position: relative;
            font-weight: 500;
            opacity: 0;
            transform: translateY(20px);
            /* Deskripsi masuk setelah H1 */
            animation: heroTextReveal 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.25s forwards;
        }

        /* Staggered Entry untuk Kartu KPI di dalam Hero */
        .hero .kpi {
            opacity: 0;
            transform: translateY(25px);
            animation: heroTextReveal 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .hero .kpi:nth-child(1) {
            animation-delay: 0.35s;
        }

        .hero .kpi:nth-child(2) {
            animation-delay: 0.45s;
        }

        .hero .kpi:nth-child(3) {
            animation-delay: 0.55s;
        }

        .hero .kpi:nth-child(4) {
            animation-delay: 0.65s;
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
        // 2. Ambil Data Tools/Kalibrasi
        $toolsData = optional($tools)->take(5) ?? [];

        $countKalibrasi = count($toolsData);
        $countNcr = $portalNcrs->count();
    @endphp

    <div class="container">
        @php
            // Hitung Total Seluruh Data dari Database
            $totalTools = \App\Tool::count() ?? 0; // Ganti Tool dengan nama model Alat/Instrumen Anda
            $totalNcrAll = \App\Ncr::count() ?? 0;
            $totalInventory = \App\Material::count() ?? 0; // Ganti dengan model Inventory Anda
            $totalDocument = \App\Document::count() ?? 0; // Ganti dengan model Dokumen Anda

            // Data untuk tampilan Tab dan List
            $portalNcrs =
                \App\Ncr::whereIn('status', ['Open', 'Monitoring'])
                    ->orderBy('issue_date', 'desc')
                    ->take(5)
                    ->get() ?? collect([]);
            $countNcr = $portalNcrs->count();
            $countKalibrasi = isset($toolsNeedCalibration) ? $toolsNeedCalibration->count() : 0;
        @endphp

        <div class="header-grid fade-in-up">
            <div class="hero">
                <h1>Halo, {{ Auth::user()->name ?? 'Tim MCI' }} 👋</h1>
                <p>Ringkasan akumulasi seluruh data operasional di dalam sistem saat ini.</p>

                <div class="kpis">
                    <div class="kpi">
                        <div class="kpi-header">
                            <div class="kpi-icon-wrapper icon-blue">
                                <i class='bx bx-target-lock'></i>
                            </div>
                            <div class="label">Total Alat</div>
                        </div>
                        <div class="value">{{ number_format($totalTools) }}</div>
                        <div class="kpi-sub text-orange">
                            <i class='bx bx-time-five'></i>
                            <span><strong>{{ $countKalibrasi ?? 0 }}</strong> butuh kalibrasi (H-30)</span>
                        </div>
                    </div>

                    <div class="kpi">
                        <div class="kpi-header">
                            <div class="kpi-icon-wrapper icon-red">
                                <i class='bx bx-error-alt'></i>
                            </div>
                            <div class="label">Total NCR</div>
                        </div>
                        <div class="value">{{ number_format($totalNcrAll) }}</div>
                        <div class="kpi-sub text-red">
                            <i class='bx bx-trending-up'></i>
                            <span><strong>+{{ $ncrThisMonth ?? 0 }}</strong> laporan bulan ini</span>
                        </div>
                    </div>

                    <div class="kpi">
                        <div class="kpi-header">
                            <div class="kpi-icon-wrapper icon-orange">
                                <i class='bx bx-package'></i>
                            </div>
                            <div class="label">Inventory</div>
                        </div>
                        <div class="value">{{ number_format($totalStock) }}</div>
                        <div class="kpi-sub"
                            style="display: flex; flex-direction: column; gap: 8px; align-items: flex-start; margin-top: 12px;">
                            <span class="text-green"
                                style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem;">
                                <i class='bx bx-down-arrow-circle' style="font-size: 1.1rem;"></i>
                                <span><strong>{{ $inventoryInToday ?? 0 }}</strong> masuk bulan ini</span>
                            </span>
                            <span class="text-red"
                                style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem;">
                                <i class='bx bx-up-arrow-circle' style="font-size: 1.1rem;"></i>
                                <span><strong>{{ $inventoryOutToday ?? 0 }}</strong> keluar bulan ini</span>
                            </span>
                        </div>
                    </div>

                    <div class="kpi">
                        <div class="kpi-header">
                            <div class="kpi-icon-wrapper icon-green">
                                <i class='bx bx-folder-open'></i>
                            </div>
                            <div class="label">Dokumen</div>
                        </div>
                        <div class="value">{{ number_format($totalDocument) }}</div>
                        <div class="kpi-sub text-green">
                            <i class='bx bx-file-blank'></i>
                            <span><strong>+{{ $documentInToday ?? 0 }}</strong> masuk bulan ini</span>
                        </div>
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
                <div class="card border-0">
                    <div class="card-header">
                        <h3><i class='bx bx-grid-alt'></i> Akses Cepat</h3>
                    </div>
                    <div class="quick">
                        <div class="item" onclick="location.href='/schedule'">
                            <div class="icon"><i class='bx bx-calendar'></i></div>
                            <span>Jadwal</span>
                        </div>
                        <div class="item" onclick="location.href='/kalibrasi'">
                            <div class="icon"><i class='bx bx-wrench'></i></div>
                            <span>Kalibrasi</span>
                        </div>
                        <div class="item" onclick="location.href='/portal/inventory'">
                            <div class="icon"><i class='bx bx-package'></i></div>
                            <span>Inventory</span>
                        </div>
                        <div class="item" onclick="location.href='/portal/document'">
                            <div class="icon"><i class='bx bx-clipboard'></i></div>
                            <span>Document</span>
                        </div>
                    </div>
                </div>

                <div class="card border-0">
                    <div class="card-header">
                        <h3><i class='bx bx-bell'></i> Pengumuman Internal</h3>
                        <a href="{{ route('announcements.index') ?? '#' }}" class="btn-action btn-action-primary"
                            style="padding: 0.4rem 1rem;">Lihat Semua</a>
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
                            <div class="text-center py-5 text-muted border rounded-lg"
                                style="background:#f8fafc; border-style: dashed !important;"><i
                                    class='bx bx-message-rounded-dots fs-1 mb-2'></i><br>Belum ada pengumuman terbaru.
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-header pb-3" style="border-bottom: none;">
                        <h3><i class='bx bx-layer'></i> Pantauan Operasional</h3>
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
                                <table role="table">
                                    <thead>
                                        <tr>
                                            <th>Info Alat</th>
                                            <th>Status</th>
                                            <th>Due Date</th>
                                            <th style="text-align:right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="toolsTbody">
                                        @forelse($toolsNeedCalibration ?? [] as $history)
                                            @php
                                                // Karena $history adalah model CalibrationHistory, kita ambil relasi alatnya
                                                $t = $history->tool ?? null;
                                                $s = strtolower($history->status_kalibrasi ?? '-');
                                                $badge = $s === 'ok' ? 'ok' : ($s === 'proses' ? 'proses' : 'due');
                                            @endphp
                                            <tr data-action="detail"
                                                data-nama="{{ optional($t)->nama_alat ?? 'Alat Dihapus' }}"
                                                data-merek="{{ optional($t)->merek ?? '-' }}"
                                                data-seri="{{ optional($t)->no_seri ?? '-' }}"
                                                data-tgl="{{ $history->tgl_kalibrasi_ulang ? $history->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}">
                                                <td>
                                                    <div
                                                        style="font-weight:800; color:var(--text-dark); font-size:0.95rem;">
                                                        {{ e(optional($t)->nama_alat ?? 'Tidak ada data alat') }}
                                                    </div>
                                                    <div
                                                        style="font-size:0.8rem; color:var(--text-muted); margin-top:4px; font-family: 'JetBrains Mono', monospace;">
                                                        <i class='bx bx-barcode'></i> SN:
                                                        {{ e(optional($t)->no_seri ?? '-') }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $badge }}">{{ $history->status_kalibrasi ?? '-' }}</span>
                                                </td>
                                                <td
                                                    style="font-family:'JetBrains Mono', monospace; font-size:0.9rem; font-weight:800; color: var(--danger);">
                                                    {{ $history->tgl_kalibrasi_ulang ? $history->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}
                                                </td>
                                                <td style="text-align:right">
                                                    <button class="btn-action"><i class='bx bx-search-alt-2'></i>
                                                        Detail</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    style="text-align:center; padding: 4rem 1rem; color: var(--text-muted);">
                                                    <i class='bx bx-check-shield'
                                                        style="font-size: 3.5rem; color: var(--success); margin-bottom: 15px;"></i><br>
                                                    <span
                                                        style="font-weight: 800; color: var(--text-dark); font-size: 1.2rem;">Semua
                                                        Aman!</span><br>
                                                    Tidak ada jadwal kalibrasi mendesak saat ini.
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
                                    @php $statusClass = $ncr->status == 'Open' ? 'badge-danger due' : 'badge-warning proses'; @endphp
                                    <a href="{{ route('ncr.home') ?? '#' }}"
                                        class="ncr-row {{ $ncr->status == 'Open' ? 'due' : 'proses' }}">
                                        <div class="ncr-info">
                                            <span class="ncr-id"><i class='bx bx-error-alt'></i>
                                                {{ $ncr->no_ncr }}</span>
                                            <span class="ncr-issue">{{ $ncr->issue }}</span>
                                        </div>
                                        <div><span class="badge {{ $statusClass }}"><span class="status-dot"></span>
                                                {{ $ncr->status }}</span></div>
                                    </a>
                                @empty
                                    <div
                                        style="text-align:center; padding:4rem 1rem; color:var(--text-muted); border: 2px dashed var(--border); border-radius: var(--radius-lg); background: #f8fafc;">
                                        <i class='bx bx-check-shield'
                                            style="font-size: 3.5rem; color: var(--success); margin-bottom: 15px;"></i><br><span
                                            style="display:block; font-weight: 800; font-size: 1.2rem; color: var(--text-dark);">Tidak
                                            Ada Masalah Aktif</span><span
                                            style="font-size: 0.95rem; font-weight:500;">Semua
                                            proses operasional berjalan dengan standar mutu.</span>
                                    </div>
                                @endforelse
                            </div>
                            @if ($countNcr > 0)
                                <div style="margin-top: 1.5rem; text-align: center;">
                                    <a href="{{ route('ncr.home') ?? '#' }}" class="btn-action btn-action-primary"
                                        style="padding: 0.75rem 1.5rem; border-radius: 99px;">Buka Penuh Log NCR <i
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
                style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed var(--border); padding-bottom:1.25rem;">
                <h3 style="margin:0; font-weight:800; font-size:1.4rem; display:flex; align-items:center; gap:10px;"><i
                        class='bx bx-info-circle text-primary'></i> Detail Alat</h3>
                <button id="modalClose" class="btn-action" style="padding:0.5rem; border-radius:50%;"><i
                        class='bx bx-x fs-4'></i></button>
            </header>

            <div id="modalBody" style="display:flex; flex-direction:column; gap:1.25rem; margin:1.5rem 0;">
            </div>

            <div style="text-align:right; border-top:1px dashed var(--border); padding-top:1.5rem; margin-top:1rem;">
                <button id="modalClose2" class="btn-action">Tutup Panel</button>
            </div>
        </div>
    </div>
@endsection

<script>
    // ========== 1. TAB INTERACTION & MODAL LOGIC ==========
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

        // Modal Logic (menggunakan dataset murni HTML anti error)
        const modal = document.getElementById('detailModal');

        document.body.addEventListener('click', function(e) {
            // Delegasi event untuk btn-action Detail
            const btnDetail = e.target.closest('tr[data-action="detail"]');
            if (btnDetail) {
                e.preventDefault();
                e.stopPropagation();

                // Ambil Data
                const nama = btnDetail.getAttribute('data-nama') || '-';
                const merek = btnDetail.getAttribute('data-merek') || '-';
                const seri = btnDetail.getAttribute('data-seri') || '-';
                const tgl = btnDetail.getAttribute('data-tgl') || '-';

                // Render Modal Premium
                document.getElementById('modalBody').innerHTML = `
                        <div style="background:#f8fafc; padding:16px 20px; border-radius:16px; border:1px solid var(--border);">
                            <div style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase; font-weight:800; letter-spacing:1px;">Nama Instrumen</div>
                            <div style="font-weight:800; color:var(--text-dark); font-size:1.2rem; margin-top:4px;">${nama}</div>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">
                            <div style="background:#f8fafc; padding:16px; border-radius:16px; border:1px solid var(--border);">
                                <div style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase; font-weight:800; letter-spacing:1px;">Pabrikan</div>
                                <div style="font-weight:700; color:var(--text-dark); font-size:1rem; margin-top:4px;">${merek}</div>
                            </div>
                            <div style="background:#f8fafc; padding:16px; border-radius:16px; border:1px solid var(--border);">
                                <div style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase; font-weight:800; letter-spacing:1px;">Nomor Seri</div>
                                <div style="font-family:'JetBrains Mono', monospace; font-weight:700; font-size:1rem; color:var(--text-dark); margin-top:4px;">${seri}</div>
                            </div>
                        </div>
                        <div style="background:var(--danger-soft); padding:20px; border-radius:16px; border:1px solid rgba(239, 68, 68, 0.2); text-align:center;">
                            <div style="color:var(--danger); font-size:0.8rem; text-transform:uppercase; font-weight:800; letter-spacing:1px;">Due Date Kalibrasi Berikutnya</div>
                            <div style="font-family:'JetBrains Mono', monospace; font-size:2rem; font-weight:800; color:var(--danger); margin-top:8px;">${tgl}</div>
                        </div>
                    `;
                modal.classList.add('show');
            }

            // Tutup Modal
            if (e.target.closest('#modalClose') || e.target.closest('#modalClose2') || e.target
                .classList.contains('backdrop')) {
                modal.classList.remove('show');
            }
        });
    });


    // ========== 2. MASTER DASHBOARD APP (CLOCK, WEATHER, PRAYER) ==========
    const DashboardApp = {
        prayerTimings: {},
        prayerInterval: null,

        init() {
            // A. Jalankan Jam Lokal
            this.updateTime();
            setInterval(() => this.updateTime(), 1000);

            // B. Tarik API Lokasi, Cuaca, dan Sholat (Hanya 1x Geolocation)
            this.fetchData();

            // C. Tombol Refresh Sholat & Cuaca
            const refreshBtn = document.getElementById('prayerRefreshBtn');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', () => {
                    const icon = refreshBtn.querySelector('i');
                    if (icon) {
                        icon.style.transform = 'rotate(360deg)';
                        icon.style.transition = 'transform 0.5s ease';
                        setTimeout(() => {
                            icon.style.transform = 'none';
                            icon.style.transition = 'none';
                        }, 500);
                    }
                    this.fetchData();
                });
            }
        },

        // --- FUNGSI JAM ---
        updateTime() {
            const now = new Date();
            const timeEl = document.getElementById('localTime');
            const dateEl = document.getElementById('localDate');
            if (timeEl) {
                const h = String(now.getHours()).padStart(2, '0');
                const m = String(now.getMinutes()).padStart(2, '0');
                timeEl.innerHTML = `${h}<span class="time-blink">:</span>${m}`;
            }
            if (dateEl) {
                dateEl.textContent = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }
        },

        // --- FUNGSI GEOLOCATION MASTER ---
        async fetchData() {
            const defaultLat = -6.200000;
            const defaultLon = 106.816666; // Jakarta Pusat

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => this.processAPIs(pos.coords.latitude, pos.coords.longitude),
                    (err) => this.processAPIs(defaultLat, defaultLon, "Jakarta (Default)"), {
                        timeout: 8000,
                        maximumAge: 60000
                    }
                );
            } else {
                this.processAPIs(defaultLat, defaultLon, "Jakarta (Default)");
            }
        },

        // --- EKSEKUSI API CUACA & SHOLAT BERSAMAAN ---
        async processAPIs(lat, lon, fallbackName = null) {
            // 1. Resolve Nama Kota (Nominatim)
            let locationName = fallbackName;
            if (!locationName) {
                try {
                    const resCity = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`);
                    if (resCity.ok) {
                        const loc = await resCity.json();
                        if (loc?.address) {
                            const parts = [];
                            if (loc.address.city) parts.push(loc.address.city);
                            else if (loc.address.town) parts.push(loc.address.town);
                            else if (loc.address.county) parts.push(loc.address.county);
                            if (loc.address.state) parts.push(loc.address.state);
                            if (parts.length) locationName = parts.join(', ');
                        }
                    }
                } catch (e) {
                    console.warn("Geocode failed");
                }
            }
            if (!locationName) locationName = `${lat.toFixed(2)}, ${lon.toFixed(2)}`;

            // Terapkan nama lokasi ke UI Cuaca dan UI Sholat
            const locCuacaEl = document.getElementById('weatherLocation');
            const locSholatEl = document.getElementById('prayerLocation');
            if (locCuacaEl) locCuacaEl.textContent = locationName;
            if (locSholatEl) locSholatEl.innerHTML = `<i class='bx bx-map text-primary'></i> ${locationName}`;


            // 2. Fetch Cuaca (Open-Meteo)
            try {
                const resWeather = await fetch(
                    `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`
                );
                const dataW = await resWeather.json();
                if (dataW?.current_weather) {
                    const cw = dataW.current_weather;
                    const tempEl = document.getElementById('temp');
                    const iconEl = document.getElementById('weatherIcon');
                    const descEl = document.getElementById('weatherDesc');

                    if (tempEl) tempEl.textContent = Math.round(cw.temperature) + '°C';

                    // Parse WMO Weather Code
                    const code = cw.weathercode;
                    let icon = '☀️';
                    let desc = 'Cerah';
                    if (code === 0) {
                        icon = '☀️';
                        desc = 'Cerah';
                    } else if (code >= 1 && code <= 3) {
                        icon = '⛅';
                        desc = 'Berawan';
                    } else if (code >= 45 && code <= 48) {
                        icon = '🌫️';
                        desc = 'Berkabut';
                    } else if (code >= 51 && code <= 67) {
                        icon = '🌧️';
                        desc = 'Hujan Ringan';
                    } else if (code >= 71 && code <= 77) {
                        icon = '❄️';
                        desc = 'Salju';
                    } else if (code >= 80 && code <= 82) {
                        icon = '🌦️';
                        desc = 'Hujan Lebat';
                    } else if (code >= 95 && code <= 99) {
                        icon = '⛈️';
                        desc = 'Badai Petir';
                    }

                    if (iconEl) iconEl.textContent = icon;
                    if (descEl) descEl.textContent = desc;
                }
            } catch (e) {
                const descEl = document.getElementById('weatherDesc');
                if (descEl) descEl.textContent = "Data cuaca gagal dimuat";
            }


            // 3. Fetch Jadwal Sholat (Aladhan Method 20 Kemenag RI)
            try {
                const resPrayer = await fetch(
                    `https://api.aladhan.com/v1/timings?latitude=${lat}&longitude=${lon}&method=20`);
                const jsonP = await resPrayer.json();
                if (jsonP?.data?.timings) {
                    this.prayerTimings = jsonP.data.timings;

                    // Set Hijri Date
                    const hijriInfo = jsonP.data.date.hijri || null;
                    const hijriEl = document.getElementById('prayerHijri');
                    if (hijriInfo && hijriEl) {
                        hijriEl.textContent = `${hijriInfo.day} ${hijriInfo.month.en} ${hijriInfo.year}`;
                    }

                    // Set Tabel Jadwal
                    const keys = ['Imsak', 'Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                    keys.forEach(k => {
                        const el = document.getElementById('pray-' + k);
                        if (el) el.textContent = (this.prayerTimings[k] || '--:--').replace(
                            /\s*\(.*\)$/, '');
                    });

                    // Jalankan fungsi countdown sholat
                    if (this.prayerInterval) clearInterval(this.prayerInterval);
                    this.updatePrayerCountdown();
                    this.prayerInterval = setInterval(() => this.updatePrayerCountdown(), 1000);
                }
            } catch (e) {
                if (locSholatEl) locSholatEl.innerHTML =
                    `<i class='bx bx-error text-danger'></i> Gagal memuat jadwal`;
            }
        },

        // --- FUNGSI COUNTDOWN SHOLAT ---
        updatePrayerCountdown() {
            if (!this.prayerTimings) return;

            const order = ['Imsak', 'Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
            const now = new Date();

            let nextPrayerName = 'Imsak';
            for (const name of order) {
                const t = this.parseTimeStr(this.prayerTimings[name]);
                if (t && t > now) {
                    nextPrayerName = name;
                    break;
                }
            }

            // Update UI Label & Waktu Target
            const PRAY_LABELS = {
                'Imsak': 'Imsak',
                'Fajr': 'Subuh',
                'Sunrise': 'Terbit',
                'Dhuhr': 'Dzuhur',
                'Asr': 'Ashar',
                'Maghrib': 'Maghrib',
                'Isha': 'Isya'
            };
            const nextLabelEl = document.getElementById('prayerNextLabel');
            const nextTimeEl = document.getElementById('nextPrayerTime');

            if (nextLabelEl) nextLabelEl.textContent = PRAY_LABELS[nextPrayerName] || nextPrayerName;
            if (nextTimeEl) nextTimeEl.textContent = (this.prayerTimings[nextPrayerName] || '--:--').replace(
                /\s*\(.*\)$/, '');

            // Hilight Tabel Jadwal
            ['Imsak', 'Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'].forEach(k => {
                const row = document.getElementById('row-' + k);
                if (row) {
                    row.classList.remove('active');
                    if (k === nextPrayerName) row.classList.add('active');
                }
            });

            // Kalkulasi Mundur (Countdown)
            let targetTime = this.parseTimeStr(this.prayerTimings[nextPrayerName]);
            if (!targetTime) return;
            if (targetTime < now) targetTime.setDate(targetTime.getDate() + 1); // Jika besok

            const prevName = order.indexOf(nextPrayerName) > 0 ? order[order.indexOf(nextPrayerName) - 1] : 'Isha';
            let prevTime = this.parseTimeStr(this.prayerTimings[prevName]);
            if (prevTime && prevTime > targetTime) prevTime.setDate(prevTime.getDate() - 1);

            let totalSeconds = Math.max(0, Math.floor((targetTime - now) / 1000));
            const h = Math.floor(totalSeconds / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            const s = totalSeconds % 60;

            const countdownEl = document.getElementById('nextPrayerCountdown');
            if (countdownEl) {
                let text = (h > 0 ? `${h}j ` : '') + (m > 0 ? `${m}m ` : '') + `${s}s`;
                countdownEl.textContent = `Tersisa ${text}`;
            }

            // Progress Bar
            const pBar = document.getElementById('countdownBar');
            if (pBar && prevTime) {
                let percent = Math.max(0, Math.min(((now - prevTime) / (targetTime - prevTime)) * 100, 100));
                pBar.style.width = percent + '%';
                if (totalSeconds <= 600) pBar.classList.add('warning'); // Merah jika sisa 10 menit
                else pBar.classList.remove('warning');
            }
        },

        parseTimeStr(timeStr) {
            if (!timeStr) return null;
            const m = timeStr.match(/(\d{1,2}):(\d{2})/);
            if (!m) return null;
            const d = new Date();
            d.setHours(parseInt(m[1], 10), parseInt(m[2], 10), 0, 0);
            return d;
        }
    };

    // Initialize Everything when DOM is Ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => DashboardApp.init());
    } else {
        DashboardApp.init();
    }
</script>
