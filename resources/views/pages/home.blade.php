@extends('layouts.home')
@section('title')
    Home Page | Portal MCI
@endsection

@push('css')
    <style>
        /* Visual polish */
        .hero {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.95), rgba(99, 102, 241, 0.95));
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(2, 6, 23, 0.06);
        }

        .announce-priority-high {
            border-left: 4px solid #ef4444;
        }

        .announce-priority-medium {
            border-left: 4px solid #f59e0b;
        }

        .announce-priority-low {
            border-left: 4px solid #2563eb;
        }

        .focus-ring:focus {
            outline: 3px solid rgba(79, 70, 229, 0.12);
            outline-offset: 2px;
        }

        .small-muted {
            color: #6b7280;
            font-size: .92rem;
        }

        /* card hover lift */
        .lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.08);
        }

        .transition-fast {
            transition: all .18s ease;
        }

        /* responsive tweaks */
        @media (max-width: 640px) {
            .hero {
                padding: 1.25rem;
            }

            .hero h1 {
                font-size: 1.25rem;
            }
        }
    </style>
    <style>
        /* Styles khusus untuk jam & tanggal */
        .time-card {
            min-width: 220px;
        }

        .time-meta {
            display: flex;
            gap: 0.75rem;
            align-items: baseline;
            justify-content: flex-end;
            width: 100%;
        }

        /* Jam besar: monospace, tabular numbers untuk kestabilan lebar digit */
        #localTime {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, "Roboto Mono", "Segoe UI Mono", monospace;
            font-variant-numeric: tabular-nums;
            font-weight: 700;
            font-size: 1.25rem;
            /* 20px */
            color: #0f172a;
            background: linear-gradient(90deg, #111827, #4f46e5);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 0.5px;
        }

        /* Tanggal kecil: pill, subtle background */
        #localDate {
            font-size: 0.72rem;
            /* ~11.5px */
            color: #334155;
            background: rgba(99, 102, 241, 0.08);
            padding: 4px 8px;
            border-radius: 999px;
            border: 1px solid rgba(99, 102, 241, 0.12);
            text-transform: capitalize;
            display: inline-block;
            margin-top: 2px;
        }

        /* container for suhu to align vertically centered with time */
        .suhu-large {
            font-size: 1.6rem;
            /* ~26px */
            font-weight: 800;
            color: #0f172a;
        }

        /* responsive: on very small screens stack time & suhu */
        @media (max-width:420px) {
            .time-meta {
                flex-direction: column;
                align-items: flex-end;
                gap: 6px;
            }

            #localTime {
                font-size: 1.05rem;
            }

            .suhu-large {
                font-size: 1.25rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Header Mini (hero) -->
    <section class="py-6 hero text-white animate-gradient">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl md:text-3xl font-bold tracking-wide">Selamat Datang di Metinca Portal .</h1>
            </div>

            <!-- Ganti dengan blok ini --- suhu dan jam sejajar, tanpa duplikasi -->
            <div class="flex justify-end">
                <div
                    class="bg-white/70 backdrop-blur-md border border-white/40 shadow-md p-4 rounded-2xl flex flex-col items-end time-card transition hover:shadow-lg hover:scale-[1.02] duration-200">
                    <div class="text-xs text-gray-600 mb-1">🌡️ Suhu Saat Ini</div>

                    <!-- SUHU + JAM sejajar -->
                    <div class="time-meta">
                        <!-- Jam (sejajar dengan suhu) -->
                        <div class="flex flex-col items-end" style="line-height:1;">
                            <div id="localTime" class="text-lg" role="timer" aria-live="polite" aria-atomic="true">
                                --:--:--</div>
                        </div>

                        <!-- Suhu (besar) -->
                        <div id="suhu" class="suhu-large leading-none ml-2" aria-live="polite">--°C</div>
                    </div>

                    <div id="cuaca" class="text-sm text-gray-700 flex items-center gap-2 mt-3" aria-live="polite">
                        <span id="weather-icon" class="text-xl" aria-hidden="true">🌤️</span>
                        <span id="weather-text" class="font-medium">Memuat cuaca...</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pengumuman Terbaru -->
    <section class="py-12 bg-gray-50 border-b animate-fadein">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold mb-0 text-gray-800">📢 Pengumuman Terbaru</h2>
                <div class="flex items-center gap-3">
                    {{-- <a href="{{ route('announcements.index') }}" class="text-sm text-sky-600 hover:underline">Lihat Semua
                        Pengumuman</a> --}}
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @php
                    $priorityA = [
                        'high' => 'announce-priority-high',
                        'medium' => 'announce-priority-medium',
                        'low' => 'announce-priority-low',
                    ];
                @endphp

                @forelse ($announcements as $item)
                    @php
                        $prio = $item->priority ?? 'low';
                        $borderClass = $priorityA[$prio] ?? 'announce-priority-low';
                    @endphp

                    <article class="bg-white p-6 rounded-xl shadow transition transform hover:-translate-y-1 lift"
                        aria-labelledby="ann-{{ $item->id }}">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex items-center justify-center h-12 w-12 rounded-lg bg-gradient-to-br from-sky-100 to-indigo-50 text-indigo-600">
                                    <!-- icon -->
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 2v6l4 2-4 2" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>

                            <div class="min-w-0 flex-1">
                                <h3 id="ann-{{ $item->id }}" class="font-semibold text-black-800">{{ $item->title }}
                                </h3>
                                <p class="text-sm text-black-600 mt-1">{{ Str::limit($item->content, 120, '...') }}</p>

                                <div class="mt-3 flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-black-400">oleh <br> {{ $item->author->name ?? 'Admin' }}</span>
                                        @if ($item->expiry_date)
                                            <span class="text-xs text-black-400">Sampai <br>
                                                {{ \Carbon\Carbon::parse($item->expiry_date)->translatedFormat('d M Y') }}</span>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-xs font-medium
                                            {{ $prio === 'high' ? 'bg-red-50 text-red-600' : ($prio === 'medium' ? 'bg-yellow-50 text-yellow-700' : 'bg-blue-50 text-sky-600') }}">
                                            {{ strtoupper($prio) }}
                                        </span>
                                        <a href="{{ url('pengumuman/show/' . Str::slug($item->title)) }}"
                                            class="inline-block px-3 py-1 rounded-lg text-sm text-white
    {{ $prio === 'high' ? 'bg-red-600 hover:bg-red-700' : ($prio === 'medium' ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-sky-600 hover:bg-sky-700') }}
    focus-ring">
                                            Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-10 text-gray-500">
                        Belum ada pengumuman terbaru.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Akses Cepat / Feature Grid -->
    <section class="py-12 bg-white animate-fadein">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-xl font-bold text-gray-800 mb-6">⚡ Akses Cepat</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="/schedule"
                    class="group card-glass p-6 rounded-xl text-center border transition-all duration-200 hover:-translate-y-1 hover:shadow-lg focus-ring">
                    <div class="text-2xl text-sky-600 mb-3"><i class="fas fa-calendar-alt" aria-hidden="true"></i></div>
                    <p class="font-semibold text-gray-800">Jadwal</p>
                </a>

                <a href="/tracking"
                    class="group card-glass p-6 rounded-xl text-center border transition-all duration-200 hover:-translate-y-1 hover:shadow-lg focus-ring">
                    <div class="text-2xl text-green-600 mb-3"><i class="fas fa-search" aria-hidden="true"></i></div>
                    <p class="font-semibold text-gray-800">Tracking</p>
                </a>

                <a href="/portal/inventory"
                    class="group card-glass p-6 rounded-xl text-center border transition-all duration-200 hover:-translate-y-1 hover:shadow-lg focus-ring">
                    <div class="text-2xl text-yellow-600 mb-3"><i class="fas fa-boxes" aria-hidden="true"></i></div>
                    <p class="font-semibold text-gray-800">Inventory</p>
                </a>

                <a href="/kalibrasi"
                    class="group card-glass p-6 rounded-xl text-center border transition-all duration-200 hover:-translate-y-1 hover:shadow-lg focus-ring">
                    <div class="text-2xl text-indigo-600 mb-3"><i class="fas fa-bullhorn" aria-hidden="true"></i></div>
                    <p class="font-semibold text-gray-800">Kalibrasi</p>
                </a>
            </div>

        </div>
    </section>

    <!-- Animations & small scripts -->
    <style>
        @keyframes gradientMove {

            0%,
            100% {
                background-position: 0% 50%
            }

            50% {
                background-position: 100% 50%
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientMove 14s ease infinite;
        }

        @keyframes fadein {
            from {
                opacity: 0;
                transform: translateY(8px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        .animate-fadein {
            animation: fadein .7s ease both;
        }
    </style>

    @push('js')
        <script>
            // Date & Time display (localized)
            function updateDateTime() {
                const dEl = document.getElementById('tanggal');
                if (!dEl) return;
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                dEl.textContent = now.toLocaleDateString('id-ID', options) + ' • ' + now.toLocaleTimeString('id-ID');
            }
            updateDateTime();
            setInterval(updateDateTime, 1000);

            // Weather using Open-Meteo (no API key). Fallback coords: Jakarta.
        </script>
        <script>
            (function() {
                // waktu lokal (jam & tanggal)
                const timeEl = document.getElementById('localTime');
                if (!timeEl) return;

                function updateTime() {
                    const now = new Date();
                    const timeStr = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false
                    });
                    timeEl.textContent = timeStr;
                }

                updateTime();
                setInterval(updateTime, 1000);
                document.addEventListener('visibilitychange', function() {
                    if (document.visibilityState === 'visible') updateTime();
                });

                // (Opsional) jika Anda juga ingin memperbarui suhu dari Open-Meteo di sini,
                // bisa gabungkan fetch weather seperti contoh sebelumnya. Berikut contoh ringan
                // yang hanya memperbarui elemen #suhu dan #weather-* apabila tersedia:
                (function fetchWeatherFallback() {
                    const tempEl = document.getElementById('suhu');
                    const weatherText = document.getElementById('weather-text');
                    const weatherIcon = document.getElementById('weather-icon');
                    if (!tempEl) return;

                    function renderWeather(data) {
                        if (!data || !data.current_weather) {
                            tempEl.textContent = '--°C';
                            if (weatherText) weatherText.textContent = 'Cuaca tidak tersedia';
                            return;
                        }
                        const cw = data.current_weather;
                        const temp = Math.round(cw.temperature);
                        tempEl.textContent = temp + '°C';
                        if (weatherText) weatherText.textContent = cw.weathercode === 0 ? 'Cerah' :
                            'Berawan / Berangin';
                        const code = cw.weathercode;
                        const icon = (code === 0) ? '☀️' : (code <= 3 ? '⛅' : (code <= 48 ? '🌫️' : (code <= 77 ?
                            '🌧️' : '🌦️')));
                        if (weatherIcon) weatherIcon.textContent = icon;
                    }

                    // gunakan geolocation jika tersedia, fallback ke Jakarta
                    function fetchWeather(lat, lon) {
                        const url =
                            `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`;
                        fetch(url).then(r => r.json()).then(json => renderWeather(json)).catch(() => renderWeather(
                            null));
                    }

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(pos) {
                            fetchWeather(pos.coords.latitude, pos.coords.longitude);
                        }, function() {
                            fetchWeather(-6.2088, 106.8456);
                        }, {
                            timeout: 5000
                        });
                    } else {
                        fetchWeather(-6.2088, 106.8456);
                    }
                })();
            })();
        </script>
    @endpush
@endsection
