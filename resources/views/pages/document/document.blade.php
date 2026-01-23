<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Drawing Folder — Document Transmittal</title>

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
            <h3>Folder: Drawing</h3>
            <small>
                Dokumen teknik resmi untuk kebutuhan engineering & manufacturing.<br>
                <strong>12 dokumen</strong> • Update terakhir <strong>20 Jan 2026</strong>
            </small>
        </div>

        <div class="header-meta text-end">
            <div class="fw-semibold">Project</div>
            <small>Valve Assembly Series</small>
        </div>

    </div>

    <!-- BREADCRUMB -->
    <div class="breadcrumb-custom">
        Home / Transmittal / <span>Drawing</span>
    </div>

    <!-- FILE LIST -->
    <div class="card">

        <!-- TOOLBAR -->
        <div class="toolbar">
            <input type="text" class="form-control w-25" placeholder="Cari dokumen...">

            <select class="form-select w-25">
                <option>Semua Status</option>
                <option>Released</option>
                <option>Approved</option>
                <option>Draft</option>
            </select>

            <button class="btn btn-outline-secondary ms-auto">
                Download Semua
            </button>
        </div>

        <!-- TABLE -->
        <div class="table-wrapper">
            <table class="table">
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

                    <tr>
                        <td>
                            <div class="file-name">Valve Assembly Drawing</div>
                            <div class="file-meta">PDF • 2.4 MB</div>
                        </td>
                        <td>DWG-VAL-001</td>
                        <td>Rev. 1.3</td>
                        <td><span class="badge bg-success badge-status">Released</span></td>
                        <td>20 Jan 2026</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-outline-primary btn-download">Download</a>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="file-name">Body Section Drawing</div>
                            <div class="file-meta">PDF • 1.8 MB</div>
                        </td>
                        <td>DWG-VAL-002</td>
                        <td>Rev. 1.1</td>
                        <td><span class="badge bg-primary badge-status">Approved</span></td>
                        <td>18 Jan 2026</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-outline-primary btn-download">Download</a>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="file-name">Bonnet Detail Drawing</div>
                            <div class="file-meta">PDF • 950 KB</div>
                        </td>
                        <td>DWG-VAL-003</td>
                        <td>Rev. 0.9</td>
                        <td><span class="badge bg-secondary badge-status">Draft</span></td>
                        <td>15 Jan 2026</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-outline-primary btn-download">Download</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>
