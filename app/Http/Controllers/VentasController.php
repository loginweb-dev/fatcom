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
use App\VentasPago;
use App\IeAsiento;
use App\Proforma;
use App\ProformasDetalle;
use App\VentasSeguimiento;
use App\HojasTrabajo;
use App\HojasTrabajosDetalle;

use App\Http\Controllers\ProductosController as Productos;
use App\Http\Controllers\OfertasController as Ofertas;
use App\Http\Controllers\LandingPageController as LandingPage;
use App\Http\Controllers\DosificacionesController as Dosificacion;
use App\Http\Controllers\FacturasController as Facturacion;

// Exportación a Excel
use App\Exports\LibroVentaExport;
use Maatwebsite\Excel\Facades\Excel;

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

        $delivery = DB::table('empleados as e')
                            ->join('users as u', 'u.id', 'e.user_id')
                            ->select('e.*', 'u.name as nombre')
                            // Repartidores es rol 7
                            ->where('u.role_id', 7)
                            ->where('e.deleted_at', NULL)
                            ->get();

        // Obtener ultima sucursal del usuario
        $sucursal_actual = $this->get_user_sucursal();

        $sucursales = Sucursale::where('deleted_at', NULL)->select('id', 'nombre')->get();

        // Verificar si el usuario tiene permiso de cambiar de sucursal
        $cambiar_sucursal = false;
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3){
            $cambiar_sucursal = true;
        }

        $value = '';
        return view('ventas.ventas_index', compact('value', 'delivery', 'tamanio', 'sucursal_actual', 'sucursales', 'cambiar_sucursal'));
    }

    public function ventas_list($sucursal_id, $search){
        $filtro_tipo_venta = Auth::user()->role_id == 5 ? "v.venta_tipo_id = 3" : 1;
        $filtro_sucursal = $sucursal_id != 'all' ? "v.sucursal_id = $sucursal_id" : 1;

        $filtro_search = $search != 'all' ? "(  c.razon_social like '%".$search."%' or
                                                vt.nombre like '%".$search."%' or
                                                ve.nombre like '%".$search."%')" : 1;

        $registros = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->join('ventas_estados as ve', 've.id', 'v.venta_estado_id')
                            ->join('ventas_tipos as vt', 'vt.id', 'v.venta_tipo_id')
                            ->select('v.*', 'c.razon_social as cliente', 'vt.nombre as tipo_nombre', 'vt.etiqueta as tipo_etiqueta', 've.id as estado_id', 've.nombre as estado_nombre', 've.etiqueta as estado_etiqueta', 'v.deleted_at as siguiente_estado')
                            ->whereRaw($filtro_tipo_venta)
                            ->whereRaw($filtro_sucursal)
                            ->whereRaw($filtro_search)
                            ->orderBy('v.id', 'DESC')
                            ->paginate(20);
        // Obtener siguiente estado de la venta
        $cont = 0;
        foreach ($registros as $item) {
            $aux = DB::table('ventas_detalle_tipo_estados as d')
                                ->join('ventas_estados as e', 'e.id', 'd.venta_estado_id')
                                ->select('e.id', 'e.nombre', 'e.etiqueta', 'e.icono')
                                ->where('d.venta_tipo_id', $item->venta_tipo_id)
                                ->where('e.id', '>', $item->venta_estado_id)->first();
            $registros[$cont]->siguiente_estado = $aux;
            $cont++;
        }
        return view('ventas.partials.ventas_lista', compact('registros'));
    }

    public function cocinaindex(){
        return view('ventas.ventas_index_cocina');     
     }
 
     public function apicocina(){
        $sucursal_users = DB::table('users_sucursales')->select('sucursal_id')->where('user_id', Auth::user()->id)->where('deleted_at', NULL)->first();
        $sucursal_id = $sucursal_users ? $sucursal_users->sucursal_id : 0;
        $ventas = Venta::with(['items.productoadicional','items.producto.subcategoria'])
                                     ->join('ventas_seguimientos as vs','ventas.id','=','vs.venta_id')
                                     ->join('ventas_tipos as tv','ventas.venta_tipo_id','=','tv.id')
                                     ->join('ventas_estados as ve','vs.venta_estado_id','=','ve.id')
                                     ->selectRaw("ventas.id,ventas.nro_venta,ventas.importe,
                                                 ventas.fecha,ventas.estado,vs.created_at, DATE_FORMAT(vs.created_at, '%H:%i') as hora,
                                                 ADDDATE(vs.created_at, INTERVAL ve.duracion minute) as hora_entrega,
                                                 tv.nombre as tipo_venta,ve.nombre as estado_venta,ve.duracion")
                                     ->where('ventas.venta_estado_id',2)
                                     ->where('ventas.sucursal_id', $sucursal_id)
                                     ->orderBy('ventas.created_at', 'ASC')
                                     ->get();
      return response()->json($ventas);
     }
 
     public function entregar($id){
         $venta = Venta::findOrFail($id);
         $venta->venta_estado_id = 3;
         $venta->update();
       return response()
                                 ->json([
                                     'saved' => 'Se entrego con exito',
                                     'venta' => $venta
                                 ]);
    }

    public function tickets_index(){
        return view('ventas.tickets_index');
    }

    public function tickets_list(){
        $ventas = DB::table('ventas as v')
                        ->join('clientes as c', 'c.id', 'v.cliente_id')
                        ->join('ie_cajas as ca', 'ca.id', 'v.caja_id')
                        ->join('users_sucursales as us', 'us.sucursal_id', 'v.sucursal_id')
                        ->select('v.id', 'v.nro_venta', 'v.created_at', 'v.venta_estado_id', 'c.razon_social as cliente', 'v.deleted_at as productos')
                        ->whereRaw('(v.venta_tipo_id = 1 or v.venta_tipo_id = 2)')
                        ->where('ca.abierta', 1)
                        ->where('us.user_id', Auth::user()->id)
                        ->where('v.estado', 'V')
                        ->whereRaw('(v.venta_estado_id = 5 or v.venta_estado_id= 3)')
                        ->orderBy('v.venta_estado_id', 'ASC')
                        ->orderBy('v.id', 'DESC')
                        ->get();
        $cont = 0;
        foreach ($ventas as $item) {
            $aux = DB::table('productos as p')
                        ->join('ventas_detalles as vd', 'vd.producto_id', 'p.id')
                        ->select('p.nombre', 'vd.cantidad')
                        ->where('vd.venta_id', $item->id)->get();
            $ventas[$cont]->productos = $aux;
            $cont++;
        }
        return view('ventas.partials.tickets_list', compact('ventas'));
    }

    // Obtener publicaciones de Facebook
    public function get_posts(){
        $post = DB::table('publicaciones')
                            ->inRandomOrder()
                            ->where('deleted_at', NULL)
                            ->first();
        return response()->json($post);
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
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->select('d.*', 'p.nombre as producto', 'm.nombre as marca', 't.nombre as talla', 'c.nombre as color', 'p.imagen')
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

    public function create(Request $data){
        // Obetener el tamaño de la factura o recibo
        $tamanio = DB::table('settings')
                            ->select('value')
                            ->where('id', 26)
                            ->first()->value;
        // Obtener ultima sucursal del usuario
        $sucursal_actual = $this->get_user_sucursal();

        $sucursales = Sucursale::where('deleted_at', NULL)->select('id', 'nombre')->get();

        // Verificar si el usuario tiene permiso de cambiar de sucursal
        $cambiar_sucursal = false;
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3){
            $cambiar_sucursal = true;
        }

        $categorias = DB::table('categorias as c')
                            ->join('subcategorias as s', 's.categoria_id', 'c.id')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('c.*')
                            ->where('p.deleted_at', NULL)
                            ->where('c.deleted_at', NULL)
                            ->where('c.id', '>', 1)
                            ->distinct()
                            ->get();

        $aux = DB::table('ie_cajas as c')
                            ->select('c.*')
                            ->where('c.abierta', 1)
                            ->where('c.sucursal_id', $sucursal_actual)
                            ->first();
        $abierta = false;
        $caja_id = 0;
        if($aux){
            $abierta = true;
            $caja_id = $aux->id;
        }

        $facturacion = (new Dosificacion)->get_dosificacion();

        // En caso de recibir un variable de tipo Request la asignamos a proforma_id
        $proforma_id = $data->query('proforma');
        return view('ventas.ventas_create', compact('categorias', 'abierta', 'caja_id', 'facturacion', 'tamanio', 'sucursales', 'sucursal_actual', 'proforma_id', 'cambiar_sucursal'));
    }

    public function productos_search(){
        $sucursal_actual = UsersSucursale::where('user_id', Auth::user()->id)->first()->sucursal_id;

        $categorias = DB::table('categorias')
                            ->select('id', 'nombre')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();

        $productos = $this->get_productos_disponibles($sucursal_actual, 'all', 'all', 'all', 'all', 'all', 'all');

        // dd($productos);
        
        return view('ventas.ventas_productos_search', compact('categorias', 'productos'));
    }

    public function productos_search_barcode($codigo){
        $producto = Producto::where('codigo_barras', $codigo)->first();
        return response()->json(['producto' => $producto]);
    }

    public function ventas_categorias($categoria_id){
        $sucursal_actual = UsersSucursale::where('user_id', Auth::user()->id)->first()->sucursal_id;
        $subcategorias = DB::table('subcategorias as s')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('s.id', 's.nombre')
                            ->where('s.deleted_at', NULL)
                            ->where('s.categoria_id', $categoria_id)
                            ->distinct()
                            ->orderBy('s.nombre', 'ASC')
                            ->limit(8)
                            ->get();
        $productos = $this->get_productos_disponibles($sucursal_actual, $categoria_id, 'all', 'all', 'all', 'all', 'all');
        return view('ventas.ventas_categorias', compact('subcategorias', 'productos'));
    }

    public function ventas_productos_categorias($subcategoria_id){
        $sucursal_actual = UsersSucursale::where('user_id', Auth::user()->id)->first()->sucursal_id;
        // dd($id);
        $productos = $this->get_productos_disponibles($sucursal_actual, 'all', $subcategoria_id, 'all', 'all', 'all', 'all');
        return view('ventas.ventas_productos_categoria', compact('productos'));
    }

    // Obtener productos al realizar filtro
    public function filtro_productos_disponibles($categoria_id, $subcategoria_id, $marca, $talla, $genero, $color){
        $sucursal_actual = UsersSucursale::where('user_id', Auth::user()->id)->first()->sucursal_id;
        $productos = $this->get_productos_disponibles($sucursal_actual, $categoria_id, $subcategoria_id, $marca, $talla, $genero, $color);
        return response()->json($productos);
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
                    $sucursal_id = ($data->caja_id) ? DB::table('ie_cajas')->select('sucursal_id')->where('id', $data->caja_id)->first()->sucursal_id : NULL;
                    if(Producto::find($data->producto_id[$i])->se_almacena){
                        $dp = DB::table('productos_depositos as pd')
                                    ->join('depositos as d', 'd.id', 'pd.deposito_id')
                                    ->select('pd.id', 'pd.stock', 'pd.stock_compra', 'd.id as deposito_id')
                                    ->where('pd.producto_id', $data->producto_id[$i])->where('d.sucursal_id', $sucursal_id)
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
                            DB::table('productos_depositos')->where('id', $dp->id)->decrement($stock_primario, $data->cantidad[$i]);
                        }else{
                            $monto_sobrante = $data->cantidad[$i] - $stock;
                            DB::table('productos_depositos')->where('id', $dp->id)->update([$stock_primario => 0]);
                            DB::table('productos_depositos')->where('id', $dp->id)->decrement($stock_secundario, $monto_sobrante);
                        }

                        // Descontar stock del registro global
                        DB::table('productos')->where('id', $data->producto_id[$i])->decrement('stock', $data->cantidad[$i]);
                    }
                }
            }

            // crear el asiento de ingreso si el pago es en efectivo
            $efectivo = isset($data->efectivo) ? false : true;
            if($efectivo){

                // Crear asiento de ingreso si no es un pedido a domicilio
                if($data->venta_tipo_id != 4){
                    $monto_venta = $data->importe - $data->descuento;
                    $this->crear_asiento_venta($venta_id, $monto_venta, $data->caja_id, 'Venta realizada');
                }

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
            }
            

            // Si es una venta a credito crear un registro de pago
            if(isset($data->credito) && $data->monto_recibido){
                VentasPago::create([
                    'venta_id' => $venta_id,
                    'monto' => $data->monto_recibido,
                    'observacion' => 'Primer pago',
                    'user_id' => Auth::user()->id,
                ]);
            }

            return $venta_id;
        }else{
            return null;
        }
        // ============================

    }

    public function ventas_details($id){
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

        $monto_total = $detalle_venta[0]->importe_base;
        $total_literal = NumerosEnLetras::convertir($monto_total,'Bolivianos',true);

        return view('ventas.partials.ventas_detalles', compact('detalle_venta', 'total_literal'));
    }

    public function convertir_factura(Request $request){
        // Obetner dosificacion
        $dosificacion = (new Dosificacion)->get_dosificacion();
        // si hay dosificaciones generamos codigo de control e incrementamos el numero de factura actual
        if($dosificacion){
            $venta = Venta::find($request->id);
            $codigo_control = (new Facturacion)->generate($dosificacion->nro_autorizacion, $dosificacion->numero_actual, setting('empresa.nit'), date('Ymd'), $venta->importe_base, $dosificacion->llave_dosificacion);
            DB::table('ventas')->where('id', $request->id)
                                    ->update([
                                                'nro_factura'       => $dosificacion->numero_actual,
                                                'codigo_control'    => $codigo_control,
                                                'nro_autorizacion'  => $dosificacion->nro_autorizacion,
                                                'fecha_limite'      => $dosificacion->fecha_limite,
                                                'autorizacion_id'   => $dosificacion->id,
                                                'fecha'             => date('Y-m-d')
                                                ]);
            DB::table('dosificaciones')->where('id', $dosificacion->id)->increment('numero_actual', 1);
            return 1;
        }
        return 0;
    }

    public function delete(Request $data){
        // Eliminacion provisional para productos que no pertenencen a un almacen
        $query = Venta::where('id', $data->id)->update(['deleted_at' => Carbon::now(), 'estado' => $data->tipo]);
        if($query){

            // Si el producto se almacena en stock agregar la cantidad del detalle de la venta
            $vd = DB::table('ventas_detalles as d')
                            ->join('ventas as v', 'v.id', 'd.venta_id')
                            ->join('productos as p', 'p.id', 'd.producto_id')
                            ->select('d.*', 'v.sucursal_id', 'p.se_almacena', 'v.nro_factura', 'v.venta_tipo_id')
                            ->where('d.venta_id', $data->id)
                            ->get();
                            
            // Quitar registros de caja de las ventas que no sean a domicilio ni pedidos
            if($vd[0]->venta_tipo_id < 3 ){
                // Eliminar asiento de la caja
                DB::table('ie_asientos')->where('venta_id', $data->id)->update(['deleted_at' => Carbon::now()]);
                // Incrementar el total de egresos en caja y decrementar el total existente
                DB::table('ie_cajas')->where('id', $data->caja_id)->decrement('total_ingresos', $data->importe);
                DB::table('ie_cajas')->where('id', $data->caja_id)->decrement('monto_final', $data->importe);
            }

            foreach ($vd as $item) {
                if($item->se_almacena){

                    $stock = ($item->nro_factura) ? 'stock_compra' : 'stock';

                    $pd = DB::table('productos_depositos as pd')
                                ->join('depositos as d', 'd.id', 'pd.deposito_id')
                                ->select('pd.id', 'pd.stock', 'pd.stock_compra', 'd.id as deposito_id')
                                ->where('pd.producto_id', $item->producto_id)->where('d.sucursal_id', $item->sucursal_id)
                                ->first();

                        DB::table('productos_depositos')->where('id', $pd->id)->increment($stock, $item->cantidad);
                    
                    // Descontar stock del registro global
                    DB::table('productos')->where('id', $item->producto_id)->increment('stock', $item->cantidad);
                }
            }
            return 1;
            // return redirect()->route('ventas_index')->with(['message' => 'Venta eliminada exitosamenete.', 'alert-type' => 'success']);              
        }else{
            return 0;
            // return redirect()->route('ventas_index')->with(['message' => 'Ocurrio un problema al eliminar la venta.', 'alert-type' => 'error']);
        }
    }


    // Manejo de pedidos

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

        $venta_id = $this->crear_venta($data);

        if($venta_id != ''){
            $cont = 0;
            foreach ($carrito as $item) {
                DB::table('ventas_detalles')
                        ->insert([
                            'venta_id' => $venta_id,
                            'producto_id' => $item->id,
                            'precio' => $item->precio_venta,
                            'cantidad' => $item->cantidad,
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

        DB::beginTransaction();
        try {
            // Actualizar estado de la venta
            Venta::where('id', $id)->update(['venta_estado_id' => $valor]);
            // Crear registro de seguimiento de la venta
            VentasSeguimiento::create(['venta_id' => $id, 'venta_estado_id' => $valor]);

            if($valor == 5){
                RepartidoresPedido::where('pedido_id', $id)->update(['estado' => 2]);
            }
            DB::commit();
            return response()->json(['success' => 1]);
            // return redirect()->route('ventas_index')->with(['message' => 'El cambio de estado fué actualizado exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrio un problema al actualizar el estado.']);
            // return redirect()->route('ventas_index')->with(['message' => 'Ocurrio un problema al actualizar el estado.', 'alert-type' => 'error']);
        }
    }

    public function asignar_repartidor(Request $data){

        DB::beginTransaction();
        try {
            // Cambiar estado de la venta
            Venta::where('id', $data->id)->update(['venta_estado_id' => 4]);
            // Crear registro de seguimiento de la venta
            VentasSeguimiento::create(['venta_id' => $data->id, 'venta_estado_id' => 4]);
            // Asignar repartidor
            $repartidores_pedidos = new RepartidoresPedido;
            $repartidores_pedidos->repartidor_id = $data->repartidor_id;
            $repartidores_pedidos->pedido_id = $data->id;
            $repartidores_pedidos->estado = 1;
            $query = $repartidores_pedidos->save();

            DB::commit();
            return response()->json(['success' => 1]);
            // return redirect()->route('ventas_index')->with(['message' => 'Pedido asignado exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrio un problema al asignar el pedido.']);
            // return redirect()->route('ventas_index')->with(['message' => 'Ocurrio un problema al asignar el pedido.', 'alert-type' => 'error']);
        }

    }

    // Administracion de pedidos
    public function delivery_admin_index(){
        $registros = DB::table('empleados as e')
                            ->join('repartidores_pedidos as rp', 'rp.repartidor_id', 'e.id')
                            ->join('ventas as v', 'v.id', 'rp.pedido_id')
                            ->select(DB::raw('e.id, e.nombre, e.movil, e.direccion, count(rp.id) as pedidos'))
                            ->where('v.estado', 'V')->where('v.deleted_at', NULL)
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
        $cajas = DB::table('ie_cajas as c')
                            ->join('sucursales as s', 's.id', 'c.sucursal_id')
                            ->select('c.*', 's.nombre as sucursal')
                            ->where('c.abierta', 1)
                            ->where('c.deleted_at', NULL)
                            ->where('s.deleted_at', NULL)
                            ->get();
            return view('ventas.delivery_admin.delivery_view', compact('registros', 'id', 'cajas'));
    }

    // Pedidos cerrados por administrador
    public function delivery_admin_close(Request $request){
        DB::beginTransaction();
        try {
            $pedidos = DB::table('empleados as e')
                                ->join('repartidores_pedidos as rp', 'rp.repartidor_id', 'e.id')
                                ->join('ventas as v', 'v.id', 'rp.pedido_id')
                                ->join('clientes as c', 'c.id', 'v.cliente_id')
                                ->select('v.id', 'v.importe', 'v.efectivo', 'e.nombre as empleado')
                                ->where('e.id', $request->id)
                                ->where('v.estado', 'V')
                                ->where('rp.deleted_at', NULL)
                                ->whereRaw('(rp.estado = 1 or rp.estado = 2)')
                                ->orderBy('rp.id', 'DESC')
                                ->get();
            foreach ($pedidos as $item) {
                Venta::where('id', $item->id)->update(['venta_estado_id' => 5]);
                RepartidoresPedido::where('pedido_id', $item->id)->update(['estado' => 3]);

                // Crear asiento en caja
                if($item->efectivo){
                    $this->crear_asiento_venta($item->id, $item->importe, $request->caja_id, 'Pedido entregado por '.$item->empleado);
                }
            }
            DB::commit();
            return redirect()->route('delivery_admin_index')->with(['message' => 'Pedidos cerrados exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
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
        return view('ventas.delivery.delivery_view', compact('id' ,'pedido', 'detalle_pedido', 'repartidor_pedido'));
    }

    // Pedido entregado
    public function delivery_close($id){
        DB::beginTransaction();
        try {
            // Cambiar estado del delivery
            RepartidoresPedido::where('pedido_id', $id)->update(['estado' => 2]);
            // Cambiar el estado de la venta
            Venta::where('id', $id)->update(['venta_estado_id' => 5]);
            // Crear registro de seguimiento del pedido
            VentasSeguimiento::create([ 'venta_id' => $id, 'venta_estado_id' => 5,]);
            
            DB::commit();
            return redirect()->route('delivery_index')->with(['message' => 'Pedido entregado exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
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

    // Manejo de cuentas por cobrar
    public function ventas_credito_index(){
        $registros = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.*', 'c.razon_social')
                            ->where('v.deleted_at', NULL)
                            ->where('v.estado', 'V')
                            ->where('v.pagada', 0)
                            ->orderBy('v.id', 'DESC')
                            ->paginate(20);
        $cajas = DB::table('ie_cajas as c')
                        ->join('sucursales as s', 's.id', 'c.sucursal_id')
                        ->select('c.*', 's.nombre as sucursal')
                        ->where('c.abierta', 1)
                        ->where('c.deleted_at', NULL)
                        ->where('s.deleted_at', NULL)
                        ->get();

        $value = '';
        return view('ventas.creditos.ventas_credito_index', compact('registros', 'value', 'cajas'));
    }

    public function ventas_credito_search($value){
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.*', 'c.razon_social')
                            ->where('v.deleted_at', NULL)
                            ->where('v.estado', 'V')
                            ->where('v.pagada', 0)
                            ->where('c.razon_social', 'like', "%$value%")
                            ->orderBy('v.id', 'DESC')
                            ->paginate(20);
        $cajas = DB::table('ie_cajas as c')
                        ->join('sucursales as s', 's.id', 'c.sucursal_id')
                        ->select('c.*', 's.nombre as sucursal')
                        ->where('c.abierta', 1)
                        ->where('c.deleted_at', NULL)
                        ->where('s.deleted_at', NULL)
                        ->get();

        
        return view('ventas.creditos.ventas_credito_index', compact('registros', 'value', 'cajas'));
    }

    // Registrar pagos de las ventas a credito
    public function ventas_credito_store(Request $data){
        // dd($data);
        $query = VentasPago::create([
                    'venta_id' => $data->id,
                    'monto' => $data->monto,
                    'observacion' => $data->observacion,
                    'user_id' => Auth::user()->id,
                ]);
        if($query){
            // Incrementar monto recibido por la venta
            DB::table('ventas')->where('id', $data->id)->increment('monto_recibido', $data->monto);
            
            // Buscar la venta y si el monto recibido es igual al importe de la venta actualizar su estado a pagada
            $venta = DB::table('ventas')
                            ->select('importe', 'monto_recibido')
                            ->where('id', $data->id)
                            ->first();
            if($venta->importe == $venta->monto_recibido){
                DB::table('ventas')->where('id', $data->id)->update(['pagada'=> 1]);
            }

            // crear el asiento de ingreso
            $this->crear_asiento_venta($data->id, $data->monto, $data->caja_id, 'Pago de deuda');

            return redirect()->route('ventas_credito_index')->with(['message' => 'Pago de deuda registrado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('ventas_credito_index')->with(['message' => 'Ocurrio un error al registrar el pago.', 'alert-type' => 'error']);
        }
    }

    public function ventas_credito_details($id){
        $detalle = DB::table('ventas_pagos as vp')
                                ->join('ventas as v', 'v.id', 'vp.venta_id')
                                ->join('users as u', 'u.id', 'vp.user_id')
                                ->select('vp.*', 'v.importe', 'v.monto_recibido', 'u.name')
                                ->where('vp.venta_id', $id)
                                ->get();

        return view('ventas.creditos.ventas_credito_details', compact('detalle'));
    }

    // Manejo de proformas
    public function proformas_index(){
        $registros = DB::table('proformas as p')
                ->join('clientes as c', 'c.id', 'p.cliente_id')
                ->select('p.*', 'c.razon_social')
                ->where('p.deleted_at', NULL)
                ->orderBy('p.id', 'DESC')
                ->paginate(20);

        // Obetener el tamaño de la factura o recibo
        $tamanio = DB::table('settings')
        ->select('value')
        ->where('id', 26)
        ->first()->value;

        $value = '';
        return view('ventas.proformas.proformas_index', compact('registros', 'tamanio', 'value'));
    }

    public function proformas_search($value){
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('proformas as p')
                ->join('clientes as c', 'c.id', 'p.cliente_id')
                ->select('p.*', 'c.razon_social')
                ->where('p.deleted_at', NULL)
                ->whereRaw("(c.razon_social like '%$value%' or p.codigo like '%$value%')")
                ->orderBy('p.id', 'DESC')
                ->paginate(20);

        // Obetener el tamaño de la factura o recibo
        $tamanio = DB::table('settings')
        ->select('value')
        ->where('id', 26)
        ->first()->value;

        return view('ventas.proformas.proformas_index', compact('registros', 'tamanio', 'value'));
    }

    public function proformas_create(){
        $categorias = DB::table('categorias')
                            ->select('id', 'nombre')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();

        // Obetener lista de productos a la venta en la sucursal actual
        $productos = DB::table('productos as p')
                            ->join('productos_depositos as pd', 'pd.producto_id', 'p.id')
                            ->join('depositos as d', 'd.id', 'pd.deposito_id')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as ca', 'ca.id', 's.categoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('monedas as mo', 'mo.id', 'p.moneda_id')
                            ->select(   'p.id',
                                        'p.codigo_interno',
                                        'p.codigo',
                                        'p.nombre',
                                        'p.imagen',
                                        'p.precio_venta',
                                        'p.precio_minimo',
                                        'p.stock',
                                        'p.descripcion_small',
                                        'p.se_almacena',
                                        'm.nombre as marca',
                                        't.nombre as talla',
                                        'g.nombre as genero',
                                        's.nombre as subcategoria',
                                        'ca.nombre as categoria',
                                        'c.nombre as color',
                                        'mo.abreviacion as moneda'
                                    )
                            ->where('p.deleted_at', NULL)
                            ->get();

        return view('ventas.proformas.proformas_create', compact('categorias', 'productos'));
    }

    public function proformas_store(Request $data){
        // dd($data);
        $proforma = Proforma::create(['cliente_id' => $data->cliente_id, 'sucursal_id' => $data->sucursal_id]);
        // insertar detalle de la proforma
        if($proforma){
            for ($i=0; $i < count($data->producto_id); $i++) {
                if(!is_null($data->producto_id[$i])){
                    ProformasDetalle::create([
                        'proforma_id' => $proforma->id,
                        'producto_id' => $data->producto_id[$i],
                        'cantidad' => $data->cantidad[$i]
                    ]);
                }
            }

            // Editar codigos de la proforma
            DB::table('proformas')->where('id', $proforma->id)
                    ->update(['codigo' => 'PRO-'.str_pad($proforma->id, 5, "0", STR_PAD_LEFT)]);

            return redirect()->route('proformas_index')->with(['message' => 'Proforma guardada exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('proformas_index')->with(['message' => 'Ocurrio un error al guardar la proforma.', 'alert-type' => 'error']);
        }
    }

    public function proformas_print($tipo, $id){
        if($tipo == 'rollo'){
            // return $this->imprimir_rollo($id);
        }else{
            $detalle_proforma = $this->get_proforma_detalles($id);
            $monto_total = 0;
            foreach($detalle_proforma as $item){
                $monto_total += $item->precio * $item->cantidad;
            }

            $total_literal = NumerosEnLetras::convertir($monto_total,'Bolivianos',true);

            return view('facturas.proforma_venta', compact('detalle_proforma', 'monto_total', 'total_literal'));
        }
    }

    public function proformas_detalle($id){
        $detalle = $this->get_proforma_detalles($id);
        return response()->json($detalle);
    }

    // Obtener detalles de la proforma a partir de su ID
    public function get_proforma_detalles($id){
        return DB::table('proformas as pr')
                    ->join('proformas_detalles as d', 'd.proforma_id', 'pr.id')
                    ->join('productos as p', 'p.id', 'd.producto_id')
                    ->join('marcas as m', 'm.id', 'p.marca_id')
                    ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                    ->join('clientes as c', 'c.id', 'pr.cliente_id')
                    ->select(   'pr.*',
                                'pr.created_at as fecha',
                                'c.razon_social as cliente',
                                'c.nit',
                                'p.nombre as producto',
                                'p.precio_venta as precio',
                                'd.producto_id',
                                'd.cantidad',
                                's.nombre as subcategoria'
                            )
                    ->where('pr.id', $id)
                    ->get();
    }
    // =====================================

    // Manejo de hojas de trabajo
    public function hojas_trabajos_index(){
        $registros = DB::table('hojas_trabajos as ht')
                ->join('empleados as e', 'e.id', 'ht.empleado_id')
                ->select('ht.*', 'e.nombre')
                ->where('ht.deleted_at', NULL)
                ->orderBy('ht.id', 'DESC')
                ->paginate(20);

        // Obetener el tamaño de la factura o recibo
        $tamanio = DB::table('settings')
        ->select('value')
        ->where('id', 26)
        ->first()->value;

        $value = '';
        return view('ventas.hojas_trabajo.hojas_trabajo_index', compact('registros', 'tamanio', 'value'));
    }

    public function hojas_trabajos_search($value){
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('hojas_trabajos as ht')
                ->join('empleados as e', 'e.id', 'ht.empleado_id')
                ->select('ht.*', 'e.nombre')
                ->where('ht.deleted_at', NULL)
                ->whereRaw("(e.nombre like '%$value%' or ht.codigo like '%$value%')")
                ->orderBy('ht.id', 'DESC')
                ->paginate(20);

        // Obetener el tamaño de la factura o recibo
        $tamanio = DB::table('settings')
        ->select('value')
        ->where('id', 26)
        ->first()->value;

        return view('ventas.hojas_trabajo.hojas_trabajo_index', compact('registros', 'tamanio', 'value'));
    }

    public function hojas_trabajos_create(){
        $categorias = DB::table('categorias')
                            ->select('id', 'nombre')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();

        $delivery = DB::table('empleados as e')
                            ->join('users as u', 'u.id', 'e.user_id')
                            ->select('e.*', 'u.name as nombre')
                            // Repartidores es rol 7
                            ->where('u.role_id', 7)
                            ->get();

        // Obtener ultima sucursal del usuario
        $sucursal_actual = $this->get_user_sucursal();

        $sucursales = Sucursale::where('deleted_at', NULL)->select('id', 'nombre')->get();

        // Obetener lista de productos a la venta en la sucursal actual
        $productos = $this->get_productos_disponibles($sucursal_actual, 'all', 'all', 'all', 'all', 'all', 'all');

        return view('ventas.hojas_trabajo.hojas_trabajo_create', compact('categorias', 'sucursal_actual', 'productos', 'delivery', 'sucursales'));
    }

    public function hojas_trabajos_store(Request $data){
        // dd($data);
        if(!isset($data->producto_id)){
            return redirect()->route('hojas_trabajos_create')->with(['message' => 'Debe elegir al menos un producto.', 'alert-type' => 'error']);
        }

        DB::beginTransaction();
        try {
            $hojas_trabajos = HojasTrabajo::create([
                                    'empleado_id' => $data->empleado_id,
                                    'sucursal_id' => $data->sucursal_id,
                                    'estado' => 1
                                ]);

            for ($i=0; $i < count($data->producto_id); $i++) {
                if(!is_null($data->producto_id[$i])){
                    HojasTrabajosDetalle::create([
                        'hoja_trabajo_id' => $hojas_trabajos->id,
                        'producto_id' => $data->producto_id[$i],
                        'cantidad' => $data->cantidad[$i]
                    ]);
                }
            }
            // Editar codigos de la hoja de trabajo
            DB::table('hojas_trabajos')->where('id', $hojas_trabajos->id)
                    ->update(['codigo' => 'HT-'.str_pad($hojas_trabajos->id, 5, "0", STR_PAD_LEFT)]);

            DB::commit();
            return redirect()->route('hojas_trabajos_index')->with(['message' => 'Hoja de trabajo guardada exitosamenete.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('hojas_trabajos_index')->with(['message' => 'Ocurrio un error al guardar la hoja de trabajo.', 'alert-type' => 'error']);
        }
    }

    public function hojas_trabajos_details($id){
        // Obtener ultima sucursal del usuario
        $sucursal_actual = $this->get_user_sucursal();
        
        $aux = DB::table('ie_cajas as c')
                            ->select('c.*')
                            ->where('c.abierta', 1)
                            ->where('c.sucursal_id', $sucursal_actual)
                            ->first();
        $abierta = false;
        $caja_id = 0;
        if($aux){
            $abierta = true;
            $caja_id = $aux->id;
        }

        $registros = $this->get_hojas_trabajos_detalles($id);
        // dd($registros);
        return view('ventas.hojas_trabajo.hojas_trabajo_details', compact('abierta', 'caja_id', 'registros', 'id'));
    }

    public function hojas_trabajos_close(Request $request){
        // dd($request);
        DB::beginTransaction();

        try {
        //    Cliente por defecto
            $cliente_id = 1;
            
            // Crear venta
            $venta = Venta::create([
                'cliente_id' => $cliente_id,
                'importe' => $request->importe,
                'estado' => 'V',
                'subtotal' => $request->importe,
                'importe_base' => $request->importe,
                'fecha' => date('Y-m-d'),
                'venta_tipo_id' => 1,
                'venta_estado_id' => 5,
                'caja_id' => $request->caja_id,
                
            ]);

            // Crear detalle de venta
            for ($i=0; $i < count($request->producto_id); $i++) {
                if(!is_null($request->producto_id[$i])){
                    DB::table('ventas_detalles')
                        ->insert([
                            'venta_id' => $venta->id,
                            'producto_id' => $request->producto_id[$i],
                            'precio' => $request->precio[$i],
                            'cantidad' => $request->cantidad[$i],
                            'producto_adicional' => $request->adicional_id[$i],
                            'observaciones' => $request->observacion[$i],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                    // Si el producto se almacena en stock descontar la cantidad vendidad
                    if(Producto::find($request->producto_id[$i])->se_almacena){
                        $dp = DB::table('productos_depositos as pd')
                                    ->join('depositos as d', 'd.id', 'pd.deposito_id')
                                    ->select('pd.id', 'pd.stock', 'pd.stock_compra', 'd.id as deposito_id')
                                    ->where('pd.producto_id', $request->producto_id[$i])->where('d.sucursal_id', $request->sucursal_id)
                                    ->first();
                        
                        $stock = $dp->stock;
                        $stock_primario = 'stock';
                        $stock_secundario = 'stock_compra';
                        

                        // Si el stock seleccionado es menor o igual a la cantidad vendida se decrementa, sino se deja en 0
                        // y se decrementa al stock secundario la resta entre la cantidad vendida y el stock seleccionado
                        if($stock >= $request->cantidad[$i]){
                            DB::table('productos_depositos')->where('id', $dp->id)->decrement($stock_primario, $request->cantidad[$i]);
                        }else{
                            $monto_sobrante = $request->cantidad[$i] - $stock;
                            DB::table('productos_depositos')->where('id', $dp->id)->update([$stock_primario => 0]);
                            DB::table('productos_depositos')->where('id', $dp->id)->decrement($stock_secundario, $monto_sobrante);
                        }

                        // Descontar stock del registro global
                        DB::table('productos')->where('id', $request->producto_id[$i])->decrement('stock', $request->cantidad[$i]);
                    }
                }
            }

            // crear el asiento de ingreso
            $this->crear_asiento_venta($venta->id, $request->importe, $request->caja_id, 'Venta realizada de la hoja de trabajo '.$request->codigo);

            // ==============================

            // Crear asiento de egreso si se realizó gastos
            if($request->monto_gasto > 0){
                IeAsiento::create([
                    'caja_id' => $request->caja_id,
                    'fecha' => date('Y-m-d', strtotime(Carbon::now())),
                    'hora' => date('H:i:s', strtotime(Carbon::now())),
                    'concepto' => 'Gasto de la hoja de trabajo '.$request->codigo.' : '.$request->detalle_gasto,
                    'tipo' => 'egreso',
                    'monto' => $request->monto_gasto,
                    'user_id' => Auth::user()->id
                ]);
                DB::table('ie_cajas')->where('id', $request->caja_id)->decrement('monto_final', $request->monto_gasto);
                DB::table('ie_cajas')->where('id', $request->caja_id)->increment('total_egresos', $request->monto_gasto);
            }
            // ==============================

            DB::table('hojas_trabajos')
                    ->where('id', $request->id)
                    ->update(['estado' => 2, 'observaciones' => $request->observaciones, 'updated_at' => Carbon::now()]);
        
            DB::commit();
            return redirect()->route('hojas_trabajos_index')->with(['message' => 'Hoja de trabajo cerrada exitosamenete.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('hojas_trabajos_index')->with(['message' => 'Ocurrio un error al cerrar la hoja de trabajo.', 'alert-type' => 'error']);
        }
    }

    public function hojas_trabajos_print($id){
        $hoja_trabajo = $this->get_hojas_trabajos_detalles($id);
        $monto_total = 0;
        foreach($hoja_trabajo as $item){
            $monto_total += $item->precio * $item->cantidad;
        }

        $total_literal = NumerosEnLetras::convertir($monto_total,'Bolivianos',true);

        return view('facturas.hoja_trabajo', compact('hoja_trabajo', 'monto_total', 'total_literal'));
    }

    // Obtener detalles de la proforma a partir de su ID
    public function get_hojas_trabajos_detalles($id){
        return DB::table('hojas_trabajos as ht')
                    ->join('hojas_trabajos_detalles as d', 'd.hoja_trabajo_id', 'ht.id')
                    ->join('productos as p', 'p.id', 'd.producto_id')
                    ->join('marcas as m', 'm.id', 'p.marca_id')
                    ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                    ->join('empleados as e', 'e.id', 'ht.empleado_id')
                    ->select(   'ht.*',
                                'ht.created_at as fecha',
                                'e.nombre as empleado',
                                'd.id as detalle_id',
                                'p.nombre as producto',
                                'p.precio_venta as precio',
                                'd.producto_id',
                                'd.cantidad',
                                's.nombre as subcategoria'
                            )
                    ->where('ht.id', $id)
                    ->get();
    }

    // =======================================


    // *********Generar informe para impuestos nacionales*********

    // libros
    function ventas_libro(){
        return view('ventas.impuestos.ventas_libro');
    }

    function ventas_libro_generar(Request $datos){
        $ventas = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.*', 'c.razon_social as cliente', 'c.nit')
                            ->where('v.codigo_control', '<>', NULL)
                            ->whereMonth('fecha', $datos->mes)
                            ->whereYear('fecha', $datos->anio)
                            ->get();
        $mes = $datos->mes;
        $anio = $datos->anio;
        return view('ventas.impuestos.ventas_libro_generar', compact('ventas', 'mes', 'anio'));
    }

    public function ventas_libro_generar_excel($mes, $anio){
        session(['venta_mes' => $mes, 'venta_anio' => $anio]);
        return Excel::download(new LibroVentaExport, 'Libro_venta-'.$mes.'-'.$anio.'.xlsx');
    }

    public function ventas_libro_generar_pdf($mes, $anio){
        $ventas = DB::table('ventas')
                        ->join('clientes', 'clientes.id', 'ventas.cliente_id')
                        ->select('ventas.*', 'clientes.razon_social as cliente', 'clientes.nit')
                        ->where('ventas.codigo_control', '<>', NULL)
                        ->whereMonth('fecha', $mes)
                        ->whereYear('fecha', $anio)
                        ->get();

        $vista = view('ventas.impuestos.ventas_libro_generar_pdf', compact('ventas', 'anio', 'mes'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista)->setPaper('legal', 'landscape');
        $pdf->loadHTML($vista);
        return $pdf->stream();
    }

    // formularios
    public function ventas_formulario_200_pdf($mes, $anio){
        $ventas = DB::table('ventas')
                        ->select(   DB::raw('SUM(importe) as importe_venta'),
                                    DB::raw('SUM(importe_ice) as importe_ice'),
                                    DB::raw('SUM(importe_exento) as importe_exento'),
                                    DB::raw('SUM(tasa_cero) as tasa_cero'),
                                    DB::raw('SUM(subtotal) as sub_total'),
                                    DB::raw('SUM(descuento) as descuento'),
                                    DB::raw('SUM(importe_base) as importe_base'),
                                    DB::raw('SUM(debito_fiscal) as debito_fiscal')
                                )
                        ->where('codigo_control', '<>', NULL)
                        ->whereMonth('fecha', $mes)
                        ->whereYear('fecha', $anio)
                        ->first();
        $compras = DB::table('compras')
                        ->select(   DB::raw('SUM(importe_compra) as importe_compra'),
                                    DB::raw('SUM(monto_exento) as monto_exento'),
                                    DB::raw('SUM(sub_total) as sub_total'),
                                    DB::raw('SUM(descuento) as descuento'),
                                    DB::raw('SUM(importe_base) as importe_base'),
                                    DB::raw('SUM(credito_fiscal) as credito_fiscal')
                                )
                        ->where('nro_factura', '<>', NULL)
                        ->whereMonth('fecha', $mes)
                        ->whereYear('fecha', $anio)
                        ->first();

        return view('ventas.impuestos.ventas_formulario_200_pdf', compact('ventas', 'compras', 'anio', 'mes'));
        $vista = view('ventas.impuestos.ventas_formulario_200_pdf', compact('ventas', 'compras', 'anio', 'mes'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista)->setPaper('legal', 'portrait');
        $pdf->loadHTML($vista);
        return $pdf->stream();
    }

    public function ventas_formulario_400_pdf($mes, $anio){
        $ventas = DB::table('ventas')
                        ->select(   DB::raw('SUM(importe) as importe_venta'),
                                    DB::raw('SUM(importe_ice) as importe_ice'),
                                    DB::raw('SUM(importe_exento) as importe_exento'),
                                    DB::raw('SUM(tasa_cero) as tasa_cero'),
                                    DB::raw('SUM(subtotal) as sub_total'),
                                    DB::raw('SUM(descuento) as descuento'),
                                    DB::raw('SUM(importe_base) as importe_base'),
                                    DB::raw('SUM(debito_fiscal) as debito_fiscal')
                                )
                        ->where('codigo_control', '<>', NULL)
                        ->whereMonth('fecha', $mes)
                        ->whereYear('fecha', $anio)
                        ->first();
        $compras = DB::table('compras')
                        ->select(   DB::raw('SUM(importe_compra) as importe_compra'),
                                    DB::raw('SUM(monto_exento) as monto_exento'),
                                    DB::raw('SUM(sub_total) as sub_total'),
                                    DB::raw('SUM(descuento) as descuento'),
                                    DB::raw('SUM(importe_base) as importe_base'),
                                    DB::raw('SUM(credito_fiscal) as credito_fiscal')
                                )
                        ->where('nro_factura', '<>', NULL)
                        ->whereMonth('fecha', $mes)
                        ->whereYear('fecha', $anio)
                        ->first();

        return view('ventas.impuestos.ventas_formulario_400_pdf', compact('ventas', 'compras', 'anio', 'mes'));
        $vista = view('ventas.impuestos.ventas_formulario_400_pdf', compact('ventas', 'compras', 'anio', 'mes'));
        $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($vista)->setPaper('a4', 'landscape');
        $pdf->loadHTML($vista);
        return $pdf->stream();
    }


    // Función creada para utilizarla tanto para crear una venta normal o realizar un pedido por parte de un cliente
    public function crear_venta($data){

        // Filtrar datos que no existen cuando se hace un pedido
        // $sucursal_id = isset($data->sucursal_id) ? $data->sucursal_id : NULL;
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
        $sucursal_id = ($caja_id) ? DB::table('ie_cajas')->select('sucursal_id')->where('id', $caja_id)->first()->sucursal_id : NULL;
        $autorizacion_id = isset($data->autorizacion_id) ? $data->autorizacion_id : NULL;
        $monto_recibido = isset($data->monto_recibido) ? $data->monto_recibido : 0;
        $pagada = isset($data->credito) ? 0 : 1;
        $efectivo = isset($data->efectivo) ? 0 : 1;

        $venta_estado_id = DB::table('ventas_detalle_tipo_estados as d')
                                ->join('ventas_estados as e', 'e.id', 'd.venta_estado_id')
                                ->select('d.venta_estado_id')
                                ->where('d.venta_tipo_id', $data->venta_tipo_id)
                                ->where('d.deleted_at', NULL)
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
        $venta->pagada = $pagada;
        $venta->efectivo = $efectivo;
        $venta->user_id = Auth::user()->id;
        $venta->venta_tipo_id = $data->venta_tipo_id;
        $venta->venta_estado_id = $venta_estado_id;
        $venta->nro_mesa = $nro_mesa;
        $venta->autorizacion_id = $autorizacion_id;
        $venta->monto_recibido = $monto_recibido;
        $venta->observaciones = $data->observaciones;

        $venta->save();

        // Crear registro de seguimiento del pedido
        DB::table('ventas_seguimientos')
        ->insert([
            'venta_id' => $venta->id,
            'venta_estado_id' => $venta_estado_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return $venta->id;
    }

    public function pedidos_success(){
        $sucursal = DB::table('sucursales')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->first();
        $mas_vendidos = (new LandingPage)->get_masVendidos();

        return view('ecommerce.'.setting('admin.ecommerce').'agradecimiento', compact('mas_vendidos'));
    }

    public function crear_asiento_venta($venta_id, $monto, $caja_id, $detalle){
        DB::beginTransaction();
        try {
            IeAsiento::create([
                'caja_id' => $caja_id,
                'fecha' => date('Y-m-d', strtotime(Carbon::now())),
                'hora' => date('H:i:s', strtotime(Carbon::now())),
                'concepto' => $detalle,
                'tipo' => 'ingreso',
                'monto' => $monto,
                'venta_id' => $venta_id,
                'user_id' => Auth::user()->id
            ]);
            DB::table('ie_cajas')->where('id', $caja_id)->increment('monto_final', $monto);
            DB::table('ie_cajas')->where('id', $caja_id)->increment('total_ingresos', $monto);
            DB::commit();
            return 0;
        } catch (\Exception $e) {
            DB::rollback();
            return 1;
        }
    }

    // =========Ipresion de factura y recibo=========

    public function ventas_print($tipo, $id){
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
            if(setting('impresion.impresion_rapida')){
                return view('facturas.recibo_venta_aux', compact('detalle_venta', 'producto_adicional', 'total_literal'));
            }else{
                return view('facturas.recibo_venta', compact('detalle_venta', 'producto_adicional', 'total_literal'));
            }
        }else{
            $original = true;
            if(setting('impresion.impresion_rapida')){
                return view('facturas.factura_venta_aux', compact('detalle_venta', 'producto_adicional', 'total_literal', 'original'));
            }else{
                return view('facturas.factura_venta', compact('detalle_venta', 'producto_adicional', 'total_literal', 'original'));
            }            
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

    // Obtener todos los productos de disponibles para la venta
    public function get_productos_disponibles($sucursal_id, $categoria_id, $subcategoria_id, $marca, $talla, $genero, $color){
        
        $filtro_categoria = ($categoria_id != 'all') ? "s.categoria_id = $categoria_id" : 1;
        $filtro_subcategoria = ($subcategoria_id != 'all') ? "s.id = $subcategoria_id" : 1;
        $filtro_marca = ($marca != 'all') ? "m.id = $marca " : 1;
        $filtro_talla = ($talla != 'all') ? "t.id = $talla " : 1;
        $filtro_genero = ($genero != 'all') ? "g.id = $genero " : 1;
        $filtro_color = ($color != 'all') ? "c.id = $color " : 1;
        
        $productos = collect();

        // Obetener lista de productos a la venta en la sucursal actual
        $productos_deposito = DB::table('productos as p')
                            ->join('productos_depositos as pd', 'pd.producto_id', 'p.id')
                            ->join('depositos as d', 'd.id', 'pd.deposito_id')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as ca', 'ca.id', 's.categoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('monedas as mo', 'mo.id', 'p.moneda_id')
                            ->select(   'p.id',
                                        'p.codigo_interno',
                                        'p.codigo',
                                        'p.nombre',
                                        'p.imagen',
                                        'p.precio_venta',
                                        'p.precio_minimo',
                                        DB::raw('(pd.stock + pd.stock_compra) as stock'),
                                        'p.descripcion_small',
                                        'p.se_almacena',
                                        'm.nombre as marca',
                                        't.nombre as talla',
                                        'g.nombre as genero',
                                        's.nombre as subcategoria',
                                        'ca.nombre as categoria',
                                        'c.nombre as color',
                                        'mo.abreviacion as moneda'
                                    )
                            ->where('p.deleted_at', NULL)
                            ->where('p.se_almacena', 1)
                            ->where('p.stock', '>', 0)
                            ->where('d.sucursal_id', $sucursal_id)
                            ->whereRaw($filtro_subcategoria)
                            ->whereRaw($filtro_categoria)
                            ->whereRaw($filtro_marca)
                            ->whereRaw($filtro_talla)
                            ->whereRaw($filtro_genero)
                            ->whereRaw($filtro_color)
                            ->get();
        foreach ($productos_deposito as $item) {
            $productos->push($item);
        }
        // Obetener lista de productos a la venta en todas las sucursales (Productos que no se almacenan)
        $productos_deposito = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as ca', 'ca.id', 's.categoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('monedas as mo', 'mo.id', 'p.moneda_id')
                            ->select(   'p.id',
                                        'p.codigo_interno',
                                        'p.codigo',
                                        'p.nombre',
                                        'p.imagen',
                                        'p.precio_venta',
                                        'p.precio_minimo',
                                        'p.stock',
                                        'p.descripcion_small',
                                        'p.se_almacena',
                                        'm.nombre as marca',
                                        't.nombre as talla',
                                        'g.nombre as genero',
                                        's.nombre as subcategoria',
                                        'ca.nombre as categoria',
                                        'c.nombre as color',
                                        'mo.abreviacion as moneda'
                                    )
                            ->where('p.deleted_at', NULL)
                            ->where('p.se_almacena', NULL)
                            ->whereRaw($filtro_subcategoria)
                            ->whereRaw($filtro_categoria)
                            ->whereRaw($filtro_marca)
                            ->whereRaw($filtro_talla)
                            ->whereRaw($filtro_genero)
                            ->whereRaw($filtro_color)
                            ->get();
        foreach ($productos_deposito as $item) {
            $productos->push($item);
        }

        return $productos;
    }

    // Obtener la sucursal asignada al empleado (Si no tiene ninguna se le asigna para evitar erro 500)
    public function get_user_sucursal(){
        $sucursal_user = DB::table('users_sucursales')->select('sucursal_id')->where('user_id', Auth::user()->id)->where('deleted_at', NULL)->first();
        if($sucursal_user){
            $sucursal_actual = $sucursal_user->sucursal_id;
        }else{
            $sucursal_actual = Sucursale::all()->first()->id;
            UsersSucursale::create([
                'user_id' => Auth::user()->id,
                'sucursal_id' => $sucursal_actual,
            ]);
        }
        return $sucursal_actual;
    }
}