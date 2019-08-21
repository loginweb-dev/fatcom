<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use NumerosEnLetras;

// Nota: Agregar Caja para usar eloquent
use App\Venta;
use App\Cliente;
use App\ClientesCoordenada;
use App\RepartidoresPedido;
use App\User;
use App\Sucursale;
use App\UsersSucursale;
use App\Producto;


use App\Http\Controllers\ProductosController as Productos;
use App\Http\Controllers\OfertasController as Ofertas;
use App\Http\Controllers\LandingPageController as LandingPage;
use App\Http\Controllers\DosificacionesController as Dosificacion;
use App\Http\Controllers\FacturasController as Facturacion;


// Impresora
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        // Obetener el tamaño de la factura o recibo
        $tamanio = DB::table('settings')
                            ->select('value')
                            ->where('id', 26)
                            ->first()->value;

        $consulta = '1';
        switch (Auth::user()->role_id) {
            case '5':
                $consulta = " v.venta_tipo_id = '3'";
                break;
            case '6':
                $consulta = " v.venta_estado_id = '2'";
                break;
            default:
                break;
        }

        $registros = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->join('ventas_estados as ve', 've.id', 'v.venta_estado_id')
                            ->join('ventas_tipos as vt', 'vt.id', 'v.venta_tipo_id')
                            ->select('v.*', 'c.razon_social as cliente', 'vt.nombre as tipo_nombre', 'vt.etiqueta as tipo_etiqueta', 've.id as estado_id', 've.nombre as estado_nombre', 've.etiqueta as estado_etiqueta')
                            ->whereRaw($consulta)
                            ->orderBy('v.id', 'DESC')
                            ->paginate(20);
        $delivery = DB::table('empleados as e')
                            ->join('users as u', 'u.id', 'e.user_id')
                            ->select('e.*', 'u.name as nombre')
                            // ->orderBy('r.nombre', 'ASC')
                            ->get();
        $ultima_venta = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.id')
                            ->orderBy('v.id', 'DESC')
                            ->first();
        $ultima_venta = $ultima_venta ? $ultima_venta->id : 0;

        // Obtener siguiente estado de la venta
        $siguiente_estado = [];
        foreach ($registros as $item) {

            $aux = DB::table('ventas_detalle_tipo_estados as d')
                                ->join('ventas_estados as e', 'e.id', 'd.venta_estado_id')
                                ->select('e.id', 'e.nombre', 'e.etiqueta', 'e.icono')
                                ->where('d.venta_tipo_id', $item->venta_tipo_id)
                                ->where('e.id', '>', $item->venta_estado_id)->first();
            array_push($siguiente_estado, $aux);
        }
        // dd($registros);
        $value = '';
        return view('ventas.ventas_index', compact('registros', 'value', 'delivery', 'ultima_venta', 'siguiente_estado', 'tamanio'));
    }

    public function search($value){
        // Obetener el tamaño de la factura o recibo
        $tamanio = DB::table('settings')
                            ->select('value')
                            ->where('id', 26)
                            ->first()->value;

        $value = ($value != 'all') ? $value : '';

        $consulta = '1';
        switch (Auth::user()->role_id) {
            case '5':
                $consulta = " v.venta_tipo_id = '3'";
                break;
            case '6':
                $consulta = " v.venta_estado_id = '2'";
                break;
            default:
                break;
        }

        $registros = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->join('ventas_estados as ve', 've.id', 'v.venta_estado_id')
                            ->join('ventas_tipos as vt', 'vt.id', 'v.venta_tipo_id')
                            ->select('v.*', 'c.razon_social as cliente', 'vt.nombre as tipo_nombre', 'vt.etiqueta as tipo_etiqueta', 've.id as estado_id', 've.nombre as estado_nombre', 've.etiqueta as estado_etiqueta')
                            ->whereRaw($consulta." and
                                            (c.razon_social like '%".$value."%' or
                                             vt.nombre like '%".$value."%' or
                                             ve.nombre like '%".$value."%')
                                        ")
                            ->orderBy('v.id', 'DESC')
                            ->paginate(20);
        $delivery = DB::table('empleados as e')
                            ->join('users as u', 'u.id', 'e.user_id')
                            ->select('e.*', 'u.name as nombre')
                            // ->orderBy('r.nombre', 'ASC')
                            ->get();
        $ultima_venta = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.id')
                            ->orderBy('v.id', 'DESC')
                            ->first();
        $ultima_venta = $ultima_venta ? $ultima_venta->id : 0;

        // Obtener siguiente estado de la venta
        $siguiente_estado = [];
        foreach ($registros as $item) {

            $aux = DB::table('ventas_detalle_tipo_estados as d')
                                ->join('ventas_estados as e', 'e.id', 'd.venta_estado_id')
                                ->select('e.id', 'e.nombre', 'e.etiqueta', 'e.icono')
                                ->where('d.venta_tipo_id', $item->venta_tipo_id)
                                ->where('e.id', '>', $item->venta_estado_id)->first();
            array_push($siguiente_estado, $aux);
        }

        return view('ventas.ventas_index', compact('registros', 'value', 'delivery', 'ultima_venta', 'siguiente_estado', 'tamanio'));
    }

    public function get_nuevos_pedidos($ultimo){
        return DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->join('ventas_estados as ve', 've.id', 'v.venta_estado_id')
                            ->select('v.*', 'c.razon_social as cliente', 've.id as estado_id', 've.nombre as estado_nombre', 've.etiqueta as estado_etiqueta')
                            ->where('v.id', '>', $ultimo)
                            ->where('v.venta_estado_id', 1)
                            ->orderBy('v.id', 'DESC')
                            ->get();
    }

    public function view($id){
        $venta = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->join('ventas_estados as ve', 've.id', 'v.venta_estado_id')
                            ->join('ventas_tipos as vt', 'vt.id', 'v.venta_tipo_id')
                            ->select('v.*', 'c.razon_social as cliente', 'c.nit', 'vt.nombre as tipo_nombre', 've.id as estado_id', 've.nombre as estado_nombre', 've.etiqueta as estado_etiqueta')
                            ->where('v.id', $id)
                            ->first();
        $detalle = DB::table('ventas_detalles as d')
                            ->join('productos as p', 'p.id', 'd.producto_id')
                            ->select('d.*', 'p.nombre as producto')
                            ->where('d.deleted_at', NULL)
                            ->where('d.venta_id', $id)
                            ->get();
        $ubicacion = DB::table('clientes as c')
                            ->join('clientes_coordenadas as cc', 'cc.cliente_id', 'c.id')
                            ->select('cc.*')
                            ->where('c.id', $venta->cliente_id)
                            ->where('ultima_ubicacion', 1)
                            ->first();
        return view('ventas.ventas_view', compact('venta', 'id', 'detalle', 'ubicacion'));
    }

    public function create(){
        // Obetener el tamaño de la factura o recibo
        $tamanio = DB::table('settings')
                            ->select('value')
                            ->where('id', 26)
                            ->first()->value;
        // Obtener ultima sucursal del usuario
        $sucursal_user = DB::table('users_sucursales')->select('sucursal_id')->where('user_id', Auth::user()->id)->first();
        if($sucursal_user){
            $sucursal_actual = $sucursal_user->sucursal_id;
        }else{
            $sucursal_actual = Sucursale::all()->first()->id;
            UsersSucursale::create([
                'user_id' => Auth::user()->id,
                'sucursal_id' => $sucursal_actual,
            ]);
        }

        $categorias = DB::table('categorias as c')
                            ->join('subcategorias as s', 's.categoria_id', 'c.id')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('c.*')
                            // ->where('p.deleted_at', NULL)
                            ->distinct()
                            ->get();

        $sucursal_user = DB::table('users_sucursales')->select('sucursal_id')->where('user_id', Auth::user()->id)->first();
        $aux = DB::table('ie_cajas as c')
                            ->select('c.*')
                            ->where('c.abierta', 1)
                            ->where('c.sucursal_id', $sucursal_user->sucursal_id)
                            ->first();
        $abierta = false;
        $caja_id = 0;
        if($aux){
            $abierta = true;
            $caja_id = $aux->id;
        }

        $sucursales = Sucursale::where('deleted_at', NULL)->select('id', 'nombre')->get();

        $facturacion = (new Dosificacion)->get_dosificacion();
        return view('ventas.ventas_create', compact('categorias', 'abierta', 'caja_id', 'facturacion', 'tamanio', 'sucursales', 'sucursal_actual'));
    }

    public function productos_search(){
        $sucursal_actual = UsersSucursale::where('user_id', Auth::user()->id)->first()->sucursal_id;

        $categorias = DB::table('categorias')
                            ->select('id', 'nombre')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();

        // Obetener lista de productos a la venta en la sucursal actual
        $productos = (new Productos)->get_productos_venta($sucursal_actual);
        
        return view('ventas.ventas_productos_search', compact('categorias', 'productos'));
    }

    public function productos_categoria($id){
        $sucursal_actual = UsersSucursale::where('user_id', Auth::user()->id)->first()->sucursal_id;

        $subcategorias = DB::table('subcategorias as s')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('s.id', 's.nombre')
                            ->where('s.deleted_at', NULL)
                            ->where('s.categoria_id', $id)
                            ->distinct()
                            ->get();

        // Obetener lista de productos a la venta en la sucursal actual
        $productos = (new Productos)->get_productos_venta($sucursal_actual);

        return view('ventas.ventas_productos_categoria', compact('subcategorias', 'productos'));
    }

    public function store(Request $data){
        // dd($data);
        // validar si exiten productos en la venta
        if(!isset($data->producto_id)){
            return null;
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
        $pedido_pendiente = Venta::where('venta_tipo_id', 3)
                                    ->where('venta_estado_id', '<', 5)
                                    ->where('cliente_id', $data->cliente_id)
                                    ->select()->first();
        if($pedido_pendiente){
            return 'error 1';
        }

        // Si la venta es adimicilio actualizar ultima ubicación del cliente
        if($data->venta_tipo_id == 4){
            $this->set_ultima_ubicacion($data->cliente_id, $data->coordenada_id, $data->lat, $data->lon, $data->descripcion);
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
                            'producto_id' => $data->producto_id[$i],
                            'precio' => $data->precio[$i],
                            'cantidad' => $data->cantidad[$i],
                            'producto_adicional' => $data->adicional_id[$i],
                            'observaciones' => $data->observacion[$i],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                    // Si el producto se almacena en stock descontar la cantidad vendidad
                    if(Producto::find($data->producto_id[$i])->se_almacena){
                        $dp = DB::table('productos_depositos')->select('stock', 'stock_compra')
                                    ->where('producto_id', $data->producto_id[$i])->where('deposito_id', $data->sucursal_id)
                                    ->first();
                        
                        // Si la venta emitió factura se descontará del stock de compra, caso contrario del stock normal
                        // Nota:   la variable stock_secuandario se usará en caso de que el stock primario sea menor a la cantidad
                        //         de producto a vender, para así descontarselo al otro stock y no quede con número negativo.
                        if($data->factura){
                            $stock = $dp->stock_compra;
                            $stock_primario = 'stock_compra';
                            $stock_secundario = 'stock';
                        }else{
                            $stock = $dp->stock;
                            $stock_primario = 'stock';
                            $stock_secundario = 'stock_compra';
                        }

                        // Si el stock seleccionado es menor o igual a la cantidad vendida se decrementa, sino se deja en 0
                        // y se decrementa al stock secundario la resta entre la cantidad vendida y el stock seleccionado
                        if($stock >= $data->cantidad[$i]){
                            DB::table('productos_depositos')
                                    ->where('producto_id', $data->producto_id[$i])->where('deposito_id', $data->sucursal_id)
                                    ->decrement($stock_primario, $data->cantidad[$i]);
                        }else{
                            $monto_sobrante = $data->cantidad[$i] - $stock;
                            DB::table('productos_depositos')
                                    ->where('producto_id', $data->producto_id[$i])->where('deposito_id', $data->sucursal_id)
                                    ->update([$stock_primario => 0]);
                            DB::table('productos_depositos')
                                    ->where('producto_id', $data->producto_id[$i])->where('deposito_id', $data->sucursal_id)
                                    ->decrement($stock_secundario, $monto_sobrante);
                        }

                        // Descontar stock del registro global
                        DB::table('productos')->where('id', $data->producto_id[$i])->decrement('stock', $data->cantidad[$i]);
                    }
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
                'concepto' => 'Venta realizada',
                'tipo' => 'ingreso',
                'monto' => $data->importe - $data->descuento,
                'venta_id' => $venta_id,
                'user_id' => Auth::user()->id
            ]);
            DB::table('ie_cajas')->where('id', $data->caja_id)->increment('monto_final', $data->importe - $data->descuento);
            DB::table('ie_cajas')->where('id', $data->caja_id)->increment('total_ingresos', $data->importe - $data->descuento);

            // Obetner dosificacion
            $dosificacion = (new Dosificacion)->get_dosificacion();
            // si hay dosificaciones generamos codigo de control e incrementamos el numero de factura actual
            if($dosificacion && $data->factura){
                $codigo_control = (new Facturacion)->generate($dosificacion->nro_autorizacion, $dosificacion->numero_actual, setting('empresa.nit'), date('Ymd', strtotime($data->fecha)), $data->importe, $dosificacion->llave_dosificacion);
                DB::table('ventas')->where('id', $venta_id)
                                        ->update([
                                                    'nro_factura'       => $dosificacion->numero_actual,
                                                    'codigo_control'    => $codigo_control,
                                                    'nro_autorizacion'  => $dosificacion->nro_autorizacion,
                                                    'fecha_limite'      => $dosificacion->fecha_limite,
                                                    'autorizacion_id'   => $dosificacion->id,
                                                    ]);
                DB::table('dosificaciones')->where('id', $dosificacion->id)->increment('numero_actual', 1);
            }

            return $venta_id;
        }else{
            return null;
        }
        // ============================

    }

    public function delete(Request $data){
        // Eliminacion provisional para productos que no pertenencen a un almacen
        $query = Venta::where('id', $data->id)->update(['deleted_at' => Carbon::now(), 'estado' => $data->tipo]);
        if($query){
            // Crear un asiento de eliminación en caja
            DB::table('ie_asientos')->where('venta_id', $data->id)->update(['deleted_at' => Carbon::now()]);
            // Incrementar el total de egresos en caja y decrementar el total existente
            DB::table('ie_cajas')->where('id', $data->caja_id)->decrement('total_ingresos', $data->importe);
            DB::table('ie_cajas')->where('id', $data->caja_id)->decrement('monto_final', $data->importe);
            return redirect()->route('ventas_index')->with(['message' => 'Venta eliminada exitosamenete.', 'alert-type' => 'success']);              
        }else{
            return redirect()->route('ventas_index')->with(['message' => 'Ocurrio un problema al eliminar la venta.', 'alert-type' => 'error']);
        }
    }

    public function pedidos_store(Request $data){
        
        if((new LandingPage)->cantidad_pedidos() > 0){
            $alerta = 'pedido_pendiente';
            return redirect()->route('carrito_compra')->with(compact('alerta'));
        }

        // Verificar si el cliente está registrado
        $user = User::find(Auth::user()->id);
        if(!$user->cliente_id){
            $cliente = new Cliente;
            $cliente->razon_social = Auth::user()->name;
            $cliente->save();
            $user = User::where('id', Auth::user()->id)->update(['cliente_id' => $cliente->id]);
        }

        // Verificar coordenadas si el producto se entrega a domicilio
        if(isset($data->tipo_entrega)){
            if($data->tipo_entrega == 'domicilio'){
                $this->set_ultima_ubicacion($data->cliente_id, $data->coordenada_id, $data->lat, $data->lon, $data->descripcion);
            }
        }

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
        $query = Venta::where('id', $id)->update(['venta_estado_id' => $valor]);
        if($query){

            if($valor == 5){
                RepartidoresPedido::where('pedido_id', $id)->update(['estado' => 2]);
            }

            return redirect()->route('ventas_index')->with(['message' => 'El cambio de estado fué actualizado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('ventas_index')->with(['message' => 'Ocurrio un problema al actualizar el estado.', 'alert-type' => 'error']);
        }
    }

    public function asignar_repartidor(Request $data){
        // Cambiar estado de la venta
        Venta::where('id', $data->id)->update(['venta_estado_id' => 4]);
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

    // Administracion de pedidos
    public function delivery_admin_index(){
        $registros = DB::table('empleados as e')
                            ->join('repartidores_pedidos as rp', 'rp.repartidor_id', 'e.id')
                            ->join('ventas as v', 'v.id', 'rp.pedido_id')
                            ->select(DB::raw('e.id, e.nombre, e.movil, e.direccion, count(rp.id) as pedidos'))
                            ->where('v.estado', 'V')
                            ->where('rp.deleted_at', NULL)
                            ->whereRaw('(rp.estado = 1 or rp.estado = 2)')
                            ->groupBy('e.id', 'e.nombre', 'e.movil', 'e.direccion')
                            ->paginate(10);
        return view('ventas.delivery_admin.delivery_index', compact('registros'));
    }

    // Detalle de pedidos de un repartidor
    public function delivery_admin_view($id){
        $registros = DB::table('empleados as e')
                            ->join('repartidores_pedidos as rp', 'rp.repartidor_id', 'e.id')
                            ->join('ventas as v', 'v.id', 'rp.pedido_id')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.id', 'v.nro_venta', 'v.created_at', 'v.importe_base as monto', 'c.razon_social', 'v.importe_base', 'v.venta_estado_id', 'e.nombre', 'rp.estado')
                            ->where('e.id', $id)
                            ->where('v.estado', 'V')
                            ->where('rp.deleted_at', NULL)
                            ->whereRaw('(rp.estado = 1 or rp.estado = 2)')
                            ->orderBy('rp.id', 'DESC')
                            ->get();
        return view('ventas.delivery_admin.delivery_view', compact('registros', 'id'));
    }

    // Pedidos cerrados por administrador
    public function delivery_admin_close($id){
        $pedidos = DB::table('empleados as e')
                            ->join('repartidores_pedidos as rp', 'rp.repartidor_id', 'e.id')
                            ->join('ventas as v', 'v.id', 'rp.pedido_id')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.id')
                            ->where('e.id', $id)
                            ->where('v.estado', 'V')
                            ->where('rp.deleted_at', NULL)
                            ->whereRaw('(rp.estado = 1 or rp.estado = 2)')
                            ->orderBy('rp.id', 'DESC')
                            ->get();
        $cont_pedidos = count($pedidos);
        $cont_updates = 0;
        foreach ($pedidos as $item) {
            $query = Venta::where('id', $item->id)->update(['venta_estado_id' => 5]);
            $query = RepartidoresPedido::where('pedido_id', $item->id)->update(['estado' => 3]);
            $cont_updates++;
        }
        
        if($cont_updates == $cont_pedidos){
            return redirect()->route('delivery_admin_index')->with(['message' => 'Pedidoscerrados exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('delivery_admin_index')->with(['message' => 'Ocurrio un problema al cerrar los pedidos.', 'alert-type' => 'error']);
        }
    }

    // Lista de pedidos que tiene un repartidor
    public function delivery_index(){
        $registros = DB::table('empleados as e')
                            ->join('repartidores_pedidos as rp', 'rp.repartidor_id', 'e.id')
                            ->join('ventas as v', 'v.id', 'rp.pedido_id')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.id', 'c.razon_social', 'v.importe_base', 'v.venta_estado_id', 'v.created_at', 'rp.estado')
                            ->where('e.user_id', Auth::user()->id)
                            ->where('v.estado', 'V')
                            ->where('rp.deleted_at', NULL)
                            ->whereRaw('(rp.estado = 1 or rp.estado = 2)')
                            ->orderBy('rp.id', 'DESC')
                            ->paginate(10);
        $value = '';
        return view('ventas.delivery.delivery_index', compact('registros', 'value'));
    }

    // Lista de pedidos que tiene un repartidor
    public function delivery_search($value){
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('empleados as e')
                            ->join('repartidores_pedidos as rp', 'rp.repartidor_id', 'e.id')
                            ->join('ventas as v', 'v.id', 'rp.pedido_id')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.id', 'c.razon_social', 'v.importe_base', 'v.venta_estado_id', 'v.created_at', 'rp.estado')
                            ->where('e.user_id', Auth::user()->id)
                            ->where('v.estado', 'V')
                            ->where('rp.deleted_at', NULL)
                            ->whereRaw("(rp.estado = 1 or rp.estado = 2) and (c.razon_social like '%".$value."%')")
                            ->orderBy('rp.id', 'DESC')
                            ->paginate(10);
        return view('ventas.delivery.delivery_index', compact('registros', 'value'));
    }

    // Vista del detalle de un pedido asignado a un repartidor
    public function delivery_view($id){
        $pedido = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->join('clientes_coordenadas as cc', 'cc.cliente_id', 'c.id')
                            ->select('v.id as venta_id', 'v.descuento', 'v.importe_base', 'v.cobro_adicional', 'cc.*', 'c.razon_social', 'c.movil')
                            ->where('v.id', $id)
                            ->where('cc.ultima_ubicacion', 1)
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
        return view('ventas.delivery/delivery_view', compact('id' ,'pedido', 'detalle_pedido', 'repartidor_pedido'));
    }

    // Pedido entregado
    public function delivery_close($id){
        $query = RepartidoresPedido::where('pedido_id', $id)->update(['estado' => 2]);
        if($query){
            return redirect()->route('delivery_index')->with(['message' => 'Pedido entregado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('delivery_index')->with(['message' => 'Ocurrio un problema al actualizar el estado del pedido.', 'alert-type' => 'error']);
        }
    }

    // Envío de ubicacion actual del repartidor
    public function set_ubicacion($id, $lat, $lon){
        $ultima_ubicacion = DB::table('repartidores_ubicaciones')
                                    ->select('lon', 'lat')
                                    ->where('repartidor_pedido_id', $id)
                                    ->orderBy('id', 'DESC')
                                    ->first();
        if($ultima_ubicacion){
            if($ultima_ubicacion->lon != $lon && $ultima_ubicacion->lat != $lat){
                DB::table('repartidores_ubicaciones')
                            ->insert([
                                'repartidor_pedido_id' => $id,
                                'lat' => $lat,
                                'lon' => $lon,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
            }
        }else{
            DB::table('repartidores_ubicaciones')
                            ->insert([
                                'repartidor_pedido_id' => $id,
                                'lat' => $lat,
                                'lon' => $lon,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
        }
        return 1;
    }

    // obetener la ubicación actual del repartidos asignado a un pedido
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

    // Obtener lista de ubicaciones frecuentes de un cliente
    public function get_ubicaciones_cliente($cliente_id){
        return ClientesCoordenada::where('cliente_id', $cliente_id)
                                    ->where('descripcion', '<>', '')
                                    ->orderBy('concurrencia', 'DESC')->limit(5)->get();
    }

    // Asignar la ultima ubicación de un cliente
    public function set_ultima_ubicacion($cliente_id, $coordenada_id, $lat, $lon, $descripcion){
        // Verificar coordenada
        ClientesCoordenada::where('cliente_id', $cliente_id)->update(['ultima_ubicacion' => NULL]);
        if(empty($coordenada_id)){
            $coordenadas = new ClientesCoordenada;
            $coordenadas->cliente_id = $cliente_id;
            $coordenadas->lat = $lat;
            $coordenadas->lon = $lon;
            $coordenadas->descripcion = $descripcion;
            $coordenadas->concurrencia = 1;
            $coordenadas->ultima_ubicacion = 1;
            $coordenadas->save();

        }else{
            // Setear ubicación actual
            ClientesCoordenada::where('cliente_id', $cliente_id)
                                ->where('id',$coordenada_id)
                                ->update(['ultima_ubicacion' => 1]);
            // Incrementar concurrencia a ubicacion
            ClientesCoordenada::where('cliente_id', $cliente_id)
                                ->where('id',$coordenada_id)
                                ->increment('concurrencia', 1);
        }
    }

    // Función creada para utilizarla tanto para crear una venta normal o realizar un pedido por parte de un cliente
    public function crear_venta($data){

        // Filtrar datos que no existen cuando se hace un pedido
        $sucursal_id = isset($data->sucursal_id) ? $data->sucursal_id : NULL;
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
        $cobro_adicional_factura = isset($data->cobro_adicional_factura) ? 1 : 0;
        $caja_id = isset($data->caja_id) ? $data->caja_id : NULL;
        $autorizacion_id = isset($data->autorizacion_id) ? $data->autorizacion_id : NULL;
        $monto_recibido = isset($data->monto_recibido) ? $data->monto_recibido : 0;

        $venta_estado_id = DB::table('ventas_detalle_tipo_estados as d')
                                ->join('ventas_estados as e', 'e.id', 'd.venta_estado_id')
                                ->select('d.venta_estado_id')
                                ->where('d.venta_tipo_id', $data->venta_tipo_id)
                                ->first()->venta_estado_id;

        $nro_mesa = isset($data->nro_mesa) ? $data->nro_mesa : NULL;

        $venta = new Venta;

        $venta->sucursal_id = $sucursal_id;
        $venta->nro_venta = ($caja_id) ? Venta::where('caja_id', $caja_id)->count() + 1 : NULL;
        $venta->cliente_id = $data->cliente_id;
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
        $venta->cobro_adicional_factura = $cobro_adicional_factura;        
        $venta->caja_id = $caja_id;
        $venta->user_id = Auth::user()->id;
        $venta->venta_tipo_id = $data->venta_tipo_id;
        $venta->venta_estado_id = $venta_estado_id;
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
        return view('ecommerce/agradecimiento');
    }

    // Ipresion de factura y recibo

    public function generar_impresion($tipo, $id){
        if($tipo == 'rollo'){
            return $this->imprimir_rollo($id);
        }else{
            return $this->imprimir_normal($id);
        }
    }

    public function imprimir_normal($id){
        $detalle_venta = DB::table('ventas as v')
                                ->join('ventas_detalles as d', 'd.venta_id', 'v.id')
                                ->join('ventas_tipos as vt', 'vt.id', 'v.venta_tipo_id')
                                ->join('productos as p', 'p.id', 'd.producto_id')
                                ->join('marcas as m', 'm.id', 'p.marca_id')
                                ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                ->join('clientes as c', 'c.id', 'v.cliente_id')
                                ->select('v.*', 'vt.nombre as tipo_nombre', 'c.razon_social as cliente', 'c.nit', 'p.nombre as producto', 'd.precio', 'd.cantidad', 'd.producto_adicional', 'd.observaciones', 's.nombre as subcategoria')
                                ->where('v.id', $id)
                                ->get();
        // En caso de que el item de venta comprenda más de un producto
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

        $monto_total = $detalle_venta[0]->importe_base;
        $total_literal = NumerosEnLetras::convertir($monto_total,'Bolivianos',true);

        if(!$detalle_venta[0]->nro_factura){
            return view('facturas.recibo_venta', compact('detalle_venta', 'producto_adicional'));
        }else{
            $original = true;
            return view('facturas.factura_venta', compact('detalle_venta', 'producto_adicional', 'total_literal', 'original'));
        }
    }

    public function imprimir_rollo($id){
        $venta = DB::table('ventas as v')
                                    ->join('ventas_detalles as d', 'd.venta_id', 'v.id')
                                    ->join('ventas_tipos as vt', 'vt.id', 'v.venta_tipo_id')
                                    ->join('productos as p', 'p.id', 'd.producto_id')
                                    ->join('marcas as m', 'm.id', 'p.marca_id')
                                    ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                    ->join('clientes as c', 'c.id', 'v.cliente_id')
                                    ->select('v.*', 'vt.nombre as tipo_nombre', 'c.razon_social as cliente', 'c.nit', 'p.nombre as producto', 'd.precio', 'd.cantidad', 'd.producto_adicional', 'd.observaciones', 's.nombre as subcategoria')
                                    ->where('v.id', $id)
                                    ->get();
        try {
            $connector = new WindowsPrintConnector(setting('impresion.impresora1'));
            $printer = new Printer($connector);

            // TICKET PARA EL CLIENTE
            // Datos de la empresa
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            if(!empty(setting('empresa.title'))){
                $printer->text(setting('empresa.title')."\n");
            }
            if(!empty(setting('empresa.telefono'))){
                $printer->text(setting('empresa.telefono'));
            }
            if(!empty(setting('empresa.telefono')) && !empty(setting('empresa.celular'))){
                $printer->text(setting(' - '));
            }
            if(!empty(setting('empresa.celular'))){
                $printer->text(setting('empresa.celular'));
            }
            $printer->text("\n");
            $printer->text("\n");
            // ======================

            // Datos de la venta
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("TICKET DE VENTA #".$venta[0]->id."\n");
            $printer->selectPrintMode();
            $printer->text("ATENDIDO POR ".Auth::user()->name."\n");
            $printer->text(date("d-m-Y H:i:s") . "\n");
            $printer->text($venta[0]->tipo_nombre."\n");
            $printer->text("\n");
            // =====================
            
            
            // Detalle de productos de la venta
            $printer->text("Detalle\n-------------------------\n");
            $total = 0;
            foreach ($venta as $item) {
                $total += $item->precio*$item->cantidad;
            
                /*Alinear a la izquierda para la cantidad y el nombre*/
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text(intval($item->cantidad). "  " .$item->producto);
            
                /*Y a la derecha para el importe*/
                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $printer->text(' '.$item->precio . "\n");
            }
            // ========================
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("TOTAL: Bs ".number_format($total, 2, '.', '')."\n");

            // Footer
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("-------------------------\n\n");
            $printer->text("Muchas gracias por su compra\n\n");
            // ========================

            $printer->cut();

            // =========================================================

            // TICKET PARA LA COCINA
            // Datos de la venta
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("TICKET DE VENTA #".$venta[0]->id."\n");
            $printer->selectPrintMode();
            $printer->text(date("d-m-Y H:i:s") . "\n");
            $printer->text($venta[0]->tipo_nombre."\n");
            $printer->text("\n");
            // ======================

            // Detalle de productos de la venta
            $printer->text("Detalle\n-------------------------\n");
            $total = 0;
            foreach ($venta as $item) {
                $total += $item->precio*$item->cantidad;
            
                /*Alinear a la izquierda para la cantidad y el nombre*/
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text(intval($item->cantidad). "  " .$item->producto);
            
                /*Y a la derecha para el importe*/
                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $printer->text(' '.$item->precio . "\n");
            }
            // ========================

            // Footer
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("-------------------------\n\n");
            $printer->text("Cliente: ".$venta[0]->cliente."\n\n");
            // =========================

            $printer->cut();

            $printer->pulse();
            $printer-> close();
        } catch (Exception $e) {
            // echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }
}


