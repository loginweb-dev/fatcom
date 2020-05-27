<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('t_pages')->delete();
        
        \DB::table('t_pages')->insert(array (
            0 => 
            array (
                'id' => 1,
                't_template_id' => 2,
                'name' => 'Inicio',
                'description' => 'Página de inicio.',
                'created_at' => '2020-05-16 17:46:54',
                'updated_at' => '2020-05-16 17:46:54',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                't_template_id' => 2,
                'name' => 'Métodos de pago',
                'description' => NULL,
                'created_at' => '2020-05-26 16:57:40',
                'updated_at' => '2020-05-26 16:57:40',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                't_template_id' => 2,
                'name' => 'Búsqueda',
                'description' => NULL,
                'created_at' => '2020-05-26 17:14:26',
                'updated_at' => '2020-05-26 17:14:26',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                't_template_id' => 2,
                'name' => 'Carrito de compra',
                'description' => NULL,
                'created_at' => '2020-05-26 17:18:01',
                'updated_at' => '2020-05-26 17:18:01',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                't_template_id' => 2,
                'name' => 'Pedidos',
                'description' => NULL,
                'created_at' => '2020-05-27 15:42:20',
                'updated_at' => '2020-05-27 15:42:20',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                't_template_id' => 2,
                'name' => 'Detalles de producto',
                'description' => NULL,
                'created_at' => '2020-05-27 15:49:47',
                'updated_at' => '2020-05-27 15:49:47',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}
