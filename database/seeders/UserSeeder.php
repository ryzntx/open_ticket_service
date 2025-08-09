<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@unsub.ac.id',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ],
            [
                'name' => 'Agent 1',
                'email' => 'agent1@unsub.ac.id',
                'password' => bcrypt('agent123'),
                'email_verified_at' => now(),
                'role' => 'agent',
            ],
        ];

        foreach ($users as $user) {
            $userModel = \App\Models\User::create($user);
            // sync user  with categories if needed
            $userModel->categories()->sync([1, 2]); // Example of syncing categories
        }
    }
}
