<?php

use Illuminate\Database\Seeder;
use App\Colore;

class ColoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Colore::count() == 0) {
            Colore::create([
                'nombre' => 'Por defecto'
            ]);
        }
    }
}
