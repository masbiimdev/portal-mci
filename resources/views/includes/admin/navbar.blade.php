<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <button class="nav-item nav-link px-0 me-xl-4 btn btn-ghost" type="button" aria-label="Toggle menu">
            <i class="bx bx-menu bx-sm"></i>
        </button>
    </div>

    @php
        $user = Auth::user();
        $userName = $user ? $user->name : 'User';
        $firstName = explode(' ', trim($userName))[0]; // Mengambil nama depan saja

        $avatarPath = public_path('images/metinca-logo.jpeg');
        $avatarUrl = file_exists($avatarPath) ? asset('images/metinca-logo.jpeg') : null;

        // Build initials safely (Max 2 chars)
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

    <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">

        <div class="navbar-nav align-items-center d-none d-md-flex">
            <div class="nav-greeting">
                <span class="text-muted">Selamat bekerja,</span>
                <strong class="text-heading ms-1">{{ $firstName }}</strong>
                <span class="wave-emoji">👋</span>
            </div>
        </div>

        <div class="nav-smart-info d-none d-lg-flex mx-auto align-items-center gap-2">
            <div class="info-pill clock-pill" title="Waktu Saat Ini">
                <i class="bx bx-time-five"></i>
                <span id="live-clock">--:--:--</span>
            </div>

            <div class="info-pill weather-pill" title="Cuaca Jakarta Timur">
                <i class="bx bx-sun"></i>
                <span id="live-weather">32°C Cerah</span>
            </div>

            <div class="info-pill prayer-pill" title="Jadwal Sholat Terdekat">
                <i class="bx bx-mosque"></i>
                <span id="prayer-countdown">Menghitung...</span>
            </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto gap-2 gap-sm-3">

            <li class="nav-item d-none d-sm-flex align-items-center">
                <a href="{{ route('home') }}" class="btn-premium-portal" title="Menuju ke halaman portal">
                    <i class="bx bx-globe"></i>
                    <span>Portal</span>
                </a>
            </li>

            <li class="nav-item d-flex align-items-center">
                <button class="action-icon-btn position-relative" title="Notifikasi">
                    <i class="bx bx-bell"></i>
                    <span class="pulse-indicator"></span>
                </button>
            </li>

            <div class="nav-divider d-none d-sm-block"></div>

            <li class="nav-item d-flex align-items-center profile-block">
                <div class="avatar-wrapper">
                    @if ($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="avatar" class="user-avatar">
                    @else
                        <div class="user-avatar-initial">
                            {{ $initials }}
                        </div>
                    @endif
                    <span class="status-online"></span>
                </div>

                <div class="user-info d-none d-md-flex flex-column justify-content-center ms-2">
                    <span class="user-name">{{ \Illuminate\Support\Str::limit($userName, 18) }}</span>
                    <span class="user-role">{{ $user->role ?? 'Operator' }}</span>
                </div>
            </li>

            <li class="nav-item d-flex align-items-center ms-1">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="action-icon-btn logout-btn" title="Keluar / Logout"
                        onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
                        <i class="bx bx-power-off"></i>
                    </button>
                </form>
            </li>

        </ul>
    </div>

    <style>
        /* ============== NAVBAR CORE ============== */
        #layout-navbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(226, 232, 240, 0.7);
            border-radius: 16px;
            box-shadow: 0 4px 20px -5px rgba(15, 23, 42, 0.05), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
            margin-top: 1rem;
            margin-bottom: 1rem;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }

        /* ============== GREETING ============== */
        .nav-greeting {
            font-size: 0.95rem;
            background: rgba(241, 245, 249, 0.6);
            padding: 0.4rem 1rem;
            border-radius: 999px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            white-space: nowrap;
        }

        .text-heading {
            color: #0f172a;
            font-weight: 800;
        }

        .wave-emoji {
            display: inline-block;
            animation: wave 2.5s infinite;
            transform-origin: 70% 70%;
        }

        @keyframes wave {

            0%,
            60%,
            100% {
                transform: rotate(0.0deg)
            }

            10%,
            30% {
                transform: rotate(14.0deg)
            }

            20%,
            40% {
                transform: rotate(-8.0deg)
            }

            50% {
                transform: rotate(10.0deg)
            }
        }

        /* ============== SMART INFO PILLS ============== */
        .nav-smart-info {
            background: rgba(248, 250, 252, 0.7);
            padding: 0.3rem;
            border-radius: 12px;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .info-pill {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.3rem 0.8rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: default;
            transition: all 0.2s;
        }

        .info-pill i {
            font-size: 1.1rem;
        }

        .clock-pill {
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
        }

        .weather-pill {
            color: #f59e0b;
            background: rgba(245, 158, 11, 0.1);
        }

        .prayer-pill {
            color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }

        .info-pill:hover {
            filter: brightness(0.95);
            transform: translateY(-1px);
        }

        /* ============== ACTION ICONS & PORTAL ============== */
        .action-icon-btn {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: transparent;
            border: 1px solid transparent;
            color: #64748b;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .action-icon-btn i {
            font-size: 1.35rem;
        }

        .action-icon-btn:hover {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #0f172a;
            transform: translateY(-2px) scale(1.05);
        }

        .logout-btn:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #dc2626;
        }

        /* Pulse Indicator */
        .pulse-indicator {
            position: absolute;
            top: 8px;
            right: 10px;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid #ffffff;
        }

        .pulse-indicator::after {
            content: "";
            position: absolute;
            top: -2px;
            left: -2px;
            width: 100%;
            height: 100%;
            background-color: #ef4444;
            border-radius: 50%;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        .btn-premium-portal {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 1rem;
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            color: #ffffff !important;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            border: none;
            box-shadow: 0 4px 10px -2px rgba(37, 99, 235, 0.4);
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .btn-premium-portal:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 15px -2px rgba(37, 99, 235, 0.5);
            background: linear-gradient(135deg, #1d4ed8 0%, #4338ca 100%);
        }

        .nav-divider {
            height: 28px;
            width: 1px;
            margin: 0 0.2rem;
            background: linear-gradient(to bottom, transparent, #cbd5e1, transparent);
        }

        /* ============== USER PROFILE ============== */
        .profile-block {
            padding: 0.35rem;
            border-radius: 14px;
            transition: background 0.2s;
            cursor: default;
        }

        .profile-block:hover {
            background: #f1f5f9;
        }

        .avatar-wrapper {
            position: relative;
            display: inline-block;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .user-avatar-initial {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #0f172a, #334155);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-weight: 800;
            font-size: 1rem;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .status-online {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background-color: #10b981;
            border-radius: 50%;
            border: 2px solid #ffffff;
        }

        .user-info .user-name {
            font-size: 0.85rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .user-info .user-role {
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        @media (max-width: 992px) {
            #layout-navbar {
                margin-top: 0.5rem;
                border-radius: 12px;
                padding: 0.5rem 1rem;
            }
        }
    </style>
</nav>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // 1. FUNGSI JAM REALTIME
            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                document.getElementById('live-clock').textContent = `${hours}:${minutes}:${seconds} WIB`;
            }
            setInterval(updateClock, 1000);
            updateClock();

            // 2. FUNGSI COUNTDOWN SHOLAT (Waktu Estimasi Jakarta)
            // Catatan: Ini adalah waktu statis rata-rata. Untuk akurasi harian, gunakan API Aladhan.
            const prayerSchedules = [{
                    name: 'Subuh',
                    time: '04:45'
                },
                {
                    name: 'Dzuhur',
                    time: '12:05'
                },
                {
                    name: 'Ashar',
                    time: '15:15'
                },
                {
                    name: 'Maghrib',
                    time: '18:05'
                },
                {
                    name: 'Isya',
                    time: '19:15'
                }
            ];

            function updatePrayerCountdown() {
                const now = new Date();
                const currentTotalMinutes = (now.getHours() * 60) + now.getMinutes();

                let nextPrayer = null;
                let targetMinutes = 0;

                // Cari sholat terdekat hari ini
                for (let prayer of prayerSchedules) {
                    let [p_hours, p_minutes] = prayer.time.split(':').map(Number);
                    let p_totalMinutes = (p_hours * 60) + p_minutes;

                    if (p_totalMinutes > currentTotalMinutes) {
                        nextPrayer = prayer;
                        targetMinutes = p_totalMinutes;
                        break;
                    }
                }

                // Jika semua sholat hari ini sudah lewat, targetnya Subuh besok
                if (!nextPrayer) {
                    nextPrayer = prayerSchedules[0]; // Subuh
                    let [s_hours, s_minutes] = nextPrayer.time.split(':').map(Number);
                    targetMinutes = (24 * 60) + (s_hours * 60) + s_minutes; // Tambah 24 jam
                }

                // Hitung selisih waktu
                let diffMinutes = targetMinutes - currentTotalMinutes;
                let diffH = Math.floor(diffMinutes / 60);
                let diffM = diffMinutes % 60;

                let countdownText = `${nextPrayer.name} dalam `;
                if (diffH > 0) countdownText += `${diffH}j `;
                countdownText += `${diffM}m`;

                // Jika waktunya tiba (selisih kurang dari 5 menit)
                if (diffMinutes <= 5 && diffMinutes >= 0) {
                    countdownText = `Waktu ${nextPrayer.name} tiba!`;
                    document.querySelector('.prayer-pill').style.backgroundColor = 'rgba(239, 68, 68, 0.1)';
                    document.querySelector('.prayer-pill').style.color = '#ef4444'; // Berubah merah
                } else {
                    document.querySelector('.prayer-pill').style.backgroundColor = 'rgba(16, 185, 129, 0.1)';
                    document.querySelector('.prayer-pill').style.color = '#10b981';
                }

                document.getElementById('prayer-countdown').textContent = countdownText;
            }

            // Jalankan penghitung sholat setiap 1 menit
            setInterval(updatePrayerCountdown, 60000);
            updatePrayerCountdown();
        });
    </script>
@endpush
