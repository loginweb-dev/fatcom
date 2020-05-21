<?php

use Illuminate\Database\Seeder;

class BlockInputTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('t_block_input')->delete();
        
        \DB::table('t_block_input')->insert(array (
            0 => 
            array (
                'id' => 1,
                't_block_id' => 1,
                'name' => 'image',
                'type' => 'image',
                'value' => '../ecommerce_public/templates/ecommerce_v1/images/banners/banner1.png',
                'order' => NULL,
                'created_at' => '2020-05-16 17:46:54',
                'updated_at' => '2020-05-20 18:12:28',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                't_block_id' => 2,
                'name' => 'image',
                'type' => 'image',
                'value' => '../ecommerce_public/templates/ecommerce_v1/images/banners/banner2.png',
                'order' => NULL,
                'created_at' => '2020-05-16 17:47:00',
                'updated_at' => '2020-05-20 17:55:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                't_block_id' => 3,
                'name' => 'image',
                'type' => 'image',
                'value' => '../ecommerce_public/templates/ecommerce_v1/images/banners/banner3.png',
                'order' => NULL,
                'created_at' => '2020-05-16 17:47:03',
                'updated_at' => '2020-05-20 17:55:08',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                't_block_id' => 4,
                'name' => 'icon',
                'type' => 'icon',
                'value' => 'fa fa-truck',
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:13',
                'updated_at' => '2020-05-16 18:33:33',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                't_block_id' => 4,
                'name' => 'text',
                'type' => 'text',
                'value' => 'Entrega inmediata',
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:13',
                'updated_at' => '2020-05-16 18:32:20',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                't_block_id' => 4,
                'name' => 'long_text',
                'type' => 'long_text',
                'value' => 'Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore',
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:13',
                'updated_at' => '2020-05-16 18:32:35',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                't_block_id' => 5,
                'name' => 'icon',
                'type' => 'icon',
                'value' => 'fa fa-check-circle',
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:44',
                'updated_at' => '2020-05-16 18:33:56',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                't_block_id' => 5,
                'name' => 'text',
                'type' => 'text',
                'value' => 'Excelente calidad',
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:44',
                'updated_at' => '2020-05-16 18:32:57',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                't_block_id' => 5,
                'name' => 'long_text',
                'type' => 'long_text',
                'value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod',
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:44',
                'updated_at' => '2020-05-16 18:33:06',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                't_block_id' => 6,
                'name' => 'icon',
                'type' => 'icon',
                'value' => 'far fa-money-bill-alt',
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:47',
                'updated_at' => '2020-05-16 18:33:35',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                't_block_id' => 6,
                'name' => 'text',
                'type' => 'text',
                'value' => 'Precio justo',
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:47',
                'updated_at' => '2020-05-16 18:33:21',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                't_block_id' => 6,
                'name' => 'long_text',
                'type' => 'long_text',
                'value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod',
                'order' => NULL,
                'created_at' => '2020-05-16 17:48:47',
                'updated_at' => '2020-05-16 18:33:14',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}