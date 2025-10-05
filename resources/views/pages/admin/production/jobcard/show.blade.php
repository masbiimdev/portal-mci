@extends('layouts.admin')
@section('title')
    Detail Jobcard | MCI
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Jobcards /</span> Detail
        </h4>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Jobcard</h5>
                <a href="{{ route('jobcards.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
            </div>
            <div class="card-body">
                {{-- Informasi Umum --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th>No. Jobcard</th>
                                <td>{{ $jobcard->jobcard_no }}</td>
                            </tr>
                            <tr>
                                <th>WS No</th>
                                <td>{{ $jobcard->ws_no }}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>{{ $jobcard->customer }}</td>
                            </tr>
                            <tr>
                                <th>Serial No</th>
                                <td>{{ $jobcard->serial_no }}</td>
                            </tr>
                            <tr>
                                <th>Drawing No</th>
                                <td>{{ $jobcard->drawing_no }}</td>
                            </tr>
                            <tr>
                                <th>Disc</th>
                                <td>{{ $jobcard->disc ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Body</th>
                                <td>{{ $jobcard->body ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Bonnet</th>
                                <td>{{ $jobcard->bonnet ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th>Size / Class</th>
                                <td>{{ $jobcard->size_class ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ $jobcard->type ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Qty acc PO</th>
                                <td>{{ $jobcard->qty_acc_po }}</td>
                            </tr>
                            <tr>
                                <th>Date Line</th>
                                <td>{{ $jobcard->date_line ? $jobcard->date_line->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $jobcard->category }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Oleh</th>
                                <td>{{ $jobcard->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Dibuat</th>
                                <td>{{ $jobcard->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- QR Code --}}
                <div class="text-center my-4">
                    <h6>Scan QR untuk tracking progress</h6>
                    <div>{!! QrCode::size(200)->generate(route('jobcards.scan', $jobcard->id)) !!}</div>
                </div>

                {{-- History Scan --}}
                <h5 class="mt-4">History Progress</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Operator</th>
                                <th>NIK</th>
                                <th>Departemen</th>
                                <th>Process</th>
                                <th>Action</th>
                                <th>Scan At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobcard->histories as $history)
                                <tr>
                                    <td>{{ $history->user->name ?? '-' }}</td>
                                    <td>{{ $history->user->nik ?? '-' }}</td>
                                    <td>{{ $history->user->departemen ?? '-' }}</td>
                                    <td>{{ $history->process_name }}</td>
                                    <td>{{ $history->action }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($history->scanned_at)->translatedFormat('l, d F Y, H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    </div>
@endsection
