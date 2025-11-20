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

        .card {
            width: 28%;
            border: 1px solid #333;
            padding: 1px;
            /* super minimal */
            border-radius: 2px;
            display: inline-block;
            margin: 2px;
            /* minimal jarak antar card */
            height: 50px;
            page-break-inside: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 0;
            margin: 0;
        }

        .name {
            font-weight: bold;
            font-size: 8.5px;
            margin: 0;
            line-height: 1.5;
        }

        .text {
            font-size: 6.5px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .qr {
            text-align: center;
            padding: 0;
            margin: 0;
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

        @foreach ($tools as $tool)
            <div class="card">

                <table>
                    <tr>

                        {{-- QR KIRI --}}
                        <td style="width: 38%;" class="qr">
                            @if ($tool->qr_code_path)
                                <img src="{{ public_path('storage/app/public/uploads/' . $tool->qr_code_path) }}"
                                    width="25" height="25" alt="QR">
                            @else
                                <div class="text">QR Tidak Ada</div>
                            @endif
                        </td>

                        {{-- DETAIL KANAN --}}
                        <td style="width: 62%; padding-left: 6px;">
                            <div class="name">{{ $tool->nama_alat }}</div>
                            <div class="text">Merk: {{ $tool->merek }}</div>
                            <div class="text">Seri: {{ $tool->no_seri }}</div>
                            <div class="text">Kap: {{ $tool->kapasitas }}</div>
                        </td>

                    </tr>
                </table>

            </div>
        @endforeach

    </div>

</body>

</html>
