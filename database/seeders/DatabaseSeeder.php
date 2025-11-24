<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        User::create([
            'name' => 'Admin Laboratorium',
            'email' => 'admin@lab.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        // Create Dosen
        User::create([
            'name' => 'Dr. Ahmad, M.Kom',
            'email' => 'ahmad@ptik.com',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
            'department' => 'Pendidikan Teknik Informatika'
        ]);

        // Create Mahasiswa
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@student.ptik.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'nim' => '20210001',
            'department' => 'Pendidikan Teknik Informatika'
        ]);

        // Create Sample Items
        Item::create([
            'name' => 'Laptop ASUS ROG',
            'description' => 'Laptop gaming untuk praktikum programming',
            'quantity' => 5,
            'category' => 'elektronik',
            'location' => 'Lab Komputer 1',
            'condition' => 'good',
            'is_available' => true
        ]);

        Item::create([
            'name' => 'Microcontroller Arduino',
            'description' => 'Untuk praktikum IoT dan embedded system',
            'quantity' => 20,
            'category' => 'elektronik',
            'location' => 'Lab Elektronika',
            'condition' => 'good',
            'is_available' => true
        ]);

        Item::create([
            'name' => 'Proyektor Epson',
            'description' => 'Proyektor untuk presentasi dan pembelajaran',
            'quantity' => 3,
            'category' => 'alat',
            'location' => 'Gudang Alat',
            'condition' => 'good',
            'is_available' => true
        ]);
    }
}