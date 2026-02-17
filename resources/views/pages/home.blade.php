@extends('layouts.home')

@section('title', 'Home — Portal MCI')

@push('css')
    <style>
        /* ============== CSS VARIABLES ============== */
        :root {
            --bg-gradient: linear-gradient(180deg, #eaf4ff 0%, #f3f8ff 70%);
            --bg-1: #f3f8ff;
            --panel: #ffffff;
            --accent: #2563eb;
            --accent-soft: #60a5fa;
            --accent-lighter: #dbeafe;
            --muted: #6b7280;
            --border: #e3e7f0;
            --card-radius: 14px;
            --glass: rgba(255, 255, 255, 0.75);
            --shadow-sm: 0 2px 8px rgba(80, 120, 220, 0.07);
            --shadow: 0 8px 38px rgba(20, 33, 60, 0.10);
            --shadow-lg: 0 18px 48px rgba(41, 59, 128, 0.14);
        }

        /* ============== BASE STYLES ============== */
        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--bg-gradient);
            color: #07203a;
            line-height: 1.5;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            max-width: 1120px;
            margin: 28px auto;
            padding: 20px;
        }

        /* ============== HERO SECTION ============== */
        .hero {
            display: flex;
            gap: 24px;
            align-items: stretch;
            background: linear-gradient(135deg, var(--panel) 0%, rgba(255, 255, 255, 0.97) 100%);
            border-radius: var(--card-radius);
            padding: 28px;
            box-shadow: var(--shadow);
            margin-bottom: 4px;
        }

        .hero .meta {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero h1 {
            margin: 0;
            color: var(--accent);
            font-weight: 800;
            font-size: 1.65rem;
            letter-spacing: -0.5px;
        }

        .hero p {
            margin: 8px 0 0 0;
            color: var(--muted);
            font-size: 0.98rem;
        }

        .kpis {
            display: flex;
            gap: 16px;
            margin-top: 18px;
            flex-wrap: wrap;
        }

        .kpi {
            background: linear-gradient(180deg, rgba(96, 165, 250, 0.08), rgba(96, 165, 250, 0.02));
            padding: 14px 18px;
            border-radius: 12px;
            min-width: 140px;
            color: var(--accent);
            border: 1px solid rgba(37, 99, 235, 0.08);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .kpi:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(96, 165, 250, 0.12);
        }

        .kpi .label {
            font-size: 0.82rem;
            color: var(--muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .kpi .value {
            font-size: 1.35rem;
            font-weight: 800;
            margin-top: 8px;
            color: #08306b;
        }

        /* ============== WEATHER & TIME CARD ============== */
        .weather-time-card {
            width: 100%;
            max-width: 340px;
        }

        .time-display {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-weight: 700;
            font-size: 1.35rem;
            letter-spacing: 0.05em;
            margin: 12px 0;
            color: var(--accent);
        }

        .weather-widget {
            margin-top: 16px;
            display: flex;
            justify-content: center;
            gap: 12px;
            align-items: center;
        }

        .weather-widget .icon {
            font-size: 32px;
        }

        .weather-widget .temp {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .weather-desc {
            margin-top: 10px;
            font-size: 0.92rem;
            color: var(--muted);
        }

        /* ============== LAYOUT ============== */
        .layout {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 18px;
            margin-top: 24px;
        }

        @media (max-width: 1024px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .weather-time-card {
                max-width: 100%;
            }

            .hero {
                flex-direction: column;
                gap: 20px;
            }
        }

        .card {
            background: var(--panel);
            border-radius: var(--card-radius);
            padding: 18px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: box-shadow 0.15s cubic-bezier(0.3, 0.3, 0.35, 1),
                transform 0.15s cubic-bezier(0.3, 0.3, 0.35, 1);
        }

        .card:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        .card>h3,
        .card>h4 {
            margin: 0 0 12px 0;
            color: #08306b;
            font-weight: 700;
        }

        .card>h3 {
            font-size: 1.15rem;
        }

        .card>h4 {
            font-size: 1rem;
        }

        /* ============== ANNOUNCEMENTS ============== */
        .ann-list {
            display: grid;
            gap: 12px;
            margin-top: 14px;
        }

        .ann {
            display: flex;
            gap: 14px;
            padding: 14px;
            border-radius: 12px;
            background: linear-gradient(180deg, #fff, #fbfdff);
            border: 1px solid rgba(30, 64, 175, 0.06);
            border-left: 5px solid var(--accent-soft);
            transition: transform 0.12s ease, box-shadow 0.12s ease, border-color 0.2s ease;
            cursor: pointer;
        }

        .ann:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(16, 32, 80, 0.08);
            border-left-color: var(--accent);
        }

        .ann.prio-high {
            border-left-color: #f87171;
        }

        .ann.prio-medium {
            border-left-color: #fbbf24;
        }

        .ann.prio-low {
            border-left-color: #a5b4fc;
        }

        .ann .avatar {
            width: 52px;
            height: 52px;
            min-width: 52px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--accent-soft), var(--accent));
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(96, 165, 250, 0.3);
        }

        .ann .body {
            flex: 1;
            min-width: 0;
        }

        .ann .title {
            font-weight: 700;
            color: #06234a;
            margin: 0;
            font-size: 0.98rem;
        }

        .ann .excerpt {
            margin: 6px 0 0 0;
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.4;
        }

        .ann .meta {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            align-items: center;
            color: var(--muted);
            font-size: 0.8rem;
            flex-wrap: wrap;
        }

        .badge-prio {
            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .prio-high {
            background: #fee2e2;
            color: #991b1b;
        }

        .prio-medium {
            background: #fff7ed;
            color: #92400e;
        }

        .prio-low {
            background: #eef2ff;
            color: #1e3a8a;
        }

        /* ============== QUICK ACTIONS ============== */
        .quick {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .quick {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .quick {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }
        }

        .quick .item {
            padding: 14px 12px;
            text-align: center;
            border-radius: 11px;
            cursor: pointer;
            font-weight: 600;
            background: transparent;
            border: 1.5px solid rgba(30, 64, 175, 0.08);
            color: #08306b;
            font-size: 0.88rem;
            transition: all 0.15s cubic-bezier(0.3, 0.3, 0.35, 1);
            display: flex;
            flex-direction: column;
            gap: 6px;
            align-items: center;
            justify-content: center;
        }

        .quick .item:hover {
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.08), rgba(59, 130, 246, 0.04));
            transform: translateY(-4px);
            border-color: rgba(30, 64, 175, 0.16);
            box-shadow: 0 8px 20px rgba(96, 165, 250, 0.12);
        }

        .quick .item:active {
            transform: translateY(-2px);
        }

        .quick .icon {
            font-size: 1.6rem;
        }

        /* ============== TABLE ============== */
        .table-wrap {
            overflow-x: auto;
            margin-top: 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            -webkit-overflow-scrolling: touch;
        }

        .table-wrap::-webkit-scrollbar {
            height: 6px;
        }

        .table-wrap::-webkit-scrollbar-track {
            background: rgba(96, 165, 250, 0.05);
        }

        .table-wrap::-webkit-scrollbar-thumb {
            background: rgba(96, 165, 250, 0.3);
            border-radius: 3px;
        }

        .table-wrap::-webkit-scrollbar-thumb:hover {
            background: rgba(96, 165, 250, 0.5);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
            font-size: 0.92rem;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            vertical-align: middle;
        }

        thead th {
            position: sticky;
            top: 0;
            background: linear-gradient(180deg, var(--panel) 0%, rgba(255, 255, 255, 0.95) 100%);
            color: #08306b;
            font-weight: 700;
            font-size: 0.86rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            z-index: 10;
        }

        tbody tr {
            transition: background-color 0.1s ease;
        }

        tbody tr:hover {
            background-color: rgba(96, 165, 250, 0.04);
        }

        .badge {
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 0.2px;
            text-transform: uppercase;
            display: inline-block;
        }

        .badge.ok {
            background: #ecfdf5;
            color: #027a3b;
        }

        .badge.proses {
            background: #fefce8;
            color: #854d0e;
        }

        .badge.due {
            background: #fef2f2;
            color: #9f1239;
        }

        .action {
            padding: 6px 12px;
            border: 1px solid rgba(30, 64, 175, 0.12);
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.06), rgba(59, 130, 246, 0.02));
            color: var(--accent);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.82rem;
            transition: all 0.12s ease;
        }

        .action:hover {
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.12), rgba(59, 130, 246, 0.06));
            border-color: rgba(30, 64, 175, 0.24);
            transform: translateY(-2px);
        }

        .action:active {
            transform: translateY(0);
        }

        /* ============== PRAYER TIMES (IMPROVED) ============== */
        .pray-card {
            overflow: hidden;
        }

        .prayer-head {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .prayer-icon {
            font-size: 1.4rem;
        }

        .prayer-head h4 {
            margin: 0;
            font-size: 1.05rem;
            flex: 1;
            color: #08306b;
        }

        .prayer-head .action {
            padding: 6px 10px;
            background: transparent;
            border-radius: 8px;
            border: 1px solid rgba(30, 50, 90, 0.08);
            font-size: 0.9rem;
            transition: all 0.12s ease;
        }

        .prayer-head .action:hover {
            border-color: rgba(30, 50, 90, 0.16);
            background: rgba(96, 165, 250, 0.04);
            animation: spin 0.6s ease-in-out;
        }

        @keyframes spin {
            from {
                transform: rotateZ(0deg);
            }

            to {
                transform: rotateZ(360deg);
            }
        }

        /* ========== PRAYER INFO (LOKASI, TANGGAL, HIJRI) ========== */
        .prayer-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            font-size: 0.88rem;
            margin-bottom: 10px;
            padding: 8px;
            background: rgba(96, 165, 250, 0.04);
            border-radius: 8px;
        }

        .prayer-info-item {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .prayer-info-item .label {
            color: var(--muted);
            font-weight: 400;
        }

        .prayer-info-item .value {
            color: #08306b;
            font-weight: 400;
        }

        .prayer-info-icon {
            font-size: 0.95rem;
        }

        @media (max-width: 650px) {
            .prayer-info {
                grid-template-columns: 1fr;
                gap: 6px;
            }
        }

        /* ========== NEXT PRAYER BLOCK ========== */
        .next-prayer-block {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 50%, #f0f9ff 100%);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 12px;
            text-align: center;
            border: 1px solid rgba(96, 165, 250, 0.2);
            box-shadow: 0 2px 10px rgba(49, 98, 173, 0.06);
        }

        .np-label {
            font-size: 0.85rem;
            color: var(--muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }

        .np-name {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1e40af;
            display: block;
            margin-bottom: 6px;
        }

        .np-time {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-size: 1.4rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 6px;
            letter-spacing: 0.05em;
        }

        .np-countdown {
            font-size: 0.9rem;
            color: #0369a1;
            font-weight: 500;
        }

        /* ========== PRAYER TIMES LIST ========== */
        .prayer-list {
            display: grid;
            gap: 6px;
            margin-top: 8px;
        }

        .pray-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            transition: all 0.12s cubic-bezier(0.3, 0.3, 0.35, 1);
            background: rgba(96, 165, 250, 0.02);
            border: 1px solid transparent;
            font-size: 0.94rem;
            font-weight: 500;
        }

        .pray-row:hover {
            background: rgba(96, 165, 250, 0.06);
            border-color: rgba(96, 165, 250, 0.15);
        }

        .pray-row.next {
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            color: #fff;
            font-weight: 700;
            border-color: rgba(37, 99, 235, 0.4);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
        }

        .pray-row.next .pray-time {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        .pray-ico {
            font-size: 1.15rem;
            min-width: 20px;
            text-align: center;
        }

        .pray-name {
            flex: 1;
        }

        .pray-time {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-weight: 700;
            color: var(--accent);
            font-size: 0.92rem;
        }

        .pray-row.next .pray-time {
            color: #fff;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .prayer-info {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .next-prayer-block {
                padding: 12px;
            }

            .np-name {
                font-size: 1.1rem;
            }

            .np-time {
                font-size: 1.2rem;
            }

            .pray-row {
                padding: 8px 10px;
            }
        }

        @media (max-width: 480px) {
            .prayer-info {
                grid-template-columns: 1fr;
                gap: 6px;
                padding: 6px;
                font-size: 0.82rem;
            }

            .next-prayer-block {
                padding: 10px;
            }

            .np-name {
                font-size: 1rem;
            }

            .np-time {
                font-size: 1.1rem;
            }

            .np-countdown {
                font-size: 0.85rem;
            }

            .prayer-list {
                gap: 4px;
            }

            .pray-row {
                padding: 8px;
                font-size: 0.88rem;
            }

            .pray-ico {
                min-width: 18px;
                font-size: 1rem;
            }

            .pray-time {
                font-size: 0.85rem;
            }
        }

        /* ============== SUMMARY SECTION ============== */
        .summary-legend {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .summary-legend .muted {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 500;
        }

        /* ============== MODAL ============== */
        #detailModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 999;
            display: none;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s cubic-bezier(0.3, 0.3, 0.35, 1);
        }

        #detailModal.show {
            display: flex;
            opacity: 1;
            pointer-events: auto;
            align-items: center;
            justify-content: center;
        }

        #detailModal .backdrop {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(30, 50, 90, 0.35);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            z-index: 1;
        }

        #detailModal .modal-card {
            position: relative;
            z-index: 2;
            background: var(--panel);
            max-width: 420px;
            width: 90vw;
            border-radius: 18px;
            padding: 28px;
            box-shadow: var(--shadow-lg);
            animation: modalPopIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes modalPopIn {
            from {
                transform: translateY(40px) scale(0.95);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        #detailModal header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        #detailModal h3 {
            margin: 0;
            color: #08306b;
            font-weight: 700;
            font-size: 1.25rem;
        }

        #detailModal button {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--muted);
            transition: color 0.12s ease;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #detailModal button:hover {
            color: var(--accent);
        }

        #modalBody {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin: 18px 0;
        }

        @media (max-width: 480px) {
            #modalBody {
                grid-template-columns: 1fr;
            }

            #detailModal .modal-card {
                padding: 18px;
            }
        }

        #modalBody>div {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        #modalBody strong {
            color: #08306b;
            font-weight: 700;
            font-size: 0.92rem;
        }

        #modalBody .muted {
            color: var(--muted);
            font-size: 0.88rem;
            word-break: break-word;
        }

        /* ============== TOAST ============== */
        .toast {
            position: fixed;
            right: 20px;
            bottom: 20px;
            background: var(--accent);
            color: #fff;
            padding: 12px 18px;
            border-radius: 10px;
            display: none;
            z-index: 9999;
            font-weight: 600;
            font-size: 0.92rem;
            box-shadow: var(--shadow);
            animation: toastSlideIn 0.2s cubic-bezier(0.3, 0.3, 0.35, 1);
        }

        .toast.show {
            display: block;
        }

        @keyframes toastSlideIn {
            from {
                transform: translateX(400px) translateY(0);
                opacity: 0;
            }

            to {
                transform: translateX(0) translateY(0);
                opacity: 1;
            }
        }

        /* ============== UTILITY CLASSES ============== */
        .muted {
            color: var(--muted);
        }

        .center {
            text-align: center;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .card-header a {
            color: var(--accent);
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: opacity 0.12s ease;
        }

        .card-header a:hover {
            opacity: 0.7;
        }

        /* ============== RESPONSIVE ============== */
        @media (max-width: 768px) {
            .container {
                margin: 16px auto;
                padding: 12px;
            }

            .hero {
                padding: 18px;
                gap: 16px;
            }

            .hero h1 {
                font-size: 1.3rem;
            }

            .kpis {
                gap: 10px;
                margin-top: 14px;
            }

            .kpi {
                min-width: 100px;
                padding: 10px 12px;
            }

            .layout {
                gap: 12px;
            }

            .card {
                padding: 14px;
                border-radius: 12px;
            }

            .ann {
                gap: 10px;
                padding: 10px;
            }

            .ann .avatar {
                width: 44px;
                height: 44px;
            }

            table,
            th,
            td {
                font-size: 0.88rem;
            }

            th,
            td {
                padding: 8px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 8px;
                margin: 10px auto;
            }

            .hero {
                padding: 12px;
                border-radius: 10px;
            }

            .hero h1 {
                font-size: 1.1rem;
            }

            .hero p {
                font-size: 0.9rem;
            }

            .kpis {
                flex-direction: column;
            }

            .kpi {
                min-width: auto;
            }

            .ann .excerpt {
                font-size: 0.88rem;
            }

            .muted {
                font-size: 0.85rem;
            }
        }
    </style>
    <style>
        .np-progress {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
            margin-top: 10px;
        }

        .np-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #4facfe, #00f2fe);
            border-radius: 20px;
            transition: width 1s linear;
        }

        /* kalau udah hampir waktu sholat */
        .np-bar.warning {
            background: linear-gradient(90deg, #ff9966, #ff5e62);
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <!-- Hero -->
        <div class="hero">
            <div class="meta">
                <h1>Halo, {{ Auth::user()->name ?? 'Pengguna' }} — Portal MCI</h1>
                <p class="muted">Ringkasan cepat status kalibrasi, pengumuman penting, dan akses ke modul utama.</p>

                <div class="kpis" aria-label="Key Performance Indicators">
                    <div class="kpi" title="Total jumlah alat dalam sistem">
                        <div class="label">Total Item</div>
                        <div class="value">{{ number_format($totalTools ?? 0) }}</div>
                    </div>
                    <div class="kpi" title="Alat dengan status kalibrasi OK">
                        <div class="label">Status OK</div>
                        <div class="value">{{ number_format($statusOk ?? 0) }}</div>
                    </div>
                    <div class="kpi" title="Alat sedang dalam proses kalibrasi">
                        <div class="label">Sedang Kalibrasi</div>
                        <div class="value">{{ number_format($statusProses ?? 0) }}</div>
                    </div>
                    <div class="kpi" title="Alat dengan jadwal kalibrasi kurang dari 15 hari">
                        <div class="label">Due &lt; 15 hari</div>
                        <div class="value">{{ number_format($dueSoon ?? 0) }}</div>
                    </div>
                    <div class="kpi" title="Total jumlah item inventory">
                        <div class="label">Inventory Total</div>
                        <div class="value">{{ number_format($inventoryTotalCount ?? 0) }}</div>
                    </div>
                    <div class="kpi" title="Jumlah item dengan stok rendah">
                        <div class="label">Low Stock</div>
                        <div class="value">{{ number_format($lowStockCount ?? 0) }}</div>
                    </div>
                </div>
            </div>

            <!-- Weather & Time Card -->
            <div class="weather-time-card">
                <div class="card center">
                    <div class="muted" style="font-size:0.88rem">Waktu Lokal</div>
                    <div id="localTime" class="time-display">--:--:--</div>
                    <div id="localDate" class="muted" style="font-size:0.85rem; margin-top:4px;">—</div>

                    <div class="weather-widget">
                        <div id="weatherIcon" class="icon">⛅</div>
                        <div id="temp" class="temp">--°C</div>
                    </div>
                    <div id="weatherDesc" class="weather-desc">Memuat cuaca...</div>
                </div>
            </div>
        </div>

        <!-- MAIN LAYOUT -->
        <div class="layout" aria-live="polite" aria-label="Konten utama dashboard">
            <!-- Left Column -->
            <div>
                <!-- Announcements -->
                <div class="card">
                    <div class="card-header">
                        <h3>Pengumuman</h3>
                        <a href="{{ route('announcements.index') ?? '#' }}">Lihat Semua</a>
                    </div>

                    <div class="ann-list" role="feed" aria-label="Daftar pengumuman">
                        @forelse($announcements as $a)
                            @php
                                $prio = strtolower($a->priority ?? 'low');
                                $prioClass =
                                    $prio === 'high' ? 'prio-high' : ($prio === 'medium' ? 'prio-medium' : 'prio-low');
                                $author = optional($a->author)->name ?? 'Admin';
                                $excerpt = \Illuminate\Support\Str::limit(strip_tags($a->content), 160);
                                $date = \Carbon\Carbon::parse($a->created_at)->translatedFormat('d M Y');
                            @endphp

                            <article class="ann {{ $prioClass }}" role="article"
                                aria-labelledby="ann-{{ $a->id }}">
                                <div class="avatar" aria-hidden="true">{{ strtoupper(substr($author, 0, 2)) }}</div>

                                <div class="body">
                                    <h4 id="ann-{{ $a->id }}" class="title">{{ $a->title }}</h4>
                                    <div class="excerpt">{{ $excerpt }}</div>

                                    <div class="meta">
                                        <span class="badge-prio {{ $prioClass }}">{{ strtoupper($prio) }}</span>
                                        <span>{{ $author }}</span>
                                        <span>•</span>
                                        <time datetime="{{ $a->created_at }}">{{ $date }}</time>
                                        <span style="margin-left:auto">
                                            <a href="{{ url('pengumuman/show/' . \Illuminate\Support\Str::slug($a->title)) }}"
                                                style="color:var(--accent); font-weight:600; text-decoration:none; transition:opacity .12s;">Lihat</a>
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="muted center" style="padding:20px 0;">Belum ada pengumuman.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick actions -->
                <div class="card" style="margin-top:14px;">
                    <h4 style="margin:0 0 10px 0">Akses Cepat</h4>
                    <div class="quick">
                        <div class="item" onclick="location.href='/schedule'" role="button" tabindex="0"
                            title="Lihat Jadwal">
                            <span class="icon">📅</span>
                            <span>Jadwal</span>
                        </div>
                        <div class="item" onclick="location.href='/kalibrasi'" role="button" tabindex="0"
                            title="Kelola Kalibrasi">
                            <span class="icon">🛠</span>
                            <span>Kalibrasi</span>
                        </div>
                        <div class="item" onclick="location.href='/portal/inventory'" role="button" tabindex="0"
                            title="Manajemen Inventory">
                            <span class="icon">📦</span>
                            <span>Inventory</span>
                        </div>
                        <div class="item" onclick="location.href='/export'" role="button" tabindex="0"
                            title="Export Data">
                            <span class="icon">⬇</span>
                            <span>Export</span>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card" style="margin-top:14px;">
                    <div class="card-header">
                        <h4 style="margin:0">Upcoming / Due</h4>
                        <div class="muted" style="font-size:0.9rem">Terbaru</div>
                    </div>

                    <div class="table-wrap">
                        <table role="table" aria-label="Daftar alat kalibrasi">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Merk</th>
                                    <th>Status</th>
                                    <th>Tgl Kalibrasi</th>
                                    <th>Tgl Ulang</th>
                                    <th>Aksi</th>
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
                                                    'tgl_kalibrasi_ulang' => $h->tgl_kalibrasi_ulang
                                                        ? $h->tgl_kalibrasi_ulang->format('d/m/Y')
                                                        : null,
                                                    'keterangan' => $h->keterangan,
                                                ]
                                                : null,
                                        ];
                                    @endphp
                                    <tr data-tool='@json($toolJson)'>
                                        <td>{{ $i + 1 }}</td>
                                        <td><strong>{{ e($t->nama_alat) }}</strong></td>
                                        <td>{{ e($t->merek ?? '-') }}</td>
                                        <td><span
                                                class="badge {{ $badge }}">{{ optional($h)->status_kalibrasi ?? '-' }}</span>
                                        </td>
                                        <td>{{ optional($h)->tgl_kalibrasi ? $h->tgl_kalibrasi->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>{{ optional($h)->tgl_kalibrasi_ulang ? $h->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}
                                        </td>
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

            <!-- Right Column (Sidebar) -->
            <aside class="sidebar" aria-label="Sidebar informasi tambahan">

                <div class="card pray-card">

                    <!-- Header -->
                    <div class="prayer-head">
                        <div class="head-left">
                            <span class="prayer-icon">🕋</span>
                            <h4>Jadwal Sholat</h4>
                        </div>
                        <button id="prayerRefreshBtn" class="action" title="Refresh jadwal" aria-label="Refresh jadwal">
                            ↻
                        </button>
                    </div>

                    <!-- Info Section -->
                    <div class="prayer-info">
                        <div class="prayer-info-item">
                            <div class="left">
                                <span>📍</span>
                                <span>Lokasi</span>
                            </div>
                            <span class="value" id="prayerLocation">—</span>
                        </div>

                        <div class="prayer-info-item">
                            <div class="left">
                                <span>☪️</span>
                                <span>Hijriyah</span>
                            </div>
                            <span class="value" id="prayerHijri">—</span>
                        </div>
                    </div>

                    <!-- Next Prayer Highlight -->
                    <div class="next-prayer-block">
                        <div class="np-label">Sholat Berikutnya</div>
                        <div class="np-name" id="prayerNextLabel">—</div>
                        <div class="np-time" id="nextPrayerTime">--:--</div>
                        <div class="np-countdown" id="nextPrayerCountdown"></div>
                        <div class="np-progress">
                            <div class="np-bar" id="countdownBar"></div>
                        </div>
                    </div>

                    <!-- List -->
                    <div class="prayer-list">

                        <div class="pray-row" id="row-Imsak">
                            <span class="pray-name">⏰ Imsak</span>
                            <span class="pray-time" id="pray-Imsak">--:--</span>
                        </div>

                        <div class="pray-row" id="row-Fajr">
                            <span class="pray-name">🌅 Subuh</span>
                            <span class="pray-time" id="pray-Fajr">--:--</span>
                        </div>

                        <div class="pray-row" id="row-Sunrise">
                            <span class="pray-name">🌄 Terbit</span>
                            <span class="pray-time" id="pray-Sunrise">--:--</span>
                        </div>

                        <div class="pray-row" id="row-Dhuhr">
                            <span class="pray-name">☀️ Dzuhur</span>
                            <span class="pray-time" id="pray-Dhuhr">--:--</span>
                        </div>

                        <div class="pray-row" id="row-Asr">
                            <span class="pray-name">🏜️ Ashar</span>
                            <span class="pray-time" id="pray-Asr">--:--</span>
                        </div>

                        <div class="pray-row" id="row-Maghrib">
                            <span class="pray-name">🌇 Maghrib</span>
                            <span class="pray-time" id="pray-Maghrib">--:--</span>
                        </div>

                        <div class="pray-row" id="row-Isha">
                            <span class="pray-name">🌃 Isya</span>
                            <span class="pray-time" id="pray-Isha">--:--</span>
                        </div>

                    </div>
                </div>

            </aside>

        </div>
    </div>

    <!-- Modal -->
    <div id="detailModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="backdrop" role="button" tabindex="-1" aria-hidden="true"></div>
        <div class="modal-card" role="document">
            <header>
                <h3 id="modalTitle">Detail</h3>
                <button id="modalClose" aria-label="Tutup modal" title="Tutup (Esc)">✕</button>
            </header>
            <div id="modalBody" style="margin-top:12px;"></div>
            <div style="margin-top:18px; text-align:right;">
                <button id="modalClose2" class="action">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="mciToast" class="toast" role="status" aria-live="polite" aria-hidden="true"></div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        'use strict';

        // ========== PRAYER TIMES CONFIG ==========
        const PRAY_LABELS = {
            'Imsak': 'Imsak',
            'Fajr': 'Subuh',
            'Sunrise': 'Terbit',
            'Dhuhr': 'Dzuhur',
            'Asr': 'Ashar',
            'Maghrib': 'Maghrib',
            'Isha': 'Isya'
        };

        // ========== Global Data ==========
        window._tools = @json($toolsData ?? []);
        window._pieData = @json($pieData ?? ['ok' => 0, 'proses' => 0, 'due' => 0]);
        window._visitorTrend = @json($visitorTrend ?? ['labels' => [], 'data' => []]);

        // ================= PRAYER TIMES MODULE =================
        const PrayerTimes = {
            countdownInterval: null,
            currentTimings: {},
            currentNextPrayer: null,
            dom: {},

            init() {
                this.cacheDom();
                this.bindEvents();
                this.fetchPrayerTimes();

                this.countdownInterval = setInterval(() => {
                    this.updateCountdown();
                }, 1000);
            },

            cacheDom() {
                this.dom = {
                    refreshBtn: document.getElementById('prayerRefreshBtn'),
                    location: document.getElementById('prayerLocation'),
                    date: document.getElementById('prayerDate'),
                    hijri: document.getElementById('prayerHijri'),
                    nextLabel: document.getElementById('prayerNextLabel'),
                    nextTime: document.getElementById('nextPrayerTime'),
                    countdown: document.getElementById('nextPrayerCountdown'),
                    progressBar: document.getElementById('countdownBar'), // ← TAMBAH INI
                };
            },

            bindEvents() {
                this.dom.refreshBtn?.addEventListener('click', () => {
                    this.fetchPrayerTimes();
                    if (window.AppDashboard?.showToast) {
                        AppDashboard.showToast('Memperbarui jadwal sholat...');
                    }
                });
            },

            // 🔥 fallback langsung supaya selalu stabil
            async fetchPrayerTimes() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (pos) => this.getPrayerData(pos.coords.latitude, pos.coords.longitude),
                        () => this.getPrayerData(-6.2383, 106.9892), {
                            timeout: 8000,
                            maximumAge: 60000
                        }
                    );
                } else {
                    this.getPrayerData(-6.2383, 106.9892);
                }
            },

            async getPrayerData(lat, lon) {
                const url = `https://api.aladhan.com/v1/timings?latitude=${lat}&longitude=${lon}&method=2`;
                try {
                    const res = await fetch(url);
                    const json = await res.json();

                    if (!json?.data?.timings) {
                        this.displayPrayerTimes({}, '', '', null);
                        return;
                    }

                    const timings = json.data.timings;
                    const dateReadable = json.data.date.readable || new Date().toLocaleDateString('id-ID');
                    const hijriInfo = json.data.date.hijri || null;

                    let locationLabel = `${lat.toFixed(3)}, ${lon.toFixed(3)}`;
                    try {
                        const r = await fetch(
                            `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`, {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            }
                        );
                        if (r.ok) {
                            const loc = await r.json();
                            if (loc?.address) {
                                const parts = [];
                                if (loc.address.city) parts.push(loc.address.city);
                                else if (loc.address.town) parts.push(loc.address.town);
                                else if (loc.address.village) parts.push(loc.address.village);
                                if (loc.address.state) parts.push(loc.address.state);
                                if (parts.length) locationLabel = parts.join(', ');
                            }
                        }
                    } catch (err) {
                        console.warn('Geocode error:', err);
                    }

                    this.displayPrayerTimes(timings, dateReadable, locationLabel, hijriInfo);
                } catch (err) {
                    console.error('Prayer times fetch error:', err);
                    this.displayPrayerTimes({}, '', 'Tidak dapat memuat data', null);
                }
            },

            displayPrayerTimes(timings, dateReadable, locationLabel, hijriInfo) {
                this.currentTimings = timings;

                if (this.dom.date) this.dom.date.textContent = dateReadable || '—';
                if (this.dom.location) this.dom.location.textContent = locationLabel || '—';

                if (hijriInfo && this.dom.hijri) {
                    this.dom.hijri.textContent =
                        `${hijriInfo.day} ${hijriInfo.month.en} ${hijriInfo.year}`;
                } else if (this.dom.hijri) {
                    this.dom.hijri.textContent = '—';
                }

                const keys = ['Imsak', 'Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];

                keys.forEach(k => {
                    const el = document.getElementById('pray-' + k);
                    if (el) {
                        const time = (timings[k] || '--:--')
                            .replace(/\s*\(.*\)$/, '');
                        el.textContent = time;
                    }
                });

                this.currentNextPrayer = this.getNextPrayer();
                this.updateNextPrayerUI();
                this.updateCountdown();
            },

            // 🔥 Imsak MASUK countdown
            getNextPrayer() {
                const order = ['Imsak', 'Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                const now = new Date();

                for (const name of order) {
                    const t = this.parseTimeToDate(this.currentTimings[name]);
                    if (t && t > now) {
                        return name;
                    }
                }

                // kalau semua sudah lewat → besok Imsak
                return 'Imsak';
            },

            updateNextPrayerUI() {
                const next = this.currentNextPrayer;
                if (!next) return;

                if (this.dom.nextLabel) {
                    this.dom.nextLabel.textContent = PRAY_LABELS[next] || next;
                }

                if (this.dom.nextTime) {
                    const nextTime = (this.currentTimings[next] || '--:--')
                        .replace(/\s*\(.*\)$/, '');
                    this.dom.nextTime.textContent = nextTime;
                }

                const keys = ['Imsak', 'Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];

                keys.forEach(k => {
                    const row = document.getElementById('row-' + k);
                    if (row) {
                        row.classList.remove('next');
                        if (k === next) {
                            row.classList.add('next');
                        }
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
                let target = this.parseTimeToDate(
                    this.currentTimings[this.currentNextPrayer]
                );

                if (!target) {
                    this.dom.countdown.textContent = '';
                    return;
                }

                if (target < now) {
                    target.setDate(target.getDate() + 1);
                }

                // 🔥 cari waktu sholat sebelumnya
                const order = ['Imsak', 'Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                const currentIndex = order.indexOf(this.currentNextPrayer);
                const prevName = currentIndex > 0 ? order[currentIndex - 1] : 'Isha';

                let prevTime = this.parseTimeToDate(this.currentTimings[prevName]);
                if (prevTime && prevTime > target) {
                    prevTime.setDate(prevTime.getDate() - 1);
                }

                let totalSeconds = Math.floor((target - now) / 1000);
                if (totalSeconds < 0) totalSeconds = 0;

                const h = Math.floor(totalSeconds / 3600);
                const m = Math.floor((totalSeconds % 3600) / 60);
                const s = totalSeconds % 60;

                let text = '';
                if (h > 0) text += `${h} jam `;
                if (m > 0) text += `${m} mnt `;
                text += `${s} detik`;

                this.dom.countdown.textContent = `Mulai dalam ${text}`;

                // ======================
                // 🔥 PROGRESS BAR LOGIC
                // ======================
                if (!this.dom.progressBar || !prevTime) return;

                const totalDuration = target - prevTime;
                const elapsed = now - prevTime;

                let percent = (elapsed / totalDuration) * 100;
                percent = Math.max(0, Math.min(percent, 100));

                this.dom.progressBar.style.width = percent + '%';

                // warna berubah kalau sisa < 10 menit
                if (totalSeconds <= 600) {
                    this.dom.progressBar.classList.add('warning');
                } else {
                    this.dom.progressBar.classList.remove('warning');
                }
            }

        };


        // ========== APP DASHBOARD ==========
        const AppDashboard = {
            dom: {
                localTime: null,
                localDate: null,
                weatherIcon: null,
                temp: null,
                weatherDesc: null,
                toolsTbody: null,
                detailModal: null,
                detailModalBody: null,
                modalClose: null,
                modalClose2: null,
                mciToast: null,
                statusPie: null,
                visitorTrendChart: null,
            },

            charts: {
                pie: null,
                visitorTrend: null,
            },

            init() {
                this.cacheDom();
                this.bindEvents();
                this.updateTime();
                setInterval(() => this.updateTime(), 1000);
                this.initWeather();
                this.initCharts();
                PrayerTimes.init();
            },

            cacheDom() {
                this.dom.localTime = document.getElementById('localTime');
                this.dom.localDate = document.getElementById('localDate');
                this.dom.weatherIcon = document.getElementById('weatherIcon');
                this.dom.temp = document.getElementById('temp');
                this.dom.weatherDesc = document.getElementById('weatherDesc');
                this.dom.toolsTbody = document.getElementById('toolsTbody');
                this.dom.detailModal = document.getElementById('detailModal');
                this.dom.detailModalBody = document.getElementById('modalBody');
                this.dom.modalClose = document.getElementById('modalClose');
                this.dom.modalClose2 = document.getElementById('modalClose2');
                this.dom.mciToast = document.getElementById('mciToast');
                this.dom.statusPie = document.getElementById('statusPie');
                this.dom.visitorTrendChart = document.getElementById('visitorTrendChart');
            },

            bindEvents() {
                this.dom.modalClose?.addEventListener('click', () => this.closeModal());
                this.dom.modalClose2?.addEventListener('click', () => this.closeModal());
                this.dom.detailModal?.addEventListener('click', (e) => {
                    if (e.target === this.dom.detailModal || e.target.classList.contains('backdrop')) {
                        this.closeModal();
                    }
                });
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.dom.detailModal?.classList.contains('show')) {
                        this.closeModal();
                    }
                });
                this.dom.toolsTbody?.addEventListener('click', (e) => {
                    const btn = e.target.closest('[data-action="detail"]');
                    if (!btn) return;
                    const tr = btn.closest('tr[data-tool]');
                    if (!tr) return;
                    try {
                        const data = JSON.parse(tr.getAttribute('data-tool') || '{}');
                        this.openModal(data);
                    } catch (err) {
                        console.error('Parse error:', err);
                    }
                });
            },

            updateTime() {
                const now = new Date();
                if (this.dom.localTime) {
                    this.dom.localTime.textContent = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false,
                    });
                }
                if (this.dom.localDate) {
                    this.dom.localDate.textContent = now.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric',
                    });
                }
            },

            initWeather() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (pos) => this.fetchWeather(pos.coords.latitude, pos.coords.longitude),
                        () => this.fetchWeather(-6.2383, 106.9892), {
                            timeout: 6000,
                            maximumAge: 60000
                        }
                    );
                } else {
                    this.fetchWeather(-6.2383, 106.9892);
                }
            },

            fetchWeather(lat, lon) {
                const url =
                    `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`;
                fetch(url)
                    .then(r => r.json())
                    .then(data => this.renderWeather(data))
                    .catch(() => this.renderWeather(null));
            },

            renderWeather(data) {
                if (!data?.current_weather) {
                    if (this.dom.temp) this.dom.temp.textContent = '--°C';
                    if (this.dom.weatherDesc) this.dom.weatherDesc.textContent = 'Cuaca tidak tersedia';
                    return;
                }
                const cw = data.current_weather;
                if (this.dom.temp) this.dom.temp.textContent = Math.round(cw.temperature) + '°C';
                const code = cw.weathercode;
                const icon = code === 0 ? '☀️' : (code <= 3 ? '⛅' : (code <= 48 ? '🌫️' : (code <= 77 ? '🌧️' :
                    '🌦️')));
                if (this.dom.weatherIcon) this.dom.weatherIcon.textContent = icon;
                if (this.dom.weatherDesc) {
                    this.dom.weatherDesc.textContent = code === 0 ? 'Cerah' : 'Berawan / Hujan ringan';
                }
            },

            initCharts() {
                this.initPieChart();
                this.initVisitorTrendChart();
            },

            initPieChart() {
                if (!this.dom.statusPie || !window.Chart) return;
                const ctx = this.dom.statusPie.getContext('2d');
                if (this.charts.pie) this.charts.pie.destroy();

                const pd = window._pieData || {
                    ok: 0,
                    proses: 0,
                    due: 0
                };

                const centerText = {
                    id: 'centerText',
                    afterDraw: (chart) => {
                        const total = chart.data.datasets[0].data.reduce((a, b) => a + (b || 0), 0) || 0;
                        const ctx = chart.ctx;
                        const x = (chart.chartArea.left + chart.chartArea.right) / 2;
                        const y = (chart.chartArea.top + chart.chartArea.bottom) / 2;
                        ctx.save();
                        ctx.fillStyle = '#08306b';
                        ctx.font = '600 18px Inter, system-ui, Arial';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(total, x, y - 8);
                        ctx.font = '500 12px Inter, system-ui, Arial';
                        ctx.fillStyle = '#6b7280';
                        ctx.fillText('Total', x, y + 16);
                        ctx.restore();
                    },
                };

                this.charts.pie = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['OK', 'Proses', 'Due'],
                        datasets: [{
                            data: [pd.ok || 0, pd.proses || 0, pd.due || 0],
                            backgroundColor: ['#16a34a', '#f59e0b', '#dc2626'],
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                    },
                    plugins: [centerText],
                });
            },

            initVisitorTrendChart() {
                if (!this.dom.visitorTrendChart || !window.Chart) return;
                const ctx = this.dom.visitorTrendChart.getContext('2d');
                if (this.charts.visitorTrend) this.charts.visitorTrend.destroy();

                const trendData = window._visitorTrend || {
                    labels: [],
                    data: []
                };
                const labels = trendData.labels || [];
                const values = trendData.data || [];

                const grad = ctx.createLinearGradient(0, 0, 0, 180);
                grad.addColorStop(0, 'rgba(37, 99, 235, 0.15)');
                grad.addColorStop(1, 'rgba(37, 99, 235, 0.02)');

                this.charts.visitorTrend = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pengunjung',
                            data: values,
                            fill: true,
                            backgroundColor: grad,
                            borderColor: '#2563eb',
                            borderWidth: 2.5,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#2563eb',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                        }],
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
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        size: 12
                                    }
                                },
                                grid: {
                                    color: 'rgba(96, 165, 250, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        size: 12
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    },
                });
            },

            openModal(data) {
                if (!this.dom.detailModal || !this.dom.detailModalBody) return;
                document.getElementById('modalTitle').textContent = data.nama || 'Detail';
                this.dom.detailModalBody.innerHTML = `
                <div>
                    <div style="margin-bottom:12px;">
                        <strong>Nama</strong>
                        <div class="muted">${this.escapeHtml(data.nama || '-')}</div>
                    </div>
                    <div style="margin-bottom:12px;">
                        <strong>Merk</strong>
                        <div class="muted">${this.escapeHtml(data.merek || '-')}</div>
                    </div>
                </div>
                <div>
                    <div style="margin-bottom:12px;">
                        <strong>No. Seri</strong>
                        <div class="muted">${this.escapeHtml(data.no_seri || '-')}</div>
                    </div>
                    <div style="margin-bottom:12px;">
                        <strong>Status</strong>
                        <div class="muted">${this.escapeHtml(data.history?.status || '-')}</div>
                    </div>
                </div>
                <div style="grid-column:1/-1; margin-bottom:12px;">
                    <strong>Tgl Kalibrasi Ulang</strong>
                    <div class="muted">${this.escapeHtml(data.history?.tgl_kalibrasi_ulang || '-')}</div>
                </div>
                <div style="grid-column:1/-1;">
                    <strong>Keterangan</strong>
                    <div class="muted">${this.escapeHtml(data.history?.keterangan || '-')}</div>
                </div>
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

            showToast(msg, ms = 2000) {
                if (!this.dom.mciToast) return;
                this.dom.mciToast.textContent = msg;
                this.dom.mciToast.classList.add('show');
                this.dom.mciToast.setAttribute('aria-hidden', 'false');
                setTimeout(() => {
                    this.dom.mciToast.classList.remove('show');
                    this.dom.mciToast.setAttribute('aria-hidden', 'true');
                }, ms);
            },

            escapeHtml(s) {
                if (s === null || s === undefined) return '';
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;',
                    '`': '&#96;',
            };
            return String(s).replace(/[&<>"'`]/g, m => map[m]);
            },
        };

        // ========== INIT ON DOM READY ==========
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => AppDashboard.init());
        } else {
            AppDashboard.init();
        }
    </script>
@endpush
