<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@dental.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dr. Sarah Dental',
            'email' => 'doctor@dental.com',
            'password' => Hash::make('doctor123'),
            'role' => 'petugas',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Petugas Medis',
            'email' => 'petugas@dental.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'is_active' => true,
        ]);
    }
}