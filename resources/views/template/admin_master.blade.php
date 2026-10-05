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

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

    <!-- ✅ STYLES PERSONNALISÉS DBR -->
    <style>
        /* ============================================
           VARIABLES GLOBALES DBR
           ============================================ */
        :root {
            --bg-dark-body: #0b0f19;
            --bg-dark-topbar: rgba(11, 15, 25, 0.9);
            --bg-glass-card: rgba(18, 26, 43, 0.85);
            --bg-glass-hover: rgba(26, 38, 64, 0.95);
            --border-glass: rgba(255, 255, 255, 0.08);
            --border-glass-hover: rgba(255, 255, 255, 0.2);

            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --text-dim: #b8c1d1;

            --accent-amber: #f59e0b;
            --accent-amber-glow: rgba(245, 158, 11, 0.25);
            --accent-blue: #3b82f6;
            --accent-blue-glow: rgba(59, 130, 246, 0.25);
            --accent-emerald: #10b981;
            --accent-red: #ef4444;

            --radius-lg: 16px;
            --radius-md: 10px;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);

            --bs-body-bg: #0b0f19;
            --bs-body-color: #f3f4f6;
            --bs-border-color: rgba(255, 255, 255, 0.08);
        }

        /* ============================================
           BODY
           ============================================ */
        html, body {
            background-color: var(--bg-dark-body) !important;
            color: var(--text-main) !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
            min-height: 100vh;
        }

        body {
            background-image:
                radial-gradient(circle at 10% 10%, rgba(59, 130, 246, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(245, 158, 11, 0.06) 0%, transparent 40%) !important;
            background-attachment: fixed;
        }

        /* ============================================
           WRAPPER & CONTENT
           ============================================ */
        .wrapper,
        .content-page,
        .content,
        .container-fluid,
        .container {
            background: transparent !important;
            color: var(--text-main);
        }

        .content-page,
        .content {
            padding-bottom: 2rem;
        }

        /* ✅ CONTENU PRINCIPAL - Sans sidebar, pleine largeur */
        .content-page {
            margin-left: 0 !important;
            width: 100% !important;
        }

        /* ============================================
           CARTES
           ============================================ */
        .card, .card-body, .modal-content, [class*="card-"] {
            background: var(--bg-glass-card) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-glass) !important;
            border-radius: var(--radius-lg) !important;
            color: var(--text-main) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .card-header, .card-footer {
            background: rgba(255, 255, 255, 0.03) !important;
            border-color: var(--border-glass) !important;
            color: var(--text-main) !important;
        }

        .card .card,
        .card-body .card,
        .card-body .card-body {
            background: rgba(26, 38, 64, 0.6) !important;
            border: 1px solid var(--border-glass) !important;
        }

        .card *, .card-body *, .modal-content * {
            color: var(--text-main);
        }

        .card h1, .card h2, .card h3, .card h4, .card h5, .card h6,
        .card-body h1, .card-body h2, .card-body h3,
        .card-body h4, .card-body h5, .card-body h6 {
            color: var(--text-main) !important;
        }

        /* ============================================
           TEXTES
           ============================================ */
        .text-muted, .card .text-muted, .card-body .text-muted,
        small.text-muted, p.text-muted, span.text-muted {
            color: var(--text-dim) !important;
            opacity: 1 !important;
        }

        .text-secondary, .card .text-secondary, .card-body .text-secondary {
            color: #8b95a8 !important;
        }

        /* ============================================
           BORDURES
           ============================================ */
        .card-body [class*="border"],
        .border-top, .border-bottom, .border-start, .border-end {
            border-color: var(--border-glass) !important;
        }

        /* ============================================
           TABLEAUX
           ============================================ */
        .table { color: var(--text-main) !important; }

        .table thead th {
            background: rgba(255, 255, 255, 0.04) !important;
            color: var(--accent-amber) !important;
            border-bottom: 1px solid var(--border-glass) !important;
            font-weight: 600;
        }

        .table td, .table th {
            border-color: var(--border-glass) !important;
            color: var(--text-main) !important;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: var(--bg-glass-hover) !important;
        }

        /* ============================================
           BADGES
           ============================================ */
        .badge { color: #fff !important; }

        /* ============================================
           FONDS CLAIRS
           ============================================ */
        .bg-white, .bg-light, [class*="bg-white"], [class*="bg-light"] {
            background: var(--bg-glass-card) !important;
            color: var(--text-main) !important;
        }

        /* ============================================
           FORMULAIRES
           ============================================ */
        .form-control, .form-select,
        .select2-container--default .select2-selection--single {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-glass) !important;
            color: var(--text-main) !important;
            border-radius: var(--radius-md) !important;
            transition: var(--transition-smooth);
        }

        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.08) !important;
            border-color: var(--accent-amber) !important;
            box-shadow: 0 0 12px var(--accent-amber-glow) !important;
            color: #fff !important;
        }

        .form-control:disabled, .form-control[readonly], .form-select:disabled {
            background-color: rgba(255, 255, 255, 0.03) !important;
            color: #8b95a8 !important;
            border-color: var(--border-glass) !important;
        }

        .form-control::placeholder, .form-select::placeholder {
            color: #6b7280 !important;
            opacity: 1 !important;
        }

        .form-label, label { color: var(--text-main) !important; }

        /* ============================================
           SELECT2
           ============================================ */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-main) !important;
        }

        .select2-dropdown {
            background: var(--bg-glass-card) !important;
            border: 1px solid var(--border-glass) !important;
            color: var(--text-main) !important;
        }

        .select2-results__option { color: var(--text-main) !important; }

        .select2-results__option--highlighted {
            background: var(--accent-amber) !important;
            color: #0b0f19 !important;
        }

        /* ============================================
           BOUTONS
           ============================================ */
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-blue), #2563eb) !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, var(--accent-blue)) !important;
            box-shadow: 0 0 20px var(--accent-blue-glow);
        }

        .btn-warning, .btn-amber {
            background: linear-gradient(135deg, var(--accent-amber), #d97706) !important;
            border: none !important;
            color: #1a1a1a !important;
            font-weight: 600;
        }

        .btn-warning:hover { box-shadow: 0 0 20px var(--accent-amber-glow); }

        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.3) !important;
            color: var(--text-main) !important;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }

        /* ============================================
           SCROLLBAR
           ============================================ */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-dark-body); }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent-amber); }

        /* ============================================
           DROPDOWNS
           ============================================ */
        .dropdown-menu {
            background: var(--bg-glass-card) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass-hover) !important;
            border-radius: var(--radius-md) !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5) !important;
            z-index: 1050 !important;
        }

        .dropdown-item {
            color: var(--text-main) !important;
            transition: var(--transition-smooth);
        }

        .dropdown-item:hover {
            background: rgba(245, 158, 11, 0.15) !important;
            color: var(--accent-amber) !important;
        }

        .dropdown-divider { border-color: var(--border-glass) !important; }

        /* ============================================
           MODALS
           ============================================ */
        .modal-content {
            background: var(--bg-glass-card) !important;
            color: var(--text-main) !important;
        }

        .modal-header, .modal-footer {
            border-color: var(--border-glass) !important;
        }

        .btn-close { filter: invert(1); }

        /* ============================================
           ALERTES
           ============================================ */
        .alert {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-glass) !important;
            color: var(--text-main) !important;
        }

        /* ============================================
           FOOTER
           ============================================ */
        .footer {
            background: rgba(255, 255, 255, 0.02) !important;
            border-top: 1px solid var(--border-glass);
            color: var(--text-muted);
            padding: 1rem 0;
            font-size: 0.875rem;
        }

        /* ============================================
           PRELOADER
           ============================================ */
        .dbr-preloader {
            position: fixed;
            inset: 0;
            background: var(--bg-dark-body);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }

        .dbr-spinner {
            width: 48px;
            height: 48px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-top-color: var(--accent-amber);
            border-radius: 50%;
            animation: dbr-spin 0.8s linear infinite;
        }

        @keyframes dbr-spin {
            to { transform: rotate(360deg); }
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 768px) {
            .footer { text-align: center; }
            .footer .text-end { text-align: center !important; }
            .dbr-preloader { display: none; }
        }
    </style>

    @stack('styles')
