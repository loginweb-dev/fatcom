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
        ));
    }
}
