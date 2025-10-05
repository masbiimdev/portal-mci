<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-text demo fw-bolder ms-2">ERP System .</span>
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
                    <div data-i18n="Dashboard">User</div>
                </a>
            </li>
        @endif
        {{-- Announcement --}}
        {{-- <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-volume-full"></i>
                <div data-i18n="Dashboard">Pengumuman</div>
            </a>
        </li> --}}
        <!-- Schedule -->
        <li class="menu-item {{ request()->routeIs('activities.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Schedule">Schedule</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('activities.index') ? 'active' : '' }}">
                    <a href="{{ route('activities.index') }}" class="menu-link">
                        <div data-i18n="Daily">Witness/Meeting/Other</div>
                    </a>
                </li>
            </ul>
        </li>       
        <!-- Schedule -->
        <li class="menu-item {{ request()->routeIs('activities.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-building"></i>
                <div data-i18n="Schedule">Production</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('jobcards.index') ? 'active' : '' }}">
                    <a href="{{ route('jobcards.index') }}" class="menu-link">
                        <div data-i18n="Daily">Jobcard      </div>
                    </a>
                </li>
            </ul>
        </li>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
        <!-- Client -->
        {{-- <li class="menu-item {{ request()->is('client*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Client">Client</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('client/list') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="List">Client List</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('client/add') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Add">Add Client</div>
                    </a>
                </li>
            </ul>
        </li> --}}
    </ul>
</aside>
