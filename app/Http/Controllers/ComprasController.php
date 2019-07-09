<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Proveedore;
use App\Compra;
use App\IeCaja;

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
        dd($data);
        // Si se envió un NIT crear nuevo proveedor
        if($data->nit!=''){
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
                    // if($data->compra_mercaderia==1){
                    //     if(isset($data->nro_factura)){
                    //         DB::table('deposito_productos')
                    //                 ->where('producto_id', $data->producto[$i])
                    //                 ->where('deposito_id', $data->deposito_id)
                    //                 ->increment('cantidad_compra', $data->cantidad[$i]);
                    //     }else{
                    //         DB::table('deposito_productos')
                    //                 ->where('producto_id', $data->producto[$i])
                    //                 ->where('deposito_id', $data->deposito_id)
                    //                 ->increment('cantidad_adicional', $data->cantidad[$i]);
                    //     }

                    // }
                }
            }
            return redirect()->route('compras_index')->with(['message' => 'Compra registrada exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('compras_index')->with(['message' => 'Ocurrio un error al registrar la compra.', 'alert-type' => 'error']);
        }
    }

    public function compras_cargar_tipo($tipo){

        $productos = DB::table('productos as p')
                        ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                        ->join('categorias as c', 'c.id', 's.categoria_id')
                        ->select('p.*', 's.nombre as subcategoria')
                        // ->where('deleted_at', NULL)
                        ->orderBy('c.id', 'DESC')
                        ->get();
        // dd($productos);
        $categorias = [];
        $subcategorias = [];
        // dd($productos);
        if($tipo=='normal'){
            return view('compras.compras_normal');
        }else{
            switch (setting('admin.modo_sistema')) {
                case 'restaurante':
                    return view('compras.restaurante.compras_productos', compact('productos', 'categorias', 'subcategorias'));
                    break;
                case 'normal':

                    break;
                default:
                    # code...
                    break;
            }
        }

    }



}
