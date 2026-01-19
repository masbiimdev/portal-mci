<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached bg-navbar-theme py-2" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <button class="nav-item nav-link px-0 me-xl-4 btn btn-ghost" type="button" aria-label="Toggle menu">
            <i class="bx bx-menu bx-sm"></i>
        </button>
    </div>

    @php
        $user = Auth::user();
        $userName = $user ? $user->name : 'User';
        $avatarPath = public_path('images/metinca-logo.jpeg');
        $avatarUrl = file_exists($avatarPath) ? asset('images/metinca-logo.jpeg') : null;

        // Build initials (up to 2 characters) safely
        $parts = preg_split('/\s+/', trim($userName));
        $initials = '';
        if (!empty($parts) && count($parts) > 0) {
            $initials .= strtoupper(substr($parts[0], 0, 1));
            if (count($parts) > 1) {
                $initials .= strtoupper(substr($parts[1], 0, 1));
            }
        }
        if ($initials === '') {
            $initials = strtoupper(substr($userName, 0, 2));
        }
    @endphp

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <!-- Portal button (hidden on very small screens) -->
        <div class="me-3 d-none d-sm-flex align-items-center">
            <a href="{{ route('home') }}" title="Menuju ke halaman portal"
               class="btn btn-sm btn-primary d-flex align-items-center gap-2 shadow-sm">
                <i class="bx bx-globe fs-5"></i>
                <span class="d-none d-md-inline">Menuju Halaman Portal</span>
            </a>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto gap-2">

            <!-- Profile summary (no dropdown) -->
            <li class="nav-item d-flex align-items-center">
                    @if($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="avatar" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;border:1px solid rgba(15,23,42,0.06);">
                    @else
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;font-weight:700">
                            {{ $initials }}
                        </div>
                    @endif
                    <div class="ms-2 d-none d-md-block">
                        <div class="fw-semibold" style="line-height:1;">{{ \Illuminate\Support\Str::limit($userName, 18) }}</div>
                        <div class="small text-muted" style="line-height:1;">{{ $user->role ?? '-' }}</div>
                    </div>
                </a>
            </li>

            <!-- Logout button placed visibly outside any dropdown -->
            <li class="nav-item d-flex align-items-center">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-md btn-outline-danger d-flex align-items-center gap-1">
                        <i class="bx bx-power-off"></i>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <style>
        /* small visual polish */
        #layout-navbar { --bs-navbar-padding-y: .5rem; }
        #layout-navbar .btn-ghost { background: transparent; border: none; color: inherit; }
        #layout-navbar .btn-outline-danger { border-color: rgba(220,53,69,0.12); }
        #layout-navbar .nav-link { color: rgba(15,23,42,0.78); }
        #layout-navbar .nav-link .bx { vertical-align: -.125em; }

        /* avatar hover */
        .rounded-circle:hover { transform: translateY(-1px); transition: transform .12s ease; }

        @media (max-width: 575px) {
            /* compact the profile: show only avatar on the smallest screens */
            #layout-navbar .ms-2 { display:none !important; }
            #layout-navbar .d-none.d-sm-flex { display:none !important; } /* hide portal button on xs */
        }
    </style>
</nav>