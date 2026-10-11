<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Gracia Meilanie',
                'email' => 'admin@toko.test',
                'role' => 'admin',
            ],
            [
                'name' => 'Dina Maharani',
                'email' => 'editor@toko.test',
                'role' => 'editor',
            ],
            [
                'name' => 'Nadia Putri',
                'email' => 'user1@toko.test',
                'role' => 'user',
            ],
            [
                'name' => 'Rizky Saputra',
                'email' => 'user2@toko.test',
                'role' => 'user',
            ],
            [
                'name' => 'Fajar Ramadhan',
                'email' => 'user3@toko.test',
                'role' => 'user',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => $data['role'],
                ]
            );
        }

        $this->command->info('UserSeeder DONE');
    }
}