<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolehasPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [];

    $role_id = '1';
    
    for ($permission_id = 1; $permission_id <= 124; $permission_id++) {
        $data[] = [
            'permission_id' => (string)$permission_id,
            'role_id' => $role_id,
        ];
    }

    // Maintenant, insérez les données dans la table role_has_permissions
    DB::table('role_has_permissions')->insert($data);
}
}
