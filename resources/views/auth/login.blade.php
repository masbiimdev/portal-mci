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
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --secondary: #0ea5e9;
            --text-dark: #0f172a;
            --text-gray: #64748b;

            /* Enhanced Glass Variables */
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.8);
            --glass-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            --glass-inner-glow: inset 0 1px 2px rgba(255, 255, 255, 0.9);

            --radius-large: 28px;
            --radius-medium: 20px;
            --gap: 24px;

            --ease-out-expo: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-out-back: cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        * {
            box-sizing: border-box;
            outline: none;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
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
            background-color: #f8fafc;
            overflow: hidden;
        }

        .bg-mesh .blob {
            position: absolute;
            filter: blur(120px);
            opacity: 0.6;
            animation: moveBlob 25s infinite alternate ease-in-out;
            border-radius: 50%;
        }

        .blob-1 {
            top: -10%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: #93c5fd;
            animation-delay: 0s;
        }

        .blob-2 {
            bottom: -10%;
            right: -10%;
            width: 60vw;
            height: 60vw;
            background: #e0e7ff;
            animation-delay: -5s;
        }

        .blob-3 {
            top: 20%;
            left: 40%;
            width: 40vw;
            height: 40vw;
            background: #bfdbfe;
            animation-delay: -12s;
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
            max-width: 1150px;
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--gap);
            z-index: 10;
            perspective: 2000px;
        }

        @media (min-width: 1024px) {
            .bento-wrapper {
                grid-template-columns: 1.3fr 0.8fr;
                grid-template-rows: auto auto;
                min-height: 600px;
                /* Diubah ke min-height agar fleksibel */
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
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-large);
            padding: 3rem;
            box-shadow: var(--glass-shadow), var(--glass-inner-glow);
            display: flex;
            flex-direction: column;
            opacity: 0;
            transform: translateY(30px);
            animation: bentoEntrance 0.8s var(--ease-out-expo) forwards;
            transition: box-shadow 0.4s ease, transform 0.1s ease-out;
            transform-style: preserve-3d;
        }

        .glass-card:not(.tilting):hover {
            box-shadow: 0 35px 60px -15px rgba(29, 78, 216, 0.15), var(--glass-inner-glow);
        }

        .bento-brand {
            animation-delay: 0.1s;
        }

        .bento-form {
            animation-delay: 0.2s;
        }

        .bento-split .card-1 {
            animation-delay: 0.3s;
        }

        .bento-split .card-2 {
            animation-delay: 0.4s;
        }

        @keyframes bentoEntrance {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============== 3. BRAND HERO BOX ============== */
        .bento-brand {
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .bento-brand * {
            transform: translateZ(30px);
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 2.5rem;
        }

        .logo-wrap {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: white;
            padding: 6px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 10px;
        }

        .header-top h2 {
            margin: 0;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--text-dark);
        }

        .brand-content h1 {
            font-size: clamp(2rem, 3.5vw, 3.5rem);
            font-weight: 800;
            margin: 0 0 1rem 0;
            line-height: 1.15;
            letter-spacing: -1px;
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

        /* ============== 4. FORM BOX ============== */
        .bento-form {
            background: rgba(255, 255, 255, 0.85);
            justify-content: center;
            padding: 3rem 2.5rem;
        }

        .bento-form h3 {
            font-size: 1.75rem;
            font-weight: 800;
            margin: 0 0 2rem 0;
            letter-spacing: -0.5px;
        }

        /* Alert Box Refined */
        .alert-box {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            padding: 1rem 1.25rem;
            border-radius: 16px;
            display: flex;
            gap: 12px;
            margin-bottom: 2rem;
            align-items: flex-start;
            animation: alertPulse 2s infinite var(--ease-out-expo);
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
            margin-bottom: 4px;
            font-weight: 700;
        }

        .alert-content p {
            margin: 0;
            color: #9f1239;
            font-size: 0.85rem;
            line-height: 1.4;
            font-weight: 500;
        }

        /* SaaS Style Enclosed Inputs */
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-control {
            width: 100%;
            padding: 1.4rem 1rem 0.6rem;
            font-size: 1rem;
            font-family: inherit;
            color: var(--text-dark);
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .input-label {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            font-size: 1rem;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.2s var(--ease-out-expo);
        }

        .input-control:focus,
        .input-control:hover {
            background: #ffffff;
            border-color: var(--primary);
        }

        .input-control:focus {
            box-shadow: 0 0 0 4px var(--primary-light), inset 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .input-control:focus~.input-label,
        .input-control:not(:placeholder-shown)~.input-label {
            top: 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
        }

        .input-control.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .input-control.is-invalid~.input-label {
            color: #ef4444;
        }

        .pw-toggle-btn {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--text-gray);
            cursor: pointer;
            font-size: 1.3rem;
            transition: 0.2s;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .pw-toggle-btn:hover {
            color: var(--primary);
        }

        .error-msg {
            font-size: 0.8rem;
            color: #ef4444;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            padding-left: 0.5rem;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            font-size: 0.9rem;
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
            width: 18px;
            height: 18px;
            border-radius: 6px;
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
        }

        /* ============== 5. SHINE & PARTICLE BUTTON ============== */
        .btn-submit-wrapper {
            position: relative;
            width: 100%;
        }

        .btn-submit {
            width: 100%;
            padding: 1.1rem;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 20px -6px rgba(29, 78, 216, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            transition: all 0.3s var(--ease-out-back);
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: skewX(-20deg);
            animation: btnShine 4s infinite;
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
            transform: translateY(-2px);
            box-shadow: 0 12px 25px -5px rgba(29, 78, 216, 0.5);
        }

        .btn-submit:active {
            transform: translateY(1px) scale(0.98);
        }

        .btn-particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: -1;
        }

        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ============== BOTTOM SPLIT BOXES ============== */
        .bento-small {
            border-radius: var(--radius-medium);
            padding: 2rem;
            justify-content: center;
        }

        .box-feature {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            border: none;
            box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.4);
        }

        .box-feature i {
            font-size: 2rem;
            color: var(--secondary);
            margin-bottom: 1rem;
            display: inline-block;
        }

        .box-feature h4 {
            margin: 0 0 0.5rem 0;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .box-feature p {
            margin: 0;
            font-size: 0.9rem;
            color: #94a3b8;
            line-height: 1.5;
            font-weight: 500;
        }

        .box-register {
            background: rgba(255, 255, 255, 0.5);
            border: 2px dashed rgba(148, 163, 184, 0.4);
            align-items: center;
            text-align: center;
            box-shadow: none;
        }

        .box-register:hover {
            border-color: var(--primary);
        }

        .box-register i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .box-register h4 {
            margin: 0 0 0.4rem 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .box-register p {
            margin: 0 0 1.2rem 0;
            font-size: 0.85rem;
            color: var(--text-gray);
            font-weight: 500;
        }

        .btn-outline {
            display: inline-block;
            width: 100%;
            padding: 0.8rem;
            border-radius: 12px;
            background: white;
            color: var(--text-dark);
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            box-shadow: 0 8px 15px rgba(29, 78, 216, 0.08);
            transform: translateY(-2px);
        }

        /* Responsive Layout Fix */
        @media (max-width: 1023px) {
            .bento-wrapper {
                max-width: 500px;
                padding: 1rem 0;
            }

            .bento-brand {
                padding: 2.5rem 2rem;
            }

            .brand-content h1 {
                font-size: 2rem;
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

        <div class="glass-card bento-brand js-tilt" data-tilt-max="5" data-tilt-speed="1000"
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

        <div class="glass-card bento-form js-tilt" data-tilt-max="3" data-tilt-speed="1000"
            data-tilt-perspective="2000">
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
            <div class="glass-card bento-small box-feature card-1 js-tilt" data-tilt-max="8" data-tilt-scale="1.02">
                <i class='bx bx-shield-quarter'></i>
                <h4>Keamanan Berlapis</h4>
                <p>Proteksi data end-to-end dan pemantauan sesi aktif.</p>
            </div>

            <div class="glass-card bento-small box-register card-2 js-tilt" data-tilt-max="8" data-tilt-scale="1.02">
                <i class='bx bx-user-plus'></i>
                <h4>Akses Baru</h4>
                <p>Belum memiliki kredensial?</p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-outline">Daftar Akun</a>
                @else
                    <div
                        style="font-size: 0.8rem; color: var(--text-gray); font-weight: 600; border: 1px dashed #cbd5e1; padding: 8px; border-radius: 10px; background: white;">
                        Hubungi Admin IT
                    </div>
                @endif
            </div>
        </div>

    </main>

    @include('includes.admin.script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- A. VanillaTilt Init ---
            const tiltElements = document.querySelectorAll(".js-tilt");
            if (window.innerWidth > 1024) {
                VanillaTilt.init(tiltElements, {
                    gyroscope: false,
                    "full-page-listening": false,
                    glare: false // Matikan glare agar glassmorphism tetap natural
                });

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
                const emailInput = document.getElementById('email');
                if (emailInput) emailInput.focus();
            }

            // --- C. Password Toggle UX ---
            const pwInput = document.getElementById('password');
            const pwToggleBtn = document.getElementById('pwToggle');
            const pwIcon = document.getElementById('pwIcon');

            if (pwToggleBtn && pwInput) {
                pwToggleBtn.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah form tersubmit tak sengaja
                    const isPassword = pwInput.type === 'password';
                    pwInput.type = isPassword ? 'text' : 'password';

                    pwIcon.className = isPassword ? 'bx bx-show' : 'bx bx-hide';
                    pwInput.focus();
                });
            }

            // --- D. Form Loading & Particle Effect ---
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnSpinner = document.getElementById('btnSpinner');
            const btnText = document.getElementById('btnText');
            const particleContainer = document.getElementById('btnParticles');

            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    // Cek form validasi dasar HTML5 sebelum animasi jalan
                    if (!this.checkValidity()) return;

                    submitBtn.style.pointerEvents = 'none';
                    btnSpinner.style.display = 'block';
                    btnText.innerHTML = 'Memverifikasi...';

                    createParticles(particleContainer);
                });
            }

            function createParticles(container) {
                container.innerHTML = '';
                const colors = ['#eff6ff', '#bfdbfe', '#ffffff'];

                for (let i = 0; i < 25; i++) {
                    const particle = document.createElement('div');
                    const color = colors[Math.floor(Math.random() * colors.length)];

                    particle.style.cssText = `
                        position: absolute;
                        top: 50%; left: 50%;
                        width: ${Math.random() * 6 + 4}px;
                        height: ${particle.style.width};
                        background: ${color};
                        border-radius: 50%;
                        opacity: 0.9;
                        pointer-events: none;
                        transition: all ${Math.random() * 0.4 + 0.4}s var(--ease-out-expo);
                        transform: translate(-50%, -50%);
                    `;

                    container.appendChild(particle);

                    const destinationX = (Math.random() - 0.5) * 250;
                    const destinationY = (Math.random() - 0.5) * 100;

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
