<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([

           //Menu
[
    'name'=> 'traduction.menu',
    'guard_name'=> 'web',
    'group_name'=> 'traduction',
    ],
    //Add
    [
    'name'=> 'traduction.add',
    'guard_name'=> 'web',
    'group_name'=> 'traduction',
    ],
    //Store
    [
    'name'=> 'traduction.store',
    'guard_name'=> 'web',
    'group_name'=> 'traduction',
    ],
    //Edit
    [
    'name'=> 'traduction.edit',
    'guard_name'=> 'web',
    'group_name'=> 'traduction',
    ],
    //Update
    [
    'name'=> 'traduction.update',
    'guard_name'=> 'web',
    'group_name'=> 'traduction',
    ],
    //Delete
    [
    'name'=> 'traduction.delete',
    'guard_name'=> 'web',
    'group_name'=> 'traduction',
    ],

     //Extrait les terme a traduire
     [
        'name'=> 'traduction.trans',
        'guard_name'=> 'web',
        'group_name'=> 'traduction',
        ],

         //Multi delete
    [
        'name'=> 'traduction.mdelete',
        'guard_name'=> 'web',
        'group_name'=> 'traduction',
        ],

    //user
    //Menu
[
    'name'=> 'user.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Utlisateur',
    ],
    //Add
    [
    'name'=> 'user.add',
    'guard_name'=> 'web',
    'group_name'=> 'Utlisateur',
    ],
    //Store
    [
    'name'=> 'user.store',
    'guard_name'=> 'web',
    'group_name'=> 'Utlisateur',
    ],
    //Edit
    [
    'name'=> 'user.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Utlisateur',
    ],
    //Update
    [
    'name'=> 'user.update',
    'guard_name'=> 'web',
    'group_name'=> 'Utlisateur',
    ],
    //Delete
    [
    'name'=> 'user.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Utlisateur',
    ],

    //Restore
    [
        'name'=> 'user.restore',
        'guard_name'=> 'web',
        'group_name'=> 'Utlisateur',
        ],
        
    //Fore Delete
    [
        'name'=> 'user.fdelete',
        'guard_name'=> 'web',
        'group_name'=> 'Utlisateur',
        ],

        //Statut
    [
        'name'=> 'user.status',
        'guard_name'=> 'web',
        'group_name'=> 'Utlisateur',
        ],

        //Activité
    [
        'name'=> 'user.activite',
        'guard_name'=> 'web',
        'group_name'=> 'Utlisateur',
        ],

//Permission
//Menu
[
    'name'=> 'permission.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Permission',
    ],
    //Add
    [
    'name'=> 'permission.add',
    'guard_name'=> 'web',
    'group_name'=> 'Permission',
    ],
    //Store
    [
    'name'=> 'permission.store',
    'guard_name'=> 'web',
    'group_name'=> 'Permission',
    ],
    //Edit
    [
    'name'=> 'permission.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Permission',
    ],
    //Update
    [
    'name'=> 'permission.update',
    'guard_name'=> 'web',
    'group_name'=> 'Permission',
    ],
    //Delete
    [
    'name'=> 'permission.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Permission',
    ],

    // Role

    //Menu
[
    'name'=> 'roles.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Roles',
    ],
    //Add
    [
    'name'=> 'roles.add',
    'guard_name'=> 'web',
    'group_name'=> 'Roles',
    ],
    //Store
    [
    'name'=> 'roles.store',
    'guard_name'=> 'web',
    'group_name'=> 'Roles',
    ],
    //Edit
    [
    'name'=> 'roles.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Roles',
    ],
    //Update
    [
    'name'=> 'roles.update',
    'guard_name'=> 'web',
    'group_name'=> 'Roles',
    ],
    //Delete
    [
    'name'=> 'roles.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Roles',
    ],

    // Permission Par Roles

    //Menu
[
    'name'=> 'roles.permission.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Permissions Par Role',
    ],
    //Add
    [
    'name'=> 'roles.permission.add',
    'guard_name'=> 'web',
    'group_name'=> 'Permissions Par Role',
    ],
    //Store
    [
    'name'=> 'roles.permission.store',
    'guard_name'=> 'web',
    'group_name'=> 'Permissions Par Role',
    ],
    //Edit
    [
    'name'=> 'roles.permission.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Permissions Par Role',
    ],
    //Update
    [
    'name'=> 'roles.permission.update',
    'guard_name'=> 'web',
    'group_name'=> 'Permissions Par Role',
    ],
    //Delete
    [
    'name'=> 'roles.permission.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Permissions Par Role',
    ],


    //Gouvernerat 
    //Menu
[
    'name'=> 'gouv.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Gouvernerat',
    ],
    //Add
    [
    'name'=> 'gouv.add',
    'guard_name'=> 'web',
    'group_name'=> 'Gouvernerat',
    ],
    //Store
    [
    'name'=> 'gouv.store',
    'guard_name'=> 'web',
    'group_name'=> 'Gouvernerat',
    ],
    //Edit
    [
    'name'=> 'gouv.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Gouvernerat',
    ],
    //Update
    [
    'name'=> 'gouv.update',
    'guard_name'=> 'web',
    'group_name'=> 'Gouvernerat',
    ],
    //Delete
    [
    'name'=> 'gouv.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Gouvernerat',
    ],

    //Delegation
    //Menu
[
    'name'=> 'deleg.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Delegation',
    ],
    //Add
    [
    'name'=> 'deleg.add',
    'guard_name'=> 'web',
    'group_name'=> 'Delegation',
    ],
    //Store
    [
    'name'=> 'deleg.store',
    'guard_name'=> 'web',
    'group_name'=> 'Delegation',
    ],
    //Edit
    [
    'name'=> 'deleg.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Delegation',
    ],
    //Update
    [
    'name'=> 'deleg.update',
    'guard_name'=> 'web',
    'group_name'=> 'Delegation',
    ],
    //Delete
    [
    'name'=> 'deleg.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Delegation',
    ],
    //Secteur
    //Menu
[
    'name'=> 'sect.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Secteur',
    ],
    //Add
    [
    'name'=> 'sect.add',
    'guard_name'=> 'web',
    'group_name'=> 'Secteur',
    ],
    //Store
    [
    'name'=> 'sect.store',
    'guard_name'=> 'web',
    'group_name'=> 'Secteur',
    ],
    //Edit
    [
    'name'=> 'sect.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Secteur',
    ],
    //Update
    [
    'name'=> 'sect.update',
    'guard_name'=> 'web',
    'group_name'=> 'Secteur',
    ],
    //Delete
    [
    'name'=> 'sect.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Secteur',
    ],

    //Exploitant
    //Menu
[
    'name'=> 'exploi.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Exploitant',
    ],
    //Add
    [
    'name'=> 'exploi.add',
    'guard_name'=> 'web',
    'group_name'=> 'Exploitant',
    ],
    //Store
    [
    'name'=> 'exploi.store',
    'guard_name'=> 'web',
    'group_name'=> 'Exploitant',
    ],
    //Edit
    [
    'name'=> 'exploi.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Exploitant',
    ],
    //Update
    [
    'name'=> 'exploi.update',
    'guard_name'=> 'web',
    'group_name'=> 'Exploitant',
    ],
    //Delete
    [
    'name'=> 'exploi.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Exploitant',
    ],

    //Localisation
//Menu
[
    'name'=> 'local.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Localisation',
    ],
    //Add
    [
    'name'=> 'local.add',
    'guard_name'=> 'web',
    'group_name'=> 'Localisation',
    ],
    //Store
    [
    'name'=> 'local.store',
    'guard_name'=> 'web',
    'group_name'=> 'Localisation',
    ],
    //Edit
    [
    'name'=> 'local.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Localisation',
    ],
    //Update
    [
    'name'=> 'local.update',
    'guard_name'=> 'web',
    'group_name'=> 'Localisation',
    ],
    //Delete
    [
    'name'=> 'local.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Localisation',
    ],

    // Type de Demande
//Menu
[
    'name'=> 'typedemande.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Type de Demande',
    ],
    //Add
    [
    'name'=> 'typedemande.add',
    'guard_name'=> 'web',
    'group_name'=> 'Type de Demande',
    ],
    //Store
    [
    'name'=> 'typedemande.store',
    'guard_name'=> 'web',
    'group_name'=> 'Type de Demande',
    ],
    //Edit
    [
    'name'=> 'typedemande.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Type de Demande',
    ],
    //Update
    [
    'name'=> 'typedemande.update',
    'guard_name'=> 'web',
    'group_name'=> 'Type de Demande',
    ],
    //Delete
    [
    'name'=> 'typedemande.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Type de Demande',
    ],

    // Dossier de demande

    //Menu
[
    'name'=> 'dossier.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Dossier de demande',
    ],
    //Add
    [
    'name'=> 'dossier.add',
    'guard_name'=> 'web',
    'group_name'=> 'Dossier de demande',
    ],
    //Store
    [
    'name'=> 'dossier.store',
    'guard_name'=> 'web',
    'group_name'=> 'Dossier de demande',
    ],
    //Edit
    [
    'name'=> 'dossier.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Dossier de demande',
    ],
    //Update
    [
    'name'=> 'dossier.update',
    'guard_name'=> 'web',
    'group_name'=> 'Dossier de demande',
    ],
    //Delete
    [
    'name'=> 'dossier.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Dossier de demande',
    ],

    //Restore
    [
        'name'=> 'dossier.restore',
        'guard_name'=> 'web',
        'group_name'=> 'Dossier de demande',
        ],

    //Fore Delete
    [
        'name'=> 'dossier.fdelete',
        'guard_name'=> 'web',
        'group_name'=> 'Dossier de demande',
        ],

        

    //Adresse exploitant 

    //Menu
[
    'name'=> 'adresse.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Adresse Exploitant',
    ],
    //Add
    [
    'name'=> 'adresse.add',
    'guard_name'=> 'web',
    'group_name'=> 'Adresse Exploitant',
    ],
    //Store
    [
    'name'=> 'adresse.store',
    'guard_name'=> 'web',
    'group_name'=> 'Adresse Exploitant',
    ],
    //Edit
    [
    'name'=> 'adresse.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Adresse Exploitant',
    ],
    //Update
    [
    'name'=> 'adresse.update',
    'guard_name'=> 'web',
    'group_name'=> 'Adresse Exploitant',
    ],
    //Delete
    [
    'name'=> 'adresse.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Adresse Exploitant',
    ],

    //Commission
    //Menu
[
    'name'=> 'commission.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Commission',
    ],
    //Add
    [
    'name'=> 'commission.add',
    'guard_name'=> 'web',
    'group_name'=> 'Commission',
    ],
    //Store
    [
    'name'=> 'commission.store',
    'guard_name'=> 'web',
    'group_name'=> 'Commission',
    ],
    //Edit
    [
    'name'=> 'commission.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Commission',
    ],
    //Update
    [
    'name'=> 'commission.update',
    'guard_name'=> 'web',
    'group_name'=> 'Commission',
    ],
    //Delete
    [
    'name'=> 'commission.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Commission',
    ],
    //Avis de commission
    //Menu
[
    'name'=> 'avis.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Avis de Commission',
    ],
    //Add
    [
    'name'=> 'avis.add',
    'guard_name'=> 'web',
    'group_name'=> 'Avis de Commission',
    ],
    //Store
    [
    'name'=> 'avis.store',
    'guard_name'=> 'web',
    'group_name'=> 'Avis de Commission',
    ],
    //Edit
    [
    'name'=> 'avis.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Avis de Commission',
    ],
    //Update
    [
    'name'=> 'avis.update',
    'guard_name'=> 'web',
    'group_name'=> 'Avis de Commission',
    ],
    //Delete
    [
    'name'=> 'avis.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Avis de Commission',
    ],

    //Autorisation

    //Menu
[
    'name'=> 'autorisation.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Autorisation',
    ],
    //Add
    [
    'name'=> 'autorisation.add',
    'guard_name'=> 'web',
    'group_name'=> 'Autorisation',
    ],
    //Store
    [
    'name'=> 'autorisation.store',
    'guard_name'=> 'web',
    'group_name'=> 'Autorisation',
    ],
    //Edit
    [
    'name'=> 'autorisation.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Autorisation',
    ],
    //Update
    [
    'name'=> 'autorisation.update',
    'guard_name'=> 'web',
    'group_name'=> 'Autorisation',
    ],
    //Delete
    [
    'name'=> 'autorisation.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Autorisation',
    ],

    //Date Autorisation

    //Menu
[
    'name'=> 'dateau.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Date Autorisation',
    ],
    //Add
    [
    'name'=> 'dateau.add',
    'guard_name'=> 'web',
    'group_name'=> 'Date Autorisation',
    ],
    //Store
    [
    'name'=> 'dateau.store',
    'guard_name'=> 'web',
    'group_name'=> 'Date Autorisation',
    ],
    //Edit
    [
    'name'=> 'dateau.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Date Autorisation',
    ],
    //Update
    [
    'name'=> 'dateau.update',
    'guard_name'=> 'web',
    'group_name'=> 'Date Autorisation',
    ],
    //Delete
    [
    'name'=> 'dateau.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Date Autorisation',
    ],

    //Representant

    //Menu
[
    'name'=> 'representant.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Representant',
    ],
    //Add
    [
    'name'=> 'representant.add',
    'guard_name'=> 'web',
    'group_name'=> 'Representant',
    ],
    //Store
    [
    'name'=> 'representant.store',
    'guard_name'=> 'web',
    'group_name'=> 'Representant',
    ],
    //Edit
    [
    'name'=> 'representant.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Representant',
    ],
    //Update
    [
    'name'=> 'representant.update',
    'guard_name'=> 'web',
    'group_name'=> 'Representant',
    ],
    //Delete
    [
    'name'=> 'representant.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Representant',
    ],

    //Visite

    //Menu
[
    'name'=> 'visite.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Visite',
    ],
    //Add
    [
    'name'=> 'visite.add',
    'guard_name'=> 'web',
    'group_name'=> 'Visite',
    ],
    //Store
    [
    'name'=> 'visite.store',
    'guard_name'=> 'web',
    'group_name'=> 'Visite',
    ],
    //Edit
    [
    'name'=> 'visite.edit',
    'guard_name'=> 'web',
    'group_name'=> 'Visite',
    ],
    //Update
    [
    'name'=> 'visite.update',
    'guard_name'=> 'web',
    'group_name'=> 'Visite',
    ],
    //Delete
    [
    'name'=> 'visite.delete',
    'guard_name'=> 'web',
    'group_name'=> 'Visite',
    ],

    //Recherche
//Detail
 [
    'name'=> 'recherche.detail',
    'guard_name'=> 'web',
    'group_name'=> 'Recherche',
    ],
    //Detail
 [
    'name'=> 'recherche.menu',
    'guard_name'=> 'web',
    'group_name'=> 'Recherche',
    ],



        ]);
    }
}
