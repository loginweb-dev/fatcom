<?php

use Illuminate\Database\Seeder;
use App\Genero;

class GenerosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Genero::count() == 0) {
            Genero::create([
                'nombre' => 'Por defecto'
            ]);
        }
    }
}
