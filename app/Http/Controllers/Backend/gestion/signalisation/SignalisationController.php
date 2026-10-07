<?php

namespace App\Http\Controllers\Backend\gestion\signalisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class SignalisationController extends Controller
{
    protected string $table    = 'trafic';
    protected string $tableTyp = 'types_panneaux';
    protected string $tableObs = 'observation';
    protected string $tablePho = 'photo';
    protected string $pk       = 'id_0';

    /**
     * Chemin physique du dossier des photos
     */
    protected function photosDir(): string
    {
        return public_path('Backend/assets/photos');
    }

    /* =========================================================
       INDEX
    ========================================================= */
    public function index(Request $request)
    {
        $page    = (int) $request->input('page', 1);
        $search  = $request->input('q');
        $route   = $request->input('route_nom');
        $type    = $request->input('code_nomen');
        $etat    = $request->input('etat_actuel');
        $perPage = 20;
        $offset  = ($page - 1) * $perPage;

        $pk = $this->pk;

        $baseQuery = "
            WITH LatestObs AS (
                SELECT o1.id_traffic, MAX(o1.id_obs) AS last_id_obs
                FROM public.{$this->tableObs} o1
                GROUP BY o1.id_traffic
            ),
            LastObservation AS (
                SELECT o.id_obs, o.id_traffic, o.date_obs, o.etat_actuel,
                       o.classe_retro, o.num_agrem, o.date_pose,
                       o.date_fabrication, o.garantie_expiration, o.remarque
                FROM public.{$this->tableObs} o
                INNER JOIN LatestObs lo ON o.id_traffic = lo.id_traffic
                                      AND o.id_obs = lo.last_id_obs
            )
            SELECT
                t.{$pk} AS panneau_id,
                t.code_nomen,
                t.\"Type\" AS type_code,
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
                t.fclass,
                t.name,
                tp.nom           AS type_nom,
                tp.description   AS type_description,
                tp.couleur_fond  AS type_couleur_fond,
                tp.couleur_bord  AS type_couleur_bord,
                tp.categorie     AS type_categorie,
                o.id_obs,
                o.date_obs,
                o.etat_actuel,
                o.classe_retro,
                o.num_agrem,
                o.date_pose,
                o.date_fabrication,
                o.garantie_expiration,
                o.remarque AS obs_remarque,
                (SELECT COUNT(*) FROM public.{$this->tableObs} o2
                 WHERE o2.id_traffic = t.{$pk}) AS nb_observations,
                (SELECT COUNT(*) FROM public.{$this->tablePho} p
                 JOIN public.{$this->tableObs} o3 ON o3.id_obs = p.id_obs
                 WHERE o3.id_traffic = t.{$pk}) AS nb_photos
            FROM public.{$this->table} t
            LEFT JOIN public.{$this->tableTyp} tp ON tp.code_type = t.code_nomen
            LEFT JOIN LastObservation o ON o.id_traffic = t.{$pk}
            WHERE 1=1
        ";

        $bindings   = [];
        $conditions = [];

        if ($search) {
            $conditions[] = "(t.code_nomen ILIKE ? OR t.name ILIKE ? OR t.route_nom ILIKE ? OR tp.nom ILIKE ?)";
            $bindings = array_merge($bindings, array_fill(0, 4, "%{$search}%"));
        }
        if ($route) {
            $conditions[] = "t.route_nom ILIKE ?";
            $bindings[]   = "%{$route}%";
        }
        if ($type) {
            $conditions[] = "t.code_nomen = ?";
            $bindings[]   = $type;
        }
        if ($etat) {
            $conditions[] = "o.etat_actuel = ?";
            $bindings[]   = $etat;
        }

        if (!empty($conditions)) {
            $baseQuery .= " AND " . implode(" AND ", $conditions);
        }

        $countQuery = "SELECT COUNT(*) AS total FROM ({$baseQuery}) AS subquery";
        $totalCount = (int) DB::select($countQuery, $bindings)[0]->total;

        $query    = $baseQuery . " ORDER BY o.date_obs DESC NULLS LAST, t.{$pk} DESC LIMIT ? OFFSET ?";
        $bindings = array_merge($bindings, [$perPage, $offset]);

        $datas = DB::select($query, $bindings);

        $panneaux = new LengthAwarePaginator(
            $datas, $totalCount, $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $routesDisponibles = DB::table($this->table)
            ->select('route_nom')->whereNotNull('route_nom')->where('route_nom', '!=', '')
            ->distinct()->orderBy('route_nom')->pluck('route_nom');

        $typesDisponibles = DB::table($this->tableTyp)
            ->select('code_type', 'nom')->orderBy('code_type')->get();

        $etatsDisponibles = ['Bon', 'Dégradé', 'Vandalisé', 'Masqué'];

        return view('Backend.gestion.signalisation.index', [
            'panneaux'          => $panneaux,
            'routesDisponibles' => $routesDisponibles,
            'typesDisponibles'  => $typesDisponibles,
            'etatsDisponibles'  => $etatsDisponibles,
            'route'             => $route,
            'type'              => $type,
            'etat'              => $etat,
            'search'            => $search,
        ]);
    }

    /* =========================================================
       SHOW
    ========================================================= */
    public function show($id)
    {
        $pk = $this->pk;

        $query = "
            SELECT
                t.{$pk} AS panneau_id,
                t.code_nomen,
                t.\"Type\" AS type_code,
                t.fclass,
                t.name,
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
                tp.description   AS type_description,
                tp.couleur_fond  AS type_couleur_fond,
                tp.couleur_bord  AS type_couleur_bord,
                tp.categorie     AS type_categorie,
                ST_Y(ST_Transform(t.geom, 4326)) AS lat,
                ST_X(ST_Transform(t.geom, 4326)) AS lng
            FROM public.{$this->table} t
            LEFT JOIN public.{$this->tableTyp} tp ON tp.code_type = t.code_nomen
            WHERE t.{$pk} = ?
            LIMIT 1
        ";

        $panneau = DB::select($query, [$id])[0] ?? null;

        if (!$panneau) {
            abort(404, 'Panneau introuvable');
        }

        $observations = DB::table($this->tableObs . ' as o')
            ->select(
                'o.id_obs', 'o.date_obs', 'o.date_fabrication', 'o.date_pose',
                'o.garantie_expiration', 'o.num_agrem', 'o.classe_retro',
                'o.etat_actuel', 'o.remarque', 'o.photo_path'
            )
            ->where('o.id_traffic', $id)
            ->orderByDesc('o.date_obs')
            ->get();

        $photosParObs = [];
        if ($observations->isNotEmpty()) {
            $obsIds = $observations->pluck('id_obs')->toArray();
            $photos = DB::table($this->tablePho)
                ->whereIn('id_obs', $obsIds)
                ->orderByDesc('prise_le')
                ->get();
            foreach ($photos as $p) {
                $photosParObs[$p->id_obs][] = $p;
            }
        }

        $nbObservations = $observations->count();
        $derniereObs    = $observations->first();
        $nbPhotos       = array_sum(array_map('count', $photosParObs));

        $voisins = DB::table($this->table)
            ->select("{$pk} as id", 'code_nomen', 'point_kilo')
            ->where('route_nom', $panneau->route_nom)
            ->where($pk, '!=', $id)
            ->whereNotNull('point_kilo')
            ->orderBy('point_kilo')
            ->limit(10)
            ->get();

        $listes = [
            'types_panneaux' => DB::table($this->tableTyp)
                ->select('code_type', 'nom')->orderBy('code_type')->get(),
            'fclass' => DB::table($this->table)
                ->select('fclass')->whereNotNull('fclass')->where('fclass', '!=', '')
                ->distinct()->orderBy('fclass')->pluck('fclass'),
            'routes' => DB::table($this->table)
                ->select('route_nom')->whereNotNull('route_nom')->where('route_nom', '!=', '')
                ->distinct()->orderBy('route_nom')->pluck('route_nom'),
            'dimensions' => DB::table($this->table)
                ->select('dimensions')->whereNotNull('dimensions')->where('dimensions', '!=', '')
                ->distinct()->orderBy('dimensions')->pluck('dimensions'),
            'types_suppo' => DB::table($this->table)
                ->select('type_suppo')->whereNotNull('type_suppo')->where('type_suppo', '!=', '')
                ->distinct()->orderBy('type_suppo')->pluck('type_suppo'),
            'nature_mat' => DB::table($this->table)
                ->select('nature_mat')->whereNotNull('nature_mat')->where('nature_mat', '!=', '')
                ->distinct()->orderBy('nature_mat')->pluck('nature_mat'),
            'type_subje' => DB::table($this->table)
                ->select('type_subje')->whereNotNull('type_subje')->where('type_subje', '!=', '')
                ->distinct()->orderBy('type_subje')->pluck('type_subje'),
            'protection' => DB::table($this->table)
                ->select('protection')->whereNotNull('protection')
                ->distinct()->orderBy('protection')->pluck('protection'),
        ];

        return view('Backend.gestion.signalisation.show', compact(
            'panneau',
            'observations',
            'photosParObs',
            'nbObservations',
            'nbPhotos',
            'derniereObs',
            'voisins',
            'listes'
        ));
    }

    /* =========================================================
       UPDATE PANNEAU
    ========================================================= */
    public function update(Request $request, $id)
    {
        $pk = $this->pk;

        try {
            $validated = $request->validate([
                'code_nomen'              => 'nullable|string|max:50',
                'fclass'                  => 'nullable|string|max:100',
                'name'                    => 'nullable|string|max:255',
                'code_panneau_cctp'       => 'nullable|in:EB10,E36,D20,D43',
                'hc_caractere'            => 'nullable|in:100,125,160,200',
                'route_nom'               => 'nullable|string|max:100',
                'point_kilo'              => 'nullable|string|max:50',
                'route'                   => 'nullable|string|max:50',
                'acier_nuance'            => 'nullable|in:Acier E 24-1,Acier A 33',
                'galva_depot'             => 'nullable|numeric|min:5.7|max:10',
                'largeur_latte'           => 'nullable|integer|min:15|max:30',
                'anodise'                 => 'nullable|boolean',
                'num_agrement'            => 'nullable|string|max:50',
                'nature_mat'              => 'nullable|string|max:100',
                'type_subje'              => 'nullable|string|max:100',
                'dimensions'              => 'nullable|string|max:50',
                'dim_cctp'                => 'nullable|string|max:30',
                'couleur_fo'              => 'nullable|string|max:50',
                'protection'              => 'nullable|string|max:100',
                'type_film_retro'         => 'nullable|in:Classe 1 (EG),Classe 2 (HI),Classe 3 (DG)',
                'garantie_film_ans'       => 'nullable|integer|min:7|max:15',
                'nb_raidisseurs'          => 'nullable|integer|min:2|max:3',
                'type_suppo'              => 'nullable|string|max:100',
                'matiere_support'         => 'nullable|string|max:50',
                'hauteur_so'              => 'nullable|numeric|min:2.30|max:10',
                'hauteur_libre_m'         => 'nullable|numeric|min:2.30|max:10',
                'implantation_m'          => 'nullable|numeric|min:1|max:3',
                'fiche_ancrage_m'         => 'nullable|numeric|min:0.4|max:2',
                'resistance'              => 'nullable|integer|min:130|max:250',
                'date_pose'               => 'nullable|date',
                'duree_vie_ans'           => 'nullable|integer|min:7|max:20',
            ]);

            DB::table($this->table)->where($pk, $id)->update($validated);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Informations mises à jour avec succès.',
                    'data'    => $validated,
                ]);
            }

