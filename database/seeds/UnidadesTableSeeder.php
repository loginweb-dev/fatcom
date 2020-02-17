<?php

use Illuminate\Database\Seeder;
use App\Unidade;

class UnidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Unidade::count() == 0) {
            Unidade::create(
                ['nombre' => 'Por defecto', 'abreviacion' => 'Df.']
            );
            Unidade::create(
                ['nombre' => 'Kilogramos', 'abreviacion' => 'Kg.'],
            );
            Unidade::create(
                ['nombre' => 'Litros', 'abreviacion' => 'Lt.'],
            );
            Unidade::create(
                ['nombre' => 'Piezas', 'abreviacion' => 'Pz.']
            );
        }
    }
}
