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
            14 => 
            array (
                'id' => 17,
                't_section_id' => 12,
                'order' => NULL,
                'created_at' => '2020-05-26 16:24:22',
                'updated_at' => '2020-05-26 16:24:22',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 21,
                't_section_id' => 16,
                'order' => NULL,
                'created_at' => '2020-05-26 17:06:10',
                'updated_at' => '2020-05-26 17:06:10',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 22,
                't_section_id' => 18,
                'order' => NULL,
                'created_at' => '2020-05-26 17:15:18',
                'updated_at' => '2020-05-26 17:15:18',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 23,
                't_section_id' => 19,
                'order' => NULL,
                'created_at' => '2020-05-26 17:18:37',
                'updated_at' => '2020-05-26 17:18:37',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 24,
                't_section_id' => 17,
                'order' => NULL,
                'created_at' => '2020-05-26 17:36:07',
                'updated_at' => '2020-05-26 17:36:07',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 25,
                't_section_id' => 17,
                'order' => NULL,
                'created_at' => '2020-05-26 17:39:15',
                'updated_at' => '2020-05-26 17:39:15',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 26,
                't_section_id' => 17,
                'order' => NULL,
                'created_at' => '2020-05-26 17:39:22',
                'updated_at' => '2020-05-26 17:39:22',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 27,
                't_section_id' => 21,
                'order' => NULL,
                'created_at' => '2020-05-27 15:42:53',
                'updated_at' => '2020-05-27 15:42:53',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 28,
                't_section_id' => 22,
                'order' => NULL,
                'created_at' => '2020-05-27 15:50:25',
                'updated_at' => '2020-05-27 15:50:25',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}