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
            --surface-bg: #f1f5f9;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --input-border: #cbd5e1;
            --card-radius: 24px;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            height: 100vh;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--surface-bg);
            background-image:
                radial-gradient(at 0% 0%, hsla(199, 89%, 48%, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, hsla(217, 91%, 60%, 0.15) 0px, transparent 50%);
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
            max-width: 1024px;
            background: #ffffff;
            border-radius: var(--card-radius);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            display: grid;
            grid-template-columns: 1fr;
            overflow: hidden;
            animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @media(min-width: 900px) {
            .auth-container {
                grid-template-columns: 1fr 1fr;
                min-height: 600px;
            }
        }

        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ============== LEFT SIDE (FORM) ============== */
        .auth-form-section {
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media(min-width: 900px) {
            .auth-form-section {
                padding: 4rem 10%;
            }
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2.5rem;
        }

        .brand-header img {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            object-fit: cover;
        }

        .brand-header span {
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .form-titles h1 {
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.03em;
        }

        .form-titles p {
            color: var(--text-muted);
            margin: 0 0 2rem 0;
            font-size: 0.95rem;
        }

        /* ============== FLOATING INPUTS ============== */
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-control {
            width: 100%;
            padding: 1.2rem 1rem 0.6rem 1rem;
            font-size: 1rem;
            font-family: inherit;
            color: var(--text-main);
            background: #fff;
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            outline: none;
            transition: var(--transition-smooth);
        }

        .input-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .input-control.is-invalid {
            border-color: #ef4444;
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
            padding: 0 4px;
        }

        /* Float the label when input is focused or has value */
        .input-control:focus~.input-label,
        .input-control:not(:placeholder-shown)~.input-label {
            top: 0;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
        }

        .input-control.is-invalid~.input-label {
            color: #ef4444;
        }

        /* Password Toggle Button */
        .pw-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
        }

        .pw-toggle-btn:hover {
            color: var(--text-main);
        }

        /* Checkbox & Forgot Password */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-muted);
            font-weight: 500;
        }

        .custom-checkbox input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .link-forgot {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .link-forgot:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 14px rgba(14, 165, 233, 0.25);
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Error Messages */
        .error-msg {
            font-size: 0.8rem;
            color: #ef4444;
            margin-top: 6px;
            display: block;
            font-weight: 500;
        }

        .alert-box {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .alert-box svg {
            color: #ef4444;
            flex-shrink: 0;
        }

        .alert-box p {
            margin: 0;
            font-size: 0.9rem;
            color: #991b1b;
        }

        .alert-box strong {
            display: block;
            color: #7f1d1d;
            margin-bottom: 2px;
        }

        /* ============== RIGHT SIDE (IMAGE/DECORATION) ============== */
        .auth-visual-section {
            background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
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

        /* Decorative blobs */
        .auth-visual-section::before,
        .auth-visual-section::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .auth-visual-section::before {
            width: 400px;
            height: 400px;
            top: -100px;
            right: -100px;
        }

        .auth-visual-section::after {
            width: 300px;
            height: 300px;
            bottom: -50px;
            left: -100px;
        }

        .visual-content {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .visual-content h2 {
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 1rem 0;
            line-height: 1.2;
        }

        .visual-content p {
            font-size: 1.05rem;
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
                <p>Please sign in to access your dashboard.</p>
            </div>

            @if ($errors->has('login'))
                <div class="alert-box">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
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
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#f59e0b"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <strong style="color:#b45309;">Session Berakhir</strong>
                        <p style="color:#b45309;">Anda otomatis logout karena tidak ada aktivitas.</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="input-group">
                    <input type="email" id="email" name="email"
                        class="input-control @error('email') is-invalid @enderror" placeholder=" "
                        value="{{ old('email') }}" required autofocus>
                    <label for="email" class="input-label">Email Address</label>
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
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
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-footer">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-forgot">Forgot Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">Sign In to Account</button>

                <div style="text-align: center; margin-top: 2rem; font-size: 0.9rem; color: var(--text-muted);">
                    Don't have an account?
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="link-forgot">Register Here</a>
                    @else
                        Contact Admin.
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
            // Focus on first invalid input
            const invalidInput = document.querySelector('.is-invalid');
            if (invalidInput) invalidInput.focus();

            // Password Toggle Logic
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

                    // Keep focus on input after toggle
                    pwInput.focus();
                });
            }
        });
    </script>
</body>

</html>
