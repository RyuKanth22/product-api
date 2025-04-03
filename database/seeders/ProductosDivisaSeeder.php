<?php

namespace Database\Seeders;

use App\Models\ProductosDivisa;
use Illuminate\Database\Seeder;

class ProductosDivisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ProductosDivisa::create(['producto_id' => 1, 'divisa_id' => 1, 'price' => 100.0]);
        ProductosDivisa::create(['producto_id' => 1, 'divisa_id' => 2, 'price' => 85.0]);
        ProductosDivisa::create(['producto_id' => 1, 'divisa_id' => 3, 'price' => 110.0]);
        ProductosDivisa::create(['producto_id' => 2, 'divisa_id' => 1, 'price' => 150.0]);
        ProductosDivisa::create(['producto_id' => 2, 'divisa_id' => 2, 'price' => 127.5]);
        ProductosDivisa::create(['producto_id' => 2, 'divisa_id' => 3, 'price' => 165.0]);
        ProductosDivisa::create(['producto_id' => 3, 'divisa_id' => 1, 'price' => 200.0]);
        ProductosDivisa::create(['producto_id' => 3, 'divisa_id' => 2, 'price' => 170.0]);
        ProductosDivisa::create(['producto_id' => 3, 'divisa_id' => 3, 'price' => 220.0]);
        ProductosDivisa::create(['producto_id' => 4, 'divisa_id' => 1, 'price' => 250.0]);
    
    }
}
