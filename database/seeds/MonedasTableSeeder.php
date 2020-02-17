<?php

use Illuminate\Database\Seeder;
use App\Moneda;

class MonedasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Moneda::count() == 0) {
            Moneda::create(['nombre' => 'Por defecto', 'abreviacion' => 'Df.']);
            Moneda::create(['nombre' => 'Bolivanos', 'abreviacion' => 'Bs.']);
            Moneda::create(['nombre' => 'Dolares', 'abreviacion' => '$us.']);
        }
    }
}
