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
            ['nombre' => 'Electrónica', 'descripcion' => 'Artículos de electrónica y accesorios', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Muebles', 'descripcion' => 'Sillas, mesas y otros muebles', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gaming', 'descripcion' => 'Accesorios y dispositivos para gamers', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Almacenamiento', 'descripcion' => 'Dispositivos de almacenamiento', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
