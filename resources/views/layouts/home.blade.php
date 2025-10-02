<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ERP - Home</title>
  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Heroicons -->
  <script src="https://unpkg.com/feather-icons"></script>
  @stack('css')
</head>
<body class="bg-gray-50">

    @include('includes.navbar')

    @yield('content')
  <script>
    feather.replace();

    // Dropdown notif
    const notifBtn = document.getElementById("notifBtn");
    const notifMenu = document.getElementById("notifMenu");
    notifBtn.addEventListener("click", () => {
      notifMenu.classList.toggle("hidden");
    });

    // Dropdown user
    const userBtn = document.getElementById("userBtn");
    const userMenu = document.getElementById("userMenu");
    userBtn.addEventListener("click", () => {
      userMenu.classList.toggle("hidden");
    });

    // Hamburger menu
    const hamburger = document.getElementById("hamburger");
    const mobileMenu = document.getElementById("mobileMenu");
    hamburger.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });
  </script>
  
@stack('js')
</body>
</html>
