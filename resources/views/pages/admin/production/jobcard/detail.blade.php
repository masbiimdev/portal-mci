<h2>History Jobcard {{ $job->jobcard_no }}</h2>
<table border="1" cellpadding="5">
  <tr>
    <th>User</th>
    <th>Role</th>
    <th>Process</th>
    <th>Time</th>
  </tr>
  @foreach($job->histories as $h)
  <tr>
    <td>{{ $h->user->name ?? 'Unknown' }}</td>
    <td>{{ $h->role }}</td>
    <td>{{ $h->process }}</td>
    <td>{{ $h->scanned_at }}</td>
  </tr>
  @endforeach
</table>
