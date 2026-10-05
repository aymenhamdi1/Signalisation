<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id('id_prj'); // Clé primaire avec nom personnalisé
            $table->string('nom_prj', 255);
            $table->string('type_prj', 255)->nullable();
            $table->string('pk_debut', 50)->nullable();
            $table->string('pk_fin', 50)->nullable();
            $table->string('rte_nom', 255)->nullable();
            $table->geometry('geom')->nullable(); // Pour le stockage géospatial
            $table->dateTime('date_creation')->nullable();
            $table->decimal('distance_apres_debut_m', 10, 2)->nullable();
            $table->decimal('distance_apres_fin_m', 10, 2)->nullable();
            $table->string('bailleur_de_fond', 255)->nullable();
            $table->date('date_signature_contrat')->nullable();
            $table->date('annee_budgetisation')->nullable();
            $table->date('date_debut_travaux')->nullable();
            $table->decimal('longueur_travaux', 10, 2)->nullable();
            $table->decimal('avancement_payement', 12, 2)->nullable();
            $table->decimal('avancement_projet', 3, 2)->nullable(); // Valeur entre 0 et 1
            $table->decimal('montant_projet', 15, 2)->nullable();
            
            // Timestamps optionnels - décommentez si vous les voulez
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('projets');
    }
};