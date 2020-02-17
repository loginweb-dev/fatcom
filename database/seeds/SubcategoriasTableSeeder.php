<?php

use Illuminate\Database\Seeder;
use App\Subcategoria;

class SubcategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Subcategoria::count() == 0) {
            Subcategoria::create([
                'nombre' => 'Por defecto', 'descripcion' => 'NN', 'categoria_id' => 1
            ]);
        }
    }
}
