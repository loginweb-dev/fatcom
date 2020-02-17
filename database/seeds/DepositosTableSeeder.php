<?php

use Illuminate\Database\Seeder;
use App\Deposito;

class DepositosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Deposito::count() == 0) {
            Deposito::create([
                'nombre' => 'Deposito - Casa Matriz',
                'direccion' => 'NN',
                'sucursal_id' => 1,
                'inventario' => 1
            ]);
        }
    }
}
