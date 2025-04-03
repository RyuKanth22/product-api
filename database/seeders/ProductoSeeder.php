<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producto::create(['name' => 'Producto A', 'description' => 'Descripción del producto A', 'price' => 100.0, 'divisa_id' => 1, 'tax_cost' => 5.0, 'manufacturing_cost' => 50.0]);
        Producto::create(['name' => 'Producto B', 'description' => 'Descripción del producto B', 'price' => 150.0, 'divisa_id' => 2, 'tax_cost' => 10.0, 'manufacturing_cost' => 80.0]);
        Producto::create(['name' => 'Producto C', 'description' => 'Descripción del producto C', 'price' => 200.0, 'divisa_id' => 3, 'tax_cost' => 15.0, 'manufacturing_cost' => 100.0]);
        Producto::create(['name' => 'Producto D', 'description' => 'Descripción del producto D', 'price' => 250.0, 'divisa_id' => 4, 'tax_cost' => 20.0, 'manufacturing_cost' => 120.0]);
        Producto::create(['name' => 'Producto E', 'description' => 'Descripción del producto E', 'price' => 300.0, 'divisa_id' => 5, 'tax_cost' => 25.0, 'manufacturing_cost' => 150.0]);
        Producto::create(['name' => 'Producto F', 'description' => 'Descripción del producto F', 'price' => 350.0, 'divisa_id' => 6, 'tax_cost' => 30.0, 'manufacturing_cost' => 170.0]);
        Producto::create(['name' => 'Producto G', 'description' => 'Descripción del producto G', 'price' => 400.0, 'divisa_id' => 7, 'tax_cost' => 35.0, 'manufacturing_cost' => 200.0]);
        Producto::create(['name' => 'Producto H', 'description' => 'Descripción del producto H', 'price' => 450.0, 'divisa_id' => 8, 'tax_cost' => 40.0, 'manufacturing_cost' => 220.0]);
        Producto::create(['name' => 'Producto I', 'description' => 'Descripción del producto I', 'price' => 500.0, 'divisa_id' => 9, 'tax_cost' => 45.0, 'manufacturing_cost' => 250.0]);
        Producto::create(['name' => 'Producto J', 'description' => 'Descripción del producto J', 'price' => 550.0, 'divisa_id' => 10, 'tax_cost' => 50.0, 'manufacturing_cost' => 280.0]);
    }
}
