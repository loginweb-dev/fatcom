<?php

use Illuminate\Database\Seeder;
use App\Sucursale;

class SucursalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Sucursale::count() == 0) {
            Sucursale::create(['nombre' => 'Casa matriz', 'latitud' => '-14.833232', 'longitud' => '-64.897004']);
        }
    }
}
