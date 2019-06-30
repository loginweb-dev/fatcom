<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Venta extends Model
{
    protected $fillable = ['cliente_id', 'fecha', 'nro_factura', 'codigo_control', 'estado', 'nro_autorizacion', 'fecha_limite', 'importe', 'importe_ice', 'importe_exento', 'tasa_cero', 'subtotal', 'descuento', 'importe_base', 'debito_fiscal', 'caja_id', 'user_id', 'tipo', 'tipo_estado', 'nro_mesa', 'autorizacion_id', 'monto_recibido', 'observaciones'];
}
