<!-- ========== Topbar Start ========== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-3">
            <!-- Logo et Boutons de Menu -->
            <div class="d-flex align-items-center gap-2">
                <!-- Logo Light -->
                <a href="{{ route('all.dashboard') }}" class="logo-light d-none d-lg-block">
                    <img src="{{ asset('Backend/assets/images/logo3.png') }}" alt="DBR Logo" class="main-logo">
                </a>

                <!-- Logo Dark -->
                <a href="{{ route('all.dashboard') }}" class="logo-dark d-block d-lg-none">
                    <img src="{{ asset('Backend/assets/images/logo-sm.png') }}" alt="DBR Logo" class="mobile-logo">
                </a>

                <!-- Boutons de Menu -->
                <button class="button-toggle-menu menu-toggle-btn" title="{{ __('Réduire le menu') }}">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>

                <button class="navbar-toggle mobile-menu-btn" data-bs-toggle="collapse"
                    data-bs-target="#topnav-menu-content">
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
                <div class="nav-link theme-toggle" id="light-dark-mode" title="{{ __('Changer le thème') }}">
                    <i class="fa-solid fa-moon light-icon"></i>
                    <i class="fa-solid fa-sun dark-icon"></i>
                </div>
            </li>

            <!-- Plein écran -->
            <li class="fullscreen-toggle">
                <a class="nav-link fullscreen-btn" href="#" title="{{ __('Plein écran') }}">
                    <i class="fa-solid fa-expand enter-fullscreen"></i>
                    <i class="fa-solid fa-compress exit-fullscreen"></i>
                </a>
            </li>

            <!-- Profil Utilisateur -->
            @php
                $id = Auth::user()->id;
                $adminData = App\Models\User::find($id);
            @endphp
            <li class="dropdown user-profile-dropdown">
                <a class="nav-link dropdown-toggle user-profile" data-bs-toggle="dropdown" href="#" role="button"
                    aria-expanded="false">
                    <div class="user-avatar-container">
                        <img src="{{ !empty($adminData->photo) ? url('upload/admin_images/' . $adminData->photo) : url('upload/no_image.png') }}"
                            alt="{{ __('Photo de profil') }}" class="user-avatar">
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
                            <img src="{{ !empty($adminData->photo) ? url('upload/admin_images/' . $adminData->photo) : url('upload/no_image.png') }}"
                                alt="{{ __('Photo de profil') }}" class="dropdown-avatar">
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
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.4));
    }

    .mobile-logo {
        height: 32px;
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
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 20px;
        padding: 0;
        cursor: pointer;
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
    }

    .profile-dropdown .dropdown-item i {
        color: var(--text-muted);
        transition: var(--transition-smooth);
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

    /* Adaptabilité mobile */
    @media (max-width: 768px) {
        .navbar-custom {
            padding: 0 0.5rem;
        }

        .user-profile {
            padding: 4px !important;
            border-radius: 50%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mode Sombre/Clair Toggle
        const themeBtn = document.getElementById('light-dark-mode');
        const themeContainer = document.querySelector('.theme-toggle-container');

        if (themeBtn) {
            themeBtn.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');
                themeContainer.classList.toggle('active');

                const isDarkMode = document.body.classList.contains('dark-mode');
                localStorage.setItem('darkMode', isDarkMode);
            });

            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                themeContainer.classList.add('active');
            }
        }

        // Mode Plein écran Toggle
        const fullscreenBtn = document.querySelector('.fullscreen-btn');
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', function(e) {
                e.preventDefault();

                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(err => {
                        console.log(`Erreur plein écran: ${err.message}`);
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
    });
</script>
