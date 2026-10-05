<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIG-Signalisation — Gestion du Patrimoine Routier</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        /* =========================================================
           RESET
        ========================================================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: #fff;
            background-color: #0f172a;

            background-image:
                linear-gradient(135deg, rgba(8, 15, 30, 0.88), rgba(15, 23, 42, 0.94)),
                url('{{ asset('backend/assets/images/img1.jpg') }}');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;

            overflow-x: hidden;
        }

        /* =========================================================
           CANVAS PARTICULES
        ========================================================= */
        #data-canvas {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            z-index: 1;
            pointer-events: none;
        }

        /* =========================================================
           OVERLAY PRINCIPAL
        ========================================================= */
        .overlay {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            padding: 45px 20px 50px;
            display: flex;
            justify-content: center;
        }

        .main-container {
            width: 100%;
            max-width: 1250px;
            margin: auto;
        }

        /* =========================================================
           🖼️ LOGO — AFFICHÉ TEL QUEL (SANS CERCLE)
        ========================================================= */
        .logo-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            padding: 10px 0;
            text-align: center;
            width: 100%;
        }

        /* Image du logo affichée telle quelle, juste centrée et agrandie */
        .logo-img {
            display: block;
            margin: 0 auto;
            width: auto;
            max-width: 100%;
            height: 80px;
            /* Taille du logo */
            object-fit: contain;
            filter: drop-shadow(0 12px 30px rgba(0, 0, 0, 0.5));
            transition: transform 0.5s ease;
            animation: logoAppear 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        .logo-img:hover {
            transform: scale(1.05);
        }

        @keyframes logoAppear {
            from {
                opacity: 0;
                transform: scale(0.85) translateY(-15px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Fallback si le logo est manquant */
        .logo-fallback {
            display: block;
            margin: 0 auto;
            font-size: 110px;
            color: #f59e0b;
            filter: drop-shadow(0 10px 25px rgba(245, 158, 11, 0.5));
            animation: iconPulse 3s ease-in-out infinite;
        }

        @keyframes iconPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(0.94);
                opacity: 0.88;
            }
        }

        /* Nom de l'institution sous le logo */
        .institution-hero {
            margin-top: 24px;
            text-align: center;
        }

        .institution-hero-title {
            color: #ffffff;
            font-size: clamp(14px, 1.6vw, 16px);
            font-weight: 800;
            letter-spacing: 0.09em;
            line-height: 1.3;
            text-shadow: 0 3px 10px rgba(0, 0, 0, 0.35);
        }

        .institution-hero-subtitle {
            color: #94a3b8;
            font-size: clamp(11.5px, 1.3vw, 13px);
            margin-top: 7px;
            font-weight: 500;
            letter-spacing: 0.04em;
        }

        .institution-hero-subtitle::after {
            content: '';
            display: block;
            width: 50px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.7), transparent);
            margin: 16px auto 0;
        }

        /* =========================================================
           TITRE
        ========================================================= */
        .header {
            text-align: center;
        }

        .system-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 7px 16px;
            margin-bottom: 20px;
            border-radius: 30px;
            color: #fbbf24;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            background: rgba(245, 158, 11, 0.08);
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .system-label i {
            color: #f59e0b;
        }

        .title {
            font-size: clamp(28px, 5vw, 54px);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.035em;
            margin-bottom: 18px;
            text-shadow: 0 5px 25px rgba(0, 0, 0, 0.35);
        }

        .highlight-amber {
            color: #f59e0b;
        }

        .highlight-blue {
            color: #60a5fa;
        }

        .subtitle {
            max-width: 820px;
            margin: 0 auto;
            color: #a8b4c7;
            font-size: 15px;
            line-height: 1.8;
        }

        /* =========================================================
           STATISTIQUES
        ========================================================= */
        .stats-badge {
            margin: 35px auto 42px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .stat-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 15px;
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 600;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.045);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            transition: 0.3s ease;
        }

        .stat-item i {
            color: #f59e0b;
        }

        .stat-item:hover {
            transform: translateY(-3px);
            color: #fff;
            border-color: rgba(245, 158, 11, 0.35);
            background: rgba(245, 158, 11, 0.08);
        }

        /* =========================================================
           CARTES
        ========================================================= */
        .feature-card {
            height: 100%;
            min-height: 180px;
            padding: 30px 22px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            border-radius: 22px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.055), rgba(255, 255, 255, 0.018));
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.18);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            transition: transform 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease;
        }

        .feature-card::before {
            content: attr(data-num);
            position: absolute;
            top: 10px;
            right: 16px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 40px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.035);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(245, 158, 11, 0.4);
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.25), 0 0 25px rgba(245, 158, 11, 0.08);
        }

        .feature-icon-wrapper {
            width: 65px;
            height: 65px;
            margin-bottom: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 17px;
            color: #fff;
            font-size: 25px;
            background: rgba(255, 255, 255, 0.055);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: 0.4s ease;
        }

        .feature-card:hover .feature-icon-wrapper {
            transform: scale(1.08) rotate(-4deg);
            background: linear-gradient(135deg, #b45309, #f59e0b);
            box-shadow: 0 12px 25px rgba(245, 158, 11, 0.3);
        }

        .blue-accent:hover .feature-icon-wrapper {
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            box-shadow: 0 12px 25px rgba(59, 130, 246, 0.3);
        }

        .green-accent:hover .feature-icon-wrapper {
            background: linear-gradient(135deg, #047857, #10b981);
            box-shadow: 0 12px 25px rgba(16, 185, 129, 0.3);
        }

        .red-accent:hover .feature-icon-wrapper {
            background: linear-gradient(135deg, #b91c1c, #ef4444);
            box-shadow: 0 12px 25px rgba(239, 68, 68, 0.3);
        }

        .feature-title {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.4;
        }

        /* =========================================================
           ZONE CONNEXION
        ========================================================= */
        .login-section {
            margin-top: 45px;
            text-align: center;
        }

        .login-caption {
            color: #64748b;
            font-size: 11px;
            font-family: 'JetBrains Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            margin-bottom: 14px;
        }

        .btn-login {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 15px 35px;
            min-width: 280px;
            color: #fff !important;
            text-decoration: none;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 700;
            background: linear-gradient(135deg, #b45309, #f59e0b);
            box-shadow: 0 12px 30px rgba(245, 158, 11, 0.28);
            transition: 0.4s ease;
            overflow: hidden;
        }

        .btn-login::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: 0.6s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 38px rgba(245, 158, 11, 0.4);
            background: linear-gradient(135deg, #f59e0b, #10b981);
        }

        .btn-login i {
            transition: 0.3s ease;
        }

        .btn-login:hover i {
            transform: translateX(5px);
        }

        /* =========================================================
           BANDEAU
        ========================================================= */
        .cctp-strip {
            margin-top: 42px;
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            padding: 17px 22px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(10px);
        }

        .spec {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 600;
        }

        .spec i {
            color: #f59e0b;
        }

        /* =========================================================
           FOOTER
        ========================================================= */
        .footer {
            margin-top: 38px;
            padding-top: 22px;
            text-align: center;
            color: rgba(148, 163, 184, 0.65);
            font-size: 12px;
            line-height: 1.7;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .footer strong {
            color: rgba(255, 255, 255, 0.85);
        }

        /* =========================================================
           ORBE IA
        ========================================================= */
        .ai-orb-card {
            position: fixed;
            right: 25px;
            bottom: 25px;
            z-index: 999;
            width: 125px;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            border-radius: 20px;
            background: linear-gradient(160deg, rgba(15, 23, 42, 0.94), rgba(30, 27, 75, 0.94));
            border: 1px solid rgba(245, 158, 11, 0.35);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(18px);
            animation: orbFloat 5s ease-in-out infinite;
            transition: 0.4s ease;
        }

        .ai-orb-card:hover {
            transform: translateY(-7px) scale(1.04);
            box-shadow: 0 25px 55px rgba(245, 158, 11, 0.3);
        }

        .ai-orb {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: radial-gradient(circle at 30% 30%, #fde68a, #f59e0b 35%, #3b82f6 70%, #1e40af);
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.55), inset -8px -8px 18px rgba(0, 0, 0, 0.3);
            animation: orbRotate 8s linear infinite;
        }

        .ai-orb img {
            width: 30px;
            height: 30px;
            object-fit: contain;
            position: relative;
            z-index: 3;
            filter: drop-shadow(0 0 6px rgba(255, 255, 255, 0.9));
        }

        .fallback-icon {
            color: white;
            font-size: 25px;
            position: relative;
            z-index: 3;
        }

        .ai-orb-text {
            text-align: center;
        }

        .ai-orb-title {
            display: block;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #fde68a;
        }

        .ai-orb-subtitle {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            margin-top: 3px;
            color: #cbd5e1;
            font-size: 9px;
            font-weight: 600;
        }

        .ai-orb-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
            animation: blink 1.5s infinite;
        }

        /* =========================================================
           ANIMATIONS
        ========================================================= */
        @keyframes orbFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-7px);
            }
        }

        @keyframes orbRotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */
        @media (max-width: 768px) {
            .overlay {
                padding: 35px 15px 40px;
            }

            .logo-img {
                height: 140px;
            }

            .logo-fallback {
                font-size: 90px;
            }

            .stats-badge {
                margin-bottom: 30px;
            }

            .cctp-strip {
                gap: 15px;
            }

            .ai-orb-card {
                width: 105px;
                right: 15px;
                bottom: 15px;
                padding: 13px 9px;
            }

            .ai-orb {
                width: 50px;
                height: 50px;
            }
        }

        @media (max-width: 480px) {
            .overlay {
                padding: 25px 12px 35px;
            }

            .logo-img {
                height: 110px;
            }

            .logo-fallback {
                font-size: 70px;
            }

            .institution-hero-title {
                font-size: 12px;
            }

            .institution-hero-subtitle {
                font-size: 10.5px;
            }

            .title {
                font-size: 27px;
            }

            .subtitle {
                font-size: 13px;
            }

            .stats-badge {
                flex-direction: column;
                align-items: stretch;
            }

            .stat-item {
                justify-content: center;
            }

            .feature-card {
                min-height: 155px;
                padding: 24px 18px;
            }

            .btn-login {
                min-width: 0;
                width: 100%;
                padding: 14px 20px;
            }

            .cctp-strip {
                flex-direction: column;
                align-items: flex-start;
            }

            .ai-orb-card {
                width: 90px;
                right: 10px;
                bottom: 10px;
            }

            .ai-orb {
                width: 43px;
                height: 43px;
            }

            .ai-orb img {
                width: 23px;
                height: 23px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body>

    <!-- =========================================================
         CANVAS
    ========================================================== -->
    <canvas id="data-canvas"></canvas>

    <!-- =========================================================
         CONTENU
    ========================================================== -->
    <div class="overlay">
        <div class="main-container">

            <!-- =====================================================
                 🖼️ LOGO AFFICHÉ TEL QUEL
            ====================================================== -->
            <div class="logo-area animate__animated animate__fadeInDown">

                <img src="{{ asset('Backend/assets/images/logo3.png') }}"
                    alt="Logo Ministère de l'Équipement et de l'Habitat" class="logo-img"
                    onerror="
                         this.style.display='none';
                         this.parentElement.insertAdjacentHTML(
                             'beforeend',
                             '<i class=\'fa-solid fa-landmark-flag logo-fallback\'></i>'
                         );
                     ">

                <div class="institution-hero">

                    <div class="institution-hero-title">
                        Direction Générale des Ponts et Chaussées
                    </div>
                </div>

            </div>

            <!-- =====================================================
                 EN-TÊTE
            ====================================================== -->
            <header class="header animate__animated animate__fadeInDown">

                <div class="system-label">
                    <i class="fa-solid fa-location-dot"></i>
                    SIG — Signalisation Routière
                </div>

                <h1 class="title">
                    Gestion de la
                    <span class="highlight-amber">signalisation verticale</span>
                    <span class="highlight-blue">routière</span>
                </h1>

                <p class="subtitle">
                    Plateforme numérique unifiée pour l'inventaire des panneaux,
                    le suivi de leur cycle de vie et le contrôle de leur conformité
                    aux normes nationales : matériaux, films rétroréfléchissants,
                    règles d'implantation et sécurité passive.
                </p>

            </header>

            <!-- =====================================================
                 BADGES
            ====================================================== -->
            <div class="stats-badge animate__animated animate__fadeInUp">
                <div class="stat-item">
                    <i class="fa-solid fa-sign-hanging"></i>
                    Inventaire des panneaux
                </div>
                <div class="stat-item">
                    <i class="fa-solid fa-magnifying-glass-location"></i>
                    Inspection terrain
                </div>
                <div class="stat-item">
                    <i class="fa-solid fa-clipboard-check"></i>
                    Contrôle conformité CCTP
                </div>
                <div class="stat-item">
                    <i class="fa-solid fa-calendar-xmark"></i>
                    Alertes fin de garantie
                </div>
            </div>

            <!-- =====================================================
                 CARTES
            ====================================================== -->
            <div class="row g-4 justify-content-center">

                <div class="col-xl-3 col-md-6 col-12">
                    <div class="feature-card animate__animated animate__fadeInUp" data-num="01">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-sign-hanging"></i>
                        </div>
                        <div class="feature-title">Inventaire des panneaux</div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12">
                    <div class="feature-card blue-accent animate__animated animate__fadeInUp" data-num="02">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-magnifying-glass-location"></i>
                        </div>
                        <div class="feature-title">Inspection terrain</div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12">
                    <div class="feature-card green-accent animate__animated animate__fadeInUp" data-num="03">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div class="feature-title">Contrôle conformité CCTP</div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12">
                    <div class="feature-card red-accent animate__animated animate__fadeInUp" data-num="04">
                        <div class="feature-icon-wrapper">
                            <i class="fa-solid fa-calendar-xmark"></i>
                        </div>
                        <div class="feature-title">Alertes &amp; cycle de vie</div>
                    </div>
                </div>

            </div>

            <!-- =====================================================
                 BANDEAU TECHNIQUE
            ====================================================== -->
            <div class="cctp-strip">
                <div class="spec">
                    <i class="fa-solid fa-database"></i>
                    Base patrimoniale
                </div>
                <div class="spec">
                    <i class="fa-solid fa-map-location-dot"></i>
                    Données géolocalisées
                </div>
                <div class="spec">
                    <i class="fa-solid fa-mobile-screen-button"></i>
                    Collecte terrain
                </div>
                <div class="spec">
                    <i class="fa-solid fa-shield-halved"></i>
                    Contrôle qualité
                </div>
            </div>

            <!-- =====================================================
                 CONNEXION
            ====================================================== -->
            <div class="login-section animate__animated animate__zoomIn">

                <div class="login-caption">
                    <i class="fa-solid fa-lock me-1"></i>
                    Accès sécurisé
                </div>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('all.dashboard') }}" class="btn-login">
                            <span>Accéder au tableau de bord</span>
                            <i class="fa-solid fa-table-columns"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">
                            <span>Portail d'accès techniciens</span>
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        </a>
                    @endauth
                @endif

            </div>

            <!-- =====================================================
                 FOOTER
            ====================================================== -->
            <footer class="footer">
                <div>
                    <i class="fa-solid fa-landmark-flag me-1"></i>
                    Ministère de l'Équipement et de l'Habitat
                    <span class="mx-1">•</span>
                    <strong>Direction Générale des Ponts et Chaussées</strong>
                </div>
                <small>
                    Système d'inventaire et de contrôle de conformité
                    de la signalisation verticale — CCTP DGPC
                </small>
            </footer>

        </div>
    </div>



    <!-- =========================================================
         JAVASCRIPT
    ========================================================== -->
    <script>
        const canvas = document.getElementById('data-canvas');
        const ctx = canvas.getContext('2d');

        let particles = [];
        const PARTICLE_COUNT = 30;

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        class Particle {
            constructor() {
                this.reset(true);
            }

            reset(initial = false) {
                this.x = Math.random() * canvas.width;
                this.y = initial ?
                    Math.random() * canvas.height :
                    canvas.height + Math.random() * 80;
                this.size = Math.random() * 1.8 + 0.6;
                this.speed = Math.random() * 0.35 + 0.08;
                this.opacity = Math.random() * 0.25 + 0.08;
            }

            update() {
                this.y -= this.speed;
                if (this.y < -10) {
                    this.reset();
                }
            }

            draw() {
                ctx.beginPath();
                ctx.fillStyle = `rgba(245,158,11,${this.opacity})`;
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function initParticles() {
            particles = [];
            for (let i = 0; i < PARTICLE_COUNT; i++) {
                particles.push(new Particle());
            }
        }

        function animateParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });
            requestAnimationFrame(animateParticles);
        }

        resizeCanvas();
        initParticles();
        animateParticles();

        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                resizeCanvas();
                initParticles();
            }, 150);
        });
    </script>

</body>

</html>
