<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Carte des panneaux</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <style>
    html, body { width: 100%; height: 100%; margin: 0; padding: 0; overflow: hidden; }
    body { font-family: 'Inter', sans-serif; background: #F8FAFC; }

    .carte-page {
        padding: 0;
        background: #F8FAFC !important;
        height: 100vh !important;
        height: 100dvh !important;
        display: flex; flex-direction: column;
        font-family: 'Inter', sans-serif;
        color: #0F172A !important;
        overflow: hidden; position: relative;
    }

    .carte-topbar {
        padding: 12px 20px;
        background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%);
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px; flex-wrap: wrap;
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.25);
        z-index: 100; flex-shrink: 0;
    }
    .topbar-left { display: flex; align-items: center; gap: 14px; }
    .topbar-icon {
        width: 42px; height: 42px;
        background: rgba(255, 255, 255, 0.98);
        border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .topbar-icon i { font-size: 1.2rem; color: #2563EB; }
    .topbar-title { font-size: 1.05rem; font-weight: 800; color: #fff !important; margin: 0; line-height: 1.2; }
    .topbar-subtitle { font-size: 0.75rem; color: rgba(255, 255, 255, 0.85) !important; margin: 0; }

    .topbar-center { flex: 1; max-width: 320px; min-width: 200px; position: relative; }
    .topbar-center input {
        width: 100%; padding: 9px 14px 9px 36px;
        border: none; border-radius: 10px;
        font-size: 0.82rem;
        background: rgba(255, 255, 255, 0.95);
        color: #0F172A !important;
        transition: all 0.15s ease;
    }
    .topbar-center input:focus { outline: none; box-shadow: 0 0 0 3px rgba(255,255,255,0.35); }
    .topbar-center i {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%);
        color: #64748B; font-size: 0.8rem;
    }

    .topbar-right { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-topbar {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 14px; border-radius: 9px;
        font-size: 0.78rem; font-weight: 600;
        text-decoration: none; transition: all 0.2s ease;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.15);
        color: #fff !important;
        border: 1.5px solid rgba(255, 255, 255, 0.25);
    }
    .btn-topbar:hover { background: rgba(255, 255, 255, 0.25); color: #fff !important; }
    .btn-topbar-primary {
        background: rgba(255, 255, 255, 0.95);
        color: #1E40AF !important; border: none;
    }
    .btn-topbar-primary:hover { background: #fff; color: #1E40AF !important; transform: translateY(-1px); }
    .btn-topbar-success {
        background: linear-gradient(135deg, #059669, #10B981);
        color: #fff !important; border: none;
        box-shadow: 0 2px 6px rgba(5,150,105,0.35);
    }
    .btn-topbar-success:hover { background: linear-gradient(135deg, #047857, #059669); color: #fff !important; transform: translateY(-1px); }
    .btn-topbar-filter-active {
        background: rgba(255,255,255,0.95) !important;
        color: #1E40AF !important;
        border: none !important;
    }

    .carte-kpibar {
        display: flex; gap: 8px; padding: 10px 20px;
        background: #fff; border-bottom: 1px solid #E2E8F0;
        overflow-x: auto; flex-shrink: 0;
        box-shadow: 0 1px 3px rgba(15,23,42,0.04);
        z-index: 99; -webkit-overflow-scrolling: touch;
    }
    .carte-kpibar::-webkit-scrollbar { height: 4px; }
    .carte-kpibar::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 2px; }

    .kpi-chip {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 6px 12px; border-radius: 100px;
        font-size: 0.75rem; font-weight: 700;
        background: #F1F5F9; color: #475569 !important;
        border: 1.5px solid transparent;
        cursor: pointer; transition: all 0.15s ease;
        white-space: nowrap; flex-shrink: 0;
    }
    .kpi-chip:hover { background: #E2E8F0; }
    .kpi-chip.active { background: #EFF6FF; color: #1E40AF !important; border-color: #2563EB; }
    .kpi-chip .chip-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .kpi-chip .chip-count {
        padding: 1px 7px; border-radius: 100px;
        background: rgba(15,23,42,0.08);
        font-weight: 800; font-size: 0.7rem;
    }
    .kpi-chip.active .chip-count { background: rgba(37,99,235,0.15); }

    .carte-main { flex: 1; position: relative; overflow: hidden; }
    #carte-globale { width: 100%; height: 100%; background: #F1F5F9; }

    /* FILTRES AVANCÉS */
    .filters-panel {
        position: absolute;
        top: 16px;
        left: 16px;
        width: 320px;
        max-width: calc(100vw - 32px);
        max-height: calc(100% - 32px);
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 14px;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.18);
        border: 1px solid #E2E8F0;
        z-index: 1100;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform: translateX(-120%);
        transition: transform 0.35s cubic-bezier(0.2, 0.9, 0.3, 1);
        font-family: 'Inter', sans-serif;
    }
    .filters-panel.open { transform: translateX(0); }

    .filters-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: linear-gradient(135deg, #1E40AF, #2563EB);
        color: #fff;
        font-size: 0.85rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    .filters-header i { font-size: 0.9rem; }
    .filters-result-count {
        background: rgba(255,255,255,0.2);
        padding: 2px 8px;
        border-radius: 100px;
        font-size: 0.68rem;
        font-weight: 700;
    }
    .filters-close {
        width: 28px; height: 28px;
        border-radius: 7px;
        background: rgba(255,255,255,0.15);
        border: none; color: #fff;
        cursor: pointer; transition: all 0.15s ease;
        display: flex; align-items: center; justify-content: center;
    }
    .filters-close:hover { background: rgba(255,255,255,0.3); }

    .filters-body {
        padding: 16px;
        overflow-y: auto;
        flex: 1;
    }
    .filters-body::-webkit-scrollbar { width: 5px; }
    .filters-body::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }

    .filter-group { margin-bottom: 14px; }
    .filter-group:last-child { margin-bottom: 0; }

    .filter-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }
    .filter-label i { color: #2563EB; font-size: 0.75rem; }

    .filter-select,
    .filter-input {
        width: 100%;
        padding: 8px 12px;
        border: 1.5px solid #E2E8F0;
        border-radius: 8px;
        font-size: 0.82rem;
        font-family: 'Inter', sans-serif;
        background: #fff;
        color: #0F172A;
        transition: all 0.15s ease;
        box-sizing: border-box;
    }
    .filter-select:focus,
    .filter-input:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none;
    }
    .filter-select {
        padding-right: 30px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748B' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        appearance: none;
        -webkit-appearance: none;
    }

    .filters-footer {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        padding: 12px 16px;
        background: #F8FAFC;
        border-top: 1px solid #E2E8F0;
        flex-shrink: 0;
    }
    .filters-btn-reset,
    .filters-btn-apply {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 12px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }
    .filters-btn-reset { background: #F1F5F9; color: #475569; }
    .filters-btn-reset:hover { background: #E2E8F0; color: #0F172A; }
    .filters-btn-apply {
        background: linear-gradient(135deg, #1E40AF, #2563EB);
        color: #fff;
        box-shadow: 0 2px 6px rgba(37,99,235,0.25);
    }
    .filters-btn-apply:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(37,99,235,0.35); }

    /* =========================================================
       ZONES LÉGENDE
       ========================================================= */
    .zones-legend {
        position: absolute;
        bottom: 30px;
        left: 16px;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.97);
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.18);
        border: 1px solid #E2E8F0;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        min-width: 200px;
        max-width: 260px;
        max-height: 50vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        font-family: 'Inter', sans-serif;
        transition: max-height 0.3s ease, width 0.3s ease;
    }

    .zones-legend-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        background: linear-gradient(135deg, #7C3AED, #A855F7);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 700;
        flex-shrink: 0;
        cursor: pointer;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
    }
    .zones-legend-header i { font-size: 0.85rem; }
    .zones-legend-header .legend-toggle-icon {
        margin-left: auto;
        transition: transform 0.3s ease;
        font-size: 0.75rem;
    }
    .zones-legend.collapsed .legend-toggle-icon {
        transform: rotate(-90deg);
    }
    .zones-legend.collapsed .zones-legend-body {
        max-height: 0 !important;
        padding: 0 !important;
        overflow: hidden;
    }

    .zones-legend-body {
        overflow-y: auto;
        padding: 6px 0;
        flex: 1;
        max-height: 400px;
        transition: max-height 0.3s ease, padding 0.3s ease;
    }
    .zones-legend-body::-webkit-scrollbar { width: 5px; }
    .zones-legend-body::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }

    .zones-legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 14px;
        font-size: 0.78rem;
        color: #0F172A;
        transition: background 0.15s ease;
    }
    .zones-legend-item:hover { background: #F5F3FF; }
    .zones-legend-color {
        width: 20px;
        height: 4px;
        border-radius: 2px;
        flex-shrink: 0;
        box-shadow: 0 0 0 1px rgba(255,255,255,0.9);
    }
    .zones-legend-name {
        flex: 1;
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .zones-legend-empty {
        padding: 14px;
        text-align: center;
        color: #94A3B8;
        font-size: 0.76rem;
        font-style: italic;
    }

    /* LEAFLET CONTROLS */
    .leaflet-control-layers {
        border-radius: 12px !important;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.15) !important;
        border: 1px solid #E2E8F0 !important;
        background: #fff !important;
    }
    .leaflet-control-layers-toggle { width: 42px !important; height: 42px !important; background-size: 22px 22px !important; border-radius: 10px !important; }
    .leaflet-control-layers-expanded { padding: 12px 14px !important; min-width: 160px !important; }
    .leaflet-control-layers-expanded label { display: flex !important; align-items: center !important; gap: 8px !important; padding: 6px 4px !important; cursor: pointer !important; border-radius: 6px !important; }
    .leaflet-control-layers-expanded label:hover { background: #EFF6FF !important; }
    .leaflet-control-layers-expanded input[type="radio"] { accent-color: #2563EB; cursor: pointer; }

    /* PLACEMENT */
    .placement-banner {
        position: absolute;
        top: 16px; left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #059669, #10B981);
        color: #fff; padding: 12px 20px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(5,150,105,0.4);
        z-index: 1500; display: none;
        align-items: center; gap: 12px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem; font-weight: 600;
        animation: bannerPulse 2s ease infinite;
    }
    .placement-banner.active { display: flex; }
    .placement-banner.moving {
        background: linear-gradient(135deg, #EA580C, #F97316);
        box-shadow: 0 8px 24px rgba(234,88,12,0.4);
    }
    .placement-banner i { font-size: 1.1rem; }
    .placement-banner .btn-cancel-placement {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff; padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.72rem; font-weight: 700;
        cursor: pointer; transition: all 0.2s ease;
    }
    .placement-banner .btn-cancel-placement:hover { background: rgba(255,255,255,0.35); }

    @keyframes bannerPulse {
        0%, 100% { transform: translateX(-50%) scale(1); }
        50%      { transform: translateX(-50%) scale(1.02); }
    }

    .temp-marker { background: transparent !important; border: none !important; }
    .temp-marker-inner {
        width: 40px; height: 40px;
        background: rgba(16, 185, 129, 0.25);
        border: 3px solid #10B981;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        animation: tempPulse 1.2s ease infinite;
        box-shadow: 0 4px 12px rgba(16,185,129,0.5);
    }
    .temp-marker-inner i { color: #059669; font-size: 1.2rem; }
    @keyframes tempPulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%      { transform: scale(1.15); opacity: 0.85; }
    }

    /* SLIDE PANEL */
    .slide-panel {
        position: absolute;
        top: 0; right: 0; bottom: 0;
        width: 420px; max-width: 92vw;
        background: #fff;
        box-shadow: -8px 0 32px rgba(15, 23, 42, 0.15);
        transform: translateX(100%);
        transition: transform 0.35s cubic-bezier(0.2, 0.9, 0.3, 1);
        z-index: 1000;
        display: flex; flex-direction: column;
        overflow: hidden;
        border-left: 1px solid #E2E8F0;
    }
    .slide-panel.open { transform: translateX(0); }
    .slide-header {
        padding: 16px 20px;
        background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%);
        display: flex; justify-content: space-between; align-items: center;
        color: #fff; flex-shrink: 0;
    }
    .slide-title { font-size: 0.9rem; font-weight: 800; margin: 0; color: #fff !important; display: flex; align-items: center; gap: 8px; }
    .slide-close {
        width: 32px; height: 32px; border-radius: 8px;
        background: rgba(255, 255, 255, 0.15);
        border: none; color: #fff; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.15s ease;
    }
    .slide-close:hover { background: rgba(255, 255, 255, 0.3); }
    .slide-body { flex: 1; overflow-y: auto; padding: 20px; }
    .slide-body::-webkit-scrollbar { width: 6px; }
    .slide-body::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
    .slide-empty { padding: 60px 20px; text-align: center; color: #94A3B8; font-size: 0.85rem; }
    .slide-empty i { font-size: 2.5rem; opacity: 0.35; display: block; margin-bottom: 12px; }

    .detail-svg-box {
        width: 100%; height: 150px;
        background: #F8FAFC; border: 1px solid #E2E8F0;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        padding: 16px; margin-bottom: 16px;
    }
    .detail-svg-box img { max-width: 100%; max-height: 100%; object-fit: contain; filter: drop-shadow(0 3px 6px rgba(15,23,42,0.15)); }
    .detail-code { font-size: 1.35rem; font-weight: 800; color: #1E40AF !important; margin: 0 0 4px; }
    .detail-name { font-size: 0.85rem; color: #64748B !important; margin: 0 0 14px; }
    .detail-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 10px 0; border-bottom: 1px dashed #E2E8F0;
        font-size: 0.82rem;
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-row .label { color: #94A3B8 !important; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.04em; }
    .detail-row .value { color: #0F172A !important; font-weight: 600; text-align: right; }

    .badge-etat {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 100px;
        font-size: 0.75rem; font-weight: 700;
    }
    .badge-etat::before { content: ''; width: 7px; height: 7px; border-radius: 50%; }
    .badge-etat.bon     { background: rgba(16,185,129,0.12); color: #059669 !important; }
    .badge-etat.bon::before { background: #059669; }
    .badge-etat.degrade { background: rgba(250,204,21,0.18); color: #B45309 !important; }
    .badge-etat.degrade::before { background: #B45309; }
    .badge-etat.vandal  { background: rgba(249,115,22,0.15); color: #EA580C !important; }
    .badge-etat.vandal::before { background: #EA580C; }
    .badge-etat.masque  { background: rgba(220,38,38,0.10); color: #DC2626 !important; }
    .badge-etat.masque::before { background: #DC2626; }
    .badge-etat.aucun   { background: rgba(148,163,184,0.15); color: #64748B !important; }
    .badge-etat.aucun::before { background: #94A3B8; }

    .slide-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 16px; }
    .btn-slide {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 10px 14px; border-radius: 10px;
        font-size: 0.8rem; font-weight: 700;
        text-decoration: none; transition: all 0.2s ease;
        cursor: pointer; border: none;
    }
    .btn-slide-primary { background: linear-gradient(135deg, #1E40AF, #2563EB); color: #fff !important; box-shadow: 0 2px 6px rgba(37,99,235,0.25); grid-column: span 2; }
    .btn-slide-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(37,99,235,0.35); color: #fff !important; }
    .btn-slide-success { background: linear-gradient(135deg, #059669, #10B981); color: #fff !important; box-shadow: 0 2px 6px rgba(5,150,105,0.25); grid-column: span 2; }
    .btn-slide-success:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(5,150,105,0.35); color: #fff !important; }
    .btn-slide-warning { background: linear-gradient(135deg, #EA580C, #F97316); color: #fff !important; box-shadow: 0 2px 6px rgba(234,88,12,0.25); grid-column: span 2; }
    .btn-slide-warning:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(234,88,12,0.35); color: #fff !important; }
    .btn-slide-light { background: #F1F5F9; color: #475569 !important; }
    .btn-slide-light:hover { background: #E2E8F0; color: #0F172A !important; }

    .slide-toggle {
        position: absolute;
        top: 50%; right: 0;
        transform: translateY(-50%);
        background: linear-gradient(135deg, #1E40AF, #2563EB);
        color: #fff; border: none;
        padding: 14px 10px;
        border-radius: 12px 0 0 12px;
        cursor: pointer;
        box-shadow: -4px 0 16px rgba(30,64,175,0.35);
        transition: all 0.3s ease;
        z-index: 999;
        writing-mode: vertical-rl;
        text-orientation: mixed;
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.72rem;
        letter-spacing: 0.08em;
        display: flex; align-items: center; gap: 8px;
    }
    .slide-toggle i { font-size: 0.9rem; }
    .slide-toggle:hover { padding-right: 14px; }
    .slide-toggle.hidden { transform: translateY(-50%) translateX(100%); opacity: 0; pointer-events: none; }

    .panneau-marker { background: transparent !important; border: none !important; cursor: pointer; }
    .panneau-marker img { filter: drop-shadow(0 1px 3px rgba(15, 23, 42, 0.35)); transition: filter 0.2s ease, transform 0.2s ease; }
    .panneau-marker:hover img { filter: drop-shadow(0 3px 8px rgba(37, 99, 235, 0.55)); }
    .cluster-marker { background: transparent !important; border: none !important; cursor: pointer; }
    .cluster-marker img { filter: drop-shadow(0 1px 3px rgba(15, 23, 42, 0.4)); }

    .leaflet-popup-content-wrapper { border-radius: 12px; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.15); }
    .leaflet-popup-content { margin: 12px 14px; font-family: 'Inter', sans-serif; }

    /* MODALES */
    .modal-content { border-radius: 16px !important; border: none !important; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.35) !important; overflow: hidden !important; }
    .modal-header { border-bottom: none !important; padding: 20px 26px !important; border-radius: 16px 16px 0 0 !important; flex-shrink: 0; }
    .modal-body { padding: 0 !important; max-height: calc(100vh - 220px) !important; overflow-y: auto !important; }
    .modal-footer { background: #F8FAFC !important; border-top: 1px solid #E2E8F0 !important; padding: 16px 26px !important; border-radius: 0 0 16px 16px !important; flex-shrink: 0; }

    .modal .nav-tabs { padding: 0 26px; background: #F8FAFC; border-bottom: 2px solid #E2E8F0; gap: 4px; }
    .modal .nav-tabs .nav-link { border: none !important; color: #64748B !important; font-size: 0.82rem; font-weight: 700; padding: 12px 18px !important; border-radius: 0 !important; position: relative; transition: all 0.2s ease; }
    .modal .nav-tabs .nav-link:hover { color: #2563EB !important; background: #EFF6FF; }
    .modal .nav-tabs .nav-link.active { color: #1E40AF !important; background: #fff; border-bottom: 3px solid #2563EB !important; margin-bottom: -2px; }
    .modal .nav-tabs .nav-link i { margin-right: 6px; }
    .modal .tab-content { padding: 24px 26px; }

    .modal .form-label { margin-bottom: 4px; font-size: 0.72rem; font-weight: 700; color: #64748B !important; text-transform: uppercase; letter-spacing: 0.04em; }
    .modal .form-control,
    .modal .form-select { padding: 8px 12px; border: 1.5px solid #E2E8F0; border-radius: 8px; font-size: 0.85rem; transition: all 0.15s ease; width: 100%; box-sizing: border-box; }
    .modal .form-control { color: #0F172A !important; background-color: #ffffff !important; }
    .modal .form-control::placeholder { color: #94A3B8 !important; }
    .modal .form-select {
        padding-right: 32px; color: #0F172A !important; background-color: #ffffff !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748B' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center;
        appearance: none; -webkit-appearance: none; color-scheme: light;
    }
    .modal .form-control:focus,
    .modal .form-select:focus { border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; color: #0F172A !important; background-color: #ffffff !important; }
    .modal .btn-close-white { filter: brightness(0) invert(1); opacity: 0.8; }
    .modal .btn-close-white:hover { opacity: 1; }

    .coords-block { background: #EFF6FF; border: 1.5px solid #BFDBFE; border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; }
    .coords-block .coords-title { font-size: 0.75rem; font-weight: 800; color: #1E40AF !important; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
    .coords-block .coords-values { display: flex; gap: 12px; flex-wrap: wrap; font-family: monospace; font-size: 0.82rem; color: #1E3A8A !important; margin-bottom: 10px; }
    .coords-block .coords-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-coord { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s ease; }
    .btn-coord-pick { background: linear-gradient(135deg, #059669, #10B981); color: #fff !important; box-shadow: 0 2px 6px rgba(5,150,105,0.25); }
    .btn-coord-pick:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(5,150,105,0.35); color: #fff !important; }
    .btn-coord-gps { background: linear-gradient(135deg, #1E40AF, #2563EB); color: #fff !important; box-shadow: 0 2px 6px rgba(37,99,235,0.25); }
    .btn-coord-gps:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(37,99,235,0.35); color: #fff !important; }
    .btn-coord:disabled { opacity: 0.7; cursor: not-allowed; }

    .photo-upload-zone { border: 2px dashed #CBD5E1; border-radius: 12px; padding: 24px; text-align: center; background: #F8FAFC; cursor: pointer; transition: all 0.2s ease; }
    .photo-upload-zone:hover { border-color: #2563EB; background: #EFF6FF; }
    .photo-upload-zone input[type="file"] { display: none; }
    .photo-preview-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 8px; margin-top: 12px; }
    .photo-preview-item { position: relative; aspect-ratio: 1; border-radius: 8px; overflow: hidden; border: 1px solid #E2E8F0; }
    .photo-preview-item img { width: 100%; height: 100%; object-fit: cover; display: block; }

    /* =========================================================
       RESPONSIVE — TABLETTE (≤ 1024px)
       ========================================================= */
    @media (max-width: 1024px) {
        .carte-topbar { padding: 10px 14px; gap: 10px; }
        .topbar-title { font-size: 0.95rem; }
        .topbar-subtitle { font-size: 0.7rem; }
        .topbar-center { max-width: 240px; }
        .btn-topbar { padding: 7px 11px; font-size: 0.72rem; }
        .slide-panel { width: 380px; }
        .carte-kpibar { padding: 8px 14px; }
    }

    /* =========================================================
       RESPONSIVE — SMARTPHONE (≤ 768px)
       ========================================================= */
    @media (max-width: 768px) {

        /* TOPBAR */
        .carte-topbar { flex-direction: column; align-items: stretch; padding: 10px 12px; gap: 8px; }
        .topbar-left { justify-content: flex-start; }
        .topbar-icon { width: 36px; height: 36px; border-radius: 9px; }
        .topbar-icon i { font-size: 1rem; }
        .topbar-title { font-size: 0.9rem; }
        .topbar-subtitle { font-size: 0.65rem; }
        .topbar-center { max-width: 100%; width: 100%; order: 3; }
        .topbar-center input { padding: 9px 14px 9px 34px; font-size: 0.8rem; }
        .topbar-right { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 6px; width: 100%; order: 2; }
        .btn-topbar { justify-content: center; padding: 8px 6px; font-size: 0.7rem; gap: 4px; }
        .btn-topbar i { font-size: 0.75rem; }

        /* KPI BAR */
        .carte-kpibar { padding: 8px 12px; gap: 6px; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
        .carte-kpibar::-webkit-scrollbar { display: none; }
        .kpi-chip { padding: 5px 10px; font-size: 0.7rem; gap: 6px; }
        .kpi-chip .chip-count { font-size: 0.65rem; padding: 1px 6px; }

        /* SLIDE PANEL */
        .slide-panel { width: 100vw !important; max-width: 100vw !important; }
        .slide-header { padding: 14px 16px; }
        .slide-title { font-size: 0.85rem; }
        .slide-body { padding: 16px; }
        .slide-toggle {
            top: auto; bottom: 16px; right: 16px;
            transform: none;
            writing-mode: horizontal-tb;
            padding: 10px 14px;
            border-radius: 100px;
            font-size: 0.75rem;
            letter-spacing: 0.04em;
            box-shadow: 0 4px 16px rgba(30,64,175,0.45);
            display: inline-flex;
            flex-direction: row;
            gap: 6px;
        }
        .slide-toggle:hover { padding-right: 14px; }
        .slide-toggle.hidden { transform: translateY(80px); opacity: 0; }
        .detail-svg-box { height: 110px; padding: 12px; }
        .detail-code { font-size: 1.15rem; }
        .detail-name { font-size: 0.8rem; }
        .detail-row { padding: 8px 0; font-size: 0.78rem; }
        .slide-actions { gap: 6px; }
        .btn-slide { padding: 9px 12px; font-size: 0.75rem; border-radius: 8px; }

        /* MODALES */
        .modal-dialog { margin: 0 !important; max-width: 100% !important; width: 100% !important; height: 100% !important; }
        .modal-dialog.modal-dialog-centered { min-height: 100% !important; align-items: stretch !important; }
        .modal-content { border-radius: 0 !important; height: 100% !important; max-height: 100vh !important; display: flex; flex-direction: column; }
        .modal-header { padding: 14px 16px !important; border-radius: 0 !important; flex-shrink: 0; }
        .modal-title { font-size: 0.95rem !important; }
        .modal-body { flex: 1 1 auto !important; max-height: none !important; overflow-y: auto !important; padding: 0 !important; -webkit-overflow-scrolling: touch; }
        .modal-footer { padding: 12px 16px !important; border-radius: 0 !important; flex-shrink: 0; gap: 8px; }
        .modal-footer button { flex: 1; padding: 11px 14px !important; font-size: 0.85rem !important; }

        .modal .nav-tabs { padding: 0 12px; overflow-x: auto; flex-wrap: nowrap; -webkit-overflow-scrolling: touch; scrollbar-width: none; margin: 0 !important; }
        .modal .nav-tabs::-webkit-scrollbar { display: none; }
        .modal .nav-tabs .nav-link { padding: 10px 12px !important; font-size: 0.75rem; white-space: nowrap; }
        .modal .nav-tabs .nav-link i { margin-right: 4px; }
        .modal .tab-content { padding: 16px !important; }

        .coords-block { padding: 12px 14px; }
        .coords-block .coords-values { font-size: 0.75rem; }
        .coords-block .coords-actions { flex-direction: column; }
        .btn-coord { width: 100%; justify-content: center; padding: 9px 12px; font-size: 0.78rem; }
        .photo-preview-grid { grid-template-columns: repeat(3, 1fr); gap: 6px; }

        /* BANDEAU PLACEMENT */
        .placement-banner {
            top: auto;
            bottom: 90px;
            left: 12px;
            right: 12px;
            transform: none;
            animation: none;
            padding: 10px 14px;
            font-size: 0.78rem;
            border-radius: 10px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
        .placement-banner.active { display: flex; }
        .placement-banner .btn-cancel-placement { flex-shrink: 0; }

        /* POPUP LEAFLET */
        .leaflet-popup-content-wrapper { max-width: calc(100vw - 40px) !important; }
        .leaflet-popup-content { margin: 10px 12px !important; }
        .leaflet-popup { max-width: calc(100vw - 30px); }

        /* FILTRES */
        .filters-panel {
            top: auto;
            bottom: 80px;
            left: 10px;
            right: 10px;
            width: auto;
            max-height: 60vh;
            transform: translateY(120%);
        }
        .filters-panel.open { transform: translateY(0); }

        /* =========================================================
           LÉGENDE DES ZONES — VERSION MOBILE COMPACTE ET REPLIABLE
           ========================================================= */
        .zones-legend {
            bottom: 20px;
            left: 12px;
            right: auto;
            max-width: calc(100vw - 90px);
            min-width: 0;
            width: auto;
            max-height: none;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.22);
        }

        /* Par défaut repliée sur mobile */
        .zones-legend:not(.expanded) .zones-legend-body {
            max-height: 0 !important;
            padding: 0 !important;
            overflow: hidden;
        }

        /* Quand dépliée, elle s'étend mais reste limitée */
        .zones-legend.expanded {
            max-height: 45vh;
            width: calc(100vw - 24px);
            max-width: calc(100vw - 24px);
        }
        .zones-legend.expanded .zones-legend-body {
            max-height: 40vh;
            padding: 4px 0;
        }

        .zones-legend-header {
            padding: 9px 12px;
            font-size: 0.75rem;
            border-radius: 10px;
        }
        .zones-legend-header i { font-size: 0.78rem; }
        .zones-legend-header .legend-toggle-icon { font-size: 0.7rem; }

        .zones-legend-item {
            padding: 7px 12px;
            font-size: 0.75rem;
            gap: 8px;
        }
        .zones-legend-color { width: 16px; height: 3px; }
        .zones-legend-name {
            max-width: calc(100vw - 90px);
            font-size: 0.75rem;
        }

        .leaflet-control-layers-toggle { width: 38px !important; height: 38px !important; background-size: 20px 20px !important; }
    }

    /* =========================================================
       TRÈS PETIT ÉCRAN (≤ 420px)
       ========================================================= */
    @media (max-width: 420px) {
        .btn-topbar span { display: none; }
        .btn-topbar { font-size: 0.85rem; padding: 8px 4px; }

        .zones-legend.expanded {
            width: calc(100vw - 20px);
            max-width: calc(100vw - 20px);
        }
        .zones-legend-name { max-width: calc(100vw - 80px); }
    }

    /* =========================================================
       TRÈS TRÈS PETIT ÉCRAN (≤ 380px)
       ========================================================= */
    @media (max-width: 380px) {
        .topbar-title { font-size: 0.82rem; }
        .topbar-subtitle { display: none; }
        .kpi-chip { padding: 4px 8px; font-size: 0.65rem; }
        .btn-slide { font-size: 0.7rem; padding: 8px 10px; }
        .detail-svg-box { height: 90px; }

        .zones-legend {
            bottom: 16px;
            left: 10px;
            max-width: calc(100vw - 80px);
        }
        .zones-legend.expanded {
            width: calc(100vw - 16px);
            max-width: calc(100vw - 16px);
        }
        .zones-legend-name { max-width: calc(100vw - 70px); }
    }
    /* =========================================================
   BOUTON FLOTTANT DE RECENTRAGE
   ========================================================= */
.btn-recenter-map {
    position: absolute;
    right: 16px;
    bottom: 100px;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.18);
    color: #2563EB;
    font-size: 1.15rem;
    cursor: pointer;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    -webkit-tap-highlight-color: transparent;
}
.btn-recenter-map:hover {
    background: #EFF6FF;
    color: #1E40AF;
    transform: scale(1.08);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
}
.btn-recenter-map:active {
    transform: scale(0.95);
}
.btn-recenter-map.active {
    background: linear-gradient(135deg, #2563EB, #1E40AF);
    color: #fff !important;
    border-color: transparent;
}

/* Position du bouton sur mobile */
@media (max-width: 768px) {
    .btn-recenter-map {
        right: 12px;
        bottom: 150px;
        width: 44px;
        height: 44px;
        font-size: 1.05rem;
    }
}

@media (max-width: 420px) {
    .btn-recenter-map {
        bottom: 140px;
        width: 42px;
        height: 42px;
        font-size: 1rem;
    }
}
.btn-recenter-map {
    position: absolute;
    right: 16px;
    bottom: 100px;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.18);
    color: #2563EB;
    font-size: 1.15rem;
    cursor: pointer;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
.btn-recenter-map:hover {
    background: #EFF6FF;
    transform: scale(1.08);
}
.btn-recenter-map.active {
    background: linear-gradient(135deg, #2563EB, #1E40AF);
    color: #fff !important;
    border-color: transparent;
}
@media (max-width: 768px) {
    .btn-recenter-map {
        right: 12px;
        bottom: 150px;
        width: 44px;
        height: 44px;
    }
}
</style>
</head>
<body>

<script>
window.__panneaux     = @json($panneaux);
window.__baseSvg      = "{{ asset('Backend/assets/SVG') }}";
window.__csrf         = "{{ csrf_token() }}";
window.__listes       = @json($listes ?? []);
window.__zones        = @json($zones ?? []);
window.__zonesBounds  = @json($zonesBounds ?? null);

console.log('📦 Panneaux :', window.__panneaux.length);
console.log('🗺️ Zones :', window.__zones.length);
console.log('📍 Bounds zones :', window.__zonesBounds);
</script>

<div class="carte-page">

    <div class="carte-topbar">
        <div class="topbar-left">
            <div class="topbar-icon">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div>
                <h1 class="topbar-title">Carte des panneaux</h1>
                <p class="topbar-subtitle">Grand Tunis — Tunis • Ariana • Manouba • Ben Arous</p>
            </div>
        </div>

        <div class="topbar-center">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchInput" placeholder="Rechercher code, route, PK...">
        </div>

        <div class="topbar-right">
            {{-- ✅ Bouton "Ma position" AJOUTÉ --}}
            <button type="button" class="btn-topbar btn-topbar-locate" id="btnLocateMe" onclick="locateMe()">
                <i class="fa-solid fa-location-crosshairs"></i> <span>Ma position</span>
            </button>

            <button type="button" class="btn-topbar" onclick="toggleFiltersPanel()">
                <i class="fa-solid fa-filter"></i> <span>Filtres</span>
                <span id="filtersCountBadge" style="display:none; background:#DC2626; color:#fff; border-radius:100px; padding:0 6px; font-size:0.65rem; font-weight:800; margin-left:2px;">0</span>
            </button>

            <a href="{{ route('signalisation.index') }}" class="btn-topbar">
                <i class="fa-solid fa-list"></i> <span>Liste</span>
            </a>

            <button type="button" class="btn-topbar btn-topbar-success" onclick="startNewPanneauPlacement()">
                <i class="fa-solid fa-plus"></i> <span>Nouveau panneau</span>
            </button>

            <button type="button" class="btn-topbar btn-topbar-primary" onclick="fitAllMarkers()">
                <i class="fa-solid fa-expand"></i> <span>Tout voir</span>
            </button>
        </div>
    </div>

    <div class="carte-kpibar">
        <div class="kpi-chip active" data-filtre-etat="">
            <span class="chip-dot" style="background:#2563EB;"></span>
            Total
            <span class="chip-count">{{ $stats['total'] }}</span>
        </div>
        <div class="kpi-chip" data-filtre-etat="Bon">
            <span class="chip-dot" style="background:#059669;"></span>
            Bon état
            <span class="chip-count">{{ $stats['bon'] }}</span>
        </div>
        <div class="kpi-chip" data-filtre-etat="Dégradé">
            <span class="chip-dot" style="background:#B45309;"></span>
            Dégradés
            <span class="chip-count">{{ $stats['degrade'] }}</span>
        </div>
        <div class="kpi-chip" data-filtre-etat="Vandalisé">
            <span class="chip-dot" style="background:#EA580C;"></span>
            Vandalisés
            <span class="chip-count">{{ $stats['vandal'] }}</span>
        </div>
        <div class="kpi-chip" data-filtre-etat="Masqué">
            <span class="chip-dot" style="background:#DC2626;"></span>
            Masqués
            <span class="chip-count">{{ $stats['masque'] }}</span>
        </div>
    </div>

    <div class="carte-main">
        <div id="carte-globale"></div>

        {{-- ✅ BOUTON FLOTTANT DE RECENTRAGE --}}
        <button type="button"
                id="btnRecenter"
                class="btn-recenter-map"
                onclick="centerOnMyPosition()"
                title="Recentrer sur ma position"
                style="display: none;">
            <i class="fa-solid fa-location-crosshairs"></i>
        </button>

        {{-- ✅ BANDEAU INFO POSITION (correctement fermé !) --}}
        <div class="user-location-banner" id="userLocationBanner">
            <span class="loc-dot"></span>
            <span class="loc-text" id="userLocationText">Position en cours...</span>
            <button type="button" class="loc-close" onclick="hideUserLocationBanner()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- PANNEAU DE FILTRES AVANCÉS --}}
        <div class="filters-panel" id="filtersPanel">
            <div class="filters-header">
                <div style="display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Filtres avancés</span>
                    <span class="filters-result-count" id="filtersResultCount">0 résultat</span>
                </div>
                <button type="button" class="filters-close" onclick="toggleFiltersPanel()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="filters-body">

                {{-- Route --}}
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fa-solid fa-road"></i> Route
                    </label>
                    <select id="filterRoute" class="filter-select" onchange="applyFilters()">
                        <option value="">— Toutes les routes —</option>
                    </select>
                </div>

                {{-- Catégorie de panneau (types_panneaux.categorie) --}}
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fa-solid fa-layer-group"></i> Catégorie
                    </label>
                    <select id="filterCategorie" class="filter-select" onchange="applyFilters()">
                        <option value="">— Toutes catégories —</option>
                    </select>
                </div>

                {{-- Nom du panneau (types_panneaux.nom) --}}
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fa-solid fa-sign-hanging"></i> Nom du panneau
                    </label>
                    <select id="filterNom" class="filter-select" onchange="applyFilters()">
                        <option value="">— Tous les noms —</option>
                    </select>
                </div>

                {{-- État --}}
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fa-solid fa-heart-pulse"></i> État
                    </label>
                    <select id="filterEtat" class="filter-select" onchange="applyFilters()">
                        <option value="">— Tous états —</option>
                        <option value="Bon">Bon</option>
                        <option value="Dégradé">Dégradé</option>
                        <option value="Vandalisé">Vandalisé</option>
                        <option value="Masqué">Masqué</option>
                        <option value="__aucun__">Non observé</option>
                    </select>
                </div>

                {{-- PK min/max --}}
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fa-solid fa-ruler"></i> PK (min — max)
                    </label>
                    <div style="display:flex; gap:6px;">
                        <input type="number" id="filterPkMin" class="filter-input" placeholder="Min" oninput="applyFilters()">
                        <input type="number" id="filterPkMax" class="filter-input" placeholder="Max" oninput="applyFilters()">
                    </div>
                </div>

                {{-- Date d'observation --}}
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fa-solid fa-calendar"></i> Dernière observation
                    </label>
                    <select id="filterDateRange" class="filter-select" onchange="applyFilters()">
                        <option value="">— Toutes dates —</option>
                        <option value="7">7 derniers jours</option>
                        <option value="30">30 derniers jours</option>
                        <option value="90">3 derniers mois</option>
                        <option value="365">12 derniers mois</option>
                        <option value="__jamais__">Jamais observé</option>
                    </select>
                </div>

            </div>

            <div class="filters-footer">
                <button type="button" class="filters-btn-reset" onclick="resetAllFilters()">
                    <i class="fa-solid fa-rotate-left"></i> Réinitialiser
                </button>
                <button type="button" class="filters-btn-apply" onclick="applyFilters()">
                    <i class="fa-solid fa-check"></i> Appliquer
                </button>
            </div>
        </div>

        {{-- LÉGENDE ZONES --}}
        <div class="zones-legend" id="zonesLegend">
            <div class="zones-legend-header">
                <i class="fa-solid fa-map"></i>
                <span>Zones d'étude</span>
            </div>
            <div class="zones-legend-body" id="zonesLegendBody"></div>
        </div>

        {{-- BANDEAU PLACEMENT --}}
        <div class="placement-banner" id="placementBanner">
            <i class="fa-solid fa-crosshairs" id="placementIcon"></i>
            <span id="placementText">Cliquez sur la carte pour placer le nouveau panneau</span>
            <button type="button" class="btn-cancel-placement" onclick="cancelPlacement()">
                <i class="fa-solid fa-xmark"></i> Annuler
            </button>
        </div>

        <button type="button" class="slide-toggle" id="slideToggle" onclick="toggleSlidePanel()">
            <i class="fa-solid fa-chevron-left"></i>
            <span>DÉTAILS</span>
        </button>

        <div class="slide-panel" id="slidePanel">
            <div class="slide-header">
                <h3 class="slide-title">
                    <i class="fa-solid fa-circle-info"></i>
                    Détail du panneau
                </h3>
                <button type="button" class="slide-close" onclick="closeSlidePanel()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="slide-body" id="detailBody">
                <div class="slide-empty">
                    <i class="fa-solid fa-hand-pointer"></i>
                    Cliquez sur un marqueur pour afficher les détails et agir sur le terrain.
                </div>
            </div>
        </div>
    </div>

</div>

{{-- MODALE PANNEAU --}}
<div class="modal fade" id="modalPanneau" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header" id="modalPanneauHeader" style="background: linear-gradient(135deg, #1E40AF, #2563EB); color: #fff;">
                <div>
                    <h5 class="modal-title" style="color: #fff !important; font-weight: 700;" id="modalPanneauTitle">
                        <i class="fa-solid fa-pen-to-square"></i> Modifier le panneau
                    </h5>
                    <small id="modalPanneauSubtitle" style="color: rgba(255,255,255,0.85); font-size: 0.8rem;"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="formPanneau" method="POST" style="display: flex; flex-direction: column; flex: 1; min-height: 0;">
                @csrf
                <input type="hidden" name="_method" id="formPanneauMethod" value="PUT">

                <div class="modal-body">
                    <div id="panneauError" class="alert alert-danger d-none" style="margin: 16px 26px 0; border-radius: 10px;"></div>
                    <div id="panneauSuccess" class="alert alert-success d-none" style="margin: 16px 26px 0; border-radius: 10px;"></div>

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#p-tab-ident" type="button">
                                <i class="fa-solid fa-tag"></i> Identification
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#p-tab-loc" type="button">
                                <i class="fa-solid fa-map-location-dot"></i> Localisation
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#p-tab-mat" type="button">
                                <i class="fa-solid fa-industry"></i> Matériaux
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#p-tab-struct" type="button">
                                <i class="fa-solid fa-screwdriver-wrench"></i> Structure
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="p-tab-ident">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Code nomenclature</label>
                                    <input type="text" name="code_nomen" id="p_code_nomen" class="form-control" placeholder="Ex: A1a, B1...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fclass</label>
                                    <input type="text" name="fclass" id="p_fclass" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="name" id="p_name" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">N° agrément</label>
                                    <input type="text" name="num_agrement" id="p_num_agrement" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Code panneau CCTP</label>
                                    <input type="text" name="code_panneau_cctp" id="p_code_panneau_cctp" class="form-control" placeholder="Ex: EB10, E36...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">HC caractère (mm)</label>
                                    <input type="number" name="hc_caractere" id="p_hc_caractere" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dimensions CCTP</label>
                                    <input type="text" name="dim_cctp" id="p_dim_cctp" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="p-tab-loc">
                            <div class="coords-block">
                                <div class="coords-title">
                                    <i class="fa-solid fa-map-pin"></i> Coordonnées GPS
                                </div>
                                <div class="coords-values">
                                    <span>Lat : <strong id="coordLatLabel">—</strong></span>
                                    <span>Lng : <strong id="coordLngLabel">—</strong></span>
                                </div>
                                <div class="coords-actions">
                                    <button type="button" class="btn-coord btn-coord-gps" id="btnUseGps" onclick="useMyPositionInModal()">
                                        <i class="fa-solid fa-location-crosshairs"></i> Ma position
                                    </button>
                                    <button type="button" class="btn-coord btn-coord-pick" onclick="pickPositionOnMap()">
                                        <i class="fa-solid fa-hand-pointer"></i> Cliquer sur la carte
                                    </button>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Latitude *</label>
                                    <input type="number" step="0.0000001" name="lat" id="p_lat" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Longitude *</label>
                                    <input type="number" step="0.0000001" name="lng" id="p_lng" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Route</label>
                                    <input type="text" name="route_nom" id="p_route_nom" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Point kilométrique</label>
                                    <input type="text" name="point_kilo" id="p_point_kilo" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Catégorie de route</label>
                                    <select name="route" id="p_route" class="form-select">
                                        <option value="">— Non renseignée —</option>
                                        @foreach (['Nationale', 'Régionale', 'Locale', 'Autoroute', 'Urbaine', 'Rurale'] as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="p-tab-mat">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nuance acier</label>
                                    <input type="text" name="acier_nuance" id="p_acier_nuance" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nature matériau</label>
                                    <input type="text" name="nature_mat" id="p_nature_mat" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Type subjectile</label>
                                    <input type="text" name="type_subje" id="p_type_subje" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dépôt galva (g/dm²)</label>
                                    <input type="number" step="0.1" name="galva_depot" id="p_galva_depot" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Largeur lattes (cm)</label>
                                    <input type="number" name="largeur_latte" id="p_largeur_latte" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Anodisé</label>
                                    <select name="anodise" id="p_anodise" class="form-select">
                                        <option value="">— Non renseigné —</option>
                                        <option value="1">Oui</option>
                                        <option value="0">Non</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Type film rétro</label>
                                    <input type="text" name="type_film_retro" id="p_type_film_retro" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Garantie film (ans)</label>
                                    <input type="number" name="garantie_film_ans" id="p_garantie_film_ans" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dimensions</label>
                                    <input type="text" name="dimensions" id="p_dimensions" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Couleur fond</label>
                                    <input type="text" name="couleur_fo" id="p_couleur_fo" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="p-tab-struct">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Protection</label>
                                    <input type="text" name="protection" id="p_protection" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Type de support</label>
                                    <input type="text" name="type_suppo" id="p_type_suppo" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Matière support</label>
                                    <input type="text" name="matiere_support" id="p_matiere_support" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nb raidisseurs</label>
                                    <input type="number" name="nb_raidisseurs" id="p_nb_raidisseurs" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Résistance vent (daN/m²)</label>
                                    <input type="number" name="resistance" id="p_resistance" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hauteur au sol (m)</label>
                                    <input type="number" step="0.01" name="hauteur_so" id="p_hauteur_so" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hauteur libre (m)</label>
                                    <input type="number" step="0.01" name="hauteur_libre_m" id="p_hauteur_libre_m" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Implantation (m)</label>
                                    <input type="number" step="0.01" name="implantation_m" id="p_implantation_m" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fiche ancrage (m)</label>
                                    <input type="number" step="0.01" name="fiche_ancrage_m" id="p_fiche_ancrage_m" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date de pose</label>
                                    <input type="date" name="date_pose" id="p_date_pose" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Durée de vie (ans)</label>
                                    <input type="number" name="duree_vie_ans" id="p_duree_vie_ans" class="form-control" value="10">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="fa-solid fa-xmark"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitPanneau" style="border-radius: 8px; font-weight: 600; background: linear-gradient(135deg, #1E40AF, #2563EB); border: none; padding: 8px 20px;">
                        <i class="fa-solid fa-check"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODALE OBSERVATION --}}
<div class="modal fade" id="modalNewObservation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #059669, #10B981); color: #fff;">
                <div>
                    <h5 class="modal-title" style="color: #fff !important; font-weight: 700;">
                        <i class="fa-solid fa-plus-circle"></i> Nouvelle observation
                    </h5>
                    <small id="newObsSubtitle" style="color: rgba(255,255,255,0.85); font-size: 0.8rem;"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="formNewObservation" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; flex: 1; min-height: 0;">
                @csrf

                <div class="modal-body">
                    <div id="newObsError" class="alert alert-danger d-none" style="margin: 16px 26px 0; border-radius: 10px;"></div>
                    <div id="newObsSuccess" class="alert alert-success d-none" style="margin: 16px 26px 0; border-radius: 10px;"></div>

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#new-tab-insp" type="button">
                                <i class="fa-solid fa-heart-pulse"></i> Inspection
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#new-tab-dates" type="button">
                                <i class="fa-solid fa-calendar"></i> Dates
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#new-tab-photos" type="button">
                                <i class="fa-solid fa-camera"></i> Photos
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="new-tab-insp">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Date d'observation *</label>
                                    <input type="datetime-local" name="date_obs" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">État actuel *</label>
                                    <select name="etat_actuel" class="form-select" required>
                                        <option value="">— Choisir —</option>
                                        <option value="Bon">Bon</option>
                                        <option value="Dégradé">Dégradé</option>
                                        <option value="Vandalisé">Vandalisé</option>
                                        <option value="Masqué">Masqué</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Classe rétro</label>
                                    <select name="classe_retro" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="Type 1 (EG)">Type 1 (EG)</option>
                                        <option value="Type 2 (HI)">Type 2 (HI)</option>
                                        <option value="Type 3 (DG)">Type 3 (DG)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">N° agrément</label>
                                    <input type="text" name="num_agrem" class="form-control" placeholder="N° homologation">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Remarque</label>
                                    <textarea name="remarque" class="form-control" rows="3" placeholder="Commentaires du technicien..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="new-tab-dates">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Date fabrication</label>
                                    <input type="date" name="date_fabrication" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date pose</label>
                                    <input type="date" name="date_pose" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Fin garantie</label>
                                    <input type="date" name="garantie_expiration" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="new-tab-photos">
                            <div class="photo-upload-zone" onclick="document.getElementById('newObsPhotos').click();">
                                <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2rem; color: #2563EB; margin-bottom: 8px; display: block;"></i>
                                <div style="font-weight: 700; color: #0F172A; margin-bottom: 4px;">Cliquez pour ajouter des photos</div>
                                <div style="font-size: 0.8rem; color: #64748B;">JPG, PNG, WEBP — max 10 Mo (10 photos max)</div>
                                <input type="file" id="newObsPhotos" name="photos[]" accept="image/*" multiple capture="environment" onchange="previewPhotos(this, 'photoPreviewNew')">
                            </div>
                            <div class="photo-preview-grid" id="photoPreviewNew"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="fa-solid fa-xmark"></i> Annuler
                    </button>
                    <button type="submit" id="btnSubmitNewObs" style="border-radius: 8px; font-weight: 600; background: linear-gradient(135deg, #059669, #10B981); color: #fff; border: none; padding: 8px 20px;">
                        <i class="fa-solid fa-check"></i> Enregistrer l'observation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       HELPERS PERFORMANCE
    ========================================================= */
    function debounce(fn, wait) {
        let t = null;
        return function () {
            const ctx = this, args = arguments;
            clearTimeout(t);
            t = setTimeout(function () { fn.apply(ctx, args); }, wait);
        };
    }
    function throttleRAF(fn) {
        let scheduled = false;
        return function () {
            if (scheduled) return;
            scheduled = true;
            requestAnimationFrame(function () {
                scheduled = false;
                fn.apply(this, arguments);
            });
        };
    }

    /* =========================================================
       NORMALISATION DES PANNEAUX
    ========================================================= */
    const panneauxBruts = window.__panneaux || [];
    const panneauxListe = Array.isArray(panneauxBruts) ? panneauxBruts : Object.values(panneauxBruts);

    function normaliserPanneau(p) {
        if (!p || typeof p !== 'object') return null;
        const lat = parseFloat(p.lat ?? p.latitude ?? p.latitud ?? p.lat_deg ?? p.y);
        const lng = parseFloat(p.lng ?? p.longitude ?? p.longitud ?? p.lon ?? p.long_deg ?? p.x);
        if (!Number.isFinite(lat) || !Number.isFinite(lng)) return null;
        if (lat < -90 || lat > 90 || lng < -180 || lng > 180) return null;
        return Object.assign({}, p, { lat: lat, lng: lng });
    }

    const panneaux      = panneauxListe.map(normaliserPanneau).filter(Boolean);
    const BASE_SVG      = window.__baseSvg || '';
    const CSRF          = window.__csrf || '';
    const ZONES         = window.__zones || [];
    const ZONES_BOUNDS  = window.__zonesBounds || null;

    console.log('🚀 Panneaux valides :', panneaux.length, '/', panneauxListe.length);

    let placementMode = null;
    let movePanneauId = null;
    let tempMarker = null;
    let pickPositionCallback = null;

    const GRAND_TUNIS_BOUNDS = L.latLngBounds([36.55, 9.95], [36.98, 10.45]);
    const isMobile = L.Browser.mobile;

    /* =========================================================
       CARTE
    ========================================================= */
    const carte = L.map('carte-globale', {
        center: GRAND_TUNIS_BOUNDS.getCenter(),
        zoom: 5,
        minZoom: 5, maxZoom: 19,
        zoomControl: true,
        scrollWheelZoom: !isMobile,
        zoomSnap: 0.5,
        tap: true,
        tapTolerance: 15,
        preferCanvas: true
    });

    window.__carte = carte;

    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '&copy; OpenStreetMap'
    }).addTo(carte);

    const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19, attribution: '&copy; Esri'
    });

    L.control.layers({ "Plan": osm, "Satellite": satellite }, null, { position: 'bottomright' }).addTo(carte);
    L.control.scale({ imperial: false, position: 'bottomleft' }).addTo(carte);

    const CARTE_STATE_KEY = 'carte_state_v1';

    const sauvegarderEtatCarte = debounce(function () {
        try {
            const c = carte.getCenter();
            sessionStorage.setItem(CARTE_STATE_KEY, JSON.stringify({
                lat: c.lat, lng: c.lng, zoom: carte.getZoom()
            }));
        } catch (e) {}
    }, 500);

    function restaurerEtatCarte() {
        try {
            const raw = sessionStorage.getItem(CARTE_STATE_KEY);
            if (!raw) return false;
            const s = JSON.parse(raw);
            if (!s || s.lat == null || s.lng == null || s.zoom == null) return false;
            carte.setView([s.lat, s.lng], s.zoom, { animate: false });
            return true;
        } catch (e) { return false; }
    }
    window.sauvegarderEtatCarte = sauvegarderEtatCarte;
    window.restaurerEtatCarte   = restaurerEtatCarte;

    if (!restaurerEtatCarte()) {
        if (ZONES_BOUNDS) {
            const zoneBounds = L.latLngBounds(
                [ZONES_BOUNDS.min_lat, ZONES_BOUNDS.min_lng],
                [ZONES_BOUNDS.max_lat, ZONES_BOUNDS.max_lng]
            );
            carte.fitBounds(zoneBounds.pad(0.05));
        } else {
            carte.fitBounds(GRAND_TUNIS_BOUNDS);
        }
    }

    carte.on('moveend zoomend', sauvegarderEtatCarte);

    const invalidateSizeThrottled = throttleRAF(function () { carte.invalidateSize(true); });
    window.addEventListener('orientationchange', function () { setTimeout(invalidateSizeThrottled, 300); });
    window.addEventListener('resize', invalidateSizeThrottled);

    window.rechargerPageEnConservantEtat = function (delayMs) {
        sauvegarderEtatCarte();
        setTimeout(function () { window.location.reload(); }, delayMs || 900);
    };

    /* =========================================================
       ZONES D'ÉTUDE
    ========================================================= */
    const zoneColors = [
        '#7C3AED', '#2563EB', '#059669', '#EA580C',
        '#DC2626', '#0891B2', '#CA8A04', '#DB2777',
        '#16A34A', '#9333EA', '#0284C7', '#B45309'
    ];
    const zoneLayers = [];

    function getZoneColor(i) { return zoneColors[i % zoneColors.length]; }

    function initZones() {
        const legendBody = document.getElementById('zonesLegendBody');
        if (!legendBody) return;

        if (ZONES.length === 0) {
            legendBody.innerHTML =
                '<div class="zones-legend-empty">' +
                    '<i class="fa-solid fa-circle-info" style="display:block; margin-bottom:4px; opacity:0.6;"></i>' +
                    'Aucune zone' +
                '</div>';
            return;
        }

        const fragment = document.createDocumentFragment();

        ZONES.forEach(function (zone, index) {
            const color = getZoneColor(index);

            let geoJsonData;
            try {
                geoJsonData = typeof zone.geojson === 'string'
                    ? JSON.parse(zone.geojson)
                    : zone.geojson;
            } catch (e) { return; }
            if (!geoJsonData || !geoJsonData.type) return;

            const layer = L.geoJSON(geoJsonData, {
                style: {
                    color: color,
                    weight: 3,
                    opacity: 0.95,
                    fillColor: color,
                    fillOpacity: 0,
                    dashArray: '8, 5'
                }
            });

            layer.addTo(carte);
            zoneLayers.push(layer);

            const nom = zone.nom_fr || zone.nom_ar || ('Zone ' + (index + 1));
            const item = document.createElement('div');
            item.className = 'zones-legend-item';
            item.innerHTML =
                '<span class="zones-legend-color" style="background:' + color + ';"></span>' +
                '<span class="zones-legend-name" title="' + nom + '">' + nom + '</span>';
            fragment.appendChild(item);
        });

        legendBody.innerHTML = '';
        legendBody.appendChild(fragment);

        /* Repli/dépli légende sur mobile */
        const legendEl = document.getElementById('zonesLegend');
        const legendHeader = legendEl ? legendEl.querySelector('.zones-legend-header') : null;
        if (legendEl && legendHeader && !legendEl.dataset.bound) {
            legendEl.dataset.bound = '1';

            if (!legendHeader.querySelector('.legend-toggle-icon')) {
                const icon = document.createElement('i');
                icon.className = 'fa-solid fa-chevron-down legend-toggle-icon';
                legendHeader.appendChild(icon);
            }

            const isMobileInit = window.matchMedia('(max-width: 768px)').matches;
            if (isMobileInit) {
                legendEl.classList.add('expanded');
                setTimeout(function () { legendEl.classList.remove('expanded'); }, 2500);
            }

            legendHeader.addEventListener('click', function (e) {
                e.stopPropagation();
                if (!window.matchMedia('(max-width: 768px)').matches) return;
                legendEl.classList.toggle('expanded');
            });
        }
    }
    initZones();

    /* =========================================================
       TAILLE / ICÔNES
    ========================================================= */
    function sizeForZoom(zoom) {
        if (zoom <= 9)  return 14;
        if (zoom <= 11) return 20;
        if (zoom <= 13) return 26;
        if (zoom <= 15) return 34;
        if (zoom <= 17) return 42;
        return 52;
    }

    const iconCache = new Map();
    const clusterIconCache = new Map();

    function makeIcon(svgUrl, zoom, hovered) {
        const key = (svgUrl || '_') + '|' + zoom + '|' + (hovered ? 1 : 0);
        if (iconCache.has(key)) return iconCache.get(key);

        const baseSize = sizeForZoom(zoom);
        const s = hovered ? Math.round(baseSize * 1.15) : baseSize;

        let html;
        if (svgUrl) {
            html = '<img src="' + svgUrl + '" alt="" style="width:' + s + 'px;height:' + s + 'px;object-fit:contain;display:block;filter:drop-shadow(0 1px 3px rgba(15,23,42,0.35));' + (hovered ? 'transform:scale(1.1);' : '') + '" onerror="this.style.display=\'none\';">';
        } else {
            html = '<i class="fa-solid fa-sign-hanging" style="color:#2563EB;font-size:' + Math.round(s * 0.8) + 'px;filter:drop-shadow(0 1px 3px rgba(15,23,42,0.35));display:block;"></i>';
        }

        const icon = L.divIcon({
            html: html,
            className: 'panneau-marker',
            iconSize:   [s, s],
            iconAnchor: [s / 2, s / 2],
            popupAnchor: [0, -s / 2]
        });
        iconCache.set(key, icon);
        return icon;
    }

    function makeClusterIcon(svgUrl, zoom, count, hovered) {
        const key = (svgUrl || '_') + '|' + zoom + '|' + count + '|' + (hovered ? 1 : 0);
        if (clusterIconCache.has(key)) return clusterIconCache.get(key);

        const baseSize = sizeForZoom(zoom);
        const size     = hovered ? Math.round(baseSize * 1.15) : baseSize;
        const visible  = Math.min(count, 3);
        const offset   = Math.max(3, Math.round(size * 0.18));
        const totalWidth  = size + offset * (visible - 1);
        const totalHeight = size + offset * (visible - 1);

        let svgStack = '';
        for (let i = 0; i < visible; i++) {
            const top  = offset * (visible - 1 - i);
            const left = offset * i;
            const opacity  = 1 - (i * 0.10);
            const scale    = 1 - (i * 0.04);
            const rotation = (i - (visible - 1) / 2) * 4;

            const inner = svgUrl
                ? '<img src="' + svgUrl + '" style="width:' + size + 'px;height:' + size + 'px;object-fit:contain;display:block;filter:drop-shadow(0 1px 3px rgba(15,23,42,0.4));">'
                : '<i class="fa-solid fa-sign-hanging" style="color:#2563EB;font-size:' + Math.round(size * 0.8) + 'px;"></i>';

            svgStack += '<div style="position:absolute;top:' + top + 'px;left:' + left + 'px;width:' + size + 'px;height:' + size + 'px;opacity:' + opacity + ';transform:scale(' + scale + ') rotate(' + rotation + 'deg);transform-origin:center center;z-index:' + (i + 1) + ';">' + inner + '</div>';
        }

        const badge = count > 3
            ? '<div style="position:absolute;bottom:-4px;right:-4px;min-width:18px;height:18px;padding:0 5px;background:linear-gradient(135deg,#DC2626,#EF4444);color:#fff;font-family:Inter,sans-serif;font-weight:800;font-size:10px;line-height:18px;text-align:center;border-radius:18px;border:2px solid #fff;box-shadow:0 2px 6px rgba(220,38,38,0.5);z-index:10;">+' + count + '</div>'
            : '';

        const html = '<div style="position:relative;width:' + totalWidth + 'px;height:' + totalHeight + 'px;' + (hovered ? 'transform:scale(1.08);' : '') + 'transition:transform 0.2s ease;">' + svgStack + badge + '</div>';

        const icon = L.divIcon({
            html: html,
            className: 'cluster-marker',
            iconSize:   [totalWidth, totalHeight],
            iconAnchor: [totalWidth / 2, totalHeight / 2],
            popupAnchor: [0, -totalHeight / 2]
        });
        clusterIconCache.set(key, icon);
        return icon;
    }

    function getEtatKey(etat) {
        const e = (etat || '').toLowerCase();
        if (e.indexOf('bon') !== -1) return 'bon';
        if (e.indexOf('dégrad') !== -1 || e.indexOf('degrad') !== -1) return 'degrade';
        if (e.indexOf('vandal') !== -1) return 'vandal';
        if (e.indexOf('masqu') !== -1) return 'masque';
        return 'aucun';
    }

    function buildClusterPopup(groupe) {
        const premier = groupe[0];
        let html = '<div style="font-family:Inter,sans-serif;min-width:220px;max-height:280px;overflow-y:auto;">'
            + '<div style="font-weight:800;color:#1E40AF;font-size:0.9rem;margin-bottom:6px;"><i class="fa-solid fa-layer-group"></i> ' + groupe.length + ' panneaux</div>'
            + '<div style="font-size:0.7rem;color:#94A3B8;margin-bottom:10px;padding-bottom:8px;border-bottom:2px solid #E0E7FF;"><i class="fa-solid fa-location-dot"></i> ' + Number(premier.lat).toFixed(5) + ', ' + Number(premier.lng).toFixed(5) + '</div>';

        groupe.forEach(function (p, idx) {
            const svgUrl = p.code_nomen ? BASE_SVG + '/' + p.code_nomen + '.svg' : null;
            html += '<div style="display:flex;gap:10px;align-items:center;padding:8px 0;' + (idx < groupe.length - 1 ? 'border-bottom:1px dashed #E2E8F0;' : '') + '">'
                + (svgUrl ? '<img src="' + svgUrl + '" style="width:32px;height:32px;object-fit:contain;flex-shrink:0;">' : '')
                + '<div style="flex:1;min-width:0;">'
                +   '<div style="font-weight:800;color:#1E40AF;font-size:0.82rem;">' + (p.code_nomen || '—') + '</div>'
                +   '<div style="font-size:0.7rem;color:#64748B;">' + (p.type_nom || p.name || '—') + '</div>'
                + '</div>'
                + '<a href="/signalisation/' + p.panneau_id + '" style="padding:4px 8px;background:#EFF6FF;color:#2563EB !important;border-radius:6px;font-size:0.7rem;font-weight:700;text-decoration:none;"><i class="fa-solid fa-eye"></i></a>'
                + '</div>';
        });
        html += '</div>';
        return html;
    }

    const allMarkers  = [];
    const markersById = {};

    /* =========================================================
       CRÉATION DES MARQUEURS (lazy batch)
    ========================================================= */
    const groupes = {};
    panneaux.forEach(function (p) {
        const key = p.lat.toFixed(5) + ',' + p.lng.toFixed(5);
        if (!groupes[key]) groupes[key] = [];
        groupes[key].push(p);
    });

    const groupesArray = Object.keys(groupes).map(function (k) { return groupes[k]; });

    function buildMarkerFromGroup(groupe) {
        const premier = groupe[0];
        const lat = parseFloat(premier.lat);
        const lng = parseFloat(premier.lng);
        const nb = groupe.length;
        const svgUrl = premier.code_nomen ? BASE_SVG + '/' + premier.code_nomen + '.svg' : null;
        const z0 = carte.getZoom();

        if (nb === 1) {
            const marker = L.marker([lat, lng], { icon: makeIcon(svgUrl, z0, false) });
            marker.on('click', function () { afficherDetail(premier); });
            marker._panneau = premier;
            marker._svgUrl = svgUrl;
            marker._isCluster = false;
            allMarkers.push(marker);
            markersById[premier.panneau_id] = marker;
            return marker;
        }

        const clusterMarker = L.marker([lat, lng], {
            icon: makeClusterIcon(svgUrl, z0, nb, false),
            zIndexOffset: 100
        });
        clusterMarker.bindPopup(function () { return buildClusterPopup(groupe); }, { maxWidth: 300, minWidth: 220 });
        clusterMarker.on('click', function () { afficherDetail(premier); });
        clusterMarker._panneau = premier;
        clusterMarker._svgUrl = svgUrl;
        clusterMarker._count = nb;
        clusterMarker._isCluster = true;
        allMarkers.push(clusterMarker);
        groupe.forEach(function (p) { markersById[p.panneau_id] = clusterMarker; });
        return clusterMarker;
    }

    let batchIndex = 0;
    const BATCH_SIZE = 30;
    function processBatch() {
        const end = Math.min(batchIndex + BATCH_SIZE, groupesArray.length);
        const markersToAdd = [];
        for (let i = batchIndex; i < end; i++) {
            markersToAdd.push(buildMarkerFromGroup(groupesArray[i]));
        }
        markersToAdd.forEach(function (m) { if (m) m.addTo(carte); });
        batchIndex = end;

        if (batchIndex < groupesArray.length) {
            requestAnimationFrame(processBatch);
        } else {
            console.log('✅ Tous les marqueurs créés :', allMarkers.length);
        }
    }
    requestAnimationFrame(processBatch);

    setTimeout(function () { carte.invalidateSize(true); }, 150);

    const updateIconsOnZoom = throttleRAF(function () {
        const z = carte.getZoom();
        allMarkers.forEach(function (marker) {
            if (marker._isCluster) marker.setIcon(makeClusterIcon(marker._svgUrl, z, marker._count, false));
            else marker.setIcon(makeIcon(marker._svgUrl, z, false));
        });
    });
    carte.on('zoomend', updateIconsOnZoom);

    /* =========================================================
       FIT ALL MARKERS
    ========================================================= */
    window.fitAllMarkers = function () {
        sessionStorage.removeItem(CARTE_STATE_KEY);

        let zoneBounds = null;

        if (ZONES_BOUNDS &&
            Number.isFinite(Number(ZONES_BOUNDS.min_lat)) &&
            Number.isFinite(Number(ZONES_BOUNDS.min_lng)) &&
            Number.isFinite(Number(ZONES_BOUNDS.max_lat)) &&
            Number.isFinite(Number(ZONES_BOUNDS.max_lng))) {
            zoneBounds = L.latLngBounds(
                [Number(ZONES_BOUNDS.min_lat), Number(ZONES_BOUNDS.min_lng)],
                [Number(ZONES_BOUNDS.max_lat), Number(ZONES_BOUNDS.max_lng)]
            );
        }

        if (!zoneBounds || !zoneBounds.isValid()) {
            zoneLayers.forEach(function (layer) {
                try {
                    const b = layer.getBounds();
                    if (b && b.isValid()) zoneBounds = zoneBounds ? zoneBounds.extend(b) : b;
                } catch (e) {}
            });
        }
        if (!zoneBounds || !zoneBounds.isValid()) zoneBounds = GRAND_TUNIS_BOUNDS;

        carte.fitBounds(zoneBounds, { padding: [40, 40], maxZoom: 11, animate: true });
        setTimeout(function () { carte.invalidateSize(true); }, 250);
    };

    /* =========================================================
       SLIDE PANEL
    ========================================================= */
    const slidePanel  = document.getElementById('slidePanel');
    const slideToggle = document.getElementById('slideToggle');

    window.toggleSlidePanel = function () {
        if (slidePanel.classList.contains('open')) closeSlidePanel();
        else openSlidePanel();
    };
    window.openSlidePanel  = function () { slidePanel.classList.add('open'); slideToggle.classList.add('hidden'); };
    window.closeSlidePanel = function () { slidePanel.classList.remove('open'); slideToggle.classList.remove('hidden'); };

    window.afficherDetail = function (p) {
        const etatKey   = getEtatKey(p.etat_actuel);
        const etatLabel = p.etat_actuel || 'Non observé';
        const svgUrl    = p.code_nomen ? BASE_SVG + '/' + p.code_nomen + '.svg' : null;

        document.getElementById('detailBody').innerHTML = ''
            + '<div class="detail-svg-box">'
            +   (svgUrl ? '<img src="' + svgUrl + '" alt="" onerror="this.style.display=\'none\'">' : '<i class="fa-solid fa-sign-hanging" style="color:#CBD5E1;font-size:2.5rem;"></i>')
            + '</div>'
            + '<h3 class="detail-code">' + (p.code_nomen || '—') + '</h3>'
            + '<p class="detail-name">' + (p.type_nom || p.name || 'Type inconnu') + '</p>'
            + '<div style="margin-bottom:14px;"><span class="badge-etat ' + etatKey + '">' + etatLabel + '</span></div>'
            + '<div class="detail-row"><span class="label">Route</span><span class="value">' + (p.route_nom || '—') + '</span></div>'
            + '<div class="detail-row"><span class="label">PK</span><span class="value">' + (p.point_kilo || '—') + '</span></div>'
            + '<div class="detail-row"><span class="label">Catégorie</span><span class="value">' + (p.type_categorie || '—') + '</span></div>'
            + '<div class="detail-row"><span class="label">Dernière obs.</span><span class="value">' + (p.date_obs ? new Date(p.date_obs).toLocaleDateString('fr-FR') : '—') + '</span></div>'
            + '<div class="detail-row"><span class="label">Photos</span><span class="value"><i class="fa-solid fa-camera" style="color:#7C3AED;"></i> ' + (p.nb_photos || 0) + '</span></div>'
            + '<div class="detail-row"><span class="label">Coordonnées</span><span class="value" style="font-size:0.72rem;font-family:monospace;">' + Number(p.lat).toFixed(5) + ', ' + Number(p.lng).toFixed(5) + '</span></div>'
            + '<div class="slide-actions">'
            +   '<button type="button" class="btn-slide btn-slide-success" onclick="openNewObservation(' + p.panneau_id + ')"><i class="fa-solid fa-plus-circle"></i> Nouvelle observation</button>'
            +   '<button type="button" class="btn-slide btn-slide-warning" onclick="startMovePanneau(' + p.panneau_id + ')"><i class="fa-solid fa-arrows-up-down-left-right"></i> Déplacer le point</button>'
            +   '<button type="button" class="btn-slide btn-slide-primary" onclick="openEditPanneau(' + p.panneau_id + ')"><i class="fa-solid fa-pen"></i> Modifier infos</button>'
            +   '<a href="/signalisation/' + p.panneau_id + '" class="btn-slide btn-slide-light"><i class="fa-solid fa-arrow-up-right-from-square"></i> Fiche complète</a>'
            +   '<button type="button" class="btn-slide btn-slide-light" onclick="centrerSur(' + p.panneau_id + ')"><i class="fa-solid fa-crosshairs"></i> Centrer</button>'
            + '</div>';

        openSlidePanel();
    };

    window.centrerSur = function (id) {
        const marker = markersById[id];
        if (marker) carte.setView(marker.getLatLng(), 16, { animate: true });
    };

    /* =========================================================
       PLACEMENT
    ========================================================= */
    const placementBanner = document.getElementById('placementBanner');
    const placementText   = document.getElementById('placementText');
    const placementIcon   = document.getElementById('placementIcon');

    window.startNewPanneauPlacement = function () {
        placementMode = 'new'; movePanneauId = null; pickPositionCallback = null;
        placementBanner.classList.add('active'); placementBanner.classList.remove('moving');
        placementText.textContent = 'Cliquez sur la carte pour placer le nouveau panneau';
        placementIcon.className = 'fa-solid fa-crosshairs';
        carte.getContainer().style.cursor = 'crosshair';
        closeSlidePanel();
    };

    window.startMovePanneau = function (id) {
        placementMode = 'move'; movePanneauId = id; pickPositionCallback = null;
        placementBanner.classList.add('active'); placementBanner.classList.add('moving');
        placementText.textContent = 'Cliquez sur la carte pour déplacer le point';
        placementIcon.className = 'fa-solid fa-arrows-up-down-left-right';
        carte.getContainer().style.cursor = 'crosshair';
        closeSlidePanel();
        const marker = markersById[id];
        if (marker) carte.setView(marker.getLatLng(), 16, { animate: true });
    };

    window.cancelPlacement = function () {
        placementMode = null; movePanneauId = null; pickPositionCallback = null;
        placementBanner.classList.remove('active');
        carte.getContainer().style.cursor = '';
        if (tempMarker) { carte.removeLayer(tempMarker); tempMarker = null; }
    };

    carte.on('click', function (e) {
        if (!placementMode) return;
        if (e.originalEvent && e.originalEvent.target) {
            const t = e.originalEvent.target;
            if (t.tagName === 'path' || t.tagName === 'svg') return;
        }
        const lat = e.latlng.lat, lng = e.latlng.lng;
        if (tempMarker) carte.removeLayer(tempMarker);
        const tempIcon = L.divIcon({
            html: '<div class="temp-marker-inner"><i class="fa-solid fa-location-crosshairs"></i></div>',
            className: 'temp-marker', iconSize: [40, 40], iconAnchor: [20, 20]
        });
        tempMarker = L.marker([lat, lng], { icon: tempIcon }).addTo(carte);

        if (placementMode === 'new') { openCreatePanneau(lat, lng); cancelPlacement(); return; }
        if (placementMode === 'move') {
            if (confirm('Confirmer le déplacement ?')) movePanneauPosition(movePanneauId, lat, lng);
            cancelPlacement(); return;
        }
        if (placementMode === 'pick' && typeof pickPositionCallback === 'function') {
            const cb = pickPositionCallback;
            pickPositionCallback = null;
            cancelPlacement();
            cb(lat, lng);
        }
    });

    /* =========================================================
       MODALE PANNEAU
    ========================================================= */
    const modalPanneauEl = document.getElementById('modalPanneau');
    const bsModalPanneau = new bootstrap.Modal(modalPanneauEl);
    let currentMode = 'edit';

    function updateCoordsLabels() {
        const lat = document.getElementById('p_lat').value;
        const lng = document.getElementById('p_lng').value;
        document.getElementById('coordLatLabel').textContent = lat ? Number(lat).toFixed(6) : '—';
        document.getElementById('coordLngLabel').textContent = lng ? Number(lng).toFixed(6) : '—';
    }
    window.updateCoordsLabels = updateCoordsLabels;
    document.getElementById('p_lat').addEventListener('input', updateCoordsLabels);
    document.getElementById('p_lng').addEventListener('input', updateCoordsLabels);

    window.openCreatePanneau = function (lat, lng) {
        currentMode = 'create';
        document.getElementById('modalPanneauTitle').innerHTML = '<i class="fa-solid fa-plus-circle"></i> Nouveau panneau';
        document.getElementById('modalPanneauSubtitle').textContent = 'Position : ' + lat.toFixed(6) + ', ' + lng.toFixed(6);
        document.getElementById('modalPanneauHeader').style.background = 'linear-gradient(135deg, #059669, #10B981)';
        const form = document.getElementById('formPanneau');
        form.action = '/carte/panneau';
        document.getElementById('formPanneauMethod').value = 'POST';
        form.reset();
        document.getElementById('p_lat').value = lat.toFixed(7);
        document.getElementById('p_lng').value = lng.toFixed(7);
        document.getElementById('p_duree_vie_ans').value = '10';
        updateCoordsLabels();
        const firstTab = modalPanneauEl.querySelector('.nav-tabs .nav-link');
        if (firstTab) new bootstrap.Tab(firstTab).show();
        bsModalPanneau.show();
    };

    window.openEditPanneau = function (id) {
        const p = panneaux.find(function (x) { return String(x.panneau_id) === String(id); });
        if (!p) { alert('Panneau introuvable'); return; }
        currentMode = 'edit';
        document.getElementById('modalPanneauTitle').innerHTML = '<i class="fa-solid fa-pen-to-square"></i> Modifier le panneau';
        document.getElementById('modalPanneauSubtitle').textContent = (p.code_nomen || '—') + ' — ' + (p.type_nom || p.name || '');
        document.getElementById('modalPanneauHeader').style.background = 'linear-gradient(135deg, #1E40AF, #2563EB)';
        const form = document.getElementById('formPanneau');
        form.action = '/carte/panneau/' + id;
        document.getElementById('formPanneauMethod').value = 'PUT';

        const map = {
            p_code_nomen: 'code_nomen', p_fclass: 'fclass', p_name: 'name',
            p_num_agrement: 'num_agrement', p_code_panneau_cctp: 'code_panneau_cctp',
            p_hc_caractere: 'hc_caractere', p_dim_cctp: 'dim_cctp',
            p_lat: 'lat', p_lng: 'lng', p_route_nom: 'route_nom',
            p_point_kilo: 'point_kilo', p_route: 'route',
            p_acier_nuance: 'acier_nuance', p_nature_mat: 'nature_mat',
            p_type_subje: 'type_subje', p_galva_depot: 'galva_depot',
            p_largeur_latte: 'largeur_latte', p_type_film_retro: 'type_film_retro',
            p_garantie_film_ans: 'garantie_film_ans', p_dimensions: 'dimensions',
            p_couleur_fo: 'couleur_fo', p_protection: 'protection',
            p_type_suppo: 'type_suppo', p_matiere_support: 'matiere_support',
            p_nb_raidisseurs: 'nb_raidisseurs', p_resistance: 'resistance',
            p_hauteur_so: 'hauteur_so', p_hauteur_libre_m: 'hauteur_libre_m',
            p_implantation_m: 'implantation_m', p_fiche_ancrage_m: 'fiche_ancrage_m',
            p_duree_vie_ans: 'duree_vie_ans'
        };
        Object.keys(map).forEach(function (domId) {
            const el = document.getElementById(domId);
            if (el) el.value = p[map[domId]] || '';
        });

        document.getElementById('p_anodise').value =
            (p.anodise === true || p.anodise === 't' || p.anodise === 1) ? '1'
            : (p.anodise === false || p.anodise === 'f' || p.anodise === 0) ? '0' : '';

        document.getElementById('p_date_pose').value = p.date_pose ? p.date_pose.slice(0, 10) : '';
        document.getElementById('p_duree_vie_ans').value = p.duree_vie_ans || '10';

        updateCoordsLabels();
        const firstTab = modalPanneauEl.querySelector('.nav-tabs .nav-link');
        if (firstTab) new bootstrap.Tab(firstTab).show();
        bsModalPanneau.show();
    };

    /* =========================================================
       GÉOLOCALISATION — MA POSITION (style Google Maps)
       - Zoom automatique
       - Suivi continu (watchPosition)
       - Bouton flottant de recentrage
       - Cercle de précision dynamique
    ========================================================= */
    let userLocationMarker = null;
    let userAccuracyCircle = null;
    let userWatchId = null;
    let userLastPosition = null;
    let userHasZoomedOnce = false;

    const userLocationBanner = document.getElementById('userLocationBanner');
    const userLocationText   = document.getElementById('userLocationText');
    const btnLocateMe        = document.getElementById('btnLocateMe');

    /* Icône style Google Maps */
    const userIcon = L.divIcon({
        className: 'user-location-marker',
        html: '<div class="pulse-ring"></div><div class="pulse-dot"></div>',
        iconSize: [0, 0],
        iconAnchor: [0, 0]
    });

    function showUserLocationBanner(text, isError) {
        if (!userLocationBanner) return;
        userLocationText.textContent = text;
        userLocationBanner.classList.add('active');
        if (isError) {
            userLocationBanner.style.background = '#FEF2F2';
            userLocationBanner.style.borderColor = '#FECACA';
            userLocationBanner.style.color = '#991B1B';
            const dot = userLocationBanner.querySelector('.loc-dot');
            if (dot) dot.style.background = '#DC2626';
        } else {
            userLocationBanner.style.background = 'rgba(255, 255, 255, 0.98)';
            userLocationBanner.style.borderColor = '#E2E8F0';
            userLocationBanner.style.color = '#0F172A';
            const dot = userLocationBanner.querySelector('.loc-dot');
            if (dot) dot.style.background = '#2563EB';
        }
    }
    window.hideUserLocationBanner = function () {
        if (userLocationBanner) userLocationBanner.classList.remove('active');
    };

    function isSecureOk() {
        return window.isSecureContext === true
            || location.protocol === 'https:'
            || location.hostname === 'localhost'
            || location.hostname === '127.0.0.1';
    }

    /* Mettre à jour la position sur la carte */
    function updateUserPositionOnMap(lat, lng, accuracy, shouldZoom) {
        userLastPosition = { lat: lat, lng: lng, accuracy: accuracy };

        /* Cercle de précision */
        if (userAccuracyCircle) {
            userAccuracyCircle.setLatLng([lat, lng]);
            userAccuracyCircle.setRadius(accuracy);
        } else {
            userAccuracyCircle = L.circle([lat, lng], {
                radius: accuracy,
                color: '#2563EB',
                fillColor: '#2563EB',
                fillOpacity: 0.12,
                weight: 1.5,
                opacity: 0.4,
                interactive: false
            }).addTo(carte);
        }

        /* Marqueur */
        if (userLocationMarker) {
            userLocationMarker.setLatLng([lat, lng]);
        } else {
            userLocationMarker = L.marker([lat, lng], {
                icon: userIcon,
                zIndexOffset: 10000,
                interactive: true,
                keyboard: false
            }).addTo(carte);

            userLocationMarker.bindPopup(function () {
                const acc = userLastPosition ? Math.round(userLastPosition.accuracy) : 0;
                return '<div style="font-family:Inter,sans-serif; text-align:center; min-width:200px;">' +
                    '<div style="font-weight:800; color:#1E40AF; font-size:0.9rem; margin-bottom:6px;">' +
                        '<i class="fa-solid fa-location-crosshairs"></i> Votre position' +
                    '</div>' +
                    '<div style="font-size:0.75rem; color:#64748B; font-family:monospace; margin-bottom:8px;">' +
                        lat.toFixed(6) + ', ' + lng.toFixed(6) +
                    '</div>' +
                    '<div style="font-size:0.72rem; color:#94A3B8; margin-bottom:10px;">' +
                        'Précision : ±' + acc + ' m' +
                    '</div>' +
                    '<button type="button" onclick="startNewPanneauAtMyPosition(' + lat + ',' + lng + ')" ' +
                        'style="width:100%; padding:8px 12px; border-radius:8px; border:none; background:linear-gradient(135deg,#059669,#10B981); color:#fff; font-size:0.78rem; font-weight:700; cursor:pointer;">' +
                        '<i class="fa-solid fa-plus"></i> Créer un panneau ici' +
                    '</button>' +
                '</div>';
            }, { maxWidth: 260 });
        }

        /* ✅ ZOOM AUTOMATIQUE style Google Maps */
        if (shouldZoom) {
            const targetZoom = accuracy < 30 ? 18 : accuracy < 100 ? 17 : 16;
            carte.flyTo([lat, lng], targetZoom, {
                animate: true,
                duration: 1.2,
                easeLinearity: 0.25
            });
        }
    }

    /* ✅ Localiser (avec watchPosition pour suivi continu) */
    window.locateMe = function () {
        if (!navigator.geolocation) {
            showUserLocationBanner('❌ Géolocalisation non supportée par ce navigateur.', true);
            return;
        }
        if (!isSecureOk()) {
            showUserLocationBanner('❌ HTTPS requis pour la géolocalisation.', true);
            return;
        }

        /* État de chargement */
        if (btnLocateMe) {
            btnLocateMe.classList.add('loading');
            const icon = btnLocateMe.querySelector('i');
            if (icon) icon.className = 'fa-solid fa-spinner';
        }
        showUserLocationBanner('📍 Recherche de votre position...', false);

        /* Arrêter l'ancien watch */
        if (userWatchId !== null) {
            navigator.geolocation.clearWatch(userWatchId);
            userWatchId = null;
        }

        /* Afficher le bouton flottant */
        const btnRecenter = document.getElementById('btnRecenter');
        if (btnRecenter) btnRecenter.style.display = 'flex';

        let firstFix = true;
        userWatchId = navigator.geolocation.watchPosition(
            function (pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                const accuracy = pos.coords.accuracy;

                if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

                updateUserPositionOnMap(lat, lng, accuracy, firstFix || !userHasZoomedOnce);

                if (firstFix || !userHasZoomedOnce) {
                    userHasZoomedOnce = true;
                    firstFix = false;
                }

                showUserLocationBanner('📍 Position active (±' + Math.round(accuracy) + ' m)', false);

                if (btnLocateMe) {
                    btnLocateMe.classList.remove('loading');
                    const icon = btnLocateMe.querySelector('i');
                    if (icon) icon.className = 'fa-solid fa-location-crosshairs';
                }

                if (btnRecenter) {
                    btnRecenter.classList.add('active');
                    btnRecenter.style.display = 'flex';
                }

                setTimeout(hideUserLocationBanner, 4000);
            },
            function (error) {
                let msg = '❌ Erreur de géolocalisation.';
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        msg = '❌ Accès refusé. Autorisez la localisation dans les paramètres du navigateur.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        msg = '❌ Position indisponible. Activez le GPS.';
                        break;
                    case error.TIMEOUT:
                        msg = '❌ Délai dépassé. Réessayez.';
                        break;
                }
                showUserLocationBanner(msg, true);

                if (btnLocateMe) {
                    btnLocateMe.classList.remove('loading');
                    const icon = btnLocateMe.querySelector('i');
                    if (icon) icon.className = 'fa-solid fa-location-crosshairs';
                }
                setTimeout(hideUserLocationBanner, 7000);
            },
            {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            }
        );
    };

    /* ✅ Recentrer sur la position (bouton flottant) */
    window.centerOnMyPosition = function () {
        if (!userLastPosition) {
            locateMe();
            return;
        }
        const { lat, lng, accuracy } = userLastPosition;
        const targetZoom = accuracy < 30 ? 18 : accuracy < 100 ? 17 : 16;

        carte.flyTo([lat, lng], targetZoom, {
            animate: true,
            duration: 1.0
        });

        if (userLocationMarker) {
            userLocationMarker.openPopup();
            setTimeout(function () {
                if (userLocationMarker) userLocationMarker.closePopup();
            }, 3000);
        }
    };

    /* Arrêter le suivi */
    window.stopLocateMe = function () {
        if (userWatchId !== null) {
            navigator.geolocation.clearWatch(userWatchId);
            userWatchId = null;
        }
    };

    /* Créer un panneau à ma position */
    window.startNewPanneauAtMyPosition = function (lat, lng) {
        if (userLocationMarker) userLocationMarker.closePopup();
        openCreatePanneau(lat, lng);
    };

    /* Nettoyer à la fermeture */
    window.addEventListener('beforeunload', stopLocateMe);

    /* =========================================================
       GPS DANS LA MODALE
    ========================================================= */
    window.useMyPositionInModal = function () {
        if (!navigator.geolocation) {
            showGeoFallback('La géolocalisation n\'est pas supportée par ce navigateur.');
            return;
        }
        if (!isSecureOk()) {
            showGeoFallback('La géolocalisation nécessite une connexion sécurisée (HTTPS).<br>Utilisez le bouton <strong>"Cliquer sur la carte"</strong>.');
            return;
        }

        const btns = document.querySelectorAll('.btn-coord-gps');
        btns.forEach(function (b) {
            b.disabled = true;
            b.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Localisation...';
        });

        navigator.geolocation.getCurrentPosition(
            function (pos) {
                document.getElementById('p_lat').value = pos.coords.latitude.toFixed(7);
                document.getElementById('p_lng').value = pos.coords.longitude.toFixed(7);
                updateCoordsLabels();

                btns.forEach(function (b) {
                    b.disabled = false;
                    b.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Ma position';
                });

                if (window.__carte) {
                    window.__carte.flyTo([pos.coords.latitude, pos.coords.longitude], 17, {
                        animate: true, duration: 1.0
                    });
                }
            },
            function (err) {
                btns.forEach(function (b) {
                    b.disabled = false;
                    b.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Ma position';
                });

                let msg = 'Impossible d\'obtenir votre position.';
                switch (err.code) {
                    case err.PERMISSION_DENIED:
                        msg = 'Vous avez refusé la géolocalisation.<br>Autorisez-la dans les paramètres du navigateur.';
                        break;
                    case err.POSITION_UNAVAILABLE:
                        msg = 'Position indisponible. Vérifiez votre GPS / connexion.';
                        break;
                    case err.TIMEOUT:
                        msg = 'Délai dépassé. Réessayez ou utilisez le bouton "Cliquer sur la carte".';
                        break;
                }
                showGeoFallback(msg);
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    };

    function showGeoFallback(message) {
        const old = document.getElementById('geoFallback');
        if (old) old.remove();

        const box = document.createElement('div');
        box.id = 'geoFallback';
        box.style.cssText =
            'margin: 14px 0; padding: 14px 16px; ' +
            'background: #FEF3C7; border-left: 4px solid #F59E0B; ' +
            'border-radius: 10px; font-size: 0.82rem; color: #78350F; ' +
            'line-height: 1.5; font-family: Inter, sans-serif;';

        box.innerHTML =
            '<div style="display:flex; align-items:flex-start; gap:10px;">' +
                '<i class="fa-solid fa-triangle-exclamation" style="color:#F59E0B; font-size:1.1rem; margin-top:2px;"></i>' +
                '<div style="flex:1;">' +
                    '<div style="font-weight:800; margin-bottom:4px; color:#78350F !important;">Géolocalisation indisponible</div>' +
                    '<div style="margin-bottom:10px; color:#78350F !important;">' + message + '</div>' +
                    '<div style="display:flex; gap:8px; flex-wrap:wrap;">' +
                        '<button type="button" onclick="geoFallbackUseMap()" style="display:inline-flex; align-items:center; gap:6px; padding:7px 12px; border-radius:8px; border:none; background:linear-gradient(135deg,#059669,#10B981); color:#fff; font-size:0.75rem; font-weight:700; cursor:pointer;">' +
                            '<i class="fa-solid fa-hand-pointer"></i> Choisir sur la carte' +
                        '</button>' +
                        '<button type="button" onclick="document.getElementById(\'geoFallback\').remove()" style="display:inline-flex; align-items:center; gap:6px; padding:7px 12px; border-radius:8px; background:#F1F5F9; border:1px solid #E2E8F0; color:#475569; font-size:0.75rem; font-weight:700; cursor:pointer;">' +
                            '<i class="fa-solid fa-xmark"></i> Fermer' +
                        '</button>' +
                    '</div>' +
                '</div>' +
            '</div>';

        const coordsBlock = document.querySelector('.coords-block');
        if (coordsBlock) {
            coordsBlock.parentNode.insertBefore(box, coordsBlock.nextSibling);
        }
    }
    window.showGeoFallback = showGeoFallback;

    window.geoFallbackUseMap = function () {
        const box = document.getElementById('geoFallback');
        if (box) box.remove();
        if (typeof pickPositionOnMap === 'function') pickPositionOnMap();
    };

    window.pickPositionOnMap = function () {
        const form = document.getElementById('formPanneau');
        const currentAction = form.action;
        const previousMode  = currentMode;

        bsModalPanneau.hide();

        placementMode = 'pick';
        placementBanner.classList.add('active');
        placementBanner.classList.remove('moving');
        placementText.textContent = 'Cliquez sur la carte pour choisir la position';
        placementIcon.className = 'fa-solid fa-hand-pointer';
        carte.getContainer().style.cursor = 'crosshair';

        pickPositionCallback = function (lat, lng) {
            if (previousMode === 'create') {
                openCreatePanneau(lat, lng);
            } else {
                const editId = currentAction.split('/').pop();
                openEditPanneau(editId);
                setTimeout(function () {
                    document.getElementById('p_lat').value = lat.toFixed(7);
                    document.getElementById('p_lng').value = lng.toFixed(7);
                    updateCoordsLabels();
                }, 450);
            }
        };
    };

    /* =========================================================
       SUBMIT FORM PANNEAU
    ========================================================= */
    const formPanneau = document.getElementById('formPanneau');
    let isSubmittingPanneau = false;

    formPanneau.addEventListener('submit', function (e) {
        e.preventDefault();
        if (isSubmittingPanneau) return;
        isSubmittingPanneau = true;

        const errorBox   = document.getElementById('panneauError');
        const successBox = document.getElementById('panneauSuccess');
        const btn        = document.getElementById('btnSubmitPanneau');

        errorBox.classList.add('d-none');
        successBox.classList.add('d-none');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Enregistrement...';

        fetch(formPanneau.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: new FormData(formPanneau)
        })
        .then(async function (response) {
            const data = await response.json();
            if (!response.ok) {
                let messages = [];
                if (data.errors) Object.values(data.errors).forEach(function (arr) { arr.forEach(function (m) { messages.push(m); }); });
                else if (data.message) messages.push(data.message);
                else messages.push('Une erreur est survenue.');
                throw new Error(messages.join('<br>'));
            }
            return data;
        })
        .then(function (data) {
            successBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (data.message || 'Enregistré !');
            successBox.classList.remove('d-none');
            window.rechargerPageEnConservantEtat(900);
        })
        .catch(function (err) {
            errorBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + err.message;
            errorBox.classList.remove('d-none');
            isSubmittingPanneau = false;
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Enregistrer';
        });
    });

    window.movePanneauPosition = function (id, lat, lng) {
        const p = panneaux.find(function (x) { return String(x.panneau_id) === String(id); });
        if (!p) return;

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('_token', CSRF);
        formData.append('lat', lat);
        formData.append('lng', lng);

        ['code_nomen','fclass','name','route_nom','point_kilo','route',
         'nature_mat','type_subje','dimensions','couleur_fo','protection',
         'type_suppo','hauteur_so','resistance','num_agrement'].forEach(function (k) {
            if (p[k] != null) formData.append(k, p[k]);
        });

        fetch('/carte/panneau/' + id, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: formData
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.success) {
                alert('✅ Position mise à jour avec succès.');
                window.rechargerPageEnConservantEtat(300);
            } else {
                alert('❌ Erreur : ' + (data.message || 'inconnue'));
            }
        })
        .catch(function () { alert('❌ Erreur réseau.'); });
    };

    window.openNewObservation = function (id) {
        const p = panneaux.find(function (x) { return String(x.panneau_id) === String(id); });
        if (!p) { alert('Panneau introuvable'); return; }

        document.getElementById('newObsSubtitle').textContent =
            (p.code_nomen || '—') + ' — ' + (p.route_nom || '') + ' PK ' + (p.point_kilo || '');

        document.getElementById('formNewObservation').action = '/signalisation/' + id + '/observation';
        new bootstrap.Modal(document.getElementById('modalNewObservation')).show();
    };

    window.previewPhotos = function (input, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        container.innerHTML = '';
        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach(function (file) {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = function (e) {
                    const div = document.createElement('div');
                    div.className = 'photo-preview-item';
                    div.innerHTML = '<img src="' + e.target.result + '" alt="preview">';
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    };

    const formNewObs = document.getElementById('formNewObservation');
    if (formNewObs) {
        let isSubmitting = false;
        formNewObs.addEventListener('submit', function (e) {
            e.preventDefault();
            if (isSubmitting) return;
            isSubmitting = true;

            const errorBox   = document.getElementById('newObsError');
            const successBox = document.getElementById('newObsSuccess');
            const btn        = document.getElementById('btnSubmitNewObs');

            errorBox.classList.add('d-none');
            successBox.classList.add('d-none');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Enregistrement...';

            fetch(formNewObs.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: new FormData(formNewObs)
            })
            .then(async function (response) {
                const data = await response.json();
                if (!response.ok) {
                    let messages = [];
                    if (data.errors) Object.values(data.errors).forEach(function (arr) { arr.forEach(function (m) { messages.push(m); }); });
                    else if (data.message) messages.push(data.message);
                    else messages.push('Une erreur est survenue.');
                    throw new Error(messages.join('<br>'));
                }
                return data;
            })
            .then(function (data) {
                successBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (data.message || 'Enregistré !');
                successBox.classList.remove('d-none');
                window.rechargerPageEnConservantEtat(900);
            })
            .catch(function (err) {
                errorBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + err.message;
                errorBox.classList.remove('d-none');
                isSubmitting = false;
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Enregistrer l\'observation';
            });
        });
    }

    /* =========================================================
       FILTRES AVANCÉS
    ========================================================= */
    const filtersPanel = document.getElementById('filtersPanel');
    let filtersOpen = false;

    window.toggleFiltersPanel = function () {
        filtersOpen = !filtersOpen;
        filtersPanel.classList.toggle('open', filtersOpen);
    };

    function populateFilterOptions() {
        const routesSet = new Set(), categoriesSet = new Set(), nomsSet = new Set();

        panneaux.forEach(function (p) {
            if (p.route_nom && String(p.route_nom).trim()) routesSet.add(String(p.route_nom).trim());
            if (p.type_categorie && String(p.type_categorie).trim()) categoriesSet.add(String(p.type_categorie).trim());
            const nom = String(p.type_nom || p.name || '').trim();
            if (nom) nomsSet.add(nom);
        });

        const filterRoute = document.getElementById('filterRoute');
        const fragRoute = document.createDocumentFragment();
        Array.from(routesSet).sort().forEach(function (r) {
            const opt = document.createElement('option');
            opt.value = r; opt.textContent = r;
            fragRoute.appendChild(opt);
        });
        filterRoute.appendChild(fragRoute);

        const filterCategorie = document.getElementById('filterCategorie');
        const fragCat = document.createDocumentFragment();
        Array.from(categoriesSet).sort().forEach(function (c) {
            const opt = document.createElement('option');
            opt.value = c; opt.textContent = c;
            fragCat.appendChild(opt);
        });
        filterCategorie.appendChild(fragCat);

        const filterNom = document.getElementById('filterNom');
        const fragNom = document.createDocumentFragment();
        Array.from(nomsSet).sort().forEach(function (n) {
            const opt = document.createElement('option');
            opt.value = n; opt.textContent = n;
            fragNom.appendChild(opt);
        });
        filterNom.appendChild(fragNom);
    }
    populateFilterOptions();

    function getActiveFilters() {
        return {
            route:     document.getElementById('filterRoute').value,
            categorie: document.getElementById('filterCategorie').value,
            etat:      document.getElementById('filterEtat').value,
            nom:       document.getElementById('filterNom').value,
            pkMin:     document.getElementById('filterPkMin').value,
            pkMax:     document.getElementById('filterPkMax').value,
            dateRange: document.getElementById('filterDateRange').value
        };
    }

    function panneauMatchesFilters(p, f) {
        if (f.route && String(p.route_nom || '').trim() !== f.route) return false;
        if (f.categorie && String(p.type_categorie || '').trim() !== f.categorie) return false;
        if (f.etat) {
            if (f.etat === '__aucun__') { if (p.etat_actuel && String(p.etat_actuel).trim()) return false; }
            else { if (String(p.etat_actuel || '').trim() !== f.etat) return false; }
        }
        if (f.nom) {
            const nomPanneau = String(p.type_nom || p.name || '').trim();
            if (nomPanneau !== f.nom) return false;
        }
        if (f.pkMin !== '' && f.pkMin != null) {
            const pk = parseFloat(p.point_kilo);
            if (!Number.isFinite(pk) || pk < parseFloat(f.pkMin)) return false;
        }
        if (f.pkMax !== '' && f.pkMax != null) {
            const pk = parseFloat(p.point_kilo);
            if (!Number.isFinite(pk) || pk > parseFloat(f.pkMax)) return false;
        }
        if (f.dateRange) {
            if (f.dateRange === '__jamais__') { if (p.date_obs) return false; }
            else {
                if (!p.date_obs) return false;
                const days = parseInt(f.dateRange, 10);
                const dateObs = new Date(p.date_obs);
                const limite = new Date(); limite.setDate(limite.getDate() - days);
                if (dateObs < limite) return false;
            }
        }
        return true;
    }

    function countActiveFilters(f) {
        let n = 0;
        if (f.route) n++;
        if (f.categorie) n++;
        if (f.etat) n++;
        if (f.nom) n++;
        if (f.pkMin !== '' && f.pkMin != null) n++;
        if (f.pkMax !== '' && f.pkMax != null) n++;
        if (f.dateRange) n++;
        return n;
    }

    window.applyFilters = function () {
        const f = getActiveFilters();
        const nbActifs = countActiveFilters(f);

        const btnFilter = document.querySelector('.btn-topbar[onclick="toggleFiltersPanel()"]');
        const badge = document.getElementById('filtersCountBadge');
        if (btnFilter) {
            if (nbActifs > 0) {
                btnFilter.classList.add('btn-topbar-filter-active');
                if (badge) { badge.textContent = nbActifs; badge.style.display = 'inline-block'; }
            } else {
                btnFilter.classList.remove('btn-topbar-filter-active');
                if (badge) badge.style.display = 'none';
            }
        }

        allMarkers.forEach(function (m) { carte.removeLayer(m); });

        let visibles = 0;
        allMarkers.forEach(function (m) {
            if (panneauMatchesFilters(m._panneau, f)) { carte.addLayer(m); visibles++; }
        });

        const countEl = document.getElementById('filtersResultCount');
        if (countEl) countEl.textContent = visibles + ' résultat' + (visibles > 1 ? 's' : '');

        if (visibles > 0 && visibles < allMarkers.length) {
            const visiblesMarkers = allMarkers.filter(function (m) { return carte.hasLayer(m); });
            if (visiblesMarkers.length > 0) {
                try {
                    const group = L.featureGroup(visiblesMarkers);
                    carte.fitBounds(group.getBounds().pad(0.15));
                } catch (e) {}
            }
        }
    };

    window.resetAllFilters = function () {
        document.getElementById('filterRoute').value = '';
        document.getElementById('filterCategorie').value = '';
        document.getElementById('filterEtat').value = '';
        document.getElementById('filterNom').value = '';
        document.getElementById('filterPkMin').value = '';
        document.getElementById('filterPkMax').value = '';
        document.getElementById('filterDateRange').value = '';

        allMarkers.forEach(function (m) { if (!carte.hasLayer(m)) carte.addLayer(m); });

        const btnFilter = document.querySelector('.btn-topbar[onclick="toggleFiltersPanel()"]');
        const badge = document.getElementById('filtersCountBadge');
        if (btnFilter) btnFilter.classList.remove('btn-topbar-filter-active');
        if (badge) badge.style.display = 'none';

        const countEl = document.getElementById('filtersResultCount');
        if (countEl) countEl.textContent = allMarkers.length + ' résultats';

        document.querySelectorAll('.kpi-chip').forEach(function (c) { c.classList.remove('active'); });
        const totalChip = document.querySelector('.kpi-chip[data-filtre-etat=""]');
        if (totalChip) totalChip.classList.add('active');
    };

    const countElInit = document.getElementById('filtersResultCount');
    if (countElInit) countElInit.textContent = allMarkers.length + ' résultats';

    /* =========================================================
       RECHERCHE + FILTRE KPI
    ========================================================= */
    document.getElementById('searchInput').addEventListener('input', debounce(function () {
        const q = this.value.toLowerCase().trim();
        if (q) window.resetAllFilters();

        allMarkers.forEach(function (m) {
            const p = m._panneau;
            if (!q) { if (!carte.hasLayer(m)) carte.addLayer(m); return; }
            const match = (p.code_nomen || '').toLowerCase().indexOf(q) !== -1
                       || (p.route_nom || '').toLowerCase().indexOf(q) !== -1
                       || (String(p.point_kilo || '')).toLowerCase().indexOf(q) !== -1;
            if (match) { if (!carte.hasLayer(m)) carte.addLayer(m); }
            else if (carte.hasLayer(m)) carte.removeLayer(m);
        });
    }, 300));

    document.querySelectorAll('.kpi-chip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            window.resetAllFilters();

            const filtre = this.dataset.filtreEtat;
            document.querySelectorAll('.kpi-chip').forEach(function (c) { c.classList.remove('active'); });
            this.classList.add('active');

            document.getElementById('searchInput').value = '';
            allMarkers.forEach(function (m) { if (!carte.hasLayer(m)) carte.addLayer(m); });

            if (!filtre) { window.fitAllMarkers(); return; }

            const mapping = { 'Bon': 'bon', 'Dégradé': 'degrade', 'Vandalisé': 'vandal', 'Masqué': 'masque' };
            allMarkers.forEach(function (m) { carte.removeLayer(m); });

            const visibles = [];
            allMarkers.forEach(function (m) {
                if (getEtatKey(m._panneau.etat_actuel) === mapping[filtre]) {
                    carte.addLayer(m);
                    visibles.push(m);
                }
            });

            if (visibles.length > 0) {
                const group  = L.featureGroup(visibles);
                carte.fitBounds(group.getBounds().pad(0.15));
            }
        });
    });

});
</script>

</body>
</html>
