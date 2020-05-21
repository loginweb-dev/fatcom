<?php

use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('t_templates')->delete();
        
        \DB::table('t_templates')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Por defecto',
                'description' => 'Plantilla por defecto del Ecommerce.',
                'created_at' => '2020-05-16 17:46:54',
                'updated_at' => '2020-05-16 17:46:54',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Tienda Bootstrap 4',
                'description' => 'Plantilla de tienda en general Bootstrap 4.',
                'created_at' => '2020-05-16 17:47:00',
                'updated_at' => '2020-05-16 17:47:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Restaurante mdbootstrap',
                'description' => 'Plantilla de restaurante mdboostrap.',
                'created_at' => '2020-05-16 17:47:03',
                'updated_at' => '2020-05-16 17:47:03',
                'deleted_at' => NULL,
            ),
        ));
    }
}
