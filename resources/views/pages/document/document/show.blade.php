<style>
    .modal-doc-wrapper {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #1f2937;
        padding: 6px;
    }

    .modal-doc-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 1px solid #eef2f7;
    }

    .modal-doc-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }

    .badge-folder {
        background: #eef2ff;
        color: #3730a3;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-final {
        background: #dcfce7;
        color: #166534;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 10px;
    }

    .info-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 26px;
    }

    .stat-card {
        background: #f9fafb;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        transition: 0.2s;
    }

    .stat-card:hover {
        background: #f3f4f6;
    }

    .stat-label {
        font-size: 10px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        margin-bottom: 6px;
        display: block;
    }

    .stat-value {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .description-content {
        font-size: 14px;
        color: #4b5563;
        line-height: 1.7;
        padding: 16px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 26px;
    }

    .preview-section {
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        background: #f8fafc;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
        margin-bottom: 30px;
    }

    .preview-header {
        background: white;
        padding: 12px 18px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e5e7eb;
    }

    .iframe-container {
        width: 100%;
        height: 500px;
        border: none;
    }

    /* ================= HISTORY TIMELINE ================= */

    .history-section {
        margin-bottom: 30px;
    }

    .history-title {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 16px;
    }

    .timeline {
        position: relative;
        padding-left: 22px;
        border-left: 2px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .timeline-item {
        position: relative;
    }

    .timeline-dot {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #2563eb;
    }

    .timeline-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 14px 16px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .03);
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
        font-size: 13px;
    }

    .timeline-action {
        font-weight: 600;
        color: #111827;
    }

    .timeline-meta {
        font-size: 11px;
        color: #9ca3af;
    }

    .timeline-note {
        font-size: 13px;
        color: #4b5563;
        margin-top: 6px;
        line-height: 1.6;
    }

    .badge-revision {
        background: #eef2ff;
        color: #3730a3;
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 6px;
    }

    .modal-doc-footer {
        margin-top: 26px;
        display: flex;
        justify-content: flex-end;
    }

    .btn-download-action {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white !important;
        padding: 10px 22px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
        box-shadow: 0 6px 16px rgba(37, 99, 235, .2);
    }

    .btn-download-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(37, 99, 235, .3);
    }

    @media (max-width: 768px) {
        .info-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="modal-doc-wrapper">

    <div class="modal-doc-header">
        <div>
            <h2 class="modal-doc-title">
                {{ $document->title }}

                @if ($document->is_final)
                    <span class="badge-final">FINAL</span>
                @endif
            </h2>
        </div>

        <div class="badge-folder">
            {{ $document->folder->folder_name ?? 'General' }}
        </div>
    </div>

    @php
        $fullPath = $document->file_path ? public_path($document->file_path) : null;

        $fileExists = $fullPath && file_exists($fullPath);

        $fileSize = '-';

        if ($fileExists) {
            $size = filesize($fullPath);

            $fileSize =
                $size >= 1024 * 1024
                    ? number_format($size / 1024 / 1024, 1) . ' MB'
                    : number_format($size / 1024, 0) . ' KB';
        }
    @endphp


    <div class="info-stats-grid">
        <div class="stat-card">
            <span class="stat-label">Doc Number</span>
            <span class="stat-value">{{ $document->document_no ?? '-' }}</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Revision</span>
            <span class="stat-value">Rev {{ $document->revision ?? '0' }}</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Size</span>
            <span class="stat-value">{{ $fileSize }} KB</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Date</span>
            <span class="stat-value">{{ $document->created_at->format('d M Y') }}</span>
        </div>
    </div>

    <div class="description-content">
        {{ $document->description ?? 'No detailed description available.' }}
    </div>
    @if ($fileExists)
        <div class="preview-section">
            <div class="preview-header">
                Document Preview
            </div>

            {{-- <iframe class="iframe-container" src="{{ route('document.preview', $document->id) }}" width="100%"
                height="600" style="border:none;">
            </iframe> --}}
            <iframe class="iframe-container" src="{{ asset($document->file_path) }}" width="100%" height="600"
                style="border:none;">
            </iframe>
        </div>
    @else
        <div style="padding:20px;color:#6b7280;">
            File tidak ditemukan.
        </div>
    @endif


    {{-- ================= TIMELINE HISTORY ================= --}}
    @if ($document->histories->count())
        <div class="history-section">
            <div class="history-title">Document Activity</div>

            <div class="timeline">
                @foreach ($document->histories as $history)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>

                        <div class="timeline-card">
                            <div class="timeline-header">
                                <div class="timeline-action">
                                    {{ ucfirst($history->action) }}

                                    @if ($history->revision)
                                        <span class="badge-revision">
                                            Rev {{ $history->revision }}
                                        </span>
                                    @endif
                                </div>

                                <div class="timeline-meta">
                                    {{ $history->user->name ?? 'System' }} •
                                    {{ $history->created_at->format('d M Y H:i') }}
                                </div>
                            </div>

                            @if ($history->note)
                                <div class="timeline-note">
                                    {{ $history->note }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
