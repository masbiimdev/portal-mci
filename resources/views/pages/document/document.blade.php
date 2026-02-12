<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Folder {{ $folder->folder_name }} — Document Transmittal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
    --primary: #0d1b2a;
    --accent: #0d6efd;
    --bg: #f4f6f9;
    --card: #ffffff;
    --text-muted: #6c757d;
    --radius: 14px;
}

body {
    background: var(--bg);
    font-family: 'Segoe UI', system-ui, sans-serif;
    color: #1f2937;
}

.container-main {
    max-width: 1200px;
    margin: auto;
    padding: 32px 20px;
}

/* HEADER */
.page-header {
    background: linear-gradient(135deg, #0d1b2a, #1b263b);
    color: #fff;
    padding: 30px 32px;
    border-radius: 18px;
    margin-bottom: 24px;
}

.page-header h3 {
    font-weight: 600;
    margin-bottom: 4px;
}

.page-header small {
    color: #cbd5e1;
    font-size: 14px;
    line-height: 1.4;
}

.header-meta {
    padding-left: 24px;
    border-left: 1px solid rgba(255,255,255,.18);
}

.header-meta small {
    color: #cbd5e1;
    font-size: 13px;
}

/* BREADCRUMB */
.breadcrumb-custom {
    font-size: 14px;
    margin-bottom: 20px;
    color: var(--text-muted);
}

.breadcrumb-custom span {
    color: var(--accent);
    font-weight: 600;
}

/* CARD */
.card {
    border: none;
    border-radius: var(--radius);
    background: var(--card);
    box-shadow: 0 10px 28px rgba(0,0,0,.06);
}

/* TOOLBAR */
.toolbar {
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.toolbar input,
.toolbar select {
    font-size: 14px;
    border-radius: 8px;
}

/* TABLE */
.table-wrapper {
    max-height: 480px;
    overflow: auto;
}

.table {
    margin: 0;
}

.table thead th {
    position: sticky;
    top: 0;
    background: #fff;
    z-index: 1;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #6b7280;
    border-bottom: 1px solid #e5e7eb;
    padding: 14px 20px;
}

.table tbody td {
    padding: 18px 20px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

/* ROW STYLE */
.table tbody tr {
    transition: background .15s ease, box-shadow .15s ease;
}

.table tbody tr:hover {
    background: #f8fafc;
    box-shadow: inset 4px 0 0 var(--accent);
}

/* FILE INFO */
.file-name {
    font-weight: 600;
}

.file-meta {
    font-size: 13px;
    color: var(--text-muted);
}

/* STATUS */
.badge-status {
    font-size: 12px;
    padding: 6px 14px;
    border-radius: 999px;
    font-weight: 500;
}

/* ACTION */
.btn-download {
    padding: 6px 16px;
    font-size: 13px;
    border-radius: 8px;
}
</style>
</head>

<body>

<div class="container-main">

    <!-- HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h3>Folder: {{ $folder->folder_name }}</h3>
            <small>
                {{ $folder->description ?? 'Dokumen resmi project.' }}<br>
                <strong>{{ $documents->count() }} dokumen</strong>
                • Update terakhir
                <strong>
                    {{ $lastUpdate ? \Carbon\Carbon::parse($lastUpdate)->format('d M Y') : '-' }}
                </strong>
            </small>
        </div>

        <div class="header-meta text-end">
            <div class="fw-semibold">Project</div>
            <small>{{ $project->project_name ?? '—' }}</small>
        </div>

    </div>

    <!-- BREADCRUMB -->
    <div class="breadcrumb-custom">
        Home / Transmittal / <span>{{ $folder->folder_name }}</span>
    </div>

    <!-- FILE LIST -->
    <div class="card">

        <!-- TOOLBAR -->
        <div class="toolbar">
            <input type="text"
                   class="form-control w-25"
                   placeholder="Cari dokumen..."
                   id="searchInput">

            <select class="form-select w-25" id="statusFilter">
                <option value="">Semua Status</option>
                <option value="RELEASED">Released</option>
                <option value="APPROVED">Approved</option>
                <option value="DRAFT">Draft</option>
            </select>

            <a href="{{ route('portal.document.download.all', $folder->id) }}"
               class="btn btn-outline-secondary ms-auto">
                Download Semua
            </a>
        </div>

        <!-- TABLE -->
        <div class="table-wrapper">
            <table class="table" id="documentTable">
                <thead>
                    <tr>
                        <th>Dokumen</th>
                        <th>Nomor</th>
                        <th>Revisi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                @forelse ($documents as $doc)
                    <tr data-status="{{ $doc->status }}">
                        <td>
                            <div class="file-name">{{ $doc->document_name }}</div>
                            <div class="file-meta">
                                {{ strtoupper(pathinfo($doc->file_path, PATHINFO_EXTENSION)) }}
                                • {{ number_format($doc->file_size / 1024 / 1024, 1) }} MB
                            </div>
                        </td>

                        <td>{{ $doc->document_number }}</td>
                        <td>Rev. {{ $doc->revision }}</td>

                        <td>
                            <span class="badge badge-status
                                bg-{{ $doc->status === 'RELEASED' ? 'success' :
                                      ($doc->status === 'APPROVED' ? 'primary' : 'secondary') }}">
                                {{ $doc->status }}
                            </span>
                        </td>

                        <td>{{ $doc->updated_at->format('d M Y') }}</td>

                        <td class="text-end">
                            <a href="{{ route('portal.document.download', $doc->id) }}"
                               class="btn btn-outline-primary btn-download">
                                Download
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            Belum ada dokumen di folder ini
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll('#documentTable tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword)
            ? ''
            : 'none';
    });
});

document.getElementById('statusFilter').addEventListener('change', function () {
    const status = this.value;
    document.querySelectorAll('#documentTable tbody tr').forEach(row => {
        row.style.display =
            status === '' || row.dataset.status === status
            ? ''
            : 'none';
    });
});
</script>

</body>
</html>
