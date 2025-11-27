<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>History Kalibrasi — {{ $tool->nama_alat ?? 'Alat' }}</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --accent: #1765d1;
      --accent-2: #60a5fa;
      --muted: #64748b;
      --card-bg: #ffffff;
      --glass: rgba(255,255,255,0.78);
      --rounded: 12px;
      --shadow-1: 0 8px 30px rgba(16,24,40,0.06);
      --shadow-2: 0 6px 18px rgba(16,24,40,0.06);
    }

    html,body { height:100%; }
    body {
      min-height:100%;
      margin:0;
      font-family: Inter, "Segoe UI", system-ui, -apple-system, "Helvetica Neue", Arial;
      background: linear-gradient(135deg, #f3fbff 0%, #f7fbfe 100%);
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      color:#0f172a;
      -webkit-tap-highlight-color: transparent;
    }

    .container-main { padding: 36px 20px; max-width:1100px; margin:0 auto; }

    .topbar {
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:1rem;
      margin-bottom:18px;
    }
    .topbar .title { display:flex; flex-direction:column; gap:4px; }
    .topbar h1 { margin:0; font-size:1.25rem; font-weight:700; color:var(--accent); letter-spacing: -0.2px; }
    .topbar .subtitle { font-size:.9rem; color:var(--muted); }

    .tool-info {
      background:var(--card-bg);
      padding:16px;
      border-radius:var(--rounded);
      box-shadow: var(--shadow-1);
      display:flex;
      justify-content:space-between;
      gap:1rem;
      align-items:center;
      margin-bottom:18px;
      border: 1px solid rgba(15,23,42,0.03);
    }
    .tool-meta { font-size:.95rem; color:var(--muted); gap:12px; display:flex; flex-wrap:wrap; align-items:center; }
    .tool-meta div { display:inline-flex; gap:.5rem; align-items:center; }

    /* timeline */
    .timeline {
      position:relative;
      padding-left:20px;
      margin-top:8px;
    }
    .timeline::before {
      content:"";
      position:absolute;
      left:6px;
      top:6px;
      bottom:6px;
      width:4px;
      background: linear-gradient(180deg,var(--accent), rgba(96,165,250,0.18));
      border-radius:3px;
      filter: drop-shadow(0 2px 6px rgba(16,24,40,0.02));
    }

    .timeline-item {
      position:relative;
      margin-left:56px;
      margin-bottom:18px;
      display:flex;
      gap:14px;
      align-items:flex-start;
      transition: transform .12s ease;
    }
    .timeline-item:hover { transform: translateY(-4px); }

    .timeline-bullet {
      position:absolute;
      left:-64px;
      top:2px;
      width:52px;
      height:52px;
      border-radius:10px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      color:#fff;
      font-weight:700;
      box-shadow:0 12px 30px rgba(10,20,40,0.06);
      border: 5px solid #fff;
      transition: transform .12s ease;
    }
    .timeline-bullet.latest { background:linear-gradient(180deg,#16a34a,#059669); }
    .timeline-bullet.ok { background:linear-gradient(180deg,#10b981,#059669); }
    .timeline-bullet.proses { background:linear-gradient(180deg,#f59e0b,#f97316); }
    .timeline-bullet.due { background:linear-gradient(180deg,#ef4444,#dc2626); }

    .timeline-bullet small { font-size:10px; display:block; line-height:1; }

    .history-card {
      background:var(--card-bg);
      border-radius:10px;
      padding:16px;
      flex:1;
      box-shadow: var(--shadow-2);
      border:1px solid rgba(15,23,42,0.04);
      transition: box-shadow .12s ease, transform .12s ease;
    }
    .history-card:hover { box-shadow: 0 18px 40px rgba(16,24,40,0.08); transform: translateY(-4px); }

    .badge-status {
      display:inline-flex; gap:.4rem; align-items:center; padding:.32rem .56rem; border-radius:999px; font-weight:600; font-size:.84rem;
      box-shadow: inset 0 -1px 0 rgba(0,0,0,0.02);
    }
    .badge-ok { background:#ecfdf5; color:#166534; }
    .badge-proses { background:#fffbeb; color:#92400e; }
    .badge-due { background:#fff1f2; color:#991b1b; }

    /* Mobile PDF */
    .pdf-frame {
      width: 100%;
      height: 80vh;
      border: none;
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
    }

  </style>
</head>


<body>
  <div class="container-main">

    <div class="topbar">
      <div class="title">
        <h1>History Kalibrasi</h1>
        <div class="subtitle">Riwayat kalibrasi alat — detail, sertifikat dan catatan</div>
      </div>
    </div>

    <div class="tool-info">
      <div>
        <h2 class="h5 mb-1">{{ e($tool->nama_alat) }}</h2>
        <div class="tool-meta">
          <div><strong>No Seri:</strong> {{ e($tool->no_seri) ?? 'Tidak ada' }}</div>
          <div><strong>Kapasitas:</strong> {{ e($tool->kapasitas) ?? '-' }}</div>
          <div><strong>Lokasi:</strong> {{ e($tool->lokasi ?? '-') }}</div>
          <div><strong>Histori:</strong> <span id="historyCount" class="text-muted">0</span> Kali</div>
        </div>
      </div>

      <div class="text-end">
        <img src="{{ $tool->qr_code_path ? asset('storage/' . $tool->qr_code_path) : 'https://dummyimage.com/100x100/1976d2/ffffff&text=QR' }}"
             alt="QR" width="100" height="100" style="border-radius:8px; object-fit:cover;">
      </div>
    </div>

    {{-- Timeline --}}
    <div id="timelineRoot" class="timeline" aria-live="polite">
      @php $histories = $tool->histories->sortByDesc('tgl_kalibrasi'); @endphp

      @if($histories->isEmpty())
        <div class="empty-state">
          <h4>Belum Ada Riwayat</h4>
        </div>
      @else

      @foreach($histories as $h)
        @php
          $isLatest = $loop->first;
          $certUrl = $h->file_sertifikat ? Storage::url($h->file_sertifikat) : null;
          $status = strtoupper($h->status_kalibrasi ?? '');
          $marker = $isLatest ? 'latest' : ($status === 'OK' ? 'ok' : ($status === 'PROSES' ? 'proses' : 'due'));
        @endphp

        <div class="timeline-item">

          <div class="timeline-bullet {{ $marker }}">
            @if($isLatest)
              <small>Baru</small>
            @else
              <small>{{ $loop->iteration }}</small>
            @endif
          </div>

          <article class="history-card">
            <div class="d-flex justify-content-between">
              <div>
                <div class="history-meta">
                  <strong>{{ \Carbon\Carbon::parse($h->tgl_kalibrasi)->format('d M Y') }}</strong>
                </div>
                <div class="history-title">{{ e($h->lembaga_kalibrasi ?? '-') }}</div>

                <span class="badge-status {{ $status === 'OK' ? 'badge-ok' : ($status === 'PROSES' ? 'badge-proses' : 'badge-due') }}">
                  {{ $status ?? '-' }}
                </span>
              </div>

              <div class="text-end">
                @if($certUrl)
                  <button class="btn btn-sm btn-outline-secondary" data-pdf="{{ $certUrl }}">📄 Lihat</button>
                @endif
              </div>
            </div>

            <hr>

            <p><strong>No Sertifikat:</strong> {{ e($h->no_sertifikat ?? '-') }}</p>
            <p><strong>Interval:</strong> {{ e($h->interval_kalibrasi ?? '-') }}</p>
          </article>

        </div>

      @endforeach
      @endif
    </div>

  </div>

  <!-- PDF Modal -->
  <div class="modal fade" id="pdfModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">

        <div class="modal-header">
          <h5>Sertifikat Kalibrasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body p-0">
          <iframe id="pdfFrame" class="pdf-frame" src=""></iframe>
        </div>

        <div class="modal-footer">
          <a id="pdfDownload" href="#" class="btn btn-outline-success" target="_blank">Download</a>
        </div>

      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    (function(){
      const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
      const pdfFrame = document.getElementById('pdfFrame');
      const pdfDownload = document.getElementById('pdfDownload');

      function openPDFModal(url) {
        if (!url) return;

        // Google Docs Viewer fix
        const viewer = "https://docs.google.com/gview?embedded=true&url=" + encodeURIComponent(url);

        pdfFrame.src = viewer;
        pdfDownload.href = url;

        pdfModal.show();
      }

      document.addEventListener("click", function(e){
        const btn = e.target.closest("[data-pdf]");
        if (!btn) return;
        e.preventDefault();
        openPDFModal(btn.getAttribute("data-pdf"));
      });

      document.getElementById("pdfModal").addEventListener("hidden.bs.modal", () => {
        pdfFrame.src = "";
      });
    })();
  </script>

</body>
</html>
