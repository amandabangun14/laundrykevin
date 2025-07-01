<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Cuci Reguler',
            'description' => 'Cuci pakaian biasa dengan estimasi 2-3 hari',
            'price_per_kg' => 7000,
            'estimated_days' => 3,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Cuci Express',
            'description' => 'Cuci pakaian cepat dengan estimasi 1 hari',
            'price_per_kg' => 12000,
            'estimated_days' => 1,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Cuci Premium',
            'description' => 'Cuci pakaian premium dengan perawatan khusus',
            'price_per_kg' => 15000,
            'estimated_days' => 2,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Setrika Saja',
            'description' => 'Hanya setrika tanpa cuci',
            'price_per_kg' => 5000,
            'estimated_days' => 1,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Cuci + Setrika',
            'description' => 'Cuci dan setrika lengkap',
            'price_per_kg' => 10000,
            'estimated_days' => 3,
            'is_active' => true,
        ]);
    }
}