</head>

<body class="loading"
      data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false,"leftSidebarCondensed":false,"leftSidebarScrollable":false,"hasTopbar":true,"hasSidebar":false}'>

    <!-- Preloader -->
    <div id="preloader" class="dbr-preloader">
        <div class="dbr-spinner"></div>
    </div>

    <!-- Wrapper principal -->
    <div class="wrapper">

        <!-- ✅ Topbar / Header (PAS de sidebar) -->
        @include('template.body.header')

        <!-- ✅ Contenu principal - PLEINE LARGEUR -->
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

    <!-- jQuery + vendor (jQuery inclus dans vendor.min.js) -->
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

            // Initialisation immédiate du thème
            const savedTheme = localStorage.getItem('dbr-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.documentElement.setAttribute('data-bs-theme', savedTheme);

            document.addEventListener('DOMContentLoaded', function() {
                // Force le fond sombre
                document.body.style.backgroundColor = '#0b0f19';
                document.body.style.color = '#f3f4f6';

                if (savedTheme === 'dark') {
                    document.body.classList.add('dark-mode');
                }

                // Nettoyer les classes conflictuelles
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

                console.log('%c[DBR] Initialized v{{ config("app.version", "1.0.0") }} — Theme: ' + savedTheme.toUpperCase(),
                            'color: #f59e0b; font-weight: bold;');
            });
        })();
    </script>

    <!-- ✅ Stack pour JS additionnel par vue -->
    @stack('scripts')

</body>

</html>
