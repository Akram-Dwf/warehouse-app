<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin (Akses Penuh)
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gudang.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'is_approved' => true,
        ]);

        // 2. Akun Warehouse Manager (Kepala Gudang)
        User::create([
            'name' => 'Manager Gudang',
            'email' => 'manager@gudang.com',
            'role' => 'manager',
            'password' => Hash::make('password'),
            'is_approved' => true,
        ]);

        // 3. Akun Staff Gudang (Pekerja)
        User::create([
            'name' => 'Staff Gudang 1',
            'email' => 'staff@gudang.com',
            'role' => 'staff',
            'password' => Hash::make('password'),
            'is_approved' => true,
        ]);

        User::create([
            'name' => 'Staff Gudang 2',
            'email' => 'staff2@gudang.com',
            'role' => 'staff',
            'password' => Hash::make('password'),
            'is_approved' => true,
        ]);

        // 4. Akun Supplier (Contoh Mitra)
        User::create([
            'name' => 'PT Supplier Jaya',
            'email' => 'supplier@pt.com',
            'role' => 'supplier',
            'password' => Hash::make('password'),
            'is_approved' => true,
        ]);
    }
}