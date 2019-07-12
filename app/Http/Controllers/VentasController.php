<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;

// Nota: Agregar Caja para usar eloquent
use App\Venta;
use App\Cliente;
use App\UsersCoordenada;
use App\RepartidoresPedido;
use App\User;

use App\Http\Controllers\ProductosController as Productos;
use App\Http\Controllers\LandingPageController as LandingPage;
use App\Http\Controllers\DosificacionesController as Dosificacion;

class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $consulta = '1';
        switch (Auth::user()->role_id) {
            case '5':
                $consulta = " v.tipo = 'pedido'";
                break;
            default:
                break;
        }

        $registros = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.*', 'c.razon_social as cliente')
                            ->whereRaw($consulta)
                            ->orderBy('v.id', 'DESC')
                            ->paginate(10);
        $delivery = DB::table('empleados as e')
                            ->join('users as u', 'u.id', 'e.user_id')
                            ->select('e.*', 'u.name as nombre')
                            // ->orderBy('r.nombre', 'ASC')
                            ->get();

        $value = '';
        return view('ventas.ventas_index', compact('registros', 'value', 'delivery'));
    }

    public function view($id){
        $venta = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.*', 'c.razon_social as cliente', 'c.nit')
                            ->where('v.id', $id)
                            ->first();
        $detalle = DB::table('ventas_detalles as d')
                            ->join('productos as p', 'p.id', 'd.producto_id')
                            ->select('d.*', 'p.nombre as producto')
                            ->where('d.deleted_at', NULL)
                            ->where('d.venta_id', $id)
                            ->get();
        $ubicacion = DB::table('clientes as c')
                            ->join('users_coordenadas as u', 'u.user_id', 'c.user_id')
                            ->select('u.*')
                            ->where('c.id', $venta->cliente_id)
                            ->where('ultima_ubicacion', 1)
                            ->first();
        return view('ventas.ventas_view', compact('venta', 'id', 'detalle', 'ubicacion'));
    }

    public function create(){
        $categorias = DB::table('categorias as c')
                            ->join('subcategorias as s', 's.categoria_id', 'c.id')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('c.*')
                            // ->where('p.deleted_at', NULL)
                            ->distinct()
                            ->get();
        $clientes = DB::table('clientes as c')
                        ->select('c.*')
                        ->where('c.deleted_at', NULL)
                        ->where('c.id', '>', 1)
                        ->get();
        $aux = DB::table('ie_cajas as c')
                            ->select('c.*')
                            ->where('c.abierta', 1)
                            ->first();
        $abierta = false;
        $caja_id = 0;
        if($aux){
            $abierta = true;
            $caja_id = $aux->id;
        }

        $facturacion = (new Dosificacion)->get_dosificacion();
        return view('ventas.ventas_create', compact('categorias', 'abierta', 'caja_id', 'clientes', 'facturacion'));
        // dd($facturacion);
        // switch (setting('admin.modo_sistema')) {
        //     case 'boutique':

        //         break;
        //     case 'electronica_computacion':
        //         return view('ventas.ventas_create', compact('categorias', 'abierta', 'caja_id', 'clientes', 'facturacion'));
        //         break;
        //     case 'restaurante':
        //         return view('ventas.restaurante.ventas_create', compact('categorias', 'abierta', 'caja_id', 'clientes', 'facturacion'));
        //         break;
        //     default:
        //         # code...
        //         break;
        // }
    }

    public function productos_search(){
        $categorias = DB::table('categorias')
                            ->select('id', 'nombre')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $productos = DB::table('productos as p')
                            ->join('producto_unidades as pu', 'pu.producto_id', 'p.id')
                            ->select('p.*', 'pu.precio')
                            ->where('p.deleted_at', NULL)
                            ->get();
        return view('ventas.ventas_productos_search', compact('categorias', 'productos'));
    }

    public function productos_categoria($id){
        $subcategorias = DB::table('subcategorias as s')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('s.id', 's.nombre')
                            ->where('s.deleted_at', NULL)
                            ->where('s.categoria_id', $id)
                            ->distinct()
                            ->get();
        $productos = DB::table('categorias as c')
                            ->join('subcategorias as s', 's.categoria_id', 'c.id')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('p.*')
                            // ->where('deleted_at', NULL)
                            ->where('s.categoria_id', $id)
                            ->get();
        $precios = [];
        foreach ($productos as $item) {
            // Obtener precios de venta del producto
            $producto_unidades =  (new Productos)->obtener_precios_venta($item->id);
            $precio = (count($producto_unidades)>0) ? ['precio' => $producto_unidades[0]->precio, 'unidad' => $producto_unidades[0]->unidad] : ['precio' => 0, 'unidad' => 'No definida'];
            array_push($precios, $precio);
        }

        return view('ventas.ventas_productos_categoria', compact('subcategorias', 'productos', 'precios'));
    }

    public function store(Request $data){
        // dd($data);
        // validar si exiten productos en la venta
        if(!isset($data->producto_id)){
            return null;
        }

        // dd($data->producto_id[0]);
        // Si la venta incluye el costo de envío en la factura se agrega ese costo al primer producto vendido
        $incremento_aux = 0;
        if(isset($data->incluir_envio)){
            if(count($data->producto_id)>0){
                $incremento_aux = $data->cobro_adicional;
                $data->cobro_adicional = 0;
            }
        }else{
            $data->cobro_adicional = (!empty($data->cobro_adicional)) ? $data->cobro_adicional : 0;
            $data->importe -= $data->cobro_adicional;
        }

        // Verificar si el cliente está registrado
        if(!is_numeric($data->cliente_id)){
            $cliente = new Cliente;
            $cliente->razon_social = $data->cliente_id;
            $cliente->nit = $data->nit;
            $cliente->save();
            $data->cliente_id = Cliente::all()->last()->id;
        }else{
            $cliente = Cliente::find($data->cliente_id);
            $cliente->nit = $data->nit;
            $cliente->save();
        }

        // Validar si el cliente tiene un pedido o pedido pendiente
        $pedido_pendiente = Venta::where('tipo', 'pedido')
                                    ->where('tipo_estado', '<', 5)
                                    ->where('cliente_id', $data->cliente_id)
                                    ->select()->first();
        if($pedido_pendiente){
            return 'error 1';
        }

        // insertar y obtener ultima venta
        $venta_id = $this->crear_venta($data);

        // insertar detalle de venta
        if($venta_id != ''){
            for ($i=0; $i < count($data->producto_id); $i++) {
                if(!is_null($data->producto_id[$i])){
                    DB::table('ventas_detalles')
                        ->insert([
                            'venta_id' => $venta_id,
                            // Se realiza una suma al primer item en caso de que el costo de envío se incluya en la factura, de lo contrario el incremento es 0
                            'producto_id' => $data->producto_id[$i],
                            'precio' => ($i==0) ? $data->precio[$i] + $incremento_aux : $data->precio[$i],
                            'cantidad' => $data->cantidad[$i],
                            'producto_adicional' => $data->adicional_id[$i],
                            'observaciones' => $data->observacion[$i],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                }
            }

            // crear el asiento de ingreso
            DB::table('ie_asientos')
            ->insert([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'caja_id' => $data->caja_id,
                'fecha' => date('Y-m-d', strtotime(Carbon::now())),
                'hora' => date('H:i:s', strtotime(Carbon::now())),
                'concepto' => 'Venta realizadas',
                'tipo' => 'ingreso',
                'monto' => $data->importe,
                'venta_id' => $venta_id,
                'user_id' => Auth::user()->id
            ]);
            DB::table('ie_cajas')->where('id', $data->caja_id)->increment('monto_final', $data->importe);
            DB::table('ie_cajas')->where('id', $data->caja_id)->increment('total_ingresos', $data->importe);

            // // si hay dosificaciones generamos codigo de control e incrementamos el numero de factura actual
            // if($dosificacion && $facturacion){
            //     $codigo_control = self::generate($dosificacion->nro_autorizacion, $dosificacion->numero_actual, setting('empresa.nit'), date('Ymd', strtotime($data->fecha)), $data->sub_total, $dosificacion->llave_dosificacion);
            //     DB::table('ventas')->where('id', $venta_id)->update(['codigo_control' => $codigo_control]);
            //     DB::table('dosificaciones')->where('id', $dosificacion->id)->increment('numero_actual', 1);
            // }

            return $venta_id;
        }else{
            return null;
        }
        // ============================

    }

    public function generar_factura($id){
        // obtener el tamaño de factura actual
        // $factura = DB::table('settings')
        //                 ->select('value')
        //                 ->where('id', 25)
        //                 ->first();

        $detalle_venta = DB::table('ventas as v')
                                ->join('ventas_detalles as d', 'd.venta_id', 'v.id')
                                ->join('productos as p', 'p.id', 'd.producto_id')
                                ->join('marcas as m', 'm.id', 'p.marca_id')
                                ->join('clientes as c', 'c.id', 'v.cliente_id')
                                ->select('v.*', 'c.razon_social as cliente', 'c.nit', 'p.nombre as producto', 'd.precio', 'd.cantidad', 'd.producto_adicional', 'd.observaciones')
                                ->where('v.id', $id)
                                ->get();
        $producto_adicional = [];
        foreach ($detalle_venta as $item) {
            $producto = DB::table('productos as p')
                                ->select('p.nombre')
                                ->where('p.id', $item->producto_adicional)
                                ->first();
            if($producto){
                array_push($producto_adicional, ['nombre'=>', '.$producto->nombre]);
            }else{
                array_push($producto_adicional, ['nombre'=>'']);
            }
        }


        // $recibo = false;
        // if($monto_total = $detalle_venta[0]->nro_factura==0){
        //     $recibo = true;
        // }
        // $monto_total = $detalle_venta[0]->importe_base;
        // $total_literal = NumerosEnLetras::convertir($monto_total,'Bolivianos',true);

        return view('facturas.factura_venta', compact('detalle_venta', 'producto_adicional'));
    }

    public function pedidos_store(Request $data){

        if((new LandingPage)->cantidad_pedidos() > 0){
            $alerta = 'pedido_pendiente';
            return redirect()->route('carrito_compra')->with(compact('alerta'));
        }

        // Verificar si el cliente está registrado
        $cliente = Cliente::where('user_id', Auth::user()->id)->first();
        if(!$cliente){
            $cliente = new Cliente;
            $cliente->razon_social = Auth::user()->name;
            $cliente->user_id = Auth::user()->id;
            $cliente->save();
        }

        // Verificar coordenada
        $this->set_ultima_ubicacion(Auth::user()->id, $data);

        $carrito = session()->has('carrito_compra') ? session()->get('carrito_compra') : array();
        if(count($carrito)==0){
            $alerta = 'carrito_vacio';
            return redirect()->route('carrito_compra')->with(compact('alerta'));
        }
        $cantidades = array();
        $precios = array();
        for ($i=0; $i < count($data->cantidad); $i++) {
            array_push($cantidades, $data->cantidad[$i]);
            array_push($precios, $data->precio[$i]);
        }

        $venta_id = $this->crear_venta($data);

        if($venta_id != ''){
            $cont = 0;
            foreach ($carrito as $item) {
                DB::table('ventas_detalles')
                        ->insert([
                            'venta_id' => $venta_id,
                            'producto_id' => $item->id,
                            'precio' => $precios[$cont],
                            'cantidad' => $cantidades[$cont],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                $cont++;
            }
        }

        if($venta_id != ''){
            session()->forget('carrito_compra');
            return redirect()->route('pedidos_success');
        }else{
            return 0;
        }
    }

    public function estado_update($id, $valor){
        $query = Venta::where('id', $id)->update(['tipo_estado' => $valor]);
        if($query){
            return redirect()->route('ventas_index')->with(['message' => 'El cambio de estado fué actualizado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('ventas_index')->with(['message' => 'Ocurrio un problema al actualizar el estado.', 'alert-type' => 'error']);
        }
    }

    public function asignar_repartidor(Request $data){
        // Cambiar estado de la venta
        Venta::where('id', $data->id)->update(['tipo_estado' => 4]);

        // Asignar repartidor
        $repartidores_pedidos = new RepartidoresPedido;
        $repartidores_pedidos->repartidor_id = $data->repartidor_id;
        $repartidores_pedidos->pedido_id = $data->id;
        $repartidores_pedidos->estado = 1;
        $query = $repartidores_pedidos->save();

        if($query){
            return redirect()->route('ventas_index')->with(['message' => 'Pedido asignado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('ventas_index')->with(['message' => 'Ocurrio un problema al asignar el pedido.', 'alert-type' => 'error']);
        }

    }

    public function delivery_index(){
        $registros = DB::table('empleados as e')
                            ->join('repartidores_pedidos as rp', 'rp.repartidor_id', 'e.id')
                            ->join('ventas as v', 'v.id', 'rp.pedido_id')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.id', 'c.razon_social', 'v.importe_base', 'v.tipo_estado', 'v.created_at')
                            ->where('e.user_id', Auth::user()->id)
                            ->orderBy('rp.id', 'DESC')
                            ->paginate(10);
        // dd($registros);
        $value = '';
        return view('ventas.delivery/delivery_index', compact('registros', 'value'));
    }

    public function delivery_view($id){
        $pedido = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->join('users_coordenadas as co', 'co.user_id', 'c.user_id')
                            ->select('v.id as venta_id', 'co.*')
                            ->where('v.id', $id)
                            ->where('co.ultima_ubicacion', 1)
                            ->first();
        $detalle_pedido = DB::table('ventas_detalles as dv')
                            ->join('productos as p', 'p.id', 'dv.producto_id')
                            ->join('monedas as m', 'm.id', 'p.moneda_id')
                            ->select('p.*', 'dv.cantidad as cantidad_pedido', 'dv.precio as precio_pedido', 'm.abreviacion as moneda')
                            ->where('dv.venta_id', $id)
                            ->get();
        $repartidor_pedido = DB::table('repartidores_pedidos as r')
                                ->select('r.*')
                                ->where('r.pedido_id', $id)
                                ->first();
        // dd($registros);
        return view('ventas.delivery/delivery_view', compact('pedido', 'detalle_pedido', 'repartidor_pedido'));
    }

    public function set_ubicacion($id, $lat, $lon){
        $query = DB::table('repartidores_ubicaciones')
                        ->insert([
                            'repartidor_pedido_id' => $id,
                            'lat' => $lat,
                            'lon' => $lon,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
        return 1;
    }

    public function get_ubicacion($id){
        $data =  DB::table('repartidores_pedidos as r')
                        ->join('repartidores_ubicaciones as ru', 'ru.repartidor_pedido_id', 'r.id')
                        ->select('ru.lat', 'ru.lon')
                        ->where('r.pedido_id', $id)
                        ->orderBy('ru.id', 'DESC')
                        ->limit(1)
                        ->get();
        return $data;
    }

    public function get_ubicaciones_cliente($cliente_id){
        $user_id = Cliente::where('id', $cliente_id)->first()->user_id;
        if($user_id){
            return UsersCoordenada::where('user_id', $user_id)->where('descripcion', '<>', '')->orderBy('concurrencia', 'DESC')->limit(5)->get();
        }else{
            return [];
        }
    }

    public function set_ultima_ubicacion($user_id, $data){
        // Verificar coordenada
        UsersCoordenada::where('user_id', $user_id)->update(['ultima_ubicacion' => NULL]);
        if(empty($data->coordenada_id)){
            $coordenadas = new UsersCoordenada;
            $coordenadas->user_id = $user_id;
            $coordenadas->lat = $data->lat;
            $coordenadas->lon = $data->lon;
            $coordenadas->descripcion = $data->descripcion;
            $coordenadas->concurrencia = 1;
            $coordenadas->ultima_ubicacion = 1;
            $coordenadas->save();

        }else{
            // Setear ubicación actual
            UsersCoordenada::where('user_id', $user_id)
                                ->where('id',$data->coordenada_id)
                                ->update(['ultima_ubicacion' => 1]);
            // Incrementar concurrencia a ubicacion
            UsersCoordenada::where('user_id', $user_id)
                                ->where('id',$data->coordenada_id)
                                ->increment('concurrencia', 1);
        }
    }

    public function crear_venta($data){

        $cliente_id = isset($data->cliente_id) ? $data->cliente_id : '';

        if(empty($cliente_id)){
            $cliente_id = Cliente::where('user_id', Auth::user()->id)->first()->id;
            // $cliente_id = $cliente->id;
        }

        if($data->tipo == 'domicilio'){
            $user = Cliente::where('id', $cliente_id)->first();
            if(!$user->user_id){
                User::create([
                    'name' => $user->razon_social,
                    'email' => str_replace(' ', '', $user->razon_social).'.'.$user->user_id.'@loginweb.net',
                    'password' => Hash::make(str_random(10)),
                ]);
                $user_id = User::all()->last()->id;
            }else{
                $user_id = $user->user_id;
            }

            $this->set_ultima_ubicacion($user_id, $data);

        }

        // Nota: Falta obtener datos de facturación

        // Filtrar datos que no existen cuando se hace un pedido
        $nro_factura = isset($data->nro_factura) ? $data->nro_factura : NULL;
        $codigo_control = isset($data->codigo_control) ? $data->codigo_control : NULL;
        $nro_autorizacion = isset($data->nro_autorizacion) ? $data->nro_autorizacion : NULL;
        $fecha_limite = isset($data->fecha_limite) ? $data->fecha_limite : NULL;
        $importe_ice = isset($data->importe_ice) ? $data->importe_ice : 0;
        $importe_exento = isset($data->importe_exento) ? $data->importe_exento : 0;
        $tasa_cero = isset($data->tasa_cero) ? $data->tasa_cero : 0;
        $subtotal = $data->importe - $importe_ice - $importe_exento - $tasa_cero;
        $descuento = isset($data->descuento) ? $data->descuento : 0;
        $importe_base = $subtotal - $descuento;
        // Nota: Calcula el debito fisacal (13%)
        $debito_fiscal = $importe_base * 0.13;
        $cobro_adicional = isset($data->cobro_adicional) ? $data->cobro_adicional : 0;
        $caja_id = isset($data->caja_id) ? $data->caja_id : NULL;
        $autorizacion_id = isset($data->autorizacion_id) ? $data->autorizacion_id : NULL;
        $monto_recibido = isset($data->monto_recibido) ? $data->monto_recibido : 0;

        switch ($data->tipo) {
            case 'venta':
                $tipo_estado = '5';
                break;
            case 'llevar':
                $tipo_estado = '2';
                break;
            case 'pedido':
                $tipo_estado = '1';
                break;
            case 'domicilio':
                $tipo_estado = '1';
                break;
            default:
                $tipo_estado = '1';
                break;
        }
        $nro_mesa = isset($data->nro_mesa) ? $data->nro_mesa : NULL;

        $venta = new Venta;

        $venta->cliente_id = $cliente_id;
        $venta->fecha = date('Y-m-d');
        $venta->nro_factura = $nro_factura;
        $venta->codigo_control = $codigo_control;
        $venta->estado = 'V';
        $venta->nro_autorizacion =$nro_autorizacion;
        $venta->fecha_limite = $fecha_limite;
        $venta->importe = $data->importe;
        $venta->importe_ice = $importe_ice;
        $venta->importe_exento = $importe_exento;
        $venta->tasa_cero = $tasa_cero;
        $venta->subtotal = $subtotal;
        $venta->descuento = $descuento;
        $venta->importe_base = $importe_base;
        $venta->debito_fiscal = $debito_fiscal;
        $venta->cobro_adicional = $cobro_adicional;
        $venta->caja_id = $caja_id;
        $venta->user_id = Auth::user()->id;
        $venta->tipo = $data->tipo;
        $venta->tipo_estado = $tipo_estado;
        $venta->nro_mesa = $nro_mesa;
        $venta->autorizacion_id = $autorizacion_id;
        $venta->monto_recibido = $monto_recibido;
        $venta->observaciones = $data->observaciones;

        $venta->save();
        return Venta::all()->last()->id;
    }

    public function pedidos_success(){
        $sucursal = DB::table('sucursales')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->first();
        switch (setting('admin.modo_sistema')) {
            case 'boutique':

                break;
            case 'electronica_computacion':
                return view('ecommerce/computacion_electronica/agradecimiento', compact('sucursal'));
                break;
            case 'restaurante':
                return view('ecommerce/restaurante/agradecimiento');
                break;
            default:
                # code...
                break;
        }
    }
}


