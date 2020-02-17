<?php

use Illuminate\Database\Seeder;
use App\Categoria;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Categoria::count() == 0) {
            Categoria::create([
                'nombre' => 'Por defecto',
                'descripcion' => 'NN'
            ]);
        }
    }
}
