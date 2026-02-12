<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-text demo fw-bolder ms-2">Metinca Portal .</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        {{-- user --}}
        @if (Auth::check() && Auth::user()->role === 'SUP')
            <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div>User</div>
                </a>
            </li>
        @endif

        {{-- Announcement --}}
        <li class="menu-item {{ request()->routeIs('announcements.index') ? 'active' : '' }}">
            <a href="{{ route('announcements.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-volume-full"></i>
                <div>Announcement</div>
            </a>
        </li>

        {{-- Access Management --}}
        @if (Auth::check() && Auth::user()->role === 'SUP')
            <li class="menu-item {{ request()->routeIs('module.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-key"></i>
                    <div>Management Access</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('modules.index') ? 'active' : '' }}">
                        <a href="{{ route('modules.index') }}" class="menu-link">
                            <div>Module</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('access.user') ? 'active' : '' }}">
                        <a href="{{ route('access.user') }}" class="menu-link">
                            <div>User Access</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- Schedule --}}
        <li class="menu-item {{ request()->routeIs('activities.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div>Schedule</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('activities.index') ? 'active' : '' }}">
                    <a href="{{ route('activities.index') }}" class="menu-link">
                        <div>Witness / Meeting / Other</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- QUALITY CONTROL --}}
        <li class="menu-item {{ request()->routeIs('qc.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-check-shield"></i>
                <div>Quality Control</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('tools.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div>Kalibrasi</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('kalibrasi.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('kalibrasi.dashboard') }}" class="menu-link">
                                <div>Dashboard</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('tools.index') ? 'active' : '' }}">
                            <a href="{{ route('tools.index') }}" class="menu-link">
                                <div>Master Alat</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('histories.index') ? 'active' : '' }}">
                            <a href="{{ route('histories.index') }}" class="menu-link">
                                <div>History Kalibrasi</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        {{-- INVENTORY --}}
        <li class="menu-item {{ request()->routeIs('inventory.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div>Inventory</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('inventory.index') ? 'active' : '' }}">
                    <a href="{{ route('inventory.index') }}" class="menu-link">
                        <div>Dashboard</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('valves.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div>Master Data</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('spare-parts.index') ? 'active' : '' }}">
                            <a href="{{ route('spare-parts.index') }}" class="menu-link">
                                <div>Spare Part</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('valves.index') ? 'active' : '' }}">
                            <a href="{{ route('valves.index') }}" class="menu-link">
                                <div>Valve</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('racks.index') ? 'active' : '' }}">
                            <a href="{{ route('racks.index') }}" class="menu-link">
                                <div>Rack</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('materials.index') ? 'active' : '' }}">
                            <a href="{{ route('materials.index') }}" class="menu-link">
                                <div>Material</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        {{-- ================= DOCUMENT MENU (NEW) ================= --}}
        <li class="menu-item {{ request()->routeIs('documents.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div>Document</div>
            </a>
            <ul class="menu-sub">
                {{-- Dashboard --}}
                <li class="menu-item {{ request()->routeIs('inventory.index') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div>Dashboard</div>
                    </a>
                </li>
                {{-- Master --}}
                <li class="menu-item {{ request()->routeIs('documents.master.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div>Master</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('') ? 'active' : '' }}">
                            <a href="{{ route('document.project.index') }}" class="menu-link">
                                <div>Project</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('') ? 'active' : '' }}">
                            <a href="{{ route('document.folders.index') }}" class="menu-link">
                                <div>Folder</div>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Document --}}
                <li class="menu-item {{ request()->routeIs('inventory.index') ? 'active' : '' }}">
                    <a href="{{ route('inventory.index') }}" class="menu-link">
                        <div>Document</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- ======================================================= --}}
    </ul>
</aside>
