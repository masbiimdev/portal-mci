<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scan Berhasil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .success-card {
      background: #fff;
      border: 1px solid #dee2e6;
      border-radius: 12px;
      padding: 35px;
      text-align: center;
      max-width: 380px;
      width: 100%;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .checkmark {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: inline-block;
      stroke-width: 2;
      stroke: #28a745;
      stroke-miterlimit: 10;
      box-shadow: inset 0px 0px 0px #28a745;
      animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
      margin-bottom: 15px;
    }

    .checkmark__circle {
      stroke-dasharray: 166;
      stroke-dashoffset: 166;
      stroke-width: 2;
      stroke-miterlimit: 10;
      stroke: #28a745;
      fill: none;
      animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark__check {
      transform-origin: 50% 50%;
      stroke-dasharray: 48;
      stroke-dashoffset: 48;
      animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
      100% { stroke-dashoffset: 0; }
    }
    @keyframes scale {
      0%, 100% { transform: none; }
      50% { transform: scale3d(1.1, 1.1, 1); }
    }
    @keyframes fill {
      100% { box-shadow: inset 0px 0px 0px 30px #28a745; }
    }

    h5 {
      font-weight: 600;
      color: #212529;
    }

    p {
      color: #555;
      font-size: 15px;
      margin-top: 10px;
    }

    a.btn {
      margin-top: 20px;
      font-size: 14px;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <div class="success-card">
    <!-- Animasi centang SVG -->
    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
      <path class="checkmark__check" fill="none" stroke="#fff" stroke-width="4" d="M14 27l7 7 16-16"/>
    </svg>

    <h5>{{ $action }} Berhasil</h5>
    <p>Jobcard <strong>{{ $jobcard->jobcard_no }}</strong><br>
       (Customer: {{ $jobcard->customer }})</p>

    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
  </div>
</body>
</html>
