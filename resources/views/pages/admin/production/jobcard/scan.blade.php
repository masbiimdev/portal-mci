@extends('layouts.admin')
@section('title', 'Scan Jobcard')

@section('content')
<div class="container">
    <h3>Scan Jobcard: {{ $jobcard->jobcard_no }}</h3>
    <p>Part: {{ $jobcard->part_name ?? '-' }}</p>
    <p>Customer: {{ $jobcard->customer ?? '-' }}</p>

    <form method="POST" action="{{ route('jobcards.scan', $jobcard->id) }}">
        @csrf
        <label>Status:</label>
        <select name="status" class="form-select" required>
            <option value="Started">Started</option>
            <option value="In Progress">In Progress</option>
            <option value="QC Check">QC Check</option>
            <option value="Finished">Finished</option>
        </select>
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
</div>
@endsection