            return redirect()->route('signalisation.show', $id)
                ->with('success', 'Informations mises à jour avec succès.');

        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $e->errors(),
                ], 422);
            }
            throw $e;
        } catch (Throwable $e) {
            Log::error('Erreur update panneau #' . $id . ' : ' . $e->getMessage());
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur serveur : ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour.');
        }
    }

    /* =========================================================
       STORE PANNEAU
    ========================================================= */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code_nomen'              => 'nullable|string|max:50',
                'fclass'                  => 'nullable|string|max:100',
                'name'                    => 'nullable|string|max:255',
                'code_panneau_cctp'       => 'nullable|string|max:20',
                'hc_caractere'            => 'nullable|in:100,125,160,200',
                'route_nom'               => 'nullable|string|max:100',
                'point_kilo'              => 'nullable|string|max:50',
                'route'                   => 'nullable|string|max:50',
                'lat'                     => 'required|numeric|between:-90,90',
                'lng'                     => 'required|numeric|between:-180,180',
                'acier_nuance'            => 'nullable|string|max:50',
                'galva_depot'             => 'nullable|numeric|min:0|max:20',
                'largeur_latte'           => 'nullable|integer|min:0|max:100',
                'anodise'                 => 'nullable|boolean',
                'num_agrement'            => 'nullable|string|max:50',
                'nature_mat'              => 'nullable|string|max:100',
                'type_subje'              => 'nullable|string|max:100',
                'dimensions'              => 'nullable|string|max:50',
                'dim_cctp'                => 'nullable|string|max:30',
                'couleur_fo'              => 'nullable|string|max:50',
                'protection'              => 'nullable|string|max:100',
                'type_film_retro'         => 'nullable|string|max:50',
                'garantie_film_ans'       => 'nullable|integer|min:0|max:20',
                'nb_raidisseurs'          => 'nullable|integer|min:0|max:5',
                'type_suppo'              => 'nullable|string|max:100',
                'matiere_support'         => 'nullable|string|max:50',
                'hauteur_so'              => 'nullable|numeric|min:0|max:20',
                'hauteur_libre_m'         => 'nullable|numeric|min:0|max:20',
                'implantation_m'          => 'nullable|numeric|min:0|max:10',
                'fiche_ancrage_m'         => 'nullable|numeric|min:0|max:5',
                'resistance'              => 'nullable|integer|min:0|max:500',
                'date_pose'               => 'nullable|date',
                'duree_vie_ans'           => 'nullable|integer|min:0|max:50',
            ]);

            $lat = $validated['lat'];
            $lng = $validated['lng'];
            unset($validated['lat'], $validated['lng']);

            $id = DB::table($this->table)->insertGetId(
                array_merge($validated, [
                    'geom' => DB::raw("ST_SetSRID(ST_MakePoint($lng, $lat), 4326)"),
                ])
            );

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Panneau créé avec succès.',
                    'id'      => $id,
                ]);
            }

            return redirect()->route('signalisation.show', $id)
                ->with('success', 'Panneau créé avec succès.');

        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $e->errors(),
                ], 422);
            }
            throw $e;
        } catch (Throwable $e) {
            Log::error('Erreur store panneau : ' . $e->getMessage());
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur serveur : ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Erreur lors de la création.');
        }
    }

    /* =========================================================
       ✅ STORE OBSERVATION — AVEC GESTION D'ERREUR ROBUSTE
       - Détection des erreurs PHP (post_max_size, upload_max_filesize)
       - Toujours retourner du JSON pour les requêtes AJAX
       - Validation photos robuste
    ========================================================= */
    public function storeObservation(Request $request, $id)
    {
        // ✅ Vérification CRITIQUE : PHP a-t-il rejeté la requête ?
        // Si post_max_size est dépassé, $_POST et $_FILES sont VIDES.
        if ($this->isPostMaxSizeExceeded()) {
            Log::warning('POST max size exceeded lors de storeObservation');
            return response()->json([
                'success' => false,
                'message' => 'Les photos envoyées sont trop volumineuses (limite serveur dépassée). ' .
                             'Réduisez la taille ou le nombre de photos. ' .
                             'Taille max actuelle : ' . ini_get('post_max_size'),
            ], 413);
        }

        try {
            $validated = $request->validate([
                'date_obs'            => 'nullable|date',
                'date_fabrication'    => 'nullable|date',
                'date_pose'           => 'nullable|date',
                'garantie_expiration' => 'nullable|date',
                'num_agrem'           => 'nullable|string|max:50',
                'classe_retro'        => 'nullable|string|max:20',
                'etat_actuel'         => 'required|string|max:30',
                'remarque'            => 'nullable|string|max:2000',
                'photos'              => 'nullable|array|max:10',
                'photos.*'            => 'image|mimes:jpeg,jpg,png,webp|max:10240',
            ]);

            $photos = $request->file('photos');
            unset($validated['photos']);

            if (empty($validated['date_obs'])) {
                $validated['date_obs'] = now();
            }

            // 1) Déplacer les photos — lire les métadonnées AVANT move()
            $destination = $this->photosDir();
            if (!is_dir($destination)) {
                if (!mkdir($destination, 0755, true) && !is_dir($destination)) {
                    throw new \RuntimeException("Impossible de créer le dossier : {$destination}");
                }
            }

            $savedPhotos = [];
            $photoErrors = [];

            if (!empty($photos)) {
                foreach ($photos as $file) {
                    if (!$file->isValid()) {
                        $errMsg = $file->getErrorMessage();
                        Log::warning('Upload invalide : ' . $errMsg);
                        $photoErrors[] = $errMsg;
                        continue;
                    }

                    // ⚠️ Lire AVANT move() — sinon "file does not exist"
                    $originalName = $file->getClientOriginalName();
                    $mimeType     = $file->getClientMimeType();
                    $extension    = strtolower($file->getClientOriginalExtension());
                    $sizeKb       = (int) round($file->getSize() / 1024);

                    // Sécurité : whitelist extensions
                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                        $photoErrors[] = "Extension non autorisée : {$extension}";
                        continue;
                    }

                    $filename = Str::uuid() . '.' . $extension;

                    try {
                        $file->move($destination, $filename);
                    } catch (Throwable $e) {
                        Log::error('Erreur move() : ' . $e->getMessage());
                        $photoErrors[] = "Impossible de sauvegarder : {$originalName}";
                        continue;
                    }

                    $fullPath = $destination . DIRECTORY_SEPARATOR . $filename;
                    if (!is_file($fullPath)) {
                        Log::error("Fichier non déplacé : {$fullPath}");
                        $photoErrors[] = "Fichier perdu : {$originalName}";
                        continue;
                    }

                    $savedPhotos[] = [
                        'nom_fichier' => $originalName,
                        'chemin'      => $filename,
                        'mime_type'   => $mimeType,
                        'taille_ko'   => $sizeKb,
                    ];
                }
            }

            // 2) Insérer l'observation
            $idObs = DB::table($this->tableObs)->insertGetId(
                array_merge($validated, [
                    'id_traffic' => $id,
                    'created_at' => now(),
                ]),
                'id_obs'
            );

            // 3) Insérer les photos en base
            foreach ($savedPhotos as $p) {
                DB::table($this->tablePho)->insert([
                    'id_obs'      => $idObs,
                    'nom_fichier' => $p['nom_fichier'],
                    'chemin'      => $p['chemin'],
                    'type_photo'  => $request->input('type_photo', 'Face'),
                    'legende'     => $request->input('legende'),
                    'mime_type'   => $p['mime_type'],
                    'taille_ko'   => $p['taille_ko'],
                    'prise_le'    => now(),
                    'uploaded_by' => Auth::id(),
                    'created_at'  => now(),
                ]);
            }

            // ✅ Message avec info sur les photos éventuellement ratées
            $message = 'Observation enregistrée avec succès.';
            if (!empty($photoErrors)) {
                $message .= ' (' . count($photoErrors) . ' photo(s) ignorée(s))';
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success'       => true,
                    'message'       => $message,
                    'id_obs'        => $idObs,
                    'photos_saved'  => count($savedPhotos),
                    'photos_failed' => count($photoErrors),
                ]);
            }

            return redirect()->route('signalisation.show', $id)
                ->with('success', $message);

        } catch (ValidationException $e) {
            Log::info('Validation échouée storeObservation', $e->errors());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $e->errors(),
                    'message' => 'Certains champs sont invalides.',
                ], 422);
            }
            throw $e;

        } catch (Throwable $e) {
            Log::error('Erreur storeObservation : ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id_traffic' => $id,
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur serveur : ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Erreur lors de la création de l\'observation.');
        }
    }

    /* =========================================================
       UPDATE OBSERVATION
    ========================================================= */
    public function updateObservation(Request $request, $idObs)
    {
        try {
            $validated = $request->validate([
                'date_obs'              => 'nullable|date',
                'date_fabrication'      => 'nullable|date',
                'date_pose'             => 'nullable|date',
                'garantie_expiration'   => 'nullable|date',
                'num_agrem'             => 'nullable|string|max:50',
                'classe_retro'          => 'nullable|string|max:20',
                'etat_actuel'           => 'required|string|max:30',
                'remarque'              => 'nullable|string|max:2000',
            ]);

            DB::table($this->tableObs)
                ->where('id_obs', $idObs)
                ->update(array_merge($validated, [
                    'updated_at' => now(),
                ]));

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Observation modifiée avec succès.',
                ]);
            }

            return redirect()->back()->with('success', 'Observation modifiée.');

        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $e->errors(),
                ], 422);
            }
            throw $e;
        } catch (Throwable $e) {
            Log::error('Erreur updateObservation #' . $idObs . ' : ' . $e->getMessage());
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur serveur : ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Erreur lors de la modification.');
        }
    }

    /* =========================================================
       DESTROY OBSERVATION
    ========================================================= */
    public function destroyObservation($idObs)
    {
        try {
            $photos = DB::table($this->tablePho)->where('id_obs', $idObs)->get();

            foreach ($photos as $photo) {
                $fullPath = $this->photosDir() . DIRECTORY_SEPARATOR . $photo->chemin;
                if (is_file($fullPath)) {
                    @unlink($fullPath);
                }
            }

            DB::table($this->tablePho)->where('id_obs', $idObs)->delete();
            DB::table($this->tableObs)->where('id_obs', $idObs)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Observation supprimée.',
            ]);

        } catch (Throwable $e) {
            Log::error('Erreur destroyObservation #' . $idObs . ' : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur : ' . $e->getMessage(),
            ], 500);
        }
    }


