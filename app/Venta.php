<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Venta extends Model
{
    protected $fillable = ['sucursal_id', 'nro_venta', 'cliente_id', 'fecha', 'nro_factura', 'codigo_control', 'estado', 'nro_autorizacion', 'fecha_limite', 'importe', 'importe_ice', 'importe_exento', 'tasa_cero', 'subtotal', 'descuento', 'importe_base', 'debito_fiscal', 'cobro_adicional', 'cobro_adicional_factura', 'caja_id', 'pagada', 'efectivo', 'user_id', 'venta_tipo_id', 'venta_estado_id', 'nro_mesa', 'autorizacion_id', 'monto_recibido', 'observaciones'];

    public function items(){
        return $this->hasMany(VentasDetalle::class);
    }

    public function tipoventa(){
        return $this->belongsTo(VentasTipo::class,'venta_tipo_id');
    }

    public function estadoventa(){
        return $this->belongsTo(VentasEstado::class,'venta_estado_id');
    }

    public function ventaseguimientos(){
        return $this->hasMany(VentasSeguimiento::class,'venta_id');
    }
}
