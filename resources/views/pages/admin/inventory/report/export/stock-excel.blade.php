<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            vertical-align: middle;
        }

        .row-warning {
            background-color: #fff2e6 !important;
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 10px;
            }
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <td rowspan="3" colspan="2" width="8%">
                {{-- Logo jika sudah ada file --}}
                {{-- <img src="{{ asset('images/metinca-logo.jpeg') }}" width="45"> --}}
            </td>

            <td colspan="12" style="font-size:12px; font-weight:bold; text-align:center;">
                PT. METINCA PRIMA INDUSTRIAL WORKS - VALVE DIVISION
            </td>

            <td colspan="2" style="font-size:9px; text-align:left;">
                Document No.: F/WHS/KB/005
            </td>
        </tr>

        <tr>
            <td colspan="12" style="font-weight:bold; text-align:center;">
                KONTROL BARANG (KB)
            </td>
            <td colspan="2" style="font-size:9px; text-align:left;">
                Revision No.: 2
            </td>
        </tr>

        <tr>
            <td colspan="12" style="font-weight:bold; text-align:center;">
                PERIODE
                {{ strtoupper(
                    is_numeric($bulan)
                        ? [
                            '',
                            'Januari',
                            'Februari',
                            'Maret',
                            'April',
                            'Mei',
                            'Juni',
                            'Juli',
                            'Agustus',
                            'September',
                            'Oktober',
                            'November',
                            'Desember',
                        ][$bulan]
                        : $bulan,
                ) .
                    ' ' .
                    $tahun }}
            </td>
            <td colspan="2" style="font-size:9px; text-align:left;">
                Date Issued : 07/10/24
            </td>
        </tr>
        <tr>
            <td colspan="16"></td>
        </tr>
        <!-- Header Tabel -->
        <tr style="background:#dedede; font-weight:bold;">
            <td>No</td>
            <td>Heat/Lot/Batch No.</td>
            <td>No Drawing</td>
            <td>Valve</td>
            <td>Spare Part</td>
            <td>Dimensi</td>
            <td>Stock Awal</td>
            <td>Masuk</td>
            <td>Keluar</td>
            <td>Stock Akhir</td>
            <td>Stock Opname</td>
            <td>Selisih</td>
            <td>Warning</td>
            <td>Stock Minimum</td>
            <td>Balance</td>
            <td>Posisi Barang</td>
        </tr>

        {{-- Data Tabel --}}
        @forelse($materials as $index => $row)
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
                <td>{{ $row['warning'] ?: '-' }}</td>
                <td>{{ $material->stock_minimum ?? 0 }}</td>
                <td>{{ $row['balance'] ?? 0 }}</td>
                <td>{{ $material->rack->rack_name ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="16">Tidak ada data</td>
            </tr>
        @endforelse

    </table>

</body>

</html>
