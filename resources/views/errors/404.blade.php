<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ __('SIG-Signalisation - Page introuvable') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plateforme de gestion et de contrôle de la conformité de la signalisation verticale routière - Page introuvable">

    <link rel="shortcut icon" href="{{ asset('Backend/assets/images/favicon.ico') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('Backend/assets/css/toastr.min.css') }}" rel="stylesheet">

    <style>
        /* =========================================================
           RESET
        ========================================================= */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bleu: #1E40AF;
            --bleu-vif: #2563EB;
            --bleu-clair: #3B82F6;
            --bleu-glow: rgba(37, 99, 235, 0.30);

            --rouge: #DC2626;
            --rouge-vif: #EF4444;

            --jaune: #FACC15;
            --jaune-vif: #FDE047;

            --vert: #10B981;

            --blanc: #FFFFFF;
            --gris-50: #F8FAFC;
            --gris-100: #F1F5F9;
            --gris-200: #E2E8F0;
            --gris-300: #CBD5E1;
            --gris-400: #94A3B8;
            --gris-500: #64748B;
            --gris-600: #475569;
            --gris-700: #334155;
            --gris-900: #0F172A;

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-xl: 28px;

            --shadow-sm: 0 2px 6px rgba(15, 23, 42, 0.06), 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 6px 16px rgba(15, 23, 42, 0.08), 0 2px 4px rgba(15, 23, 42, 0.04);
            --shadow-lg: 0 16px 40px rgba(15, 23, 42, 0.14), 0 4px 12px rgba(15, 23, 42, 0.06);
            --shadow-2xl: 0 32px 80px rgba(15, 23, 42, 0.28), 0 12px 28px rgba(15, 23, 42, 0.12);
        }

        html, body {
            min-height: 100%;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--gris-900);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            position: relative;
            overflow-x: hidden;

            /* IMAGE DE FOND + OVERLAY */
            background:
                linear-gradient(
                    135deg,
                    rgba(15, 23, 42, 0.80) 0%,
                    rgba(30, 58, 138, 0.72) 50%,
                    rgba(15, 23, 42, 0.85) 100%
                ),
                url("{{ asset('Backend/assets/images/sign.jpg') }}") no-repeat center center fixed;
            background-size: cover;

            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at 15% 20%, rgba(59, 130, 246, 0.30) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(250, 204, 21, 0.14) 0%, transparent 45%),
                radial-gradient(circle at 80% 15%, rgba(220, 38, 38, 0.12) 0%, transparent 40%);
            pointer-events: none;
            z-index: 1;
        }

        /* =========================================================
           CARTE PRINCIPALE
        ========================================================= */
        .page {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1040px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border-radius: var(--radius-xl);
            box-shadow:
                var(--shadow-2xl),
                0 0 0 1px rgba(255, 255, 255, 0.5) inset;
            overflow: hidden;
            animation: cardIn 0.9s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* =========================================================
           COLONNE GAUCHE
        ========================================================= */
        .side-left {
            position: relative;
            padding: 52px 44px;
            background:
                radial-gradient(circle at 20% 0%, rgba(59, 130, 246, 0.45) 0%, transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(250, 204, 21, 0.18) 0%, transparent 55%),
                linear-gradient(150deg, #1E3A8A 0%, #1E40AF 55%, #172554 100%);
            color: var(--blanc);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .side-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
            background-size: 22px 22px;
            opacity: 0.7;
            pointer-events: none;
        }

        .side-left::after {
            content: '';
            position: absolute;
            top: -140px;
            right: -140px;
            width: 320px;
            height: 320px;
            border: 2px dashed rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            animation: rotate 45s linear infinite;
            pointer-events: none;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .side-left-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* =======================================================
           BRAND
        ======================================================= */
        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 48px;
        }

        .brand-logo-box {
            width: 100%;
            height: 56px;
            flex-shrink: 0;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.2);
        }

        .brand-logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 6px;
            display: block;
        }

        /* Titre */
        .hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.035em;
            margin-bottom: 18px;
        }

        .hero-title .accent {
            background: linear-gradient(120deg, var(--jaune) 0%, var(--jaune-vif) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-description {
            font-size: 0.9rem;
            line-height: 1.65;
            opacity: 0.85;
            max-width: 340px;
            margin-bottom: 32px;
        }

        /* Badges */
        .badge-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: var(--blanc);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: default;
        }

        .badge-icon:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.18);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25);
        }

        .badge-icon.yellow {
            background: linear-gradient(135deg, var(--jaune) 0%, var(--jaune-vif) 100%);
            color: var(--gris-900);
            border-color: transparent;
            box-shadow: 0 8px 20px rgba(250, 204, 21, 0.40);
        }

        .badge-icon.red {
            background: linear-gradient(135deg, var(--rouge) 0%, var(--rouge-vif) 100%);
            border-color: transparent;
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.40);
        }

        /* Footer gauche */
        .side-left-footer {
            position: relative;
            z-index: 2;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            opacity: 0.6;
            padding-top: 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            margin-top: auto;
        }

        /* =========================================================
           COLONNE DROITE
        ========================================================= */
        .side-right {
            padding: 52px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.9);
            overflow-y: auto;
            max-height: 90vh;
            text-align: center;
        }

        .form-header {
            margin-bottom: 26px;
        }

        .form-tag {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--jaune);
            background: rgba(250, 204, 21, 0.10);
            padding: 6px 12px;
            border-radius: 100px;
            margin-bottom: 16px;
            border: 1px solid rgba(250, 204, 21, 0.25);
        }

        .form-tag .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--jaune);
            box-shadow: 0 0 8px var(--jaune);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%      { opacity: 0.55; transform: scale(0.8); }
        }

        /* Icône erreur 404 */
        .error-icon-wrapper {
            width: 100px;
            height: 100px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, rgba(250, 204, 21, 0.15) 0%, rgba(253, 224, 71, 0.08) 100%);
            border: 2px solid rgba(250, 204, 21, 0.40);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: pulse-error 2.5s ease-in-out infinite;
        }

        @keyframes pulse-error {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(250, 204, 21, 0.30);
            }
            50% {
                box-shadow: 0 0 0 18px rgba(250, 204, 21, 0);
            }
        }

        .error-icon-wrapper::before {
            content: '';
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            border: 1.5px dashed rgba(250, 204, 21, 0.30);
            animation: rotate 20s linear infinite;
        }

        .error-icon-wrapper i {
            font-size: 2.8rem;
            background: linear-gradient(135deg, #F59E0B 0%, var(--jaune) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .error-code {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 5px;
            letter-spacing: -2px;
            background: linear-gradient(135deg, #F59E0B 0%, var(--jaune) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 4px 20px rgba(250, 204, 21, 0.25);
        }

        .error-title {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--gris-900);
            margin-bottom: 12px;
        }

        .error-description {
            color: var(--gris-500);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 30px;
            max-width: 360px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Bouton principal */
        .btn-submit {
            position: relative;
            width: 100%;
            padding: 16px 24px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--blanc);
            background: linear-gradient(135deg, var(--bleu) 0%, var(--bleu-vif) 100%);
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow:
                0 10px 24px var(--bleu-glow),
                0 2px 4px rgba(15, 23, 42, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--jaune) 0%, var(--jaune-vif) 100%);
            opacity: 0;
            transition: opacity 0.35s ease;
            z-index: 1;
        }

        .btn-submit:hover::before {
            opacity: 1;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            color: var(--gris-900);
            box-shadow:
                0 16px 36px rgba(250, 204, 21, 0.38),
                0 4px 8px rgba(15, 23, 42, 0.10);
        }

        .btn-submit span,
        .btn-submit i {
            position: relative;
            z-index: 2;
        }

        .btn-submit i {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-submit:hover i {
            transform: translateX(4px);
        }

        /* Bouton secondaire (retour) */
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px 24px;
            margin-top: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gris-600);
            background: var(--blanc);
            border: 1.5px solid var(--gris-200);
            border-radius: var(--radius-md);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: var(--shadow-sm);
        }

        .btn-back:hover {
            color: var(--bleu-vif);
            border-color: var(--bleu-vif);
            background: rgba(37, 99, 235, 0.04);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
        }

        /* Register / Footer */
        .register {
            margin-top: 26px;
            padding-top: 22px;
            border-top: 1px solid var(--gris-200);
            text-align: center;
            font-size: 0.85rem;
            color: var(--gris-500);
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */
        @media (max-width: 900px) {
            .page {
                grid-template-columns: 1fr;
                max-width: 540px;
            }

            .side-left {
                padding: 40px 32px;
            }

            .hero-title {
                font-size: 1.9rem;
            }

            .side-right {
                padding: 40px 32px;
                max-height: none;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 16px 12px;
            }

            .side-left,
            .side-right {
                padding: 32px 22px;
            }

            .hero-title {
                font-size: 1.55rem;
            }

            .badge-icon {
                width: 40px;
                height: 40px;
                font-size: 15px;
            }

            .brand-logo-box {
                width: 148px;
                height: 48px;
            }

            .error-code {
                font-size: 3.5rem;
            }

            .error-icon-wrapper {
                width: 80px;
                height: 80px;
            }

            .error-icon-wrapper i {
                font-size: 2.2rem;
            }

            .error-title {
                font-size: 1.4rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body>

    <div class="page">

        <!-- =====================================================
             COLONNE GAUCHE
        ====================================================== -->
        <aside class="side-left">

            <div class="side-left-content">

                <!-- BRAND -->
                <div class="brand">
                    <div class="brand-logo-box">
                        <img src="{{ asset('Backend/assets/images/logo3.png') }}"
                             alt="Logo Ministère"
                             onerror="
                                 this.style.display='none';
                                 this.parentElement.insertAdjacentHTML(
                                     'beforeend',
                                     '<i class=\'fa-solid fa-landmark-flag\'></i>'
                                 );
                             ">
                    </div>
                </div>

                <!-- TITRE -->
                <h1 class="hero-title">
                    SIG<span class="accent">·</span>Signalisation
                </h1>

                <p class="hero-description">
                    Plateforme d'inventaire et de contrôle de conformité
                    de la signalisation verticale routière — CCTP DGPC.
                </p>

                <!-- BADGES -->
                <div class="badge-row">
                    <div class="badge-icon yellow">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="badge-icon red">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                    <div class="badge-icon">
                        <i class="fa-solid fa-arrow-up"></i>
                    </div>
                    <div class="badge-icon">
                        <i class="fa-solid fa-road"></i>
                    </div>
                </div>

            </div>

            <div class="side-left-footer">
                Direction Générale des Ponts et Chaussées
            </div>

        </aside>

        <!-- =====================================================
             COLONNE DROITE
        ====================================================== -->
        <main class="side-right">

            <div class="form-header">
                <span class="form-tag">
                    <span class="dot"></span>
                    Erreur 404
                </span>
            </div>

            <!-- Icône d'erreur animée -->
            <div class="error-icon-wrapper">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>

            <!-- Code erreur -->
            <div class="error-code">404</div>

            <!-- Titre -->
            <h1 class="error-title">{{ __('Page introuvable') }}</h1>

            <!-- Description -->
            <p class="error-description">
                {{ __("La page que vous recherchez n'existe pas ou a été déplacée. Vérifiez l'URL ou revenez à l'accueil pour continuer votre navigation.") }}
            </p>

            <!-- Boutons d'action -->
            <a class="btn-submit" href="{{ route('index') }}">
                <span>{{ __('Retour à l\'accueil') }}</span>
                <i class="fa-solid fa-house"></i>
            </a>

            <a class="btn-back" href="javascript:history.back()">
                <i class="fa-solid fa-arrow-left"></i>
                {{ __('Page précédente') }}
            </a>

            <div class="register">
                &copy; {{ date('Y') }} {{ __('SIG-Signalisation — Plateforme de Suivi Routier') }}
            </div>

        </main>

    </div>

    <!-- =========================================================
         SCRIPTS
    ========================================================== -->
    <script src="{{ asset('Backend/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/sweetalert2.all.js') }}"></script>
    @include('template.scripts.Sweetalert2')

</body>
</html>