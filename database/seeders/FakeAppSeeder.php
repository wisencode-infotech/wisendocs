<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class FakeAppSeeder extends Seeder
{
    /**
     * Seed the application's database for fake entries. specially for test setup.
     */
    public function run(): void
    {
        // User roles seeder

        UserRole::insert([
            [
                'id' => 1,
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
        
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@wisendocs.com',
            'password' => Hash::make('master@wisendocs121'),
            'user_role_id' => 1
        ]);

        User::factory(10)->create([
            'user_role_id' => 1,
            'password' => Hash::make('wisendoc_test'),
        ]);

        $this->call([
            FakeVersionSeeder::class,
            FakeTopicSeeder::class,
            FakeTopicBlockSeeder::class,
        ]);

    } 
}
