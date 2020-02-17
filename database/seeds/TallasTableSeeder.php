<?php

use Illuminate\Database\Seeder;
use App\Talla;

class TallasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Talla::count() == 0) {
            Talla::create([
                'nombre' => 'Por defecto', 'tamanio_id' => 1
            ]);
        }
    }
}