/* =========================================================
   ✅ DESTROY PANNEAU
   - Supprime l'observation liée + toutes ses photos (fichiers + BD)
   - Supprime le panneau lui-même
========================================================= */
public function destroy($id)
{
    try {
        // 1) Récupérer toutes les observations du panneau
        $observations = DB::table($this->tableObs)
            ->where('id_traffic', $id)
            ->pluck('id_obs')
            ->toArray();

        // 2) Supprimer les photos physiques + lignes en BD
        if (!empty($observations)) {
            $photos = DB::table($this->tablePho)
                ->whereIn('id_obs', $observations)
                ->get();

            foreach ($photos as $photo) {
                $fullPath = $this->photosDir() . DIRECTORY_SEPARATOR . $photo->chemin;
                if (is_file($fullPath)) {
                    @unlink($fullPath);
                }
            }

            DB::table($this->tablePho)->whereIn('id_obs', $observations)->delete();
            DB::table($this->tableObs)->where('id_traffic', $id)->delete();
        }

        // 3) Supprimer le panneau
        $deleted = DB::table($this->table)->where($this->pk, $id)->delete();

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Panneau introuvable.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Panneau supprimé avec succès (avec ses ' 
                         . count($observations) . ' observation(s)).',
        ]);

    } catch (Throwable $e) {
        Log::error('Erreur destroy panneau #' . $id . ' : ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Erreur serveur : ' . $e->getMessage(),
        ], 500);
    }
}

