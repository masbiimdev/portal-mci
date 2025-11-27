<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Document Control - File Manager</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        display: flex;
        height: 100vh;
        overflow: hidden;
    }

    /* SIDEBAR */
    .sidebar {
        width: 280px;
        background: #1d2b36;
        color: #fff;
        padding: 20px;
        overflow-y: auto;
    }

    .sidebar h3 {
        margin-bottom: 15px;
        font-size: 18px;
        color: #fff;
    }

    .folder {
        cursor: pointer;
        padding: 10px 10px;
        border-radius: 6px;
        margin-bottom: 5px;
        transition: 0.2s;
    }

    .folder:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .folder.active {
        background: rgba(255, 255, 255, 0.2);
    }

    .folder span {
        margin-left: 8px;
    }

    /* MAIN AREA */
    .main {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }

    .breadcrumb {
        font-size: 14px;
        margin-bottom: 20px;
        color: #555;
    }

    /* FILE CARDS */
    .file-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .file-card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: 0.2s;
        border: 1px solid #ddd;
    }

    .file-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
    }

    .file-icon {
        font-size: 40px;
        margin-bottom: 10px;
        color: #3b82f6;
    }

    .file-name {
        font-size: 14px;
        font-weight: bold;
        color: #333;
    }

</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3>📁 Document Control</h3>

    <div class="folder" onclick="loadFolder('Quality Manual Metinca Valve', files_quality)">
        📘 <span>Quality Manual Metinca Valve</span>
    </div>

    <div class="folder" onclick="loadFolder('Procedure', files_procedure)">
        📗 <span>Procedure</span>
    </div>

    <div class="folder" onclick="loadFolder('Document Pendukung & SOP', files_sop)">
        📙 <span>Document Pendukung & SOP</span>
    </div>

    <div class="folder" onclick="loadFolder('Formulir', files_formulir)">
        📒 <span>Formulir</span>
    </div>
</div>

<!-- MAIN AREA -->
<div class="main">
    <div class="breadcrumb" id="breadcrumb">Home / Document Control</div>

    <div class="file-grid" id="fileGrid">
        <p style="opacity: .6;">Pilih folder di sebelah kiri untuk melihat isi dokumennya.</p>
    </div>
</div>

<script>
    // Dummy Files
    const files_quality = [
        "QM-001 Quality Policy.pdf",
        "QM-002 Scope.pdf",
        "QM-003 Organizational Structure.pdf"
    ];

    const files_procedure = [
        "PROC-01 Purchasing Procedure.pdf",
        "PROC-02 Calibration Procedure.pdf",
        "PROC-03 Inspection Procedure.pdf"
    ];

    const files_sop = [
        "SOP-VALVE-01 Cold Working.pdf",
        "SOP-VALVE-02 Packaging.pdf",
        "WI-QA-01 Welding.pdf"
    ];

    const files_formulir = [
        "FRM-001 Checksheet.pdf",
        "FRM-002 Inspection Report.docx",
        "FRM-003 NCR Form.pdf"
    ];

    function loadFolder(name, files) {
        document.getElementById("breadcrumb").innerText = "Home / Document Control / " + name;

        let html = "";
        files.forEach(f => {
            html += `
                <div class="file-card" onclick="alert('Preview file: ${f}')">
                    <div class="file-icon">📄</div>
                    <div class="file-name">${f}</div>
                </div>
            `;
        });

        document.getElementById("fileGrid").innerHTML = html;

        // highlight sidebar active
        document.querySelectorAll(".folder").forEach(el => el.classList.remove("active"));
        event.target.closest(".folder").classList.add("active");
    }
</script>

</body>
</html>
