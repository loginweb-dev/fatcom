<?php

use Illuminate\Database\Seeder;
use App\Localidade;

class LocalidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Localidade::count() == 0) {
            Localidade::create(['departamento' => 'Beni','localidad' => 'Santísima Trinidad','tiempo_estimado' => '1 hora','activo' => 1]);
            Localidade::create(['departamento' => 'Beni','localidad' => 'Guayaramerín','tiempo_estimado' => '2 días','activo' => 1]);
            Localidade::create(['departamento' => 'Beni','localidad' => 'Riberalta','tiempo_estimado' => '2 días','activo' => 1]);
        }
    }
}
