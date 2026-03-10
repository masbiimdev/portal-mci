<style>
    /* ============== CUSTOM SIDEBAR ENHANCEMENTS ============== */
    .layout-menu {
        border-right: 1px solid rgba(0, 0, 0, 0.05);
        background-color: #ffffff !important;
        /* Tambahan Pola (Pattern) Valve Transparan di Latar Belakang */
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

    /* ============== WIDGET BAWAH GAYA JEPANG (DYNAMIC ZEN) ============== */
    .sidebar-bottom-widget {
        padding: 1.5rem 1.25rem 1.5rem 1.25rem;
        flex-shrink: 0;
        margin-top: auto;
        position: relative;
        z-index: 2;
    }

    .zen-sakura-card {
        background: linear-gradient(135deg, #fff5f6 0%, #fee2e9 100%);
        border-radius: 12px;
        padding: 1.25rem 1rem;
        position: relative;
        overflow: hidden;
        border: 1px solid #fecdd3;
        box-shadow: 0 4px 15px rgba(251, 113, 133, 0.1);
        cursor: default;
        transition: transform 0.3s ease;
    }

    .zen-sakura-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(251, 113, 133, 0.2);
    }

    /* Area Animasi Kelopak */
    .sakura-rain {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        pointer-events: none;
        /* Mencegah bug klik */
    }

    /* Styling Kelopak Sakura yang lebih realistis dengan gradasi */
    .petal {
        position: absolute;
        background: linear-gradient(135deg, #fda4af, #fecdd3);
        border-radius: 100% 0 100% 0;
        opacity: 0;
        box-shadow: 0 2px 4px rgba(251, 113, 133, 0.2);
    }

    /* 1. ANIMASI JATUH (Vertikal) */
    @keyframes fallingDown {
        0% {
            top: -20%;
            opacity: 0;
        }

        15% {
            opacity: 0.85;
        }

        85% {
            opacity: 0.85;
        }

        100% {
            top: 110%;
            opacity: 0;
        }
    }

    /* 2. ANIMASI TERBANG 3D (Berputar & Goyang Kiri Kanan) */
    @keyframes tumbling3D {
        0% {
            transform: translateX(-15px) rotate(0deg) rotateX(0deg) rotateY(0deg);
        }

        50% {
            transform: translateX(20px) rotate(180deg) rotateX(75deg) rotateY(60deg);
        }

        100% {
            transform: translateX(-15px) rotate(360deg) rotateX(0deg) rotateY(120deg);
        }
    }

    /* Set-up 8 Kelopak Bunga agar animasinya acak dan terlihat natural */
    .petal:nth-child(1) {
        width: 12px;
        height: 14px;
        left: 10%;
        animation: fallingDown 6s linear infinite, tumbling3D 3.5s ease-in-out infinite;
        animation-delay: 0s, 0s;
    }

    .petal:nth-child(2) {
        width: 8px;
        height: 10px;
        left: 30%;
        animation: fallingDown 8s linear infinite, tumbling3D 4.5s ease-in-out infinite;
        animation-delay: 2s, 1s;
        filter: blur(0.5px);
    }

    .petal:nth-child(3) {
        width: 14px;
        height: 16px;
        left: 50%;
        animation: fallingDown 5.5s linear infinite, tumbling3D 3s ease-in-out infinite;
        animation-delay: 4s, 2s;
    }

    .petal:nth-child(4) {
        width: 9px;
        height: 11px;
        left: 70%;
        animation: fallingDown 7.5s linear infinite, tumbling3D 4s ease-in-out infinite;
        animation-delay: 1.5s, 0.5s;
        filter: blur(1px);
    }

    .petal:nth-child(5) {
        width: 11px;
        height: 13px;
        left: 85%;
        animation: fallingDown 9s linear infinite, tumbling3D 5s ease-in-out infinite;
        animation-delay: 3s, 1.5s;
    }

    .petal:nth-child(6) {
        width: 7px;
        height: 9px;
        left: 15%;
        animation: fallingDown 6.5s linear infinite, tumbling3D 3.2s ease-in-out infinite;
        animation-delay: 5s, 3s;
        filter: blur(1.5px);
    }

    .petal:nth-child(7) {
        width: 13px;
        height: 15px;
        left: 45%;
        animation: fallingDown 8.5s linear infinite, tumbling3D 4.2s ease-in-out infinite;
        animation-delay: 0.5s, 2.5s;
    }

    .petal:nth-child(8) {
        width: 10px;
        height: 12px;
        left: 80%;
        animation: fallingDown 7s linear infinite, tumbling3D 3.8s ease-in-out infinite;
        animation-delay: 3.5s, 0s;
    }


    /* 3. ANIMASI GELOMBANG MENGALIR */
    .japan-waves {
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 40px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 150'%3E%3Cpath fill='%23fb7185' fill-opacity='0.15' d='M0,150 C120,130 140,130 250,150 C360,130 380,130 500,150 C620,130 640,130 800,150 L800,150 L0,150 Z'%3E%3C/path%3E%3Cpath fill='%23fb7185' fill-opacity='0.1' d='M0,150 C120,110 140,110 250,150 C360,110 380,110 500,150 C620,110 640,110 800,150 L800,150 L0,150 Z'%3E%3C/path%3E%3Cpath fill='%23fb7185' fill-opacity='0.05' d='M0,150 C120,90 140,90 250,150 C360,90 380,90 500,150 C620,90 640,90 800,150 L800,150 L0,150 Z'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: repeat-x;
        /* Ulangi secara horizontal */
        background-size: 400px 40px;
        /* Lebar 400px per pola */
        background-position: 0 bottom;
        animation: oceanFlow 12s linear infinite;
        /* Animasi ombak berjalan */
        z-index: 0;
    }

    /* Efek ombak berjalan ke arah kiri tanpa batas */
    @keyframes oceanFlow {
        0% {
            background-position: 0 bottom;
        }

        100% {
            background-position: -400px bottom;
        }
    }

    /* Teks Status */
    .zen-status-content {
        position: relative;
        z-index: 2;
        text-align: center;
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
        <div class="zen-sakura-card">

            <div class="sakura-rain">
                <div class="petal"></div>
                <div class="petal"></div>
                <div class="petal"></div>
                <div class="petal"></div>
                <div class="petal"></div>
                <div class="petal"></div>
                <div class="petal"></div>
                <div class="petal"></div>
            </div>

            <div class="japan-waves"></div>

            <div class="zen-status-content">
                <i class='bx bx-wind text-rose-400 mb-1' style="font-size: 1.25rem; color: #fb7185;"></i>
                <h6 class="fw-bold mb-1" style="font-size: 0.8rem; color: #881337;">Metinca Portal</h6>
                <p class="mb-0" style="font-size: 0.7rem; color: #db2777; font-weight: 500; letter-spacing: 0.5px;">
                    メティンカ (v1.0)</p>
            </div>
        </div>
    </div>

</aside>
