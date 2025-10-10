<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>
    <!-- Tailwind -->
    <link rel="icon" type="image/x-icon"
        href="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/metinca-logo.jpeg'))) }}" />

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        .active-page {
            position: relative;
            color: #1D4ED8;
            /* Biru utama */
            font-weight: 600;
            padding-bottom: 4px;
            transition: color 0.3s ease;
            /* smooth untuk teks */
        }

        .active-page::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 100%;
            background-color: #1D4ED8;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
            /* animasi garis bawah */
        }

        .active-page:hover::after,
        .active-page.active-page-current::after {
            transform: scaleX(1);
            /* garis bawah muncul */
        }

        .active-page:hover {
            color: #1E40AF;
            /* biru lebih gelap saat hover */
        }
    </style>
    @stack('css')
</head>

<body class="bg-gray-50">

    @include('includes.navbar')

    @yield('content')
    <script>
        feather.replace();

        // Dropdown notif
        const notifBtn = document.getElementById("notifBtn");
        const notifMenu = document.getElementById("notifMenu");
        notifBtn.addEventListener("click", () => {
            notifMenu.classList.toggle("hidden");
        });

        // Dropdown user
        const userBtn = document.getElementById("userBtn");
        const userMenu = document.getElementById("userMenu");
        userBtn.addEventListener("click", () => {
            userMenu.classList.toggle("hidden");
        });

        // Hamburger menu
        const hamburger = document.getElementById("hamburger");
        const mobileMenu = document.getElementById("mobileMenu");
        hamburger.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    </script>
    <script>
        // --- Tanggal Otomatis ---
        const namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const namaBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
            "Oktober", "November", "Desember"
        ];
        const now = new Date();
        const tanggal = `${namaHari[now.getDay()]}, ${now.getDate()} ${namaBulan[now.getMonth()]} ${now.getFullYear()}`;
        document.getElementById("tanggal").innerText = tanggal;

        // --- Cuaca Realtime ---
        async function getWeather() {
            const apiKey = "033c013fa9b31e5cc084074664b9454d"; // <-- ubah di sini
            const city = "Tambun";
            const url =
            `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${apiKey}&lang=id`;

            try {
                const response = await fetch(url);
                const data = await response.json();

                const suhu = parseFloat(data.main.temp).toFixed(1);
                const kondisi = data.weather[0].description;
                const icon = data.weather[0].icon;

                document.getElementById("suhu").innerHTML = `${suhu}°C`;
                document.getElementById("cuaca").innerHTML =
                    `${city}, ${kondisi} <img src="https://openweathermap.org/img/wn/${icon}.png" alt="">`;
            } catch (error) {
                document.getElementById("cuaca").innerText = "Gagal memuat cuaca 😔";
                console.error(error);
            }
        }

        getWeather();
    </script>

    @stack('js')
</body>

</html>
