<?php

use Illuminate\Database\Seeder;
use App\Cliente;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Cliente::count() == 0) {
            Cliente::create([
                'razon_social' => 'Sin nombre'
            ]);
        }
    }
}
