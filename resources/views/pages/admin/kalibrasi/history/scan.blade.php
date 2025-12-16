<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
  <title>History Kalibrasi — {{ $tool->nama_alat ?? 'Alat' }}</title>

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap (utilities + modal) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --bg: #f7fbff;
      --accent: #1765d1;
      --muted: #6b7280;
      --card: #ffffff;
      --glass: rgba(255,255,255,0.9);
      --radius: 12px;
      --success: #16a34a;
      --warning: #f59e0b;
      --danger: #ef4444;
      --shadow-sm: 0 8px 28px rgba(16,24,40,0.06);
    }

    * { box-sizing: border-box; }
    html,body {
      height:100%;
      margin:0;
      font-family:"Inter",system-ui,-apple-system,"Segoe UI",Roboto,Arial;
      background: linear-gradient(180deg,var(--bg),#fbfbfe 100%);
      color:#071133;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      font-size:14px;
    }

    .container-main{
      max-width:1100px;
      margin:28px auto;
      padding:20px;
    }

    /* Topbar */
    .topbar{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:1rem;
      margin-bottom:18px;
    }
    .topbar .title h1{
      margin:0;
      font-size:1.25rem;
      color:var(--accent);
      font-weight:700;
    }
    .subtitle{ color:var(--muted); font-size:0.95rem; margin-top:4px }

    /* Tool info */
    .tool-info{
      background: linear-gradient(180deg, rgba(255,255,255,0.92), var(--glass));
      padding:14px;
      border-radius:var(--radius);
      box-shadow:var(--shadow-sm);
      display:flex;
      gap:1rem;
      align-items:center;
      justify-content:space-between;
      border:1px solid rgba(15,23,42,0.04);
      margin-bottom:20px;
    }
    .tool-left{ display:flex; gap:16px; align-items:center; min-width:0; }
    .tool-left h2{ margin:0; font-size:1rem; font-weight:700; }
    .tool-meta{ color:var(--muted); font-size:0.95rem; display:flex; gap:12px; flex-wrap:wrap; }
    .qr-box{ width:92px; height:92px; border-radius:10px; overflow:hidden; background:#f3f6fb; display:flex; align-items:center; justify-content:center; flex-shrink:0; border:1px solid rgba(15,23,42,0.03); }
    .qr-box img{ width:100%; height:100%; object-fit:cover; display:block; }

    /* Timeline */
    .timeline{
      position:relative;
      padding-left:26px;
      margin-top:8px;
    }
    .timeline::before{
      content:"";
      position:absolute;
      left:18px;
      top:12px;
      bottom:12px;
      width:4px;
      background:linear-gradient(180deg,var(--accent), rgba(96,165,250,0.14));
      border-radius:6px;
    }

    .timeline-item{
      position:relative;
      margin-left:64px;
      margin-bottom:18px;
      display:grid;
      grid-template-columns: 1fr auto;
      gap:14px;
      align-items:start;
    }

    .timeline-bullet{
      position:absolute;
      left:-64px;
      top:0;
      width:56px;
      height:56px;
      border-radius:12px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      color:#fff;
      font-weight:700;
      box-shadow: 0 8px 26px rgba(16,24,40,0.06);
      border:5px solid #fff;
      text-align:center;
    }
    .timeline-bullet small{ display:block; font-size:11px; line-height:1; }

    .timeline-bullet.latest{ background:linear-gradient(180deg,var(--success), #059669) }
    .timeline-bullet.ok{ background:linear-gradient(180deg,#10b981,#059669) }
    .timeline-bullet.proses{ background:linear-gradient(180deg,#f59e0b,#f97316) }
    .timeline-bullet.due{ background:linear-gradient(180deg,#ef4444,#dc2626) }

    .history-card{
      background:var(--card);
      border-radius:10px;
      padding:16px;
      box-shadow:0 8px 18px rgba(16,24,40,0.04);
      border:1px solid rgba(15,23,42,0.04);
      transition:transform .12s ease, box-shadow .12s ease;
      min-width:0;
    }
    .history-card:hover{ transform:translateY(-6px); box-shadow:0 16px 40px rgba(16,24,40,0.06); }

    .history-meta{ color:var(--muted); font-size:0.9rem; margin-bottom:6px; }
    .history-title{ font-weight:700; color:#071133; margin-bottom:8px; font-size:1rem }

    .badge-status{
      display:inline-flex;
      gap:.4rem;
      align-items:center;
      padding:.3rem .6rem;
      border-radius:999px;
      font-weight:600;
      font-size:0.86rem;
    }
    .badge-ok{ background:#ecfdf5; color:var(--success); }
    .badge-proses{ background:#fffbeb; color:#92400e; }
    .badge-due{ background:#fff1f2; color:var(--danger); }

    .history-meta-row{ display:flex; gap:12px; align-items:center; flex-wrap:wrap; color:var(--muted); font-size:0.93rem; margin-top:10px; }
    .history-actions{ display:flex; gap:8px; align-items:center; justify-content:flex-end; }

    .pdf-frame{ width:100%; height:100%; border:0; display:block; }

    .empty-state{
      padding:48px; text-align:center; background:linear-gradient(180deg, rgba(23,101,209,0.03), rgba(96,165,250,0.02));
      border-radius:12px; border:1px dashed rgba(15,23,42,0.04)
    }

    .small-muted{ color:var(--muted); font-size:0.9rem; }

    /* Mobile tweaks */
    @media (max-width:768px){
      .timeline-item{ margin-left:56px; grid-template-columns:1fr; gap:12px; }
      .timeline-bullet{ left:-56px; }
      .tool-info{ flex-direction:column; align-items:stretch; gap:12px; }
      .history-actions{ justify-content:flex-start; }
      .history-card{ padding:12px; }
      .history-title{ font-size:0.98rem; }
      .qr-box{ width:80px; height:80px; }
    }

    /* Small micro-polish */
    .btn-ghost {
      background: transparent;
      border: 1px solid rgba(15,23,42,0.06);
      color: var(--accent);
    }
    .muted { color:var(--muted); }
  </style>
</head>

<body>
  <div class="container-main">
    <div class="topbar">
      <div class="title">
        <h1>History Kalibrasi</h1>
        <div class="subtitle">Riwayat kalibrasi alat — detail, sertifikat, dan catatan</div>
      </div>

      <div class="d-flex gap-2 align-items-center">
        <a href="{{ route('histories.index') }}" class="btn btn-ghost btn-sm" aria-label="Kembali ke daftar history">
          <!-- simple SVG back icon -->
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="margin-right:6px;vertical-align:middle">
            <path d="M15 18l-6-6 6-6" stroke="#1765d1" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Kembali
        </a>
      </div>
    </div>

    <!-- Tool Info -->
    <div class="tool-info" role="region" aria-label="Informasi alat">
      <div class="tool-left">
        <div>
          <h2 class="h5 mb-1" style="margin:0; font-weight:700">{{ e($tool->nama_alat) }}</h2>
          <div class="tool-meta">
            <div><strong>No Seri:</strong> <span class="small-muted">{{ e($tool->no_seri) ?? 'Tidak ada' }}</span></div>
            <div><strong>Kapasitas:</strong> <span class="small-muted">{{ e($tool->kapasitas) ?? '-' }}</span></div>
            <div><strong>Lokasi:</strong> <span class="small-muted">{{ e($tool->lokasi) ?? '-' }}</span></div>
            <div><strong>Histori:</strong> <span id="historyCount" class="small-muted">0</span> Kali</div>
          </div>
        </div>
      </div>

      <div class="d-flex align-items-center gap-3">
        <div class="text-end small-muted" style="font-size:0.9rem">
          <div>QR Alat</div>
        </div>
        <div class="qr-box" aria-hidden="true">
          <img src="{{ $tool->qr_code_path ? asset('storage/' . $tool->qr_code_path) : 'https://dummyimage.com/100x100/1976d2/ffffff&text=QR' }}" alt="QR {{ e($tool->nama_alat) }}">
        </div>
      </div>
    </div>

    <!-- Timeline -->
    <section id="timelineRoot" class="timeline" aria-live="polite">
      @php $histories = $tool->histories->sortByDesc('tgl_kalibrasi'); @endphp

      @if ($histories->isEmpty())
        <div class="empty-state" aria-hidden="false">
          <svg width="84" height="84" viewBox="0 0 24 24" fill="none" style="margin-bottom:12px">
            <rect x="1" y="3" width="22" height="14" rx="2" fill="#eaf6ff"/>
            <path d="M3 21h18" stroke="#d0eaff" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
          <h4 style="margin-bottom:6px">Belum Ada Riwayat</h4>
          <p class="small-muted" style="margin:0">Alat ini belum memiliki riwayat kalibrasi. Anda dapat menambahkan riwayat baru melalui halaman tambah.</p>
        </div>
      @else
        @foreach ($histories as $h)
          @php
            $isLatest = $loop->first;
            $certUrl = $h->file_sertifikat ? asset('storage/' . $h->file_sertifikat) : null;
            $status = strtoupper($h->status_kalibrasi ?? '');
            $marker = $isLatest
                ? 'latest'
                : ($status === 'OK'
                    ? 'ok'
                    : ($status === 'PROSES'
                        ? 'proses'
                        : 'due'));
          @endphp

          <div class="timeline-item" data-history-id="{{ $h->id ?? $loop->index }}">
            <div class="timeline-bullet {{ $marker }}" aria-hidden="true">
              @if ($isLatest)
                <small>Baru</small>
              @else
                <small>{{ $loop->iteration }}</small>
              @endif
            </div>

            <article class="history-card" aria-labelledby="history-{{ $h->id ?? $loop->index }}">
              <div class="d-flex justify-content-between align-items-start" style="gap:12px; flex-wrap:wrap;">
                <div style="min-width:0">
                  <div class="history-meta">
                    <strong id="history-{{ $h->id ?? $loop->index }}">{{ \Carbon\Carbon::parse($h->tgl_kalibrasi)->format('d M Y') }}</strong>
                  </div>

                  <div class="history-title">{{ e($h->lembaga_kalibrasi ?? '-') }}</div>

                  <div style="margin-top:6px">
                    <span class="badge-status {{ $status === 'OK' ? 'badge-ok' : ($status === 'PROSES' ? 'badge-proses' : 'badge-due') }}">
                      {{ $status ?? '-' }}
                    </span>
                  </div>

                  <div class="history-meta-row" style="margin-top:10px;">
                    <div><strong>No Sertifikat:</strong> <span class="small-muted">{{ e($h->no_sertifikat ?? '-') }}</span></div>
                    <div><strong>Interval:</strong> <span class="small-muted">{{ e($h->interval_kalibrasi ?? '-') }}</span></div>
                  </div>
                </div>

                <div class="history-actions">
                  @if ($certUrl)
                    <!-- Only view (no download) -->
                    <button type="button" class="btn btn-sm btn-outline-primary btn-view-pdf" data-pdf="{{ $certUrl }}" title="Lihat sertifikat">
                      <!-- document icon -->
                      <svg width="14" height="14" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px" fill="none">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" stroke="#1765d1" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14 2v6h6" stroke="#1765d1" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                      Lihat
                    </button>
                  @else
                    <span class="small-muted">Tidak ada sertifikat</span>
                  @endif
                </div>
              </div>
            </article>
          </div>
        @endforeach
      @endif
    </section>
  </div>

  <!-- PDF Modal (view only) -->
  <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content" style="overflow:hidden;border-radius:12px">
        <div class="modal-header">
          <h5 class="modal-title" id="pdfModalLabel">Pratinjau Sertifikat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body p-0" style="height:82vh; max-height:92vh;">
          <!-- we use object as fallback for browsers that may block iframe-pdf inline -->
          <iframe id="pdfFrame" class="pdf-frame" src="" title="Pratinjau sertifikat" allow="fullscreen"></iframe>
        </div>

        <div class="modal-footer">
          <small class="small-muted">Hanya pratinjau — fitur unduh telah dinonaktifkan.</small>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    (function () {
      // Update history count
      function refreshHistoryCount() {
        const items = document.querySelectorAll(".timeline-item");
        const countEl = document.getElementById("historyCount");
        if (countEl) countEl.textContent = items.length;
      }
      document.addEventListener('DOMContentLoaded', refreshHistoryCount);

      // Modal & PDF view (view-only)
      const pdfModalEl = document.getElementById('pdfModal');
      const pdfFrame = document.getElementById('pdfFrame');
      let bsModal = null;

      if (pdfModalEl) {
        bsModal = new bootstrap.Modal(pdfModalEl, {keyboard: true});
        pdfModalEl.addEventListener('hidden.bs.modal', function () {
          // Clear src to free memory and stop playback
          if (pdfFrame) pdfFrame.src = '';
        });
      }

      // Delegate click for view buttons
      document.addEventListener('click', function (ev) {
        const btn = ev.target.closest("[data-pdf]");
        if (!btn) return;
        ev.preventDefault();
        const url = btn.getAttribute("data-pdf");
        if (!url) return;

        // Set src (lazy-load)
        // Use a sanitized url; if you need a viewer proxy (pdf.js) you can swap here
        pdfFrame.src = url;

        if (bsModal) bsModal.show();
      });

      // Accessibility: close modal with Escape handled by bootstrap automatically
    })();
  </script>
</body>

</html>