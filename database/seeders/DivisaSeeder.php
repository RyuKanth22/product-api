<?php

namespace Database\Seeders;

use App\Models\Divisa;
use Illuminate\Database\Seeder;

class DivisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Divisa::create(['name' => 'Dólar', 'symbol' => '$', 'exchange_rate' => 1.0]);
        Divisa::create(['name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.85]);
        Divisa::create(['name' => 'Yen Japonés', 'symbol' => '¥', 'exchange_rate' => 110.0]);
        Divisa::create(['name' => 'Libra Esterlina', 'symbol' => '£', 'exchange_rate' => 0.75]);
        Divisa::create(['name' => 'Peso Mexicano', 'symbol' => 'MXN', 'exchange_rate' => 20.0]);
        Divisa::create(['name' => 'Peso Argentino', 'symbol' => 'ARS', 'exchange_rate' => 100.0]);
        Divisa::create(['name' => 'Franco Suizo', 'symbol' => 'CHF', 'exchange_rate' => 0.92]);
        Divisa::create(['name' => 'Dólar Canadiense', 'symbol' => 'CAD', 'exchange_rate' => 1.25]);
        Divisa::create(['name' => 'Yuan Chino', 'symbol' => '¥', 'exchange_rate' => 6.5]);
        Divisa::create(['name' => 'Real Brasileño', 'symbol' => 'BRL', 'exchange_rate' => 5.4]);
    }
}
