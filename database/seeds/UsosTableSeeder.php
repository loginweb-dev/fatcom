<?php

use Illuminate\Database\Seeder;
use App\Uso;

class UsosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Uso::count() == 0) {
            Uso::create([
                'nombre' => 'Por defecto', 'descripcion' => 'NN'
            ]);
        }
    }
}
