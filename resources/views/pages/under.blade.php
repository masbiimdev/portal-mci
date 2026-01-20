@extends('layouts.home')

@section('title', 'Under Construction | Portal MCI')

@section('content')
<section id="under-construction" class="min-h-screen flex items-center justify-center overflow-hidden" aria-labelledby="pageTitle" role="main" style="height:100vh;">
    <!-- Fullscreen space scene (fixed) -->
    <div class="space-scene" style="position:fixed; inset:0; width:100%; height:100%; z-index:0; pointer-events:none;">
        <div class="stars" aria-hidden="true" style="position:absolute; inset:0; z-index:1; background-image: radial-gradient(#fff 0.8px, transparent 1px), radial-gradient(#fff 0.6px, transparent 1px); background-size: 1200px 1200px, 600px 600px; opacity: 0.55; animation: drift 60s linear infinite;"></div>
        <div class="stars2" aria-hidden="true" style="position:absolute; inset:0; z-index:2; background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 900px 900px; opacity: 0.28; animation: drift 100s linear infinite reverse;"></div>
        <div class="nebula" aria-hidden="true" style="position:absolute; inset:0; z-index:3; background: radial-gradient(ellipse at 10% 20%, rgba(96,165,250,0.10) 0%, rgba(59,130,246,0.06) 18%, transparent 40%), radial-gradient(ellipse at 80% 80%, rgba(219,234,254,0.06) 0%, rgba(99,102,241,0.03) 28%, transparent 50%); mix-blend-mode: screen; filter: blur(18px) saturate(110%);"></div>
    </div>

    <!-- Centered content (above the fixed background) -->
    <div class="center-wrap" style="position:relative; z-index:10; width:100%; max-width:980px; padding:2rem;">
        <div class="card" role="region" aria-labelledby="pageTitle"
             style="background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.015)); border:1px solid rgba(255,255,255,0.05); border-radius:14px; box-shadow: 0 18px 50px rgba(2,6,23,0.55); padding:2rem; color:#eaf6ff;">

            <header style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
                <div style="width:64px; height:64px; border-radius:14px; display:grid; place-items:center; background: linear-gradient(135deg,#60a5fa,#2563eb); box-shadow: 0 6px 18px rgba(37,99,235,0.18);">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 2s3 1 5 3 3 5 3 5-4 1-6 3c-2 2-3 6-3 6s-4-1-6-3S2 12 2 12s3-1 5-3 5-5 5-5z" stroke="rgba(255,255,255,0.95)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 14l3 3 3-3" stroke="rgba(255,255,255,0.95)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <div style="flex:1; min-width:220px;">
                    <h1 id="pageTitle" style="margin:0; font-size:1.6rem; line-height:1.05; font-weight:800; color:#f8fbff;">Portal MCI — Dalam Pengembangan</h1>
                    <p style="margin:.35rem 0 0; color:#d7eefe;">Sedang menyempurnakan dashboard kalibrasi dengan tampilan biru-putih elegan: grafik interaktif, export, dan notifikasi.</p>
                </div>

                <div style="display:flex; gap:.5rem; align-items:center;">
                    <a href="{{ url('/') }}" class="btn-back" aria-label="Kembali ke beranda"
                       style="background:#ffffff; color:#0b2a55; padding:.55rem .85rem; border-radius:10px; font-weight:700; text-decoration:none; box-shadow:0 8px 20px rgba(2,6,23,0.18);">Kembali</a>
                </div>
            </header>

            <div style="display:flex; gap:1.25rem; margin-top:1.25rem; align-items:flex-start; flex-wrap:wrap;">
                <!-- Left: message + subscribe -->
                <div style="flex:1; min-width:260px;">
                    <p style="margin:0 0 .6rem 0; color:#d0e9ff;">Halaman ini sedang dikembangkan. Kami menyiapkan pengalaman yang bersih, cepat, dan mudah digunakan untuk memantau kalibrasi alat.</p>

                    <form id="notifyForm" class="subscribe" onsubmit="return false;" style="display:flex; gap:.5rem; align-items:center; margin-top:.6rem;">
                        <label for="email" class="sr-only">Email pemberitahuan</label>
                        <input id="email" name="email" type="email" placeholder="Masukkan email untuk diberitahu" aria-label="Email pemberitahuan"
                               style="flex:1; padding:.56rem .85rem; border-radius:10px; border:1px solid rgba(255,255,255,0.06); background:rgba(255,255,255,0.02); color:#eaf6ff;" required />
                        <button id="notifyBtn" class="btn-primary" aria-label="Beri tahu saya"
                                style="padding:.56rem .9rem; border-radius:10px; background:linear-gradient(90deg,#60a5fa,#1e40af); color:white; font-weight:700; border:0;">Beri tahu saya</button>
                    </form>

                    <div id="notifyMsg" role="status" aria-live="polite" style="margin-top:.6rem; color:#bfe1ff; font-size:.95rem;"></div>
                </div>

                <!-- Right: decorative planet -->
                <div style="width:260px; min-width:180px; display:flex; align-items:center; justify-content:center; position:relative;">
                    <div class="planet" aria-hidden="true" style="width:160px; height:160px; border-radius:50%; background: radial-gradient(circle at 30% 30%, #e6f6ff, #8ecdf9 40%, #60a5fa 85%); box-shadow: 0 10px 28px rgba(37,99,235,0.12); position:relative;">
                        <svg viewBox="0 0 200 200" style="position:absolute; inset:0; width:100%; height:100%; pointer-events:none;">
                            <ellipse cx="100" cy="115" rx="80" ry="22" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="4" transform="rotate(-12 100 100)"></ellipse>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles (kept local and minimal) -->
