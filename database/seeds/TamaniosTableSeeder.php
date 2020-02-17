<?php

use Illuminate\Database\Seeder;
use App\Tamanio;

class TamaniosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Tamanio::count() == 0) {
            Tamanio::create([
                'nombre' => 'Por defecto', 'descripcion' => 'NN'
            ]);
        }
    }
}
