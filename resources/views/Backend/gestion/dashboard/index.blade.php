@extends('template.admin_master')

@section('Content')
@auth

<style>
    /* ============================================
       STYLES MODERNES — VERSION LUXE
    ============================================ */
    :root {
        --primary: #4f46e5;
        --primary-dark: #3730a3;
        --primary-light: #818cf8;
        --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #a855f7 100%);
        --primary-gradient-subtle: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(124, 58, 237, 0.08));
        --secondary: #1e293b;
        --success: #22c55e;
        --warning: #eab308;
        --danger: #ef4444;
        --info: #3b82f6;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -1px rgba(0, 0, 0, 0.04);
        --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
        --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.10), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --radius: 16px;
        --radius-lg: 20px;
        --radius-xl: 28px;
        --radius-full: 9999px;
        --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== OVERLAY SUR TOUTE LA PAGE ===== */
    .page-wrapper::before {
        content: '';
        position: fixed;
        inset: 0;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.75) 0%, rgba(30, 27, 75, 0.65) 50%, rgba(15, 23, 42, 0.80) 100%);
        z-index: 0;
    }

    .page-wrapper {
        position: relative;
        min-height: 100vh;
        background: url("{{ asset('backend/assets/images/img1.jpg') }}") center/cover fixed no-repeat;
    }

    .page-wrapper > * {
        position: relative;
        z-index: 1;
    }

    /* ============================================
       MAIN CONTENT
    ============================================ */
    .main-content {
        flex: 1;
        padding: 40px 40px 60px;
        max-width: 1440px;
        margin: 0 auto;
        width: 100%;
        position: relative;
        z-index: 1;
    }

    /* ============================================
       HERO SECTION
    ============================================ */
    .test-section {
        border-radius: var(--radius-xl);
        padding: 48px 56px;
        margin-bottom: 48px;
        position: relative;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
    }

    .test-section .hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
    }

    .test-section .hero-text {
        color: white;
    }

    .test-section .hero-text .badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        padding: 6px 20px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
    }

    .test-section .hero-text .badge i {
        color: #818cf8;
    }

    .test-section .hero-text h1 {
        font-size: 2.6rem;
        font-weight: 900;
        color: white;
        line-height: 1.2;
        margin-bottom: 12px;
        text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
    }

    .test-section .hero-text h1 span {
        background: linear-gradient(135deg, #818cf8 0%, #c084fc 50%, #f472b6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .test-section .hero-text p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.05rem;
        max-width: 520px;
        line-height: 1.8;
        text-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    }

    /* ============================================
       STATS CARDS
    ============================================ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 24px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius);
        padding: 16px 18px;
        text-align: center;
        transition: var(--transition);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 3px;
        background: var(--primary-gradient);
        transition: var(--transition);
        border-radius: var(--radius-full);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }

    .stat-card:hover::after {
        width: 60%;
    }

    .stat-card .stat-icon {
        font-size: 1.4rem;
        margin-bottom: 4px;
        display: block;
    }

    .stat-card .stat-number {
        font-size: 1.6rem;
        font-weight: 900;
        display: block;
        line-height: 1.2;
        color: white;
    }

    .stat-card .stat-label {
        font-size: 0.68rem;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 600;
    }

    .stat-card.purple .stat-icon  { color: #a78bfa; }
    .stat-card.blue   .stat-icon  { color: #60a5fa; }
    .stat-card.green  .stat-icon  { color: #4ade80; }
    .stat-card.orange .stat-icon  { color: #fbbf24; }
    .stat-card.red    .stat-icon  { color: #f87171; }
    .stat-card.yellow .stat-icon  { color: #facc15; }
    .stat-card.crimson .stat-icon { color: #f43f5e; }
    .stat-card.teal   .stat-icon  { color: #14b8a6; }

    /* ============================================
       SECTION TITLE
    ============================================ */
    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 40px 0 24px 0;
    }

    .section-title .title-line {
        flex: 1;
        height: 2px;
        background: linear-gradient(to left, rgba(255, 255, 255, 0.15), transparent);
    }

    .section-title .title-text {
        font-size: 1.1rem;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }

    .section-title .title-text i {
        color: #818cf8;
    }

    .section-title .title-badge {
        background: rgba(255, 255, 255, 0.10);
        color: #a78bfa;
        padding: 2px 14px;
        border-radius: var(--radius-full);
        font-size: 0.6rem;
        font-weight: 700;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* ============================================
       FEATURED CARDS
    ============================================ */
    .featured-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .featured-card {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: var(--radius-lg);
        padding: 32px 28px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: var(--transition);
        text-decoration: none;
        color: inherit;
        position: relative;
        overflow: hidden;
        text-align: center;
        display: block;
    }

    .featured-card:hover {
        transform: translateY(-8px);
        background: rgba(255, 255, 255, 0.12);
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.3);
    }

    .featured-card .card-icon {
        width: 72px;
        height: 72px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 16px;
        transition: var(--transition);
        background: rgba(255, 255, 255, 0.08);
    }

    .featured-card:hover .card-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .featured-card .card-icon.blue   { color: #60a5fa; }
    .featured-card .card-icon.green  { color: #4ade80; }
    .featured-card .card-icon.orange { color: #fbbf24; }

    .featured-card .card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 6px;
    }

    .featured-card .card-desc {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.6;
    }

    .featured-card .card-tags {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 14px;
        flex-wrap: wrap;
    }

    .featured-card .card-tags .tag {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.7);
        background: rgba(255, 255, 255, 0.06);
        padding: 3px 12px;
        border-radius: var(--radius-full);
    }

    .featured-card .card-arrow {
        display: inline-block;
        margin-top: 16px;
        padding: 6px 24px;
        border-radius: var(--radius-full);
        background: var(--primary-gradient);
        color: white;
        font-weight: 700;
        font-size: 0.8rem;
        opacity: 0;
        transform: translateY(10px);
        transition: var(--transition);
    }

    .featured-card:hover .card-arrow {
        opacity: 1;
        transform: translateY(0);
    }

    /* ============================================
       MENU GRID
    ============================================ */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    .menu-card {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-radius: var(--radius);
        padding: 24px 20px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        transition: var(--transition);
        text-decoration: none;
        color: inherit;
        text-align: center;
        position: relative;
        overflow: hidden;
        display: block;
    }

    .menu-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary-gradient);
        opacity: 0;
        transition: var(--transition);
    }

    .menu-card:hover {
        transform: translateY(-6px);
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }

    .menu-card:hover::before {
        opacity: 1;
    }

    .menu-card .icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin: 0 auto 12px;
        transition: var(--transition);
        background: rgba(255, 255, 255, 0.06);
    }

    .menu-card:hover .icon {
        transform: scale(1.1);
    }

    .menu-card .icon.purple { color: #a78bfa; }
    .menu-card .icon.blue   { color: #60a5fa; }
    .menu-card .icon.green  { color: #4ade80; }
    .menu-card .icon.amber  { color: #fbbf24; }
    .menu-card .icon.rose   { color: #f472b6; }
    .menu-card .icon.indigo { color: #818cf8; }
    .menu-card .icon.cyan   { color: #22d3ee; }
    .menu-card .icon.slate  { color: #94a3b8; }

    .menu-card .title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #fff;
    }

    .menu-card .badge-count {
        display: inline-block;
        margin-top: 8px;
        padding: 2px 14px;
        border-radius: var(--radius-full);
        font-size: 0.6rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.7);
    }

    .menu-card .badge-count.primary { color: #60a5fa; }
    .menu-card .badge-count.success { color: #4ade80; }
    .menu-card .badge-count.warning { color: #fbbf24; }
    .menu-card .badge-count.danger  { color: #f87171; }

    /* ============================================
       RESPONSIVE — TABLETTE & MOBILE
    ============================================ */

    @media (max-width: 1400px) {
        .stats-grid { grid-template-columns: repeat(3, 1fr); }
    }

    /* TABLETTE (≤992px) */
    @media (max-width: 992px) {
        .main-content { padding: 28px 24px 48px; }
        .test-section { padding: 36px 32px; border-radius: var(--radius-lg); }
        .test-section .hero-text h1 { font-size: 2.1rem; }
        .test-section .hero-text p { font-size: 0.95rem; }
        .featured-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .stats-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .stat-card { padding: 14px 12px; }
        .stat-card .stat-number { font-size: 1.35rem; }
        .stat-card .stat-label { font-size: 0.62rem; }
        .stat-card .stat-icon { font-size: 1.2rem; }
        .section-title { margin: 32px 0 18px 0; }
        .section-title .title-text { font-size: 1rem; }
        .featured-card { padding: 26px 22px; }
        .featured-card .card-icon { width: 64px; height: 64px; font-size: 1.7rem; }
        .menu-grid { grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 12px; }
        .menu-card { padding: 20px 16px; }
        .menu-card .icon { width: 50px; height: 50px; font-size: 1.4rem; }
    }

    /* SMARTPHONE (≤768px) */
    @media (max-width: 768px) {
        .main-content { padding: 16px 14px 40px; }

        .test-section {
            padding: 26px 18px;
            border-radius: var(--radius);
            margin-bottom: 28px;
        }
        .test-section .hero-text .badge {
            font-size: 0.62rem;
            padding: 5px 14px;
            margin-bottom: 12px;
        }
        .test-section .hero-text h1 {
            font-size: 1.65rem;
            line-height: 1.25;
            margin-bottom: 10px;
        }
        .test-section .hero-text p {
            font-size: 0.86rem;
            line-height: 1.65;
            max-width: 100%;
        }

        /* STATS — 2 colonnes */
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: 20px;
        }
        .stat-card { padding: 12px 10px; border-radius: 12px; }
        .stat-card .stat-icon { font-size: 1.1rem; margin-bottom: 2px; }
        .stat-card .stat-number { font-size: 1.15rem; }
        .stat-card .stat-label { font-size: 0.58rem; line-height: 1.2; }

        .section-title { margin: 26px 0 14px 0; gap: 8px; }
        .section-title .title-text { font-size: 0.92rem; gap: 8px; }
        .section-title .title-badge { display: none; }
        .section-title .title-line { height: 1px; }

        .featured-grid {
            grid-template-columns: 1fr;
            gap: 12px;
            max-width: 100%;
        }
        .featured-card {
            padding: 22px 18px;
            border-radius: 16px;
        }
        .featured-card .card-icon {
            width: 60px;
            height: 60px;
            font-size: 1.6rem;
            margin-bottom: 12px;
        }
        .featured-card .card-title { font-size: 1rem; }
        .featured-card .card-desc { font-size: 0.8rem; }
        .featured-card .card-arrow {
            opacity: 1;
            transform: translateY(0);
            margin-top: 14px;
            font-size: 0.75rem;
            padding: 6px 18px;
        }
        .featured-card:hover { transform: none; }
        .featured-card:active {
            transform: scale(0.98);
            background: rgba(255, 255, 255, 0.12);
        }

        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .menu-card {
            padding: 18px 12px;
            border-radius: 14px;
        }
        .menu-card .icon {
            width: 44px;
            height: 44px;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .menu-card .title { font-size: 0.82rem; }
        .menu-card .badge-count {
            font-size: 0.55rem;
            padding: 2px 10px;
            margin-top: 6px;
        }
        .menu-card:hover { transform: none; }
        .menu-card:active { transform: scale(0.97); }

        .stat-card,
        .featured-card,
        .menu-card {
            animation-duration: 0.4s;
        }
    }

    /* TRÈS PETIT (≤480px) */
    @media (max-width: 480px) {
        .main-content { padding: 12px 12px 36px; }

        .test-section { padding: 22px 14px; }
        .test-section .hero-text h1 { font-size: 1.4rem; }
        .test-section .hero-text p { font-size: 0.8rem; }
        .test-section .hero-text .badge {
            font-size: 0.58rem;
            padding: 4px 12px;
        }

        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 6px; }
        .stat-card { padding: 10px 8px; }
        .stat-card .stat-number { font-size: 1rem; }
        .stat-card .stat-label { font-size: 0.52rem; }
        .stat-card .stat-icon { font-size: 1rem; }

        .menu-grid {
            grid-template-columns: 1fr;
            max-width: 100%;
            gap: 8px;
        }
        .menu-card {
            padding: 16px 14px;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 12px;
            text-align: left;
        }
        .menu-card .icon {
            width: 42px;
            height: 42px;
            font-size: 1.1rem;
            margin: 0;
            flex-shrink: 0;
        }
        .menu-card .title { font-size: 0.85rem; flex: 1; }
        .menu-card .badge-count {
            margin: 0;
            flex-shrink: 0;
        }

        .featured-card { padding: 20px 16px; }
        .featured-card .card-icon { width: 54px; height: 54px; font-size: 1.4rem; }
        .featured-card .card-title { font-size: 0.92rem; }
        .featured-card .card-desc { font-size: 0.76rem; }
        .featured-card .card-tags { gap: 6px; }
        .featured-card .card-tags .tag { font-size: 0.6rem; padding: 2px 10px; }

        .section-title .title-text { font-size: 0.85rem; }
        .section-title .title-text i { font-size: 0.9rem; }
    }

    /* PAYSAGE MOBILE */
    @media (max-width: 900px) and (orientation: landscape) {
        .main-content { padding: 20px 20px 40px; }
        .test-section { padding: 24px 28px; }
        .test-section .hero-text h1 { font-size: 1.6rem; }
        .stats-grid { grid-template-columns: repeat(3, 1fr); gap: 8px; }
        .featured-grid { grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .menu-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; }
    }

    /* ============================================
       ANIMATIONS
    ============================================ */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .test-section,
    .stat-card,
    .featured-card,
    .menu-card {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .test-section { animation-duration: 0.7s; }

    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.10s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.20s; }
    .stat-card:nth-child(5) { animation-delay: 0.25s; }
    .stat-card:nth-child(6) { animation-delay: 0.30s; }

    .featured-card:nth-child(1) { animation-delay: 0.10s; }
    .featured-card:nth-child(2) { animation-delay: 0.15s; }
    .featured-card:nth-child(3) { animation-delay: 0.20s; }

    .menu-card:nth-child(1) { animation-delay: 0.05s; }
    .menu-card:nth-child(2) { animation-delay: 0.10s; }
    .menu-card:nth-child(3) { animation-delay: 0.15s; }
    .menu-card:nth-child(4) { animation-delay: 0.20s; }
    .menu-card:nth-child(5) { animation-delay: 0.25s; }
    .menu-card:nth-child(6) { animation-delay: 0.30s; }

    @media (prefers-reduced-motion: reduce) {
        .test-section,
        .stat-card,
        .featured-card,
        .menu-card {
            animation: none;
            opacity: 1;
        }
    }
</style>

<div class="content">
    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">

        <!-- ===== HERO SECTION ===== -->
        <section class="test-section">
            <div class="hero-content">
                <div class="hero-text">
                    <div class="badge">
                        <i class="fa-solid fa-gauge-high"></i>
                        Tableau de bord principal
                    </div>
                    <h1>
                        Bienvenue dans <br>
                        <span>l'application de gestion de la signalisation verticale</span>
                    </h1>
                </div>

                <!-- ===== STATS CARDS ===== -->
                <div class="stats-grid">

                    {{-- ✅ Total panneaux --}}
                    <div class="stat-card purple" onclick="window.location='{{ route('signalisation.index') }}'">
                        <span class="stat-icon"><i class="fa-solid fa-sign-hanging"></i></span>
                        <span class="stat-number">{{ number_format($totalPanneaux, 0, ',', ' ') }}</span>
                        <span class="stat-label">Panneaux total</span>
                    </div>

                    {{-- ✅ Total observations --}}
                    <div class="stat-card orange" onclick="window.location='{{ route('signalisation.index') }}'">
                        <span class="stat-icon"><i class="fa-solid fa-clipboard-check"></i></span>
                        <span class="stat-number">{{ number_format($totalObservations, 0, ',', ' ') }}</span>
                        <span class="stat-label">Observations</span>
                    </div>

                    {{-- ✅ Bon état --}}
                    <div class="stat-card green" onclick="window.location='{{ route('signalisation.index') }}?etat_actuel=Bon'">
                        <span class="stat-icon"><i class="fa-solid fa-circle-check"></i></span>
                        <span class="stat-number">{{ number_format($totalBon, 0, ',', ' ') }}</span>
                        <span class="stat-label">Bon état</span>
                    </div>

                    {{-- ✅ Dégradés --}}
                    <div class="stat-card yellow" onclick="window.location='{{ route('signalisation.index') }}?etat_actuel=Dégradé'">
                        <span class="stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></span>
                        <span class="stat-number">{{ number_format($totalDegrade, 0, ',', ' ') }}</span>
                        <span class="stat-label">Dégradés</span>
                    </div>

                    {{-- ✅ Vandalisés --}}
                    <div class="stat-card crimson" onclick="window.location='{{ route('signalisation.index') }}?etat_actuel=Vandalisé'">
                        <span class="stat-icon"><i class="fa-solid fa-spray-can"></i></span>
                        <span class="stat-number">{{ number_format($totalVandal, 0, ',', ' ') }}</span>
                        <span class="stat-label">Vandalisés</span>
                    </div>

                    {{-- ✅ Masqués --}}
                    <div class="stat-card teal" onclick="window.location='{{ route('signalisation.index') }}?etat_actuel=Masqué'">
                        <span class="stat-icon"><i class="fa-solid fa-eye-slash"></i></span>
                        <span class="stat-number">{{ number_format($totalMasque, 0, ',', ' ') }}</span>
                        <span class="stat-label">Masqués</span>
                    </div>

                </div>
            </div>
        </section>

        <!-- ============================================ -->
        <!-- SECTION: SUIVI PRINCIPAL                     -->
        <!-- ============================================ -->
        <div class="section-title">
            <span class="title-text">
                <i class="fa-solid fa-folder-tree"></i>
                Suivi principal
                <span class="title-badge">Signalisation routière</span>
            </span>
            <span class="title-line"></span>
        </div>

        <div class="featured-grid">
            <a href="{{ route('signalisation.index') }}" class="featured-card">
                <div class="card-icon blue"><i class="fa-solid fa-sign-hanging"></i></div>
                <h3 class="card-title">Signalisation verticale</h3>
                <p class="card-desc">Inventaire complet des panneaux, de leurs dimensions et de leurs caractéristiques CCTP.</p>
                <div class="card-tags">
                    <span class="tag"><i class="fa-solid fa-check"></i> {{ $totalPanneaux }} panneaux</span>
                    <span class="tag"><i class="fa-solid fa-check"></i> {{ $totalRoutes }} routes</span>
                </div>
                <span class="card-arrow"><i class="fa-solid fa-arrow-right"></i> Consulter</span>
            </a>

            <a href="{{ route('signalisation.index') }}" class="featured-card">
                <div class="card-icon green"><i class="fa-solid fa-clipboard-check"></i></div>
                <h3 class="card-title">Observations &amp; inspections</h3>
                <p class="card-desc">Suivi des inspections, de l'état des panneaux et des classes de rétroréflexion.</p>
                <div class="card-tags">
                    <span class="tag"><i class="fa-solid fa-check"></i> {{ $totalObservations }} observations</span>
                    <span class="tag"><i class="fa-solid fa-check"></i> {{ $tauxCouverture }}% couverture</span>
                </div>
                <span class="card-arrow"><i class="fa-solid fa-arrow-right"></i> Consulter</span>
            </a>

            <a href="{{ route('carte.index') }}" class="featured-card">
                <div class="card-icon orange"><i class="fa-solid fa-map-location-dot"></i></div>
                <h3 class="card-title">Cartographie</h3>
                <p class="card-desc">Visualisation géographique de la signalisation sur l'ensemble du réseau routier.</p>
                <div class="card-tags">
                    <span class="tag"><i class="fa-solid fa-check"></i> {{ $totalGeoloc }} points</span>
                    <span class="tag"><i class="fa-solid fa-check"></i> Carte interactive</span>
                </div>
                <span class="card-arrow"><i class="fa-solid fa-arrow-right"></i> Consulter</span>
            </a>
        </div>

        <div style="height: 40px;"></div>

        <!-- ============================================ -->
        <!-- SECTION: GRAPHIQUES                          -->
        <!-- ============================================ -->
        <div class="section-title">
            <span class="title-text">
                <i class="fa-solid fa-chart-pie"></i>
                Analyses et statistiques
                <span class="title-badge">Répartitions</span>
            </span>
            <span class="title-line"></span>
        </div>

        <div class="featured-grid">
            <a href="#" class="featured-card">
                <div class="card-icon blue"><i class="fa-solid fa-chart-bar"></i></div>
                <h3 class="card-title">Par dimensions</h3>
                <p class="card-desc">Répartition des panneaux selon leurs dimensions CCTP.</p>
                <div class="card-tags">
                    <span class="tag"><i class="fa-solid fa-check"></i> Top 10</span>
                </div>
                <span class="card-arrow"><i class="fa-solid fa-arrow-right"></i> Voir</span>
            </a>

            <a href="#" class="featured-card">
                <div class="card-icon green"><i class="fa-solid fa-circle-nodes"></i></div>
                <h3 class="card-title">Par nature de matériau</h3>
                <p class="card-desc">Analyse des matériaux utilisés pour la fabrication.</p>
                <div class="card-tags">
                    <span class="tag"><i class="fa-solid fa-check"></i> {{ $totalNatures }} types</span>
                </div>
                <span class="card-arrow"><i class="fa-solid fa-arrow-right"></i> Voir</span>
            </a>

            <a href="#" class="featured-card">
                <div class="card-icon orange"><i class="fa-solid fa-heart-pulse"></i></div>
                <h3 class="card-title">État des panneaux</h3>
                <p class="card-desc">Répartition selon l'état actuel (Bon, Dégradé, Vandalisé, Masqué).</p>
                <div class="card-tags">
                    <span class="tag"><i class="fa-solid fa-check"></i> {{ $totalObservations }} données</span>
                </div>
                <span class="card-arrow"><i class="fa-solid fa-arrow-right"></i> Voir</span>
            </a>
        </div>

        <div style="height: 40px;"></div>

        <!-- ===== SECTION: ADMINISTRATION ===== -->
        <div class="section-title">
            <span class="title-text">
                <i class="fa-solid fa-gauge-high"></i>
                Administration
            </span>
            <span class="title-line"></span>
        </div>

        <div class="menu-grid">

            <a href="{{ route('dashboard') }}" class="menu-card">
                <div class="icon purple">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
                <div class="title">Tableau de bord</div>
                <span class="badge-count primary">Principal</span>
            </a>

            <a href="{{ route('all.user') }}" class="menu-card">
                <div class="icon blue">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <div class="title">Utilisateurs</div>
                <span class="badge-count primary">
                    {{ count(App\Models\User::all()) }}
                </span>
            </a>

            <a href="{{ route('all.permission') }}" class="menu-card">
                <div class="icon amber">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="title">Permissions</div>
                <span class="badge-count warning">Gestion</span>
            </a>

            <a href="{{ route('all.roles') }}" class="menu-card">
                <div class="icon indigo">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="title">Rôles</div>
                <span class="badge-count primary">Gestion</span>
            </a>

            <a href="{{ route('all.roles.permission') }}" class="menu-card">
                <div class="icon rose">
                    <i class="fa-solid fa-key"></i>
                </div>
                <div class="title">Permissions par rôle</div>
                <span class="badge-count warning">Gestion</span>
            </a>

            <a href="#" class="menu-card">
                <div class="icon slate">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <div class="title">Paramètres</div>
                <span class="badge-count">Personnalisation</span>
            </a>

        </div>

        <!-- ===== SECTION: SIGNALISATION ===== -->
        <div class="section-title">
            <span class="title-text">
                <i class="fa-solid fa-sign-hanging"></i>
                Signalisation
            </span>
            <span class="title-line"></span>
        </div>

        <div class="menu-grid">
            <a href="{{ route('signalisation.index') }}" class="menu-card">
                <div class="icon green"><i class="fa-solid fa-list"></i></div>
                <div class="title">Tous les panneaux</div>
                <span class="badge-count success">{{ $totalPanneaux }}</span>
            </a>

            <a href="{{ route('signalisation.index') }}" class="menu-card">
                <div class="icon blue"><i class="fa-solid fa-road"></i></div>
                <div class="title">Par route</div>
                <span class="badge-count primary">{{ $totalRoutes }}</span>
            </a>

            <a href="{{ route('signalisation.index') }}" class="menu-card">
                <div class="icon amber"><i class="fa-solid fa-layer-group"></i></div>
                <div class="title">Par nature</div>
                <span class="badge-count warning">{{ $totalNatures }}</span>
            </a>

            <a href="{{ route('signalisation.index') }}" class="menu-card">
                <div class="icon cyan"><i class="fa-solid fa-clipboard-check"></i></div>
                <div class="title">Observations</div>
                <span class="badge-count primary">{{ $totalObservations }}</span>
            </a>
        </div>

    </main>
</div>

@else
<script>
    window.location.href = "{{ route('login') }}";
</script>
@endauth
@endsection