<style>
    /* ============== CUSTOM SIDEBAR ENHANCEMENTS ============== */
    .layout-menu {
        border-right: 1px solid rgba(0, 0, 0, 0.05);
        background-color: #ffffff !important;
        /* Pola (Pattern) Valve Transparan di Latar Belakang */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cg transform='rotate(-15 60 60)' fill='none' stroke='%233b82f6' stroke-width='1.5' stroke-opacity='0.04'%3E%3Cpolygon points='40,50 40,70 60,60'/%3E%3Cpolygon points='80,50 80,70 60,60'/%3E%3Cline x1='60' y1='60' x2='60' y2='35'/%3E%3Cline x1='45' y1='35' x2='75' y2='35'/%3E%3Ccircle cx='60' cy='60' r='3'/%3E%3C/g%3E%3C/svg%3E") !important;
        background-size: 120px 120px;
        background-repeat: repeat;
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .app-brand {
        padding: 1.5rem 1.5rem 1rem 1.5rem;
        margin-bottom: 0.5rem;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .app-brand-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 1.25rem;
        letter-spacing: -0.5px;
        color: #1e293b;
    }

    .app-brand-text .dot {
        color: #3b82f6;
    }

    /* ============== SCROLLBAR ELEGAN ============== */
    .menu-inner {
        flex-grow: 1;
        overflow-y: auto;
        overflow-x: hidden;
        position: relative;
        z-index: 2;
    }

    .menu-inner::-webkit-scrollbar {
        width: 4px;
    }

    .menu-inner::-webkit-scrollbar-track {
        background: transparent;
    }

    .menu-inner::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.2);
        border-radius: 10px;
    }

    .menu-inner:hover::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.5);
    }

    /* ============== MENU ITEMS ============== */
    .menu-inner>.menu-item {
        margin-bottom: 0.25rem;
    }

    .menu-link {
        border-radius: 0.5rem;
        margin: 0 1rem;
        transition: all 0.2s ease;
        font-weight: 500;
        background: transparent;
    }

    .menu-item.active>.menu-link:not(.menu-toggle) {
        background: rgba(59, 130, 246, 0.08) !important;
        color: #2563eb !important;
        box-shadow: none !important;
        backdrop-filter: blur(2px);
    }

    .menu-item.active>.menu-link:not(.menu-toggle) i {
        color: #2563eb !important;
    }

    /* Sub-menu styling */
    .menu-sub .menu-link {
        margin: 0 1rem 0 2.5rem;
        padding-left: 1rem;
        position: relative;
    }

    .menu-sub .menu-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #cbd5e1;
        transition: all 0.2s ease;
    }

    .menu-sub .menu-item.active>.menu-link::before {
        background-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .menu-sub .menu-link:hover::before {
        background-color: #94a3b8;
    }

    /* Menu Headers */
    .menu-header {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        padding: 1.5rem 1.5rem 0.5rem 1.5rem;
        font-weight: 700;
    }

    /* ============== WIDGET BAWAH GAYA HIGH-TECH INDUSTRIAL ============== */
    .sidebar-bottom-widget {
        padding: 1.5rem 1.25rem 1.5rem 1.25rem;
        flex-shrink: 0;
        margin-top: auto;
        position: relative;
        z-index: 2;
    }

    .industrial-widget-card {
        background: linear-gradient(180deg, #0f172a 0%, #020617 100%);
        border-radius: 16px;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
        border: 1px solid #1e293b;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), inset 0 1px 1px rgba(255, 255, 255, 0.1);
        cursor: default;
        transition: all 0.3s ease;
    }

    .industrial-widget-card:hover {
        border-color: #0ea5e9;
        box-shadow: 0 10px 30px -5px rgba(14, 165, 233, 0.3), inset 0 1px 1px rgba(255, 255, 255, 0.2);
    }

    /* 1. Moving Blueprint Grid */
    .ind-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(56, 189, 248, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(56, 189, 248, 0.05) 1px, transparent 1px);
        background-size: 15px 15px;
        animation: panGrid 15s linear infinite;
        z-index: 0;
    }

    @keyframes panGrid {
        100% {
            background-position: 30px 30px;
        }
    }

    /* 2. Rotating Gears */
    .ind-gear {
        position: absolute;
        opacity: 0.15;
        z-index: 0;
        color: #38bdf8;
    }

    .ind-gear.g1 {
        right: -20px;
        top: -20px;
        width: 100px;
        height: 100px;
        animation: spinGear 20s linear infinite;
    }

    .ind-gear.g2 {
        right: 50px;
        top: 30px;
        width: 60px;
        height: 60px;
        animation: spinGear 12s linear infinite reverse;
    }

    @keyframes spinGear {
        100% {
            transform: rotate(360deg);
        }
    }

    /* 3. Content Layout */
    .ind-content {
        position: relative;
        z-index: 2;
    }

    .ind-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .ind-status-dot {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 8px #10b981;
        animation: pulseHeartbeat 2s infinite;
    }

    @keyframes pulseHeartbeat {
        0% {
            transform: scale(0.95);
            opacity: 0.8;
            box-shadow: 0 0 5px #10b981;
        }

        50% {
            transform: scale(1.1);
            opacity: 1;
            box-shadow: 0 0 12px #10b981;
        }

        100% {
            transform: scale(0.95);
            opacity: 0.8;
            box-shadow: 0 0 5px #10b981;
        }
    }

    .ind-title {
        color: #e2e8f0;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    /* 4. Animated Pressure Gauge */
    .ind-gauge-container {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .ind-gauge {
        width: 65px;
        height: 35px;
        overflow: visible;
        filter: drop-shadow(0 0 4px rgba(14, 165, 233, 0.4));
    }

    .ind-needle {
        transform-origin: 50px 45px;
        animation: needleTwitch 4s infinite alternate ease-in-out;
    }

    @keyframes needleTwitch {
        0% {
            transform: rotate(35deg);
        }

        20% {
            transform: rotate(40deg);
        }

        40% {
            transform: rotate(32deg);
        }

        60% {
            transform: rotate(45deg);
        }

        80% {
            transform: rotate(38deg);
        }

        100% {
            transform: rotate(42deg);
        }
    }

    .ind-value {
        color: #38bdf8;
        font-size: 1.25rem;
        font-weight: 900;
        font-family: monospace;
        line-height: 1;
        text-shadow: 0 0 10px rgba(56, 189, 248, 0.5);
    }

    .ind-unit {
        font-size: 0.6rem;
        color: #94a3b8;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* 5. Dynamic 3D Fluid Pipe */
    .ind-pipe-wrapper {
        position: relative;
        height: 14px;
        background: #0f172a;
        border-radius: 8px;
        border: 1px solid #334155;
        box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.8);
        overflow: hidden;
    }

    .ind-fluid {
        width: 100%;
        height: 100%;
        background: repeating-linear-gradient(-45deg,
                #0ea5e9,
                #0ea5e9 10px,
                #0284c7 10px,
                #0284c7 20px);
        background-size: 28px 28px;
        animation: flowStripe 0.8s linear infinite;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
    }

    @keyframes flowStripe {
        100% {
            background-position: 28px 0;
        }
    }

    .ind-pipe-glare {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 40%;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.3) 0%, transparent 100%);
        border-radius: 8px 8px 0 0;
        pointer-events: none;
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link flex align-items-center">
            <div
                style="background: linear-gradient(135deg, #2563eb, #3b82f6); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px; margin-right: 10px; box-shadow: 0 2px 6px rgba(37,99,235,0.3);">
                M
            </div>
            <span class="app-brand-text demo">Metinca<span class="dot">.</span></span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        {{-- Divider / Header --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">General</span>
        </li>

        {{-- Announcement --}}
        <li class="menu-item {{ request()->routeIs('announcements.index') ? 'active' : '' }}">
            <a href="{{ route('announcements.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-volume-full"></i>
                <div data-i18n="Announcement">Announcement</div>
            </a>
        </li>

        {{-- Access Management (Only for SUP) --}}
        @if (Auth::check() && Auth::user()->role === 'SUP')
            <li
                class="menu-item {{ request()->routeIs('users.*') || request()->routeIs('modules.*') || request()->routeIs('access.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                    <div data-i18n="Access Control">Access Control</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <div data-i18n="User Management">User Management</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('modules.index') ? 'active' : '' }}">
                        <a href="{{ route('modules.index') }}" class="menu-link">
                            <div data-i18n="Module Config">Module Config</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('access.user') ? 'active' : '' }}">
                        <a href="{{ route('access.user') }}" class="menu-link">
                            <div data-i18n="User Access">User Access</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- Divider / Header --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Operations</span>
        </li>

        {{-- Schedule --}}
        <li class="menu-item {{ request()->routeIs('activities.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div data-i18n="Schedule">Schedule</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('activities.index') ? 'active' : '' }}">
                    <a href="{{ route('activities.index') }}" class="menu-link">
                        <div data-i18n="Witness & Meeting">Witness & Meeting</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- QUALITY CONTROL --}}
        <li
            class="menu-item {{ request()->routeIs('kalibrasi.*') || request()->routeIs('tools.*') || request()->routeIs('histories.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-check-shield"></i>
                <div data-i18n="Quality Control">Quality Control</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('kalibrasi.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('kalibrasi.dashboard') }}" class="menu-link">
                        <div data-i18n="Dashboard">Dashboard QC</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('tools.index') ? 'active' : '' }}">
                    <a href="{{ route('tools.index') }}" class="menu-link">
                        <div data-i18n="Master Alat">Master Alat</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('histories.index') ? 'active' : '' }}">
                    <a href="{{ route('histories.index') }}" class="menu-link">
                        <div data-i18n="History Kalibrasi">History Kalibrasi</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- INVENTORY --}}
        <li
            class="menu-item {{ request()->routeIs('inventory.*') || request()->routeIs('valves.*') || request()->routeIs('spare-parts.*') || request()->routeIs('racks.*') || request()->routeIs('materials.*') || request()->routeIs('material_in.*') || request()->routeIs('material_out.*') || request()->routeIs('stock-card.*') || request()->routeIs('stock-opname.*') || request()->routeIs('report.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Inventory">Inventory</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('inventory.index') ? 'active' : '' }}">
                    <a href="{{ route('inventory.index') }}" class="menu-link">
                        <div data-i18n="Dashboard">Dashboard Inventory</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ request()->routeIs('valves.*') || request()->routeIs('spare-parts.*') || request()->routeIs('racks.*') || request()->routeIs('materials.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Master Data">Master Data</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('valves.index') ? 'active' : '' }}">
                            <a href="{{ route('valves.index') }}" class="menu-link">
                                <div>Valve</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('spare-parts.index') ? 'active' : '' }}">
                            <a href="{{ route('spare-parts.index') }}" class="menu-link">
                                <div>Spare Part</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('materials.index') ? 'active' : '' }}">
                            <a href="{{ route('materials.index') }}" class="menu-link">
                                <div>Material</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('racks.index') ? 'active' : '' }}">
                            <a href="{{ route('racks.index') }}" class="menu-link">
                                <div>Rack (Lokasi)</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="menu-item {{ request()->routeIs('material_in.*') || request()->routeIs('material_out.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Transactions">Transactions</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('material_in.index') ? 'active' : '' }}">
                            <a href="{{ route('material_in.index') }}" class="menu-link">
                                <div>Material In (Masuk)</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('material_out.index') ? 'active' : '' }}">
                            <a href="{{ route('material_out.index') }}" class="menu-link">
                                <div>Material Out (Keluar)</div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Stock Management --}}
                <li
                    class="menu-item {{ request()->routeIs('stock-card.*') || request()->routeIs('stock-opname.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Stock Management">Stock Management</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('stock-card.index') ? 'active' : '' }}">
                            <a href="{{ route('stock-card.index') }}" class="menu-link">
                                <div data-i18n="Stock Card">Stock Card</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('stock-opname.index') ? 'active' : '' }}">
                            <a href="{{ route('stock-opname.index') }}" class="menu-link">
                                <div data-i18n="Stock Opname">Stock Opname</div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Reports --}}
                <li class="menu-item {{ request()->routeIs('report.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Reports">Reports</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('report.stock-summary') ? 'active' : '' }}">
                            <a href="{{ route('report.stock-summary') }}" class="menu-link">
                                <div data-i18n="Stock Summary">Stock Summary</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('report.stock-movement') ? 'active' : '' }}">
                            <a href="{{ route('report.stock-movement') }}" class="menu-link">
                                <div data-i18n="Stock Movement">Stock Movement</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        {{-- DOCUMENT MANAGEMENT --}}
        <li
            class="menu-item {{ request()->routeIs('documents.*') || request()->routeIs('document.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="Document">Document Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('document.dashboard') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Dashboard">Dashboard</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ request()->routeIs('document.project.*') || request()->routeIs('document.folders.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Master">Master Data</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('document.project.index') ? 'active' : '' }}">
                            <a href="{{ route('document.project.index') }}" class="menu-link">
                                <div>Project</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('document.folders.index') ? 'active' : '' }}">
                            <a href="{{ route('document.folders.index') }}" class="menu-link">
                                <div>Folder System</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item {{ request()->routeIs('document.files.index') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Files">Files & Documents</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>

    <div class="sidebar-bottom-widget">
        <div class="industrial-widget-card">

            <div class="ind-grid"></div>

            <svg class="ind-gear g1" viewBox="0 0 100 100" fill="currentColor">
                <path
                    d="M50 8C47 8 45 10 45 13L43 20C38 21 34 24 30 27L24 23C22 21 19 22 17 24L11 30C9 32 10 35 12 37L16 43C15 48 15 52 16 57L12 63C10 65 9 68 11 70L17 76C19 78 22 79 24 77L30 73C34 76 38 79 43 80L45 87C45 90 47 92 50 92L58 92C61 92 63 90 63 87L65 80C70 79 74 76 78 73L84 77C86 79 89 78 91 76L97 70C99 68 98 65 96 63L92 57C93 52 93 48 92 43L96 37C98 35 99 32 97 30L91 24C89 22 86 21 84 23L78 27C74 24 70 21 65 20L63 13C63 10 61 8 58 8L50 8ZM50 35C58.28 35 65 41.72 65 50C65 58.28 58.28 65 50 65C41.72 65 35 58.28 35 50C35 41.72 41.72 35 50 35Z" />
            </svg>
            <svg class="ind-gear g2" viewBox="0 0 100 100" fill="currentColor">
                <path
                    d="M50 8C47 8 45 10 45 13L43 20C38 21 34 24 30 27L24 23C22 21 19 22 17 24L11 30C9 32 10 35 12 37L16 43C15 48 15 52 16 57L12 63C10 65 9 68 11 70L17 76C19 78 22 79 24 77L30 73C34 76 38 79 43 80L45 87C45 90 47 92 50 92L58 92C61 92 63 90 63 87L65 80C70 79 74 76 78 73L84 77C86 79 89 78 91 76L97 70C99 68 98 65 96 63L92 57C93 52 93 48 92 43L96 37C98 35 99 32 97 30L91 24C89 22 86 21 84 23L78 27C74 24 70 21 65 20L63 13C63 10 61 8 58 8L50 8ZM50 35C58.28 35 65 41.72 65 50C65 58.28 58.28 65 50 65C41.72 65 35 58.28 35 50C35 41.72 41.72 35 50 35Z" />
            </svg>

            <div class="ind-content">
                <div class="ind-header">
                    <span class="ind-status-dot"></span>
                    <span class="ind-title">Sys Active</span>
                </div>

                <div class="ind-gauge-container">
                    <svg viewBox="0 0 100 50" class="ind-gauge">
                        <path d="M 10 45 A 40 40 0 0 1 90 45" fill="none" stroke="#1e293b" stroke-width="8"
                            stroke-linecap="round" />
                        <path d="M 10 45 A 40 40 0 0 1 70 15" fill="none" stroke="#0ea5e9" stroke-width="8"
                            stroke-linecap="round" />
                        <circle cx="50" cy="45" r="5" fill="#94a3b8" />
                        <line x1="50" y1="45" x2="25" y2="15" stroke="#f8fafc"
                            stroke-width="2.5" stroke-linecap="round" class="ind-needle" />
                    </svg>
                    <div class="ind-value">
                        120 <span class="ind-unit">PSI</span>
                    </div>
                </div>

                <div class="ind-pipe-wrapper">
                    <div class="ind-fluid"></div>
                    <div class="ind-pipe-glare"></div>
                </div>
            </div>

        </div>
    </div>

</aside>
