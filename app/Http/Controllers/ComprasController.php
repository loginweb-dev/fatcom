<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Producto;
use App\Proveedore;
use App\Compra;
use App\IeCaja;
use App\IeAsiento;
use App\ProductosDeposito;
use App\ProductoUnidade;

use App\Http\Controllers\ProveedoresController as Proveedores;

class ComprasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $registros = DB::table('compras')
                        ->select('*')
                        ->where('deleted_at', NULL)
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
        $value = '';
        return view('compras.compras_index', compact('registros', 'value'));
    }

    public function create(){
        $caja = IeCaja::where('abierta', 1)->first();

        $depositos = DB::table('depositos')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->get();
        return view('compras.compras_create', compact('depositos', 'caja'));
    }

    public function store(Request $data){
        // dd($data);
        // Si se envió un NIT crear nuevo proveedor
        if(!empty($data->nit)){
            $proveedor = (new Proveedores)->get_proveedor($data->nit);
            if(!$proveedor){
                $proveedor = new Proveedore;
                $proveedor->nombre = $data->razon_social;
                $proveedor->nit = $data->nit;
                $proveedor->save();
            }
        }

        // Agregar nueva compra
        $compra = new Compra;
        $compra->fecha = $data->fecha;
        $compra->nit = $data->nit;
        $compra->razon_social = $data->razon_social;
        $compra->importe_compra = $data->importe_compra;
        $compra->sub_total = $data->sub_total;
        $compra->importe_base = $data->importe_base;
        $compra->compra_producto = $data->compra_producto;

        // Si existe facturación se agregan datos de facturación necesarios
        if(isset($data->nro_factura)){
            $compra->nro_factura = $data->nro_factura;
            $compra->nro_dui = $data->nro_dui;
            $compra->nro_autorizacion = $data->nro_autorizacion;
            $compra->monto_exento = $data->monto_exento;
            $compra->descuento = $data->descuento;
            $compra->credito_fiscal = $data->credito_fiscal;
            $compra->tipo_compra = $data->tipo_compra;
            $compra->codigo_control = $data->codigo_control;
        }

        $compra->save();
        $compra_id = Compra::all()->last()->id;

        $asiento_creado = null;
        if($data->crear_asiento){
            $monto_caja = IeCaja::find($data->crear_asiento)->monto_final;
            if($data->importe_base <= $monto_caja){
                // Crear asiento
                $asiento = new IeAsiento;
                $asiento->concepto = 'Compra realizada';
                $asiento->monto = $data->importe_base;
                $asiento->tipo = 'egreso';
                $asiento->fecha = date('Y-m-d');
                $asiento->hora = date('H:i:s');
                $asiento->user_id =  Auth::user()->id;
                $asiento->caja_id = $data->crear_asiento;
                $asiento->compra_id = $compra_id;
                $asiento->save();

                // Actualizar datos de egresos en la caja
                DB::table('ie_cajas')->where('id', $data->crear_asiento)->decrement('monto_final', $data->importe_base);
                DB::table('ie_cajas')->where('id', $data->crear_asiento)->increment('total_egresos', $data->importe_base);
                
                $asiento_creado = 'success';
            }else{
                $asiento_creado = 'error';
            }
        }
        // dd($data);

        // Ingresar detalle de compra
        if($compra_id!=''){
            for ($i=0; $i < count($data->producto); $i++) {
                if(!is_null($data->producto[$i])){
                    DB::table('compras_detalles')
                        ->insert([
                            'compra_id' => $compra_id,
                            'producto_id' => $data->producto[$i],
                            'precio' => $data->precio[$i],
                            'cantidad' => $data->cantidad[$i],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                    // Verificar si es compra de productos para incrementar su stock    
                    if($data->compra_productos){
                        // Si el producto ya está registrado en el almacen se incrementará, caso contrario se creara un nuevo registro
                        $pd = ProductosDeposito::where('deposito_id', $data->deposito_id)->where('producto_id', $data->producto[$i])->first();
                        if(!$pd){
                            $pd = new ProductosDeposito;
                            $pd->deposito_id = $data->deposito_id;
                            $pd->producto_id = $data->producto[$i];
                            $pd->stock = !isset($data->nro_factura) ? $data->cantidad[$i] : 0;
                            $pd->stock_compra = isset($data->nro_factura) ? $data->cantidad[$i] : 0;
                            $pd->stock_inicial = $data->cantidad[$i];
                            $pd->save();
                        }else{
                            $campo_stock = isset($data->nro_factura) ? 'stock_compra' : 'stock';
                            DB::table('productos_depositos')->where('id', $pd->id)->increment($campo_stock, $data->cantidad[$i]);

                            // Actualizar precio de compra y venta en tabla productos
                            $producto = Producto::find($data->producto[$i]);
                            $producto->precio_venta = $data->precio_venta[$i];
                            $producto->ultimo_precio_compra = $data->precio[$i];
                            $producto->save();

                            // Actualizar precio de venta en tabla de producto por unidades
                            $id = ProductoUnidade::where('producto_id', $data->producto[$i])->where('deleted_at', NULL)->first()->id;
                            $producto_unidad = ProductoUnidade::find($id);
                            $producto_unidad->precio = $data->precio_venta[$i];
                            $producto_unidad->save();
                        }
                        $producto = Producto::find($data->producto[$i]);
                        $producto->stock += $data->cantidad[$i];
                        $producto->save();
                    }
                }
            }
            if($asiento_creado){
                if($asiento_creado == 'success'){
                    return redirect()->route('compras_index')->with(['message' => 'Compra y asiento de compra registrado exitosamente.', 'alert-type' => 'success']);
                }else{
                    return redirect()->route('compras_index')->with(['message' => 'La compra fué registrada exitosamente, pero no se registró como un egreso de la caja debido a que el monto de compra es mayor al monto en caja.', 'alert-type' => 'warning']);
                }
            }else{
                return redirect()->route('compras_index')->with(['message' => 'Compra registrada exitosamente.', 'alert-type' => 'success']);
            }
        }else{
            return redirect()->route('compras_index')->with(['message' => 'Ocurrio un error al registrar la compra.', 'alert-type' => 'error']);
        }
    }

    public function compras_cargar_tipo($tipo){

        $productos = DB::table('productos as p')
                        ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                        ->join('marcas as m', 'm.id', 'p.marca_id')
                        ->join('tallas as t', 't.id', 'p.talla_id')
                        ->join('colores as c', 'c.id', 'p.color_id')
                        ->join('generos as g', 'g.id', 'p.genero_id')
                        ->join('monedas as mo', 'mo.id', 'p.moneda_id')
                        ->select('p.id','p.codigo_interno', 'p.codigo', 'p.nombre', 'p.imagen', 'p.precio_venta','p.descripcion_small', 'm.nombre as marca', 't.nombre as talla', 'g.nombre as genero', 's.nombre as subcategoria', 'c.nombre as color', 'mo.abreviacion as moneda')
                        ->where('p.deleted_at', NULL)
                        ->where('p.se_almacena', '<>', NULL)
                        ->orderBy('c.id', 'DESC')
                        ->get();
        
        $categorias = DB::table('categorias as c')
                            ->join('subcategorias as s', 's.categoria_id', 'c.id')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('c.*')
                            ->where('p.deleted_at', NULL)
                            ->where('c.deleted_at', NULL)
                            ->where('c.id', '>', 1)
                            ->distinct()
                            ->get();

        if($tipo=='normal'){
            return view('compras.compras_normal');
        }else{
            return view('compras.compras_productos', compact('productos', 'categorias'));
        }

    }



}

