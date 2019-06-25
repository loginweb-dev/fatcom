<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Compra extends Model
{
    protected $fillable = ['fecha', 'nit', 'razon_social', 'nro_factura', 'nro_dui', 'nro_autorizacion', 'importe_compra', 'monto_exento', 'sub_total', 'descuento', 'importe_base', 'credito_fiscal', 'codigo_control', 'tipo_compra', 'compra_producto'];
}
