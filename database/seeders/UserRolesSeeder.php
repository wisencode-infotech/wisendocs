<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    public function run()
    {
        $roles = ['Admin'];

        foreach ($roles as $role) {
            DB::table('user_roles')->updateOrInsert(['role' => $role], ['created_at' => now(), 'updated_at' => now()]);
        }
    }
}
