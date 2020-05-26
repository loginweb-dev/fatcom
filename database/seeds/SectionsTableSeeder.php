<?php

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('t_sections')->delete();
        
        \DB::table('t_sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                't_page_id' => 1,
                'name' => 'alerta superior',
                'description' => 'Alerta en la parte superior de la página',
                'order' => 1,
                'visible' => 1,
                'created_at' => '2020-05-25 00:00:00',
                'updated_at' => '2020-05-25 12:33:26',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                't_page_id' => 1,
                'name' => 'menu',
                'description' => 'menú principal',
                'order' => 2,
                'visible' => 1,
                'created_at' => '2020-05-25 11:52:14',
                'updated_at' => '2020-05-25 11:52:14',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                't_page_id' => 1,
                'name' => 'slider',
                'description' => 'Carrusel de imágenes para el banner de la página',
                'order' => 3,
                'visible' => 1,
                'created_at' => '2020-05-25 12:02:47',
                'updated_at' => '2020-05-25 12:02:47',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 5,
                't_page_id' => 1,
                'name' => 'Panel de información',
                'description' => NULL,
                'order' => 4,
                'visible' => 1,
                'created_at' => '2020-05-25 12:32:41',
                'updated_at' => '2020-05-25 12:32:41',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 6,
                't_page_id' => 1,
                'name' => 'ofertas',
                'description' => NULL,
                'order' => 5,
                'visible' => 1,
                'created_at' => '2020-05-25 17:42:44',
                'updated_at' => '2020-05-25 17:42:44',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 7,
                't_page_id' => 1,
                'name' => 'populares',
                'description' => NULL,
                'order' => 6,
                'visible' => 1,
                'created_at' => '2020-05-25 17:54:23',
                'updated_at' => '2020-05-25 17:54:23',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 8,
                't_page_id' => 1,
                'name' => 'sección de información',
                'description' => NULL,
                'order' => 7,
                'visible' => 1,
                'created_at' => '2020-05-25 18:05:36',
                'updated_at' => '2020-05-25 18:05:36',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 9,
                't_page_id' => 1,
                'name' => 'Productos más vendidos',
                'description' => NULL,
                'order' => 8,
                'visible' => 1,
                'created_at' => '2020-05-25 18:15:30',
                'updated_at' => '2020-05-25 18:21:00',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 10,
                't_page_id' => 1,
                'name' => 'Marcas',
                'description' => NULL,
                'order' => 9,
                'visible' => 1,
                'created_at' => '2020-05-25 18:21:08',
                'updated_at' => '2020-05-25 18:22:12',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 11,
                't_page_id' => 1,
                'name' => 'Sección de información',
                'description' => NULL,
                'order' => 10,
                'visible' => 1,
                'created_at' => '2020-05-25 18:27:06',
                'updated_at' => '2020-05-25 18:27:06',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}
