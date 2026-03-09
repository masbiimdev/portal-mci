<style>
    /* CUSTOM SIDEBAR ENHANCEMENTS */
    .layout-menu {
        border-right: 1px solid rgba(0, 0, 0, 0.05);
        background: #ffffff !important;
        /* Force clean white */
    }

    .app-brand {
        padding: 1.5rem 1.5rem 1rem 1.5rem;
        margin-bottom: 0.5rem;
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
        /* Primary blue dot */
    }

    /* Menu Items Spacing */
    .menu-inner>.menu-item {
        margin-bottom: 0.25rem;
    }

    .menu-link {
        border-radius: 0.5rem;
        margin: 0 1rem;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    /* Override template active state to look more modern */
    .menu-item.active>.menu-link:not(.menu-toggle) {
        background: rgba(59, 130, 246, 0.08) !important;
        color: #2563eb !important;
        box-shadow: none !important;
    }

    .menu-item.active>.menu-link:not(.menu-toggle) i {
        color: #2563eb !important;
    }

    /* Sub-menu styling */
    .menu-sub .menu-link {
        margin: 0 1rem 0 2.5rem;
        /* Indent sub menus */
        padding-left: 1rem;
        position: relative;
    }

    /* Add little dot to sub menus */
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

    /* Menu Headers (Section titles) */
    .menu-header {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        padding: 1.5rem 1.5rem 0.5rem 1.5rem;
        font-weight: 700;
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link flex align-items-center">
            <div
                style="background: linear-gradient(135deg, #2563eb, #3b82f6); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px; margin-right: 10px;">
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
            class="menu-item {{ request()->routeIs('inventory.*') || request()->routeIs('valves.*') || request()->routeIs('spare-parts.*') || request()->routeIs('racks.*') || request()->routeIs('materials.*') || request()->routeIs('material_in.*') || request()->routeIs('material_out.*') ? 'active open' : '' }}">
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
</aside>
