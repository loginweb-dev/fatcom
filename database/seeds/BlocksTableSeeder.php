<?php

use Illuminate\Database\Seeder;

class BlocksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('t_blocks')->delete();
        
        \DB::table('t_blocks')->insert(array (
            0 => 
            array (
                'id' => 1,
                't_section_id' => 1,
                'order' => NULL,
                'created_at' => '2020-05-16 17:46:54',
                'updated_at' => '2020-05-16 17:46:54',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                't_section_id' => 1,
                'order' => NULL,
                'created_at' => '2020-05-16 17:47:00',
                'updated_at' => '2020-05-16 17:47:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                't_section_id' => 1,
                'order' => NULL,
                'created_at' => '2020-05-16 17:47:03',
                'updated_at' => '2020-05-16 17:47:03',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                't_section_id' => 2,
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:13',
                'updated_at' => '2020-05-16 17:48:13',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                't_section_id' => 2,
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:44',
                'updated_at' => '2020-05-16 17:48:44',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                't_section_id' => 2,
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:47',
                'updated_at' => '2020-05-16 17:48:47',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}