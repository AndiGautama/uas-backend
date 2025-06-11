<?php
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'saldo' => 100000,
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Penerima Satu',
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'saldo' => 50000,
            'role' => 'user',
        ]);
    }
}