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
                'name' => 'Banner',
                'description' => 'Slider de imágenes para banner.',
                'created_at' => '2020-05-16 17:46:54',
                'updated_at' => '2020-05-16 17:46:54',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                't_page_id' => 1,
                'name' => 'Panel de información',
                'description' => 'Información descriptiva del servicio.',
                'created_at' => '2020-05-16 17:47:00',
                'updated_at' => '2020-05-16 17:47:00',
                'deleted_at' => NULL,
            ),
        ));
    }
}
