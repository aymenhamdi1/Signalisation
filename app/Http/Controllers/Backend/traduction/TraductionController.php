<?php

namespace App\Http\Controllers\Backend\traduction;

use App\Models\Traduction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class TraductionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }


    public function allTraduction()
    {
        $traductions = Traduction::select('key')->groupBy('key')->get();
        $data = [];

        foreach ($traductions as $traduction) {
            $languages = [];
            $translations = Traduction::where('key', $traduction->key)->get();

            foreach ($translations as $translation) {
                if (!in_array($translation->language, $languages)) {
                    $languages[] = $translation->language;
                }
            }

            $progress = count($languages) / 3;
            $color = count($languages) === 3 ? 'success' : (count($languages) === 2 ? 'warning' : 'danger');

            $data[] = [
                'key' => $traduction->key,
                'languages' => $languages,
                'color' => $color,
                'progress' => $progress,
            ];
        }

        // Tri les éléments en fonction de la progression de la barre (ordre croissant)
        usort($data, function ($a, $b) {
            return $a['progress'] <=> $b['progress'];
        });

        return view('Backend.traduction.index', compact('data'));
    }



    public function addTraduction()
    {
        $langTraductions = Traduction::all();
        return view('Backend.traduction.add', compact('langTraductions'));
    }

    public function storeTraduction(Request $request)
    {
        if (!is_null($request->key)) {
            $countTraduction = count($request->key);
            for ($i = 0; $i < $countTraduction; $i++) {
                $data = new Traduction();
                $data->language = $request->language[$i];
                $data->key = $request->key[$i];
                $data->value = $request->value[$i];
                $data->save();
            }

            // Group translations by language
            $translations = collect($request->language)->zip($request->key, $request->value)->groupBy(0);

            foreach ($translations as $language => $translation) {
                $this->updateLanguageFiles($language, $translation->pluck(1)->toArray(), $translation->pluck(2)->toArray());
            }
        }

        $notification = array(
            'message' => __('Successfully created'),
            'alert-type' => 'success'
        );

        return redirect()->route('all.traduction')->with($notification);
    }

    public function editTraduction($key)
    {
        $traductions = Traduction::where('key', $key)->orderBy('key', 'asc')->get();
        if ($traductions->isEmpty()) {
            // Handle the case when no traductions are found for the given key
            abort(404); // Or redirect to an error page, display a message, etc.
        }
        return view('Backend.traduction.edit', compact('traductions'));
    }

    public function updateTraduction(Request $request, $key)
    {
        if ($request->language == null) {
            $notification = array(
                'message' => __('Sorry, the field must not be empty'),
                'alert-type' => 'error'
            );

            return redirect()->route('edit.traduction', $key)->with($notification);
        } else {
            $countTraduction = count($request->language);
            $languages = Traduction::where('key', $key)->pluck('language')->toArray();
            Traduction::where('key', $key)->delete();
            foreach ($languages as $language) {
                $this->updateLanguageFiles($language, [$key], []);
            }
            for ($i = 0; $i < $countTraduction; $i++) {
                $data = new Traduction();
                $data->language = $request->language[$i];
                $data->key = $request->key[$i];
                $data->value = $request->value[$i];
                $data->save();
            }

            // Group translations by language
            $translations = collect($request->language)->zip($request->key, $request->value)->groupBy(0);

            foreach ($translations as $language => $translation) {
                $this->updateLanguageFiles($language, $translation->pluck(1)->toArray(), $translation->pluck(2)->toArray());
            }
        }

        $notification = array(
            'message' => __('Successfully updated'),
            'alert-type' => 'success'
        );

        return redirect()->route('all.traduction')->with($notification);
    }

    public function deleteTraduction($key)
    {
        $languages = Traduction::where('key', $key)->pluck('language')->toArray();
        Traduction::where('key', $key)->delete();

        foreach ($languages as $language) {
            $this->updateLanguageFiles($language, [$key], []);
        }

        $notification = array(
            'message' => __('Successfully deleted'),
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    //multi delete
    public function deleteMultipleTraductions(Request $request)
    {
        $selectedItems = $request->input('selectedItems', []);

        foreach ($selectedItems as $key) {
            $languages = Traduction::where('key', $key)->pluck('language')->toArray();
            Traduction::where('key', $key)->delete();

            foreach ($languages as $language) {
                $this->updateLanguageFiles($language, [$key], []);
            }
        }

        $notification = [
            'message' => __('Selected translations deleted successfully.'),
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // sin multi delete


    private function updateLanguageFiles($language, $keys, $values)
    {
        // Convert a single language string to an array
        if (!is_array($language)) {
            $language = [$language];
        }

        foreach ($language as $lang) {
            $filePath = base_path("lang/$lang.json");
            $translations = [];

            // Check if the JSON file exists
            if (File::exists($filePath)) {
                // Load the existing content of the JSON file
                $jsonContent = File::get($filePath);
                $translations = json_decode($jsonContent, true);

                // Remove the translations with the specified keys
                foreach ($keys as $key) {
                    unset($translations[$key]);
                }

                // Delete the file if translations are empty
                if (empty($translations)) {
                    File::delete($filePath);
                }
            }

            // Update the translations
            if (count($keys) === count($values)) {
                $translations = array_merge($translations, array_combine($keys, $values));
            } else {
                // Handle error or mismatched array sizes here
            }

            // Save the translations to the JSON file
            if (!empty($translations)) {
                File::put($filePath, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }

    //

    public function extractTranslationsFromBladeFiles()
    {
        $bladeFiles = $this->getAllBladeFiles();
        $translations = [];
    
        foreach ($bladeFiles as $file) {
            $content = File::get($file);
            $matches = [];
    
            // Extraire les traductions avec {{trans()}} ou __('')
            preg_match_all("/{{trans\((.*?)\)}}|__\('(.*?)'\)/", $content, $matches);
    
            // Ajouter les traductions extraites au tableau
            $translations = array_merge($translations, $matches[1], $matches[2]);
        }
    
        // Supprimer les traductions en double et vides
        $translations = array_filter(array_unique($translations));
    
        // Chemin du fichier JSON pour l'anglais
        $jsonFilePath = base_path('lang/en.json');
        $existingTranslations = json_decode(file_get_contents($jsonFilePath), true) ?? [];
    
        // Comparer les traductions extraites avec celles de en.json et ajouter les nouvelles
        $newTranslations = [];
        foreach ($translations as $translation) {
            if (!isset($existingTranslations[$translation])) {
                $newTranslations[$translation] = $translation;
    
                // Créer une nouvelle entrée dans la table "traductions" avec la langue "en"
                Traduction::create([
                    'key' => $translation,
                    'value' => $translation,
                    'language' => 'en',
                ]);
            }
        }
    
        // Supprimer les traductions de en.json qui ne sont pas dans la table "traductions"
        foreach ($existingTranslations as $key => $value) {
            if (!in_array($key, $translations)) {
                unset($existingTranslations[$key]);
    
                // Supprimer la traduction de la table "traductions"
                Traduction::where('key', $key)->delete();
            }
        }
    
        // Fusionner les nouvelles traductions avec les traductions existantes
        $updatedTranslations = array_merge($existingTranslations, $newTranslations);
    
        // Enregistrer les traductions mises à jour dans le fichier en.json
        file_put_contents($jsonFilePath, json_encode($updatedTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    
        // Rediriger vers la même page avec une notification
        return redirect()->back()->with([
            'message' => __('Successfully Extraction'),
            'alert-type' => 'success',
        ]);
    }
    
    private function getAllBladeFiles($directory = null)
    {
        $bladeFiles = [];
        $viewsPath = resource_path('views');
    
        if (is_null($directory)) {
            $directory = $viewsPath;
        }
    
        $finder = new Finder();
        $finder->files()->name('*.blade.php')->in($directory);
    
        foreach ($finder as $file) {
            $bladeFiles[] = $file->getRealPath();
        }
    
        return $bladeFiles;
    }
    



}
