<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan | MCI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            height: 100vh;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(ellipse at bottom, #0b0f29 0%, #000 100%);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .stars {
            width: 100%;
            height: 100%;
            background: transparent url('https://raw.githubusercontent.com/ironhack-labs/lab-css-spotify-clone/master/images/stars.png') repeat top center;
            animation: moveStars 200s linear infinite;
            position: absolute;
            top: 0;
            left: 0;
        }

        @keyframes moveStars {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 10000px 5000px;
            }
        }

        .planet {
            position: absolute;
            bottom: -120px;
            left: 70%;
            width: 260px;
            height: 260px;
            background: radial-gradient(circle at 35% 35%, #ff944d, #cc4400);
            border-radius: 50%;
            box-shadow: 0 0 60px rgba(255, 136, 77, 0.4);
            animation: floatPlanet 7s ease-in-out infinite;
        }

        @keyframes floatPlanet {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(25px);
            }
        }

        /* Astronaut nyasar */
        .astronaut {
            position: absolute;
            width: 220px;
            top: 18%;
            left: 15%;
            animation: floatAstronaut 5s ease-in-out infinite;
        }

        @keyframes floatAstronaut {

            0%,
            100% {
                transform: translateY(0) rotate(-8deg);
            }

            50% {
                transform: translateY(-25px) rotate(8deg);
            }
        }

        .content {
            position: relative;
            text-align: center;
            z-index: 10;
            animation: fadeIn 1.5s ease;
            padding: 20px;
        }

        h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        p {
            font-size: 1rem;
            opacity: 0.85;
            margin-bottom: 20px;
        }

        .btn-refresh {
            padding: 12px 30px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 1rem;
            border: 1px solid rgba(0, 255, 255, 0.4);
            color: #00eaff;
            background: rgba(0, 20, 40, 0.35);
            backdrop-filter: blur(8px);
            box-shadow: 0 0 12px rgba(0, 255, 255, 0.25), inset 0 0 10px rgba(0, 255, 255, 0.15);
            cursor: pointer;
            transition: 0.25s ease;
        }

        .btn-refresh:hover {
            color: #fff;
            background: rgba(0, 80, 120, 0.45);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.7), inset 0 0 12px rgba(0, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            position: absolute;
            bottom: 10px;
            font-size: 0.85rem;
            opacity: 0.7;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="stars"></div>
    <div class="planet"></div>

    {{-- <img src="https://i.imgur.com/8TDyQ0P.png" class="astronaut" alt="Astronaut Nyasar"> --}}

    <div class="content">
        <i class="bi bi-exclamation-triangle-fill fs-1 text-warning"></i>

        <h1 class="starwars-title">404 — Halaman Tidak Ditemukan</h1>

        <p class="starwars-text">
            Di sebuah galaksi yang sangat jauh...
            astronaut kami tersesat ketika mencoba menemukan halaman yang Anda cari.
            Jejaknya hilang di antara bintang-bintang.
        </p>

        <a href="/" class="btn-refresh">
            <i class="bi bi-house-door-fill"></i> Kembali ke Beranda
        </a>
    </div>
    <footer>
        &copy; {{ date('Y') }} PT. Metinca Prima Industrial Works — All rights reserved.
    </footer>

</body>

</html>
