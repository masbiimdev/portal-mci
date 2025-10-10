<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../admin/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/metinca-logo.jpeg'))) }}" />

    <!-- Fonts -->
    @include('includes.admin.style')
    @stack('css')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar d-flex flex-column min-vh-100">
      <div class="layout-container">
        <!-- Menu -->
        @include('includes.admin.sidebar')
        <!-- /Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          @include('includes.admin.navbar')
          <!-- /Navbar -->

          <!-- Content -->
          @yield('content')

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme mt-auto">
              <div class="container-xxl d-flex justify-content-between py-2">
                <div>© <script>document.write(new Date().getFullYear());</script>, made with ❤️ by MCI</div>
              </div>
            </footer>
          </div>
        </div>
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Core JS -->
   @include('includes.admin.script')
   @stack('js')
  </body>
</html>
