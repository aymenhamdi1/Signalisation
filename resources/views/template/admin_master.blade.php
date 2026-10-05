<!DOCTYPE html>
<html lang="fr" 
      data-layout-mode="detached" 
      data-topbar-color="dark" 
      data-menu-color="dark"
      data-sidenav-color="dark"
      data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Application DBR">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('DBR') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Backend/assets/images/favicon.ico') }}">

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="{{ asset('Backend/assets/css/icons.min.css') }}" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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

    <!-- ✅ CSS Framework principal EN PREMIER -->
    <link href="{{ asset('Backend/assets/css/app-modern.min.css') }}" rel="stylesheet" id="app-style">
    <link href="{{ asset('Backend/assets/css/toastr.min.css') }}" rel="stylesheet">

    <!-- Configuration globale JS -->
    <script src="{{ asset('Backend/assets/js/DBR-config.js') }}"></script>

    <!-- ============================================
         STYLES PERSONNALISÉS DBR - THÈME SOMBRE
         (Chargés APRÈS le framework pour override)
         ============================================ -->
    <style>
        /* ============================================
           VARIABLES GLOBALES DBR (⚠️ ÉTAIENT MANQUANTES)
           ============================================ */
        :root {
            --bg-dark-body: #0b0f19;
            --bg-dark-topbar: rgba(11, 15, 25, 0.85);
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

            /* Override variables du framework */
            --bs-body-bg: #0b0f19;
            --bs-body-color: #f3f4f6;
            --bs-border-color: rgba(255, 255, 255, 0.08);
        }

        /* ============================================
           CORPS DE PAGE
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

        /* Wrapper & Content */
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

        /* ============================================
           CARTES & PANNEAUX
           ============================================ */
        .card,
        .card-body,
        .modal-content,
        [class*="card-"] {
            background: var(--bg-glass-card) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-glass) !important;
            border-radius: var(--radius-lg) !important;
            color: var(--text-main) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .card-header,
        .card-footer {
            background: rgba(255, 255, 255, 0.03) !important;
            border-color: var(--border-glass) !important;
            color: var(--text-main) !important;
        }

        /* Cartes imbriquées */
        .card .card,
        .card-body .card,
        .card-body .card-body {
            background: rgba(26, 38, 64, 0.6) !important;
            border: 1px solid var(--border-glass) !important;
        }

        /* Texte dans les cartes */
        .card *, .card-body *, .modal-content * {
            color: var(--text-main);
        }

        .card h1, .card h2, .card h3, .card h4, .card h5, .card h6,
        .card-body h1, .card-body h2, .card-body h3,
        .card-body h4, .card-body h5, .card-body h6 {
            color: var(--text-main) !important;
        }

        /* Textes muted */
        .text-muted,
        .card .text-muted,
        .card-body .text-muted,
        small.text-muted,
        p.text-muted,
        span.text-muted {
            color: var(--text-dim) !important;
            opacity: 1 !important;
        }

        .text-secondary,
        .card .text-secondary,
        .card-body .text-secondary {
            color: #8b95a8 !important;
        }

        /* Bordures */
        .card-body [class*="border"],
        .border-top, .border-bottom,
        .border-start, .border-end {
            border-color: var(--border-glass) !important;
        }

        /* Tableaux */
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

        /* Badges */
        .badge { color: #fff !important; }

        /* Fonds clairs → sombres */
        .bg-white, .bg-light,
        [class*="bg-white"], [class*="bg-light"] {
            background: var(--bg-glass-card) !important;
            color: var(--text-main) !important;
        }

        /* ============================================
           FORMULAIRES
           ============================================ */
        .form-control,
        .form-select,
        .select2-container--default .select2-selection--single {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-glass) !important;
            color: var(--text-main) !important;
            border-radius: var(--radius-md) !important;
            transition: var(--transition-smooth);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: rgba(255, 255, 255, 0.08) !important;
            border-color: var(--accent-amber) !important;
            box-shadow: 0 0 12px var(--accent-amber-glow) !important;
            color: #fff !important;
        }

        .form-control:disabled,
        .form-control[readonly],
        .form-select:disabled {
            background-color: rgba(255, 255, 255, 0.03) !important;
            color: #8b95a8 !important;
            border-color: var(--border-glass) !important;
        }

        .form-control::placeholder,
        .form-select::placeholder {
            color: #6b7280 !important;
            opacity: 1 !important;
        }

        .form-label, label {
            color: var(--text-main) !important;
        }

        /* Select2 */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-main) !important;
        }

        .select2-dropdown {
            background: var(--bg-glass-card) !important;
            border: 1px solid var(--border-glass) !important;
            color: var(--text-main) !important;
        }

        .select2-results__option {
            color: var(--text-main) !important;
        }

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

        .btn-warning:hover {
            box-shadow: 0 0 20px var(--accent-amber-glow);
        }

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
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-dark-body);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-amber);
        }

        /* ============================================
           SIDEBAR (SIDENAV)
           ============================================ */
        .leftside-menu,
        .sidenav-menu,
        .side-nav {
            background: rgba(11, 15, 25, 0.95) !important;
            border-right: 1px solid var(--border-glass) !important;
            color: var(--text-main) !important;
        }

        .leftside-menu .side-nav-link,
        .sidenav-menu .side-nav-link {
            color: var(--text-muted) !important;
            transition: var(--transition-smooth);
        }

        .leftside-menu .side-nav-link:hover,
        .sidenav-menu .side-nav-link:hover {
            color: var(--accent-amber) !important;
            background: rgba(245, 158, 11, 0.08) !important;
        }

        .leftside-menu .side-nav-link.active,
        .sidenav-menu .side-nav-link.active {
            color: var(--accent-amber) !important;
            background: rgba(245, 158, 11, 0.12) !important;
        }

        /* ============================================
           DROPDOWNS GLOBAUX
           ============================================ */
        .dropdown-menu {
            background: var(--bg-glass-card) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass-hover) !important;
            border-radius: var(--radius-md) !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5) !important;
            z-index: 1050 !important;
            padding: 0.5rem 0;
        }

        .dropdown-item {
            color: var(--text-main) !important;
            transition: var(--transition-smooth);
        }

        .dropdown-item:hover {
            background: rgba(245, 158, 11, 0.15) !important;
            color: var(--accent-amber) !important;
        }

        .dropdown-divider {
            border-color: var(--border-glass) !important;
        }

        /* ============================================
           BREADCRUMB & TITRES DE PAGE
           ============================================ */
        .page-title-box h4,
        .page-title {
            color: var(--text-main) !important;
        }

        .breadcrumb-item a {
            color: var(--text-muted) !important;
        }

        .breadcrumb-item.active {
            color: var(--accent-amber) !important;
        }

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

        .btn-close {
            filter: invert(1);
        }

        /* ============================================
           ALERTES
           ============================================ */
        .alert {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-glass) !important;
            color: var(--text-main) !important;
        }
    </style>
