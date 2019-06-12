<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

    }

    public function pedidos_store(Request $data){
        $carrito = session()->has('carrito_compra') ? session()->get('carrito_compra') : array();
        if(count($carrito)==0){
            $alerta = 'carrito_vacio';
            return redirect()->route('carrito_compra')->with(compact('alerta'));
        }
        $cantidades = array();
        $precios = array();
        $importe_venta = 0;
        for ($i=0; $i < count($data->cantidad); $i++) {
            array_push($cantidades, $data->cantidad[$i]);
            array_push($precios, $data->precio[$i]);
            $importe_venta += $data->cantidad[$i] *  $data->precio[$i];
        }

        // insertar y obtener ultima venta
        $query = DB::table('ventas')
                        ->insert([
                            'cliente_id' => Auth::user()->id,
                            'importe' => $importe_venta,
                            'subtotal' => $importe_venta,
                            'tipo' => 'pedido',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
        $venta = DB::table('ventas')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->first();
        if($query){
            $cont = 0;
            foreach ($carrito as $item) {
                DB::table('ventas_detalles')
                        ->insert([
                            'venta_id' => $venta->id,
                            'producto_id' => $item->id,
                            'precio' => $precios[$cont],
                            'cantidad' => $cantidades[$cont],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                $cont++;
            }
        }

        if($query){
            session()->forget('carrito_compra');
            return redirect()->route('pedidos_success');
        }else{
            return 0;
        }
    }

    public function pedidos_success(){
        $sucursal = DB::table('sucursales')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->first();
        return view('landingpage/agradecimiento', compact('sucursal'));
    }
}


