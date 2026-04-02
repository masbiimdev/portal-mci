<!doctype html>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Login Premium | Portal MCI</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    @include('includes.admin.style')

    <style>
        :root {
            --primary: #1d4ed8;
            --primary-light: #60a5fa;
            --secondary: #0ea5e9;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --glass-bg: rgba(255, 255, 255, 0.6);
            --glass-border: rgba(255, 255, 255, 0.7);
            --glass-blur: blur(35px);
            --radius-large: 32px;
            --radius-medium: 24px;
            --gap: 20px;
            /* Cubic bezier untuk animasi membal yang premium */
            --ease-out-expo: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-out-back: cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        * {
            box-sizing: border-box;
            outline: none;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ============== 1. DYNAMIC MESH BACKGROUND ============== */
        .bg-mesh {
            position: fixed;
            inset: 0;
            z-index: -1;
            background-color: #f1f5f9;
            overflow: hidden;
        }

        .bg-mesh .blob {
            position: absolute;
            filter: blur(100px);
            opacity: 0.7;
            animation: moveBlob 25s infinite alternate ease-in-out;
            border-radius: 50%;
        }

        .blob-1 {
            top: -10%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: #c7d2fe;
            animation-delay: 0s;
        }

        .blob-2 {
            bottom: -15%;
            right: -10%;
            width: 60vw;
            height: 60vw;
            background: #bae6fd;
            animation-delay: -7s;
        }

        .blob-3 {
            top: 30%;
            left: 30%;
            width: 35vw;
            height: 35vw;
            background: #dbeafe;
            animation-delay: -14s;
        }

        @keyframes moveBlob {
            0% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }

            33% {
                transform: translate(5vw, 10vh) scale(1.1) rotate(5deg);
            }

            66% {
                transform: translate(-5vw, -5vh) scale(0.9) rotate(-5deg);
            }

            100% {
                transform: translate(2vw, 5vh) scale(1.05) rotate(0deg);
            }
        }

        /* ============== BENTO GRID ARCHITECTURE ============== */
        .bento-wrapper {
            width: 100%;
            max-width: 1100px;
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--gap);
            z-index: 10;
            perspective: 2000px;
            /* Penting untuk efek 3D Tilt JS */
        }

        @media (min-width: 1024px) {
            .bento-wrapper {
                grid-template-columns: 1.25fr 0.75fr;
                grid-template-rows: repeat(2, minmax(0, 1fr));
                height: 650px;
            }

            .bento-brand {
                grid-column: 1 / 2;
                grid-row: 1 / 2;
            }

            .bento-form {
                grid-column: 2 / 3;
                grid-row: 1 / 3;
            }

            .bento-split {
                grid-column: 1 / 2;
                grid-row: 2 / 3;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: var(--gap);
            }
        }

        /* ============== 2. ACTIVE GLASSMORPHISM CARD ============== */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-large);
            padding: 2.5rem;
            box-shadow: 0 20px 50px -15px rgba(0, 0, 0, 0.05), inset 0 1px 0 rgba(255, 255, 255, 0.6);
            display: flex;
            flex-direction: column;

            /* Animasi Masuk CSS (Fade-in-up) */
            opacity: 0;
            transform: translateY(40px);
            animation: bentoEntrance 0.8s var(--ease-out-expo) forwards;

            /* Transisi untuk Hover & JS Tilt */
            transition:
                box-shadow 0.4s ease,
                border-color 0.4s ease,
                transform 0.1s ease-out;
            /* Tip: transform JS harus cepat */

            /* Agar konten tidak keluar saat miring */
            transform-style: preserve-3d;
        }

        /* Efek terangkat saat hover (CSS Fallback jika JS gagal/lambat) */
        .glass-card:not(.tilting):hover {
            transform: translateY(-8px);
            box-shadow: 0 40px 80px -20px rgba(29, 78, 216, 0.15), inset 0 1px 0 rgba(255, 255, 255, 1);
            border-color: rgba(255, 255, 255, 0.9);
        }

        /* Staggered Delay Animasi Masuk */
        .bento-brand {
            animation-delay: 0.1s;
        }

        .bento-form {
            animation-delay: 0.25s;
        }

        .bento-split .card-1 {
            animation-delay: 0.4s;
        }

        .bento-split .card-2 {
            animation-delay: 0.55s;
        }

        @keyframes bentoEntrance {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============== 3. BRAND HERO BOX ============== */
        .bento-brand {
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .bento-brand * {
            transform: translateZ(30px);
            /* Efek Paralaks dalam 3D Tilt */
        }

        .bento-brand::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, var(--secondary) 0%, transparent 70%);
            opacity: 0.15;
            filter: blur(40px);
            transform: translateZ(10px);
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 2rem;
        }

        .logo-wrap {
            width: 60px;
            height: 60px;
            border-radius: 20px;
            background: white;
            padding: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 12px;
        }

        .header-top h2 {
            margin: 0;
            font-weight: 800;
            font-size: 1.6rem;
            letter-spacing: -0.5px;
        }

        .brand-content h1 {
            font-size: clamp(2.4rem, 3.8vw, 3.2rem);
            font-weight: 800;
            margin: 0 0 1rem 0;
            line-height: 1.1;
            letter-spacing: -1.5px;
            color: var(--text-dark);
        }

        .brand-content h1 span {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-content p {
            font-size: 1.1rem;
            color: var(--text-gray);
            margin: 0;
            max-width: 90%;
            line-height: 1.6;
            font-weight: 500;
        }

        /* ============== 4. FORM BOX WITH ACTIVE INPUTS ============== */
        .bento-form {
            background: rgba(255, 255, 255, 0.85);
            justify-content: center;
            transform-origin: right center;
        }

        .bento-form h3 {
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0 0 2rem 0;
            text-align: center;
            letter-spacing: -0.5px;
        }

        /* Alert Pulse Animation */
        .alert-box {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            padding: 1rem;
            border-radius: 20px;
            display: flex;
            gap: 12px;
            margin-bottom: 2rem;
            align-items: flex-start;
            animation: alertPulse 2s infinite var(--ease-out-expo);
        }

        @keyframes alertPulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.1);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(225, 29, 72, 0);
            }
        }

        .alert-box i {
            color: #e11d48;
            font-size: 1.4rem;
            margin-top: 2px;
        }

        .alert-content strong {
            color: #be123c;
            display: block;
            font-size: 0.95rem;
            margin-bottom: 2px;
            font-weight: 700;
        }

        .alert-content p {
            margin: 0;
            color: #9f1239;
            font-size: 0.85rem;
            line-height: 1.4;
            font-weight: 500;
        }

        /* Input Group dengan Garis Aktif Gradasi Bergerak */
        .input-group {
            position: relative;
            margin-bottom: 2rem;
        }

        .input-control {
            width: 100%;
            padding: 1rem 0 0.6rem 0;
            font-size: 1.05rem;
            font-family: inherit;
            color: var(--text-dark);
            background: transparent;
            border: none;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
            transition: border-color 0.3s ease;
        }

        /* Label Melayang Smooth */
        .input-label {
            position: absolute;
            left: 0;
            top: 1rem;
            color: var(--text-gray);
            font-size: 1.05rem;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.3s var(--ease-out-expo);
        }

        /* Pseudo-element Garis Gradasi Bergerak saat Focus */
        .input-group::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--secondary), var(--primary), var(--secondary));
            background-size: 200% auto;
            transition: width 0.4s var(--ease-out-expo), left 0.4s var(--ease-out-expo);
        }

        .input-control:focus~.input-label,
        .input-control:not(:placeholder-shown)~.input-label {
            top: -12px;
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--primary);
        }

        /* State Focus & Invalid */
        .input-control:focus~ ::after {
            width: 100%;
            left: 0;
            animation: gradientMove 1.5s linear infinite;
        }

        @keyframes gradientMove {
            to {
                background-position: 200% center;
            }
        }

        .input-control.is-invalid {
            border-bottom-color: #ef4444;
        }

        .input-control.is-invalid~.input-label {
            color: #ef4444;
        }

        .pw-toggle-btn {
            position: absolute;
            right: 0;
            top: 12px;
            background: transparent;
            border: none;
            color: var(--text-gray);
            cursor: pointer;
            font-size: 1.3rem;
            transition: 0.2s;
        }

        .pw-toggle-btn:hover {
            color: var(--primary);
            transform: scale(1.1);
        }

        .error-msg {
            font-size: 0.85rem;
            color: #ef4444;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            font-size: 0.95rem;
        }

        .checkbox-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-weight: 600;
            color: var(--text-gray);
            transition: 0.2s;
        }

        .checkbox-wrap:hover {
            color: var(--text-dark);
        }

        .checkbox-wrap input {
            width: 19px;
            height: 19px;
            border-radius: 7px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .link-forgot {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: 0.2s;
        }

        .link-forgot:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        /* ============== 5. SHINE & PARTICLE BUTTON ============== */
        .btn-submit-wrapper {
            position: relative;
            width: 100%;
        }

        .btn-submit {
            width: 100%;
            padding: 1.2rem;
            border: none;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-size: 1.1rem;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 10px 30px -5px rgba(29, 78, 216, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            transition: all 0.3s var(--ease-out-back);
            position: relative;
            overflow: hidden;
        }

        /* Efek Kilatan Cahaya (Shine) otomatis */
        .btn-submit::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-20deg);
            animation: btnShine 5s infinite;
        }

        @keyframes btnShine {
            0% {
                left: -100%;
            }

            20%,
            100% {
                left: 150%;
            }
        }

        .btn-submit:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 15px 40px -5px rgba(29, 78, 216, 0.5);
        }

        .btn-submit:active {
            transform: translateY(1px) scale(0.99);
            transition: 0.1s;
        }

        /* Container untuk partikel JS */
        .btn-particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: -1;
        }

        .spinner {
            display: none;
            width: 22px;
            height: 22px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ============== BOTTOM SPLIT BOXES ============== */
        @media (max-width: 1023px) {
            .bento-split {
                display: grid;
                grid-template-columns: 1fr;
                gap: var(--gap);
            }
        }

        .bento-small {
            border-radius: var(--radius-medium);
            padding: 2rem;
            justify-content: center;
        }

        /* Feature Box - Dark Gradient */
        .box-feature {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            border: none;
            overflow: hidden;
        }

        .box-feature i {
            font-size: 2.2rem;
            color: var(--secondary);
            margin-bottom: 1rem;
            animation: iconPulse 2s infinite var(--ease-out-expo);
        }

        @keyframes iconPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .box-feature h4 {
            margin: 0 0 0.6rem 0;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .box-feature p {
            margin: 0;
            font-size: 0.95rem;
            color: #cbd5e1;
            line-height: 1.5;
            font-weight: 500;
        }

        /* Register Box - Dashed Outline */
        .box-register {
            background: var(--glass-bg);
            border: 2px dashed #cbd5e0;
            align-items: center;
            text-align: center;
        }

        .box-register i {
            font-size: 2.2rem;
            color: var(--primary);
            margin-bottom: 0.6rem;
        }

        .box-register h4 {
            margin: 0 0 0.5rem 0;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .box-register p {
            margin: 0 0 1.25rem 0;
            font-size: 0.9rem;
            color: var(--text-gray);
            font-weight: 500;
        }

        .btn-outline {
            display: inline-block;
            width: 100%;
            padding: 0.9rem;
            border-radius: 14px;
            background: white;
            color: var(--text-dark);
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            border: 1px solid #e2e8f0;
            transition: all 0.3s var(--ease-out-back);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 20px rgba(29, 78, 216, 0.05);
        }

        /* Responsive Layout Fix */
        @media (max-width: 1023px) {
            .bento-wrapper {
                max-width: 550px;
            }
        }
    </style>
</head>

<body>

    <div class="bg-mesh">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <main class="bento-wrapper" id="bentoGrid">

        <div class="glass-card bento-brand js-tilt" data-tilt-max="10" data-tilt-speed="1000"
            data-tilt-perspective="2000">
            <div class="header-top">
                <div class="logo-wrap">
                    <img src="{{ asset('images/metinca-logo.jpeg') }}" alt="Logo MCI">
                </div>
                <h2>Metinca Portal<span style="color: var(--primary);">.</span></h2>
            </div>
            <div class="brand-content">
                <h1>Operasional <span>Terpusat & Cerdas</span></h1>
                <p>Ekosistem manajemen mutakhir untuk memantau jadwal kalibrasi, inspeksi NCR, dan pergerakan inventory
                    dalam satu platform intuitif.</p>
            </div>
        </div>

        <div class="glass-card bento-form js-tilt" data-tilt-max="7" data-tilt-speed="1000" data-tilt-perspective="2000"
            data-tilt-startX="5">
            <h3>Account Login</h3>

            @if ($errors->has('login') || $errors->has('session_expired'))
                <div class="alert-box"
                    style="{{ $errors->has('session_expired') ? 'background:#fffbeb; border-color:#fef08a;' : '' }}">
                    <i class='bx {{ $errors->has('session_expired') ? 'bx-time-five' : 'bx-error-circle' }}'
                        style="{{ $errors->has('session_expired') ? 'color:#ca8a04;' : '' }}"></i>
                    <div class="alert-content">
                        <strong style="{{ $errors->has('session_expired') ? 'color:#a16207;' : '' }}">
                            {{ $errors->has('session_expired') ? 'Sesi Berakhir' : 'Gagal Masuk' }}
                        </strong>
                        <p style="{{ $errors->has('session_expired') ? 'color:#854d0e;' : '' }}">
                            {{ $errors->has('session_expired') ? 'Anda otomatis logout karena tidak ada aktivitas.' : 'Email/Password salah, atau akun sedang aktif di perangkat lain.' }}
                        </p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf

                <div class="input-group">
                    <input type="email" id="email" name="email"
                        class="input-control @error('email') is-invalid @enderror" placeholder=" "
                        value="{{ old('email') }}" required autofocus>
                    <label for="email" class="input-label">Alamat Email</label>
                    @error('email')
                        <span class="error-msg"><i class='bx bx-info-circle'></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <input type="password" id="password" name="password"
                        class="input-control @error('password') is-invalid @enderror" placeholder=" " required>
                    <label for="password" class="input-label">Password</label>
                    <button type="button" class="pw-toggle-btn" id="pwToggle"><i class='bx bx-hide'
                            id="pwIcon"></i></button>
                    @error('password')
                        <span class="error-msg"><i class='bx bx-info-circle'></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="checkbox-wrap">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        Ingat Saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-forgot">Lupa Password?</a>
                    @endif
                </div>

                <div class="btn-submit-wrapper">
                    <div class="btn-particles" id="btnParticles"></div>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="spinner" id="btnSpinner"></span>
                        <span id="btnText">Masuk Dashboard <i class='bx bx-right-arrow-alt'
                                style="vertical-align: middle; font-size: 1.2rem;"></i></span>
                    </button>
                </div>
            </form>
        </div>

        <div class="bento-split">
            <div class="glass-card bento-small box-feature card-1 js-tilt" data-tilt-max="15" data-tilt-scale="1.05">
                <i class='bx bx-shield-quarter'></i>
                <h4>Keamanan Berlapis</h4>
                <p>Proteksi data end-to-end dan pemantauan sesi aktif.</p>
            </div>

            <div class="glass-card bento-small box-register card-2 js-tilt" data-tilt-max="15"
                data-tilt-scale="1.05">
                <i class='bx bx-user-plus'></i>
                <h4>Akses Baru</h4>
                <p>Belum memiliki kredensial?</p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-outline">Daftar Akun</a>
                @else
                    <div
                        style="font-size: 0.85rem; color: var(--text-gray); font-weight: 600; border: 1px dashed #e2e8f0; padding: 8px; border-radius: 10px; background: white;">
                        Hubungi Admin IT</div>
                @endif
            </div>
        </div>

    </main>

    @include('includes.admin.script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- A. Inisialisasi VanillaTilt (Efek 3D Mouse) ---
            const tiltElements = document.querySelectorAll(".js-tilt");
            if (window.innerWidth > 1024) { // Hanya aktif di desktop
                VanillaTilt.init(tiltElements, {
                    gyroscope: false, // Matikan gyro agar tidak aneh di mobile jika aktif
                    "full-page-listening": false,
                });

                // Tambahkan class saat tilting untuk mematikan transisi CSS transisi sementara agar mulus
                tiltElements.forEach(el => {
                    el.addEventListener("tiltChange", () => el.classList.add('tilting'));
                    el.addEventListener("blur", () => el.classList.remove('tilting'));
                    el.addEventListener("mouseleave", () => el.classList.remove('tilting'));
                });
            }

            // --- B. Auto Focus UX ---
            const invalidInput = document.querySelector('.is-invalid');
            if (invalidInput) {
                invalidInput.focus();
            } else {
                document.getElementById('email').focus();
            }

            // --- C. Password Toggle UX ---
            const pwInput = document.getElementById('password');
            const pwToggleBtn = document.getElementById('pwToggle');
            const pwIcon = document.getElementById('pwIcon');

            if (pwToggleBtn && pwInput) {
                pwToggleBtn.addEventListener('click', function() {
                    const isPassword = pwInput.type === 'password';
                    pwInput.type = isPassword ? 'text' : 'password';

                    // Ganti icon & animasi pop
                    pwIcon.className = isPassword ? 'bx bx-show' : 'bx bx-hide';
                    pwToggleBtn.style.transform = 'scale(1.2)';
                    setTimeout(() => pwToggleBtn.style.transform = 'scale(1)', 200);
                    pwInput.focus();
                });
            }

            // --- D. Form Loading & Particle Effect saat Klik ---
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnSpinner = document.getElementById('btnSpinner');
            const btnText = document.getElementById('btnText');
            const particleContainer = document.getElementById('btnParticles');

            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    // 1. Matikan tombol (UX)
                    submitBtn.style.pointerEvents = 'none';
                    btnSpinner.style.display = 'block';
                    btnText.innerText = 'Memverifikasi...';

                    // 2. Efek Partikel Ledakan Aurora (JS)
                    createParticles(particleContainer);

                    // (Laravel akan menangani sisanya)
                });
            }

            // Fungsi untuk membuat partikel ledakan transparan
            function createParticles(container) {
                container.innerHTML = ''; // Reset
                const colors = ['#60a5fa', '#0ea5e9', '#ffffff']; // Warna aurora

                for (let i = 0; i < 30; i++) {
                    const particle = document.createElement('div');
                    const color = colors[Math.floor(Math.random() * colors.length)];

                    // Styling partikel dasar
                    particle.style.cssText = `
                        position: absolute;
                        top: 50%; left: 50%;
                        width: ${Math.random() * 8 + 4}px;
                        height: ${particle.style.width};
                        background: ${color};
                        border-radius: 50%;
                        opacity: 0.8;
                        pointer-events: none;
                        transition: all ${Math.random() * 0.5 + 0.5}s var(--ease-out-expo);
                        transform: translate(-50%, -50%);
                    `;

                    container.appendChild(particle);

                    // Hitung arah ledakan acak
                    const destinationX = (Math.random() - 0.5) * 300; // Jarak sebar X
                    const destinationY = (Math.random() - 0.5) * 150; // Jarak sebar Y

                    // Animasikan partikel (pindah & hilang)
                    setTimeout(() => {
                        particle.style.transform =
                            `translate(calc(-50% + ${destinationX}px), calc(-50% + ${destinationY}px)) scale(0)`;
                        particle.style.opacity = '0';
                    }, 10);
                }
            }
        });
    </script>
</body>

</html>
