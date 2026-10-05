<?php

namespace App\Http\Controllers\Backend\gestion\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected string $table    = 'trafic';
    protected string $tableObs = 'observation';
    protected string $pk;

    /**
     * Détecte automatiquement la clé primaire de la table trafic
     */
    public function __construct()
    {
        $this->pk = $this->detectPrimaryKey();
    }

    /**
     * Trouve la clé primaire de la table trafic
     */
    protected function detectPrimaryKey(): string
    {
        try {
            $result = DB::select("
                SELECT a.attname AS column_name
                FROM pg_index i
                JOIN pg_attribute a ON a.attrelid = i.indrelid
                                    AND a.attnum = ANY(i.indkey)
                WHERE i.indrelid = 'public.{$this->table}'::regclass
                  AND i.indisprimary
                LIMIT 1
            ");

            if (!empty($result)) {
                return $result[0]->column_name;
            }
        } catch (\Throwable $e) {
            \Log::warning('Impossible de détecter la PK: ' . $e->getMessage());
        }

        // Fallback : essayer les noms connus
        foreach (['id_0', 'id', 'gid', 'id_trafic', 'panneau_id'] as $candidate) {
            try {
                $exists = DB::selectOne("
                    SELECT 1 FROM information_schema.columns
                    WHERE table_name = ? AND column_name = ?
                    LIMIT 1
                ", [$this->table, $candidate]);

                if ($exists) {
                    return $candidate;
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        // Dernier recours
        return 'id_0';
    }

    public function AllDashboard()
    {
        return $this->index();
    }

    public function index()
    {
        $id        = Auth::id();
        $adminData = \App\Models\User::find($id);

        // =========================================================
        // 1. KPIs PANNEAUX
        // =========================================================
        $totalPanneaux   = DB::table($this->table)->count();
        $totalRoutes     = DB::table($this->table)->whereNotNull('route_nom')->distinct('route_nom')->count('route_nom');
        $totalNatures    = DB::table($this->table)->whereNotNull('nature_mat')->distinct('nature_mat')->count('nature_mat');
        $totalTypesSuppo = DB::table($this->table)->whereNotNull('type_suppo')->distinct('type_suppo')->count('type_suppo');
        $totalGeoloc     = DB::table($this->table)->whereNotNull('geom')->count();

        $hauteurMoyenne = round(
            DB::table($this->table)->whereNotNull('hauteur_so')->avg('hauteur_so') ?? 0,
            2
        );

        // =========================================================
        // 2. KPIs OBSERVATIONS
        // =========================================================
        $totalObservations = DB::table($this->tableObs)->count();

        $panneauxObserves = DB::table($this->tableObs)
            ->distinct('id_traffic')
            ->count('id_traffic');

        $tauxCouverture = $totalPanneaux > 0
            ? round(($panneauxObserves / $totalPanneaux) * 100, 1)
            : 0;

        // =========================================================
        // ✅ 2.bis NOUVEAU — Répartition par état (dernière observation)
        // =========================================================
        $etatsParPanneau = DB::table($this->tableObs . ' as o')
            ->select('o.id_traffic', 'o.etat_actuel')
            ->whereIn('o.id_obs', function ($sub) {
                $sub->from($this->tableObs . ' as o2')
                    ->selectRaw('MAX(o2.id_obs)')
                    ->whereColumn('o2.id_traffic', 'o.id_traffic')
                    ->groupBy('o2.id_traffic');
            })
            ->get();

        $totalBon     = 0;
        $totalDegrade = 0;
        $totalVandal  = 0;
        $totalMasque  = 0;

        foreach ($etatsParPanneau as $row) {
            $e = strtolower($row->etat_actuel ?? '');
            if (str_contains($e, 'bon'))                                       $totalBon++;
            elseif (str_contains($e, 'dégrad') || str_contains($e, 'degrad'))  $totalDegrade++;
            elseif (str_contains($e, 'vandal'))                                $totalVandal++;
            elseif (str_contains($e, 'masqu'))                                 $totalMasque++;
        }

        // =========================================================
        // 3. RÉPARTITIONS
        // =========================================================
        $parType = DB::table($this->table)
            ->select('Type', DB::raw('COUNT(*) as total'))
            ->whereNotNull('Type')
            ->groupBy('Type')
            ->orderByDesc('total')
            ->get();

        $parNature = DB::table($this->table)
            ->select('nature_mat', DB::raw('COUNT(*) as total'))
            ->whereNotNull('nature_mat')
            ->groupBy('nature_mat')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $parSupport = DB::table($this->table)
            ->select('type_suppo', DB::raw('COUNT(*) as total'))
            ->whereNotNull('type_suppo')
            ->groupBy('type_suppo')
            ->orderByDesc('total')
            ->get();

        $parCouleur = DB::table($this->table)
            ->select('couleur_fo', DB::raw('COUNT(*) as total'))
            ->whereNotNull('couleur_fo')
            ->groupBy('couleur_fo')
            ->orderByDesc('total')
            ->get();

        $parRoute = DB::table($this->table)
            ->select('route_nom', DB::raw('COUNT(*) as total'))
            ->whereNotNull('route_nom')
            ->groupBy('route_nom')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $parDimensions = DB::table($this->table)
            ->select('dimensions', DB::raw('COUNT(*) as total'))
            ->whereNotNull('dimensions')
            ->groupBy('dimensions')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // =========================================================
        // 4. OBSERVATIONS RÉPARTITIONS
        // =========================================================
        $obsParEtat = DB::table($this->tableObs)
            ->select('etat_actuel', DB::raw('COUNT(*) as total'))
            ->whereNotNull('etat_actuel')
            ->groupBy('etat_actuel')
            ->orderByDesc('total')
            ->get();

        $obsParClasse = DB::table($this->tableObs)
            ->select('classe_retro', DB::raw('COUNT(*) as total'))
            ->whereNotNull('classe_retro')
            ->groupBy('classe_retro')
            ->orderByDesc('total')
            ->get();

        // =========================================================
        // 5. CARTE
        // =========================================================
        $pointsCarte = DB::table($this->table)
            ->select(
                "{$this->pk} as id",
                'Type', 'nature_mat', 'route_nom', 'point_kilo',
                'dimensions', 'couleur_fo', 'type_suppo', 'hauteur_so',
                DB::raw('ST_Y(geom) as lat'),
                DB::raw('ST_X(geom) as lng')
            )
            ->whereNotNull('geom')
            ->limit(5000)
            ->get();

        // =========================================================
        // 6. DERNIERS PANNEAUX
        // =========================================================
        $derniersPanneaux = DB::table($this->table)
            ->select("{$this->pk} as id", 'Type', 'route_nom', 'point_kilo', 'nature_mat', 'dimensions')
            ->orderByDesc($this->pk)
            ->limit(8)
            ->get();

        // =========================================================
        // 7. DERNIÈRES OBSERVATIONS
        // =========================================================
        $dernieresObservations = DB::table($this->tableObs . ' as o')
            ->leftJoin($this->table . ' as t', 'o.id_traffic', '=', "t.{$this->pk}")
            ->select(
                'o.id_obs',
                'o.etat_actuel',
                'o.classe_retro',
                'o.date_obs',
                'o.remarque',
                't.Type as type_panneau',
                't.route_nom',
                't.point_kilo'
            )
            ->orderByDesc('o.date_obs')
            ->limit(8)
            ->get();

        // Log pour debug
        \Log::info('Dashboard: PK détectée = ' . $this->pk);
        \Log::info('Dashboard états : Bon=' . $totalBon . ', Dégradé=' . $totalDegrade . ', Vandal=' . $totalVandal . ', Masqué=' . $totalMasque);

        return view('Backend.gestion.dashboard.index', compact(
            'adminData',
            'totalPanneaux',
            'totalRoutes',
            'totalNatures',
            'totalTypesSuppo',
            'totalGeoloc',
            'hauteurMoyenne',
            'totalObservations',
            'panneauxObserves',
            'tauxCouverture',
            'totalBon',
            'totalDegrade',
            'totalVandal',
            'totalMasque',
            'parType',
            'parNature',
            'parSupport',
            'parCouleur',
            'parRoute',
            'parDimensions',
            'obsParEtat',
            'obsParClasse',
            'pointsCarte',
            'derniersPanneaux',
            'dernieresObservations'
        ));
    }

    /**
     * API — Points pour la carte (AJAX)
     */
    public function apiPoints()
    {
        $points = DB::table($this->table)
            ->select(
                "{$this->pk} as id",
                'Type', 'nature_mat', 'route_nom', 'point_kilo',
                'dimensions', 'couleur_fo', 'type_suppo', 'hauteur_so',
                DB::raw('ST_Y(geom) as lat'),
                DB::raw('ST_X(geom) as lng')
            )
            ->whereNotNull('geom')
            ->get();

        return response()->json($points);
    }

    /**
     * API — Statistiques filtrées (AJAX)
     */
    public function apiStats(Request $request)
    {
        $query = DB::table($this->table);

        if ($request->filled('route_nom')) {
            $query->where('route_nom', $request->route_nom);
        }
        if ($request->filled('Type')) {
            $query->where('Type', $request->Type);
        }
        if ($request->filled('nature_mat')) {
            $query->where('nature_mat', $request->nature_mat);
        }

        return response()->json([
            'total'     => $query->count(),
            'par_type'  => (clone $query)->select('Type', DB::raw('COUNT(*) as total'))->groupBy('Type')->get(),
            'par_route' => (clone $query)->select('route_nom', DB::raw('COUNT(*) as total'))->groupBy('route_nom')->get(),
        ]);
    }
}