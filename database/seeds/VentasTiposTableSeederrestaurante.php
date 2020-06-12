<?php

use Illuminate\Database\Seeder;
use App\VentasTipo;

class VentasTiposTableSeederRestaurante extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (VentasTipo::count() == 0) {
            VentasTipo::create(
                ['nombre' => 'Mesa', 'etiqueta' => 'success', 'descripcion' => 'Venta normal']
            );
            VentasTipo::create(
                ['nombre' => 'Para llevar', 'etiqueta' => 'primary', 'descripcion' => 'Venta para llevar']
            );
            VentasTipo::create(
                ['nombre' => 'Pedido', 'etiqueta' => 'danger', 'descripcion' => 'Pedido realizado']
            );
            VentasTipo::create(
                ['nombre' => 'A domicilio', 'etiqueta' => 'dark', 'descripcion' => 'Venta para llevar a domicilio']
            );
        }
    }
}
