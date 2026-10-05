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
/* ============================================
   CORRECTIONS D'AFFICHAGE - THÈME SOMBRE
   ============================================ */

/* Forcer le fond sombre sur TOUTES les cartes, y compris les sous-cartes */
.card,
.card-body,
.card-header,
.card-footer,
.modal-content,
[class*="card-"] {
    background: var(--bg-glass-card) !important;
    color: var(--text-main) !important;
    border: 1px solid var(--border-glass) !important;
}

/* Corriger les cartes blanches imbriquées (inner cards) */
.card .card,
.card-body .card,
.card-body .card-body {
    background: rgba(26, 38, 64, 0.6) !important;
    border: 1px solid var(--border-glass) !important;
}

/* Forcer la couleur du texte dans toutes les cartes */
.card *,
.card-body *,
.modal-content * {
    color: var(--text-main);
}

/* Titres et sous-titres dans les cartes */
.card h1, .card h2, .card h3, .card h4, .card h5, .card h6,
.card-body h1, .card-body h2, .card-body h3,
.card-body h4, .card-body h5, .card-body h6 {
    color: var(--text-main) !important;
}

/* Textes muted (gris clair) - les rendre visibles */
.text-muted,
.card .text-muted,
.card-body .text-muted,
small.text-muted,
p.text-muted,
span.text-muted,
div.text-muted {
    color: #b8c1d1 !important;
    opacity: 1 !important;
}

/* Labels "Non renseigné" et champs vides */
.card .text-secondary,
.card-body .text-secondary,
.text-secondary {
    color: #8b95a8 !important;
}

/* Sections d'identification avec bordures */
.card-body [class*="border"],
.card-body .border-top,
.card-body .border-bottom,
.card-body .border-start,
.card-body .border-end {
    border-color: var(--border-glass) !important;
}

/* Listes dans les cartes */
.card ul, .card ol, .card-body ul, .card-body ol {
    color: var(--text-main) !important;
}

.card li, .card-body li {
    color: var(--text-main) !important;
}

/* Tableaux dans les cartes */
.card table,
.card-body table {
    color: var(--text-main) !important;
}

.card table td,
.card table th,
.card-body table td,
.card-body table th {
    color: var(--text-main) !important;
    border-color: var(--border-glass) !important;
}

/* Badges et pastilles */
.badge {
    color: #fff !important;
}

/* Forcer le fond sombre sur les sections avec bg-white ou bg-light */
.bg-white,
.bg-light,
[class*="bg-white"],
[class*="bg-light"] {
    background: var(--bg-glass-card) !important;
    color: var(--text-main) !important;
}

/* Inputs désactivés / readonly */
.form-control:disabled,
.form-control[readonly],
.form-select:disabled {
    background-color: rgba(255, 255, 255, 0.03) !important;
    color: #8b95a8 !important;
    border-color: var(--border-glass) !important;
}

/* Placeholder */
.form-control::placeholder,
.form-select::placeholder {
    color: #6b7280 !important;
    opacity: 1 !important;
}

/* Labels de formulaire */
.form-label,
label {
    color: var(--text-main) !important;
}

/* ============================================
   CORRECTION DU TOPBAR / HEADER
   ============================================ */

/* Fixer la hauteur de la topbar */
.topbar,
.navbar-topbar,
.topbar-custom {
    background: rgba(11, 15, 25, 0.95) !important;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border-glass) !important;
    z-index: 1030;
    position: relative;
}

/* Logo DBR - corriger l'image cassée */
.topbar .logo img,
.topbar .logo-img,
.topbar-custom .logo img,
.topbar-custom .logo-img,
.brand-logo,
img[alt*="DBR Logo"] {
    height: 32px !important;
    width: auto !important;
    max-width: 150px !important;
    object-fit: contain;
    display: inline-block;
}

/* Si l'image n'existe pas, afficher un texte de remplacement */
.topbar .logo,
.topbar-custom .logo,
.brand-logo {
    color: var(--accent-amber) !important;
    font-weight: 700;
    font-size: 1.25rem;
    letter-spacing: 1px;
    text-decoration: none;
}

/* ============================================
   CORRECTION DU MENU PROFIL DÉROULANT
   ============================================ */

/* Menu déroulant du profil */
.dropdown-menu,
.profile-dropdown,
.navbar-nav .dropdown-menu {
    background: rgba(18, 26, 43, 0.98) !important;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-glass) !important;
    border-radius: var(--radius-md) !important;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5) !important;
    z-index: 1050 !important;
    min-width: 220px;
    padding: 0.5rem 0;
}

/* Items du menu déroulant */
.dropdown-menu .dropdown-item,
.profile-dropdown .dropdown-item {
    color: var(--text-main) !important;
    padding: 0.6rem 1.25rem;
    transition: var(--transition-smooth);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.dropdown-menu .dropdown-item:hover,
.profile-dropdown .dropdown-item:hover {
    background: rgba(245, 158, 11, 0.15) !important;
    color: var(--accent-amber) !important;
}

/* Icônes dans le menu */
.dropdown-menu .dropdown-item i,
.dropdown-menu .dropdown-item svg {
    width: 18px;
    color: var(--text-muted);
}

.dropdown-menu .dropdown-item:hover i,
.dropdown-menu .dropdown-item:hover svg {
    color: var(--accent-amber);
}

/* Séparateur du menu */
.dropdown-divider {
    border-color: var(--border-glass) !important;
    margin: 0.25rem 0;
}

/* Empêcher le menu de rester ouvert par-dessus le contenu */
.dropdown-menu.show {
    display: block;
    position: absolute !important;
}

/* S'assurer que le contenu principal est bien positionné */
.content-page,
.content {
    position: relative;
    z-index: 1;
}

/* Header dropdown toggle */
.navbar-nav .nav-link,
.profile-toggle,
.dropdown-toggle {
    color: var(--text-main) !important;
    cursor: pointer;
}

.navbar-nav .nav-link:hover,
.profile-toggle:hover {
    color: var(--accent-amber) !important;
}

/* ============================================
   CORRECTIONS SUPPLÉMENTAIRES
   ============================================ */

/* Bouton "Modifier" */
.btn-primary {
    background: linear-gradient(135deg, var(--accent-blue), #2563eb) !important;
    border: none !important;
    color: #fff !important;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, var(--accent-blue)) !important;
    box-shadow: 0 0 20px var(--accent-blue-glow);
}

/* Bouton "Nouvelle observation" (amber) */
.btn-warning,
.btn-amber {
    background: linear-gradient(135deg, var(--accent-amber), #d97706) !important;
    border: none !important;
    color: #1a1a1a !important;
    font-weight: 600;
}

.btn-warning:hover {
    box-shadow: 0 0 20px var(--accent-amber-glow);
}

/* Bouton "Liste" (outline clair) */
.btn-outline-light {
    border-color: rgba(255, 255, 255, 0.3) !important;
    color: var(--text-main) !important;
}

.btn-outline-light:hover {
    background: rgba(255, 255, 255, 0.1) !important;
    color: #fff !important;
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