/* =========================================================
   ✅ DESTROY PHOTO (suppression individuelle)
========================================================= */
public function destroyPhoto($idPhoto)
{
    try {
        $photo = DB::table($this->tablePho)->where('id_photo', $idPhoto)->first();

        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo introuvable.',
            ], 404);
        }

        $fullPath = $this->photosDir() . DIRECTORY_SEPARATOR . $photo->chemin;
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }

        DB::table($this->tablePho)->where('id_photo', $idPhoto)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Photo supprimée.',
        ]);

    } catch (Throwable $e) {
        Log::error('Erreur destroyPhoto #' . $idPhoto . ' : ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Erreur serveur : ' . $e->getMessage(),
        ], 500);
    }
}


    /* =========================================================
       ✅ DÉTECTION post_max_size DÉPASSÉ
       Si le POST dépasse post_max_size, PHP vide $_POST et $_FILES
       silencieusement, et Content-Length est présent mais $_POST vide.
    ========================================================= */
    protected function isPostMaxSizeExceeded(): bool
    {
        // Cas 1 : Content-Length présent mais $_POST et $_FILES vides
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && empty($_POST)
            && empty($_FILES)
            && !empty($_SERVER['CONTENT_LENGTH'])
        ) {
            $postMax = $this->parseSize(ini_get('post_max_size'));
            $contentLength = (int) $_SERVER['CONTENT_LENGTH'];

            if ($postMax > 0 && $contentLength > $postMax) {
                return true;
            }

            // Si $_POST est vide alors qu'on attend un CSRF token, c'est suspect
            if ($contentLength > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Convertit '8M', '2G', '512K' en octets
     */
    protected function parseSize(string $size): int
    {
        $size = trim($size);
        if ($size === '' || $size === '-1') {
            return 0; // 0 = illimité
        }

        $unit = strtolower(substr($size, -1));
        $value = (int) $size;

        return match ($unit) {
            'g' => $value * 1024 * 1024 * 1024,
            'm' => $value * 1024 * 1024,
            'k' => $value * 1024,
            default => $value,
        };
    }
}
