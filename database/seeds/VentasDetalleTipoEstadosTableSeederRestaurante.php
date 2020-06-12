<?php

use Illuminate\Database\Seeder;
use App\VentasDetalleTipoEstado;

class VentasDetalleTipoEstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (VentasDetalleTipoEstado::count() == 0) {
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 1, 'venta_estado_id' => 2]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 1, 'venta_estado_id' => 3]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 1, 'venta_estado_id' => 5]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 2, 'venta_estado_id' => 2]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 2, 'venta_estado_id' => 3]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 2, 'venta_estado_id' => 5]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 3, 'venta_estado_id' => 1]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 3, 'venta_estado_id' => 2]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 3, 'venta_estado_id' => 3]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 3, 'venta_estado_id' => 4]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 3, 'venta_estado_id' => 5]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 4, 'venta_estado_id' => 2]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 4, 'venta_estado_id' => 3]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 4, 'venta_estado_id' => 4]
            );
            VentasDetalleTipoEstado::create(
                ['venta_tipo_id' => 4, 'venta_estado_id' => 5]
            );
        }
    }
}
