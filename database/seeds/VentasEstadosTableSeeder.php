<?php

use Illuminate\Database\Seeder;
use App\VentasEstado;

class VentasEstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (VentasEstado::count() == 0) {
            VentasEstado::create(
                ['nombre' => 'Pedido realizado', 'etiqueta' => 'warning', 'icono' => '']
            );
            VentasEstado::create(
                ['nombre' => 'En preparación', 'etiqueta' => 'info', 'icono' => 'voyager-alarm-clock']
            );
            VentasEstado::create(
                ['nombre' => 'Listo', 'etiqueta' => 'success', 'icono' => 'voyager-check']
            );
            VentasEstado::create(
                ['nombre' => 'Enviado', 'etiqueta' => 'dark', 'icono' => 'voyager-rocket']
            );
            VentasEstado::create(
                ['nombre' => 'Entregado', 'etiqueta' => 'primary', 'icono' => 'voyager-basket']
            );
        }
    }
}
