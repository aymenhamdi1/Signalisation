<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ __('SIG-Signalisation - Créer un compte') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plateforme de gestion et de contrôle de la conformité de la signalisation verticale routière - Inscription">

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
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-tag {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--bleu);
            background: rgba(37, 99, 235, 0.08);
            padding: 6px 12px;
            border-radius: 100px;
            margin-bottom: 16px;
            border: 1px solid rgba(37, 99, 235, 0.14);
        }

        .form-tag .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--vert);
            box-shadow: 0 0 8px var(--vert);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%      { opacity: 0.55; transform: scale(0.8); }
        }

        .form-header h2 {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--gris-900);
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 0.9rem;
            color: var(--gris-500);
            line-height: 1.5;
        }

        /* Champs */
        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--gris-700);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            color: var(--gris-400);
            font-size: 0.95rem;
            transition: color 0.25s ease;
            pointer-events: none;
            z-index: 2;
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--bleu-vif);
        }

        .field input[type="text"],
        .field input[type="email"],
        .field input[type="password"] {
            width: 100%;
            padding: 15px 18px 15px 48px;
            font-size: 0.94rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: var(--gris-900);
            background: var(--blanc);
            border: 1.5px solid var(--gris-200);
            border-radius: var(--radius-md);
            outline: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: var(--shadow-sm);
        }

        .field input::placeholder {
            color: var(--gris-400);
            font-weight: 400;
        }

        .field input:hover {
            border-color: var(--gris-300);
        }

        .field input:focus {
            border-color: var(--bleu-vif);
            box-shadow:
                0 0 0 4px var(--bleu-glow),
                var(--shadow-md);
        }

        .field.password-field input {
            padding-right: 52px;
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            color: var(--gris-400);
            cursor: pointer;
            font-size: 0.95rem;
            transition: color 0.2s ease;
            z-index: 2;
            padding: 4px;
            line-height: 1;
        }

        .toggle-password:hover {
            color: var(--bleu-vif);
        }

        /* Erreurs */
        .error-msg {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--rouge);
            font-size: 0.78rem;
            font-weight: 500;
            margin-top: 8px;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25%      { transform: translateX(-4px); }
            75%      { transform: translateX(4px); }
        }

        .field.has-error input {
            border-color: var(--rouge);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.14);
        }

        /* Bouton */
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
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--rouge) 0%, var(--rouge-vif) 100%);
            opacity: 0;
            transition: opacity 0.35s ease;
            z-index: 1;
        }

        .btn-submit:hover::before {
            opacity: 1;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow:
                0 16px 36px rgba(220, 38, 38, 0.38),
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

        /* Register */
        .register {
            margin-top: 26px;
            padding-top: 22px;
            border-top: 1px solid var(--gris-200);
            text-align: center;
            font-size: 0.85rem;
            color: var(--gris-500);
        }

        .register a {
            color: var(--bleu-vif);
            font-weight: 700;
            text-decoration: none;
            margin-left: 4px;
            transition: color 0.2s ease;
        }

        .register a:hover {
            color: var(--rouge);
            text-decoration: underline;
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

            .form-header h2 {
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
                    Nouveau compte
                </span>
                <h2>Créer un compte</h2>
                <p>Rejoignez la plateforme de suivi de la signalisation.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nom complet -->
                <div class="field @error('name') has-error @enderror">
                    <label for="name">{{ __('Nom complet') }}</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-user input-icon"></i>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               placeholder="Ex: Mohamed Ali">
                    </div>
                    @error('name')
                        <span class="error-msg">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Nom d'utilisateur -->
                <div class="field @error('username') has-error @enderror">
                    <label for="username">{{ __("Nom d'utilisateur") }}</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-at input-icon"></i>
                        <input type="text"
                               name="username"
                               id="username"
                               value="{{ old('username') }}"
                               required
                               placeholder="Ex: mali">
                    </div>
                    @error('username')
                        <span class="error-msg">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Adresse Email -->
                <div class="field @error('email') has-error @enderror">
                    <label for="email">{{ __('Adresse Email') }}</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope input-icon"></i>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="nom@domaine.tn">
                    </div>
                    @error('email')
                        <span class="error-msg">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="field password-field @error('password') has-error @enderror">
                    <label for="password">{{ __('Mot de passe') }}</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password"
                               id="password"
                               name="password"
                               required
                               autocomplete="new-password"
                               placeholder="••••••••">
                        <i class="fa-regular fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <span class="error-msg">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div class="field password-field @error('password_confirmation') has-error @enderror">
                    <label for="password_confirmation">{{ __('Confirmer le mot de passe') }}</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-shield-halved input-icon"></i>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               placeholder="••••••••">
                        <i class="fa-regular fa-eye toggle-password" id="togglePasswordConfirm"></i>
                    </div>
                    @error('password_confirmation')
                        <span class="error-msg">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Bouton -->
                <button class="btn-submit" type="submit">
                    <span>{{ __('Créer mon compte') }}</span>
                    <i class="fa-solid fa-user-plus"></i>
                </button>
            </form>

            <div class="register">
                {{ __('Vous avez déjà un compte ?') }}
                <a href="{{ route('login') }}">{{ __('Se connecter') }}</a>
            </div>

        </main>

    </div>

    <!-- =========================================================
         SCRIPTS
    ========================================================== -->
    <script src="{{ asset('Backend/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/sweetalert2.all.js') }}"></script>
    @include('template.scripts.Sweetalert2')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function setupPasswordToggle(toggleId, inputId) {
                const toggleBtn = document.getElementById(toggleId);
                const inputField = document.getElementById(inputId);

                if (toggleBtn && inputField) {
                    toggleBtn.addEventListener('click', function () {
                        const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                        inputField.setAttribute('type', type);
                        this.classList.toggle('fa-eye');
                        this.classList.toggle('fa-eye-slash');
                    });
                }
            }

            setupPasswordToggle('togglePassword', 'password');
            setupPasswordToggle('togglePasswordConfirm', 'password_confirmation');
        });
    </script>

</body>
</html>