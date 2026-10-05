<!DOCTYPE html>
<html lang="fr" data-layout-mode="detached" data-topbar-color="dark" data-menu-color="dark">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Application DBR">

    <title>{{ __('DBR') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Backend/assets/images/favicon.ico') }}">

    <!-- Google Fonts & Icones FontAwesome & RemixIcon -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="{{ asset('Backend/assets/css/icons.min.css') }}" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="{{ asset('Backend/assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Date Range Picker -->
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/daterangepicker/daterangepicker.css') }}">

    <!-- Vector Maps -->
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

    <!-- Core CSS Framework -->
    <link href="{{ asset('Backend/assets/css/app-modern.min.css') }}" rel="stylesheet" id="app-style">
    <link href="{{ asset('Backend/assets/css/toastr.min.css') }}" rel="stylesheet">

    <!-- Configuration globale JS -->
    <script src="{{ asset('Backend/assets/js/DBR-config.js') }}"></script>

    <!-- Global Glassmorphism & Dark Theme Styles -->
    <style>
        :root {
            --bg-dark-body: #0b0f19;
            --bg-glass-card: rgba(18, 26, 43, 0.75);
            --bg-glass-hover: rgba(26, 38, 64, 0.85);
            --border-glass: rgba(255, 255, 255, 0.08);
            --border-glass-hover: rgba(255, 255, 255, 0.2);
            
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            
            --accent-amber: #f59e0b;
            --accent-amber-glow: rgba(245, 158, 11, 0.25);
            --accent-blue: #3b82f6;
            --accent-blue-glow: rgba(59, 130, 246, 0.25);
            
            --radius-lg: 16px;
            --radius-md: 10px;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
            background-color: var(--bg-dark-body) !important;
            color: var(--text-main) !important;
            background-image: 
                radial-gradient(circle at 10% 10%, rgba(59, 130, 246, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(245, 158, 11, 0.06) 0%, transparent 40%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Wrapper & Content Containers */
        .wrapper {
            background: transparent !important;
        }

        .content-page, .content {
            background: transparent !important;
            padding-bottom: 2rem;
        }

        /* Cartes et Panneaux en Glassmorphism */
        .card, .card-body, .modal-content {
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
        }

        /* Champs de saisie (Inputs, Selects, Textareas) */
        .form-control, .form-select, .select2-container--default .select2-selection--single {
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

        /* DataTables Custom Theme */
        .table {
            color: var(--text-main) !important;
            border-color: var(--border-glass) !important;
        }

        .table thead th {
            background: rgba(255, 255, 255, 0.04) !important;
            color: var(--accent-amber) !important;
            border-bottom: 1px solid var(--border-glass) !important;
            font-weight: 600;
        }

        .table td, .table th {
            border-color: var(--border-glass) !important;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: var(--bg-glass-hover) !important;
        }

        /* Barre de défilement (Scrollbar) moderne */
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
    </style>
</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"hasTopbar":true}'>
    
    <!-- Début du Wrapper principal -->
    <div class="wrapper">

        <!-- Topbar / En-tête -->
        @include('template.body.header')

        <!-- Contenu principal -->
        <div class="container-fluid">
            <div class="content">
                <div class="container-fluid pt-3">
                    <!-- Injection dynamique des vues Blade -->
                    @yield('Content')
                </div>
            </div>
        </div>

    </div>
    <!-- Fin du Wrapper -->

    <!-- Core JavaScript Libraries -->
    <script src="{{ asset('Backend/assets/js/vendor.min.js') }}"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    <!-- Custom Scripts -->
    <script src="{{ asset('Backend/assets/js/app.min.js') }}"></script>

    <!-- Demo Scripts -->
    <script src="{{ asset('Backend/assets/js/pages/demo.datatable-init.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/pages/demo.google-maps.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/pages/demo.dashboard-analytics.js') }}"></script>

    <!-- Language Scripts -->
    @include('template.scripts.lang')

    <!-- SweetAlert2 Templates -->
    @include('template.scripts.Sweetalert2')

    <!-- Translation Extraction Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const extractBtn = document.getElementById('extractTranslationsBtn');

            if (extractBtn) {
                extractBtn.addEventListener('click', function() {
                    const routeUrl = '{{ route("extract.translations") }}';

                    fetch(routeUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
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
                                text: 'Une erreur s’est produite lors de l’extraction !',
                                background: '#121a2b',
                                color: '#f3f4f6',
                                confirmButtonColor: '#ef4444'
                            });
                        });
                });
            }
        });
    </script>
</body>

</html>
