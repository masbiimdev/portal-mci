<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Report Kontrol Barang (KB)</title>
    <style>
        /* Pengaturan Dasar Halaman */
        body {
            font-family: 'DejaVu Sans', Helvetica, Arial, sans-serif;
            font-size: 8.5px;
            /* Sedikit dikecilkan agar 16 kolom muat dengan rapi */
            color: #333333;
            margin: 0;
            padding: 0;
        }

        /* Tabel KOP Surat (Header) */
        .header-table {
            width: 100%;
            margin-bottom: 15px;
            border-bottom: 2px solid #003366;
            /* Garis bawah kop surat */
            padding-bottom: 10px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .title {
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            line-height: 1.4;
            color: #003366;
        }

        .right-info {
            font-size: 8px;
            text-align: right;
            line-height: 1.3;
            color: #555555;
        }

        /* Tabel Data Utama */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Agar header tabel berulang di setiap halaman baru (khusus PDF) */
        .data-table thead {
            display: table-header-group;
        }

        /* Mencegah baris terpotong di tengah halaman */
        .data-table tr {
            page-break-inside: avoid;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #b3b3b3;
            padding: 4px 3px;
        }

        /* Header Tabel Biru Dongker */
        .data-table th {
            background-color: #003366;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 8px;
            border-color: #002244;
        }

        /* Baris Selang-Seling (Zebra) untuk kemudahan membaca */
        .data-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Baris Warning (Stok Kurang) */
        .data-table tbody tr.row-warning td {
            background-color: #fff0e6;
            /* Soft Orange */
            color: #cc3300;
        }

        /* Utility Classes untuk Alignment */
        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>

    @php
        // FIX BULAN "01" → integer
        $bulanInt = (int) $bulan;

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    @endphp

    <table class="header-table">
        <tbody>
            <tr>
                <td width="20%" class="text-left">
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/metinca-logo.jpeg'))) }}"
                        alt="Logo" width="100">
                </td>
                <td width="60%" class="title">
                    PT. METINCA PRIMA INDUSTRIAL WORKS – VALVE DIVISION<br>
                    KONTROL BARANG (KB)<br>
                    PERIODE {{ strtoupper(($namaBulan[$bulanInt] ?? '-') . ' ' . $tahun) }}
                </td>
                <td width="20%" class="right-info">
                    <strong>Document :</strong> F/WHS/KB/005<br>
                    <strong>Revision No :</strong> 2<br>
                    <strong>Date issue :</strong> 07/10/24
                </td>
            </tr>
        </tbody>
    </table>

    @if ($materials->count() == 0)
        <p style="text-align:center; margin-top:30px; font-size:10px; color:#777;">
            <i>- Tidak ada data ditemukan untuk periode ini -</i>
        </p>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="8%">Heat / Lot No</th>
                    <th width="8%">No Drawing</th>
                    <th width="10%">Valve</th>
                    <th width="12%">Spare Part</th>
                    <th width="7%">Dimensi</th>
                    <th width="5%">Awal</th>
                    <th width="5%">Masuk</th>
                    <th width="5%">Keluar</th>
                    <th width="6%">Akhir</th>
                    <th width="6%">Opname</th>
                    <th width="5%">Selisih</th>
                    <th width="6%">Warning</th>
                    <th width="5%">Min.</th>
                    <th width="5%">Balance</th>
                    <th width="8%">Posisi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($materials as $index => $row)
                    @php
                        $material = $row['material'];
                        $underMin = ($row['stock_akhir'] ?? 0) < ($material->stock_minimum ?? 0);

                        // === FORMAT VALVE NAME ===
                        $codes = $material->valves->pluck('valve_name');

                        if ($codes->isNotEmpty()) {
                            $grouped = $codes->groupBy(function ($code) {
                                return str_contains($code, '.') ? substr($code, 0, strrpos($code, '.')) : $code;
                            });

                            $formattedGroups = $grouped->map(function ($items, $prefix) {
                                if (!str_contains($prefix, '.')) {
                                    return $items->join(', ');
                                }
                                $suffixes = $items->map(function ($c) {
                                    return substr($c, strrpos($c, '.') + 1);
                                });
                                return $prefix . '.' . $suffixes->join(',');
                            });

                            $valveFormatted = $formattedGroups->join(' ');
                        } else {
                            $valveFormatted = '-';
                        }
                    @endphp

                    <tr class="{{ $underMin ? 'row-warning' : '' }}">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $material->heat_lot_no ?? '-' }}</td>
                        <td class="text-left">{{ $material->no_drawing ?? '-' }}</td>
                        <td class="text-left">{{ $valveFormatted }}</td>
                        <td class="text-left">{{ $material->sparePart->spare_part_name ?? '-' }}</td>
                        <td class="text-left">{{ $material->dimensi ?? '-' }}</td>

                        <td class="text-right">{{ $material->stock_awal ?? 0 }}</td>
                        <td class="text-right">{{ $row['qty_in'] ?? 0 }}</td>
                        <td class="text-right">{{ $row['qty_out'] ?? 0 }}</td>
                        <td class="text-right fw-bold">{{ $row['stock_akhir'] ?? 0 }}</td>
                        <td class="text-right">{{ $row['opname'] ?? '-' }}</td>
                        <td class="text-right">{{ $row['selisih'] ?? '-' }}</td>

                        <td class="text-center">{{ $row['warning'] ?? '-' }}</td>
                        <td class="text-right">{{ $material->stock_minimum ?? 0 }}</td>
                        <td class="text-right">{{ $row['balance'] ?? 0 }}</td>
                        <td class="text-center">{{ $material->rack->rack_name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>

</html>
