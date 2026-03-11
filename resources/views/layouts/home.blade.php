<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Portal MCI')</title>

    <link rel="icon" type="image/jpeg"
        href="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/metinca-logo.jpeg'))) }}" />

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/feather-icons"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Navbar Active Link Styling */
        .active-page {
            position: relative;
            color: #1d4ed8;
            /* blue-700 */
            font-weight: 600;
            padding-bottom: 4px;
            transition: color 0.3s ease;
        }

        .active-page::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 100%;
            background-color: #1d4ed8;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .active-page:hover::after,
        .active-page.active-page-current::after {
            transform: scaleX(1);
        }

        .active-page:hover {
            color: #1e40af;
            /* blue-800 */
        }
    </style>

    @stack('css')
</head>

<body
    class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col selection:bg-primary-500 selection:text-white">

    @include('includes.navbar')

    <main class="flex-grow w-full">
        @yield('content')
    </main>

    @include('includes.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Ikon Feather
            feather.replace();

            // --- Logika Menu Navbar (Pengamanan agar tidak error jika ID tidak ada) ---
            const notifBtn = document.getElementById("notifBtn");
            const notifMenu = document.getElementById("notifMenu");
            if (notifBtn && notifMenu) {
                notifBtn.addEventListener("click", () => notifMenu.classList.toggle("hidden"));
            }

            const userBtn = document.getElementById("userBtn");
            const userMenu = document.getElementById("userMenu");
            if (userBtn && userMenu) {
                userBtn.addEventListener("click", () => userMenu.classList.toggle("hidden"));
            }

            const hamburger = document.getElementById("hamburger");
            const mobileMenu = document.getElementById("mobileMenu");
            if (hamburger && mobileMenu) {
                hamburger.addEventListener("click", () => mobileMenu.classList.toggle("hidden"));
            }

            // --- Tanggal Otomatis ---
            const tanggalEl = document.getElementById("tanggal");
            if (tanggalEl) {
                const namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                const namaBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                    "September", "Oktober", "November", "Desember"
                ];
                const now = new Date();
                tanggalEl.innerText =
                    `${namaHari[now.getDay()]}, ${now.getDate()} ${namaBulan[now.getMonth()]} ${now.getFullYear()}`;
            }

            // --- Cuaca Realtime ---
            const suhuEl = document.getElementById("suhu");
            const cuacaEl = document.getElementById("cuaca");

            // Hanya jalankan fetch cuaca JIKA elemen yang menampilkannya ada di halaman
            if (suhuEl || cuacaEl) {
                async function getWeather() {
                    const apiKey = "033c013fa9b31e5cc084074664b9454d";
                    const city = "Tambun";
                    const url =
                        `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${apiKey}&lang=id`;

                    try {
                        const response = await fetch(url);
                        if (!response.ok) throw new Error("Network response was not ok");
                        const data = await response.json();

                        const suhu = parseFloat(data.main.temp).toFixed(1);
                        const kondisi = data.weather[0].description;
                        const icon = data.weather[0].icon;

                        // Perhatikan penggunaan flexbox inline agar icon sejajar dengan teks
                        if (suhuEl) suhuEl.innerHTML = `${suhu}°C`;
                        if (cuacaEl) cuacaEl.innerHTML =
                            `<div style="display:flex; align-items:center; gap:4px;">${city}, ${kondisi} <img src="https://openweathermap.org/img/wn/${icon}.png" alt="ikon cuaca" style="width:30px; height:30px;"></div>`;
                    } catch (error) {
                        if (cuacaEl) cuacaEl.innerText = "Gagal memuat cuaca";
                        console.error("Weather fetch error:", error);
                    }
                }
                getWeather();
            }
        });
    </script>

    @stack('js')
</body>

</html>
