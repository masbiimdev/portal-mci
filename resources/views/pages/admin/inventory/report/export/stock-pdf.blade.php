<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        th {
            background-color: #dedede;
            font-weight: bold;
        }

        .title {
            text-align: center;
            font-weight: bold;
        }

        .header-table td {
            border: 1px solid #000 !important;
            /* ✅ BORDER HEADER */
            padding: 4px;
        }

        .header-table {
            margin-bottom: 10px;
            border: 1px solid #000 !important;
            /* ✅ BORDER LUAR */
            border-collapse: collapse;
        }

        .right-info {
            font-size: 8.5px;
            text-align: left;
            padding-left: 8px;
        }

        .row-warning {
            background-color: #ffe6e6;
        }
    </style>

</head>

<body>

    <!-- HEADER -->
    <table class="header-table">
        <tbody>
            <tr>
                <td width="15%">
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/metinca-logo.jpeg'))) }}"
                        alt="Logo">
                </td>
                <td class="title" width="60%">
                    PT. METINCA PRIMA INDUSTRIAL WORKS - VALVE DIVISION<br>
                    KONTROL BARANG (KB)<br>
                    PERIODE
                    {{ strtoupper(['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$bulan] . ' ' . $tahun) }}
                </td>
                <td width="25%" class="right-info">
                    Document : F/WHS/KB/005<br>
                    Revision No : 2<br>
                    Date issue : 07/10/24
                </td>
            </tr>
        </tbody>
    </table>
    <br>

    @if ($materials->count() == 0)
        <p style="text-align:center;margin-top:20px;">Tidak ada data ditemukan.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Heat/Lot No</th>
                    <th>No Drawing</th>
                    <th>Valve</th>
                    <th>Spare Part</th>
                    <th>Dimensi</th>
                    <th>Stock Awal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Stock Akhir</th>
                    <th>Stock Opname</th>
                    <th>Selisih</th>
                    <th>Warning</th>
                    <th>Stock Minimum</th>
                    <th>Balance</th>
                    <th>Posisi Barang</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($materials as $index => $row)
                    @php
                        $material = $row['material'];
                        $underMin = ($row['stock_akhir'] ?? 0) < ($material->stock_minimum ?? 0);

                        // === Format Valve Name ===
                        $codes = $material->valves->pluck('valve_name');

                        if ($codes->isNotEmpty()) {
                            // 1️⃣ Group berdasarkan prefix sebelum titik terakhir (misal: "GL.2")
                            $grouped = $codes->groupBy(function ($code) {
                                return substr($code, 0, strrpos($code, '.'));
                            });

                            // 2️⃣ Format tiap grup: ambil semua suffix (angka terakhir) dan gabungkan
                            $formattedGroups = $grouped->map(function ($items, $prefix) {
                                $suffixes = $items->map(function ($c) {
                                    return substr($c, strrpos($c, '.') + 1);
                                });
                                return $prefix . '.' . $suffixes->join(',');
                            });

                            // 3️⃣ Gabungkan semua grup menjadi satu string (pisah dengan spasi)
                            $valveFormatted = $formattedGroups->join(' ');
                        } else {
                            $valveFormatted = '-';
                        }
                    @endphp

                    <tr class="{{ $underMin ? 'row-warning' : '' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $material->heat_lot_no ?? '-' }}</td>
                        <td>{{ $material->no_drawing ?? '-' }}</td>

                        <!-- ✅ Gunakan variable yang sudah diformat -->
                        <td>{{ $valveFormatted }}</td>

                        <td>{{ $material->sparePart->spare_part_name ?? '-' }}</td>
                        <td>{{ $material->dimensi ?? '-' }}</td>
                        <td>{{ $material->stock_awal ?? 0 }}</td>
                        <td>{{ $row['qty_in'] ?? 0 }}</td>
                        <td>{{ $row['qty_out'] ?? 0 }}</td>
                        <td>{{ $row['stock_akhir'] ?? 0 }}</td>
                        <td>{{ $row['opname'] ?? '-' }}</td>
                        <td>{{ $row['selisih'] ?? '-' }}</td>
                        <td>
                            @if ($row['warning'])
                                {{ $row['warning'] }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $material->stock_minimum ?? 0 }}</td>
                        <td>{{ $row['balance'] ?? 0 }}</td>
                        <td>{{ $material->rack->rack_name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>

</html>
