<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jobcard | {{ $jobcard->jobcard_no }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1d4ed8;
            --light-bg: #f8fafc;
            --text-dark: #1e293b;
            --card-bg: #e0f2fe;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            margin: 0;
            padding: 0;
        }

        h3 {
            font-weight: 700;
            text-align: center;
            margin: 30px 0 25px;
            color: var(--text-dark);
        }

        .card {
            border: none;
            border-radius: 12px;
            background: linear-gradient(180deg, #e0f2fe 0%, #ffffff 100%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .card-header {
            background: #bfdbfe;
            color: #1e3a8a;
            font-weight: 600;
            font-size: 16px;
            padding: 14px 20px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            border-bottom: 1px solid #cbd5e1;
        }

        table th {
            background-color: #f9fafb;
            color: #334155;
            width: 180px;
        }

        .table td,
        .table th {
            vertical-align: middle;
            font-size: 14px;
            padding: 10px 12px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f1f5f9;
        }

        footer {
            text-align: center;
            color: #64748b;
            font-size: 13px;
            margin-top: 40px;
            padding-bottom: 20px;
        }

        /* Responsive Table */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table th {
                text-align: center;
                white-space: nowrap;
                width: 130px;
            }

            table td {
                white-space: nowrap;
            }

            .btn-back {
                width: 100%;
                text-align: center;
            }
        }

        .btn-back {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>
    <div class="container-lg mt-4 mb-5">
        <h3>Detail Jobcard</h3>

        <!-- Informasi Jobcard -->
        <div class="card">
            <div class="card-header">Informasi Jobcard</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <table class="table table-bordered table-sm mb-0">
                            <tr>
                                <th>No. Jobcard</th>
                                <td>{{ $jobcard->jobcard_no }}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>{{ $jobcard->customer }}</td>
                            </tr>
                            <tr>
                                <th>WS No</th>
                                <td>{{ $jobcard->ws_no }}</td>
                            </tr>
                            <tr>
                                <th>Drawing No</th>
                                <td>{{ $jobcard->drawing_no }}</td>
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
                            @endif
                        </table>
                    </div>

                    <div class="col-12 col-md-6">
                        <table class="table table-bordered table-sm mb-0">
                            @if ($jobcard->type_jobcard === 'Jobcard Assembling')
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
                                <th>Size/Class</th>
                                <td>{{ $jobcard->size_class ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Date Line</th>
                                <td>{{ $jobcard->date_line ? $jobcard->date_line->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td>{{ $jobcard->remarks ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Proses -->
        <div class="card">
            <div class="card-header">Riwayat Proses</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle mb-3">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Operator</th>
                                <th>NIK</th>
                                <th>Departemen</th>
                                <th>Process</th>
                                <th>Action</th>
                                <th>Waktu Scan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobcard->histories ?? [] as $index => $history)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $history->user->name ?? '-' }}</td>
                                    <td>{{ $history->user->nik ?? '-' }}</td>
                                    <td>{{ $history->user->departemen ?? '-' }}</td>
                                    <td>{{ $history->process_name }}</td>
                                    <td>{{ $history->action }}</td>
                                    <td>{{ \Carbon\Carbon::parse($history->scanned_at)->translatedFormat('d M Y, H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">Belum ada data proses.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Back -->
                <div class="text-end mt-4">
                    <a href="{{ route('home') }}" class="btn-back">
                        ← Kembali ke Home
                    </a>
                </div>
            </div>
        </div>

        <footer>
            © {{ date('Y') }} PT. MCI — Portal Produksi Internal
        </footer>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
