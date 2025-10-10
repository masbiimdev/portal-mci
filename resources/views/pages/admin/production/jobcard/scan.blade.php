@extends('layouts.scan')
@section('title', 'Scan Jobcard')

@section('content')
    <div class="scan-card">

        <table style="width:100%; border-collapse: collapse; margin-bottom: 10px;">
            <h5>{{ $jobcard->type_jobcard }}</h5>
            <tr>
                <!-- Kiri: Jobcard Info -->
                <td style="width:50%; vertical-align:top; padding-right:10px; border:none;">
                    <p><strong>WS No: <br> </strong> {{ $jobcard->ws_no }}</p>
                    <p><strong>Type Valve: <br> </strong> {{ $jobcard->type_valve }}</p>
                    <p><strong>Size/Class: <br> </strong> {{ $jobcard->size_class }}</p>
                </td>

                <!-- Kanan: Operator Info -->
                <td style="width:50%; vertical-align:top; padding-left:10px; border:none;">
                    <p><strong>PIC: <br> </strong> {{ auth()->user()->name }}</p>
                    <p><strong>NIK: <br> </strong> {{ auth()->user()->nik }}</p>
                    <p><strong>Departemen: <br> </strong> {{ auth()->user()->departemen ?? '-' }}</p>
                </td>
            </tr>
        </table>

        <hr>

        <form action="{{ route('jobcards.scan', $jobcard->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Proses</label>
                <select name="process_name" class="form-select form-select-lg" required>
                    <option value="" disabled selected>Pilih proses</option>

                    @if ($jobcard->type_jobcard === 'Jobcard Machining')
                        <option value="INC QC">INC QC</option>
                        <option value="BT">BT</option>
                        <option value="CNC MILLING">CNC MILLING</option>
                        <option value="MILLING/RADIAL">MILLING/RADIAL</option>
                        <option value="MPI">MPI</option>
                        <option value="QC">QC</option>
                    @elseif($jobcard->type_jobcard === 'Jobcard Assembling')
                        <option value="Assy">Assy</option>
                        <option value="QC-Hyd">QC-Hyd</option>
                        <option value="Painting">Painting</option>
                        <option value="QC-Dim">QC-Dim</option>
                    @endif
                </select>
            </div>


            <div class="mb-3">
                <label class="form-label">Detail Proses</label>
                <input type="text" name="remarks" class="form-control form-control-lg" placeholder="Opsional">
            </div>

            <button type="submit" class="btn btn-scan">{{ $action }}</button>
        </form>
    </div>
@endsection
