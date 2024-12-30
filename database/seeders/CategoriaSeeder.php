<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Sábanas', 'descripcion' => 'Sábanas de diferentes tamaños y materiales', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Colchas', 'descripcion' => 'Colchas para camas de todos los tamaños', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Toallas', 'descripcion' => 'Toallas de baño, mano y playa', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Almohadas', 'descripcion' => 'Almohadas de diferentes tipos y tamaños', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Pijamas', 'descripcion' => 'Pijamas para todas las edades y géneros', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Pantalonetas de Baño', 'descripcion' => 'Pantalonetas de baño para hombres y mujeres', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Camisetas de Algodón', 'descripcion' => 'Camisetas de algodón de alta calidad', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
    }
}
