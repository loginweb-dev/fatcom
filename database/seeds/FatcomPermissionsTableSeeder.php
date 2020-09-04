<?php

use Illuminate\Database\Seeder;

class FatcomPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'browse_admin',
                'table_name' => NULL,
                'created_at' => '2019-05-13 22:44:14',
                'updated_at' => '2019-05-13 22:44:14',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'browse_bread',
                'table_name' => NULL,
                'created_at' => '2019-05-13 22:44:14',
                'updated_at' => '2019-05-13 22:44:14',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'browse_database',
                'table_name' => NULL,
                'created_at' => '2019-05-13 22:44:14',
                'updated_at' => '2019-05-13 22:44:14',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'browse_media',
                'table_name' => NULL,
                'created_at' => '2019-05-13 22:44:14',
                'updated_at' => '2019-05-13 22:44:14',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'browse_compass',
                'table_name' => NULL,
                'created_at' => '2019-05-13 22:44:14',
                'updated_at' => '2019-05-13 22:44:14',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'browse_menus',
                'table_name' => 'menus',
                'created_at' => '2019-05-13 22:44:14',
                'updated_at' => '2019-05-13 22:44:14',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'read_menus',
                'table_name' => 'menus',
                'created_at' => '2019-05-13 22:44:15',
                'updated_at' => '2019-05-13 22:44:15',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'edit_menus',
                'table_name' => 'menus',
                'created_at' => '2019-05-13 22:44:15',
                'updated_at' => '2019-05-13 22:44:15',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'add_menus',
                'table_name' => 'menus',
                'created_at' => '2019-05-13 22:44:15',
                'updated_at' => '2019-05-13 22:44:15',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => 'delete_menus',
                'table_name' => 'menus',
                'created_at' => '2019-05-13 22:44:15',
                'updated_at' => '2019-05-13 22:44:15',
            ),
            10 => 
            array (
                'id' => 11,
                'key' => 'browse_roles',
                'table_name' => 'roles',
                'created_at' => '2019-05-13 22:44:15',
                'updated_at' => '2019-05-13 22:44:15',
            ),
            11 => 
            array (
                'id' => 12,
                'key' => 'read_roles',
                'table_name' => 'roles',
                'created_at' => '2019-05-13 22:44:15',
                'updated_at' => '2019-05-13 22:44:15',
            ),
            12 => 
            array (
                'id' => 13,
                'key' => 'edit_roles',
                'table_name' => 'roles',
                'created_at' => '2019-05-13 22:44:16',
                'updated_at' => '2019-05-13 22:44:16',
            ),
            13 => 
            array (
                'id' => 14,
                'key' => 'add_roles',
                'table_name' => 'roles',
                'created_at' => '2019-05-13 22:44:16',
                'updated_at' => '2019-05-13 22:44:16',
            ),
            14 => 
            array (
                'id' => 15,
                'key' => 'delete_roles',
                'table_name' => 'roles',
                'created_at' => '2019-05-13 22:44:16',
                'updated_at' => '2019-05-13 22:44:16',
            ),
            15 => 
            array (
                'id' => 16,
                'key' => 'browse_users',
                'table_name' => 'users',
                'created_at' => '2019-05-13 22:44:17',
                'updated_at' => '2019-05-13 22:44:17',
            ),
            16 => 
            array (
                'id' => 17,
                'key' => 'read_users',
                'table_name' => 'users',
                'created_at' => '2019-05-13 22:44:17',
                'updated_at' => '2019-05-13 22:44:17',
            ),
            17 => 
            array (
                'id' => 18,
                'key' => 'edit_users',
                'table_name' => 'users',
                'created_at' => '2019-05-13 22:44:17',
                'updated_at' => '2019-05-13 22:44:17',
            ),
            18 => 
            array (
                'id' => 19,
                'key' => 'add_users',
                'table_name' => 'users',
                'created_at' => '2019-05-13 22:44:17',
                'updated_at' => '2019-05-13 22:44:17',
            ),
            19 => 
            array (
                'id' => 20,
                'key' => 'delete_users',
                'table_name' => 'users',
                'created_at' => '2019-05-13 22:44:18',
                'updated_at' => '2019-05-13 22:44:18',
            ),
            20 => 
            array (
                'id' => 21,
                'key' => 'browse_settings',
                'table_name' => 'settings',
                'created_at' => '2019-05-13 22:44:18',
                'updated_at' => '2019-05-13 22:44:18',
            ),
            21 => 
            array (
                'id' => 22,
                'key' => 'read_settings',
                'table_name' => 'settings',
                'created_at' => '2019-05-13 22:44:18',
                'updated_at' => '2019-05-13 22:44:18',
            ),
            22 => 
            array (
                'id' => 23,
                'key' => 'edit_settings',
                'table_name' => 'settings',
                'created_at' => '2019-05-13 22:44:18',
                'updated_at' => '2019-05-13 22:44:18',
            ),
            23 => 
            array (
                'id' => 24,
                'key' => 'add_settings',
                'table_name' => 'settings',
                'created_at' => '2019-05-13 22:44:18',
                'updated_at' => '2019-05-13 22:44:18',
            ),
            24 => 
            array (
                'id' => 25,
                'key' => 'delete_settings',
                'table_name' => 'settings',
                'created_at' => '2019-05-13 22:44:19',
                'updated_at' => '2019-05-13 22:44:19',
            ),
            25 => 
            array (
                'id' => 26,
                'key' => 'browse_categories',
                'table_name' => 'categories',
                'created_at' => '2019-05-13 22:44:33',
                'updated_at' => '2019-05-13 22:44:33',
            ),
            26 => 
            array (
                'id' => 27,
                'key' => 'read_categories',
                'table_name' => 'categories',
                'created_at' => '2019-05-13 22:44:33',
                'updated_at' => '2019-05-13 22:44:33',
            ),
            27 => 
            array (
                'id' => 28,
                'key' => 'edit_categories',
                'table_name' => 'categories',
                'created_at' => '2019-05-13 22:44:33',
                'updated_at' => '2019-05-13 22:44:33',
            ),
            28 => 
            array (
                'id' => 29,
                'key' => 'add_categories',
                'table_name' => 'categories',
                'created_at' => '2019-05-13 22:44:33',
                'updated_at' => '2019-05-13 22:44:33',
            ),
            29 => 
            array (
                'id' => 30,
                'key' => 'delete_categories',
                'table_name' => 'categories',
                'created_at' => '2019-05-13 22:44:33',
                'updated_at' => '2019-05-13 22:44:33',
            ),
            30 => 
            array (
                'id' => 31,
                'key' => 'browse_posts',
                'table_name' => 'posts',
                'created_at' => '2019-05-13 22:44:37',
                'updated_at' => '2019-05-13 22:44:37',
            ),
            31 => 
            array (
                'id' => 32,
                'key' => 'read_posts',
                'table_name' => 'posts',
                'created_at' => '2019-05-13 22:44:37',
                'updated_at' => '2019-05-13 22:44:37',
            ),
            32 => 
            array (
                'id' => 33,
                'key' => 'edit_posts',
                'table_name' => 'posts',
                'created_at' => '2019-05-13 22:44:37',
                'updated_at' => '2019-05-13 22:44:37',
            ),
            33 => 
            array (
                'id' => 34,
                'key' => 'add_posts',
                'table_name' => 'posts',
                'created_at' => '2019-05-13 22:44:37',
                'updated_at' => '2019-05-13 22:44:37',
            ),
            34 => 
            array (
                'id' => 35,
                'key' => 'delete_posts',
                'table_name' => 'posts',
                'created_at' => '2019-05-13 22:44:37',
                'updated_at' => '2019-05-13 22:44:37',
            ),
            35 => 
            array (
                'id' => 36,
                'key' => 'browse_pages',
                'table_name' => 'pages',
                'created_at' => '2019-05-13 22:44:38',
                'updated_at' => '2019-05-13 22:44:38',
            ),
            36 => 
            array (
                'id' => 37,
                'key' => 'read_pages',
                'table_name' => 'pages',
                'created_at' => '2019-05-13 22:44:38',
                'updated_at' => '2019-05-13 22:44:38',
            ),
            37 => 
            array (
                'id' => 38,
                'key' => 'edit_pages',
                'table_name' => 'pages',
                'created_at' => '2019-05-13 22:44:38',
                'updated_at' => '2019-05-13 22:44:38',
            ),
            38 => 
            array (
                'id' => 39,
                'key' => 'add_pages',
                'table_name' => 'pages',
                'created_at' => '2019-05-13 22:44:39',
                'updated_at' => '2019-05-13 22:44:39',
            ),
            39 => 
            array (
                'id' => 40,
                'key' => 'delete_pages',
                'table_name' => 'pages',
                'created_at' => '2019-05-13 22:44:39',
                'updated_at' => '2019-05-13 22:44:39',
            ),
            40 => 
            array (
                'id' => 41,
                'key' => 'browse_hooks',
                'table_name' => NULL,
                'created_at' => '2019-05-13 22:44:44',
                'updated_at' => '2019-05-13 22:44:44',
            ),
            41 => 
            array (
                'id' => 42,
                'key' => 'browse_permissions',
                'table_name' => 'permissions',
                'created_at' => '2019-05-14 00:22:04',
                'updated_at' => '2019-05-14 00:22:04',
            ),
            42 => 
            array (
                'id' => 43,
                'key' => 'read_permissions',
                'table_name' => 'permissions',
                'created_at' => '2019-05-14 00:22:04',
                'updated_at' => '2019-05-14 00:22:04',
            ),
            43 => 
            array (
                'id' => 44,
                'key' => 'edit_permissions',
                'table_name' => 'permissions',
                'created_at' => '2019-05-14 00:22:04',
                'updated_at' => '2019-05-14 00:22:04',
            ),
            44 => 
            array (
                'id' => 45,
                'key' => 'add_permissions',
                'table_name' => 'permissions',
                'created_at' => '2019-05-14 00:22:04',
                'updated_at' => '2019-05-14 00:22:04',
            ),
            45 => 
            array (
                'id' => 46,
                'key' => 'delete_permissions',
                'table_name' => 'permissions',
                'created_at' => '2019-05-14 00:22:04',
                'updated_at' => '2019-05-14 00:22:04',
            ),
            46 => 
            array (
                'id' => 47,
                'key' => 'browse_sucursales',
                'table_name' => 'sucursales',
                'created_at' => '2019-05-18 14:13:59',
                'updated_at' => '2019-05-18 14:13:59',
            ),
            47 => 
            array (
                'id' => 48,
                'key' => 'add_sucursales',
                'table_name' => 'sucursales',
                'created_at' => '2019-05-18 14:14:18',
                'updated_at' => '2019-05-18 14:14:18',
            ),
            48 => 
            array (
                'id' => 49,
                'key' => 'edit_sucursales',
                'table_name' => 'sucursales',
                'created_at' => '2019-05-18 14:14:31',
                'updated_at' => '2019-05-18 14:14:31',
            ),
            49 => 
            array (
                'id' => 50,
                'key' => 'delete_sucursales',
                'table_name' => 'sucursales',
                'created_at' => '2019-05-18 14:14:44',
                'updated_at' => '2019-05-18 14:14:44',
            ),
            50 => 
            array (
                'id' => 62,
                'key' => 'browse_categorias',
                'table_name' => 'categorias',
                'created_at' => '2019-05-18 18:42:50',
                'updated_at' => '2019-05-18 18:42:50',
            ),
            51 => 
            array (
                'id' => 63,
                'key' => 'read_categorias',
                'table_name' => 'categorias',
                'created_at' => '2019-05-18 18:42:50',
                'updated_at' => '2019-05-18 18:42:50',
            ),
            52 => 
            array (
                'id' => 64,
                'key' => 'edit_categorias',
                'table_name' => 'categorias',
                'created_at' => '2019-05-18 18:42:50',
                'updated_at' => '2019-05-18 18:42:50',
            ),
            53 => 
            array (
                'id' => 65,
                'key' => 'add_categorias',
                'table_name' => 'categorias',
                'created_at' => '2019-05-18 18:42:50',
                'updated_at' => '2019-05-18 18:42:50',
            ),
            54 => 
            array (
                'id' => 66,
                'key' => 'delete_categorias',
                'table_name' => 'categorias',
                'created_at' => '2019-05-18 18:42:50',
                'updated_at' => '2019-05-18 18:42:50',
            ),
            55 => 
            array (
                'id' => 67,
                'key' => 'browse_depositos',
                'table_name' => 'depositos',
                'created_at' => '2019-05-18 19:09:31',
                'updated_at' => '2019-05-18 19:09:31',
            ),
            56 => 
            array (
                'id' => 68,
                'key' => 'read_depositos',
                'table_name' => 'depositos',
                'created_at' => '2019-05-18 19:17:14',
                'updated_at' => '2019-07-04 22:18:02',
            ),
            57 => 
            array (
                'id' => 69,
                'key' => 'add_depositos',
                'table_name' => 'depositos',
                'created_at' => '2019-05-18 19:17:27',
                'updated_at' => '2019-05-18 19:17:52',
            ),
            58 => 
            array (
                'id' => 70,
                'key' => 'edit_depositos',
                'table_name' => 'depositos',
                'created_at' => '2019-05-18 19:18:05',
                'updated_at' => '2019-05-18 19:18:05',
            ),
            59 => 
            array (
                'id' => 71,
                'key' => 'delete_depositos',
                'table_name' => 'depositos',
                'created_at' => '2019-05-18 19:18:16',
                'updated_at' => '2019-05-18 19:18:16',
            ),
            60 => 
            array (
                'id' => 77,
                'key' => 'browse_unidades',
                'table_name' => 'unidades',
                'created_at' => '2019-05-20 18:15:00',
                'updated_at' => '2019-05-20 18:15:00',
            ),
            61 => 
            array (
                'id' => 78,
                'key' => 'read_unidades',
                'table_name' => 'unidades',
                'created_at' => '2019-05-20 18:15:00',
                'updated_at' => '2019-05-20 18:15:00',
            ),
            62 => 
            array (
                'id' => 79,
                'key' => 'edit_unidades',
                'table_name' => 'unidades',
                'created_at' => '2019-05-20 18:15:00',
                'updated_at' => '2019-05-20 18:15:00',
            ),
            63 => 
            array (
                'id' => 80,
                'key' => 'add_unidades',
                'table_name' => 'unidades',
                'created_at' => '2019-05-20 18:15:00',
                'updated_at' => '2019-05-20 18:15:00',
            ),
            64 => 
            array (
                'id' => 81,
                'key' => 'delete_unidades',
                'table_name' => 'unidades',
                'created_at' => '2019-05-20 18:15:00',
                'updated_at' => '2019-05-20 18:15:00',
            ),
            65 => 
            array (
                'id' => 82,
                'key' => 'browse_marcas',
                'table_name' => 'marcas',
                'created_at' => '2019-05-20 18:21:55',
                'updated_at' => '2019-05-20 18:21:55',
            ),
            66 => 
            array (
                'id' => 83,
                'key' => 'read_marcas',
                'table_name' => 'marcas',
                'created_at' => '2019-05-20 18:21:55',
                'updated_at' => '2019-05-20 18:21:55',
            ),
            67 => 
            array (
                'id' => 84,
                'key' => 'edit_marcas',
                'table_name' => 'marcas',
                'created_at' => '2019-05-20 18:21:55',
                'updated_at' => '2019-05-20 18:21:55',
            ),
            68 => 
            array (
                'id' => 85,
                'key' => 'add_marcas',
                'table_name' => 'marcas',
                'created_at' => '2019-05-20 18:21:55',
                'updated_at' => '2019-05-20 18:21:55',
            ),
            69 => 
            array (
                'id' => 86,
                'key' => 'delete_marcas',
                'table_name' => 'marcas',
                'created_at' => '2019-05-20 18:21:55',
                'updated_at' => '2019-05-20 18:21:55',
            ),
            70 => 
            array (
                'id' => 87,
                'key' => 'browse_tallas',
                'table_name' => 'tallas',
                'created_at' => '2019-05-20 18:26:56',
                'updated_at' => '2019-05-20 18:26:56',
            ),
            71 => 
            array (
                'id' => 88,
                'key' => 'read_tallas',
                'table_name' => 'tallas',
                'created_at' => '2019-05-20 18:26:56',
                'updated_at' => '2019-05-20 18:26:56',
            ),
            72 => 
            array (
                'id' => 89,
                'key' => 'edit_tallas',
                'table_name' => 'tallas',
                'created_at' => '2019-05-20 18:26:56',
                'updated_at' => '2019-05-20 18:26:56',
            ),
            73 => 
            array (
                'id' => 90,
                'key' => 'add_tallas',
                'table_name' => 'tallas',
                'created_at' => '2019-05-20 18:26:56',
                'updated_at' => '2019-05-20 18:26:56',
            ),
            74 => 
            array (
                'id' => 91,
                'key' => 'delete_tallas',
                'table_name' => 'tallas',
                'created_at' => '2019-05-20 18:26:56',
                'updated_at' => '2019-05-20 18:26:56',
            ),
            75 => 
            array (
                'id' => 92,
                'key' => 'browse_tamanios',
                'table_name' => 'tamanios',
                'created_at' => '2019-05-20 18:28:40',
                'updated_at' => '2019-05-20 18:28:40',
            ),
            76 => 
            array (
                'id' => 93,
                'key' => 'read_tamanios',
                'table_name' => 'tamanios',
                'created_at' => '2019-05-20 18:28:40',
                'updated_at' => '2019-05-20 18:28:40',
            ),
            77 => 
            array (
                'id' => 94,
                'key' => 'edit_tamanios',
                'table_name' => 'tamanios',
                'created_at' => '2019-05-20 18:28:40',
                'updated_at' => '2019-05-20 18:28:40',
            ),
            78 => 
            array (
                'id' => 95,
                'key' => 'add_tamanios',
                'table_name' => 'tamanios',
                'created_at' => '2019-05-20 18:28:40',
                'updated_at' => '2019-05-20 18:28:40',
            ),
            79 => 
            array (
                'id' => 96,
                'key' => 'delete_tamanios',
                'table_name' => 'tamanios',
                'created_at' => '2019-05-20 18:28:40',
                'updated_at' => '2019-05-20 18:28:40',
            ),
            80 => 
            array (
                'id' => 97,
                'key' => 'browse_colores',
                'table_name' => 'colores',
                'created_at' => '2019-05-20 18:35:23',
                'updated_at' => '2019-05-20 18:35:23',
            ),
            81 => 
            array (
                'id' => 98,
                'key' => 'read_colores',
                'table_name' => 'colores',
                'created_at' => '2019-05-20 18:35:23',
                'updated_at' => '2019-05-20 18:35:23',
            ),
            82 => 
            array (
                'id' => 99,
                'key' => 'edit_colores',
                'table_name' => 'colores',
                'created_at' => '2019-05-20 18:35:23',
                'updated_at' => '2019-05-20 18:35:23',
            ),
            83 => 
            array (
                'id' => 100,
                'key' => 'add_colores',
                'table_name' => 'colores',
                'created_at' => '2019-05-20 18:35:23',
                'updated_at' => '2019-05-20 18:35:23',
            ),
            84 => 
            array (
                'id' => 101,
                'key' => 'delete_colores',
                'table_name' => 'colores',
                'created_at' => '2019-05-20 18:35:23',
                'updated_at' => '2019-05-20 18:35:23',
            ),
            85 => 
            array (
                'id' => 102,
                'key' => 'browse_generos',
                'table_name' => 'generos',
                'created_at' => '2019-05-20 18:59:35',
                'updated_at' => '2019-05-20 18:59:35',
            ),
            86 => 
            array (
                'id' => 103,
                'key' => 'read_generos',
                'table_name' => 'generos',
                'created_at' => '2019-05-20 18:59:35',
                'updated_at' => '2019-05-20 18:59:35',
            ),
            87 => 
            array (
                'id' => 104,
                'key' => 'edit_generos',
                'table_name' => 'generos',
                'created_at' => '2019-05-20 18:59:35',
                'updated_at' => '2019-05-20 18:59:35',
            ),
            88 => 
            array (
                'id' => 105,
                'key' => 'add_generos',
                'table_name' => 'generos',
                'created_at' => '2019-05-20 18:59:35',
                'updated_at' => '2019-05-20 18:59:35',
            ),
            89 => 
            array (
                'id' => 106,
                'key' => 'delete_generos',
                'table_name' => 'generos',
                'created_at' => '2019-05-20 18:59:35',
                'updated_at' => '2019-05-20 18:59:35',
            ),
            90 => 
            array (
                'id' => 107,
                'key' => 'browse_productos',
                'table_name' => 'productos',
                'created_at' => '2019-05-20 19:29:46',
                'updated_at' => '2019-05-20 19:29:46',
            ),
            91 => 
            array (
                'id' => 108,
                'key' => 'read_productos',
                'table_name' => 'productos',
                'created_at' => '2019-05-20 19:30:04',
                'updated_at' => '2019-07-04 22:17:48',
            ),
            92 => 
            array (
                'id' => 109,
                'key' => 'add_productos',
                'table_name' => 'productos',
                'created_at' => '2019-05-20 19:30:14',
                'updated_at' => '2019-05-20 19:30:14',
            ),
            93 => 
            array (
                'id' => 110,
                'key' => 'edit_productos',
                'table_name' => 'productos',
                'created_at' => '2019-05-20 19:30:25',
                'updated_at' => '2019-05-20 19:30:25',
            ),
            94 => 
            array (
                'id' => 111,
                'key' => 'delete_productos',
                'table_name' => 'productos',
                'created_at' => '2019-05-20 19:30:36',
                'updated_at' => '2019-05-20 19:30:36',
            ),
            95 => 
            array (
                'id' => 112,
                'key' => 'read_sucursales',
                'table_name' => 'sucursales',
                'created_at' => '2019-05-20 19:36:13',
                'updated_at' => '2019-07-04 22:17:33',
            ),
            96 => 
            array (
                'id' => 113,
                'key' => 'browse_usos',
                'table_name' => 'usos',
                'created_at' => '2019-05-20 21:02:15',
                'updated_at' => '2019-05-20 21:02:15',
            ),
            97 => 
            array (
                'id' => 114,
                'key' => 'read_usos',
                'table_name' => 'usos',
                'created_at' => '2019-05-20 21:02:15',
                'updated_at' => '2019-05-20 21:02:15',
            ),
            98 => 
            array (
                'id' => 115,
                'key' => 'edit_usos',
                'table_name' => 'usos',
                'created_at' => '2019-05-20 21:02:15',
                'updated_at' => '2019-05-20 21:02:15',
            ),
            99 => 
            array (
                'id' => 116,
                'key' => 'add_usos',
                'table_name' => 'usos',
                'created_at' => '2019-05-20 21:02:15',
                'updated_at' => '2019-05-20 21:02:15',
            ),
            100 => 
            array (
                'id' => 117,
                'key' => 'delete_usos',
                'table_name' => 'usos',
                'created_at' => '2019-05-20 21:02:15',
                'updated_at' => '2019-05-20 21:02:15',
            ),
            101 => 
            array (
                'id' => 118,
                'key' => 'add_producto_depositos',
                'table_name' => 'depositos',
                'created_at' => '2019-05-22 16:17:37',
                'updated_at' => '2019-05-22 16:17:37',
            ),
            102 => 
            array (
                'id' => 124,
                'key' => 'browse_monedas',
                'table_name' => 'monedas',
                'created_at' => '2019-05-22 22:29:41',
                'updated_at' => '2019-05-22 22:29:41',
            ),
            103 => 
            array (
                'id' => 125,
                'key' => 'read_monedas',
                'table_name' => 'monedas',
                'created_at' => '2019-05-22 22:29:41',
                'updated_at' => '2019-05-22 22:29:41',
            ),
            104 => 
            array (
                'id' => 126,
                'key' => 'edit_monedas',
                'table_name' => 'monedas',
                'created_at' => '2019-05-22 22:29:41',
                'updated_at' => '2019-05-22 22:29:41',
            ),
            105 => 
            array (
                'id' => 127,
                'key' => 'add_monedas',
                'table_name' => 'monedas',
                'created_at' => '2019-05-22 22:29:41',
                'updated_at' => '2019-05-22 22:29:41',
            ),
            106 => 
            array (
                'id' => 128,
                'key' => 'delete_monedas',
                'table_name' => 'monedas',
                'created_at' => '2019-05-22 22:29:41',
                'updated_at' => '2019-05-22 22:29:41',
            ),
            107 => 
            array (
                'id' => 134,
                'key' => 'browse_ofertas',
                'table_name' => 'ofertas',
                'created_at' => '2019-05-27 17:32:50',
                'updated_at' => '2019-05-27 17:32:50',
            ),
            108 => 
            array (
                'id' => 135,
                'key' => 'read_ofertas',
                'table_name' => 'ofertas',
                'created_at' => '2019-05-27 17:33:05',
                'updated_at' => '2019-07-04 22:17:18',
            ),
            109 => 
            array (
                'id' => 136,
                'key' => 'add_ofertas',
                'table_name' => 'ofertas',
                'created_at' => '2019-05-27 17:33:34',
                'updated_at' => '2019-05-27 17:33:34',
            ),
            110 => 
            array (
                'id' => 137,
                'key' => 'edit_ofertas',
                'table_name' => 'ofertas',
                'created_at' => '2019-05-27 17:33:49',
                'updated_at' => '2019-05-27 17:33:49',
            ),
            111 => 
            array (
                'id' => 138,
                'key' => 'delete_ofertas',
                'table_name' => 'ofertas',
                'created_at' => '2019-05-27 17:34:05',
                'updated_at' => '2019-05-27 17:34:05',
            ),
            112 => 
            array (
                'id' => 139,
                'key' => 'browse_ecommerce',
                'table_name' => 'ecommerce',
                'created_at' => '2019-05-28 16:37:12',
                'updated_at' => '2019-05-28 16:37:12',
            ),
            113 => 
            array (
                'id' => 140,
                'key' => 'read_ecommerce',
                'table_name' => 'ecommerce',
                'created_at' => '2019-05-28 16:37:27',
                'updated_at' => '2019-07-04 22:17:04',
            ),
            114 => 
            array (
                'id' => 141,
                'key' => 'add_ecommerce',
                'table_name' => 'ecommerce',
                'created_at' => '2019-05-28 16:37:42',
                'updated_at' => '2019-05-28 16:37:42',
            ),
            115 => 
            array (
                'id' => 142,
                'key' => 'edit_ecommerce',
                'table_name' => 'ecommerce',
                'created_at' => '2019-05-28 16:37:55',
                'updated_at' => '2019-05-28 16:37:55',
            ),
            116 => 
            array (
                'id' => 143,
                'key' => 'delete_ecommerce',
                'table_name' => 'ecommerce',
                'created_at' => '2019-05-28 16:38:10',
                'updated_at' => '2019-05-28 16:38:10',
            ),
            117 => 
            array (
                'id' => 144,
                'key' => 'browse_cajas',
                'table_name' => 'cajas',
                'created_at' => '2019-06-14 16:35:45',
                'updated_at' => '2019-06-14 16:35:45',
            ),
            118 => 
            array (
                'id' => 145,
                'key' => 'add_cajas',
                'table_name' => 'cajas',
                'created_at' => '2019-06-14 16:36:00',
                'updated_at' => '2019-06-14 16:36:00',
            ),
            119 => 
            array (
                'id' => 146,
                'key' => 'read_cajas',
                'table_name' => 'cajas',
                'created_at' => '2019-06-14 16:36:20',
                'updated_at' => '2019-07-04 22:16:37',
            ),
            120 => 
            array (
                'id' => 147,
                'key' => 'close_cajas',
                'table_name' => 'cajas',
                'created_at' => '2019-06-14 17:22:23',
                'updated_at' => '2019-06-14 17:22:23',
            ),
            121 => 
            array (
                'id' => 148,
                'key' => 'browse_asientos',
                'table_name' => 'asientos',
                'created_at' => '2019-06-14 19:13:40',
                'updated_at' => '2019-06-14 19:13:40',
            ),
            122 => 
            array (
                'id' => 149,
                'key' => 'add_asientos',
                'table_name' => 'asientos',
                'created_at' => '2019-06-14 19:14:16',
                'updated_at' => '2019-06-14 19:14:16',
            ),
            123 => 
            array (
                'id' => 150,
                'key' => 'delete_asientos',
                'table_name' => 'asientos',
                'created_at' => '2019-06-14 19:14:27',
                'updated_at' => '2019-06-14 19:14:27',
            ),
            124 => 
            array (
                'id' => 151,
                'key' => 'browse_insumos',
                'table_name' => 'insumos',
                'created_at' => '2019-06-14 21:19:56',
                'updated_at' => '2019-06-14 21:19:56',
            ),
            125 => 
            array (
                'id' => 152,
                'key' => 'read_insumos',
                'table_name' => 'insumos',
                'created_at' => '2019-06-14 21:19:56',
                'updated_at' => '2019-06-14 21:19:56',
            ),
            126 => 
            array (
                'id' => 153,
                'key' => 'edit_insumos',
                'table_name' => 'insumos',
                'created_at' => '2019-06-14 21:19:56',
                'updated_at' => '2019-06-14 21:19:56',
            ),
            127 => 
            array (
                'id' => 154,
                'key' => 'add_insumos',
                'table_name' => 'insumos',
                'created_at' => '2019-06-14 21:19:56',
                'updated_at' => '2019-06-14 21:19:56',
            ),
            128 => 
            array (
                'id' => 155,
                'key' => 'delete_insumos',
                'table_name' => 'insumos',
                'created_at' => '2019-06-14 21:19:56',
                'updated_at' => '2019-06-14 21:19:56',
            ),
            129 => 
            array (
                'id' => 156,
                'key' => 'browse_compras',
                'table_name' => 'compras',
                'created_at' => '2019-06-18 18:33:12',
                'updated_at' => '2019-06-18 18:33:12',
            ),
            130 => 
            array (
                'id' => 157,
                'key' => 'read_compras',
                'table_name' => 'compras',
                'created_at' => '2019-06-18 18:33:26',
                'updated_at' => '2019-07-04 22:16:23',
            ),
            131 => 
            array (
                'id' => 158,
                'key' => 'add_compras',
                'table_name' => 'compras',
                'created_at' => '2019-06-18 18:33:39',
                'updated_at' => '2019-06-18 18:33:39',
            ),
            132 => 
            array (
                'id' => 159,
                'key' => 'edit_compras',
                'table_name' => 'compras',
                'created_at' => '2019-06-18 18:33:52',
                'updated_at' => '2019-06-18 18:33:52',
            ),
            133 => 
            array (
                'id' => 160,
                'key' => 'delete_compras',
                'table_name' => 'compras',
                'created_at' => '2019-06-18 18:34:06',
                'updated_at' => '2019-06-18 18:34:06',
            ),
            134 => 
            array (
                'id' => 161,
                'key' => 'browse_proveedores',
                'table_name' => 'proveedores',
                'created_at' => '2019-06-18 21:32:00',
                'updated_at' => '2019-06-18 21:32:00',
            ),
            135 => 
            array (
                'id' => 162,
                'key' => 'read_proveedores',
                'table_name' => 'proveedores',
                'created_at' => '2019-06-18 21:32:00',
                'updated_at' => '2019-06-18 21:32:00',
            ),
            136 => 
            array (
                'id' => 163,
                'key' => 'edit_proveedores',
                'table_name' => 'proveedores',
                'created_at' => '2019-06-18 21:32:00',
                'updated_at' => '2019-06-18 21:32:00',
            ),
            137 => 
            array (
                'id' => 164,
                'key' => 'add_proveedores',
                'table_name' => 'proveedores',
                'created_at' => '2019-06-18 21:32:00',
                'updated_at' => '2019-06-18 21:32:00',
            ),
            138 => 
            array (
                'id' => 165,
                'key' => 'delete_proveedores',
                'table_name' => 'proveedores',
                'created_at' => '2019-06-18 21:32:00',
                'updated_at' => '2019-06-18 21:32:00',
            ),
            139 => 
            array (
                'id' => 171,
                'key' => 'browse_ventas',
                'table_name' => 'ventas',
                'created_at' => '2019-06-19 15:13:30',
                'updated_at' => '2019-06-19 15:13:30',
            ),
            140 => 
            array (
                'id' => 172,
                'key' => 'read_ventas',
                'table_name' => 'ventas',
                'created_at' => '2019-06-19 15:13:45',
                'updated_at' => '2019-07-04 22:16:09',
            ),
            141 => 
            array (
                'id' => 173,
                'key' => 'add_ventas',
                'table_name' => 'ventas',
                'created_at' => '2019-06-19 15:14:03',
                'updated_at' => '2019-06-19 15:14:03',
            ),
            142 => 
            array (
                'id' => 174,
                'key' => 'update_ventas',
                'table_name' => 'ventas',
                'created_at' => '2019-06-19 15:14:18',
                'updated_at' => '2019-06-19 15:14:18',
            ),
            143 => 
            array (
                'id' => 175,
                'key' => 'delete_ventas',
                'table_name' => 'ventas',
                'created_at' => '2019-06-19 15:14:33',
                'updated_at' => '2019-06-19 15:14:33',
            ),
            144 => 
            array (
                'id' => 181,
                'key' => 'browse_pasarela_pagos',
                'table_name' => 'pasarela_pagos',
                'created_at' => '2019-06-20 22:23:35',
                'updated_at' => '2019-06-20 22:23:35',
            ),
            145 => 
            array (
                'id' => 182,
                'key' => 'read_pasarela_pagos',
                'table_name' => 'pasarela_pagos',
                'created_at' => '2019-06-20 22:23:35',
                'updated_at' => '2019-06-20 22:23:35',
            ),
            146 => 
            array (
                'id' => 183,
                'key' => 'edit_pasarela_pagos',
                'table_name' => 'pasarela_pagos',
                'created_at' => '2019-06-20 22:23:35',
                'updated_at' => '2019-06-20 22:23:35',
            ),
            147 => 
            array (
                'id' => 184,
                'key' => 'add_pasarela_pagos',
                'table_name' => 'pasarela_pagos',
                'created_at' => '2019-06-20 22:23:35',
                'updated_at' => '2019-06-20 22:23:35',
            ),
            148 => 
            array (
                'id' => 185,
                'key' => 'delete_pasarela_pagos',
                'table_name' => 'pasarela_pagos',
                'created_at' => '2019-06-20 22:23:35',
                'updated_at' => '2019-06-20 22:23:35',
            ),
            149 => 
            array (
                'id' => 191,
                'key' => 'browse_repartidordelivery',
                'table_name' => 'delivery',
                'created_at' => '2019-06-22 20:33:23',
                'updated_at' => '2019-08-10 16:51:15',
            ),
            150 => 
            array (
                'id' => 192,
                'key' => 'browse_clientes',
                'table_name' => 'clientes',
                'created_at' => '2019-07-04 22:09:03',
                'updated_at' => '2019-07-04 22:09:03',
            ),
            151 => 
            array (
                'id' => 193,
                'key' => 'read_clientes',
                'table_name' => 'clientes',
                'created_at' => '2019-07-04 22:36:08',
                'updated_at' => '2019-07-04 22:36:08',
            ),
            152 => 
            array (
                'id' => 194,
                'key' => 'add_clientes',
                'table_name' => 'clientes',
                'created_at' => '2019-07-04 22:36:26',
                'updated_at' => '2019-07-04 22:36:26',
            ),
            153 => 
            array (
                'id' => 195,
                'key' => 'edit_clientes',
                'table_name' => 'clientes',
                'created_at' => '2019-07-04 22:36:42',
                'updated_at' => '2019-07-04 22:36:42',
            ),
            154 => 
            array (
                'id' => 196,
                'key' => 'delete_clientes',
                'table_name' => 'clientes',
                'created_at' => '2019-07-04 22:37:02',
                'updated_at' => '2019-07-04 22:37:02',
            ),
            155 => 
            array (
                'id' => 197,
                'key' => 'browse_empleados',
                'table_name' => 'empleados',
                'created_at' => '2019-07-05 19:27:02',
                'updated_at' => '2019-07-05 19:27:02',
            ),
            156 => 
            array (
                'id' => 198,
                'key' => 'read_empleados',
                'table_name' => 'empleados',
                'created_at' => '2019-07-05 19:27:15',
                'updated_at' => '2019-07-05 19:27:15',
            ),
            157 => 
            array (
                'id' => 199,
                'key' => 'add_empleados',
                'table_name' => 'empleados',
                'created_at' => '2019-07-05 19:27:28',
                'updated_at' => '2019-07-05 19:27:28',
            ),
            158 => 
            array (
                'id' => 200,
                'key' => 'edit_empleados',
                'table_name' => 'empleados',
                'created_at' => '2019-07-05 19:27:41',
                'updated_at' => '2019-07-05 19:27:41',
            ),
            159 => 
            array (
                'id' => 201,
                'key' => 'delete_empleados',
                'table_name' => 'empleados',
                'created_at' => '2019-07-05 19:27:54',
                'updated_at' => '2019-07-05 19:27:54',
            ),
            160 => 
            array (
                'id' => 202,
                'key' => 'browse_dosificaciones',
                'table_name' => 'dosificaciones',
                'created_at' => '2019-07-09 15:42:45',
                'updated_at' => '2019-07-09 15:42:45',
            ),
            161 => 
            array (
                'id' => 203,
                'key' => 'read_dosificaciones',
                'table_name' => 'dosificaciones',
                'created_at' => '2019-07-09 15:43:05',
                'updated_at' => '2019-07-09 15:43:05',
            ),
            162 => 
            array (
                'id' => 204,
                'key' => 'add_dosificaciones',
                'table_name' => 'dosificaciones',
                'created_at' => '2019-07-09 15:43:17',
                'updated_at' => '2019-07-09 15:43:17',
            ),
            163 => 
            array (
                'id' => 205,
                'key' => 'edit_dosificaciones',
                'table_name' => 'dosificaciones',
                'created_at' => '2019-07-09 15:43:30',
                'updated_at' => '2019-07-09 15:43:30',
            ),
            164 => 
            array (
                'id' => 206,
                'key' => 'delete_dosificaciones',
                'table_name' => 'dosificaciones',
                'created_at' => '2019-07-09 15:43:51',
                'updated_at' => '2019-07-09 15:43:51',
            ),
            165 => 
            array (
                'id' => 207,
                'key' => 'browse_ventas_estados',
                'table_name' => 'ventas_estados',
                'created_at' => '2019-07-13 15:11:40',
                'updated_at' => '2019-07-13 15:11:40',
            ),
            166 => 
            array (
                'id' => 208,
                'key' => 'read_ventas_estados',
                'table_name' => 'ventas_estados',
                'created_at' => '2019-07-13 15:11:40',
                'updated_at' => '2019-07-13 15:11:40',
            ),
            167 => 
            array (
                'id' => 209,
                'key' => 'edit_ventas_estados',
                'table_name' => 'ventas_estados',
                'created_at' => '2019-07-13 15:11:40',
                'updated_at' => '2019-07-13 15:11:40',
            ),
            168 => 
            array (
                'id' => 210,
                'key' => 'add_ventas_estados',
                'table_name' => 'ventas_estados',
                'created_at' => '2019-07-13 15:11:40',
                'updated_at' => '2019-07-13 15:11:40',
            ),
            169 => 
            array (
                'id' => 211,
                'key' => 'delete_ventas_estados',
                'table_name' => 'ventas_estados',
                'created_at' => '2019-07-13 15:11:40',
                'updated_at' => '2019-07-13 15:11:40',
            ),
            170 => 
            array (
                'id' => 212,
                'key' => 'browse_ventas_tipos',
                'table_name' => 'ventas_tipos',
                'created_at' => '2019-07-24 21:54:55',
                'updated_at' => '2019-07-24 21:54:55',
            ),
            171 => 
            array (
                'id' => 213,
                'key' => 'read_ventas_tipos',
                'table_name' => 'ventas_tipos',
                'created_at' => '2019-07-24 21:54:55',
                'updated_at' => '2019-07-24 21:54:55',
            ),
            172 => 
            array (
                'id' => 214,
                'key' => 'edit_ventas_tipos',
                'table_name' => 'ventas_tipos',
                'created_at' => '2019-07-24 21:54:55',
                'updated_at' => '2019-07-24 21:54:55',
            ),
            173 => 
            array (
                'id' => 215,
                'key' => 'add_ventas_tipos',
                'table_name' => 'ventas_tipos',
                'created_at' => '2019-07-24 21:54:55',
                'updated_at' => '2019-07-24 21:54:55',
            ),
            174 => 
            array (
                'id' => 216,
                'key' => 'delete_ventas_tipos',
                'table_name' => 'ventas_tipos',
                'created_at' => '2019-07-24 21:54:55',
                'updated_at' => '2019-07-24 21:54:55',
            ),
            175 => 
            array (
                'id' => 217,
                'key' => 'browse_ventas_detalle_tipo_estados',
                'table_name' => 'ventas_detalle_tipo_estados',
                'created_at' => '2019-07-24 22:01:58',
                'updated_at' => '2019-07-24 22:01:58',
            ),
            176 => 
            array (
                'id' => 218,
                'key' => 'read_ventas_detalle_tipo_estados',
                'table_name' => 'ventas_detalle_tipo_estados',
                'created_at' => '2019-07-24 22:01:58',
                'updated_at' => '2019-07-24 22:01:58',
            ),
            177 => 
            array (
                'id' => 219,
                'key' => 'edit_ventas_detalle_tipo_estados',
                'table_name' => 'ventas_detalle_tipo_estados',
                'created_at' => '2019-07-24 22:01:58',
                'updated_at' => '2019-07-24 22:01:58',
            ),
            178 => 
            array (
                'id' => 220,
                'key' => 'add_ventas_detalle_tipo_estados',
                'table_name' => 'ventas_detalle_tipo_estados',
                'created_at' => '2019-07-24 22:01:58',
                'updated_at' => '2019-07-24 22:01:58',
            ),
            179 => 
            array (
                'id' => 221,
                'key' => 'delete_ventas_detalle_tipo_estados',
                'table_name' => 'ventas_detalle_tipo_estados',
                'created_at' => '2019-07-24 22:01:58',
                'updated_at' => '2019-07-24 22:01:58',
            ),
            180 => 
            array (
                'id' => 222,
                'key' => 'delivery_close',
                'table_name' => 'delivery',
                'created_at' => '2019-07-25 01:01:59',
                'updated_at' => '2019-07-25 01:01:59',
            ),
            181 => 
            array (
                'id' => 223,
                'key' => 'browse_administraciondelivery',
                'table_name' => 'delivery',
                'created_at' => '2019-07-26 14:52:27',
                'updated_at' => '2019-08-10 16:50:42',
            ),
            182 => 
            array (
                'id' => 224,
                'key' => 'browse_reportesgraficos',
                'table_name' => 'reportes',
                'created_at' => '2019-08-10 21:06:34',
                'updated_at' => '2019-08-10 21:09:08',
            ),
            183 => 
            array (
                'id' => 230,
                'key' => 'browse_localidades',
                'table_name' => 'localidades',
                'created_at' => '2019-08-15 21:42:31',
                'updated_at' => '2019-08-15 21:42:31',
            ),
            184 => 
            array (
                'id' => 231,
                'key' => 'read_localidades',
                'table_name' => 'localidades',
                'created_at' => '2019-08-15 21:42:31',
                'updated_at' => '2019-08-15 21:42:31',
            ),
            185 => 
            array (
                'id' => 232,
                'key' => 'edit_localidades',
                'table_name' => 'localidades',
                'created_at' => '2019-08-15 21:42:31',
                'updated_at' => '2019-08-15 21:42:31',
            ),
            186 => 
            array (
                'id' => 233,
                'key' => 'add_localidades',
                'table_name' => 'localidades',
                'created_at' => '2019-08-15 21:42:31',
                'updated_at' => '2019-08-15 21:42:31',
            ),
            187 => 
            array (
                'id' => 234,
                'key' => 'delete_localidades',
                'table_name' => 'localidades',
                'created_at' => '2019-08-15 21:42:31',
                'updated_at' => '2019-08-15 21:42:31',
            ),
            188 => 
            array (
                'id' => 235,
                'key' => 'browse_ventascredito',
                'table_name' => 'ventas',
                'created_at' => '2019-08-28 14:36:10',
                'updated_at' => '2019-08-28 14:36:10',
            ),
            189 => 
            array (
                'id' => 236,
                'key' => 'browse_proformas',
                'table_name' => 'ventas',
                'created_at' => '2019-08-28 14:56:40',
                'updated_at' => '2019-08-28 14:56:40',
            ),
            190 => 
            array (
                'id' => 237,
                'key' => 'browse_reportesventas',
                'table_name' => 'reportes',
                'created_at' => '2019-10-08 23:13:52',
                'updated_at' => '2019-10-08 23:14:31',
            ),
            191 => 
            array (
                'id' => 238,
                'key' => 'browse_reporteventaslibro',
                'table_name' => 'reportes',
                'created_at' => '2019-10-08 23:14:19',
                'updated_at' => '2019-10-08 23:21:44',
            ),
            192 => 
            array (
                'id' => 239,
                'key' => 'browse_reportesganancia_producto',
                'table_name' => 'reportes',
                'created_at' => '2019-10-08 23:15:54',
                'updated_at' => '2019-10-08 23:18:17',
            ),
            193 => 
            array (
                'id' => 245,
                'key' => 'browse_subcategorias',
                'table_name' => 'subcategorias',
                'created_at' => '2019-10-30 15:15:22',
                'updated_at' => '2019-10-30 15:15:22',
            ),
            194 => 
            array (
                'id' => 246,
                'key' => 'read_subcategorias',
                'table_name' => 'subcategorias',
                'created_at' => '2019-10-30 15:15:22',
                'updated_at' => '2019-10-30 15:15:22',
            ),
            195 => 
            array (
                'id' => 247,
                'key' => 'edit_subcategorias',
                'table_name' => 'subcategorias',
                'created_at' => '2019-10-30 15:15:22',
                'updated_at' => '2019-10-30 15:15:22',
            ),
            196 => 
            array (
                'id' => 248,
                'key' => 'add_subcategorias',
                'table_name' => 'subcategorias',
                'created_at' => '2019-10-30 15:15:22',
                'updated_at' => '2019-10-30 15:15:22',
            ),
            197 => 
            array (
                'id' => 249,
                'key' => 'delete_subcategorias',
                'table_name' => 'subcategorias',
                'created_at' => '2019-10-30 15:15:22',
                'updated_at' => '2019-10-30 15:15:22',
            ),
            198 => 
            array (
                'id' => 250,
                'key' => 'browse_ventascocina',
                'table_name' => 'ventas',
                'created_at' => '2019-11-27 16:00:58',
                'updated_at' => '2019-11-27 16:00:58',
            ),
            199 => 
            array (
                'id' => 251,
                'key' => 'browse_publicaciones',
                'table_name' => 'publicaciones',
                'created_at' => '2019-11-29 17:30:44',
                'updated_at' => '2019-11-29 17:30:44',
            ),
            200 => 
            array (
                'id' => 252,
                'key' => 'read_publicaciones',
                'table_name' => 'publicaciones',
                'created_at' => '2019-11-29 17:30:44',
                'updated_at' => '2019-11-29 17:30:44',
            ),
            201 => 
            array (
                'id' => 253,
                'key' => 'edit_publicaciones',
                'table_name' => 'publicaciones',
                'created_at' => '2019-11-29 17:30:44',
                'updated_at' => '2019-11-29 17:30:44',
            ),
            202 => 
            array (
                'id' => 254,
                'key' => 'add_publicaciones',
                'table_name' => 'publicaciones',
                'created_at' => '2019-11-29 17:30:44',
                'updated_at' => '2019-11-29 17:30:44',
            ),
            203 => 
            array (
                'id' => 255,
                'key' => 'delete_publicaciones',
                'table_name' => 'publicaciones',
                'created_at' => '2019-11-29 17:30:44',
                'updated_at' => '2019-11-29 17:30:44',
            ),
            204 => 
            array (
                'id' => 256,
                'key' => 'edit_producto_depositos',
                'table_name' => 'depositos',
                'created_at' => '2019-12-04 18:13:15',
                'updated_at' => '2019-12-04 18:13:15',
            ),
            205 => 
            array (
                'id' => 257,
                'key' => 'delete_producto_depositos',
                'table_name' => 'depositos',
                'created_at' => '2019-12-04 18:13:28',
                'updated_at' => '2019-12-04 18:13:28',
            ),
            206 => 
            array (
                'id' => 258,
                'key' => 'browse_reportesproductosescasez',
                'table_name' => 'reportes',
                'created_at' => '2019-12-24 21:02:02',
                'updated_at' => '2019-12-24 21:02:02',
            ),
            207 => 
            array (
                'id' => 259,
                'key' => 'browse_ventastickets',
                'table_name' => 'ventas',
                'created_at' => '2020-02-13 19:57:44',
                'updated_at' => '2020-02-13 19:57:44',
            ),
            208 => 
            array (
                'id' => 260,
                'key' => 'browse_extras',
                'table_name' => 'extras',
                'created_at' => '2020-02-18 17:04:55',
                'updated_at' => '2020-02-18 17:04:55',
            ),
            209 => 
            array (
                'id' => 261,
                'key' => 'read_extras',
                'table_name' => 'extras',
                'created_at' => '2020-02-18 17:04:55',
                'updated_at' => '2020-02-18 17:04:55',
            ),
            210 => 
            array (
                'id' => 262,
                'key' => 'edit_extras',
                'table_name' => 'extras',
                'created_at' => '2020-02-18 17:04:55',
                'updated_at' => '2020-02-18 17:04:55',
            ),
            211 => 
            array (
                'id' => 263,
                'key' => 'add_extras',
                'table_name' => 'extras',
                'created_at' => '2020-02-18 17:04:55',
                'updated_at' => '2020-02-18 17:04:55',
            ),
            212 => 
            array (
                'id' => 264,
                'key' => 'delete_extras',
                'table_name' => 'extras',
                'created_at' => '2020-02-18 17:04:55',
                'updated_at' => '2020-02-18 17:04:55',
            ),
            213 => 
            array (
                'id' => 265,
                'key' => 'browse_clear-cache',
                'table_name' => 'development',
                'created_at' => '2020-02-18 17:04:55',
                'updated_at' => '2020-02-18 17:04:55',
            ),
            214 => 
            array (
                'id' => 266,
                'key' => 'browse_orders',
                'table_name' => 'pedidos',
                'created_at' => '2020-09-03 20:34:59',
                'updated_at' => '2020-09-03 20:34:59',
            ),
            215 => 
            array (
                'id' => 267,
                'key' => 'add_orders',
                'table_name' => 'pedidos',
                'created_at' => '2020-09-03 20:35:11',
                'updated_at' => '2020-09-03 20:35:11',
            ),
            216 => 
            array (
                'id' => 268,
                'key' => 'view_orders',
                'table_name' => 'pedidos',
                'created_at' => '2020-09-03 20:35:30',
                'updated_at' => '2020-09-03 20:35:30',
            ),
            217 => 
            array (
                'id' => 269,
                'key' => 'edit_orders',
                'table_name' => 'pedidos',
                'created_at' => '2020-09-03 20:35:40',
                'updated_at' => '2020-09-03 20:35:40',
            ),
            218 => 
            array (
                'id' => 270,
                'key' => 'delete_orders',
                'table_name' => 'pedidos',
                'created_at' => '2020-09-03 20:35:49',
                'updated_at' => '2020-09-03 20:35:49',
            ),
        ));
        
        
    }
}