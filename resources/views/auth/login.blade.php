<!doctype html>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Login | Portal MCI</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    @include('includes.admin.style')

    <style>
        :root {
            --primary: #0ea5e9;
            --primary-hover: #0284c7;
            --primary-light: #e0f2fe;
            --surface-bg: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --input-border: #e2e8f0;
            --card-radius: 24px;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            height: 100vh;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--surface-bg);
            background-image:
                radial-gradient(at 0% 0%, hsla(199, 89%, 48%, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, hsla(217, 91%, 60%, 0.1) 0px, transparent 50%);
            background-attachment: fixed;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            -webkit-font-smoothing: antialiased;
        }

        /* ============== CARD LAYOUT ============== */
        .auth-container {
            width: 100%;
            max-width: 1100px;
            background: #ffffff;
            border-radius: var(--card-radius);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);
            display: grid;
            grid-template-columns: 1fr;
            overflow: hidden;
            animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @media(min-width: 900px) {
            .auth-container {
                grid-template-columns: 1.1fr 0.9fr;
                min-height: 650px;
            }
        }

        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ============== LEFT SIDE (FORM) ============== */
        .auth-form-section {
            padding: 2.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media(min-width: 900px) {
            .auth-form-section {
                padding: 4rem 12%;
            }
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
        }

        .brand-header img {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .brand-header span {
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .form-titles h1 {
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.03em;
        }

        .form-titles p {
            color: var(--text-muted);
            margin: 0 0 2.5rem 0;
            font-size: 1rem;
        }

        /* ============== ALERTS ============== */
        .alert-box {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            animation: slideUpFade 0.4s ease-out;
        }

        .alert-box svg {
            color: #ef4444;
            flex-shrink: 0;
        }

        .alert-box p {
            margin: 0;
            font-size: 0.875rem;
            color: #991b1b;
            line-height: 1.4;
        }

        .alert-box strong {
            display: block;
            color: #7f1d1d;
            margin-bottom: 4px;
            font-size: 0.95rem;
        }

        /* ============== FLOATING INPUTS ============== */
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-control {
            width: 100%;
            padding: 1.25rem 1rem 0.75rem 1rem;
            font-size: 1rem;
            font-family: inherit;
            color: var(--text-main);
            background: transparent;
            border: 2px solid var(--input-border);
            border-radius: 12px;
            outline: none;
            transition: var(--transition-smooth);
            box-sizing: border-box;
        }

        .input-control[type="password"] {
            padding-right: 2.5rem;
            /* Cegah teks tertutup icon mata */
        }

        .input-control:hover {
            border-color: #cbd5e1;
        }

        .input-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-light);
            background: #fff;
        }

        .input-control.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px #fee2e2;
        }

        .input-label {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
            transition: var(--transition-smooth);
            font-size: 1rem;
            background: #fff;
            padding: 0 6px;
            margin-left: -6px;
        }

        .input-control:focus~.input-label,
        .input-control:not(:placeholder-shown)~.input-label {
            top: 0;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary);
        }

        .input-control.is-invalid~.input-label {
            color: #ef4444;
        }

        .pw-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .pw-toggle-btn:hover {
            color: var(--primary);
        }

        .error-msg {
            font-size: 0.85rem;
            color: #ef4444;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }

        /* ============== CHECKBOX & FORGOT PW ============== */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-muted);
            font-weight: 500;
            user-select: none;
        }

        .custom-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            accent-color: var(--primary);
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .link-forgot {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .link-forgot:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        /* ============== SUBMIT BUTTON ============== */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 14px rgba(14, 165, 233, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit.loading {
            opacity: 0.8;
            cursor: not-allowed;
            pointer-events: none;
        }

        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ============== RIGHT SIDE (IMAGE/DECORATION) ============== */
        .auth-visual-section {
            background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
            display: none;
            position: relative;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        @media(min-width: 900px) {
            .auth-visual-section {
                display: flex;
                flex-direction: column;
            }
        }

        /* Animated Blobs */
        .auth-visual-section::before,
        .auth-visual-section::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 8s infinite ease-in-out;
        }

        .auth-visual-section::before {
            width: 450px;
            height: 450px;
            top: -150px;
            right: -100px;
        }

        .auth-visual-section::after {
            width: 350px;
            height: 350px;
            bottom: -100px;
            left: -100px;
            animation-delay: -4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.05);
            }
        }

        .visual-content {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 3rem 2.5rem;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-width: 400px;
        }

        .visual-content h2 {
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0 0 1rem 0;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .visual-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <main class="auth-container">
        <section class="auth-form-section">
            <div class="brand-header">
                <img src="{{ asset('images/metinca-logo.jpeg') }}" alt="Metinca Logo">
                <span>Metinca Portal<span style="color:var(--primary);">.</span></span>
            </div>

            <div class="form-titles">
                <h1>Welcome Back 👋</h1>
                <p>Silakan masuk untuk mengakses dashboard Anda.</p>
            </div>

            @if ($errors->has('login'))
                <div class="alert-box">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <strong>Akun sedang digunakan</strong>
                        <p>Akun ini masih aktif di perangkat lain. Silakan logout dari perangkat sebelumnya.</p>
                    </div>
                </div>
            @endif

            @if ($errors->has('session_expired'))
                <div class="alert-box" style="background:#fffbeb; border-color:#f59e0b;">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#f59e0b"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <strong style="color:#b45309;">Sesi Berakhir</strong>
                        <p style="color:#b45309;">Anda otomatis logout karena tidak ada aktivitas.</p>
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
                        <span class="error-msg">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="input-group">
                    <input type="password" id="password" name="password"
                        class="input-control @error('password') is-invalid @enderror" placeholder=" " required>
                    <label for="password" class="input-label">Password</label>

                    <button type="button" class="pw-toggle-btn" id="pwToggle" aria-label="Toggle password visibility">
                        <svg id="icon-show" width="20" height="20" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="icon-hide" width="20" height="20" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>

                    @error('password')
                        <span class="error-msg">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-footer">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        Ingat Saya
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-forgot">Lupa Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="spinner" id="btnSpinner"></span>
                    <span id="btnText">Sign In to Account</span>
                </button>

                <div style="text-align: center; margin-top: 2rem; font-size: 0.95rem; color: var(--text-muted);">
                    Belum punya akun?
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="link-forgot">Daftar di sini</a>
                    @else
                        <span style="color: var(--text-main); font-weight: 500;">Hubungi Admin.</span>
                    @endif
                </div>
            </form>
        </section>

        <section class="auth-visual-section">
            <div class="visual-content">
                <h2>Kelola Proses<br>Lebih Cerdas</h2>
                <p>Akses jadwal inspeksi, tracking proses, dan manajemen inventory dalam satu ekosistem portal
                    terintegrasi.</p>
            </div>
        </section>

    </main>

    @include('includes.admin.script')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Auto-focus pada input yang error pertama
            const invalidInput = document.querySelector('.is-invalid');
            if (invalidInput) invalidInput.focus();

            // 2. Logika Toggle Password (Hide/Show)
            const pwInput = document.getElementById('password');
            const pwToggleBtn = document.getElementById('pwToggle');
            const iconShow = document.getElementById('icon-show');
            const iconHide = document.getElementById('icon-hide');

            if (pwToggleBtn && pwInput) {
                pwToggleBtn.addEventListener('click', function() {
                    const isPassword = pwInput.type === 'password';

                    pwInput.type = isPassword ? 'text' : 'password';
                    iconShow.style.display = isPassword ? 'none' : 'block';
                    iconHide.style.display = isPassword ? 'block' : 'none';

                    pwInput.focus();
                });
            }

            // 3. UX Loading state saat form disubmit (mencegah klik berkali-kali)
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnSpinner = document.getElementById('btnSpinner');
            const btnText = document.getElementById('btnText');

            if (loginForm) {
                loginForm.addEventListener('submit', function() {
                    submitBtn.classList.add('loading');
                    btnSpinner.style.display = 'block';
                    btnText.textContent = 'Memproses...';
                });
            }
        });
    </script>
</body>

</html>
