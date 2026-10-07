@extends('template.admin_master')

@section('Content')

<style>
    .show-page {
        padding: 24px;
        background: #F8FAFC !important;
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
        color: #0F172A !important;
    }

    /* HERO */
    .show-hero {
        background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
        box-shadow: 0 12px 28px rgba(30, 64, 175, 0.25);
        position: relative;
        overflow: hidden;
    }
    .show-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }
    .hero-left { display: flex; align-items: center; gap: 20px; position: relative; z-index: 1; flex: 1; min-width: 0; }
    .hero-svg-box {
        width: 90px; height: 90px;
        background: rgba(255, 255, 255, 0.98);
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        padding: 10px; flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .hero-svg-box img { max-width: 100%; max-height: 100%; object-fit: contain; }
    .hero-info { min-width: 0; flex: 1; }
    .hero-code { font-size: 2rem; font-weight: 800; color: #fff !important; line-height: 1.1; letter-spacing: -0.03em; margin: 0 0 6px; }
    .hero-name { font-size: 0.98rem; color: rgba(255, 255, 255, 0.9) !important; margin: 0; line-height: 1.4; }
    .hero-loc {
        display: inline-flex; align-items: center; gap: 6px;
        margin-top: 10px; padding: 5px 12px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 100px; font-size: 0.8rem;
        color: #fff !important; font-weight: 600;
    }
    .hero-right { display: flex; gap: 10px; flex-wrap: wrap; position: relative; z-index: 1; }
    .btn-hero {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 18px; border-radius: 10px;
        font-size: 0.85rem; font-weight: 600;
        text-decoration: none; transition: all 0.2s ease;
        cursor: pointer; border: none;
    }
    .btn-hero-light { background: rgba(255, 255, 255, 0.95); color: #1E40AF !important; }
    .btn-hero-light:hover { background: #fff; transform: translateY(-2px); color: #1E40AF !important; }
    .btn-hero-outline { background: rgba(255, 255, 255, 0.12); color: #fff !important; border: 1.5px solid rgba(255, 255, 255, 0.3); }
    .btn-hero-outline:hover { background: rgba(255, 255, 255, 0.2); color: #fff !important; }

    /* KPI */
    .kpi-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
    @media (max-width: 992px) { .kpi-strip { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .kpi-strip { grid-template-columns: 1fr; } }

    .kpi-box {
        background: #fff !important; border: 1px solid #E2E8F0;
        border-radius: 14px; padding: 18px 20px;
        display: flex; align-items: center; gap: 14px;
        transition: all 0.2s ease;
    }
    .kpi-box:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(15,23,42,0.06); }
    .kpi-icon-box { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; flex-shrink: 0; }
    .kpi-icon-box.blue   { background: rgba(37,99,235,0.10); color: #2563EB; }
    .kpi-icon-box.green  { background: rgba(16,185,129,0.12); color: #059669; }
    .kpi-icon-box.orange { background: rgba(249,115,22,0.12); color: #EA580C; }
    .kpi-icon-box.purple { background: rgba(139,92,246,0.12); color: #7C3AED; }

    .kpi-value { font-size: 1.5rem; font-weight: 800; color: #0F172A !important; line-height: 1; }
    .kpi-label { font-size: 0.72rem; color: #64748B !important; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 4px; }

    /* PANELS */
    .panel {
        background: #fff !important; border: 1px solid #E2E8F0;
        border-radius: 16px; overflow: hidden;
        box-shadow: 0 2px 8px rgba(15,23,42,0.04);
        margin-bottom: 20px;
    }
    .panel-header {
        padding: 18px 22px; border-bottom: 1px solid #F1F5F9;
        display: flex; justify-content: space-between; align-items: center;
        gap: 12px; flex-wrap: wrap;
    }
    .panel-title { font-size: 0.95rem; font-weight: 700; color: #0F172A !important; margin: 0; display: flex; align-items: center; gap: 8px; }
    .panel-title i { color: #2563EB; }
    .panel-body { padding: 20px 22px; }

    /* BOUTON MODIFIER */
    .btn-edit-panel {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px;
        background: linear-gradient(135deg, #2563EB, #1E40AF);
        color: #fff !important; border: none; border-radius: 8px;
        font-size: 0.78rem; font-weight: 600; cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }
    .btn-edit-panel:hover { transform: translateY(-1px); box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35); color: #fff !important; }

    /* INFO PANEL */
    .info-full-width { margin-bottom: 20px; width: 100%; }

    .info-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
    @media (max-width: 1100px) { .info-grid-3 { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 700px) { .info-grid-3 { grid-template-columns: 1fr; } }

    .info-block {
        background: #F8FAFC; border: 1px solid #E2E8F0;
        border-radius: 12px; padding: 16px 18px;
        transition: all 0.2s ease;
    }
    .info-block:hover { border-color: #CBD5E1; background: #fff; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05); }
    .info-block-title {
        font-size: 0.75rem; font-weight: 800;
        color: #1E40AF !important;
        text-transform: uppercase; letter-spacing: 0.05em;
        margin-bottom: 12px; padding-bottom: 8px;
        border-bottom: 2px solid #E0E7FF;
        display: flex; align-items: center; gap: 8px;
    }
    .info-block-title i { color: #2563EB; font-size: 0.85rem; }

    .info-block .info-item { padding: 8px 0; border-bottom: 1px dashed #E2E8F0; display: flex; flex-direction: column; gap: 3px; }
    .info-block .info-item:last-child { border-bottom: none; padding-bottom: 0; }

    .info-label { font-size: 0.7rem; color: #94A3B8 !important; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; }
    .info-value { font-size: 0.88rem; color: #0F172A !important; font-weight: 600; word-break: break-word; }
    .info-value.empty { color: #CBD5E1 !important; font-weight: 400; font-style: italic; }

    /* GRILLE 2 COLONNES */
    .show-grid-2col { display: grid; grid-template-columns: 1fr; gap: 20px; margin-bottom: 24px; }

    /* BADGES */
    .badge-etat-lg { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 100px; font-size: 0.8rem; font-weight: 700; }
    .badge-etat-lg::before { content: ''; width: 8px; height: 8px; border-radius: 50%; }
    .badge-etat-lg.bon { background: rgba(16,185,129,0.12); color: #059669 !important; }
    .badge-etat-lg.bon::before { background: #059669; }
    .badge-etat-lg.degrade { background: rgba(250,204,21,0.18); color: #B45309 !important; }
    .badge-etat-lg.degrade::before { background: #B45309; }
    .badge-etat-lg.vandal { background: rgba(249,115,22,0.15); color: #EA580C !important; }
    .badge-etat-lg.vandal::before { background: #EA580C; }
    .badge-etat-lg.masque { background: rgba(220,38,38,0.10); color: #DC2626 !important; }
    .badge-etat-lg.masque::before { background: #DC2626; }
    .badge-etat-lg.aucun { background: rgba(148,163,184,0.15); color: #64748B !important; }
    .badge-etat-lg.aucun::before { background: #94A3B8; }

    /* TABLEAU HISTORIQUE */
    .obs-table-wrapper { overflow-x: auto; max-height: 600px; overflow-y: auto; -webkit-overflow-scrolling: touch; }
    .obs-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; min-width: 900px; }
    .obs-table thead { background: #F8FAFC; position: sticky; top: 0; z-index: 2; }
    .obs-table th {
        text-align: left; padding: 12px 14px; font-size: 0.7rem;
        font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
        color: #64748B !important; border-bottom: 2px solid #E2E8F0; white-space: nowrap;
    }
    .obs-table td { padding: 12px 14px; border-bottom: 1px solid #F1F5F9; color: #334155 !important; vertical-align: middle; }
    .obs-table tbody tr:hover td { background: #F8FAFC !important; }
    .obs-remarque-row td { padding: 0 14px 12px 14px !important; border-bottom: 1px solid #F1F5F9; }

    /* Miniatures photos */
    .obs-photos { display: flex; gap: 4px; align-items: center; flex-wrap: wrap; }
    .obs-photo-thumb {
        width: 40px; height: 40px; border-radius: 6px; overflow: hidden;
        border: 1.5px solid #E2E8F0; cursor: pointer; background: #F1F5F9;
        transition: all 0.2s ease; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; position: relative;
    }
    .obs-photo-thumb:hover {
        transform: scale(1.15); border-color: #2563EB;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25); z-index: 5;
    }
    .obs-photo-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .obs-photo-thumb.broken { background: #FEE2E2; color: #DC2626; font-size: 0.9rem; }
    .obs-photo-more { background: #EFF6FF; color: #2563EB; font-size: 0.72rem; font-weight: 700; cursor: pointer; }
    .obs-photo-more:hover { background: #2563EB; color: #fff !important; }

    /* Boutons action */
    .btn-obs-action {
        width: 30px; height: 30px; border-radius: 6px; border: none;
        cursor: pointer; display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.75rem; transition: all 0.2s ease;
        background: #F1F5F9; color: #64748B;
    }
    .btn-obs-edit:hover { background: #EFF6FF; color: #2563EB; transform: translateY(-1px); }
    .btn-obs-delete:hover { background: #FEF2F2; color: #DC2626; transform: translateY(-1px); }

    /* EMPTY */
    .empty-mini { padding: 30px 20px; text-align: center; color: #94A3B8; font-size: 0.85rem; }
    .empty-mini i { font-size: 2rem; opacity: 0.4; margin-bottom: 10px; display: block; }

    /* MAP */
    #map-detail { height: 320px; width: 100%; border-radius: 0 0 16px 16px; }
    .map-coords { padding: 10px 22px; background: #F8FAFC; font-size: 0.78rem; color: #64748B !important; border-top: 1px solid #F1F5F9; display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .map-coords strong { color: #0F172A; }

    /* MARKER */
    .panneau-marker { background: transparent !important; border: none !important; transition: transform 0.2s ease, width 0.2s ease, height 0.2s ease; cursor: pointer; }
    .panneau-marker:hover { z-index: 9999 !important; }
    .leaflet-popup-content-wrapper { border-radius: 12px; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.15); }
    .leaflet-popup-content { margin: 12px 14px; font-family: 'Inter', sans-serif; }

    /* MODALES */
    .modal-content { border-radius: 16px !important; border: none !important; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.35) !important; overflow: hidden !important; }
    .modal-header { border-bottom: none !important; padding: 20px 26px !important; border-radius: 16px 16px 0 0 !important; flex-shrink: 0; }
    .modal-body { padding: 0 !important; max-height: calc(100vh - 220px) !important; overflow-y: auto !important; }
    .modal-footer { background: #F8FAFC !important; border-top: 1px solid #E2E8F0 !important; padding: 16px 26px !important; border-radius: 0 0 16px 16px !important; flex-shrink: 0; }

    /* ONGLETS */
    .modal .nav-tabs { padding: 0 26px; background: #F8FAFC; border-bottom: 2px solid #E2E8F0; gap: 4px; }
    .modal .nav-tabs .nav-link {
        border: none !important; color: #64748B !important; font-size: 0.82rem;
        font-weight: 700; padding: 12px 18px !important; border-radius: 0 !important;
        position: relative; transition: all 0.2s ease;
    }
    .modal .nav-tabs .nav-link:hover { color: #2563EB !important; background: #EFF6FF; }
    .modal .nav-tabs .nav-link.active { color: #1E40AF !important; background: #fff; border-bottom: 3px solid #2563EB !important; margin-bottom: -2px; }
    .modal .nav-tabs .nav-link i { margin-right: 6px; }
    .modal .tab-content { padding: 24px 26px; }

    /* FORMULAIRES */
    .modal .form-label {
        margin-bottom: 4px; font-size: 0.72rem; font-weight: 700;
        color: #64748B !important; text-transform: uppercase; letter-spacing: 0.04em;
    }
    .modal .form-control,
    .modal .form-select {
        padding: 8px 12px; border: 1.5px solid #E2E8F0;
        border-radius: 8px; font-size: 0.85rem; transition: all 0.15s ease; width: 100%;
    }
    .modal .form-control { color: #0F172A !important; background-color: #ffffff !important; }
    .modal .form-control::placeholder { color: #94A3B8 !important; }
    .modal .form-select {
        padding-right: 32px; color: #0F172A !important; background-color: #ffffff !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748B' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center;
        appearance: none; -webkit-appearance: none; color-scheme: light;
    }
    .modal .form-control:focus,
    .modal .form-select:focus {
        border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none; color: #0F172A !important; background-color: #ffffff !important;
    }
    .modal .form-select option, select option { background-color: #ffffff !important; color: #0F172A !important; padding: 8px 12px !important; }
    .modal .form-select option:checked, select option:checked { background-color: #2563EB !important; color: #ffffff !important; }
    .modal .form-select option:hover, select option:hover { background-color: #EFF6FF !important; color: #1E40AF !important; }

    .modal .btn-close-white { filter: brightness(0) invert(1); opacity: 0.8; }
    .modal .btn-close-white:hover { opacity: 1; }

    .modal-section-title {
        font-size: 0.78rem; font-weight: 700; color: #1E40AF !important;
        text-transform: uppercase; letter-spacing: 0.05em;
        margin: 0 0 16px; padding: 10px 14px;
        background: #EFF6FF; border-left: 3px solid #2563EB;
        border-radius: 6px; display: flex; align-items: center; gap: 6px;
    }
    .modal-section-title i { color: #2563EB; font-size: 0.78rem; }

    .form-group-block { margin-bottom: 24px; }
    .form-group-block:last-child { margin-bottom: 0; }

    /* =========================================================
       ✅ CUSTOM SELECT AVEC SVG — CODE NOMENCLATURE
       ========================================================= */
    .nomen-custom-select {
        position: relative;
        width: 100%;
        font-family: 'Inter', sans-serif;
    }
    .nomen-custom-select__trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 6px 12px;
        border: 1.5px solid #E2E8F0;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        transition: all 0.15s ease;
        min-height: 38px;
    }
    .nomen-custom-select__trigger:hover { border-color: #CBD5E1; }
    .nomen-custom-select.open .nomen-custom-select__trigger {
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .nomen-custom-select__arrow {
        color: #64748B;
        font-size: 0.75rem;
        transition: transform 0.2s ease;
        flex-shrink: 0;
        margin-left: 8px;
    }
    .nomen-custom-select.open .nomen-custom-select__arrow { transform: rotate(180deg); }
    .nomen-custom-select__value { flex: 1; min-width: 0; }

    .nomen-custom-select__dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1.5px solid #E2E8F0;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
        z-index: 3000;
        max-height: 340px;
        display: none;
        flex-direction: column;
        overflow: hidden;
    }
    .nomen-custom-select.open .nomen-custom-select__dropdown { display: flex; }
    .nomen-custom-select__search {
        position: relative;
        padding: 8px;
        border-bottom: 1px solid #F1F5F9;
        flex-shrink: 0;
    }
    .nomen-custom-select__search i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 0.8rem;
    }
    .nomen-custom-select__search input {
        width: 100%;
        padding: 8px 12px 8px 32px;
        border: 1.5px solid #E2E8F0;
        border-radius: 8px;
        font-size: 0.82rem;
        outline: none;
        font-family: 'Inter', sans-serif;
        box-sizing: border-box;
    }
    .nomen-custom-select__search input:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .nomen-custom-select__options {
        overflow-y: auto;
        max-height: 280px;
        padding: 4px 0;
    }
    .nomen-custom-select__options::-webkit-scrollbar { width: 5px; }
    .nomen-custom-select__options::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }

    .nomen-custom-option {
        cursor: pointer;
        transition: background 0.15s ease;
        padding: 0;
    }
    .nomen-custom-option:hover { background: #EFF6FF; }
    .nomen-custom-option.active { background: #EFF6FF; }

    .nomen-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
    }
    .nomen-option__svg {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        padding: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .nomen-option__svg img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }
    .nomen-option__svg i {
        color: #CBD5E1;
        font-size: 16px;
    }
    .nomen-option__text { flex: 1; min-width: 0; }
    .nomen-option__code {
        font-weight: 800;
        color: #1E40AF;
        font-size: 0.85rem;
        line-height: 1.2;
    }
    .nomen-option__name {
        font-size: 0.72rem;
        color: #64748B;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .nomen-option__name.obsolete { color: #EA580C; font-style: italic; }
    .nomen-custom-option.active .nomen-option__svg {
        border-color: #2563EB;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }

    .nomen-custom-select__trigger .nomen-option { padding: 0; gap: 8px; }
    .nomen-custom-select__trigger .nomen-option__svg { width: 26px; height: 26px; padding: 2px; }
    .nomen-custom-select__trigger .nomen-option__name { display: none; }
    .nomen-custom-select__trigger .nomen-option__code { font-size: 0.82rem; }

    /* Photos upload */
    .photo-upload-zone {
        border: 2px dashed #CBD5E1; border-radius: 12px; padding: 24px;
        text-align: center; background: #F8FAFC; cursor: pointer; transition: all 0.2s ease;
    }
    .photo-upload-zone:hover { border-color: #2563EB; background: #EFF6FF; }
    .photo-upload-zone input[type="file"] { display: none; }

    .photo-preview-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 8px; margin-top: 12px; }
    .photo-preview-item { position: relative; aspect-ratio: 1; border-radius: 8px; overflow: hidden; border: 1px solid #E2E8F0; }
    .photo-preview-item img { width: 100%; height: 100%; object-fit: cover; display: block; }

    /* =========================================================
       LIGHTBOX PHOTOS PREMIUM
    ========================================================= */
    .photo-lightbox {
        position: fixed;
        inset: 0;
        background: rgba(10, 15, 30, 0.96);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        animation: lbFadeIn 0.25s ease;
        user-select: none;
    }
    .photo-lightbox.active { display: flex; }

    @keyframes lbFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    .lb-stage {
        position: relative;
        max-width: 92vw;
        max-height: 88vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .lb-img-wrapper {
        position: relative;
        max-width: 92vw;
        max-height: 88vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .lb-img {
        max-width: 92vw;
        max-height: 88vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
        transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.3, 1.2);
        cursor: zoom-in;
        display: block;
    }
    .lb-img.zoomed { transform: scale(1.8); cursor: zoom-out; }

    .lb-topbar {
        position: fixed; top: 0; left: 0; right: 0;
        padding: 16px 24px;
        display: flex; justify-content: space-between; align-items: center;
        background: linear-gradient(to bottom, rgba(0,0,0,0.7), transparent);
        z-index: 100001; pointer-events: none;
    }
    .lb-topbar > * { pointer-events: auto; }

    .lb-counter {
        color: #fff; font-size: 0.88rem; font-weight: 700;
        background: rgba(255, 255, 255, 0.12);
        padding: 8px 16px; border-radius: 100px;
        backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-family: 'Inter', sans-serif; letter-spacing: 0.02em;
    }
    .lb-actions { display: flex; gap: 8px; }

    .lb-btn {
        width: 42px; height: 42px; border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.15);
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
        color: #fff; font-size: 1rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s ease;
    }
    .lb-btn:hover { background: rgba(255, 255, 255, 0.25); transform: scale(1.08); color: #fff; }
    .lb-btn.lb-close:hover { background: #DC2626; border-color: #DC2626; }

    .lb-nav {
        position: fixed; top: 50%; transform: translateY(-50%);
        width: 56px; height: 56px; border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.15);
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
        color: #fff; font-size: 1.4rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        z-index: 100001; transition: all 0.2s ease; opacity: 0;
    }
    .photo-lightbox.active .lb-nav { opacity: 1; }
    .lb-nav:hover { background: rgba(37, 99, 235, 0.9); border-color: rgba(37, 99, 235, 0.9); transform: translateY(-50%) scale(1.08); }
    .lb-prev { left: 24px; }
    .lb-next { right: 24px; }
    .lb-nav.hidden { display: none; }

    .lb-thumbs {
        position: fixed; bottom: 0; left: 0; right: 0;
        padding: 16px 24px; display: flex; gap: 8px;
        justify-content: center; align-items: center;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        z-index: 100001; overflow-x: auto;
        scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.3) transparent;
    }
    .lb-thumbs::-webkit-scrollbar { height: 6px; }
    .lb-thumbs::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }

    .lb-thumb {
        width: 60px; height: 60px; border-radius: 8px;
        overflow: hidden; cursor: pointer;
        border: 2px solid transparent; flex-shrink: 0;
        transition: all 0.2s ease; opacity: 0.55;
    }
    .lb-thumb:hover { opacity: 0.9; transform: translateY(-2px); }
    .lb-thumb.active { border-color: #2563EB; opacity: 1; box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.4); }
    .lb-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }

    @keyframes lbImageIn {
        from { opacity: 0; transform: scale(0.95); }
        to   { opacity: 1; transform: scale(1); }
    }
    .lb-img.animate { animation: lbImageIn 0.3s ease; }

    /* =========================================================
       RESPONSIVE
       ========================================================= */
    @media (max-width: 1024px) {
        .show-page { padding: 18px; }
        .show-hero { padding: 22px 24px; gap: 18px; border-radius: 16px; }
        .hero-svg-box { width: 76px; height: 76px; }
        .hero-code { font-size: 1.7rem; }
        .hero-name { font-size: 0.92rem; }
        .info-grid-3 { gap: 14px; }
        .modal .tab-content { padding: 20px 20px; }
    }

    @media (max-width: 768px) {
        .show-page { padding: 12px; }

        .show-hero {
            flex-direction: column;
            align-items: stretch;
            padding: 18px 18px;
            gap: 16px;
            border-radius: 14px;
            margin-bottom: 16px;
        }
        .hero-left { flex-direction: column; align-items: flex-start; gap: 12px; }
        .hero-svg-box {
            width: 64px; height: 64px;
            border-radius: 14px;
            padding: 8px;
        }
        .hero-info { width: 100%; }
        .hero-code { font-size: 1.5rem; }
        .hero-name { font-size: 0.85rem; line-height: 1.35; }
        .hero-loc {
            font-size: 0.72rem;
            padding: 4px 10px;
            margin-top: 8px;
        }
        .hero-right {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .btn-hero {
            justify-content: center;
            padding: 9px 12px;
            font-size: 0.78rem;
            gap: 6px;
        }

        .kpi-strip { grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .kpi-box { padding: 14px 14px; gap: 10px; border-radius: 12px; }
        .kpi-icon-box { width: 40px; height: 40px; font-size: 1rem; border-radius: 10px; }
        .kpi-value { font-size: 1.2rem; }
        .kpi-label { font-size: 0.65rem; }
        .kpi-box .badge-etat-lg { font-size: 0.7rem; padding: 5px 10px; }

        .panel { border-radius: 14px; margin-bottom: 14px; }
        .panel-header { padding: 14px 16px; gap: 10px; }
        .panel-title { font-size: 0.88rem; gap: 6px; }
        .panel-body { padding: 16px 16px; }
        .btn-edit-panel { padding: 6px 12px; font-size: 0.72rem; }

        .info-grid-3 { grid-template-columns: 1fr; gap: 12px; }
        .info-block { padding: 14px 14px; border-radius: 10px; }
        .info-block-title { font-size: 0.72rem; padding-bottom: 6px; margin-bottom: 10px; }
        .info-label { font-size: 0.66rem; }
        .info-value { font-size: 0.84rem; }

        .obs-table { font-size: 0.76rem; min-width: 820px; }
        .obs-table th { padding: 10px 10px; font-size: 0.65rem; }
        .obs-table td { padding: 10px 10px; }
        .obs-table-wrapper { max-height: 500px; }
        .obs-photo-thumb { width: 36px; height: 36px; }
        .btn-obs-action { width: 28px; height: 28px; font-size: 0.7rem; }

        #map-detail { height: 260px; }
        .map-coords { padding: 10px 16px; font-size: 0.72rem; }

        .modal-dialog { margin: 8px; max-width: calc(100vw - 16px) !important; }
        .modal-dialog.modal-dialog-centered {
            min-height: calc(100% - 16px);
            align-items: flex-end;
        }
        .modal-content {
            border-radius: 20px 20px 0 0 !important;
            max-height: 94vh !important;
        }
        .modal-header { padding: 14px 16px !important; }
        .modal-header .modal-title { font-size: 0.95rem !important; }
        .modal-header small { font-size: 0.72rem !important; }
        .modal-body { max-height: calc(100vh - 190px) !important; }
        .modal-footer { padding: 12px 16px !important; gap: 8px; }
        .modal-footer button { padding: 8px 14px !important; font-size: 0.82rem !important; }

        .modal .nav-tabs {
            padding: 0 10px;
            overflow-x: auto;
            flex-wrap: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .modal .nav-tabs::-webkit-scrollbar { display: none; }
        .modal .nav-tabs .nav-link {
            padding: 10px 12px !important;
            font-size: 0.74rem;
            white-space: nowrap;
        }
        .modal .nav-tabs .nav-link i { margin-right: 4px; }
        .modal .tab-content { padding: 16px 16px; }

        .modal-section-title { font-size: 0.72rem; padding: 8px 12px; margin-bottom: 12px; }
        .modal .form-label { font-size: 0.68rem; }
        .modal .form-control,
        .modal .form-select { font-size: 0.82rem; padding: 8px 10px; }

        .photo-upload-zone { padding: 18px 14px; }
        .photo-preview-grid { grid-template-columns: repeat(3, 1fr); gap: 6px; }

        .lb-topbar { padding: 10px 12px; }
        .lb-btn { width: 36px; height: 36px; font-size: 0.85rem; }
        .lb-counter { font-size: 0.75rem; padding: 5px 10px; }
        .lb-nav { width: 42px; height: 42px; font-size: 1.1rem; }
        .lb-prev { left: 8px; }
        .lb-next { right: 8px; }
        .lb-thumbs { padding: 10px 12px; gap: 6px; }
        .lb-thumb { width: 48px; height: 48px; }
        .lb-img.zoomed { transform: scale(1.4); }
    }

    @media (max-width: 420px) {
        .show-page { padding: 10px; }
        .hero-code { font-size: 1.25rem; }
        .hero-name { font-size: 0.78rem; }
        .hero-loc { font-size: 0.68rem; padding: 3px 8px; }
        .hero-right { grid-template-columns: 1fr; }
        .kpi-strip { grid-template-columns: 1fr; }
        .kpi-box { padding: 12px 12px; }
        .kpi-value { font-size: 1.1rem; }
        .panel-header { flex-direction: column; align-items: flex-start; gap: 8px; }
        .panel-header .btn-edit-panel { align-self: flex-start; }
        .obs-photo-thumb { width: 32px; height: 32px; }
        .obs-photo-more { font-size: 0.65rem; }
        .photo-preview-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>

{{-- =========================================================
     DONNÉES PHOTOS
========================================================= --}}
<script>
window.__allPhotosByObs = {
    @php
        $photosByObsJs = [];
        foreach ($photosParObs as $idObs => $photoList) {
            $photosByObsJs[$idObs] = array_map(function($p) {
                return asset('Backend/assets/photos/' . $p->chemin);
            }, $photoList);
        }
    @endphp
    @json($photosByObsJs)
};

/* ✅ Types de panneaux pour le custom select */
window.__typesPanneaux = @json($listes['types_panneaux'] ?? []);
window.__baseSvg       = "{{ asset('Backend/assets/SVG') }}";

console.log('📋 Types panneaux:', window.__typesPanneaux.length);
console.log('📁 Base SVG:', window.__baseSvg);
</script>

<div class="show-page">

    {{-- HERO --}}
    @php
        $etatValue = strtolower($derniereObs?->etat_actuel ?? '');
        $classeEtat = match(true) {
            str_contains($etatValue, 'bon')    => 'bon',
            str_contains($etatValue, 'dégrad'),
            str_contains($etatValue, 'degrad') => 'degrade',
            str_contains($etatValue, 'vandal') => 'vandal',
            str_contains($etatValue, 'masqu')  => 'masque',
            default                            => 'aucun',
        };

        $svgPath = !empty($panneau->code_nomen)
            ? asset('Backend/assets/SVG/' . $panneau->code_nomen . '.svg')
            : null;

        $ageAns = null;
        if (!empty($panneau->date_pose)) {
            $ageAns = \Carbon\Carbon::parse($panneau->date_pose)->diffInYears(now());
        }
    @endphp

    <div class="show-hero">
        <div class="hero-left">
            <div class="hero-svg-box">
                @if ($svgPath)
                    <img src="{{ $svgPath }}"
                         alt="{{ $panneau->code_nomen }}"
                         onerror="this.parentElement.innerHTML='<i class=\'fa-solid fa-sign-hanging\' style=\'color:#CBD5E1;font-size:2rem;\'></i>'">
                @else
                    <i class="fa-solid fa-sign-hanging" style="color:#CBD5E1; font-size:2rem;"></i>
                @endif
            </div>
            <div class="hero-info">
                <h1 class="hero-code">{{ $panneau->code_nomen ?: ($panneau->fclass ?? '—') }}</h1>
                <p class="hero-name">{{ $panneau->type_nom ?: ($panneau->name ?? 'Type inconnu') }}</p>
                <span class="hero-loc">
                    <i class="fa-solid fa-road"></i>
                    {{ $panneau->route_nom ?? '—' }}
                    <span style="opacity:0.6;">•</span>
                    <i class="fa-solid fa-location-dot"></i>
                    PK {{ $panneau->point_kilo ?? '—' }}
                </span>
            </div>
        </div>
        <div class="hero-right">
            <a href="{{ route('signalisation.index') }}" class="btn-hero btn-hero-outline">
                <i class="fa-solid fa-arrow-left"></i> Liste
            </a>
            <button type="button"
                    class="btn-hero btn-hero-light"
                    data-bs-toggle="modal"
                    data-bs-target="#modalNewObservation">
                <i class="fa-solid fa-plus"></i> Nouvelle observation
            </button>
        </div>
    </div>

    {{-- KPI --}}
    <div class="kpi-strip">
        <div class="kpi-box">
            <div class="kpi-icon-box blue"><i class="fa-solid fa-clipboard-check"></i></div>
            <div>
                <div class="kpi-value">{{ $nbObservations }}</div>
                <div class="kpi-label">Observations</div>
            </div>
        </div>
        <div class="kpi-box">
            <div class="kpi-icon-box purple"><i class="fa-solid fa-camera"></i></div>
            <div>
                <div class="kpi-value">{{ $nbPhotos }}</div>
                <div class="kpi-label">Photos</div>
            </div>
        </div>
        <div class="kpi-box">
            <div class="kpi-icon-box {{ $classeEtat === 'bon' ? 'green' : 'orange' }}">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
            <div>
                <div style="margin-bottom:2px;">
                    <span class="badge-etat-lg {{ $classeEtat }}">
                        {{ $derniereObs->etat_actuel ?? 'Non observé' }}
                    </span>
                </div>
                <div class="kpi-label">État actuel</div>
            </div>
        </div>
        <div class="kpi-box">
            <div class="kpi-icon-box green"><i class="fa-solid fa-calendar-check"></i></div>
            <div>
                <div class="kpi-value" style="font-size:1rem;">
                    @if ($ageAns !== null)
                        {{ $ageAns }} an{{ $ageAns > 1 ? 's' : '' }}
                    @else
                        —
                    @endif
                </div>
                <div class="kpi-label">Âge du panneau</div>
            </div>
        </div>
    </div>

    {{-- INFOS TECHNIQUES --}}
    <div class="info-full-width">
        <div class="panel">
            <div class="panel-header">
                <h3 class="panel-title">
                    <i class="fa-solid fa-circle-info"></i>
                    Informations techniques (CCTP DGPC)
                </h3>
                <button type="button" class="btn-edit-panel"
                        data-bs-toggle="modal" data-bs-target="#modalEditPanneau">
                    <i class="fa-solid fa-pen"></i> Modifier
                </button>
            </div>
            <div class="panel-body">
                <div class="info-grid-3">

                    <div class="info-block">
                        <div class="info-block-title"><i class="fa-solid fa-tag"></i> Identification</div>
                        <div class="info-item">
                            <div class="info-label">Code nomenclature</div>
                            <div class="info-value">{{ $panneau->code_nomen ?? '—' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Nom</div>
                            <div class="info-value {{ empty($panneau->name) ? 'empty' : '' }}">
                                {{ $panneau->name ?? 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Catégorie</div>
                            <div class="info-value">{{ $panneau->type_categorie ?? '—' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Couleur fond / bord</div>
                            <div class="info-value">
                                {{ $panneau->type_couleur_fond ?? '—' }}
                                <span style="color:#94A3B8;">/</span>
                                {{ $panneau->type_couleur_bord ?? '—' }}
                            </div>
                        </div>
                    </div>

                    <div class="info-block">
                        <div class="info-block-title"><i class="fa-solid fa-industry"></i> Matériaux &amp; fabrication</div>
                        <div class="info-item">
                            <div class="info-label">Nuance acier</div>
                            <div class="info-value {{ empty($panneau->acier_nuance) ? 'empty' : '' }}">
                                {{ $panneau->acier_nuance ?? 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Nature matériau</div>
                            <div class="info-value {{ empty($panneau->nature_mat) ? 'empty' : '' }}">
                                {{ $panneau->nature_mat ?? 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Type subjectile</div>
                            <div class="info-value {{ empty($panneau->type_subje) ? 'empty' : '' }}">
                                {{ $panneau->type_subje ?? 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Dépôt galvanisation</div>
                            <div class="info-value {{ empty($panneau->galva_depot) ? 'empty' : '' }}">
                                {{ $panneau->galva_depot ? $panneau->galva_depot . ' g/dm²' : 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Largeur lattes</div>
                            <div class="info-value {{ empty($panneau->largeur_latte) ? 'empty' : '' }}">
                                {{ $panneau->largeur_latte ? $panneau->largeur_latte . ' cm' : 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Anodisé</div>
                            <div class="info-value">
                                @if ($panneau->anodise) ✅ Oui @else ❌ Non @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">N° agrément</div>
                            <div class="info-value {{ empty($panneau->num_agrement) ? 'empty' : '' }}">
                                {{ $panneau->num_agrement ?? 'Non renseigné' }}
                            </div>
                        </div>
                    </div>

                    <div class="info-block">
                        <div class="info-block-title"><i class="fa-solid fa-lightbulb"></i> Film rétro-réfléchissant</div>
                        <div class="info-item">
                            <div class="info-label">Type film rétro</div>
                            <div class="info-value {{ empty($panneau->type_film_retro) ? 'empty' : '' }}">
                                {{ $panneau->type_film_retro ?? 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Garantie film</div>
                            <div class="info-value {{ empty($panneau->garantie_film_ans) ? 'empty' : '' }}">
                                {{ $panneau->garantie_film_ans ? $panneau->garantie_film_ans . ' ans' : 'Non renseignée' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Dimensions</div>
                            <div class="info-value {{ empty($panneau->dimensions) ? 'empty' : '' }}">
                                {{ $panneau->dimensions ?? 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">HC caractère</div>
                            <div class="info-value {{ empty($panneau->hc_caractere) ? 'empty' : '' }}">
                                {{ $panneau->hc_caractere ? $panneau->hc_caractere . ' mm' : 'Non renseigné' }}
                            </div>
                        </div>
                    </div>

                    <div class="info-block">
                        <div class="info-block-title"><i class="fa-solid fa-screwdriver-wrench"></i> Structure &amp; support</div>
                        <div class="info-item">
                            <div class="info-label">Protection</div>
                            <div class="info-value {{ empty($panneau->protection) ? 'empty' : '' }}">
                                {{ $panneau->protection ?? 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Type de support</div>
                            <div class="info-value {{ empty($panneau->type_suppo) ? 'empty' : '' }}">
                                {{ $panneau->type_suppo ?? 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Matière support</div>
                            <div class="info-value {{ empty($panneau->matiere_support) ? 'empty' : '' }}">
                                {{ $panneau->matiere_support ?? 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Nombre raidisseurs</div>
                            <div class="info-value {{ empty($panneau->nb_raidisseurs) ? 'empty' : '' }}">
                                {{ $panneau->nb_raidisseurs ?? 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Résistance vent</div>
                            <div class="info-value {{ empty($panneau->resistance) ? 'empty' : '' }}">
                                {{ $panneau->resistance ? $panneau->resistance . ' daN/m²' : 'Non renseigné' }}
                            </div>
                        </div>
                    </div>

                    <div class="info-block">
                        <div class="info-block-title"><i class="fa-solid fa-ruler-vertical"></i> Implantation</div>
                        <div class="info-item">
                            <div class="info-label">Hauteur au sol</div>
                            <div class="info-value {{ empty($panneau->hauteur_so) ? 'empty' : '' }}">
                                {{ $panneau->hauteur_so ? $panneau->hauteur_so . ' m' : 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Hauteur libre</div>
                            <div class="info-value {{ empty($panneau->hauteur_libre_m) ? 'empty' : '' }}">
                                {{ $panneau->hauteur_libre_m ? $panneau->hauteur_libre_m . ' m' : 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Implantation</div>
                            <div class="info-value {{ empty($panneau->implantation_m) ? 'empty' : '' }}">
                                {{ $panneau->implantation_m ? $panneau->implantation_m . ' m' : 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Fiche ancrage</div>
                            <div class="info-value {{ empty($panneau->fiche_ancrage_m) ? 'empty' : '' }}">
                                {{ $panneau->fiche_ancrage_m ? $panneau->fiche_ancrage_m . ' m' : 'Non renseigné' }}
                            </div>
                        </div>
                    </div>

                    <div class="info-block">
                        <div class="info-block-title"><i class="fa-solid fa-calendar"></i> Durée de vie</div>
                        <div class="info-item">
                            <div class="info-label">Date pose</div>
                            <div class="info-value {{ empty($panneau->date_pose) ? 'empty' : '' }}">
                                {{ $panneau->date_pose ? \Carbon\Carbon::parse($panneau->date_pose)->format('d/m/Y') : 'Non renseignée' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Durée de vie</div>
                            <div class="info-value {{ empty($panneau->duree_vie_ans) ? 'empty' : '' }}">
                                {{ $panneau->duree_vie_ans ? $panneau->duree_vie_ans . ' ans' : 'Non renseignée' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Remplacement prévu</div>
                            <div class="info-value {{ empty($panneau->date_remplacement_prevue) ? 'empty' : '' }}">
                                {{ $panneau->date_remplacement_prevue ? \Carbon\Carbon::parse($panneau->date_remplacement_prevue)->format('d/m/Y') : 'Non renseigné' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Catégorie de route</div>
                            <div class="info-value {{ empty($panneau->route) ? 'empty' : '' }}">
                                {{ $panneau->route ?? 'Non renseigné' }}
                            </div>
                        </div>
                    </div>

                </div>

                @if ($panneau->type_description)
                    <div style="margin-top:20px; padding:14px 16px; background:#EFF6FF; border-left:3px solid #2563EB; border-radius:8px; font-size:0.83rem; color:#1E3A8A !important; line-height:1.5;">
                        <strong style="display:block; margin-bottom:4px; color:#1E40AF !important;">Description officielle</strong>
                        {{ $panneau->type_description }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- LOCALISATION --}}
    <div class="show-grid-2col">
        <div class="panel">
            <div class="panel-header">
                <h3 class="panel-title">
                    <i class="fa-solid fa-map-location-dot"></i>
                    Localisation
                </h3>
            </div>

            @if ($panneau->lat && $panneau->lng)
                <div id="map-detail"></div>
                <div class="map-coords">
                    <span>Latitude : <strong>{{ number_format($panneau->lat, 6) }}</strong></span>
                    <span>Longitude : <strong>{{ number_format($panneau->lng, 6) }}</strong></span>
                </div>
            @else
                <div class="empty-mini">
                    <i class="fa-solid fa-map-location-dot"></i>
                    Coordonnées non disponibles pour ce panneau.
                </div>
            @endif
        </div>
    </div>

    {{-- HISTORIQUE DES OBSERVATIONS --}}
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Historique des observations
            </h3>
            <span style="padding:4px 12px; background:#EFF6FF; color:#2563EB !important; border-radius:100px; font-size:0.78rem; font-weight:700;">
                {{ $nbObservations }} inspection(s)
            </span>
        </div>

        @if ($observations->isEmpty())
            <div class="empty-mini">
                <i class="fa-solid fa-clipboard"></i>
                Aucune observation enregistrée pour ce panneau.
            </div>
        @else
            <div class="obs-table-wrapper">
                <table class="obs-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>État</th>
                            <th>Classe rétro</th>
                            <th>N° agrément</th>
                            <th>Fabrication</th>
                            <th>Pose</th>
                            <th>Garantie</th>
                            <th>Photos</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($observations as $obs)
                            @php
                                $oEtat = strtolower($obs->etat_actuel ?? '');
                                $oClasse = match(true) {
                                    str_contains($oEtat, 'bon')    => 'bon',
                                    str_contains($oEtat, 'dégrad'),
                                    str_contains($oEtat, 'degrad') => 'degrade',
                                    str_contains($oEtat, 'vandal') => 'vandal',
                                    str_contains($oEtat, 'masqu')  => 'masque',
                                    default                        => 'aucun',
                                };
                                $photos = $photosParObs[$obs->id_obs] ?? [];
                            @endphp

                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:6px; font-weight:600; color:#0F172A;">
                                        <i class="fa-regular fa-calendar" style="color:#94A3B8; font-size:0.75rem;"></i>
                                        {{ $obs->date_obs ? \Carbon\Carbon::parse($obs->date_obs)->format('d/m/Y') : '—' }}
                                        @if ($obs->date_obs)
                                            <small style="color:#94A3B8; font-weight:400;">
                                                {{ \Carbon\Carbon::parse($obs->date_obs)->format('H:i') }}
                                            </small>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <span class="badge-etat-lg {{ $oClasse }}">
                                        {{ $obs->etat_actuel ?? '—' }}
                                    </span>
                                </td>

                                <td>
                                    @if ($obs->classe_retro)
                                        <span class="badge-etat-lg" style="background: rgba(139,92,246,0.10); color: #7C3AED !important;">
                                            {{ $obs->classe_retro }}
                                        </span>
                                    @else
                                        <span style="color:#CBD5E1;">—</span>
                                    @endif
                                </td>

                                <td style="font-family: monospace; font-size: 0.78rem; color: #334155;">
                                    {{ $obs->num_agrem ?? '—' }}
                                </td>

                                <td style="font-size: 0.8rem; color: #64748B;">
                                    {{ $obs->date_fabrication ? \Carbon\Carbon::parse($obs->date_fabrication)->format('d/m/Y') : '—' }}
                                </td>

                                <td style="font-size: 0.8rem; color: #64748B;">
                                    {{ $obs->date_pose ? \Carbon\Carbon::parse($obs->date_pose)->format('d/m/Y') : '—' }}
                                </td>

                                <td style="font-size: 0.8rem; color: #64748B;">
                                    {{ $obs->garantie_expiration ? \Carbon\Carbon::parse($obs->garantie_expiration)->format('d/m/Y') : '—' }}
                                </td>

                                {{-- PHOTOS --}}
                                <td>
                                    @if (!empty($photos))
                                        <div class="obs-photos">
                                            @foreach (array_slice($photos, 0, 3) as $idx => $photo)
                                                @php
                                                    $photoUrl = asset('Backend/assets/photos/' . $photo->chemin);
                                                    $obsPhotosUrls = array_map(function($p) {
                                                        return asset('Backend/assets/photos/' . $p->chemin);
                                                    }, $photos);
                                                    $obsPhotosJson = json_encode(array_values($obsPhotosUrls));
                                                @endphp
                                                <div class="obs-photo-thumb"
                                                     onclick='ouvrirPhotos({{ $obsPhotosJson }}, {{ $idx }})'
                                                     title="{{ $photo->nom_fichier ?? '' }}">
                                                    <img src="{{ $photoUrl }}"
                                                         alt="{{ $photo->nom_fichier ?? 'photo' }}"
                                                         loading="lazy"
                                                         onerror="this.parentElement.classList.add('broken'); this.parentElement.innerHTML='<i class=\'fa-solid fa-image-slash\'></i>';">
                                                </div>
                                            @endforeach

                                            @if (count($photos) > 3)
                                                @php
                                                    $obsPhotosUrls = array_map(function($p) {
                                                        return asset('Backend/assets/photos/' . $p->chemin);
                                                    }, $photos);
                                                    $obsPhotosJson = json_encode(array_values($obsPhotosUrls));
                                                @endphp
                                                <div class="obs-photo-thumb obs-photo-more"
                                                     onclick='ouvrirPhotos({{ $obsPhotosJson }}, 0)'
                                                     title="Voir toutes les photos">
                                                    <span>+{{ count($photos) - 3 }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span style="color:#CBD5E1; font-size:0.75rem;">
                                            <i class="fa-regular fa-image"></i> Aucune
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div style="display:flex; gap:6px; justify-content:center;">
                                        <button type="button"
                                                class="btn-obs-action btn-obs-edit"
                                                title="Modifier"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditObservation"
                                                data-id-obs="{{ $obs->id_obs }}"
                                                data-date-obs="{{ $obs->date_obs }}"
                                                data-date-fab="{{ $obs->date_fabrication }}"
                                                data-date-pose="{{ $obs->date_pose }}"
                                                data-garantie="{{ $obs->garantie_expiration }}"
                                                data-num-agrem="{{ $obs->num_agrem }}"
                                                data-classe-retro="{{ $obs->classe_retro }}"
                                                data-etat="{{ $obs->etat_actuel }}"
                                                data-remarque="{{ $obs->remarque }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button type="button"
                                                class="btn-obs-action btn-obs-delete"
                                                title="Supprimer"
                                                data-url="{{ route('signalisation.observation.destroy', $obs->id_obs) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            @if ($obs->remarque)
                                <tr class="obs-remarque-row">
                                    <td colspan="9">
                                        <div style="padding: 8px 12px; background: #FFFBEB; border-left: 3px solid #FACC15; border-radius: 6px; font-size: 0.8rem; color: #78350F;">
                                            <strong>Remarque :</strong> {{ $obs->remarque }}
                                        </div>
                                    </td>
                                </tr>
                            @endif

                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

{{-- =========================================================
     MODALE 1 : ÉDITION DU PANNEAU — avec custom select
========================================================= --}}
<div class="modal fade" id="modalEditPanneau" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1E40AF, #2563EB); color: #fff;">
                <div>
                    <h5 class="modal-title" style="color: #fff !important; font-weight: 700;">
                        <i class="fa-solid fa-pen-to-square"></i> Modifier le panneau
                    </h5>
                    <small style="color: rgba(255,255,255,0.85); font-size: 0.8rem;">
                        {{ $panneau->code_nomen ?? '—' }} — {{ $panneau->type_nom ?? '' }}
                    </small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditPanneau" method="POST"
                  action="{{ route('signalisation.update', $panneau->panneau_id) }}"
                  style="display: flex; flex-direction: column; flex: 1; min-height: 0;">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div id="modalEditError" class="alert alert-danger d-none" style="margin: 16px 26px 0; border-radius: 10px;"></div>
                    <div id="modalEditSuccess" class="alert alert-success d-none" style="margin: 16px 26px 0; border-radius: 10px;"></div>

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-ident" type="button">
                                <i class="fa-solid fa-tag"></i> Identification
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-mat" type="button">
                                <i class="fa-solid fa-industry"></i> Matériaux &amp; Film
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-struct" type="button">
                                <i class="fa-solid fa-screwdriver-wrench"></i> Structure
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="tab-ident">
                            <h6 class="modal-section-title"><i class="fa-solid fa-tag"></i> Identification</h6>
                            <div class="row g-3 form-group-block">
                                <div class="col-md-6">
                                    <label class="form-label">Code nomenclature</label>
                                    {{-- ✅ Input hidden qui sera envoyé au serveur --}}
                                    <input type="hidden" name="code_nomen" id="edit_code_nomen_hidden" value="{{ $panneau->code_nomen ?? '' }}">

                                    {{-- ✅ Custom select avec SVG --}}
                                    <div class="nomen-custom-select" id="editNomenCustomSelect">
                                        <div class="nomen-custom-select__trigger" onclick="toggleEditNomenDropdown()">
                                            <div class="nomen-custom-select__value" id="editNomenSelectedDisplay">
                                                {{-- Rempli dynamiquement --}}
                                            </div>
                                            <i class="fa-solid fa-chevron-down nomen-custom-select__arrow"></i>
                                        </div>
                                        <div class="nomen-custom-select__dropdown" id="editNomenDropdown">
                                            <div class="nomen-custom-select__search">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                                <input type="text" id="editNomenSearch" placeholder="Rechercher code ou nom..." oninput="filterEditNomenOptions(this.value)">
                                            </div>
                                            <div class="nomen-custom-select__options" id="editNomenOptionsList"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">HC caractère (mm)</label>
                                    <select name="hc_caractere" class="form-select">
                                        <option value="">— Non renseigné —</option>
                                        @foreach ([100, 125, 160, 200] as $hc)
                                            <option value="{{ $hc }}" @selected((string)($panneau->hc_caractere ?? '') === (string)$hc)>{{ $hc }} mm</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="name" id="edit_name" class="form-control" value="{{ $panneau->name ?? '' }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Dimensions CCTP</label>
                                    <input type="text" name="dim_cctp" class="form-control" value="{{ $panneau->dim_cctp ?? '' }}">
                                </div>
                            </div>

                            <h6 class="modal-section-title"><i class="fa-solid fa-map-location-dot"></i> Localisation</h6>
                            <div class="row g-3 form-group-block">
                                <div class="col-12">
                                    <label class="form-label">Route</label>
                                    <select name="route_nom" class="form-select">
                                        <option value="">— Non renseignée —</option>
                                        @if (!empty($panneau->route_nom) && !$listes['routes']->contains($panneau->route_nom))
                                            <option value="{{ $panneau->route_nom }}" selected>{{ $panneau->route_nom }} (actuel)</option>
                                        @endif
                                        @foreach ($listes['routes'] as $r)
                                            <option value="{{ $r }}" @selected(($panneau->route_nom ?? '') === $r)>{{ $r }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Point kilométrique</label>
                                    <input type="text" name="point_kilo" class="form-control" value="{{ $panneau->point_kilo ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Catégorie de route</label>
                                    <select name="route" class="form-select">
                                        <option value="">— Non renseignée —</option>
                                        @php $categoriesRoute = ['Nationale', 'Régionale', 'Locale', 'Autoroute', 'Urbaine', 'Rurale']; @endphp
                                        @if (!empty($panneau->route) && !in_array($panneau->route, $categoriesRoute))
                                            <option value="{{ $panneau->route }}" selected>{{ $panneau->route }} (actuel)</option>
                                        @endif
                                        @foreach ($categoriesRoute as $cat)
                                            <option value="{{ $cat }}" @selected(($panneau->route ?? '') === $cat)>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-mat">
                            <h6 class="modal-section-title"><i class="fa-solid fa-industry"></i> Matériaux</h6>
                            <div class="row g-3 form-group-block">
                                <div class="col-md-6">
                                    <label class="form-label">Nuance acier</label>
                                    <select name="acier_nuance" class="form-select">
                                        <option value="">— Choisir —</option>
                                        @foreach (['Acier E 24-1', 'Acier A 33'] as $a)
                                            <option value="{{ $a }}" @selected(($panneau->acier_nuance ?? '') === $a)>{{ $a }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Type subjectile</label>
                                    <select name="type_subje" class="form-select">
                                        <option value="">— Choisir —</option>
                                        @foreach (['Tôle plane', 'Profilés extrudés (lattes)'] as $ts)
                                            <option value="{{ $ts }}" @selected(($panneau->type_subje ?? '') === $ts)>{{ $ts }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nature matériau</label>
                                    <select name="nature_mat" class="form-select">
                                        <option value="">— Choisir —</option>
                                        @php $naturesMat = ['Acier E 24-1', 'Alliage Aluminium AG 3 M', 'Alliage Aluminium AZ 5 G']; @endphp
                                        @if (!empty($panneau->nature_mat) && !in_array($panneau->nature_mat, $naturesMat))
                                            <option value="{{ $panneau->nature_mat }}" selected>{{ $panneau->nature_mat }} (actuel)</option>
                                        @endif
                                        @foreach ($naturesMat as $nm)
                                            <option value="{{ $nm }}" @selected(($panneau->nature_mat ?? '') === $nm)>{{ $nm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dépôt galva (g/dm²)</label>
                                    <input type="number" step="0.1" name="galva_depot" class="form-control" value="{{ $panneau->galva_depot ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Largeur lattes (cm)</label>
                                    <input type="number" name="largeur_latte" class="form-control" value="{{ $panneau->largeur_latte ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Anodisé</label>
                                    <select name="anodise" class="form-select">
                                        <option value="">— Non renseigné —</option>
                                        <option value="1" @selected($panneau->anodise)>Oui</option>
                                        <option value="0" @selected(!$panneau->anodise)>Non</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">N° agrément</label>
                                    <input type="text" name="num_agrement" class="form-control" value="{{ $panneau->num_agrement ?? '' }}">
                                </div>
                            </div>

                            <h6 class="modal-section-title"><i class="fa-solid fa-lightbulb"></i> Film rétro-réfléchissant</h6>
                            <div class="row g-3 form-group-block">
                                <div class="col-12">
                                    <label class="form-label">Type de film</label>
                                    <select name="type_film_retro" class="form-select">
                                        <option value="">— Choisir —</option>
                                        @php $films = ['Classe 1 (EG)' => 'Classe 1 (EG) — Standard, garantie 7 ans', 'Classe 2 (HI)' => 'Classe 2 (HI) — Haute intensité, RN, garantie 10 ans', 'Classe 3 (DG)' => 'Classe 3 (DG) — Très haute perf., autoroutes, garantie 12 ans']; @endphp
                                        @foreach ($films as $code => $label)
                                            <option value="{{ $code }}" @selected(($panneau->type_film_retro ?? '') === $code)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Garantie film (ans)</label>
                                    <input type="number" name="garantie_film_ans" class="form-control" value="{{ $panneau->garantie_film_ans ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-struct">
                            <h6 class="modal-section-title"><i class="fa-solid fa-screwdriver-wrench"></i> Structure</h6>
                            <div class="row g-3 form-group-block">
                                <div class="col-12">
                                    <label class="form-label">Protection anti-corrosion</label>
                                    <select name="protection" class="form-select">
                                        <option value="">— Choisir —</option>
                                        @foreach (['Galvanisation à chaud 80 µm', 'Galvanisation + peinture', 'Peinture époxy', 'Aucune'] as $p)
                                            <option value="{{ $p }}" @selected(($panneau->protection ?? '') === $p)>{{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Type de support</label>
                                    <select name="type_suppo" class="form-select">
                                        <option value="">— Choisir —</option>
                                        @foreach (['Mât circulaire acier', 'Mât circulaire aluminium', 'Profilé E24', 'Portique'] as $ts)
                                            <option value="{{ $ts }}" @selected(($panneau->type_suppo ?? '') === $ts)>{{ $ts }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Matière support</label>
                                    <select name="matiere_support" class="form-select">
                                        <option value="">— Choisir —</option>
                                        @foreach (['Acier galvanisé', 'Acier E24', 'Aluminium anodisé'] as $ms)
                                            <option value="{{ $ms }}" @selected(($panneau->matiere_support ?? '') === $ms)>{{ $ms }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombre raidisseurs</label>
                                    <select name="nb_raidisseurs" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="2" @selected((string)($panneau->nb_raidisseurs ?? '') === '2')>2</option>
                                        <option value="3" @selected((string)($panneau->nb_raidisseurs ?? '') === '3')>3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Résistance vent (daN/m²)</label>
                                    <select name="resistance" class="form-select">
                                        <option value="">— Choisir —</option>
                                        @foreach ([130, 160, 200] as $r)
                                            <option value="{{ $r }}" @selected((string)($panneau->resistance ?? '') === (string)$r)>{{ $r }} daN/m²</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hauteur au sol (m)</label>
                                    <input type="number" step="0.10" name="hauteur_so" class="form-control" value="{{ $panneau->hauteur_so ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hauteur libre (m)</label>
                                    <input type="number" step="0.10" name="hauteur_libre_m" class="form-control" value="{{ $panneau->hauteur_libre_m ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Implantation (m)</label>
                                    <input type="number" step="0.10" name="implantation_m" class="form-control" value="{{ $panneau->implantation_m ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fiche ancrage (m)</label>
                                    <input type="number" step="0.01" name="fiche_ancrage_m" class="form-control" value="{{ $panneau->fiche_ancrage_m ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date de pose</label>
                                    <input type="date" name="date_pose" class="form-control" value="{{ $panneau->date_pose ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Durée de vie (ans)</label>
                                    <input type="number" name="duree_vie_ans" class="form-control" value="{{ $panneau->duree_vie_ans ?? 10 }}">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="fa-solid fa-xmark"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitEdit" style="border-radius: 8px; font-weight: 600; background: linear-gradient(135deg, #1E40AF, #2563EB); border: none; padding: 8px 20px;">
                        <i class="fa-solid fa-check"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- =========================================================
     MODALE 2 : NOUVELLE OBSERVATION — import Android corrigé
========================================================= --}}
<div class="modal fade" id="modalNewObservation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #059669, #10B981); color: #fff;">
                <div>
                    <h5 class="modal-title" style="color: #fff !important; font-weight: 700;">
                        <i class="fa-solid fa-plus-circle"></i> Nouvelle observation
                    </h5>
                    <small style="color: rgba(255,255,255,0.85); font-size: 0.8rem;">
                        Panneau {{ $panneau->code_nomen ?? '—' }} — {{ $panneau->route_nom ?? '' }} PK {{ $panneau->point_kilo ?? '' }}
                    </small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="formNewObservation" method="POST"
                  action="{{ route('signalisation.observation.store', $panneau->panneau_id) }}"
                  enctype="multipart/form-data"
                  style="display: flex; flex-direction: column; flex: 1; min-height: 0;">
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
                                <i class="fa-solid fa-calendar"></i> Dates techniques
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

                        {{-- ✅ PHOTOS — Import Android corrigé --}}
                        <div class="tab-pane fade" id="new-tab-photos">
                            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px; margin-bottom:14px;">
                                {{-- Bouton 1 : Prendre une photo (appareil photo) --}}
                                <label for="newObsPhotosCamera" class="photo-upload-zone" style="margin:0; cursor:pointer;">
                                    <i class="fa-solid fa-camera" style="font-size: 1.8rem; color: #10B981; margin-bottom: 8px; display: block;"></i>
                                    <div style="font-weight: 700; color: #0F172A; margin-bottom: 4px; font-size: 0.85rem;">Prendre une photo</div>
                                    <div style="font-size: 0.72rem; color: #64748B;">Appareil photo</div>
                                    <input type="file" id="newObsPhotosCamera" name="photos[]" accept="image/*" capture="environment" multiple onchange="previewPhotos(this, 'photoPreviewNew')">
                                </label>

                                {{-- Bouton 2 : Choisir depuis la galerie --}}
                                <label for="newObsPhotosGallery" class="photo-upload-zone" style="margin:0; cursor:pointer;">
                                    <i class="fa-solid fa-images" style="font-size: 1.8rem; color: #2563EB; margin-bottom: 8px; display: block;"></i>
                                    <div style="font-weight: 700; color: #0F172A; margin-bottom: 4px; font-size: 0.85rem;">Choisir une photo</div>
                                    <div style="font-size: 0.72rem; color: #64748B;">Galerie / Fichiers</div>
                                    <input type="file" id="newObsPhotosGallery" name="photos[]" accept="image/*" multiple onchange="previewPhotos(this, 'photoPreviewNew')">
                                </label>
                            </div>

                            <div style="font-size: 0.72rem; color: #94A3B8; text-align: center; margin-bottom: 10px;">
                                <i class="fa-solid fa-circle-info"></i>
                                JPG, PNG, WEBP — max 10 Mo (10 photos max) — Compression automatique activée
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

{{-- =========================================================
     MODALE 3 : MODIFIER OBSERVATION
========================================================= --}}
<div class="modal fade" id="modalEditObservation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1E40AF, #2563EB); color: #fff;">
                <div>
                    <h5 class="modal-title" style="color: #fff !important; font-weight: 700;">
                        <i class="fa-solid fa-pen-to-square"></i> Modifier l'observation
                    </h5>
                    <small style="color: rgba(255,255,255,0.85); font-size: 0.8rem;">
                        Panneau {{ $panneau->code_nomen ?? '—' }}
                    </small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditObservation" method="POST" style="display: flex; flex-direction: column; flex: 1; min-height: 0;">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div id="editObsError" class="alert alert-danger d-none" style="margin: 16px 26px 0; border-radius: 10px;"></div>
                    <div id="editObsSuccess" class="alert alert-success d-none" style="margin: 16px 26px 0; border-radius: 10px;"></div>

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#edit-tab-insp" type="button">
                                <i class="fa-solid fa-heart-pulse"></i> Inspection
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-tab-dates" type="button">
                                <i class="fa-solid fa-calendar"></i> Dates techniques
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="edit-tab-insp">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Date d'observation</label>
                                    <input type="datetime-local" name="date_obs" id="edit_date_obs" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">État actuel *</label>
                                    <select name="etat_actuel" id="edit_etat" class="form-select" required>
                                        <option value="">— Choisir —</option>
                                        <option value="Bon">Bon</option>
                                        <option value="Dégradé">Dégradé</option>
                                        <option value="Vandalisé">Vandalisé</option>
                                        <option value="Masqué">Masqué</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Classe rétro</label>
                                    <select name="classe_retro" id="edit_classe" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="Type 1 (EG)">Type 1 (EG)</option>
                                        <option value="Type 2 (HI)">Type 2 (HI)</option>
                                        <option value="Type 3 (DG)">Type 3 (DG)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">N° agrément</label>
                                    <input type="text" name="num_agrem" id="edit_num_agrem" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Remarque</label>
                                    <textarea name="remarque" id="edit_remarque" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="edit-tab-dates">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Date fabrication</label>
                                    <input type="date" name="date_fabrication" id="edit_date_fab" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date pose</label>
                                    <input type="date" name="date_pose" id="edit_date_pose" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Fin garantie</label>
                                    <input type="date" name="garantie_expiration" id="edit_garantie" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="fa-solid fa-xmark"></i> Annuler
                    </button>
                    <button type="submit" id="btnSubmitEditObs" style="border-radius: 8px; font-weight: 600; background: linear-gradient(135deg, #1E40AF, #2563EB); color: #fff; border: none; padding: 8px 20px;">
                        <i class="fa-solid fa-check"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- =========================================================
     LIGHTBOX PHOTOS
========================================================= --}}
<div class="photo-lightbox" id="photoLightbox" role="dialog" aria-modal="true" aria-label="Visionneuse de photos">
    <div class="lb-topbar">
        <div class="lb-counter" id="lbCounter">1 / 1</div>
        <div class="lb-actions">
            <button type="button" class="lb-btn" id="lbZoomBtn" title="Zoom (Z)">
                <i class="fa-solid fa-magnifying-glass-plus"></i>
            </button>
            <button type="button" class="lb-btn" id="lbDownloadBtn" title="Télécharger">
                <i class="fa-solid fa-download"></i>
            </button>
            <button type="button" class="lb-btn lb-close" id="lbCloseBtn" title="Fermer (Échap)">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <button type="button" class="lb-nav lb-prev" id="lbPrevBtn" title="Précédent (←)">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button type="button" class="lb-nav lb-next" id="lbNextBtn" title="Suivant (→)">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <div class="lb-stage">
        <div class="lb-img-wrapper">
            <img src="" alt="" class="lb-img" id="lbImage">
        </div>
    </div>

    <div class="lb-thumbs" id="lbThumbs"></div>
</div>

{{-- =========================================================
     LEAFLET
========================================================= --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@if ($panneau->lat && $panneau->lng)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat    = {{ $panneau->lat }};
    const lng    = {{ $panneau->lng }};
    const svgUrl = @json($svgPath);

    const isMobile = L.Browser.mobile;

    const map = L.map('map-detail', {
        center: [lat, lng], zoom: 16, zoomControl: true,
        scrollWheelZoom: !isMobile, zoomSnap: 0.5,
        tap: true, tapTolerance: 15
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    function sizeForZoom(zoom) {
        if (zoom <= 10) return 14;
        if (zoom <= 13) return 24;
        if (zoom <= 16) return 40;
        return 56;
    }

    function buildIconHtml(zoom, hovered = false) {
        const baseSize = sizeForZoom(zoom);
        const size     = hovered ? Math.round(baseSize * 1.25) : baseSize;
        const padding  = Math.round(size * 0.12);
        const border   = zoom <= 10 ? 2 : 2.5;

        if (zoom <= 10) {
            return `<div style="width:${size}px;height:${size}px;background:linear-gradient(135deg,#2563EB,#1E40AF);border:2px solid #fff;border-radius:50%;box-shadow:0 2px 6px rgba(37,99,235,0.5);transform:${hovered?'scale(1.3)':'scale(1)'};transition:all 0.2s ease;"></div>`;
        }

        const imgTag = svgUrl
            ? `<img src="${svgUrl}" alt="panneau" style="width:100%;height:100%;object-fit:contain;display:block;" onerror="this.parentElement.innerHTML='<i class=\\'fa-solid fa-sign-hanging\\' style=\\'color:#2563EB;font-size:${size*0.5}px;\\'></i>';">`
            : `<i class="fa-solid fa-sign-hanging" style="color:#2563EB;font-size:${size*0.5}px;"></i>`;

        return `<div style="width:${size}px;height:${size}px;background:#fff;border:${border}px solid #2563EB;border-radius:50%;box-shadow:0 ${Math.round(size*0.12)}px ${Math.round(size*0.25)}px rgba(37,99,235,0.4);display:flex;align-items:center;justify-content:center;padding:${padding}px;overflow:hidden;transform:${hovered?'scale(1.15)':'scale(1)'};transition:all 0.2s ease;">${imgTag}</div>`;
    }

    let hovered = false;
    const z0 = map.getZoom();

    const marker = L.marker([lat, lng], {
        icon: L.divIcon({
            html: buildIconHtml(z0, false),
            className: 'panneau-marker',
            iconSize:   [sizeForZoom(z0), sizeForZoom(z0)],
            iconAnchor: [sizeForZoom(z0) / 2, sizeForZoom(z0) / 2],
            popupAnchor: [0, -sizeForZoom(z0) / 2]
        }),
        riseOnHover: true, zIndexOffset: 1000
    }).addTo(map);

    marker.bindPopup(`
        <div style="font-family:'Inter',sans-serif;min-width:200px;text-align:left;">
            ${svgUrl ? `<img src="${svgUrl}" style="width:48px;height:48px;object-fit:contain;float:left;margin-right:10px;">` : ''}
            <div style="font-weight:800;color:#1E40AF;font-size:0.95rem;margin-bottom:2px;">{{ $panneau->code_nomen ?? "Panneau" }}</div>
            <div style="font-size:0.78rem;color:#64748B;margin-bottom:6px;">{{ $panneau->type_nom ?? '' }}</div>
            <div style="clear:both;"></div>
            <div style="font-size:0.78rem;color:#334155;padding-top:6px;border-top:1px solid #F1F5F9;">
                <strong>{{ $panneau->route_nom ?? '' }}</strong>
                @if (!empty($panneau->point_kilo)) — PK {{ $panneau->point_kilo }} @endif
            </div>
        </div>
    `);

    function refreshMarker() {
        const z    = map.getZoom();
        const size = sizeForZoom(z);
        marker.setIcon(L.divIcon({
            html: buildIconHtml(z, hovered),
            className: 'panneau-marker',
            iconSize:   [size, size],
            iconAnchor: [size / 2, size / 2],
            popupAnchor: [0, -size / 2]
        }));
    }

    map.on('zoomend', refreshMarker);
    marker.on('mouseover', function () { hovered = true; refreshMarker(); if (!isMobile) this.openPopup(); });
    marker.on('mouseout', function () { hovered = false; refreshMarker(); });
    marker.on('click', function () { this.openPopup(); });
    setTimeout(() => marker.openPopup(), 300);

    window.addEventListener('orientationchange', function () {
        setTimeout(function () { map.invalidateSize(true); }, 300);
    });
    window.addEventListener('resize', function () {
        map.invalidateSize(true);
    });
});
</script>
@endif

{{-- =========================================================
     SCRIPT PRINCIPAL
========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       ✅ UTILITAIRE : PARSE SÉCURISÉ DE LA RÉPONSE
       Détecte le HTML (erreur serveur) avant de parser le JSON
       ========================================================= */
    async function parseJsonResponse(response) {
        const contentType = response.headers.get('content-type') || '';

        // ✅ Si ce n'est pas du JSON, c'est une erreur serveur (HTML)
        if (!contentType.includes('application/json')) {
            const text = await response.text();
            console.error('❌ Réponse non-JSON reçue (status ' + response.status + ') :', text.substring(0, 500));

            if (response.status === 413 ||
                text.includes('POST Content-Length') ||
                text.includes('exceeds the limit') ||
                text.includes('post_max_size')) {
                throw new Error('Les photos sont trop volumineuses. Réduisez la taille ou le nombre de photos (max 10 Mo au total).');
            }
            if (response.status === 419) {
                throw new Error('Session expirée. Rechargez la page et réessayez.');
            }
            if (response.status === 500) {
                throw new Error('Erreur serveur (500). Vérifiez les logs Laravel.');
            }
            if (response.status === 404) {
                throw new Error('Route introuvable (404).');
            }
            throw new Error('Erreur serveur (' + response.status + '). Réponse invalide.');
        }

        const data = await response.json();

        if (!response.ok) {
            let messages = [];
            if (data.errors) Object.values(data.errors).forEach(arr => arr.forEach(m => messages.push(m)));
            else if (data.message) messages.push(data.message);
            else messages.push('Une erreur est survenue.');
            throw new Error(messages.join('<br>'));
        }

        return data;
    }

    /* =========================================================
       ✅ COMPRESSION DES IMAGES CÔTÉ CLIENT
       Réduit la taille avant upload pour éviter post_max_size
       ========================================================= */
    window.compresserImage = function(file, maxWidth = 1600, quality = 0.8) {
        return new Promise((resolve) => {
            // Si le fichier est petit (< 500 Ko), on ne compresse pas
            if (file.size < 500 * 1024) {
                return resolve(file);
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    let { width, height } = img;

                    if (width > maxWidth) {
                        height = Math.round((height * maxWidth) / width);
                        width = maxWidth;
                    }

                    canvas.width = width;
                    canvas.height = height;

                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob((blob) => {
                        if (!blob) return resolve(file);
                        const newFile = new File(
                            [blob],
                            file.name.replace(/\.[^.]+$/, '.jpg'),
                            { type: 'image/jpeg', lastModified: Date.now() }
                        );
                        console.log('🗜️ Compression: ' + Math.round(file.size/1024) + ' Ko → ' + Math.round(newFile.size/1024) + ' Ko');
                        resolve(newFile);
                    }, 'image/jpeg', quality);
                };
                img.onerror = () => resolve(file);
                img.src = e.target.result;
            };
            reader.onerror = () => resolve(file);
            reader.readAsDataURL(file);
        });
    };

    /* =========================================================
       ✅ CUSTOM SELECT AVEC SVG — CODE NOMENCLATURE (MODALE ÉDITION)
       ========================================================= */
    const nomenTypes = window.__typesPanneaux || [];
    const BASE_SVG   = window.__baseSvg || '';

    function buildNomenOptionHtml(tp, opts) {
        opts = opts || {};
        const isSelected = !!opts.selected;
        const isObsolete = !!opts.obsolete;

        const svgUrl = tp.code_type ? (BASE_SVG + '/' + tp.code_type + '.svg') : null;
        const svgContent = svgUrl
            ? '<img src="' + svgUrl + '" alt="" loading="lazy" onerror="this.style.display=\'none\';this.parentElement.innerHTML=\'<i class=&quot;fa-solid fa-sign-hanging&quot;></i>\';">'
            : '<i class="fa-solid fa-sign-hanging"></i>';

        const nameClass = 'nomen-option__name' + (isObsolete ? ' obsolete' : '');
        const nameText  = isObsolete ? 'Code obsolète' : (tp.nom || '');

        return '<div class="nomen-option' + (isSelected ? ' nomen-option--selected' : '') + '">' +
            '<div class="nomen-option__svg">' + svgContent + '</div>' +
            '<div class="nomen-option__text">' +
                '<div class="nomen-option__code">' + tp.code_type + (isObsolete ? ' (actuel)' : '') + '</div>' +
                '<div class="' + nameClass + '">' + nameText + '</div>' +
            '</div>' +
        '</div>';
    }

    function renderEditNomenOptions(types) {
        const list = document.getElementById('editNomenOptionsList');
        if (!list) return;

        let html = '<div class="nomen-custom-option" data-value="" onclick="selectEditNomenOption(\'\', this)">' +
            '<div class="nomen-option">' +
                '<div class="nomen-option__svg"><i class="fa-solid fa-ban"></i></div>' +
                '<div class="nomen-option__text">' +
                    '<div class="nomen-option__code" style="color:#94A3B8;font-weight:600;">— Non renseigné —</div>' +
                '</div>' +
            '</div>' +
        '</div>';

        types.forEach(function (tp) {
            const safeCode = (tp.code_type || '').replace(/'/g, "\\'");
            html += '<div class="nomen-custom-option" data-value="' + safeCode + '" onclick="selectEditNomenOption(\'' + safeCode + '\', this)">' +
                buildNomenOptionHtml(tp, {}) +
            '</div>';
        });

        list.innerHTML = html;
    }

    function initEditNomenDisplay() {
        const hidden   = document.getElementById('edit_code_nomen_hidden');
        const display  = document.getElementById('editNomenSelectedDisplay');
        if (!display) return;

        const codeActuel = hidden ? (hidden.value || '') : '';

        if (!codeActuel) {
            display.innerHTML = '<div class="nomen-option">' +
                '<div class="nomen-option__svg"><i class="fa-solid fa-sign-hanging"></i></div>' +
                '<div class="nomen-option__text"><div class="nomen-option__code" style="color:#94A3B8;">— Non renseigné —</div></div>' +
            '</div>';
        } else {
            const tpExiste = nomenTypes.find(function (t) { return t.code_type === codeActuel; });
            const tp = tpExiste || { code_type: codeActuel, nom: '{{ $panneau->type_nom ?? $panneau->name ?? "" }}', obsolete: true };
            display.innerHTML = buildNomenOptionHtml(tp, { selected: true, obsolete: !tpExiste });
        }

        document.querySelectorAll('#editNomenOptionsList .nomen-custom-option').forEach(function (o) {
            o.classList.toggle('active', o.dataset.value === codeActuel);
        });
    }

    window.toggleEditNomenDropdown = function () {
        const el = document.getElementById('editNomenCustomSelect');
        if (!el) return;
        el.classList.toggle('open');
        if (el.classList.contains('open')) {
            const search = document.getElementById('editNomenSearch');
            if (search) { search.value = ''; renderEditNomenOptions(nomenTypes); setTimeout(function() { search.focus(); }, 50); }
        }
    };

    window.selectEditNomenOption = function (value, el) {
        const hidden = document.getElementById('edit_code_nomen_hidden');
        if (hidden) hidden.value = value;

        const display = document.getElementById('editNomenSelectedDisplay');
        if (display) {
            if (!value) {
                display.innerHTML = '<div class="nomen-option">' +
                    '<div class="nomen-option__svg"><i class="fa-solid fa-sign-hanging"></i></div>' +
                    '<div class="nomen-option__text"><div class="nomen-option__code" style="color:#94A3B8;">— Non renseigné —</div></div>' +
                '</div>';
            } else {
                const tp = nomenTypes.find(function (t) { return t.code_type === value; })
                        || { code_type: value, nom: '' };
                display.innerHTML = buildNomenOptionHtml(tp, { selected: true });
            }
        }

        /* ✅ Auto-remplissage du champ Nom */
        const nomInput = document.getElementById('edit_name');
        if (nomInput) {
            if (!value) {
                nomInput.value = '';
            } else {
                const tp = nomenTypes.find(function (t) { return t.code_type === value; });
                nomInput.value = tp ? (tp.nom || '') : '';
            }
        }

        document.querySelectorAll('#editNomenOptionsList .nomen-custom-option').forEach(function (o) {
            o.classList.toggle('active', o.dataset.value === value);
        });

        const el2 = document.getElementById('editNomenCustomSelect');
        if (el2) el2.classList.remove('open');
    };

    window.filterEditNomenOptions = function (q) {
        q = (q || '').toLowerCase().trim();
        const filtered = !q ? nomenTypes : nomenTypes.filter(function (tp) {
            return (tp.code_type || '').toLowerCase().indexOf(q) !== -1
                || (tp.nom || '').toLowerCase().indexOf(q) !== -1;
        });
        renderEditNomenOptions(filtered);
    };

    document.addEventListener('click', function (e) {
        const el = document.getElementById('editNomenCustomSelect');
        if (el && !el.contains(e.target)) el.classList.remove('open');
    });

    /* Init au chargement */
    renderEditNomenOptions(nomenTypes);
    initEditNomenDisplay();

    /* Reset à l'ouverture de la modale d'édition */
    const modalEditPanneauEl = document.getElementById('modalEditPanneau');
    if (modalEditPanneauEl) {
        modalEditPanneauEl.addEventListener('show.bs.modal', function () {
            renderEditNomenOptions(nomenTypes);
            initEditNomenDisplay();
        });
    }

    /* =========================================================
       PREVIEW DES PHOTOS AVANT UPLOAD (Android + Desktop)
    ========================================================= */
    window.previewPhotos = function(input, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const cameraInput  = document.getElementById('newObsPhotosCamera');
        const galleryInput = document.getElementById('newObsPhotosGallery');

        let allFiles = [];

        if (cameraInput && cameraInput.files) {
            Array.from(cameraInput.files).forEach(function (f) { allFiles.push(f); });
        }
        if (galleryInput && galleryInput.files) {
            Array.from(galleryInput.files).forEach(function (f) { allFiles.push(f); });
        }

        /* Éviter les doublons */
        const seen = new Set();
        const uniqueFiles = [];
        allFiles.forEach(function (f) {
            const key = f.name + '|' + f.size + '|' + f.lastModified;
            if (!seen.has(key)) {
                seen.add(key);
                uniqueFiles.push(f);
            }
        });

        container.innerHTML = '';

        if (uniqueFiles.length === 0) return;

        uniqueFiles.forEach(function(file) {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'photo-preview-item';
                div.innerHTML = '<img src="' + e.target.result + '" alt="preview">';
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    };

    /* =========================================================
       LIGHTBOX PHOTOS
    ========================================================= */
    let lbPhotos  = [];
    let lbCurrent = 0;

    window.openLightbox = function(idObs, startIndex = 0) {
        const photos = (window.__allPhotosByObs || {})[idObs] || [];

        if (photos.length === 0) {
            console.warn('Aucune photo pour id_obs = ' + idObs);
            return;
        }

        lbPhotos  = photos;
        lbCurrent = Math.max(0, Math.min(startIndex, photos.length - 1));

        const lightbox = document.getElementById('photoLightbox');
        if (!lightbox) return;

        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';

        renderLightbox();
    };

    function renderLightbox() {
        const img       = document.getElementById('lbImage');
        const counter   = document.getElementById('lbCounter');
        const thumbsBox = document.getElementById('lbThumbs');
        const prevBtn   = document.getElementById('lbPrevBtn');
        const nextBtn   = document.getElementById('lbNextBtn');

        if (!img) return;

        const url = lbPhotos[lbCurrent];

        img.classList.remove('zoomed');
        img.src = url;
        img.alt = 'Photo ' + (lbCurrent + 1);

        counter.textContent = (lbCurrent + 1) + ' / ' + lbPhotos.length;

        if (lbPhotos.length <= 1) {
            prevBtn.classList.add('hidden');
            nextBtn.classList.add('hidden');
        } else {
            prevBtn.classList.remove('hidden');
            nextBtn.classList.remove('hidden');
        }

        thumbsBox.innerHTML = '';
        lbPhotos.forEach(function(photoUrl, idx) {
            const thumb = document.createElement('div');
            thumb.className = 'lb-thumb' + (idx === lbCurrent ? ' active' : '');
            thumb.innerHTML = '<img src="' + photoUrl + '" alt="Miniature ' + (idx + 1) + '" loading="lazy">';
            thumb.onclick = function(e) {
                e.stopPropagation();
                lbCurrent = idx;
                renderLightbox();
            };
            thumbsBox.appendChild(thumb);
        });

        const activeThumb = thumbsBox.querySelector('.lb-thumb.active');
        if (activeThumb) {
            activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }

    window.lbNavigate = function(direction) {
        if (lbPhotos.length <= 1) return;
        lbCurrent = (lbCurrent + direction + lbPhotos.length) % lbPhotos.length;
        renderLightbox();
    };

    window.closeLightbox = function() {
        const lightbox = document.getElementById('photoLightbox');
        if (!lightbox) return;
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
        lbPhotos  = [];
        lbCurrent = 0;
    };

    document.getElementById('lbCloseBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        closeLightbox();
    });
    document.getElementById('lbPrevBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        lbNavigate(-1);
    });
    document.getElementById('lbNextBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        lbNavigate(1);
    });

    document.getElementById('lbZoomBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const img = document.getElementById('lbImage');
        img.classList.toggle('zoomed');
    });

    document.getElementById('lbDownloadBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const url = lbPhotos[lbCurrent];
        const a = document.createElement('a');
        a.href = url;
        a.download = 'photo-' + (lbCurrent + 1) + '.jpg';
        a.target = '_blank';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });

    document.getElementById('lbImage')?.addEventListener('click', function(e) {
        e.stopPropagation();
        this.classList.toggle('zoomed');
    });

    document.getElementById('photoLightbox')?.addEventListener('click', function(e) {
        if (e.target === this ||
            e.target.classList.contains('lb-stage') ||
            e.target.classList.contains('lb-img-wrapper')) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', function(e) {
        const lightbox = document.getElementById('photoLightbox');
        if (!lightbox || !lightbox.classList.contains('active')) return;

        switch (e.key) {
            case 'Escape': closeLightbox(); break;
            case 'ArrowLeft': e.preventDefault(); lbNavigate(-1); break;
            case 'ArrowRight': e.preventDefault(); lbNavigate(1); break;
            case 'z': case 'Z': document.getElementById('lbZoomBtn')?.click(); break;
        }
    });

    (function() {
        let touchStartX = 0;
        let touchEndX = 0;

        document.getElementById('photoLightbox')?.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        document.getElementById('photoLightbox')?.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            const delta = touchEndX - touchStartX;

            if (Math.abs(delta) > 60) {
                if (delta > 0) lbNavigate(-1);
                else           lbNavigate(1);
            }
        }, { passive: true });
    })();

    /* =========================================================
       ÉDITION DU PANNEAU : SOUMISSION
    ========================================================= */
    const formEditPanneau = document.getElementById('formEditPanneau');
    if (formEditPanneau) {
        let isSubmittingEdit = false;
        formEditPanneau.addEventListener('submit', function (e) {
            e.preventDefault();
            if (isSubmittingEdit) return;
            isSubmittingEdit = true;

            const errorBox   = document.getElementById('modalEditError');
            const successBox = document.getElementById('modalEditSuccess');
            const btn        = document.getElementById('btnSubmitEdit');

            errorBox.classList.add('d-none');
            successBox.classList.add('d-none');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Enregistrement...';

            fetch(formEditPanneau.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: new FormData(formEditPanneau),
            })
            .then(parseJsonResponse)
            .then((data) => {
                successBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (data.message || 'Enregistré !');
                successBox.classList.remove('d-none');
                setTimeout(() => window.location.reload(), 900);
            })
            .catch((err) => {
                errorBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + err.message;
                errorBox.classList.remove('d-none');
                isSubmittingEdit = false;
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Enregistrer';
            });
        });
    }

    /* =========================================================
       ✅ NOUVELLE OBSERVATION : SOUMISSION AVEC COMPRESSION PHOTOS
    ========================================================= */
    const formNewObs = document.getElementById('formNewObservation');
    let isSubmittingNewObs = false;

    if (formNewObs) {
        formNewObs.addEventListener('submit', async function (e) {
            e.preventDefault();

            if (isSubmittingNewObs) return;
            isSubmittingNewObs = true;

            const errorBox   = document.getElementById('newObsError');
            const successBox = document.getElementById('newObsSuccess');
            const btn        = document.getElementById('btnSubmitNewObs');

            errorBox.classList.add('d-none');
            successBox.classList.add('d-none');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Compression & envoi...';

            try {
                // ✅ Construire un nouveau FormData avec compression
                const formData = new FormData();

                // Copier tous les champs SAUF les fichiers photos
                for (const [key, value] of new FormData(formNewObs).entries()) {
                    if (key !== 'photos[]') {
                        formData.append(key, value);
                    }
                }

                // Récupérer les fichiers des 2 inputs
                const cameraInput  = document.getElementById('newObsPhotosCamera');
                const galleryInput = document.getElementById('newObsPhotosGallery');

                let allFiles = [];
                if (cameraInput && cameraInput.files)  Array.from(cameraInput.files).forEach(f => allFiles.push(f));
                if (galleryInput && galleryInput.files) Array.from(galleryInput.files).forEach(f => allFiles.push(f));

                // Dédupliquer
                const seen = new Set();
                const uniqueFiles = allFiles.filter(f => {
                    const k = f.name + '|' + f.size + '|' + f.lastModified;
                    if (seen.has(k)) return false;
                    seen.add(k);
                    return true;
                });

                // Compresser chaque photo (max 1600px, qualité 0.8)
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Compression photos...';
                for (const file of uniqueFiles) {
                    if (!file.type.startsWith('image/')) continue;
                    const compressed = await window.compresserImage(file);
                    formData.append('photos[]', compressed);
                }

                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Enregistrement...';

                // ✅ Envoi
                const response = await fetch(formNewObs.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await parseJsonResponse(response);

                successBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (data.message || 'Enregistré !');
                successBox.classList.remove('d-none');
                setTimeout(() => window.location.reload(), 900);

            } catch (err) {
                console.error('❌ Erreur soumission observation:', err);
                errorBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + err.message;
                errorBox.classList.remove('d-none');
                isSubmittingNewObs = false;
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Enregistrer l\'observation';
            }
        });
    }

    /* =========================================================
       MODALE ÉDITION OBSERVATION
    ========================================================= */
    const modalEditObs = document.getElementById('modalEditObservation');
    if (modalEditObs) {
        modalEditObs.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            if (!btn) return;

            const idObs    = btn.getAttribute('data-id-obs');
            const dateObs  = btn.getAttribute('data-date-obs');
            const dateFab  = btn.getAttribute('data-date-fab');
            const datePose = btn.getAttribute('data-date-pose');
            const garantie = btn.getAttribute('data-garantie');
            const numAgrem = btn.getAttribute('data-num-agrem');
            const classe   = btn.getAttribute('data-classe-retro');
            const etat     = btn.getAttribute('data-etat');
            const remarque = btn.getAttribute('data-remarque');

            document.getElementById('edit_etat').value      = etat || '';
            document.getElementById('edit_classe').value    = classe || '';
            document.getElementById('edit_num_agrem').value = numAgrem || '';
            document.getElementById('edit_remarque').value  = remarque || '';

            if (dateObs) {
                const d = new Date(dateObs);
                const tzOffset = d.getTimezoneOffset() * 60000;
                const local = new Date(d.getTime() - tzOffset);
                document.getElementById('edit_date_obs').value = local.toISOString().slice(0, 16);
            } else {
                document.getElementById('edit_date_obs').value = '';
            }

            document.getElementById('edit_date_fab').value  = dateFab ? dateFab.slice(0, 10) : '';
            document.getElementById('edit_date_pose').value = datePose ? datePose.slice(0, 10) : '';
            document.getElementById('edit_garantie').value  = garantie ? garantie.slice(0, 10) : '';

            const form = document.getElementById('formEditObservation');
            form.action = '/signalisation/observation/' + idObs;
        });
    }

    /* =========================================================
       MODIFIER OBSERVATION : SOUMISSION
    ========================================================= */
    const formEditObs = document.getElementById('formEditObservation');
    if (formEditObs) {
        let isSubmittingEditObs = false;
        formEditObs.addEventListener('submit', function (e) {
            e.preventDefault();
            if (isSubmittingEditObs) return;
            isSubmittingEditObs = true;

            const errorBox   = document.getElementById('editObsError');
            const successBox = document.getElementById('editObsSuccess');
            const btn        = document.getElementById('btnSubmitEditObs');

            errorBox.classList.add('d-none');
            successBox.classList.add('d-none');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Enregistrement...';

            fetch(formEditObs.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: new FormData(formEditObs),
            })
            .then(parseJsonResponse)
            .then((data) => {
                successBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (data.message || 'Enregistré !');
                successBox.classList.remove('d-none');
                setTimeout(() => window.location.reload(), 900);
            })
            .catch((err) => {
                errorBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + err.message;
                errorBox.classList.remove('d-none');
                isSubmittingEditObs = false;
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Enregistrer';
            });
        });
    }

    /* =========================================================
       SUPPRESSION D'UNE OBSERVATION
    ========================================================= */
    document.querySelectorAll('.btn-obs-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const url = this.getAttribute('data-url');

            if (!confirm('Supprimer cette observation ?\nCette action est irréversible.')) return;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(parseJsonResponse)
            .then((data) => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Erreur lors de la suppression.');
                }
            })
            .catch((err) => alert('Erreur : ' + err.message));
        });
    });

    /* =========================================================
       RESET DES ONGLETS À L'OUVERTURE
    ========================================================= */
    document.querySelectorAll('.modal').forEach(function (modalEl) {
        modalEl.addEventListener('show.bs.modal', function () {
            const firstTab = this.querySelector('.nav-tabs .nav-link');
            if (firstTab) new bootstrap.Tab(firstTab).show();
        });
    });

});
</script>

{{-- =========================================================
     MODALE PHOTO UNIVERSELLE (legacy — peut être supprimée si non utilisée)
========================================================= --}}
<div class="modal fade" id="modalPhotoViewer" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="background: #0F172A; border: none;">
            <div class="modal-header" style="background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.1); padding: 12px 20px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="color: #fff; font-weight: 700; font-size: 0.9rem;" id="photoCounter">1 / 1</span>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <button type="button" class="btn btn-sm" onclick="telechargerPhoto()" title="Télécharger"
                            style="background: rgba(255,255,255,0.15); color: #fff; border: none; border-radius: 8px; padding: 6px 12px;">
                        <i class="fa-solid fa-download"></i>
                    </button>
                    <button type="button" class="btn btn-sm" onclick="zoomerPhoto()" title="Zoom"
                            style="background: rgba(255,255,255,0.15); color: #fff; border: none; border-radius: 8px; padding: 6px 12px;">
                        <i class="fa-solid fa-magnifying-glass-plus" id="zoomIcon"></i>
                    </button>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
            </div>
            <div class="modal-body" style="padding: 0; position: relative; min-height: 500px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <button type="button" id="btnPrevPhoto" onclick="naviguerPhoto(-1)"
                        style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); z-index: 10; width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #fff; font-size: 1.3rem; cursor: pointer;">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <img id="photoViewerImg" src="" alt="Photo"
                     style="max-width: 100%; max-height: 75vh; object-fit: contain; border-radius: 8px; transition: transform 0.3s ease; cursor: pointer;"
                     onclick="zoomerPhoto()">
                <button type="button" id="btnNextPhoto" onclick="naviguerPhoto(1)"
                        style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); z-index: 10; width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #fff; font-size: 1.3rem; cursor: pointer;">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
            <div class="modal-footer" id="photoThumbsBar"
                 style="background: rgba(255,255,255,0.05); border-top: 1px solid rgba(255,255,255,0.1); padding: 12px 20px; justify-content: center; gap: 8px; overflow-x: auto;">
            </div>
        </div>
    </div>
</div>

<script>
// =========================================================
// VISIONNEUSE DE PHOTOS — VERSION LEGACY
// =========================================================
var photosCourantes = [];
var photoIndex = 0;
var estZoomee = false;

function ouvrirPhotos(photos, index) {
    if (!photos || photos.length === 0) {
        alert('Aucune photo à afficher');
        return;
    }

    photosCourantes = photos;
    photoIndex = Math.max(0, Math.min(index || 0, photos.length - 1));
    estZoomee = false;

    afficherPhotoCourante();

    var modalEl = document.getElementById('modalPhotoViewer');
    var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
    modal.show();
}

function afficherPhotoCourante() {
    var img = document.getElementById('photoViewerImg');
    var counter = document.getElementById('photoCounter');
    var prevBtn = document.getElementById('btnPrevPhoto');
    var nextBtn = document.getElementById('btnNextPhoto');
    var thumbsBar = document.getElementById('photoThumbsBar');

    if (!img) return;

    img.style.transform = 'scale(1)';
    estZoomee = false;
    document.getElementById('zoomIcon').className = 'fa-solid fa-magnifying-glass-plus';

    img.src = photosCourantes[photoIndex];
    img.alt = 'Photo ' + (photoIndex + 1);

    counter.textContent = (photoIndex + 1) + ' / ' + photosCourantes.length;

    if (photosCourantes.length <= 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'block';
        nextBtn.style.display = 'block';
    }

    thumbsBar.innerHTML = '';
    photosCourantes.forEach(function(url, idx) {
        var thumb = document.createElement('div');
        thumb.style.cssText = 'width: 60px; height: 60px; border-radius: 6px; overflow: hidden; cursor: pointer; border: 2px solid ' + (idx === photoIndex ? '#2563EB' : 'transparent') + '; opacity: ' + (idx === photoIndex ? '1' : '0.5') + '; transition: all 0.2s ease; flex-shrink: 0;';
        thumb.innerHTML = '<img src="' + url + '" style="width: 100%; height: 100%; object-fit: cover;">';
        thumb.onclick = function() {
            photoIndex = idx;
            afficherPhotoCourante();
        };
        thumb.onmouseover = function() { this.style.opacity = '0.9'; };
        thumb.onmouseout = function() { this.style.opacity = (idx === photoIndex ? '1' : '0.5'); };
        thumbsBar.appendChild(thumb);
    });
}

function naviguerPhoto(direction) {
    if (photosCourantes.length <= 1) return;
    photoIndex = (photoIndex + direction + photosCourantes.length) % photosCourantes.length;
    afficherPhotoCourante();
}

function zoomerPhoto() {
    var img = document.getElementById('photoViewerImg');
    var icon = document.getElementById('zoomIcon');

    estZoomee = !estZoomee;

    if (estZoomee) {
        img.style.transform = 'scale(1.8)';
        img.style.cursor = 'zoom-out';
        icon.className = 'fa-solid fa-magnifying-glass-minus';
    } else {
        img.style.transform = 'scale(1)';
        img.style.cursor = 'zoom-in';
        icon.className = 'fa-solid fa-magnifying-glass-plus';
    }
}

function telechargerPhoto() {
    var url = photosCourantes[photoIndex];
    if (!url) return;

    var a = document.createElement('a');
    a.href = url;
    a.download = 'photo-' + (photoIndex + 1) + '.jpg';
    a.target = '_blank';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

console.log('✅ Visionneuse de photos chargée');
</script>
@endsection
