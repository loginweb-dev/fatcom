<?php

use Illuminate\Database\Seeder;

class FatcomRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        // \DB::table('roles')->truncate();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Administrator',
                'created_at' => '2019-05-13 22:44:14',
                'updated_at' => '2019-05-13 22:44:14',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'user',
                'display_name' => 'Normal User',
                'created_at' => '2019-05-13 22:44:14',
                'updated_at' => '2019-05-13 22:44:14',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'administrador',
                'display_name' => 'Administrador',
                'created_at' => '2019-06-19 23:35:30',
                'updated_at' => '2019-06-26 18:17:47',
            ),
            3 => 
            array (
                'id' => 4,
            'name' => 'Cajero(a)',
                'display_name' => 'cajero',
                'created_at' => '2019-06-22 20:08:12',
                'updated_at' => '2019-07-03 18:49:48',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Encargado de pedidos',
                'display_name' => 'encargado_pedidos',
                'created_at' => '2019-06-26 18:19:30',
                'updated_at' => '2019-07-03 18:50:46',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Cocina',
                'display_name' => 'cocina',
                'created_at' => '2019-07-03 18:59:47',
                'updated_at' => '2019-07-03 18:59:47',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Repartidor',
                'display_name' => 'repartidor',
                'created_at' => '2019-07-03 19:02:10',
                'updated_at' => '2019-07-03 19:02:10',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'contador',
                'display_name' => 'Contador',
                'created_at' => '2019-10-09 19:32:58',
                'updated_at' => '2019-10-09 19:32:58',
            ),
        ));
        
        
    }
}