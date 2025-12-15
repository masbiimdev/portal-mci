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
                    <div data-i18n="Dashboard">User</div>
                </a>
            </li>
        @endif
        {{-- Announcement --}}
        <li class="menu-item {{ request()->routeIs('announcements.index') ? 'active' : '' }}">
            <a href="{{ route('announcements.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-volume-full"></i>
                <div data-i18n="Dashboard">Announcement</div>
            </a>
        </li>
        {{-- Access Managemen --}}
        @if (Auth::check() && Auth::user()->role === 'SUP')
            <li class="menu-item {{ request()->routeIs('module.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-key"></i>
                    <div data-i18n="Schedule">Management Access</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('modules.index') ? 'active' : '' }}">
                        <a href="{{ route('modules.index') }}" class="menu-link">
                            <div data-i18n="Daily">Module</div>
                        </a>
                    </li>
                </ul>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('access.user') ? 'active' : '' }}">
                        <a href="{{ route('access.user') }}" class="menu-link">
                            <div data-i18n="Daily">User Access</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
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
        {{-- <li class="menu-item {{ request()->routeIs('jobcards.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-building"></i>
                <div data-i18n="Schedule">Production</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('jobcards.index') ? 'active' : '' }}">
                    <a href="{{ route('jobcards.index') }}" class="menu-link">
                        <div data-i18n="Daily">Jobcard </div>
                    </a>
                </li>
            </ul>
        </li> --}}
        {{-- Project --}}
        {{-- <li class="menu-item {{ request()->routeIs('jobcards.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-building"></i>
                <div data-i18n="Schedule">Project</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('jobcards.index') ? 'active' : '' }}">
                    <a href="{{ route('jobcards.index') }}" class="menu-link">
                        <div data-i18n="Daily">PO</div>
                    </a>
                </li>
            </ul>
        </li> --}}
        {{-- QUALITY CONTROL MENU --}}
        <li class="menu-item {{ request()->routeIs('qc.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-check-shield"></i>
                <div data-i18n="Quality Control">Quality Control</div>
            </a>
            <ul class="menu-sub">

                {{-- QC Overview --}}

                {{-- Calibration Module --}}
                <li class="menu-item {{ request()->routeIs('tools.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Kalibrasi">Kalibrasi</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('kalibrasi.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('kalibrasi.dashboard') }}" class="menu-link">
                                <div data-i18n="Dashboard">Dashboard</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('tools.index') ? 'active' : '' }}">
                            <a href="{{ route('tools.index') }}" class="menu-link">
                                <div data-i18n="Master Alat">Master Alat</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('histories') ? 'active' : '' }}">
                            <a href="{{ route('histories.index') }}" class="menu-link">
                                <div data-i18n="History Kalibrasi">History Kalibrasi</div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Preventive Maintenance --}}
                {{-- <li class="menu-item {{ request()->routeIs('qc.pm.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Preventive Maintenance">Preventive Maintenance</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('qc.pm.assets.index') ? 'active' : '' }}">
                            <a href="javascript:void(0);" class="menu-link">
                                <div data-i18n="Master Asset">Master Asset</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('qc.pm.schedule.index') ? 'active' : '' }}">
                            <a href="javascript:void(0);" class="menu-link">
                                <div data-i18n="PM Schedule">PM Schedule</div>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                {{-- Inspection Checklist --}}
                {{-- <li class="menu-item {{ request()->routeIs('qc.inspection.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Inspection">Inspection</div>
                    </a>
                    <ul class="menu-sub">
                        <li
                            class="menu-item {{ request()->routeIs('qc.inspection.templates.index') ? 'active' : '' }}">
                            <a href="javascript:void(0);" class="menu-link">
                                <div data-i18n="Template Checklist">Template Checklist</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('qc.inspection.records.index') ? 'active' : '' }}">
                            <a href="javascript:void(0);" class="menu-link">
                                <div data-i18n="Inspection Records">Records</div>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                {{-- NCR / Non Conformance --}}
                {{-- <li class="menu-item {{ request()->routeIs('qc.ncr.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="NCR">NCR</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('qc.ncr.index') ? 'active' : '' }}">
                            <a href="javascript:void(0);" class="menu-link">
                                <div data-i18n="Daftar NCR">Daftar NCR</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('qc.ncr.create') ? 'active' : '' }}">
                            <a href="javascript:void(0);" class="menu-link">
                                <div data-i18n="Input NCR">Input NCR</div>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                {{-- QC Reports --}}
                {{-- <li class="menu-item {{ request()->routeIs('qc.reports.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Reports">Reports</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link">
                                <div data-i18n="Calibration Report">Calibration Report</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link">
                                <div data-i18n="PM Report">PM Report</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link">
                                <div data-i18n="Inspection Report">Inspection Report</div>
                            </a>
                        </li>
                    </ul>
                </li> --}}

            </ul>
        </li>

        {{-- INVENTORY MENU --}}
        <li class="menu-item {{ request()->routeIs('inventory.*') ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Inventory">Inventory</div>
            </a>
            <ul class="menu-sub">

                {{-- Dashboard --}}
                <li class="menu-item {{ request()->routeIs('inventory.index') ? 'active open' : '' }}">
                    <a href="{{ route('inventory.index') }}" class="menu-link">
                        <div data-i18n="Dashboard">Dashboard</div>
                    </a>
                </li>

                {{-- Master Data --}}
                <li class="menu-item {{ request()->routeIs('valves.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Master Data">Master Data</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('spare-parts.index') ? 'active open' : '' }}">
                            <a href="{{ route('spare-parts.index') }}" class="menu-link">
                                <div data-i18n="Spare Part">Spare Part</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('valves.index') ? 'active open' : '' }}">
                            <a href="{{ route('valves.index') }}" class="menu-link">
                                <div data-i18n="Category">Valve</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('racks.index') ? 'active open' : '' }}">
                            <a href="{{ route('racks.index') }}" class="menu-link">
                                <div data-i18n="Rack">Rack</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('materials.index') ? 'active open' : '' }}">
                            <a href="{{ route('materials.index') }}" class="menu-link">
                                <div data-i18n="Material">Material</div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Transactions --}}
                <li class="menu-item ">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Transactions">Transactions</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('material_in.index') ? 'active open' : '' }}">
                            <a href="{{ route('material_in.index') }}" class="menu-link">
                                <div data-i18n="Material In">Material In</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('material_out.index') ? 'active open' : '' }}">
                            <a href="{{ route('material_out.index') }}" class="menu-link">
                                <div data-i18n="Material Out">Material Out</div>
                            </a>
                        </li>
                        {{-- <li
                            class="menu-item ">
                            <a href="#" class="menu-link">
                                <div data-i18n="Transfer">Transfer</div>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                {{-- Stock Management --}}
                <li class="menu-item ">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Stock Management">Stock Management</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item ">
                            <a href="{{ route('stock-card.index') }}" class="menu-link">
                                <div data-i18n="Stock Card">Stock Card</div>
                            </a>
                        </li>
                        <li class="menu-item ">
                            <a href="{{ route('stock-opname.index') }}" class="menu-link">
                                <div data-i18n="Stock Opname">Stock Opname</div>
                            </a>
                        </li>
                        {{-- <li class="menu-item ">
                            <a href="#" class="menu-link">
                                <div data-i18n="Adjustment">Adjustment</div>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                {{-- Reports --}}
                <li class="menu-item ">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Reports">Reports</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('report.stock-summary') }}" class="menu-link">
                                <div data-i18n="Stock Summary">Stock Summary</div>
                            </a>
                        </li>
                        {{-- <li class="menu-item ">
                            <a href="#" class="menu-link">
                                <div data-i18n="Stock Movement">Stock Movement</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Inventory Valuation">Inventory Valuation</div>
                            </a>
                        </li> --}}
                    </ul>
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
