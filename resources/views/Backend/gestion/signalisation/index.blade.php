@extends('template.admin_master')

@section('Content')

<style>
    .sig-page {
        padding: 24px;
        background: #F8FAFC !important;
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
        color: #0F172A !important;
    }

    .sig-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 22px;
    }

    .sig-title {
        font-size: 1.55rem;
        font-weight: 800;
        color: #0F172A !important;
        margin: 0 0 4px;
        letter-spacing: -0.02em;
    }

    .sig-subtitle {
        font-size: 0.88rem;
        color: #64748B !important;
        margin: 0;
    }

    .btn-back-dash {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        background: #fff;
        border: 1.5px solid #E2E8F0;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155 !important;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back-dash:hover {
        border-color: #2563EB;
        color: #2563EB !important;
        transform: translateX(-2px);
    }

    /* FILTRES */
    .sig-filters {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 18px 22px;
        margin-bottom: 22px;
        display: grid;
        grid-template-columns: 2fr 1fr 2fr 1fr auto;
        gap: 14px;
        align-items: end;
        box-shadow: 0 1px 3px rgba(15,23,42,0.03);
    }

    @media (max-width: 1100px) {
        .sig-filters { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .sig-filters { grid-template-columns: 1fr; }
    }

    .filter-group label {
        display: block;
        font-size: 0.72rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
        padding: 9px 12px;
        border: 1.5px solid #E2E8F0;
        border-radius: 10px;
        font-size: 0.85rem;
        background: #fff;
        color: #0F172A;
        outline: none;
        transition: all 0.15s ease;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.10);
    }

    .filter-actions {
        display: flex;
        gap: 8px;
    }

    .btn-filter {
        padding: 10px 18px;
        background: linear-gradient(135deg, #1E40AF, #2563EB);
        color: #fff !important;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.85rem;
        transition: transform 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-filter:hover { transform: translateY(-1px); }

    .btn-reset {
        padding: 10px 16px;
        background: #fff;
        color: #64748B !important;
        border: 1.5px solid #E2E8F0;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.85rem;
        text-decoration: none;
        text-align: center;
        line-height: 1.2;
        transition: all 0.15s ease;
    }

    .btn-reset:hover {
        border-color: #DC2626;
        color: #DC2626 !important;
    }

    /* TABLEAU */
    .sig-card {
        background: #fff !important;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 2px 12px rgba(15,23,42,0.04);
        overflow: hidden;
    }

    .sig-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .sig-table thead { background: #F8FAFC; }

    .sig-table th {
        text-align: left;
        padding: 14px 18px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748B !important;
        border-bottom: 1px solid #E2E8F0;
        white-space: nowrap;
    }

    .sig-table tbody tr {
        transition: background 0.15s ease;
        border-bottom: 1px solid #F1F5F9;
    }

    .sig-table tbody tr[data-href]:not([data-href=""]) {
        cursor: pointer;
    }

    .sig-table tbody tr:hover { background: #F8FAFC !important; }

    .sig-table td {
        padding: 16px 18px;
        color: #334155 !important;
        vertical-align: middle;
    }

    /* CELLULES */
    .type-cell { display: flex; align-items: center; gap: 14px; }

    .type-svg {
        width: 52px;
        height: 52px;
        object-fit: contain;
        flex-shrink: 0;
        background: #FFFFFF;
        border-radius: 10px;
        padding: 4px;
        border: 1.5px solid #E2E8F0;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        transition: transform 0.2s ease;
    }

    .sig-table tbody tr:hover .type-svg {
        transform: scale(1.08);
        border-color: #2563EB;
    }

    .type-info { display: flex; flex-direction: column; gap: 4px; min-width: 0; }

    .type-code {
        font-size: 0.9rem;
        font-weight: 800;
        color: #1E40AF !important;
        letter-spacing: -0.01em;
        line-height: 1.1;
    }

    .type-name {
        font-size: 0.78rem;
        color: #64748B !important;
        line-height: 1.35;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .loc-cell { display: flex; flex-direction: column; gap: 3px; }

    .loc-route {
        font-weight: 700;
        color: #0F172A !important;
        font-size: 0.85rem;
    }

    .loc-pk {
        font-size: 0.75rem;
        color: #64748B !important;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .loc-pk i { font-size: 0.7rem; color: #94A3B8; }

    .obs-cell { display: flex; flex-direction: column; gap: 5px; }

    .obs-date {
        font-size: 0.8rem;
        font-weight: 600;
        color: #0F172A !important;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .obs-date i { font-size: 0.75rem; color: #94A3B8; }

    .obs-date.empty {
        color: #94A3B8 !important;
        font-weight: 500;
        font-style: italic;
    }

    .badge-etat {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
        width: fit-content;
    }

    .badge-etat::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .badge-etat.bon { background: rgba(16,185,129,0.12); color: #059669 !important; }
    .badge-etat.bon::before { background: #059669; }

    .badge-etat.degrade { background: rgba(250,204,21,0.18); color: #B45309 !important; }
    .badge-etat.degrade::before { background: #B45309; }

    .badge-etat.vandal { background: rgba(249,115,22,0.15); color: #EA580C !important; }
    .badge-etat.vandal::before { background: #EA580C; }

    .badge-etat.masque { background: rgba(220,38,38,0.10); color: #DC2626 !important; }
    .badge-etat.masque::before { background: #DC2626; }

    .badge-etat.aucun { background: rgba(148,163,184,0.15); color: #64748B !important; }
    .badge-etat.aucun::before { background: #94A3B8; }

    .obs-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 26px;
        height: 22px;
        padding: 0 8px;
        background: #EFF6FF;
        color: #2563EB !important;
        border-radius: 100px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .obs-count.zero {
        background: #F1F5F9;
        color: #94A3B8 !important;
    }

    .tech-cell {
        font-size: 0.78rem;
        color: #64748B !important;
    }

    /* BOUTON DÉTAILS */
    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: linear-gradient(135deg, #2563EB, #1E40AF);
        color: #fff !important;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        white-space: nowrap;
    }

    .btn-detail:hover {
        background: linear-gradient(135deg, #1E40AF, #1E3A8A);
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35);
        color: #fff !important;
    }

    .btn-detail i { font-size: 0.85rem; }

    /* PAGINATION */
    .sig-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 22px;
        background: #fff;
        border-top: 1px solid #E2E8F0;
        flex-wrap: wrap;
        gap: 10px;
    }

    .sig-pagination .info {
        font-size: 0.82rem;
        color: #64748B;
    }

    /* EMPTY */
    .empty-state {
        padding: 80px 20px;
        text-align: center;
        color: #94A3B8;
    }

    .empty-state i {
        font-size: 3.5rem;
        opacity: 0.3;
        margin-bottom: 16px;
        display: block;
    }

    .empty-state p {
        font-size: 0.95rem;
        margin: 0;
    }

    /* BOUTON NOUVEAU PANNEAU */
    .btn-new-panneau {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        background: linear-gradient(135deg, #10B981, #059669);
        color: #fff !important;
        border: none;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-new-panneau:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        color: #fff !important;
    }

    /* =========================================================
       FORCER LA VISIBILITÉ DES <option> DES <select>
    ========================================================= */
    select,
    select option,
    select optgroup,
    .form-select,
    .form-select option {
        background-color: #ffffff !important;
        color: #0F172A !important;
    }

    select option {
        padding: 8px 12px !important;
        background-color: #ffffff !important;
        color: #0F172A !important;
    }

    select option:checked,
    select option:checked:hover {
        background: #2563EB !important;
        background-color: #2563EB !important;
        color: #ffffff !important;
    }

    select option:hover {
        background-color: #EFF6FF !important;
        color: #1E40AF !important;
    }

    @-moz-document url-prefix() {
        select option {
            background-color: #ffffff !important;
            color: #0F172A !important;
        }
    }

    select:focus option:checked {
        background: linear-gradient(0deg, #2563EB 0%, #2563EB 100%) !important;
        color: #fff !important;
    }

    select {
        color: #0F172A !important;
        background-color: #ffffff !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        color-scheme: light !important;
    }

    .btn-carte {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
        background: linear-gradient(135deg, #1E40AF, #2563EB);
        color: #fff !important;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }
    .btn-carte:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35);
        color: #fff !important;
    }

    /* =========================================================
       RESPONSIVE — TABLETTE & SMARTPHONE
       ========================================================= */

    /* TABLETTE (≤ 1024px) */
    @media (max-width: 1024px) {
        .sig-page { padding: 18px; }
        .sig-title { font-size: 1.35rem; }
        .sig-subtitle { font-size: 0.82rem; }
        .sig-filters { padding: 16px 18px; gap: 12px; }
        .sig-table th { padding: 12px 14px; }
        .sig-table td { padding: 14px 14px; }
        .type-svg { width: 46px; height: 46px; }
        .type-code { font-size: 0.85rem; }
        .type-name { font-size: 0.74rem; }
    }

    /* SMARTPHONE (≤ 768px) */
    @media (max-width: 768px) {
        .sig-page { padding: 12px; }

        /* HEADER — empilé verticalement */
        .sig-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            margin-bottom: 16px;
        }
        .sig-title { font-size: 1.2rem; }
        .sig-subtitle { font-size: 0.78rem; line-height: 1.4; }
        .sig-header > div:last-child {
            display: grid !important;
            grid-template-columns: 1fr;
            gap: 8px !important;
            width: 100%;
        }
        .btn-back-dash,
        .btn-new-panneau,
        .btn-carte {
            justify-content: center;
            padding: 10px 14px;
            font-size: 0.8rem;
            width: 100%;
        }

        /* FILTRES — 1 colonne */
        .sig-filters {
            grid-template-columns: 1fr;
            padding: 14px 14px;
            gap: 12px;
            border-radius: 12px;
        }
        .filter-group input,
        .filter-group select {
            padding: 10px 12px;
            font-size: 0.85rem;
        }
        .filter-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .btn-filter,
        .btn-reset {
            justify-content: center;
            padding: 10px 12px;
            font-size: 0.82rem;
        }

        /* TABLEAU — transformation en cartes empilées */
        .sig-card {
            border-radius: 12px;
            background: transparent !important;
            border: none;
            box-shadow: none;
            overflow: visible;
        }
        .sig-table {
            display: block;
            font-size: 0.85rem;
        }
        .sig-table thead {
            display: none; /* Masquer les en-têtes */
        }
        .sig-table tbody {
            display: block;
        }
        .sig-table tbody tr {
            display: block;
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 12px;
            box-shadow: 0 1px 4px rgba(15,23,42,0.04);
            position: relative;
        }
        .sig-table tbody tr:hover {
            background: #fff !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.10);
            border-color: #BFDBFE;
        }
        .sig-table tbody tr[data-href]:not([data-href=""])::after {
            content: '\f054'; /* chevron-right */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            color: #CBD5E1;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }
        .sig-table tbody tr[data-href]:not([data-href=""]) :hover::after {
            color: #2563EB;
        }

        /* Chaque cellule devient une ligne de fiche */
        .sig-table td {
            display: block;
            padding: 8px 0;
            border-bottom: 1px dashed #F1F5F9;
            color: #334155 !important;
        }
        .sig-table td:last-child {
            border-bottom: none;
            padding-top: 12px;
            padding-right: 24px; /* espace pour chevron */
        }
        .sig-table td::before {
            content: attr(data-label);
            display: block;
            font-size: 0.65rem;
            font-weight: 700;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        /* Cellule TYPE en premier — pas de label */
        .sig-table td:nth-child(1)::before { display: none; }
        .sig-table td:nth-child(1) {
            padding-bottom: 12px;
            border-bottom: 1px solid #F1F5F9;
            margin-bottom: 6px;
        }

        /* Type cell : horizontal compact */
        .type-cell { gap: 12px; }
        .type-svg {
            width: 56px;
            height: 56px;
            border-radius: 12px;
        }
        .type-code { font-size: 1rem; }
        .type-name { font-size: 0.82rem; -webkit-line-clamp: 2; }

        /* Localisation */
        .loc-route { font-size: 0.92rem; }
        .loc-pk { font-size: 0.8rem; }

        /* Observations */
        .obs-date { font-size: 0.85rem; }
        .badge-etat { font-size: 0.75rem; padding: 5px 12px; }

        /* Compteur inspections */
        .obs-count {
            min-width: 32px;
            height: 26px;
            font-size: 0.78rem;
        }
        .sig-table td:nth-child(5) {
            text-align: left !important;
        }

        /* Bouton détails pleine largeur */
        .sig-table td:nth-child(6) {
            text-align: left !important;
        }
        .btn-detail {
            width: 100%;
            justify-content: center;
            padding: 11px 16px;
            font-size: 0.85rem;
            border-radius: 10px;
        }

        /* Pagination empilée */
        .sig-pagination {
            flex-direction: column;
            gap: 12px;
            padding: 16px 14px;
            border-radius: 12px;
            margin-top: 12px;
        }
        .sig-pagination .info {
            font-size: 0.78rem;
            text-align: center;
            width: 100%;
        }
        .sig-pagination > div:last-child {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            display: flex;
            justify-content: center;
        }

        /* MODALE plein écran */
        .modal-dialog {
            margin: 8px;
            max-width: calc(100vw - 16px) !important;
        }
        .modal-dialog.modal-dialog-centered {
            min-height: calc(100% - 16px);
            align-items: flex-end;
        }
        .modal-content {
            border-radius: 20px 20px 0 0 !important;
            max-height: 94vh !important;
        }
        .modal-header {
            padding: 16px 18px !important;
        }
        .modal-header .modal-title { font-size: 0.95rem !important; }
        .modal-header small { font-size: 0.72rem !important; }
        .modal-body { max-height: calc(100vh - 190px) !important; }
        .modal-footer {
            padding: 14px 18px !important;
            gap: 8px;
        }
        .modal-footer button {
            flex: 1;
            padding: 10px 14px !important;
            font-size: 0.85rem !important;
        }

        /* Onglets modale : scroll horizontal */
        .modal .nav-tabs {
            padding: 0 10px !important;
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
        .modal .tab-content { padding: 16px 16px !important; }

        /* Sections de formulaire */
        .modal h6 {
            font-size: 0.72rem !important;
            padding: 8px 12px !important;
            margin-bottom: 12px !important;
        }
        .modal .form-label {
            font-size: 0.68rem !important;
        }
        .modal .form-control,
        .modal .form-select {
            font-size: 0.85rem !important;
            padding: 9px 12px !important;
        }

        /* Mini-carte réduite */
        #miniMapPreview {
            height: 300px !important;
        }

        /* Filtres : select pleine largeur */
        .filter-group {
            width: 100%;
        }
    }

    /* TRÈS PETIT ÉCRAN (≤ 420px) */
    @media (max-width: 420px) {
        .sig-page { padding: 10px; }
        .sig-title { font-size: 1.05rem; }
        .sig-subtitle { font-size: 0.72rem; }
        .sig-table tbody tr { padding: 12px; }
        .type-svg { width: 48px; height: 48px; }
        .type-code { font-size: 0.92rem; }
        .type-name { font-size: 0.76rem; }
        .modal-header { padding: 14px 16px !important; }
        .modal .tab-content { padding: 14px 14px !important; }
        #miniMapPreview { height: 240px !important; }
        .filter-actions { grid-template-columns: 1fr; }
    }
</style>

<div class="sig-page">

    {{-- EN-TÊTE --}}
    <div class="sig-header">
        <div>
            <h1 class="sig-title">Signalisation verticale</h1>
           
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('all.dashboard') }}" class="btn-back-dash">
                <i class="fa-solid fa-arrow-left"></i> Retour au dashboard
            </a>

            {{-- ✅ Bouton Carte --}}
            <a href="{{ route('carte.index') }}" class="btn-new-panneau"
               style="background: linear-gradient(135deg, #1E40AF, #2563EB); color: #fff; text-decoration: none;">
                <i class="fa-solid fa-map-location-dot"></i> Voir la carte
            </a>

            <button type="button"
                    class="btn-new-panneau"
                    data-bs-toggle="modal"
                    data-bs-target="#modalNewPanneau">
                <i class="fa-solid fa-plus"></i> Nouveau panneau
            </button>
        </div>
    </div>

    {{-- FILTRES --}}
    <form method="GET" action="{{ route('signalisation.index') }}" class="sig-filters">

        <div class="filter-group">
            <label>Recherche</label>
            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Code, nom, route...">
        </div>

        <div class="filter-group">
            <label>Route</label>
            <select name="route_nom">
                <option value="">— Toutes —</option>
                @foreach ($routesDisponibles ?? [] as $r)
                    <option value="{{ $r }}" @selected(($route ?? '') === $r)>{{ $r }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label>Type de panneau</label>
            <select name="code_nomen">
                <option value="">— Tous —</option>
                @foreach ($typesDisponibles ?? [] as $t)
                    <option value="{{ $t->code_type }}" @selected(($type ?? '') === $t->code_type)>
                        {{ $t->code_type }} — {{ $t->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label>État</label>
            <select name="etat_actuel">
                <option value="">— Tous —</option>
                @foreach ($etatsDisponibles ?? [] as $e)
                    <option value="{{ $e }}" @selected(($etat ?? '') === $e)>{{ $e }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-filter">
                <i class="fa-solid fa-filter"></i> Filtrer
            </button>
            <a href="{{ route('signalisation.index') }}" class="btn-reset">Reset</a>
        </div>

    </form>

    {{-- TABLEAU --}}
    <div class="sig-card">

        @if (($panneaux->count() ?? 0) === 0)
            <div class="empty-state">
                <i class="fa-solid fa-inbox"></i>
                <p>Aucun panneau trouvé avec ces critères.</p>
            </div>
        @else
            <table class="sig-table">
                <thead>
                    <tr>
                        <th>Type de panneau</th>
                        <th>Localisation</th>
                        <th>Dimensions / Support</th>
                        <th>Dernière observation</th>
                        <th style="text-align:center;">Inspections</th>
                        <th style="text-align:center; width:140px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($panneaux as $p)
                        @php
                            $etatValue = strtolower($p->etat_actuel ?? '');
                            $classeBadge = match(true) {
                                str_contains($etatValue, 'bon')    => 'badge-etat bon',
                                str_contains($etatValue, 'dégrad'),
                                str_contains($etatValue, 'degrad') => 'badge-etat degrade',
                                str_contains($etatValue, 'vandal') => 'badge-etat vandal',
                                str_contains($etatValue, 'masqu')  => 'badge-etat masque',
                                default                            => 'badge-etat aucun',
                            };

                            $svgPath = !empty($p->code_nomen)
                                ? asset('Backend/assets/SVG/' . $p->code_nomen . '.svg')
                                : null;

                            $panneauId = $p->panneau_id ?? $p->id ?? null;

                            $urlDetail = !empty($panneauId)
                                ? route('signalisation.show', ['id' => $panneauId])
                                : null;

                            $nbObs      = (int) ($p->nb_observations ?? 0);
                            $hasDateObs = !empty($p->date_obs);
                        @endphp

                        <tr data-href="{{ $urlDetail ?? '' }}">

                            {{-- TYPE --}}
                            <td data-label="Type">
                                <div class="type-cell">
                                    @if ($svgPath)
                                        <img src="{{ $svgPath }}"
                                             alt="{{ $p->type_nom ?? $p->code_nomen }}"
                                             class="type-svg"
                                             onerror="this.style.display='none'">
                                    @else
                                        <div class="type-svg" style="display:flex; align-items:center; justify-content:center;">
                                            <i class="fa-solid fa-sign-hanging" style="color:#CBD5E1;"></i>
                                        </div>
                                    @endif
                                    <div class="type-info">
                                        <span class="type-code">{{ $p->code_nomen ?? '—' }}</span>
                                        <span class="type-name">{{ $p->type_nom ?? 'Type inconnu' }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- LOCALISATION --}}
                            <td data-label="Localisation">
                                <div class="loc-cell">
                                    <span class="loc-route">
                                        <i class="fa-solid fa-road" style="color:#94A3B8; margin-right:4px;"></i>
                                        {{ $p->route_nom ?? '—' }}
                                    </span>
                                    <span class="loc-pk">
                                        <i class="fa-solid fa-location-dot"></i>
                                        PK {{ $p->point_kilo ?? '—' }}
                                    </span>
                                </div>
                            </td>

                            {{-- DIMENSIONS / SUPPORT --}}
                            <td data-label="Dimensions / Support">
                                <div class="tech-cell">
                                    <div>{{ $p->dimensions ?? '—' }}</div>
                                    <div style="font-size:0.72rem; color:#94A3B8; margin-top:2px;">
                                        {{ $p->type_suppo ?? '—' }}
                                    </div>
                                </div>
                            </td>

                            {{-- DERNIÈRE OBSERVATION --}}
                            <td data-label="Dernière observation">
                                <div class="obs-cell">
                                    @if ($hasDateObs)
                                        <span class="obs-date">
                                            <i class="fa-regular fa-calendar"></i>
                                            {{ \Carbon\Carbon::parse($p->date_obs)->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="obs-date empty">
                                            <i class="fa-regular fa-calendar-xmark"></i>
                                            Jamais observé
                                        </span>
                                    @endif
                                    <span class="{{ $classeBadge }}">
                                        {{ $p->etat_actuel ?? 'Non observé' }}
                                    </span>
                                </div>
                            </td>

                            {{-- INSPECTIONS --}}
                            <td data-label="Inspections" style="text-align:center;">
                                <span class="obs-count {{ $nbObs === 0 ? 'zero' : '' }}">
                                    {{ $nbObs }}
                                </span>
                            </td>

                            {{-- BOUTON DÉTAILS --}}
                            <td data-label="Action" style="text-align:center;">
                                @if ($urlDetail)
                                    <a href="{{ $urlDetail }}"
                                       class="btn-detail"
                                       onclick="event.stopPropagation();">
                                        <i class="fa-solid fa-eye"></i> Voir détails
                                    </a>
                                @else
                                    <span style="color:#CBD5E1; font-size:0.75rem; font-style:italic;">
                                        Indisponible
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- PAGINATION --}}
            <div class="sig-pagination">
                <div class="info">
                    Affichage de {{ $panneaux->firstItem() ?? 0 }} à {{ $panneaux->lastItem() ?? 0 }}
                    sur {{ $panneaux->total() ?? 0 }}
                </div>
                <div>
                    {{ $panneaux->onEachSide(1)->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif

    </div>

</div>

{{-- Script : ligne cliquable via data-href --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('tr[data-href]').forEach(function (row) {
        const url = row.getAttribute('data-href');
        if (!url) return;

        row.addEventListener('click', function (e) {
            if (e.target.closest('a, button')) return;
            window.location.href = url;
        });
    });
});
</script>

{{-- =========================================================
     MODALE DE CRÉATION — NOUVEAU PANNEAU
========================================================= --}}
<div class="modal fade" id="modalNewPanneau" tabindex="-1" aria-labelledby="modalNewPanneauLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1000px;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.35);">

            <div class="modal-header" style="background: linear-gradient(135deg, #059669, #10B981); color: #fff; border-radius: 16px 16px 0 0; padding: 20px 26px;">
                <div>
                    <h5 class="modal-title" id="modalNewPanneauLabel" style="color: #fff !important; font-weight: 700;">
                        <i class="fa-solid fa-plus-circle"></i> Nouveau panneau
                    </h5>
                    <small style="color: rgba(255,255,255,0.85); font-size: 0.8rem;">
                        Créer un nouveau point de signalisation verticale
                    </small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <form id="formNewPanneau"
                  method="POST"
                  action="{{ route('signalisation.store') }}"
                  style="display: flex; flex-direction: column; flex: 1; min-height: 0;">
                @csrf

                <div class="modal-body" style="padding: 0; max-height: calc(100vh - 220px); overflow-y: auto;">

                    <div id="modalNewError" class="alert alert-danger d-none" style="margin: 16px 26px 0; border-radius: 10px;"></div>
                    <div id="modalNewSuccess" class="alert alert-success d-none" style="margin: 16px 26px 0; border-radius: 10px;"></div>

                    {{-- ONGLETS --}}
                    <ul class="nav nav-tabs" id="newPanneauTabs" role="tablist" style="padding: 0 26px; background: #F8FAFC; border-bottom: 2px solid #E2E8F0; gap: 4px;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="new-tab-ident-tab" data-bs-toggle="tab" data-bs-target="#new-tab-ident" type="button" role="tab">
                                <i class="fa-solid fa-tag"></i> Identification
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="new-tab-geo-tab" data-bs-toggle="tab" data-bs-target="#new-tab-geo" type="button" role="tab">
                                <i class="fa-solid fa-map-location-dot"></i> Localisation
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="new-tab-mat-tab" data-bs-toggle="tab" data-bs-target="#new-tab-mat" type="button" role="tab">
                                <i class="fa-solid fa-industry"></i> Matériaux &amp; Film
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="new-tab-struct-tab" data-bs-toggle="tab" data-bs-target="#new-tab-struct" type="button" role="tab">
                                <i class="fa-solid fa-screwdriver-wrench"></i> Structure
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" style="padding: 24px 26px;">

                        {{-- ============ ONGLET 1 : IDENTIFICATION ============ --}}
                        <div class="tab-pane fade show active" id="new-tab-ident" role="tabpanel">
                            <h6 style="font-size: 0.78rem; font-weight: 700; color: #1E40AF !important; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px; padding: 10px 14px; background: #EFF6FF; border-left: 3px solid #2563EB; border-radius: 6px;">
                                <i class="fa-solid fa-tag" style="color: #2563EB;"></i> Identification
                            </h6>
                            <div class="row g-3" style="margin-bottom: 24px;">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Code nomenclature *</label>
                                    <select name="code_nomen" class="form-select" required>
                                        <option value="">— Choisir —</option>
                                        @foreach ($typesDisponibles as $tp)
                                            <option value="{{ $tp->code_type }}">
                                                {{ $tp->code_type }} — {{ $tp->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">HC caractère (mm)</label>
                                    <select name="hc_caractere" class="form-select">
                                        <option value="">— Non renseigné —</option>
                                        @foreach ([100, 125, 160, 200] as $hc)
                                            <option value="{{ $hc }}">{{ $hc }} mm</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Nom / Libellé</label>
                                    <input type="text" name="name" class="form-control" placeholder="Désignation libre...">
                                </div>
                            </div>
                        </div>

                        {{-- ============ ONGLET 2 : LOCALISATION ============ --}}
                        <div class="tab-pane fade" id="new-tab-geo" role="tabpanel">
                            <h6 style="font-size: 0.78rem; font-weight: 700; color: #1E40AF !important; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px; padding: 10px 14px; background: #EFF6FF; border-left: 3px solid #2563EB; border-radius: 6px;">
                                <i class="fa-solid fa-map-location-dot" style="color: #2563EB;"></i> Localisation
                            </h6>
                            <div class="row g-3" style="margin-bottom: 24px;">
                                <div class="col-12">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Route</label>
                                    <select name="route_nom" class="form-select">
                                        <option value="">— Non renseignée —</option>
                                        @foreach ($routesDisponibles as $r)
                                            <option value="{{ $r }}">{{ $r }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Point kilométrique</label>
                                    <input type="text" name="point_kilo" class="form-control" placeholder="Ex: 12+500">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Catégorie de route</label>
                                    <select name="route" class="form-select">
                                        <option value="">— Non renseignée —</option>
                                        @foreach (['Nationale', 'Régionale', 'Locale', 'Autoroute', 'Urbaine', 'Rurale'] as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- COORDONNÉES GPS --}}
                            <h6 style="font-size: 0.78rem; font-weight: 700; color: #B45309 !important; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px; padding: 10px 14px; background: #FEF3C7; border-left: 3px solid #F59E0B; border-radius: 6px;">
                                <i class="fa-solid fa-crosshairs" style="color: #F59E0B;"></i> Coordonnées GPS *
                            </h6>

                            <div class="row g-3">

                                {{-- Message d'aide --}}
                                <div class="col-12">
                                    <div style="padding: 12px 14px; background: #EFF6FF; border-left: 3px solid #2563EB; border-radius: 6px; font-size: 0.82rem; color: #1E3A8A;">
                                        <i class="fa-solid fa-info-circle"></i>
                                        <strong>3 façons de définir la position :</strong><br>
                                        1. Cliquez sur <strong>« Utiliser ma position actuelle »</strong> (nécessite autorisation + HTTPS)<br>
                                        2. <strong>Cliquez directement sur la carte</strong> pour placer le marqueur<br>
                                        3. <strong>Glissez le marqueur orange</strong> pour ajuster
                                    </div>
                                </div>

                                {{-- Bouton géolocalisation --}}
                                <div class="col-12">
                                    <button type="button"
                                            id="btnGeoloc"
                                            style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: linear-gradient(135deg, #F59E0B, #EA580C); color: #fff !important; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); width: 100%; justify-content: center;">
                                        <i class="fa-solid fa-location-crosshairs"></i>
                                        <span id="btnGeolocText">Utiliser ma position actuelle</span>
                                    </button>
                                    <div id="geolocStatus" style="margin-top: 10px; font-size: 0.82rem; color: #64748B;"></div>
                                </div>

                                {{-- Champs Lat/Lng --}}
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Latitude *</label>
                                    <input type="number"
                                           step="0.000001"
                                           name="lat"
                                           id="inputLat"
                                           class="form-control"
                                           placeholder="36.8065"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Longitude *</label>
                                    <input type="number"
                                           step="0.000001"
                                           name="lng"
                                           id="inputLng"
                                           class="form-control"
                                           placeholder="10.1815"
                                           required>
                                </div>

                                {{-- Mini-carte --}}
                                <div class="col-12">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">
                                        Position sur la carte (cliquez ou glissez le marqueur)
                                    </label>
                                    <div id="miniMapPreview"
                                         style="height: 380px;
                                                width: 100%;
                                                border-radius: 12px;
                                                border: 2px solid #E2E8F0;
                                                background: #F8FAFC;
                                                overflow: hidden;
                                                position: relative;
                                                z-index: 1;"></div>
                                </div>
                            </div>
                        </div>

                        {{-- ============ ONGLET 3 : MATÉRIAUX ============ --}}
                        <div class="tab-pane fade" id="new-tab-mat" role="tabpanel">
                            <h6 style="font-size: 0.78rem; font-weight: 700; color: #1E40AF !important; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px; padding: 10px 14px; background: #EFF6FF; border-left: 3px solid #2563EB; border-radius: 6px;">
                                <i class="fa-solid fa-industry" style="color: #2563EB;"></i> Matériaux &amp; fabrication
                            </h6>
                            <div class="row g-3" style="margin-bottom: 24px;">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Nuance acier</label>
                                    <select name="acier_nuance" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="Acier E 24-1">Acier E 24-1</option>
                                        <option value="Acier A 33">Acier A 33</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Type subjectile</label>
                                    <select name="type_subje" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="Tôle plane">Tôle plane</option>
                                        <option value="Profilés extrudés (lattes)">Profilés extrudés (lattes)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Nature matériau</label>
                                    <select name="nature_mat" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="Acier E 24-1">Acier E 24-1</option>
                                        <option value="Alliage Aluminium AG 3 M">Alliage Aluminium AG 3 M</option>
                                        <option value="Alliage Aluminium AZ 5 G">Alliage Aluminium AZ 5 G</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Dépôt galva (g/dm²)</label>
                                    <input type="number" step="0.1" min="5.7" max="10" name="galva_depot" class="form-control" placeholder="5.7">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Largeur lattes (cm)</label>
                                    <input type="number" min="15" max="30" name="largeur_latte" class="form-control" placeholder="15 à 30">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Anodisé</label>
                                    <select name="anodise" class="form-select">
                                        <option value="">— Non renseigné —</option>
                                        <option value="1">Oui</option>
                                        <option value="0">Non</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">N° agrément</label>
                                    <input type="text" name="num_agrement" class="form-control" placeholder="N° homologation">
                                </div>
                            </div>

                            <h6 style="font-size: 0.78rem; font-weight: 700; color: #1E40AF !important; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px; padding: 10px 14px; background: #EFF6FF; border-left: 3px solid #2563EB; border-radius: 6px;">
                                <i class="fa-solid fa-lightbulb" style="color: #2563EB;"></i> Film rétro-réfléchissant
                            </h6>
                            <div class="row g-3" style="margin-bottom: 24px;">
                                <div class="col-12">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Type de film</label>
                                    <select name="type_film_retro" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="Classe 1 (EG)">Classe 1 (EG) — Standard, garantie 7 ans</option>
                                        <option value="Classe 2 (HI)">Classe 2 (HI) — Haute intensité, RN, garantie 10 ans</option>
                                        <option value="Classe 3 (DG)">Classe 3 (DG) — Très haute perf., autoroutes, garantie 12 ans</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Garantie film (ans)</label>
                                    <input type="number" min="7" max="15" name="garantie_film_ans" class="form-control" placeholder="7 à 12">
                                </div>
                            </div>

                            <h6 style="font-size: 0.78rem; font-weight: 700; color: #1E40AF !important; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px; padding: 10px 14px; background: #EFF6FF; border-left: 3px solid #2563EB; border-radius: 6px;">
                                <i class="fa-solid fa-ruler-combined" style="color: #2563EB;"></i> Dimensions &amp; Couleur
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Dimensions</label>
                                    <input type="text" name="dimensions" class="form-control" placeholder="Ex: 700x700">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Dimensions CCTP</label>
                                    <input type="text" name="dim_cctp" class="form-control" placeholder="Ex: 1040x450">
                                </div>
                                <div class="col-12">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Couleur de fond</label>
                                    <select name="couleur_fo" class="form-select">
                                        <option value="">— Choisir —</option>
                                        @foreach (['Blanc', 'Bleu', 'Rouge', 'Jaune', 'Vert', 'Noir'] as $c)
                                            <option value="{{ $c }}">{{ $c }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- ============ ONGLET 4 : STRUCTURE ============ --}}
                        <div class="tab-pane fade" id="new-tab-struct" role="tabpanel">
                            <h6 style="font-size: 0.78rem; font-weight: 700; color: #1E40AF !important; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px; padding: 10px 14px; background: #EFF6FF; border-left: 3px solid #2563EB; border-radius: 6px;">
                                <i class="fa-solid fa-screwdriver-wrench" style="color: #2563EB;"></i> Structure &amp; support
                            </h6>
                            <div class="row g-3" style="margin-bottom: 24px;">
                                <div class="col-12">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Protection anti-corrosion</label>
                                    <select name="protection" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="Galvanisation à chaud 80 µm">Galvanisation à chaud 80 µm</option>
                                        <option value="Galvanisation + peinture">Galvanisation + peinture</option>
                                        <option value="Peinture époxy">Peinture époxy</option>
                                        <option value="Aucune">Aucune</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Type de support</label>
                                    <select name="type_suppo" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="Mât circulaire acier">Mât circulaire acier</option>
                                        <option value="Mât circulaire aluminium">Mât circulaire aluminium</option>
                                        <option value="Profilé E24">Profilé E24</option>
                                        <option value="Portique">Portique</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Matière support</label>
                                    <select name="matiere_support" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="Acier galvanisé">Acier galvanisé</option>
                                        <option value="Acier E24">Acier E24</option>
                                        <option value="Aluminium anodisé">Aluminium anodisé</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Nombre raidisseurs</label>
                                    <select name="nb_raidisseurs" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Résistance vent (daN/m²)</label>
                                    <select name="resistance" class="form-select">
                                        <option value="">— Choisir —</option>
                                        <option value="130">130 daN/m²</option>
                                        <option value="160">160 daN/m²</option>
                                        <option value="200">200 daN/m²</option>
                                    </select>
                                </div>
                            </div>

                            <h6 style="font-size: 0.78rem; font-weight: 700; color: #1E40AF !important; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px; padding: 10px 14px; background: #EFF6FF; border-left: 3px solid #2563EB; border-radius: 6px;">
                                <i class="fa-solid fa-ruler-vertical" style="color: #2563EB;"></i> Implantation
                            </h6>
                            <div class="row g-3" style="margin-bottom: 24px;">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Hauteur au sol (m)</label>
                                    <input type="number" step="0.10" min="2.30" max="10" name="hauteur_so" class="form-control" placeholder="2.30">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Hauteur libre (m)</label>
                                    <input type="number" step="0.10" min="2.30" max="10" name="hauteur_libre_m" class="form-control" placeholder="5.50">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Implantation (m)</label>
                                    <input type="number" step="0.10" min="1" max="3" name="implantation_m" class="form-control" placeholder="2.30 trottoir">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Fiche ancrage (m)</label>
                                    <input type="number" step="0.01" min="0.4" max="2" name="fiche_ancrage_m" class="form-control" placeholder="H/5">
                                </div>
                            </div>

                            <h6 style="font-size: 0.78rem; font-weight: 700; color: #1E40AF !important; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 16px; padding: 10px 14px; background: #EFF6FF; border-left: 3px solid #2563EB; border-radius: 6px;">
                                <i class="fa-solid fa-calendar" style="color: #2563EB;"></i> Durée de vie
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Date de pose</label>
                                    <input type="date" name="date_pose" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">Durée de vie (ans)</label>
                                    <input type="number" min="7" max="20" name="duree_vie_ans" class="form-control" value="10">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer" style="background: #F8FAFC; border-top: 1px solid #E2E8F0; padding: 16px 26px; border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                        <i class="fa-solid fa-xmark"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitNew" style="border-radius: 8px; font-weight: 600; background: linear-gradient(135deg, #059669, #10B981); border: none; padding: 8px 20px;">
                        <i class="fa-solid fa-check"></i> Créer le panneau
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- =========================================================
     LEAFLET + SCRIPT COMPLET (GÉOLOCALISATION + CARTE)
========================================================= --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       SUBMIT DU FORMULAIRE — CRÉATION
    ========================================================= */
    const form       = document.getElementById('formNewPanneau');
    const btnSubmit  = document.getElementById('btnSubmitNew');
    const errorBox   = document.getElementById('modalNewError');
    const successBox = document.getElementById('modalNewSuccess');
    const modalEl    = document.getElementById('modalNewPanneau');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            errorBox.classList.add('d-none');
            successBox.classList.add('d-none');
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Création...';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(async (response) => {
                const data = await response.json();

                if (!response.ok) {
                    let messages = [];
                    if (data.errors) {
                        Object.values(data.errors).forEach(arr => arr.forEach(m => messages.push(m)));
                    } else if (data.message) {
                        messages.push(data.message);
                    } else {
                        messages.push('Une erreur est survenue.');
                    }
                    throw new Error(messages.join('<br>'));
                }
                return data;
            })
            .then((data) => {
                successBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (data.message || 'Panneau créé !');
                successBox.classList.remove('d-none');

                setTimeout(() => {
                    if (data.id) {
                        window.location.href = '/signalisation/' + data.id;
                    } else {
                        window.location.reload();
                    }
                }, 800);
            })
            .catch((err) => {
                errorBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + err.message;
                errorBox.classList.remove('d-none');
            })
            .finally(() => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fa-solid fa-check"></i> Créer le panneau';
            });
        });
    }

    /* =========================================================
       GÉOLOCALISATION + MINI-CARTE
    ========================================================= */
    const btnGeoloc        = document.getElementById('btnGeoloc');
    const btnGeolocText    = document.getElementById('btnGeolocText');
    const geolocStatus     = document.getElementById('geolocStatus');
    const inputLat         = document.getElementById('inputLat');
    const inputLng         = document.getElementById('inputLng');
    const miniMapContainer = document.getElementById('miniMapPreview');

    let miniMap    = null;
    let miniMarker = null;

    const DEFAULT_LAT = 36.8065;
    const DEFAULT_LNG = 10.1815;

    /* --- Initialiser la mini-carte --- */
    function initMiniMap() {
        if (miniMap) {
            setTimeout(() => miniMap.invalidateSize(), 100);
            return;
        }

        let lat = parseFloat(inputLat?.value) || DEFAULT_LAT;
        let lng = parseFloat(inputLng?.value) || DEFAULT_LNG;

        const isMobile = L.Browser.mobile;

        miniMap = L.map('miniMapPreview', {
            center: [lat, lng],
            zoom: 13,
            zoomControl: true,
            scrollWheelZoom: !isMobile,
            tap: true,
            tapTolerance: 15
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(miniMap);

        miniMarker = L.marker([lat, lng], {
            draggable: true,
            icon: L.divIcon({
                html: `<div style="width:36px;height:36px;background:linear-gradient(135deg,#F59E0B,#EA580C);border:3px solid #fff;border-radius:50%;box-shadow:0 4px 12px rgba(245,158,11,0.5);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;"><i class="fa-solid fa-sign-hanging"></i></div>`,
                className: '',
                iconSize: [36, 36],
                iconAnchor: [18, 18]
            })
        }).addTo(miniMap);

        // Clic sur la carte
        miniMap.on('click', function (e) {
            const newLat = e.latlng.lat;
            const newLng = e.latlng.lng;
            miniMarker.setLatLng([newLat, newLng]);
            updateInputs(newLat, newLng);
        });

        // Drag du marqueur
        miniMarker.on('dragend', function (e) {
            const pos = e.target.getLatLng();
            updateInputs(pos.lat, pos.lng);
        });

        setTimeout(() => miniMap.invalidateSize(), 200);

        // Recalcul de taille sur rotation
        window.addEventListener('orientationchange', function () {
            setTimeout(function () { miniMap && miniMap.invalidateSize(true); }, 300);
        });
        window.addEventListener('resize', function () {
            miniMap && miniMap.invalidateSize(true);
        });
    }

    /* --- Mettre à jour les champs --- */
    function updateInputs(lat, lng) {
        if (inputLat) inputLat.value = parseFloat(lat).toFixed(6);
        if (inputLng) inputLng.value = parseFloat(lng).toFixed(6);
    }

    /* --- Bouton géolocalisation --- */
    if (btnGeoloc) {
        btnGeoloc.addEventListener('click', function () {

            // HTTPS check
            const isSecure = window.location.protocol === 'https:' ||
                             window.location.hostname === 'localhost' ||
                             window.location.hostname === '127.0.0.1';

            if (!isSecure) {
                geolocStatus.innerHTML = '<span style="color: #DC2626;"><i class="fa-solid fa-triangle-exclamation"></i> La géolocalisation nécessite <strong>HTTPS</strong> (ou localhost). Utilisez les autres méthodes.</span>';
                return;
            }

            if (!navigator.geolocation) {
                geolocStatus.innerHTML = '<span style="color: #DC2626;"><i class="fa-solid fa-triangle-exclamation"></i> La géolocalisation n\'est pas supportée.</span>';
                return;
            }

            btnGeoloc.disabled = true;
            btnGeolocText.textContent = 'Localisation en cours...';
            geolocStatus.innerHTML = '<span style="color: #F59E0B;"><i class="fa-solid fa-spinner fa-spin"></i> Recherche de votre position...</span>';

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const accuracy = position.coords.accuracy;

                    initMiniMap();
                    updateInputs(lat, lng);

                    if (miniMap && miniMarker) {
                        miniMarker.setLatLng([lat, lng]);
                        miniMap.setView([lat, lng], 17);
                    }

                    geolocStatus.innerHTML = `<span style="color: #059669;"><i class="fa-solid fa-check-circle"></i> Position détectée (précision : ±${Math.round(accuracy)} m)</span>`;
                    btnGeoloc.disabled = false;
                    btnGeolocText.textContent = 'Utiliser ma position actuelle';
                },
                function (error) {
                    let msg = '';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            msg = `<strong>Vous avez refusé l'accès à votre position.</strong><br>
                                   👉 <u>Comment autoriser :</u><br>
                                   • <strong>Chrome/Edge :</strong> Cliquez sur l'icône 🔒 à gauche de l'URL → Autorisez « Localisation »<br>
                                   • <strong>Firefox :</strong> Cliquez sur l'icône 🛡️ → Autorisations → Localisation<br>
                                   • <strong>Safari :</strong> Safari → Réglages pour ce site → Localisation → Autoriser<br>
                                   Puis rechargez la page et réessayez.<br>
                                   <em>Ou cliquez directement sur la carte pour placer le point.</em>`;
                            break;
                        case error.POSITION_UNAVAILABLE:
                            msg = 'Position indisponible. Activez le GPS/localisation sur votre appareil.';
                            break;
                        case error.TIMEOUT:
                            msg = 'Délai dépassé. Utilisez la carte pour placer le point manuellement.';
                            break;
                        default:
                            msg = 'Erreur de géolocalisation. Utilisez la carte.';
                    }

                    geolocStatus.innerHTML = `<span style="color: #DC2626;"><i class="fa-solid fa-triangle-exclamation"></i> ${msg}</span>`;
                    btnGeoloc.disabled = false;
                    btnGeolocText.textContent = 'Utiliser ma position actuelle';
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        });
    }

    /* --- Initialiser la carte à l'ouverture de la modale --- */
    if (modalEl) {
        modalEl.addEventListener('shown.bs.modal', function () {
            setTimeout(function () {
                initMiniMap();
                if (miniMap) miniMap.invalidateSize();
                if (geolocStatus) geolocStatus.innerHTML = '';
            }, 400);

            const firstTab = document.querySelector('#newPanneauTabs .nav-link');
            if (firstTab) {
                new bootstrap.Tab(firstTab).show();
            }
        });

        modalEl.addEventListener('hidden.bs.modal', function () {
            if (miniMap) {
                miniMap.remove();
                miniMap = null;
                miniMarker = null;
            }
        });
    }

    /* --- Synchronisation manuelle des champs Lat/Lng --- */
    if (inputLat && inputLng) {
        [inputLat, inputLng].forEach(function (input) {
            input.addEventListener('change', function () {
                const lat = parseFloat(inputLat.value);
                const lng = parseFloat(inputLng.value);

                if (!isNaN(lat) && !isNaN(lng) &&
                    lat >= -90 && lat <= 90 &&
                    lng >= -180 && lng <= 180) {

                    initMiniMap();
                    if (miniMap && miniMarker) {
                        miniMarker.setLatLng([lat, lng]);
                        miniMap.setView([lat, lng], miniMap.getZoom());
                    }
                }
            });
        });
    }

});
</script>

@endsection
