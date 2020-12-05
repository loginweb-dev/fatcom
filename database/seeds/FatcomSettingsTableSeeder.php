<?php

use Illuminate\Database\Seeder;

class FatcomSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->truncate();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'empresa.title',
                'display_name' => 'Nombre de la empresa',
                'value' => '',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Empresa',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'empresa.description',
                'display_name' => 'Descripción',
                'value' => '',
                'details' => '',
                'type' => 'text_area',
                'order' => 2,
                'group' => 'Empresa',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'empresa.logo',
                'display_name' => 'Logo',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Empresa',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'admin.google_analytics_tracking_id',
                'display_name' => 'Google Analytics Tracking ID',
                'value' => NULL,
                'details' => '',
                'type' => 'text',
                'order' => 10,
                'group' => 'Admin',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'admin.bg_image',
                'display_name' => 'Imagen de fondo',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 5,
                'group' => 'Admin',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'admin.title',
                'display_name' => 'Nombre del software',
                'value' => 'Fatcom',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Admin',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'admin.description',
                'display_name' => 'Descripción',
                'value' => 'Software para administración de ventas.',
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Admin',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'admin.loader',
                'display_name' => 'Imagen de carga',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Admin',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'admin.icon_image',
                'display_name' => 'Icono del software',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 4,
                'group' => 'Admin',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => 'admin.google_analytics_client_id',
            'display_name' => 'Google Analytics Client ID (used for admin dashboard)',
                'value' => NULL,
                'details' => '',
                'type' => 'text',
                'order' => 10,
                'group' => 'Admin',
            ),
            10 => 
            array (
                'id' => 11,
                'key' => 'admin.modo_sistema',
                'display_name' => 'Modo del sistema',
                'value' => 'repuestos',
                'details' => '{
                    "options":{
                        "boutique":"Boutique",
                        "repuestos":"Tienda en gral.",
                        "electronica_computacion":"Electrónica y computación",
                        "restaurante":"Restaurante"
                    }
                }',
                'type' => 'select_dropdown',
                'order' => 7,
                'group' => 'Admin',
            ),
            11 => 
            array (
                'id' => 12,
                'key' => 'admin.prefijo_codigo',
                'display_name' => 'Prefijo de código de producto',
                'value' => 'COD',
                'details' => NULL,
                'type' => 'text',
                'order' => 8,
                'group' => 'Admin',
            ),
            12 => 
            array (
                'id' => 13,
                'key' => 'admin.tips',
                'display_name' => 'Ayuda al usuario',
                'value' => '1',
                'details' => NULL,
                'type' => 'checkbox',
                'order' => 9,
                'group' => 'Admin',
            ),
            13 => 
            array (
                'id' => 14,
                'key' => 'empresa.telefono',
                'display_name' => 'Telefono',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text',
                'order' => 17,
                'group' => 'Empresa',
            ),
            14 => 
            array (
                'id' => 15,
                'key' => 'admin.imagen_ofertas',
                'display_name' => 'Imagen de fondo para ofertas',
                'value' => '',
                'details' => NULL,
                'type' => 'image',
                'order' => 5,
                'group' => 'Admin',
            ),
            15 => 
            array (
                'id' => 16,
                'key' => 'admin.social_image',
                'display_name' => 'Imagen de fondo para compartir',
                'value' => '',
                'details' => NULL,
                'type' => 'image',
                'order' => 5,
                'group' => 'Admin',
            ),
            16 => 
            array (
                'id' => 17,
                'key' => 'empresa.facturas',
                'display_name' => 'Facturas',
                'value' => '1',
                'details' => NULL,
                'type' => 'checkbox',
                'order' => 20,
                'group' => 'Empresa',
            ),
            17 => 
            array (
                'id' => 18,
                'key' => 'empresa.direccion',
                'display_name' => 'Dirección',
                'value' => '',
                'details' => NULL,
                'type' => 'text_area',
                'order' => 18,
                'group' => 'Empresa',
            ),
            18 => 
            array (
                'id' => 19,
                'key' => 'delivery.costo_envio',
                'display_name' => 'Costo de envío',
                'value' => '10',
                'details' => NULL,
                'type' => 'text',
                'order' => 13,
                'group' => 'Delivery',
            ),
            19 => 
            array (
                'id' => 20,
                'key' => 'empresa.tipo_actividad',
                'display_name' => 'Tipo de actividad económica',
                'value' => 'bienes',
                'details' => '{
                    "options":{
                    "bienes":"Venta de bienes",
                    "servicios":"Venta de servicios"
                    }
                }',
                'type' => 'select_dropdown',
                'order' => 14,
                'group' => 'Empresa',
            ),
            20 => 
            array (
                'id' => 21,
                'key' => 'empresa.actividad_economica',
                'display_name' => 'Actividad económica',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text_area',
                'order' => 15,
                'group' => 'Empresa',
            ),
            21 => 
            array (
                'id' => 22,
                'key' => 'empresa.nit',
                'display_name' => 'NIT',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 16,
                'group' => 'Empresa',
            ),
            22 => 
            array (
                'id' => 23,
                'key' => 'empresa.celular',
                'display_name' => 'Celular',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 17,
                'group' => 'Empresa',
            ),
            23 => 
            array (
                'id' => 24,
                'key' => 'empresa.email',
                'display_name' => 'Correo electrónico',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text',
                'order' => 18,
                'group' => 'Empresa',
            ),
            24 => 
            array (
                'id' => 25,
                'key' => 'empresa.ciudad',
                'display_name' => 'Ciudad',
                'value' => 'Santísima Trinidad - Beni - Bolivia',
                'details' => NULL,
                'type' => 'text',
                'order' => 19,
                'group' => 'Empresa',
            ),
            25 => 
            array (
                'id' => 26,
                'key' => 'empresa.tipo_factura',
                'display_name' => 'Tamaño de la factura',
                'value' => 'media_carta',
                'details' => '{
                    "options":{
                        "media_carta" : "Media carta",
                        "carta" : "Carta",
                        "rollo" : "En rollo"
                    }
                }',
                'type' => 'select_dropdown',
                'order' => 20,
                'group' => 'Empresa',
            ),
            26 => 
            array (
                'id' => 27,
                'key' => 'delivery.activo',
                'display_name' => 'Activado',
                'value' => '1',
                'details' => NULL,
                'type' => 'checkbox',
                'order' => 21,
                'group' => 'Delivery',
            ),
            27 => 
            array (
                'id' => 28,
                'key' => 'ventas.ventas_credito',
                'display_name' => 'Ventas a crédito',
                'value' => '0',
                'details' => NULL,
                'type' => 'checkbox',
                'order' => 22,
                'group' => 'Ventas',
            ),
            28 => 
            array (
                'id' => 29,
                'key' => 'empresa.leyenda_factura',
                'display_name' => 'Leyenda de la factura',
                'value' => '',
                'details' => NULL,
                'type' => 'rich_text_box',
                'order' => 23,
                'group' => 'Empresa',
            ),
            29 => 
            array (
                'id' => 30,
                'key' => 'impresion.impresora1',
                'display_name' => 'Impresora principal',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text',
                'order' => 24,
                'group' => 'Impresión',
            ),
            30 => 
            array (
                'id' => 31,
                'key' => 'impresion.impresora2',
                'display_name' => 'Impresora secundaria',
                'value' => NULL,
                'details' => NULL,
                'type' => 'text',
                'order' => 25,
                'group' => 'Impresión',
            ),
            31 => 
            array (
                'id' => 32,
                'key' => 'admin.ecommerce',
                'display_name' => 'Ecommerce',
                'value' => '',
                'details' => '{
                    "options":{
                        "" : "Por defecto",
                        "ecommerce_v1." : "Ecommerce Bootstrap 4"
                    }
                }',
                'type' => 'select_dropdown',
                'order' => 7,
                'group' => 'Admin',
            ),
            32 => 
            array (
                'id' => 33,
                'key' => 'impresion.impresion_rapida',
                'display_name' => 'Auxiliar de impresión rápida',
                'value' => '1',
                'details' => NULL,
                'type' => 'checkbox',
                'order' => 23,
                'group' => 'Impresión',
            ),
            33 => 
            array (
                'id' => 34,
                'key' => 'admin.img_loader',
                'display_name' => 'Loader',
                'value' => '',
                'details' => NULL,
                'type' => 'image',
                'order' => 5,
                'group' => 'Admin',
            ),
            34 => 
            array (
                'id' => 35,
                'key' => 'empresa.propietario',
                'display_name' => 'Propietario',
                'value' => '',
                'details' => NULL,
                'type' => 'text',
                'order' => 1,
                'group' => 'Empresa',
            ),
            35 => 
            array (
                'id' => 36,
                'key' => 'admin.tickets_image',
                'display_name' => 'Imagen de fondo tickets',
                'value' => '',
                'details' => NULL,
                'type' => 'image',
                'order' => 5,
                'group' => 'Admin',
            ),
            36 => 
            array (
                'id' => 37,
                'key' => 'delivery.order_out_of_time',
                'display_name' => 'Pedidos fuera de horario',
                'value' => '',
                'details' => NULL,
                'type' => 'checkbox',
                'order' => 26,
                'group' => 'Delivery',
            ),
            37 => 
            array (
                'id' => 38,
                'key' => 'delivery.message_company_closed',
                'display_name' => 'Mensaje de tienda cerrada',
                'value' => '',
                'details' => NULL,
                'type' => 'text_area',
                'order' => 27,
                'group' => 'Delivery',
            ),
            38 => 
            array (
                'id' => 39,
                'key' => 'social.facebook',
                'display_name' => 'Facebook',
                'value' => 'https://www.facebook.com/',
                'details' => NULL,
                'type' => 'text',
                'order' => 28,
                'group' => 'Social',
            ),
            39 => 
            array (
                'id' => 40,
                'key' => 'social.instagram',
                'display_name' => 'Instagram',
                'value' => 'https://www.instagram.com/',
                'details' => NULL,
                'type' => 'text',
                'order' => 29,
                'group' => 'Social',
            ),
            40 => 
            array (
                'id' => 41,
                'key' => 'social.twitter',
                'display_name' => 'Twitter',
                'value' => 'https://twitter.com/',
                'details' => NULL,
                'type' => 'text',
                'order' => 30,
                'group' => 'Social',
            ),
            41 => 
            array (
                'id' => 42,
                'key' => 'social.youtube',
                'display_name' => 'Youtube',
                'value' => 'https://www.youtube.com/',
                'details' => NULL,
                'type' => 'text',
                'order' => 31,
                'group' => 'Social',
            ),
            42 => 
            array (
                'id' => 43,
                'key' => 'social.whatsapp',
                'display_name' => 'Whatsapp',
                'value' => 'https://api.whatsapp.com/send?phone=59175199157',
                'details' => NULL,
                'type' => 'text',
                'order' => 32,
                'group' => 'Social',
            ),
            43 => 
            array (
                'id' => 44,
                'key' => 'social.tiktok',
                'display_name' => 'TikTok',
                'value' => 'https://www.tiktok.com/',
                'details' => NULL,
                'type' => 'text',
                'order' => 33,
                'group' => 'Social',
            ),
            44 => 
            array (
                'id' => 45,
                'key' => 'social.pinterest',
                'display_name' => 'Pinterest',
                'value' => 'https://www.pinterest.com/',
                'details' => NULL,
                'type' => 'text',
                'order' => 33,
                'group' => 'Social',
            ),
        ));
        
        
    }
}