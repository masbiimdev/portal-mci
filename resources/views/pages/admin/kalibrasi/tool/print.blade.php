<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cetak Label Alat</title>

    <style>
        * {
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        .page {
            padding: 4px;
        }

        .title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        table.outer {
            width: 100%;
            border-collapse: collapse;
        }

        td.card {
            width: 30%;
            border: 1px solid #333;
            vertical-align: top;
            height: 20px; /* tinggi card */
            page-break-inside: avoid;
            padding: 0; /* hapus padding agar QR/text mepet */
        }

        table.inner {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        td.qr {
            width: 30%;
            text-align: center;
            padding: 0;
            margin: 0;
        }

        td.details {
            width: 52%;
            padding: 0 0px 0 0px; /* minimal padding kiri-kanan */
        }

        .name {
            font-weight: bold;
            font-size: 7.5px;
            margin: 0;
            line-height: 1.2;
        }

        .text {
            font-size: 6.5px;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        .qr img {
            display: block;
            margin: 0 auto;
            width: 48px;
            height: 48px;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="title">Label Alat – QC Calibration</div>
        <br>

        <table class="outer">
            <tr>
                @foreach ($tools as $index => $tool)
                    <td class="card">
                        <table class="inner">
                            <tr>
                                {{-- QR --}}
                                <td class="qr">
                                    @if ($tool->qr_code_path)
                                        <img src="{{ public_path('storage/app/public/uploads/' . $tool->qr_code_path) }}"
                                            width="48" height="48" alt="QR">
                                    @else
                                        <div class="text">QR Tidak Ada</div>
                                    @endif
                                </td>

                                {{-- DETAIL --}}
                                <td class="details">
                                    <div class="name">{{ $tool->nama_alat }}</div>
                                    <div class="text">Merk: {{ $tool->merek }}</div>
                                    <div class="text">Seri: {{ $tool->no_seri }}</div>
                                    <div class="text">Kap: {{ $tool->kapasitas }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>

                    {{-- Baris baru setiap 3 card --}}
                    @if (($index + 1) % 3 == 0)
            </tr>
            <tr>
                    @endif
                @endforeach

                {{-- Tutup tr terakhir jika tidak kelipatan 3 --}}
                @if (count($tools) % 3 != 0)
            </tr>
                @endif
        </table>
    </div>
</body>

</html>
