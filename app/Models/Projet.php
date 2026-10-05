<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    // Désactive complètement les timestamps automatiques
    public $timestamps = false;
    
    // Si votre clé primaire n'est pas 'id', spécifiez-la
    protected $primaryKey = 'id_prj';
    // Dans app/Models/Projet.php
public function getDateSignatureContratForInputAttribute()
{
    return $this->date_signature_contrat ? $this->date_signature_contrat->format('Y-m-d') : '';
}

public function getAnneeBudgetisationForInputAttribute()
{
    return $this->annee_budgetisation ? $this->annee_budgetisation->format('Y-m-d') : '';
}

public function getDateDebutTravauxForInputAttribute()
{
    return $this->date_debut_travaux ? $this->date_debut_travaux->format('Y-m-d') : '';
}
    // Liste des champs remplissables (si vous utilisez fillable)
    protected $fillable = [
        'nom_prj',
        'type_prj',
        'pk_debut',
        'pk_fin',
        'rte_nom',
        'geom',
        'date_creation',
        'distance_apres_debut_m',
        'distance_apres_fin_m',
        'bailleur_de_fond',
        'date_signature_contrat',
        'annee_budgetisation',
        'date_debut_travaux',
        'longueur_travaux',
        'avancement_payement',
        'avancement_projet',
        'montant_projet'
    ];
}