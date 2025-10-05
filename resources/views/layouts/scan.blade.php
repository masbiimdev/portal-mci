<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Scan Jobcard')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe, #93c5fd);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .scan-header {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            color: #fff;
            padding: 1.8rem;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .scan-card {
            width: 100%;
            max-width: 650px;
            margin: 3rem auto;
            background: #ffffff;
            border-radius: 18px;
            padding: 2.5rem;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
            animation: fadeIn 0.6s ease;
        }

        .scan-card h5 {
            font-weight: 700;
            margin-bottom: 1rem;
            color: #3b82f6;
        }

        .form-label {
            font-weight: 600;
            color: #1e3a8a;
        }

        .btn-scan {
            width: 100%;
            padding: 0.85rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 14px;
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-scan:hover {
            background: linear-gradient(90deg, #2563eb, #3b82f6);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.3);
        }

        footer {
            margin-top: auto;
            padding: 1rem;
            text-align: center;
            color: #374151;
            font-size: 0.9rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <!-- Content -->
    <main>
        @yield('content')
    </main>


    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
    @stack('scripts')
</body>

</html>