<style>
    /* Ensure page occupies full viewport and background fixed */
    html, body { height: 100%; margin: 0; background: linear-gradient(180deg, #07163a 0%, #031030 100%); }
    #under-construction { min-height: 100vh; height: 100vh; }

    /* Stars & nebula animations */
    @keyframes drift { from { background-position:0 0 } to { background-position:-1500px 800px } }

    .stars { background-image: radial-gradient(#fff 0.9px, transparent 1px), radial-gradient(#fff 0.6px, transparent 1px); background-size:1000px 1000px, 600px 600px; opacity:0.55; animation: drift 70s linear infinite; }
    .stars2 { background-image: radial-gradient(#fff 0.8px, transparent 1px); background-size:800px 800px; opacity:0.28; animation: drift 120s linear infinite reverse; }
    .nebula { background: radial-gradient(ellipse at 20% 20%, rgba(96,165,250,0.12) 0%, rgba(59,130,246,0.06) 18%, transparent 40%), radial-gradient(ellipse at 85% 80%, rgba(219,234,254,0.05) 0%, rgba(99,102,241,0.03) 28%, transparent 50%); mix-blend-mode: screen; filter: blur(14px) saturate(110%); opacity:0.95; }

    /* small animations */
    @keyframes float { 0%{ transform: translateY(0) rotate(-2deg);} 50%{ transform: translateY(-8px) rotate(3deg);} 100%{ transform: translateY(0) rotate(-2deg);} }
    .planet { animation: float 6s ease-in-out infinite; }

    /* Accessibility helpers */
    .sr-only { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0; }

    /* Responsive tweaks */
    @media (max-width:640px){
        .center-wrap { padding:1rem; }
        .card { padding:1rem; }
    }
</style>

<!-- Tiny client JS -->
<script>
    (function(){
        const form = document.getElementById('notifyForm');
        const email = document.getElementById('email');
        const btn = document.getElementById('notifyBtn');
        const msg = document.getElementById('notifyMsg');

        function show(message, ok = true){
            msg.textContent = message;
            msg.style.color = ok ? '#d0efff' : '#ffb4b4';
        }

        if(form){
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const v = email.value ? email.value.trim() : '';
                if(!v || v.indexOf('@') === -1){
                    show('Masukkan email yang valid.', false);
                    email.focus();
                    return;
                }
                btn.disabled = true;
                btn.textContent = 'Mendaftarkan...';
                setTimeout(() => {
                    btn.disabled = false;
                    btn.textContent = 'Beri tahu saya';
                    show('Terima kasih — kami akan mengabari Anda.', true);
                    email.value = '';
                }, 900);
            });
        }

        document.addEventListener('keydown', (e) => {
            if(e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA'){
                e.preventDefault();
                email?.focus();
            }
        });
    })();
</script>
@endsection