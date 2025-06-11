<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Satu',
                'username' => '22RPI001',
                'email' => 'admin1@example.com',
                'password' => Hash::make('password'),
                'saldo' => 500000
            ],
            [
                'name' => 'Admin Dua',
                'username' => '32RPI002',
                'email' => 'admin2@example.com',
                'password' => Hash::make('password'),
                'saldo' => 300000
            ],
            [
                'name' => 'Admin Tiga',
                'username' => '52RPI003',
                'email' => 'admin3@example.com',
                'password' => Hash::make('password'),
                'saldo' => 150000
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
