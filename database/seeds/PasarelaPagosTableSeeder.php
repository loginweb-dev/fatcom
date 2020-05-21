<?php

use Illuminate\Database\Seeder;

class PasarelaPagosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pasarela_pagos')->delete();
        
        \DB::table('pasarela_pagos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Contra entrega',
                'descripcion' => 'El cobro se realizará al momento de la entrega.',
                'icono' => '../img/assets/upon-delivery.png',
                'estado' => 1,
                'created_at' => '2020-05-20 20:01:35',
                'updated_at' => '2020-05-20 20:01:35',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}