<!doctype html>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Login | Portal MCI</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet" />

    <!-- Icons + Core CSS (existing includes) -->
    @include('includes.admin.style')
    <style>
        .alert-soft {
            display: flex;
            gap: .75rem;
            align-items: flex-start;
            padding: .85rem 1rem;
            border-radius: 12px;
            background: rgba(254, 226, 226, 0.9);
            /* soft red */
            color: #7f1d1d;
            border: 1px solid rgba(248, 113, 113, 0.35);
            box-shadow: 0 12px 30px rgba(185, 28, 28, 0.12);
            animation: slideDown .35s ease;
        }

        .alert-soft svg {
            flex-shrink: 0;
            margin-top: .15rem;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }
    </style>

    <style>
        :root {
            --bg-1: #f8fafc;
            --bg-2: #eef2ff;
            --accent-1: #5166ff;
            --accent-2: #3b82f6;
            --muted: #6b7280;
            --card-radius: 14px;
            --glass: rgba(255, 255, 255, 0.72);
            --shadow: 0 18px 50px rgba(6, 8, 15, 0.08);
            --focus-ring: 0 0 0 4px rgba(81, 102, 255, 0.12);
        }

        html,
        body {
            height: 100%;
            margin: 0;
            font-family: "Public Sans", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: linear-gradient(180deg, var(--bg-1) 0%, var(--bg-2) 100%);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: #0f172a;
        }

        .authentication-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
        }

        .auth-card {
            width: 100%;
            max-width: 980px;
            border-radius: var(--card-radius);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr;
            box-shadow: var(--shadow);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(255, 255, 255, 0.94));
            transition: transform .24s ease, box-shadow .24s ease;
            transform-origin: center;
        }

        .auth-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 80px rgba(6, 8, 15, 0.12);
        }

        @media(min-width: 880px) {
            .auth-card {
                grid-template-columns: 480px 1fr;
            }
        }

        /* LEFT - illustration + brand */
        .auth-side {
            padding: 2.5rem;
            background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }

        .auth-side::after {
            content: '';
            position: absolute;
            right: -80px;
            bottom: -80px;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
            transform: rotate(25deg);
            border-radius: 50%;
            pointer-events: none;
        }

        .brand-mark {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .brand-mark svg {
            filter: drop-shadow(0 6px 18px rgba(0, 0, 0, 0.08));
        }

        .auth-side h2 {
            font-size: 1.35rem;
            margin: 0;
            letter-spacing: -0.2px;
        }

        .auth-side p.features {
            margin: 0;
            opacity: 0.95;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.95);
        }

        .auth-side .aside-cta {
            margin-top: 1rem;
            font-size: .92rem;
            color: rgba(255, 255, 255, 0.92);
        }

        /* RIGHT - form */
        .auth-form {
            padding: 2rem;
            display: flex;
            align-items: center;
        }

        .card-body {
            width: 100%;
            padding: 0;
        }

        .panel {
            max-width: 520px;
            margin: 0 auto;
            background: transparent;
            border-radius: 10px;
        }

        h4 {
            margin: 0 0 .25rem 0;
            font-weight: 600;
        }

        .small-muted {
            color: var(--muted);
            font-size: .95rem;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #e6e9ef;
            padding: .72rem .9rem;
            font-size: .95rem;
            transition: box-shadow .16s, border-color .16s;
            background: #fff;
        }

        .form-control::placeholder {
            color: #9aa4b2;
        }

        .form-control:focus {
            outline: none;
            box-shadow: var(--focus-ring);
            border-color: var(--accent-1);
        }

        .input-group {
            display: flex;
            gap: 0;
            align-items: center;
        }

        .input-group .input-group-text {
            background: transparent;
            border-left: none;
            border-radius: 0 10px 10px 0;
            padding: .55rem .7rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .form-check-input {
            width: 1.05rem;
            height: 1.05rem;
            margin-top: .15rem;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--accent-1), var(--accent-2));
            border: none;
            border-radius: 10px;
            padding: .65rem 1rem;
            font-weight: 700;
            color: white;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.12);
            transition: transform .12s, box-shadow .12s, opacity .12s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            opacity: 0.98;
        }

        .btn-google {
            background: #fff;
            color: #111827;
            border: 1px solid #e6e9ef;
            border-radius: 10px;
            padding: .55rem .75rem;
            display: inline-flex;
            gap: .5rem;
            align-items: center;
            width: 100%;
            justify-content: center;
            font-weight: 600;
        }

        .helper-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: .5rem;
            margin-top: .5rem;
        }

        .foot-cta {
            text-align: center;
            margin-top: .9rem;
            font-size: .92rem;
            color: var(--muted);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        a.link-primary {
            color: var(--accent-2);
            font-weight: 600;
        }

        .invalid-feedback {
            display: block;
            font-size: .88rem;
            color: #dc2626;
            margin-top: .45rem;
        }

        .is-invalid {
            border-color: #fca5a5 !important;
            box-shadow: none;
        }

        /* subtle entrance */
        @keyframes floatIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .auth-card,
        .auth-form,
        .auth-side {
            animation: floatIn .36s ease both;
        }

        /* small screens spacing */
        @media (max-width:479px) {
            .auth-side {
                padding: 1.6rem;
            }

            .auth-form {
                padding: 1rem;
            }
        }

        /* visually-hidden (for a11y) */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
    </style>
</head>

<body>
    <div class="authentication-wrapper">
        <main class="auth-card" role="main" aria-labelledby="login-heading">
            <!-- LEFT - brand/benefit -->
            <aside class="auth-side" aria-hidden="false">
                <div>
                    <div class="brand-mark" aria-hidden="true">
                        <img src="{{ asset('images/metinca-logo.jpeg') }}" alt="">
                        <span>Metinca Portal Base .</span>
                    </div>
                </div>

                <h2 id="login-heading" style="color: white">Selamat datang di Portal MCI</h2>
                <p class="features" style="color: white">Akses cepat ke jadwal, tracking, inventory, dan hasil inspeksi
                    kualitas. Aman, cepat, dan dapat diandalkan untuk tim Anda.</p>

                <div class="aside-cta">
                    <div class="small-muted" style="color: white">Tips: Gunakan akun kantor untuk akses penuh. Jika lupa
                        kata sandi, Silahkan hubungi admin</div>
                </div>
            </aside>

            <!-- RIGHT - form -->
            <section class="auth-form" aria-label="Login form">
                <div class="card-body">
                    <div class="panel p-4">
                        <h4 class="text-center">Welcome Back! <span aria-hidden="true">👋</span></h4>
                        <p class="small-muted text-center mb-4">Silakan masuk untuk melanjutkan ke Portal MCI</p>

                        <!-- Live region for server-side errors -->
                        <div aria-live="polite" aria-atomic="true" class="sr-only" id="server-messages">
                            @if ($errors->any())
                                {{ implode(' | ', $errors->all()) }}
                            @endif
                        </div>
                        @if ($errors->has('login'))
                            <div class="alert-soft mb-3" role="alert">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="10" stroke="#dc2626" stroke-width="1.5" />
                                    <path d="M12 7v6" stroke="#dc2626" stroke-width="1.5" stroke-linecap="round" />
                                    <circle cx="12" cy="16.5" r="1" fill="#dc2626" />
                                </svg>

                                <div>
                                    <strong>Akun sedang digunakan</strong>
                                    <div class="text-sm" style="margin-top:2px">
                                        Akun ini masih aktif di perangkat lain.
                                        Silakan logout dari perangkat sebelumnya atau hubungi admin.
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($errors->has('session_expired'))
                            <div class="alert-soft mb-3"
                                style="background:rgba(254,243,199,.95);color:#92400e;border-color:rgba(251,191,36,.4)">
                                <strong>Session berakhir</strong>
                                <div style="font-size:.9rem">
                                    Demi keamanan, Anda otomatis logout karena tidak ada aktivitas.
                                    Silakan login kembali.
                                </div>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" autocomplete="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="nama@perusahaan.com" value="{{ old('email') }}" required autofocus
                                    aria-describedby="emailHelp" />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge" role="group"
                                    aria-label="Password field with toggle">
                                    <input type="password" id="password" name="password"
                                        autocomplete="current-password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="••••••••" required aria-describedby="pwToggle" />
                                    <button type="button" class="input-group-text" id="pwToggle"
                                        aria-label="Toggle password visibility" title="Toggle password visibility">
                                        <!-- Icon Show -->
                                        <svg id="icon-show" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" aria-hidden="true" focusable="false">
                                            <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#111827"
                                                stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="12" cy="12" r="3" stroke="#111827"
                                                stroke-width="1.2" />
                                        </svg>

                                        <!-- Icon Hide -->
                                        <svg id="icon-hide" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" aria-hidden="true" focusable="false"
                                            style="display:none">
                                            <path
                                                d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-6 0-10-7-10-7a19.85 19.85 0 0 1 5.5-5.94"
                                                stroke="#111827" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M1 1l22 22" stroke="#111827" stroke-width="1.2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>

                                        <span class="sr-only" id="pwToggleLabel">Tampilkan kata sandi</span>
                                    </button>
                                </div>

                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember & Forgot -->
                            <div class="mb-3 helper-row">
                                <div style="display:flex;align-items:center;gap:.5rem">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>

                                @if (Route::has('password.request'))
                                    <div>
                                        <a href="{{ route('password.request') }}"
                                            class="small-muted link-primary">Forgot password?</a>
                                    </div>
                                @endif
                            </div>

                            <!-- Submit -->
                            <div class="mb-3 d-grid">
                                <button class="btn btn-primary" type="submit">Sign in</button>
                            </div>

                            <!-- OR separator -->
                            <div class="text-center my-3 small-muted" aria-hidden="true">or continue with</div>

                            <!-- Social / OAuth (optional) -->
                            @if (Route::has('social.redirect'))
                                <div class="mb-3 d-grid gap-2">
                                    <a href="{{ route('social.redirect', ['provider' => 'google']) }}"
                                        class="btn-google" title="Sign in with Google"
                                        aria-label="Sign in with Google">
                                        <svg width="18" height="18" viewBox="0 0 48 48"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path fill="#f44336"
                                                d="M24 9.5c3.5 0 6.4 1.2 8.7 2.8l6.3-6.3C35.9 3 30.4 1 24 1 14.3 1 6.4 6.8 3 14.9l7.6 5.9C12.2 15.1 17.6 9.5 24 9.5z" />
                                            <path fill="#4caf50"
                                                d="M46.5 24c0-1.5-.1-3-.4-4.4H24v8.4h12.7c-.5 2.6-2 4.9-4.2 6.4l6.5 5c3.8-3.6 6-8.7 6-15.4z" />
                                        </svg>
                                        <span>Sign in with Google</span>
                                    </a>
                                </div>
                            @endif

                            <div class="foot-cta">
                                <span class="small-muted">Belum punya akun? </span>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="link-primary">Buat akun</a>
                                @else
                                    <span class="small-muted">Hubungi admin untuk akun.</span>
                                @endif
                            </div>
                        </form>

                        <!-- Inline server-side error list (visible) -->
                        {{-- @if ($errors->any())
                            <div class="mt-3" role="status" aria-live="polite">
                                <ul class="text-sm text-danger"
                                    style="color:#b91c1c; margin:0.6rem 0 0 0; padding-left:1.15rem;">
                                    @foreach ($errors->all() as $err)
                                        <li style="margin-bottom:.25rem">{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Core JS (existing include) -->
    @include('includes.admin.script')

    <script>
        (function() {
            const pwToggle = document.getElementById('pwToggle');
            const pwInput = document.getElementById('password');
            const iconShow = document.getElementById('icon-show');
            const iconHide = document.getElementById('icon-hide');
            const pwToggleLabel = document.getElementById('pwToggleLabel');

            function setState(show) {
                if (show) {
                    pwInput.setAttribute('type', 'text');
                    iconShow.style.display = 'none';
                    iconHide.style.display = '';
                    pwToggleLabel.textContent = 'Sembunyikan kata sandi';
                } else {
                    pwInput.setAttribute('type', 'password');
                    iconShow.style.display = '';
                    iconHide.style.display = 'none';
                    pwToggleLabel.textContent = 'Tampilkan kata sandi';
                }
            }

            if (pwToggle && pwInput) {
                // initialize
                setState(false);

                pwToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    setState(pwInput.type === 'password');
                    pwInput.focus();
                });

                pwToggle.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        pwToggle.click();
                    }
                });
            }

            // autofocus first invalid field if exist (also works on server-render)
            document.addEventListener('DOMContentLoaded', function() {
                const invalid = document.querySelector('.is-invalid');
                if (invalid) invalid.focus();
            });
        })();
    </script>
</body>

</html>
