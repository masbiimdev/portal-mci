<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $jobcard->type_jobcard ?? '-' }} | {{ $jobcard->jobcard_id ?? '-' }}</title>
    <link rel="icon" type="image/x-icon"
        href="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/metinca-logo.jpeg'))) }}" />

    <style>
        @media print {
            body {
                font-size: 8px;
            }
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            margin: 5px 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 2px 3px;
            vertical-align: top;
            font-size: 8px;
        }

        .no-border td,
        .no-border th {
            border: none;
        }

        .header {
            font-size: 10px;
        }

        .title {
            font-weight: bold;
            text-align: center;
            font-size: 13px;
            text-decoration: underline;
            margin: 5px 0;
        }

        .process-table th {
            background: #f4f4f4;
            text-align: center;
        }

        .footer td {
            height: 35px;
            text-align: center;
        }

        .meta {
            font-size: 9px;
            margin-top: 10px;
        }

        .operator-cell div {
            text-align: center;
        }

        .operator-cell div+div {
            margin-top: 8px;
        }
    </style>
</head>

<body>

    <!-- Header Perusahaan -->
    {{-- <table class="no-border" style="margin-bottom:10px;">
        <tr>
            <td style="width:70%" class="header">
                <strong>PT. METINCA PRIMA INDUSTRIAL WORKS</strong><br>
                Plant: Jl. Setia Darma No 35 RT 04 RW 03 Ds. Setia Darma<br>
                Kec. Tambun Selatan, Bekasi – Jawa Barat 17510<br>
                Phone: (+62-21) 88368880 Fax: (+62-21) 88368881
            </td>
            <td style="width:30%; text-align:right;">
                <img src="data:image/png;base64,{{ $qr }}" alt="QR" width="120">
            </td>
        </tr>
    </table> --}}

    <!-- Main layout -->
    <table style="width:100%;">
        <tr>
            <!-- Kiri: Jobcard info -->
            <td style="width:25%; border:none;">
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <th colspan="2"
                            style="text-align:center; font-size:7px; font-weight:bold; padding-bottom:5px;">
                            <div style="color: rgb(6, 131, 247)">
                                <strong>PT. METINCA PRIMA INDUSTRIAL WORKS</strong><br>
                                VALVE DIVISION <br </div>
                                Plant: Jl. Setia Darma No 35 RT 04 RW 03 Ds. Setia Darma<br>
                                Kec. Tambun Selatan, Bekasi – Jawa Barat 17510
                                Phone: (+62-21) 88368880 Fax: (+62-21) 88368881
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align:center; font-size:9px; font-weight:bold;">
                            {{ strtoupper($jobcard->type_jobcard) }}
                        </th>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center; vertical-align:top; padding:4px;">
                            <table style="width:100%; border:none; border-collapse:collapse; font-size:9px;">
                                <tr style="border:none;">
                                    <td style="width:25%; text-align:left; white-space:nowrap; border:none;">
                                        {{ $jobcard->category === 'Reused' ? '[x]' : '[ ]' }} Reused
                                    </td>
                                    <td style="width:25%; text-align:left; white-space:nowrap; border:none;">
                                        {{ $jobcard->category === 'New Manufacture' ? '[x]' : '[ ]' }} New Manufacture
                                    </td>
                                    <td style="width:25%; text-align:left; white-space:nowrap; border:none;">
                                        {{ $jobcard->category === 'Repair' ? '[x]' : '[ ]' }} Repair
                                    </td>
                                    <td style="width:25%; text-align:left; white-space:nowrap; border:none;">
                                        {{ $jobcard->category === 'Supplied' ? '[x]' : '[ ]' }} Supplied
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>Customer</th>
                        <td>{{ $jobcard->customer ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>WS No.</th>
                        <td>{{ $jobcard->ws_no ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>{{ $jobcard->type_valve ?? '-' }}</td>
                    </tr>

                    @if ($jobcard->type_jobcard === 'Jobcard Assembling')
                        <tr>
                            <th>Body</th>
                            <td>{{ $jobcard->body ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Bonnet</th>
                            <td>{{ $jobcard->bonnet ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Disc</th>
                            <td>{{ $jobcard->disc ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Qty Acc PO</th>
                            <td>{{ $jobcard->qty_acc_po ?? '-' }}</td>
                        </tr>
                    @elseif($jobcard->type_jobcard === 'Jobcard Machining')
                        <tr>
                            <th>Batch No</th>
                            <td>{{ $jobcard->batch_no ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Material</th>
                            <td>{{ $jobcard->material ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Qty</th>
                            <td>{{ $jobcard->qty ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Part Name</th>
                            <td>{{ $jobcard->part_name ?? '-' }}</td>
                        </tr>
                    @endif

                    <tr>
                        <th>Size / Class</th>
                        <td>{{ $jobcard->size_class ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Drawing No.</th>
                        <td>{{ $jobcard->drawing_no ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Date Line</th>
                        <td>{{ $jobcard->date_line ? $jobcard->date_line->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. Job Order</th>
                        <td>{{ $jobcard->no_joborder ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Remarks</th>
                        <td>{{ $jobcard->remarks ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center; vertical-align:middle;">
                            <img src="data:image/png;base64,{{ $qr }}" alt="QR" width="70"><br>
                            <span style="font-size:8px; font-style:italic;">
                                Scan 1× for Scan In |
                                Scan 2× for Scan Out
                            </span>
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Kanan: Process Table -->
            <td style="width:55%; border:none; vertical-align:top;">
                <table class="process-table" style="width:100%; border-collapse: collapse;">
                    <tr>
                        <th colspan="2" style="border-right: none;">
                            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/metinca-logo.jpeg'))) }}"
                                alt="Logo">
                        </th>
                        <th colspan="5" style="text-align:center; font-size:7px; font-weight:bold; padding-top:5px;">

                            <div style="color: rgb(6, 131, 247)">
                                <strong>PT. METINCA PRIMA INDUSTRIAL WORKS</strong><br>
                                VALVE DIVISION <br </div>
                                Plant: Jl. Setia Darma No 35 RT 04 RW 03 Ds. Setia Darma<br>
                                Kec. Tambun Selatan, Bekasi – Jawa Barat 17510
                                Phone: (+62-21) 88368880 Fax: (+62-21) 88368881
                        </th>
                        <th style="font-size:7px; text-align:center; vertical-align:middle; padding-top:5px;">
                            No Dokumen: F/PRC/JC/003 <br>
                            Revisi: 2 <br>
                            Tanggal Disetujui: 01/10/2024
                        </th>

                    </tr>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:25%">MC Process</th>
                        <th style="width:15%">Date</th>
                        <th style="width:15%">Operator / NIK</th>
                        <th style="width:10%">Paraf</th>
                        <th style="width:20%">No. SPK</th>
                        <th style="width:20%">Ref. Laporan</th>
                        <th style="width:20%">Keterangan</th>
                    </tr>
                    @if ($jobcard->type_jobcard === 'Jobcard Machining')
                        @php
                            $processes = ['INC QC', 'BT', 'BT', 'CNC MILLING', 'MILLING/RADIAL', 'MPI', 'QC'];
                        @endphp
                    @endif
                    @if ($jobcard->type_jobcard === 'Jobcard Assembling')
                        @php
                            $processes = [
                                ['name' => 'Assy', 'empty_after' => 1],
                                ['name' => 'QC-Hydrotest', 'empty_after' => 1],
                                ['name' => 'Painting', 'empty_after' => 2],
                                ['name' => 'QC-Dimensi', 'empty_after' => 2],
                            ];
                        @endphp
                    @endif
                    @foreach ($processes as $i => $process)
                        <tr style="height:30px;">
                            <td style="padding:10.4px;" align="center">{{ $i + 1 }}</td>
                            @if ($jobcard->type_jobcard === 'Jobcard Assembling')
                                <td style="padding:10.4px;">{{ $process['name'] }}</td>
                            @endif
                            @if ($jobcard->type_jobcard === 'Jobcard Machining')
                                <td style="padding:10.4px;">{{ $process }}</td>
                            @endif
                            <td style="padding:10.4px;"></td>
                            <td class="operator-cell" style="padding:10.4px;"></td>
                            <td style="padding:10.4px;"></td>
                            <td style="padding:10.4px;"></td>
                            <td style="padding:10.4px;"></td>
                            <td style="padding:10.4px;"></td>
                        </tr>
                        @if ($jobcard->type_jobcard === 'Jobcard Assembling')
                            @for ($j = 0; $j < $process['empty_after']; $j++)
                                <tr style="height:30px;">
                                    <td style="padding:7.3px;"></td>
                                    <td style="padding:7.3px;"></td>
                                    <td style="padding:7.3px;"></td>
                                    <td style="padding:7.3px;"></td>
                                    <td style="padding:7.3px;"></td>
                                    <td style="padding:7.3px;"></td>
                                    <td style="padding:7.3px;"></td>
                                    <td style="padding:7.3px;"></td>
                                </tr>
                            @endfor
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="2"
                            style="text-align:center; font-weight:bold; height:35px; vertical-align:middle;">
                            QC Passed
                        </td>
                        <td colspan="4" style="text-align:center; vertical-align:middle;">

                        </td>
                        <td colspan="2"
                            style="text-align:center; font-weight:bold; height:46px; vertical-align:bottom; padding-bottom:5px;">
                            Stempel
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
