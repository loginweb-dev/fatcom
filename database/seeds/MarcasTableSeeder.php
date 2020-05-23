<?php

use Illuminate\Database\Seeder;
use App\Marca;

class MarcasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Marca::count() == 0) {
            Marca::create([
                'nombre' => 'Por defecto',
                'slug' => 'por-defecto'
            ]);
        }
    }
}
