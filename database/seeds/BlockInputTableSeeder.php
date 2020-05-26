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
                'id' => 6,
                't_block_id' => 2,
                'name' => 'logo',
                'type' => 'image',
                'value' => '../ecommerce_public/templates/ecommerce_v1/images/icons/icon.png',
                'order' => NULL,
                'created_at' => '2020-05-25 11:52:55',
                'updated_at' => '2020-05-25 11:54:04',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 7,
                't_block_id' => 2,
                'name' => 'nombre',
                'type' => 'text',
                'value' => 'Fatom',
                'order' => NULL,
                'created_at' => '2020-05-25 11:52:55',
                'updated_at' => '2020-05-25 11:53:34',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 8,
                't_block_id' => 3,
                'name' => 'imagen',
                'type' => 'image',
                'value' => '../ecommerce_public/templates/ecommerce_v1/images/banners/banner1.png',
                'order' => NULL,
                'created_at' => '2020-05-25 12:04:06',
                'updated_at' => '2020-05-25 12:04:50',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 9,
                't_block_id' => 3,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Loren Ipsum',
                'order' => NULL,
                'created_at' => '2020-05-25 12:04:06',
                'updated_at' => '2020-05-25 12:05:02',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 10,
                't_block_id' => 3,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => 'Cum tempus eu tristique arcu nostra leo purus tortor integer etiam, himenaeos torquent facilisi molestie imperdiet posuere odio interdum duis enim congue',
                'order' => NULL,
                'created_at' => '2020-05-25 12:04:06',
                'updated_at' => '2020-05-25 12:05:40',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 11,
                't_block_id' => 4,
                'name' => 'imagen',
                'type' => 'image',
                'value' => '../ecommerce_public/templates/ecommerce_v1/images/banners/banner2.png',
                'order' => NULL,
                'created_at' => '2020-05-25 12:06:39',
                'updated_at' => '2020-05-25 12:07:21',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 12,
                't_block_id' => 4,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Loren Ipsum',
                'order' => NULL,
                'created_at' => '2020-05-25 12:06:40',
                'updated_at' => '2020-05-25 12:06:40',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 13,
                't_block_id' => 4,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => 'Cum tempus eu tristique arcu nostra leo purus tortor integer etiam, himenaeos torquent facilisi molestie imperdiet posuere odio interdum duis enim congue',
                'order' => NULL,
                'created_at' => '2020-05-25 12:06:40',
                'updated_at' => '2020-05-25 12:06:40',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 14,
                't_block_id' => 5,
                'name' => 'imagen',
                'type' => 'image',
                'value' => '../ecommerce_public/templates/ecommerce_v1/images/banners/banner3.png',
                'order' => NULL,
                'created_at' => '2020-05-25 12:06:44',
                'updated_at' => '2020-05-25 12:07:30',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 15,
                't_block_id' => 5,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Loren Ipsum',
                'order' => NULL,
                'created_at' => '2020-05-25 12:06:44',
                'updated_at' => '2020-05-25 12:06:44',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 16,
                't_block_id' => 5,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => 'Cum tempus eu tristique arcu nostra leo purus tortor integer etiam, himenaeos torquent facilisi molestie imperdiet posuere odio interdum duis enim congue',
                'order' => NULL,
                'created_at' => '2020-05-25 12:06:44',
                'updated_at' => '2020-05-25 12:06:44',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 17,
                't_block_id' => 6,
                'name' => 'titulo',
                'type' => 'text',
                'value' => NULL,
                'order' => NULL,
                'created_at' => '2020-05-25 12:20:58',
                'updated_at' => '2020-05-25 12:20:58',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 18,
                't_block_id' => 6,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => 'posuere odio interdum duis enim congue, faucibus ridiculus mauris curabitur blandit proin ut rutrum',
                'order' => NULL,
                'created_at' => '2020-05-25 12:20:58',
                'updated_at' => '2020-05-25 12:22:46',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 19,
                't_block_id' => 6,
                'name' => 'footer',
                'type' => 'text',
                'value' => '#QuédateEnCasa',
                'order' => NULL,
                'created_at' => '2020-05-25 12:20:58',
                'updated_at' => '2020-05-25 12:22:58',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 20,
                't_block_id' => 6,
                'name' => 'fondo',
                'type' => 'color',
                'value' => '#527fd6',
                'order' => NULL,
                'created_at' => '2020-05-25 12:20:58',
                'updated_at' => '2020-05-25 12:22:03',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 21,
                't_block_id' => 6,
                'name' => 'color',
                'type' => 'color',
                'value' => '#ffffff',
                'order' => NULL,
                'created_at' => '2020-05-25 12:20:58',
                'updated_at' => '2020-05-25 12:22:16',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 25,
                't_block_id' => 8,
                'name' => 'icono',
                'type' => 'icon',
                'value' => 'fa fa-check',
                'order' => NULL,
                'created_at' => '2020-05-25 17:00:36',
                'updated_at' => '2020-05-25 17:01:22',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 26,
                't_block_id' => 8,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Bueno',
                'order' => NULL,
                'created_at' => '2020-05-25 17:00:36',
                'updated_at' => '2020-05-25 17:01:17',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 27,
                't_block_id' => 8,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => 'molestie imperdiet posuere odio interdum duis enim congue interdum duis enim congue',
                'order' => NULL,
                'created_at' => '2020-05-25 17:00:36',
                'updated_at' => '2020-05-25 17:06:30',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 28,
                't_block_id' => 9,
                'name' => 'icono',
                'type' => 'icon',
                'value' => 'far fa-grin-stars',
                'order' => NULL,
                'created_at' => '2020-05-25 17:02:55',
                'updated_at' => '2020-05-25 17:06:06',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 29,
                't_block_id' => 9,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Bonito',
                'order' => NULL,
                'created_at' => '2020-05-25 17:02:55',
                'updated_at' => '2020-05-25 17:03:13',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 30,
                't_block_id' => 9,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => 'molestie imperdiet posuere odio interdum duis enim congue',
                'order' => NULL,
                'created_at' => '2020-05-25 17:02:55',
                'updated_at' => '2020-05-25 17:02:55',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 31,
                't_block_id' => 10,
                'name' => 'icono',
                'type' => 'icon',
                'value' => 'far fa-money-bill-alt',
                'order' => NULL,
                'created_at' => '2020-05-25 17:03:22',
                'updated_at' => '2020-05-25 17:05:32',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 32,
                't_block_id' => 10,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Barato',
                'order' => NULL,
                'created_at' => '2020-05-25 17:03:22',
                'updated_at' => '2020-05-25 17:03:30',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 33,
                't_block_id' => 10,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => 'molestie imperdiet posuere odio interdum duis enim congue congue congue',
                'order' => NULL,
                'created_at' => '2020-05-25 17:03:22',
                'updated_at' => '2020-05-25 17:06:45',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 34,
                't_block_id' => 11,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Ofertas',
                'order' => NULL,
                'created_at' => '2020-05-25 17:43:22',
                'updated_at' => '2020-05-25 17:43:54',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 35,
                't_block_id' => 11,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => NULL,
                'order' => NULL,
                'created_at' => '2020-05-25 17:43:22',
                'updated_at' => '2020-05-25 17:43:22',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 36,
                't_block_id' => 11,
                'name' => 'fondo',
                'type' => 'color',
                'value' => '#ffffff',
                'order' => NULL,
                'created_at' => '2020-05-25 17:43:22',
                'updated_at' => '2020-05-25 18:57:42',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 37,
                't_block_id' => 11,
                'name' => 'color',
                'type' => 'color',
                'value' => '#000000',
                'order' => NULL,
                'created_at' => '2020-05-25 17:43:22',
                'updated_at' => '2020-05-25 18:57:56',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 38,
                't_block_id' => 12,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Productos populares',
                'order' => NULL,
                'created_at' => '2020-05-25 17:54:55',
                'updated_at' => '2020-05-25 17:55:11',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 39,
                't_block_id' => 12,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => NULL,
                'order' => NULL,
                'created_at' => '2020-05-25 17:54:55',
                'updated_at' => '2020-05-25 17:54:55',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 40,
                't_block_id' => 12,
                'name' => 'fondo',
                'type' => 'color',
                'value' => '#ffffff',
                'order' => NULL,
                'created_at' => '2020-05-25 17:54:55',
                'updated_at' => '2020-05-25 18:59:41',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 41,
                't_block_id' => 12,
                'name' => 'color',
                'type' => 'color',
                'value' => '#212529',
                'order' => NULL,
                'created_at' => '2020-05-25 17:54:55',
                'updated_at' => '2020-05-25 18:59:54',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 42,
                't_block_id' => 13,
                'name' => 'imagen',
                'type' => 'image',
                'value' => '../ecommerce_public/templates/ecommerce_v1/images/banners/img1.jpg',
                'order' => NULL,
                'created_at' => '2020-05-25 18:06:50',
                'updated_at' => '2020-05-25 18:08:21',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 43,
                't_block_id' => 13,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Loren ipsum',
                'order' => NULL,
                'created_at' => '2020-05-25 18:06:50',
                'updated_at' => '2020-05-25 18:07:06',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 44,
                't_block_id' => 13,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => 'posuere odio interdum duis enim congue, faucibus ridiculus mauris curabitur blandit proin ut rutrum',
                'order' => NULL,
                'created_at' => '2020-05-25 18:06:50',
                'updated_at' => '2020-05-25 18:07:19',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 45,
                't_block_id' => 13,
                'name' => 'footer',
                'type' => 'text',
                'value' => 'posuere odio interdum duis enim congue, faucibus ridiculun',
                'order' => NULL,
                'created_at' => '2020-05-25 18:06:50',
                'updated_at' => '2020-05-25 18:07:34',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 46,
                't_block_id' => 13,
                'name' => 'fondo',
                'type' => 'color',
                'value' => '#5fb639',
                'order' => NULL,
                'created_at' => '2020-05-25 18:06:50',
                'updated_at' => '2020-05-25 18:08:09',
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 47,
                't_block_id' => 13,
                'name' => 'color',
                'type' => 'color',
                'value' => '#ffffff',
                'order' => NULL,
                'created_at' => '2020-05-25 18:06:50',
                'updated_at' => '2020-05-25 18:07:49',
                'deleted_at' => NULL,
            ),
            39 => 
            array (
                'id' => 48,
                't_block_id' => 14,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Más vendidos',
                'order' => NULL,
                'created_at' => '2020-05-25 18:16:02',
                'updated_at' => '2020-05-25 18:18:11',
                'deleted_at' => NULL,
            ),
            40 => 
            array (
                'id' => 49,
                't_block_id' => 14,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => NULL,
                'order' => NULL,
                'created_at' => '2020-05-25 18:16:02',
                'updated_at' => '2020-05-25 18:16:02',
                'deleted_at' => NULL,
            ),
            41 => 
            array (
                'id' => 50,
                't_block_id' => 14,
                'name' => 'fondo',
                'type' => 'color',
                'value' => '#eeeeee',
                'order' => NULL,
                'created_at' => '2020-05-25 18:16:02',
                'updated_at' => '2020-05-25 18:53:04',
                'deleted_at' => NULL,
            ),
            42 => 
            array (
                'id' => 51,
                't_block_id' => 14,
                'name' => 'color',
                'type' => 'color',
                'value' => '#ffffff',
                'order' => NULL,
                'created_at' => '2020-05-25 18:16:02',
                'updated_at' => '2020-05-25 18:16:28',
                'deleted_at' => NULL,
            ),
            43 => 
            array (
                'id' => 52,
                't_block_id' => 15,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Nuestras marcas',
                'order' => NULL,
                'created_at' => '2020-05-25 18:21:32',
                'updated_at' => '2020-05-25 18:24:24',
                'deleted_at' => NULL,
            ),
            44 => 
            array (
                'id' => 53,
                't_block_id' => 15,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => NULL,
                'order' => NULL,
                'created_at' => '2020-05-25 18:21:32',
                'updated_at' => '2020-05-25 18:21:32',
                'deleted_at' => NULL,
            ),
            45 => 
            array (
                'id' => 54,
                't_block_id' => 15,
                'name' => 'fondo',
                'type' => 'color',
                'value' => '#ffffff',
                'order' => NULL,
                'created_at' => '2020-05-25 18:21:32',
                'updated_at' => '2020-05-25 18:22:38',
                'deleted_at' => NULL,
            ),
            46 => 
            array (
                'id' => 55,
                't_block_id' => 15,
                'name' => 'color',
                'type' => 'color',
                'value' => '#000000',
                'order' => NULL,
                'created_at' => '2020-05-25 18:21:32',
                'updated_at' => '2020-05-25 18:22:48',
                'deleted_at' => NULL,
            ),
            47 => 
            array (
                'id' => 56,
                't_block_id' => 16,
                'name' => 'imagen',
                'type' => 'image',
                'value' => '../ecommerce_public/templates/ecommerce_v1/images/banners/img2.jpg',
                'order' => NULL,
                'created_at' => '2020-05-25 18:28:08',
                'updated_at' => '2020-05-25 18:28:18',
                'deleted_at' => NULL,
            ),
            48 => 
            array (
                'id' => 57,
                't_block_id' => 16,
                'name' => 'titulo',
                'type' => 'text',
                'value' => 'Loren ipsum',
                'order' => NULL,
                'created_at' => '2020-05-25 18:28:08',
                'updated_at' => '2020-05-25 18:28:25',
                'deleted_at' => NULL,
            ),
            49 => 
            array (
                'id' => 58,
                't_block_id' => 16,
                'name' => 'descripcion',
                'type' => 'long_text',
                'value' => 'posuere odio interdum duis enim congue, faucibus ridiculus mauris curabitur blandit proin ut rutrum',
                'order' => NULL,
                'created_at' => '2020-05-25 18:28:08',
                'updated_at' => '2020-05-25 18:28:35',
                'deleted_at' => NULL,
            ),
            50 => 
            array (
                'id' => 59,
                't_block_id' => 16,
                'name' => 'footer',
                'type' => 'text',
                'value' => 'posuere odio interdum duis enim congue, faucibus',
                'order' => NULL,
                'created_at' => '2020-05-25 18:28:08',
                'updated_at' => '2020-05-25 18:28:48',
                'deleted_at' => NULL,
            ),
            51 => 
            array (
                'id' => 60,
                't_block_id' => 16,
                'name' => 'fondo',
                'type' => 'color',
                'value' => '#e93e2c',
                'order' => NULL,
                'created_at' => '2020-05-25 18:28:08',
                'updated_at' => '2020-05-25 18:29:05',
                'deleted_at' => NULL,
            ),
            52 => 
            array (
                'id' => 61,
                't_block_id' => 16,
                'name' => 'color',
                'type' => 'color',
                'value' => '#ffffff',
                'order' => NULL,
                'created_at' => '2020-05-25 18:28:08',
                'updated_at' => '2020-05-25 18:29:11',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}