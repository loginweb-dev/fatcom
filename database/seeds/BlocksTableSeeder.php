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
                'id' => 2,
                't_section_id' => 2,
                'order' => NULL,
                'created_at' => '2020-05-25 11:52:55',
                'updated_at' => '2020-05-25 11:52:55',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 3,
                't_section_id' => 3,
                'order' => NULL,
                'created_at' => '2020-05-25 12:04:06',
                'updated_at' => '2020-05-25 12:04:06',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 4,
                't_section_id' => 3,
                'order' => NULL,
                'created_at' => '2020-05-25 12:06:39',
                'updated_at' => '2020-05-25 12:06:39',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 5,
                't_section_id' => 3,
                'order' => NULL,
                'created_at' => '2020-05-25 12:06:44',
                'updated_at' => '2020-05-25 12:06:44',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 6,
                't_section_id' => 1,
                'order' => NULL,
                'created_at' => '2020-05-25 12:20:58',
                'updated_at' => '2020-05-25 12:20:58',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 8,
                't_section_id' => 5,
                'order' => NULL,
                'created_at' => '2020-05-25 17:00:36',
                'updated_at' => '2020-05-25 17:00:36',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 9,
                't_section_id' => 5,
                'order' => NULL,
                'created_at' => '2020-05-25 17:02:55',
                'updated_at' => '2020-05-25 17:02:55',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 10,
                't_section_id' => 5,
                'order' => NULL,
                'created_at' => '2020-05-25 17:03:22',
                'updated_at' => '2020-05-25 17:03:22',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 11,
                't_section_id' => 6,
                'order' => NULL,
                'created_at' => '2020-05-25 17:43:22',
                'updated_at' => '2020-05-25 17:43:22',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 12,
                't_section_id' => 7,
                'order' => NULL,
                'created_at' => '2020-05-25 17:54:55',
                'updated_at' => '2020-05-25 17:54:55',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 13,
                't_section_id' => 8,
                'order' => NULL,
                'created_at' => '2020-05-25 18:06:50',
                'updated_at' => '2020-05-25 18:06:50',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 14,
                't_section_id' => 9,
                'order' => NULL,
                'created_at' => '2020-05-25 18:16:02',
                'updated_at' => '2020-05-25 18:16:02',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 15,
                't_section_id' => 10,
                'order' => NULL,
                'created_at' => '2020-05-25 18:21:32',
                'updated_at' => '2020-05-25 18:21:32',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 16,
                't_section_id' => 11,
                'order' => NULL,
                'created_at' => '2020-05-25 18:28:08',
                'updated_at' => '2020-05-25 18:28:08',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}