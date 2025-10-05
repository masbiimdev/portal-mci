<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eaf6ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-card {
            max-width: 600px;
            margin: 80px auto;
            background: white;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            box-shadow: 0px 8px 20px rgba(0,0,0,0.1);
        }
        .success-icon {
            font-size: 70px;
            color: #0d6efd;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-icon">✅</div>
        <h2>Scan {{ $action }} Berhasil!</h2>
        <p class="mt-3">Jobcard <strong>{{ $jobcard->jobcard_no }}</strong> (Customer: {{ $jobcard->customer }}) berhasil di-<strong>{{ $action }}</strong>.</p>

        {{-- <a href="{{ route('jobcards.scan.form', $jobcard->id) }}" class="btn btn-primary mt-4">🔄 Scan Lagi</a> --}}
        <a href="{{ route('home') }}" class="btn btn-outline-secondary mt-2">🏠 Kembali ke Jobcard</a>
    </div>
</body>
</html>
