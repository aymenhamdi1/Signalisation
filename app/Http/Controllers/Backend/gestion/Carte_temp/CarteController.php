<?php

namespace App\Http\Controllers\Backend\gestion\Carte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarteController extends Controller
{
    protected string $table    = 'trafic';
    protected string $tableTyp = 'types_panneaux';
    protected string $tableObs = 'observation';
    protected string $tablePho = 'photo';
    protected string $pk       = 'id_0';

    /* =========================================================
       INDEX — Carte + zones d'étude (contours)
    ========================================================= */
    public function index(Request $request)
    {
        $pk = $this->pk;

        /* ---------- PANNEAUX ---------- */
        $query = "
            WITH LatestObs AS (
                SELECT o1.id_traffic, MAX(o1.id_obs) AS last_id_obs
                FROM public.{$this->tableObs} o1
                GROUP BY o1.id_traffic
            ),
            LastObservation AS (
                SELECT o.id_obs, o.id_traffic, o.date_obs, o.etat_actuel
                FROM public.{$this->tableObs} o
                INNER JOIN LatestObs lo ON o.id_traffic = lo.id_traffic
                                      AND o.id_obs = lo.last_id_obs
            )
            SELECT
                t.{$pk} AS panneau_id,
                t.code_nomen,
                t.name,
                t.fclass,
                t.route_nom,
                t.point_kilo,
                t.route,
                t.nature_mat,
                t.type_subje,
                t.dimensions,
                t.couleur_fo,
                t.protection,
                t.type_suppo,
                t.hauteur_so,
                t.resistance,
                t.acier_nuance,
                t.galva_depot,
                t.largeur_latte,
                t.anodise,
                t.num_agrement,
                t.type_film_retro,
                t.garantie_film_ans,
                t.code_panneau_cctp,
                t.hc_caractere,
                t.dim_cctp,
                t.nb_raidisseurs,
                t.matiere_support,
                t.hauteur_libre_m,
                t.implantation_m,
                t.fiche_ancrage_m,
                t.date_pose,
                t.duree_vie_ans,
                t.date_remplacement_prevue,
                tp.nom           AS type_nom,
                tp.categorie     AS type_categorie,
                tp.description   AS type_description,
                tp.couleur_fond  AS type_couleur_fond,
                tp.couleur_bord  AS type_couleur_bord,
                tp.actif         AS type_actif,
                o.etat_actuel,
                o.date_obs,
                ST_Y(ST_Transform(t.geom, 4326)) AS lat,
                ST_X(ST_Transform(t.geom, 4326)) AS lng,
                (SELECT COUNT(*) FROM public.{$this->tablePho} p
                 JOIN public.{$this->tableObs} o3 ON o3.id_obs = p.id_obs
                 WHERE o3.id_traffic = t.{$pk}) AS nb_photos
            FROM public.{$this->table} t
            LEFT JOIN public.{$this->tableTyp} tp ON tp.code_type = t.code_nomen
            LEFT JOIN LastObservation o ON o.id_traffic = t.{$pk}
            WHERE t.geom IS NOT NULL
            ORDER BY t.{$pk} DESC
        ";

        $panneaux = DB::select($query);

        /* ---------- STATS ---------- */
        $stats = ['total' => count($panneaux), 'bon' => 0, 'degrade' => 0, 'vandal' => 0, 'masque' => 0];
        foreach ($panneaux as $p) {
            $e = strtolower($p->etat_actuel ?? '');
            if (str_contains($e, 'bon'))                                       $stats['bon']++;
            elseif (str_contains($e, 'dégrad') || str_contains($e, 'degrad'))  $stats['degrade']++;
            elseif (str_contains($e, 'vandal'))                                $stats['vandal']++;
            elseif (str_contains($e, 'masqu'))                                 $stats['masque']++;
        }

        /* ---------- LISTES POUR LES SELECTS ---------- */
        $listes = [
            'types_panneaux' => DB::table($this->tableTyp)
                ->select('code_type', 'nom', 'categorie', 'description')
                ->where('actif', true)
                ->orderBy('code_type')
                ->get(),

            'categories' => DB::table($this->tableTyp)
                ->select('categorie')
                ->whereNotNull('categorie')
                ->where('categorie', '!=', '')
                ->where('actif', true)
                ->distinct()
                ->orderBy('categorie')
                ->pluck('categorie'),

            'noms' => DB::table($this->tableTyp)
                ->select('nom')
                ->whereNotNull('nom')
                ->where('nom', '!=', '')
                ->where('actif', true)
                ->distinct()
                ->orderBy('nom')
                ->pluck('nom'),

            'routes' => DB::table($this->table)
                ->select('route_nom')
                ->whereNotNull('route_nom')
                ->where('route_nom', '!=', '')
                ->distinct()
                ->orderBy('route_nom')
                ->pluck('route_nom'),
        ];

        /* =========================================================
           ✅ ZONES D'ÉTUDE — GeoJSON (contours uniquement côté JS)
        ========================================================= */
        $zones = DB::select("
            SELECT
                id,
                id_gouv,
                nom_fr,
                nom_ar,
                ST_AsGeoJSON(ST_Transform(geom, 4326)) AS geojson
            FROM public.\"ZONE_ETUDE\"
            WHERE deleted_at IS NULL
              AND geom IS NOT NULL
            ORDER BY nom_fr ASC NULLS LAST, id ASC
        ");

        /* =========================================================
           ✅ BOUNDS GLOBAUX DES ZONES (pour le zoom par défaut)
        ========================================================= */
        $zonesBounds = null;
        $boundsRow = DB::selectOne("
            SELECT
                ST_YMin(ST_Transform(ST_Envelope(ST_Collect(geom)), 4326)) AS min_lat,
                ST_XMin(ST_Transform(ST_Envelope(ST_Collect(geom)), 4326)) AS min_lng,
                ST_YMax(ST_Transform(ST_Envelope(ST_Collect(geom)), 4326)) AS max_lat,
                ST_XMax(ST_Transform(ST_Envelope(ST_Collect(geom)), 4326)) AS max_lng
            FROM public.\"ZONE_ETUDE\"
            WHERE deleted_at IS NULL
              AND geom IS NOT NULL
        ");

        if ($boundsRow && $boundsRow->min_lat !== null) {
            $zonesBounds = [
                'min_lat' => (float) $boundsRow->min_lat,
                'min_lng' => (float) $boundsRow->min_lng,
                'max_lat' => (float) $boundsRow->max_lat,
                'max_lng' => (float) $boundsRow->max_lng,
            ];
        }

        return view('Backend.gestion.carte.carte', compact('panneaux', 'stats', 'listes', 'zones', 'zonesBounds'));
    }

    /* =========================================================
       STORE PANNEAU — Création depuis la carte
       ⚠️ Conversion 4326 (GPS) → 22332 (UTM 32N)
    ========================================================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_nomen'         => 'nullable|string|max:50',
            'fclass'             => 'nullable|string|max:100',
            'name'               => 'nullable|string|max:255',
            'code_panneau_cctp'  => 'nullable|string|max:20',
            'hc_caractere'       => 'nullable|integer',
            'dim_cctp'           => 'nullable|string|max:30',
            'num_agrement'       => 'nullable|string|max:50',
            'lat'                => 'required|numeric|between:-90,90',
            'lng'                => 'required|numeric|between:-180,180',
            'route_nom'          => 'nullable|string|max:100',
            'point_kilo'         => 'nullable|string|max:50',
            'route'              => 'nullable|string|max:50',
            'acier_nuance'       => 'nullable|string|max:50',
            'nature_mat'         => 'nullable|string|max:100',
            'type_subje'         => 'nullable|string|max:100',
            'galva_depot'        => 'nullable|numeric',
            'largeur_latte'      => 'nullable|integer',
            'anodise'            => 'nullable|boolean',
            'type_film_retro'    => 'nullable|string|max:50',
            'garantie_film_ans'  => 'nullable|integer',
            'dimensions'         => 'nullable|string|max:50',
            'couleur_fo'         => 'nullable|string|max:50',
            'protection'         => 'nullable|string|max:100',
            'type_suppo'         => 'nullable|string|max:100',
            'matiere_support'    => 'nullable|string|max:50',
            'nb_raidisseurs'     => 'nullable|integer',
            'resistance'         => 'nullable|integer',
            'hauteur_so'         => 'nullable|numeric',
            'hauteur_libre_m'    => 'nullable|numeric',
            'implantation_m'     => 'nullable|numeric',
            'fiche_ancrage_m'    => 'nullable|numeric',
            'date_pose'          => 'nullable|date',
            'duree_vie_ans'      => 'nullable|integer',
        ]);

        $lat = $validated['lat'];
        $lng = $validated['lng'];
        unset($validated['lat'], $validated['lng']);

        $id = DB::table($this->table)->insertGetId(
            array_merge($validated, [
                'geom' => DB::raw(
                    "ST_Transform(ST_SetSRID(ST_MakePoint($lng, $lat), 4326), 22332)"
                ),
            ]),
            $this->pk
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Panneau créé avec succès.',
                'id'      => $id,
            ]);
        }

        return redirect()->route('carte.index')->with('success', 'Panneau créé.');
    }

    /* =========================================================
       UPDATE PANNEAU
    ========================================================= */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code_nomen'         => 'nullable|string|max:50',
            'fclass'             => 'nullable|string|max:100',
            'name'               => 'nullable|string|max:255',
            'code_panneau_cctp'  => 'nullable|string|max:20',
            'hc_caractere'       => 'nullable|integer',
            'dim_cctp'           => 'nullable|string|max:30',
            'num_agrement'       => 'nullable|string|max:50',
            'lat'                => 'nullable|numeric|between:-90,90',
            'lng'                => 'nullable|numeric|between:-180,180',
            'route_nom'          => 'nullable|string|max:100',
            'point_kilo'         => 'nullable|string|max:50',
            'route'              => 'nullable|string|max:50',
            'acier_nuance'       => 'nullable|string|max:50',
            'nature_mat'         => 'nullable|string|max:100',
            'type_subje'         => 'nullable|string|max:100',
            'galva_depot'        => 'nullable|numeric',
            'largeur_latte'      => 'nullable|integer',
            'anodise'            => 'nullable|boolean',
            'type_film_retro'    => 'nullable|string|max:50',
            'garantie_film_ans'  => 'nullable|integer',
            'dimensions'         => 'nullable|string|max:50',
            'couleur_fo'         => 'nullable|string|max:50',
            'protection'         => 'nullable|string|max:100',
            'type_suppo'         => 'nullable|string|max:100',
            'matiere_support'    => 'nullable|string|max:50',
            'nb_raidisseurs'     => 'nullable|integer',
            'resistance'         => 'nullable|integer',
            'hauteur_so'         => 'nullable|numeric',
            'hauteur_libre_m'    => 'nullable|numeric',
            'implantation_m'     => 'nullable|numeric',
            'fiche_ancrage_m'    => 'nullable|numeric',
            'date_pose'          => 'nullable|date',
            'duree_vie_ans'      => 'nullable|integer',
        ]);

        if (isset($validated['lat']) && isset($validated['lng'])
            && $validated['lat'] !== null && $validated['lng'] !== null) {

            $lat = $validated['lat'];
            $lng = $validated['lng'];
            unset($validated['lat'], $validated['lng']);

            DB::table($this->table)->where($this->pk, $id)->update(
                array_merge($validated, [
                    'geom' => DB::raw(
                        "ST_Transform(ST_SetSRID(ST_MakePoint($lng, $lat), 4326), 22332)"
                    ),
                ])
            );
        } else {
            unset($validated['lat'], $validated['lng']);
            DB::table($this->table)->where($this->pk, $id)->update($validated);
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Panneau mis à jour avec succès.',
            ]);
        }

        return redirect()->route('carte.index')->with('success', 'Panneau mis à jour.');
    }
}