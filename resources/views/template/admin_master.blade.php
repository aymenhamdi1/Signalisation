<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-layout-mode="detached"
      data-topbar-color="dark"
      data-menu-color="dark"
      data-sidenav-color="dark"
      data-theme="dark"
      data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Application DBR - Direction des Barrières Routières">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0b0f19">

    <title>@yield('title', __('DBR')) | DBR</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Backend/assets/images/favicon.ico') }}?v={{ config('app.version', '1.0.0') }}">

    <!-- Preconnect pour performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Icones locales -->
    <link href="{{ asset('Backend/assets/css/icons.min.css') }}?v={{ config('app.version', '1.0.0') }}" rel="stylesheet">

    <!-- Bibliothèques CSS -->
    <link href="{{ asset('Backend/assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">

    <!-- DataTables -->
    <link href="{{ asset('Backend/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Backend/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Backend/assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Backend/assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Backend/assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Backend/assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet">

    <!-- Quill Editor -->
    <link href="{{ asset('Backend/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">

    <!-- ✅ CSS Framework principal -->
    <link href="{{ asset('Backend/assets/css/app-modern.min.css') }}?v={{ config('app.version', '1.0.0') }}" rel="stylesheet" id="app-style">
    <link href="{{ asset('Backend/assets/css/toastr.min.css') }}" rel="stylesheet">

    <!-- ✅ STYLES PERSONNALISÉS DBR (chargés en DERNIER pour override) -->
    <link href="{{ asset('Backend/assets/css/dbr-theme.css') }}?v={{ config('app.version', '1.0.0') }}" rel="stylesheet">

    <!-- Configuration globale JS (avant tout) -->
    <script src="{{ asset('Backend/assets/js/DBR-config.js') }}"></script>

    <!-- ✅ Stack pour CSS additionnel par vue -->
    @stack('styles')
</head>

<body class="loading"
      data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false,"leftSidebarCondensed":false,"leftSidebarScrollable":false,"hasTopbar":true}'>

    <!-- Loader de page (optionnel) -->
    <div id="preloader" class="dbr-preloader">
        <div class="dbr-spinner"></div>
    </div>

    <!-- Wrapper principal -->
    <div class="wrapper">

        <!-- Sidebar -->
        @include('template.body.sidebar')

        <!-- Topbar / Header -->
        @include('template.body.header')

        <!-- Contenu principal -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid pt-3">
                    <!-- Fil d'Ariane -->
                    @hasSection('breadcrumb')
                        <div class="row mb-2">
                            <div class="col-12">
                                @yield('breadcrumb')
                            </div>
                        </div>
                    @endif

                    <!-- Injection dynamique des vues Blade -->
                    @yield('Content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            © {{ date('Y') }} <strong>DBR</strong> — Direction des Barrières Routières
                        </div>
                        <div class="col-md-6 text-end">
                            Version {{ config('app.version', '1.0.0') }}
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>

    <!-- ============================================
         JAVASCRIPT LIBRARIES
         ============================================ -->

    <!-- jQuery (OBLIGATOIRE EN PREMIER) -->
    <script src="{{ asset('Backend/assets/js/vendor.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('Backend/assets/vendor/select2/js/select2.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('Backend/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- PDF/Excel Export -->
    <script src="{{ asset('Backend/assets/js/jszip.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/pdfmake.min.js') }}"></script>

    <!-- Date Range Picker -->
    <script src="{{ asset('Backend/assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Charts -->
    <script src="{{ asset('Backend/assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector Maps -->
    <script src="{{ asset('Backend/assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- Google Maps -->
    <script src="{{ asset('Backend/assets/vendor/gmaps/gmaps.min.js') }}"></script>

    <!-- jQuery Mask -->
    <script src="{{ asset('Backend/assets/vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('Backend/assets/js/sweetalert2.all.js') }}"></script>

    <!-- ✅ Custom App JS -->
    <script src="{{ asset('Backend/assets/js/app.min.js') }}?v={{ config('app.version', '1.0.0') }}"></script>

    <!-- Demo Scripts -->
    <script src="{{ asset('Backend/assets/js/pages/demo.datatable-init.js') }}"></script>

    <!-- Language Scripts -->
    @include('template.scripts.lang')

    <!-- SweetAlert2 Templates -->
    @include('template.scripts.Sweetalert2')

    <!-- ✅ SCRIPT D'INITIALISATION DBR -->
    <script>
        (function() {
            'use strict';

            // Initialisation immédiate du thème (avant DOMContentLoaded)
            const savedTheme = localStorage.getItem('dbr-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.documentElement.setAttribute('data-bs-theme', savedTheme);

            document.addEventListener('DOMContentLoaded', function() {
                // Force le thème sombre sur le body
                document.body.style.backgroundColor = '#0b0f19';
                document.body.style.color = '#f3f4f6';

                if (savedTheme === 'dark') {
                    document.body.classList.add('dark-mode');
                }

                // Nettoyer les classes conflictuelles du framework
                document.querySelectorAll('.bg-white, .bg-light').forEach(el => {
                    if (!el.closest('.no-dbr-theme')) {
                        el.classList.remove('bg-white', 'bg-light');
                    }
                });

                // Masquer le preloader
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.opacity = '0';
                    setTimeout(() => preloader.remove(), 300);
                }

                // Log de version pour debug
                console.log('%c[DBR] Initialized v{{ config("app.version", "1.0.0") }} — Theme: ' + savedTheme.toUpperCase(),
                            'color: #f59e0b; font-weight: bold;');
            });
        })();
    </script>

    <!-- ✅ Stack pour JS additionnel par vue -->
    @stack('scripts')

</body>
</html>
