<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Folder — Document Transmittal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
:root{
    --primary:#0d1b2a;
    --accent:#0d6efd;
    --bg:#f4f6f9;
    --card:#ffffff;
    --muted:#6b7280;
    --border:#e5e7eb;
}

body{
    background:var(--bg);
    font-family:'Segoe UI',system-ui,sans-serif;
    color:#1f2937;
}

.container-main{
    max-width:1200px;
    margin:auto;
    padding:32px 20px;
}

/* HEADER */
.page-header{
    background:linear-gradient(135deg,#0d1b2a,#1b263b);
    color:#fff;
    padding:26px 30px;
    border-radius:18px;
    margin-bottom:28px;
}

.page-header h3{
    font-weight:600;
    margin-bottom:4px;
}

.page-header small{opacity:.85}

/* CARD */
.card{
    border:none;
    border-radius:18px;
    box-shadow:0 12px 32px rgba(0,0,0,.08);
}

/* GRID */
.folder-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
    gap:22px;
}

/* FOLDER CARD (CLONE PROJECT CARD) */
.folder-card{
    background:var(--card);
    border:1px solid var(--border);
    border-radius:18px;
    padding:22px;
    display:flex;
    flex-direction:column;
    transition:.2s ease;
}

.folder-card:hover{
    transform:translateY(-6px);
    box-shadow:0 18px 40px rgba(13,110,253,.12);
    border-color:var(--accent);
}

/* HEADER */
.folder-header{
    display:flex;
    gap:14px;
    margin-bottom:14px;
}

.folder-icon{
    font-size:34px;
    color:var(--accent);
}

.folder-title{
    font-weight:700;
    font-size:18px;
}

.folder-code{
    font-size:12px;
    color:var(--muted);
}

/* STATS */
.folder-stats{
    display:flex;
    gap:10px;
    margin-bottom:14px;
}

.stat-pill{
    background:#f1f5f9;
    border-radius:999px;
    padding:6px 14px;
    font-size:13px;
    font-weight:600;
    color:#334155;
}

/* LAST UPDATE */
.last-update{
    border-top:1px dashed var(--border);
    padding-top:12px;
    margin-bottom:16px;
}

.last-update-label{
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:.4px;
    color:var(--muted);
    margin-bottom:2px;
}

.last-update-time{
    font-size:13px;
    font-weight:600;
    color:#1f2937;
}

/* FOOTER */
.folder-footer{
    margin-top:auto;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.view-link{
    font-size:13px;
    font-weight:600;
    color:var(--accent);
    opacity:.7;
    transition:.15s;
}

.folder-card:hover .view-link{
    opacity:1;
}
</style>
</head>

<body>

<div class="container-main">

    <!-- HEADER -->
    <div class="page-header">
        <h3>Project: Valve Manufacturing</h3>
        <small>Folder dokumen resmi dalam project</small>
    </div>

    <!-- FOLDER LIST -->
    <div class="card">
        <div class="card-header bg-white">
            <strong>Project Folders</strong>
        </div>

        <div class="card-body">
            <div class="folder-grid">

                <!-- FOLDER -->
                <div class="folder-card">

                    <div class="folder-header">
                        <div class="folder-icon">
                            <i class="bi bi-folder2-open"></i>
                        </div>
                        <div>
                            <div class="folder-title">Drawing</div>
                            <div class="folder-code">FDR-DWG</div>
                        </div>
                    </div>

                    <div class="folder-stats">
                        <span class="stat-pill">12 Files</span>
                        <span class="stat-pill">Released</span>
                    </div>

                    <div class="last-update">
                        <div class="last-update-label">Last Update</div>
                        <div class="last-update-time">
                            20 January 2026 • 14:32 WIB
                        </div>
                    </div>

                    <div class="folder-footer">
                        <span class="text-muted small">Active</span>
                        <span class="view-link">Open Folder →</span>
                    </div>

                </div>

                <!-- FOLDER -->
                <div class="folder-card">

                    <div class="folder-header">
                        <div class="folder-icon">
                            <i class="bi bi-folder2-open"></i>
                        </div>
                        <div>
                            <div class="folder-title">Specification</div>
                            <div class="folder-code">FDR-SPEC</div>
                        </div>
                    </div>

                    <div class="folder-stats">
                        <span class="stat-pill">8 Files</span>
                        <span class="stat-pill">Approved</span>
                    </div>

                    <div class="last-update">
                        <div class="last-update-label">Last Update</div>
                        <div class="last-update-time">
                            18 January 2026 • 09:12 WIB
                        </div>
                    </div>

                    <div class="folder-footer">
                        <span class="text-muted small">Active</span>
                        <span class="view-link">Open Folder →</span>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

</body>
</html>
