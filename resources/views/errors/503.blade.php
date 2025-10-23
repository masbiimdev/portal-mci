<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Situs Dalam Perawatan | MCI</title>
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

        /* Stars background */
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
            from { background-position: 0 0; }
            to { background-position: 10000px 5000px; }
        }

        /* Planet */
        .planet {
            position: absolute;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 300px;
            height: 300px;
            background: radial-gradient(circle at 30% 30%, #0dcaf0, #004aad);
            border-radius: 50%;
            box-shadow: 0 0 80px rgba(13, 202, 240, 0.3);
            animation: floatPlanet 6s ease-in-out infinite;
        }
        @keyframes floatPlanet {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(20px); }
        }

        /* Astronaut */
        .astronaut {
            position: absolute;
            width: 180px;
            animation: floatAstronaut 5s ease-in-out infinite;
        }
        @keyframes floatAstronaut {
            0%, 100% { transform: translateY(0) rotate(-5deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Text card */
        .content {
            position: relative;
            text-align: center;
            z-index: 10;
            animation: fadeIn 1.5s ease;
            padding: 20px;
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        p {
            font-size: 1rem;
            opacity: 0.85;
            margin-bottom: 20px;
        }

        .btn-refresh {
            background: #0dcaf0;
            color: #000;
            font-weight: 600;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-refresh:hover {
            background: #00b8e6;
            box-shadow: 0 0 15px rgba(13, 202, 240, 0.6);
            color: #fff;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
    {{-- <img src="https://img.pikbest.com/backgrounds/20241129/cute-astronaut-with-star-and-planet_11145359.jpg!sw800" class="astronaut" alt="Astronaut" style="top: 20%; left: 20%;"> --}}
    {{-- <img src="https://img.pikbest.com/backgrounds/20241129/cute-astronaut-with-star-and-planet_11145359.jpg!sw800" class="astronaut" alt="Astronaut" style="top: 30%; right: 25%; animation-delay: 2s; transform: scale(0.8);"> --}}

    <div class="content">
        <i class="bi bi-rocket-takeoff-fill fs-1 text-info"></i>
        <h1>Situs Sedang Dalam Perawatan</h1>
        <p>Server sedang melayang di luar angkasa untuk pembaruan sistem.<br>
        Kami akan segera kembali ke orbit digital!</p>

        <a href="" class="btn-refresh">
            <i class="bi bi-arrow-clockwise"></i> Muat Ulang
        </a>
    </div>

    <footer>
        &copy; {{ date('Y') }} PT. Metinca Prima Industrial Works — All rights reserved.
    </footer>

</body>
</html>