</head>

<body class="loading" 
      data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"hasTopbar":true}'>

    <!-- Début du Wrapper principal -->
    <div class="wrapper">

               <!-- Topbar / En-tête -->
        @include('template.body.header')

        <!-- Contenu principal -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid pt-3">
                    <!-- Injection dynamique des vues Blade -->
                    @yield('Content')
                </div>
            </div>
        </div>

    </div>
    <!-- Fin du Wrapper -->

    <!-- ============================================
         JAVASCRIPT LIBRARIES
         ============================================ -->

    <!-- jQuery (DOIT être en premier) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Core Vendor JS -->
    <script src="{{ asset('Backend/assets/js/vendor.min.js') }}"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    <script src="{{ asset('Backend/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/vendor/datatables.net-keytable/js/dataTablekeyTable.min.js') }}"></script>
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
    <script src="{{ asset('Backend/assets/js/app.min.js') }}"></script>

    <!-- Demo Scripts -->
    <script src="{{ asset('Backend/assets/js/pages/demo.datatable-init.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/pages/demo.google-maps.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/pages/demo.dashboard-analytics.js') }}"></script>

    <!-- Language Scripts -->
    @include('template.scripts.lang')

    <!-- SweetAlert2 Templates -->
    @include('template.scripts.Sweetalert2')

    <!-- ============================================
         SCRIPT D'INITIALISATION DBR (⚠️ AJOUTÉ)
         Force le thème sombre après init du framework
         ============================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ✅ Forcer le fond sombre (le framework peut l'écraser)
            document.body.style.backgroundColor = '#0b0f19';
            document.body.style.color = '#f3f4f6';
            document.documentElement.setAttribute('data-theme', 'dark');

            // ✅ Restaurer la préférence utilisateur
            const savedTheme = localStorage.getItem('darkMode');
            if (savedTheme === 'false') {
                // L'utilisateur a explicitement choisi le mode clair
                document.body.classList.remove('dark-mode');
            } else {
                // Par défaut : mode sombre DBR
                document.body.classList.add('dark-mode');
            }

            // ✅ Nettoyer les classes conflictuelles du framework
            document.querySelectorAll('.bg-white, .bg-light').forEach(el => {
                if (!el.closest('.no-dbr-theme')) {
                    el.classList.remove('bg-white', 'bg-light');
                }
            });

            console.log('[DBR] Theme initialized:', document.body.classList.contains('dark-mode') ? 'DARK' : 'LIGHT');
        });
    </script>

    <!-- ============================================
         TRANSLATION EXTRACTION SCRIPT (CORRIGÉ)
         ============================================ -->
    @if(Route::has('extract.translations'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const extractBtn = document.getElementById('extractTranslationsBtn');
            if (!extractBtn) return;

            extractBtn.addEventListener('click', function() {
                const routeUrl = '{{ route("extract.translations") }}';
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

                fetch(routeUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: 'Traductions extraites avec succès !',
                        background: '#121a2b',
                        color: '#f3f4f6',
                        confirmButtonColor: '#f59e0b'
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur s\'est produite lors de l\'extraction !',
                        background: '#121a2b',
                        color: '#f3f4f6',
                        confirmButtonColor: '#ef4444'
                    });
                });
            });
        });
    </script>
    @endif

</body>

</html>
