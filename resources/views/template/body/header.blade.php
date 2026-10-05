<!-- ========== Topbar Start ========== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@php
    $authUser = Auth::user();
    $adminData = $authUser ? App\Models\User::find($authUser->id) : null;
@endphp

<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-3">
            <!-- Logo et Boutons de Menu -->
            <div class="d-flex align-items-center gap-2">
                
                <!-- ============================================
                     LOGO DESKTOP - SVG INLINE (fonctionne partout)
                     ============================================ -->
                <a href="{{ route('dashboard') }}" 
                   class="logo-light d-none d-lg-flex align-items-center text-decoration-none"
                   aria-label="DBR - Accueil">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         width="240" height="44" 
                         viewBox="0 0 240 44" 
                         fill="none"
                         class="main-logo-svg">
                        <!-- Bâtiments (ministère) -->
                        <g transform="translate(4, 4)">
                            <rect x="0" y="8" width="9" height="26" fill="#1e40af"/>
                            <rect x="11" y="4" width="9" height="30" fill="#1e3a8a"/>
                            <rect x="22" y="6" width="9" height="28" fill="#1e40af"/>
                            <!-- Fenêtres -->
                            <rect x="2" y="11" width="2.5" height="3.5" fill="#fff" opacity="0.8"/>
                            <rect x="2" y="18" width="2.5" height="3.5" fill="#fff" opacity="0.8"/>
                            <rect x="2" y="25" width="2.5" height="3.5" fill="#fff" opacity="0.8"/>
                            <rect x="13" y="7" width="2.5" height="3.5" fill="#fff" opacity="0.8"/>
                            <rect x="13" y="14" width="2.5" height="3.5" fill="#fff" opacity="0.8"/>
                            <rect x="13" y="21" width="2.5" height="3.5" fill="#fff" opacity="0.8"/>
                            <rect x="24" y="9" width="2.5" height="3.5" fill="#fff" opacity="0.8"/>
                            <rect x="24" y="16" width="2.5" height="3.5" fill="#fff" opacity="0.8"/>
                            <rect x="24" y="23" width="2.5" height="3.5" fill="#fff" opacity="0.8"/>
                            <!-- Route verte -->
                            <path d="M0 36 Q15 33 31 32" 
                                  stroke="#65a30d" stroke-width="2.5" 
                                  fill="none" stroke-linecap="round"/>
                            <path d="M4 35.5 L7 35.5 M13 34.5 L16 34.5 M22 33.5 L25 33.5" 
                                  stroke="#fff" stroke-width="1" stroke-dasharray="2,2"/>
                        </g>
                        
                        <!-- Texte arabe -->
                        <text x="42" y="16" 
                              font-family="Arial, sans-serif" 
                              font-size="10" 
                              font-weight="700" 
                              fill="#f3f4f6" 
                              direction="rtl">وزارة التجهيز والإسكان</text>
                        
                        <!-- Texte français principal -->
                        <text x="42" y="28" 
                              font-family="Georgia, serif" 
                              font-size="10.5" 
                              font-weight="700" 
                              fill="#f3f4f6" 
                              letter-spacing="0.3">MINISTÈRE DE L'ÉQUIPEMENT ET DE L'HABITAT</text>
                        
                        <!-- Sous-titre anglais -->
                        <text x="42" y="38" 
                              font-family="Georgia, serif" 
                              font-size="8" 
                              font-weight="700" 
                              fill="#9ca3af" 
                              letter-spacing="0.3">MINISTRY OF EQUIPMENT AND HOUSING</text>
                        
                        <!-- Drapeau tunisien -->
                        <g transform="translate(206, 5)">
                            <rect width="26" height="34" fill="#DC2626"/>
                            <circle cx="13" cy="17" r="8" fill="#fff"/>
                            <circle cx="13" cy="17" r="5.5" fill="#DC2626"/>
                            <circle cx="14.5" cy="17" r="4.5" fill="#fff"/>
                            <circle cx="13" cy="17" r="2.2" fill="#DC2626"/>
                        </g>
                    </svg>
                </a>

                <!-- ============================================
                     LOGO MOBILE - SVG INLINE
                     ============================================ -->
                <a href="{{ route('dashboard') }}" 
                   class="logo-dark d-flex d-lg-none align-items-center text-decoration-none"
                   aria-label="DBR">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         width="42" height="42" 
                         viewBox="0 0 42 42" 
                         fill="none"
                         class="mobile-logo-svg">
                        <path d="M21 4 L35 11 L35 22 C35 30 28 37 21 38 C14 37 7 30 7 22 L7 11 Z"
                              fill="none" stroke="#f59e0b" stroke-width="2.5" 
                              stroke-linejoin="round"/>
                        <path d="M15 21 L19 25 L27 15"
                              fill="none" stroke="#f59e0b" stroke-width="2.5" 
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>

                <!-- ============================================
                     LOGO PNG - SI VOUS PRÉFÉREZ LE VRAI LOGO
                     (Décommentez si le PNG fonctionne)
                     ============================================ -->
                {{-- 
                <a href="{{ route('dashboard') }}" class="logo-light d-none d-lg-block">
                    <img src="{{ asset('Backend/assets/images/logo3.png') }}" 
                         alt="DBR Logo" 
                         class="main-logo"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                </a>
                <a href="{{ route('dashboard') }}" class="logo-dark d-block d-lg-none">
                    <img src="{{ asset('Backend/assets/images/logo-sm.png') }}" 
                         alt="DBR Logo" 
                         class="mobile-logo"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                </a>
                --}}

                <!-- Boutons de Menu -->
                <button class="button-toggle-menu menu-toggle-btn" 
                        type="button"
                        title="{{ __('Réduire le menu') }}"
                        aria-label="{{ __('Réduire le menu') }}">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>

                <button class="navbar-toggle mobile-menu-btn" 
                        type="button"
                        data-bs-toggle="collapse" 
                        data-bs-target="#topnav-menu-content"
                        aria-label="{{ __('Menu') }}">
                    <span class="menu-line"></span>
                    <span class="menu-line"></span>
                    <span class="menu-line"></span>
                </button>
            </div>
        </div>

        <!-- Menu Utilisateur & Contrôles -->
        <ul class="topbar-menu">
            <!-- Mode Sombre/Clair -->
            <li class="theme-toggle-container">
                <button type="button" 
                        class="nav-link theme-toggle" 
                        id="light-dark-mode" 
                        title="{{ __('Changer le thème') }}"
                        aria-label="{{ __('Changer le thème') }}">
                    <i class="fa-solid fa-moon light-icon"></i>
                    <i class="fa-solid fa-sun dark-icon"></i>
                </button>
            </li>

            <!-- Plein écran -->
            <li class="fullscreen-toggle">
                <a class="nav-link fullscreen-btn" 
                   href="#" 
                   title="{{ __('Plein écran') }}"
                   aria-label="{{ __('Plein écran') }}">
                    <i class="fa-solid fa-expand enter-fullscreen"></i>
                    <i class="fa-solid fa-compress exit-fullscreen"></i>
                </a>
            </li>

            <!-- Profil Utilisateur -->
            @if($adminData)
            <li class="dropdown user-profile-dropdown">
                <a class="nav-link dropdown-toggle user-profile" 
                   data-bs-toggle="dropdown" 
                   href="#" 
                   role="button" 
                   aria-expanded="false"
                   aria-haspopup="true">
                    <div class="user-avatar-container">
                        <img src="{{ (!empty($adminData->photo)) ? url('upload/admin_images/'.$adminData->photo) : url('upload/no_image.png') }}"
                             alt="{{ __('Photo de profil') }}"
                             class="user-avatar"
                             onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 36 36%22><circle cx=%2218%22 cy=%2218%22 r=%2218%22 fill=%22%233b82f6%22/><text x=%2218%22 y=%2224%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2216%22 font-family=%22Arial%22 font-weight=%22bold%22>{{ strtoupper(substr($adminData->name ?? 'U', 0, 1)) }}</text></svg>'">
                        <span class="user-status"></span>
                    </div>
                    <div class="user-info d-none d-xl-block">
                        <h6 class="user-name">{{ $adminData->name }}</h6>
                        <p class="user-role">{{ $adminData->role ?? 'Administrateur' }}</p>
                    </div>
                    <i class="fa-solid fa-chevron-down dropdown-arrow d-none d-xl-inline-block"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <div class="dropdown-header">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ (!empty($adminData->photo)) ? url('upload/admin_images/'.$adminData->photo) : url('upload/no_image.png') }}"
                                 alt="{{ __('Photo de profil') }}"
                                 class="dropdown-avatar"
                                 onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 44 44%22><circle cx=%2222%22 cy=%2222%22 r=%2222%22 fill=%22%233b82f6%22/><text x=%2222%22 y=%2229%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2220%22 font-family=%22Arial%22 font-weight=%22bold%22>{{ strtoupper(substr($adminData->name ?? 'U', 0, 1)) }}</text></svg>'">
                            <div class="user-details">
                                <h6 class="mb-0 text-white font-weight-bold">{{ $adminData->name }}</h6>
                                <p class="text-muted-custom mb-0">{{ $adminData->email }}</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.profile') }}" class="dropdown-item">
                        <i class="fa-regular fa-user me-2"></i>
                        <span>{{ __('Mon profil') }}</span>
                    </a>
                    <a href="{{ route('change.password') }}" class="dropdown-item">
                        <i class="fa-solid fa-key me-2"></i>
                        <span>{{ __('Changer mot de passe') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fa-solid fa-sliders me-2"></i>
                        <span>{{ __('Paramètres') }}</span>
                    </a>
                    <a href="{{ route('password.confirm') }}" class="dropdown-item">
                        <i class="fa-solid fa-user-shield me-2"></i>
                        <span>{{ __('Verrouiller') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.logout') }}" class="dropdown-item text-danger-custom">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>
                        <span>{{ __('Déconnexion') }}</span>
                    </a>
                </div>
            </li>
            @endif
        </ul>
    </div>
</div>
<!-- ========== Topbar End ========== -->

<style>
    /* Variables & Aesthetics Glassmorphism Dark Theme */
    :root {
        --bg-dark-topbar: rgba(11, 15, 25, 0.85);
        --bg-glass-card: rgba(18, 26, 43, 0.85);
        --border-glass: rgba(255, 255, 255, 0.08);
        --border-glass-hover: rgba(255, 255, 255, 0.2);

        --text-main: #f3f4f6;
        --text-muted: #9ca3af;

        --accent-amber: #f59e0b;
        --accent-amber-glow: rgba(245, 158, 11, 0.3);
        --accent-blue: #3b82f6;
        --accent-blue-glow: rgba(59, 130, 246, 0.3);
        --accent-emerald: #10b981;
        --accent-red: #ef4444;

        --radius-lg: 16px;
        --radius-md: 10px;
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Navbar Custom Container */
    .navbar-custom {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--bg-dark-topbar) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid var(--border-glass);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        height: 70px;
        position: sticky;
        top: 0;
        z-index: 1002;
        color: var(--text-main);
        transition: var(--transition-smooth);
    }

    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 1.5rem;
        height: 100%;
    }

    /* Logos */
    .main-logo {
        height: 38px;
        transition: var(--transition-smooth);
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));
    }

    .mobile-logo {
        height: 32px;
    }

    /* ✅ SVG Logos - Styles */
    .main-logo-svg,
    .mobile-logo-svg {
        transition: var(--transition-smooth);
        filter: drop-shadow(0 2px 6px rgba(245, 158, 11, 0.15));
    }

    .logo-light:hover .main-logo-svg,
    .logo-dark:hover .mobile-logo-svg {
        transform: scale(1.03);
        filter: drop-shadow(0 2px 12px rgba(245, 158, 11, 0.4));
    }

    .logo-light:hover .main-logo,
    .logo-dark:hover .mobile-logo {
        transform: scale(1.04);
    }

    /* Toggle Buttons */
    .menu-toggle-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-glass);
        color: var(--text-main);
        font-size: 1.1rem;
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition-smooth);
        margin-left: 0.5rem;
    }

    .menu-toggle-btn:hover {
        background: rgba(255, 255, 255, 0.12);
        color: var(--accent-amber);
        border-color: rgba(245, 158, 11, 0.4);
        box-shadow: 0 0 12px var(--accent-amber-glow);
    }

    .mobile-menu-btn {
        background: transparent;
        border: none;
        display: none;
        flex-direction: column;
        justify-content: space-between;
        height: 20px;
        padding: 0;
        cursor: pointer;
    }

    @media (max-width: 992px) {
        .mobile-menu-btn {
            display: flex;
        }
        .menu-toggle-btn {
            display: none;
        }
    }

    .menu-line {
        display: block;
        width: 22px;
        height: 2px;
        background-color: var(--text-main);
        border-radius: 2px;
        transition: var(--transition-smooth);
    }

    .mobile-menu-btn:hover .menu-line {
        background-color: var(--accent-amber);
    }

    /* Topbar Navigation Menu */
    .topbar-menu {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .topbar-menu .nav-link {
        color: var(--text-muted);
        padding: 0 0.75rem;
        height: 40px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: var(--transition-smooth);
        text-decoration: none;
        background: transparent;
        border: none;
    }

    .topbar-menu .nav-link:hover {
        color: var(--accent-amber);
        background: rgba(255, 255, 255, 0.06);
    }

    /* Mode Sombre / Clair Toggle */
    .theme-toggle-container .theme-toggle {
        cursor: pointer;
        width: 40px;
        height: 40px;
        padding: 0;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-glass);
    }

    .theme-toggle-container .theme-toggle:hover {
        border-color: rgba(245, 158, 11, 0.4);
        box-shadow: 0 0 10px var(--accent-amber-glow);
    }

    .dark-icon {
        display: none;
        color: var(--accent-amber);
    }

    .light-icon {
        color: var(--accent-blue);
    }

    .theme-toggle-container.active .light-icon {
        display: none;
    }

    .theme-toggle-container.active .dark-icon {
        display: block;
    }

    /* Plein Ecran */
    .fullscreen-btn {
        width: 40px;
        height: 40px;
        padding: 0 !important;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-glass);
    }

    .exit-fullscreen {
        display: none;
    }

    .fullscreen-btn.active .enter-fullscreen {
        display: none;
    }

    .fullscreen-btn.active .exit-fullscreen {
        display: block;
        color: var(--accent-amber);
    }

    /* Profile Dropdown Component */
    .user-profile-dropdown {
        position: relative;
    }

    .user-profile {
        display: flex !important;
        align-items: center;
        gap: 10px;
        height: 48px !important;
        padding: 4px 12px 4px 6px !important;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-glass);
        border-radius: 30px;
        cursor: pointer;
        transition: var(--transition-smooth);
        text-decoration: none;
    }

    .user-profile:hover,
    .user-profile-dropdown.show .user-profile {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(245, 158, 11, 0.3);
        box-shadow: 0 0 12px rgba(245, 158, 11, 0.15);
    }

    .user-avatar-container {
        position: relative;
        width: 36px;
        height: 36px;
        flex-shrink: 0;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--accent-amber);
    }

    .user-status {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        background-color: var(--accent-emerald);
        border-radius: 50%;
        border: 2px solid #0b0f19;
        box-shadow: 0 0 6px var(--accent-emerald);
    }

    .user-info {
        text-align: left;
        line-height: 1.2;
    }

    .user-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 2px;
    }

    .user-role {
        font-size: 0.725rem;
        color: var(--text-muted);
        margin-bottom: 0;
    }

    .dropdown-arrow {
        font-size: 0.75rem;
        color: var(--text-muted);
        transition: var(--transition-smooth);
    }

    .user-profile-dropdown.show .dropdown-arrow {
        transform: rotate(180deg);
        color: var(--accent-amber);
    }

    /* Menu Déroulant (Dropdown Glassmorphism) */
    .profile-dropdown {
        background: var(--bg-glass-card) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--border-glass-hover) !important;
        border-radius: var(--radius-lg) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6) !important;
        width: 260px;
        padding: 8px;
        margin-top: 10px !important;
        right: 0 !important;
        left: auto !important;
        position: absolute !important;
        top: 100% !important;
        z-index: 1050;
    }

    .dropdown-header {
        padding: 12px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: var(--radius-md);
        border-bottom: 1px solid var(--border-glass);
        margin-bottom: 6px;
    }

    .dropdown-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--accent-blue);
        flex-shrink: 0;
    }

    .text-muted-custom {
        color: var(--text-muted);
        font-size: 0.775rem;
    }

    .profile-dropdown .dropdown-item {
        color: var(--text-main);
        padding: 10px 14px;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: var(--transition-smooth);
        text-decoration: none;
    }

    .profile-dropdown .dropdown-item i {
        color: var(--text-muted);
        transition: var(--transition-smooth);
        width: 18px;
        text-align: center;
    }

    .profile-dropdown .dropdown-item:hover {
        background: rgba(245, 158, 11, 0.12);
        color: var(--accent-amber);
    }

    .profile-dropdown .dropdown-item:hover i {
        color: var(--accent-amber);
        transform: translateX(3px);
    }

    .dropdown-divider {
        border-top-color: var(--border-glass);
        margin: 6px 0;
    }

    .dropdown-item.text-danger-custom {
        color: var(--accent-red);
    }

    .dropdown-item.text-danger-custom:hover {
        background: rgba(239, 68, 68, 0.12);
        color: var(--accent-red);
    }

    .dropdown-item.text-danger-custom:hover i {
        color: var(--accent-red);
    }

    /* Animations */
    .dropdown-menu-animated {
        animation: dropdownFadeIn 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Adaptabilité mobile */
    @media (max-width: 768px) {
        .navbar-custom {
            padding: 0 0.5rem;
        }

        .topbar {
            padding: 0 0.75rem;
        }

        .user-profile {
            padding: 4px !important;
            border-radius: 50%;
        }

        .profile-dropdown {
            width: calc(100vw - 24px);
            right: 12px !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ============================================
        // MODE SOMBRE / CLAIR
        // ============================================
        const themeBtn = document.getElementById('light-dark-mode');
        const themeContainer = document.querySelector('.theme-toggle-container');

        if (themeBtn && themeContainer) {
            // Restaurer l'état sauvegardé
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                themeContainer.classList.add('active');
            }

            themeBtn.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');
                themeContainer.classList.toggle('active');

                const isDarkMode = document.body.classList.contains('dark-mode');
                localStorage.setItem('darkMode', isDarkMode);
            });
        }

        // ============================================
        // MODE PLEIN ÉCRAN
        // ============================================
        const fullscreenBtn = document.querySelector('.fullscreen-btn');
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', function(e) {
                e.preventDefault();

                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(err => {
                        console.warn(`Erreur plein écran: ${err.message}`);
                    });
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    }
                }
            });

            document.addEventListener('fullscreenchange', function() {
                if (document.fullscreenElement) {
                    fullscreenBtn.classList.add('active');
                } else {
                    fullscreenBtn.classList.remove('active');
                }
            });
        }

        // ============================================
        // FERMER LE MENU AU CLIC EXTÉRIEUR
        // ============================================
        document.addEventListener('click', function(e) {
            const dropdown = document.querySelector('.user-profile-dropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                const menu = dropdown.querySelector('.dropdown-menu');
                if (menu && menu.classList.contains('show')) {
                    const toggle = dropdown.querySelector('[data-bs-toggle="dropdown"]');
                    if (toggle && typeof bootstrap !== 'undefined') {
                        bootstrap.Dropdown.getInstance(toggle)?.hide();
                    }
                }
            }
        });
    });
</script>
