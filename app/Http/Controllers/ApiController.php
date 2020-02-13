<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

use App\Http\Controllers\OfertasController as Ofertas;
use App\Http\Controllers\LandingPageController as LandingPage;
use App\Http\Controllers\VentasController as Ventas;
use App\Http\Controllers\DosificacionesController as Dosificacion;
use App\Http\Controllers\FacturasController as Facturacion;

use App\User;
use App\Cliente;
use App\Producto;
use App\Venta;
use App\ProductosLike;
use App\RepartidoresPedido;
use App\VentasSeguimiento;
use App\Empleado;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $mail = $this->getEmail($request->phone);
        if($mail){
            $credentials = ['email' => $mail->email, 'password' => $request->password];

            if (Auth::attempt($credentials)) {
                $user_id=Auth::user()->id;
                $user = $this->getUser($user_id);
                return response()->json($user);
                
            }else{
                return response()->json(['error' => 'Los datos ingresados son incorretos!']);
            }
        }else{
            return response()->json(['error' => 'El celular ingresado no está registrado']);
        }
    }
    
    public function register(Request $request)
    {
        $phone = $this->getEmail($request->phone);
        if(!$phone){
            DB::beginTransaction();
            try {
                $user = User::create([
                    'name' => $request->name,
                    'email' => str_random(10).'@pizzastatu.com',
                    'localidad_id' => 1,
                    'avatar' => 'users/default_app.png',
                    'tipo_login' => 'app',
                    'password' => Hash::make($request['password']),
                ]);
                
                $cliente = new Cliente;
                $cliente->razon_social = $request->name;
                $cliente->movil = $request->phone;
                $cliente->save();
                User::where('id', $user->id)->update(['cliente_id' => $cliente->id]);
                
                $user = $this->getUser($user->id);
                
                DB::commit();
                return response()->json($user);
                
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => 'Ocurrió un problema al registrar sus datos!']);
            }
        }else{
            return response()->json(['error' => 'El celular ingresado ya está registrado']);
        }
    }
    
    public function update_profile(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            if($request->email){
                $user->email = $request->email;   
            }
            $user->save();
            
            $cliente = Cliente::find($request->cliente_id);
            $cliente->movil = $request->phone;
            $cliente->razon_social = $request->razon;
            $cliente->nit = $request->nit;
            $cliente->save();
            
            $user = $this->getUser($request->id);

            DB::commit();
            return response()->json(['success' => 'Datos actualizados correctamente!', 'user' => $user]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrio un error al actualizar los datos!']);
        }
    }
    
    public function confirm_profile(Request $request)
    {
        DB::beginTransaction();
        try {
            $cliente = Cliente::find($request->cliente_id);
            $cliente->movil = $request->phone;
            $cliente->razon_social = $request->razon;
            $cliente->nit = $request->nit;
            $cliente->save();
            
            $user = $this->getUser($request->id);

            DB::commit();
            return response()->json(['success' => 'Datos actualizados correctamente!', 'user' => $user]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrio un error al confirmar los datos!']);
        }
    }
    
    public function update_profile_delivery(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            
            $empleado = Empleado::find($request->empleado_id);
            $empleado->movil = $request->phone;
            $empleado->direccion = $request->address;
            $empleado->save();
            
            $user = $this->getEmpleado($request->id);

            DB::commit();
            return response()->json(['success' => 'Datos actualizados correctamente!', 'user' => $user]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrio un error al actualizar los datos!']);
        }
    }
    
    public function update_profile_delivery_avatar(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            Storage::makeDirectory('/public/users/'.date('F').date('Y'));
            $file = $request->file('avatar');
            $base_name = str_random(20);
            $filename = $base_name.'.'.$file->getClientOriginalExtension();
            $image_resize = Image::make($file->getRealPath())->orientate();
            $image_resize->resize(256, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->resizeCanvas(256, 256);
            $path =  'users/'.date('F').date('Y').'/'.$filename;
            $image_resize->save(public_path('../storage/app/public/'.$path));
            $user = User::find($id);
            $user->avatar = $path;
            $user->save();
            
            DB::commit();
            return response()->json(['success' => 'Imagen actualizados correctamente.', 'avatar' => $path]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrio un error al actualizar su imagen.']);
        }
    }
    
    public function login_social(Request $request)
    {
        DB::beginTransaction();
        try {
            $email = $request->email ?? $request->id.'@pizzastatu.com';
            $user_data = DB::table('users')->select('*')->where('email', $email)->first();
            // Si el correo ya está registrado
            if($user_data){
                $user = $this->getUser($user_data->id);
                // Si el usuario registrado está asociado a un cliente
                if($user){
                    return response()->json($user);
                }else{
                    $cliente = Cliente::create(['razon_social' => $request->name]);
                    User::where('id', $user_data->id)->update(['cliente_id' => $cliente->id]);
                    $user = $this->getUser($user_data->id);
                    return response()->json($user);
                }
            }
            
            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'localidad_id' => 1,
                'avatar' => $request->avatar,
                'tipo_login' => $request->type_social,
                'password' => Hash::make(str_random(10)),
            ]);
            
            $cliente = Cliente::create(['razon_social' => $request->name]);
            User::where('id', $user->id)->update(['cliente_id' => $cliente->id]);
            
            $user = $this->getUser($user->id);
    
            DB::commit();
            return response()->json($user);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrio un error al obtener los datos de facebook']);
        }
    }
    
    public function login_delivery(Request $request)
    {
        $credentials = ['email' => $request->email, 'password' => $request->password];
        if (Auth::attempt($credentials)) {
            if(Auth::user()->role_id == 7){
                $user = $this->getEmpleado(Auth::user()->id);
                return response()->json($user);   
            }else{
                return response()->json(['error' => 'No tiene permiso de acceso a esta aplicación!']);
            }
        }else{
            return response()->json(['error' => 'Los datos ingresados son incorretos!']);
        }
    }
    
    // Devolver todas las categorías que tienen productos
    public function categories_list(){
        $categorias = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as c', 'c.id', 's.categoria_id')
                            ->select('c.id', 'c.nombre', 'c.descripcion', 'c.imagen')
                            ->whereIn('p.id', function($q){
                                $q->select('producto_id')->from('ecommerce_productos')->where('deleted_at', null);
                            })
                            ->groupBy('c.id', 'c.nombre', 'c.descripcion', 'c.imagen')
                            ->get();

        return response()->json($categorias);
    }
    
    // Devolver los productos de una categoría
    public function products_list_filter($filtro, $id, $user_id){
        $query_filter = '';
        $query_groupBy = '';
        switch($filtro){
            case 'categoryId':
                $query_filter = "c.id = $id";
                $query_groupBy = 'codigo_grupo';
            break;
            case 'codigoGrupo':
                $query_filter = "p.codigo_grupo = $id";
            break;
        }
        
        // Nota: consulta copiadad desde LandingPageController - 165
        $productos = ($filtro === 'categoryId') ?
                        DB::table('productos as p')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as c', 'c.id', 's.categoria_id')
                            ->select(DB::raw("p.id, p.nombre, p.precio_venta, p.imagen, p.descripcion_small, p.vistas, s.nombre as subcategoria, p.codigo_grupo,
                                            (select COUNT(pl.id) from productos_likes as pl where pl.producto_id = p.id and pl.deleted_at is null) as likes,
                                            (select COUNT(pl.id) from productos_likes as pl where pl.producto_id = p.id and pl.user_id = $user_id and pl.deleted_at is null) as like_user,
                                            p.deleted_at as monto_oferta, p.deleted_at as tipo_descuento, p.deleted_at as fin_descuento"))
                            ->where('s.deleted_at', NULL)
                            ->where('e.deleted_at', NULL)
                            ->whereRaw($query_filter)
                            ->groupBy('codigo_grupo')
                            ->paginate(50) :
                        DB::table('productos as p')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as c', 'c.id', 's.categoria_id')
                            ->select(DB::raw("p.id, p.nombre, p.precio_venta, p.imagen, p.descripcion_small, p.vistas, s.nombre as subcategoria, p.codigo_grupo,
                                            (select COUNT(pl.id) from productos_likes as pl where pl.producto_id = p.id and pl.deleted_at is null) as likes,
                                            (select COUNT(pl.id) from productos_likes as pl where pl.producto_id = p.id and pl.user_id = $user_id and pl.deleted_at is null) as like_user,
                                            p.deleted_at as monto_oferta, p.deleted_at as tipo_descuento, p.deleted_at as fin_descuento"))
                            ->where('s.deleted_at', NULL)
                            ->where('e.deleted_at', NULL)
                            ->whereRaw($query_filter)
                            ->paginate(50);
        $cont = 0;
        foreach ($productos as $item) {
            // Obtener si el producto está en oferta
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            if($oferta){
                $productos[$cont]->monto_oferta = $oferta->monto;
                $productos[$cont]->tipo_descuento = $oferta->tipo_descuento;
                $productos[$cont]->fin = $oferta->fin;
            }
            $cont++;
        }
        
        $categoria = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as c', 'c.id', 's.categoria_id')
                            ->select('c.id', 'c.nombre', 'c.descripcion')
                            ->groupBy('c.id', 'c.nombre', 'c.descripcion')
                            ->where('c.id', $id)
                            ->get();
        
        return response()->json(['productos' =>$productos, 'categoria' => $categoria]);
    }
    
    // Ver detalles de un producto
    public function product_details($id){
        $productos = DB::table('productos as p')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as c', 'c.id', 's.categoria_id')
                            ->select(DB::raw('p.id, p.nombre, p.precio_venta, p.imagen, p.descripcion_small, p.vistas, s.nombre as subcategoria, p.codigo_grupo,
                                            (select AVG(puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos,
                                            p.deleted_at as monto_oferta, p.deleted_at as tipo_descuento, p.deleted_at as fin_descuento'))
                            ->where('s.deleted_at', NULL)
                            ->where('e.deleted_at', NULL)
                            ->where('p.id', $id)
                            ->groupBy('p.id', 'p.nombre', 'p.precio_venta', 'p.imagen', 'p.descripcion_small', 'p.vistas', 's.nombre', 'p.codigo_grupo', 'p.deleted_at')
                            ->first();

        if($productos){
            $oferta = (new Ofertas)->obtener_oferta($productos->id);
            if($oferta){
                $productos->monto_oferta = $oferta->monto;
                $productos->tipo_descuento = $oferta->tipo_descuento;
                $productos->fin = $oferta->fin;
            }
        }
        
        return response()->json($productos);
    }
    
    public function product_like($product_id, $state, $user_id){
        // return response()->json(['producto_id' => $product_id, 'state' =>$state, 'user_id' => $user_id]);
        if($state == 'true'){
            ProductosLike::create(['producto_id' => $product_id, 'user_id' => $user_id]);
        }else{
            DB::table('productos_likes')->where('producto_id', $product_id)->where('user_id', $user_id)->update(['deleted_at' => Carbon::now()]);
        }
    }
    
    public function get_locations($cliente_id){
        return DB::table('clientes_coordenadas')
                        ->select('id', 'lat', 'lon', 'descripcion')
                        ->where('descripcion', '<>', '')
                        ->where('cliente_id', $cliente_id)
                        ->limit(5)->orderBy('concurrencia', 'DESC')->get();
    }
    
    public function pedidos_state_costumer($cliente_id){
        // Devolver todos los pedidos pendientes, validos y que no hayan sido elimiados
        $pendiente = DB::table('ventas')
                        ->select('id')
                        ->where('cliente_id', $cliente_id)->where('estado', 'V')
                        ->where('deleted_at', NULL)->where('venta_estado_id', '<', 5)
                        ->where('venta_tipo_id', 3)->count();
        if($pendiente>1){
            return response()->json(['pendiente' => 1]);
        }else{
            return response()->json(['pendiente' => 0]);
        }
    }
    
    public function pedidos_store(Request $request){

        // Verificar si el cliente está registrado
        $user = User::find($request->user_id);
        if(!$user->cliente_id){
            $cliente = new Cliente;
            $cliente->razon_social = $request->user_name;
            $cliente->save();
            $cliente_id = $cliente->id;
            $user = User::where('id', $user->id)->update(['cliente_id' => $cliente_id]);
        }else{
            $cliente_id = $user->cliente_id;
        }
        
        // Devolver todos los pedidos pendientes, validos y que no hayan sido elimiados
        $pendiente = DB::table('ventas')
                        ->select('id')
                        ->where('cliente_id', $cliente_id)->where('estado', 'V')
                        ->where('deleted_at', NULL)->where('venta_estado_id', '<', 5)
                        ->where('venta_tipo_id', 3)->count();
        if($pendiente>1){
            return response()->json(['error' => 'pendiente']);
        }

        // Guardar coordenadas del pedido
        (new Ventas)->set_ultima_ubicacion($cliente_id, $request->locationId, $request->lat, $request->lon, $request->locationDetail);

        if(count($request->cart)==0){
            return response()->json(["error" => 'Carrito de compra vacío']);
        }

        $efectivo = $request->tipo_pago == 1 ? 1 : 0;
        
        $venta = Venta::create([
            'cliente_id' => $cliente_id,
            'importe' => $request->importe,
            'estado' => 'V',
            'subtotal' => $request->importe,
            'importe_base' => $request->importe,
            'fecha' => date('Y-m-d'),
            'venta_tipo_id' => 3,
            'venta_estado_id' => 1,
            'efectivo' => $efectivo,
            'sucursal_id' => 3
        ]);
        

        if($venta){
            Venta::where('id', $venta->id)->update(['nro_venta' => $venta->id]);
            
            foreach ($request->cart as $item) {
                DB::table('ventas_detalles')
                        ->insert([
                            'venta_id' => $venta->id,
                            'producto_id' => $item['id'],
                            'precio' => $item['precio'],
                            'cantidad' => $item['cantidad'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
            }
            
            // Usar Eloquent
            DB::table('ventas_seguimientos')
                ->insert([
                    'venta_id' => $venta->id,
                    'venta_estado_id' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                
            // Facturación
            if($request->factura){
                $dosificacion = (new Dosificacion)->get_dosificacion();
                // si hay dosificaciones generamos codigo de control e incrementamos el numero de factura actual
                if($dosificacion){
                    $venta = Venta::find($venta->id);
                    $codigo_control = (new Facturacion)->generate($dosificacion->nro_autorizacion, $dosificacion->numero_actual, setting('empresa.nit'), date('Ymd'), $venta->importe_base, $dosificacion->llave_dosificacion);
                    DB::table('ventas')->where('id', $venta->id)
                                            ->update([
                                                        'nro_factura'       => $dosificacion->numero_actual,
                                                        'codigo_control'    => $codigo_control,
                                                        'nro_autorizacion'  => $dosificacion->nro_autorizacion,
                                                        'fecha_limite'      => $dosificacion->fecha_limite,
                                                        'autorizacion_id'   => $dosificacion->id,
                                                        'fecha'             => date('Y-m-d')
                                                        ]);
                    DB::table('dosificaciones')->where('id', $dosificacion->id)->increment('numero_actual', 1);
                }
            }
                        
            return response()->json(["error" => null, "venta_id" => $venta->id]);
        }else{
            return response()->json(["error" => 'error desconocido']);
        }
    }
    
    public function pedidos_list($id){
        $id = intval($id);
        $pedidos = DB::table('ventas as v')
                        ->join('ventas_estados as ve', 've.id', 'v.venta_estado_id')
                        ->join('clientes as c', 'c.id', 'v.cliente_id')
                        ->join('users as u', 'u.cliente_id', 'c.id')
                        ->select(DB::RAW('v.id, v.subtotal, DATE_FORMAT(v.created_at, "%H:%i, %d %b %Y") as fecha, v.deleted_at, if(v.venta_estado_id = 5, 2, 1) as estado'))
                        ->where('u.id', $id)
                        ->orderBy('v.id', 'DESC')
                        ->limit(10)
                        ->get();
                            
        return response()->json($pedidos);
    }
    
    public function pedidos_detalles($id){
        $id = intval($id);
        $detail = DB::table('ventas as v')
                        ->join('ventas_detalles as vd', 'vd.venta_id', 'v.id')
                        ->join('productos as p', 'p.id', 'vd.producto_id')
                        ->select(DB::RAW('v.id, v.subtotal, DATE_FORMAT(v.created_at, "%H:%i, %d %b %Y") as fecha, p.nombre, vd.cantidad'))
                        ->where('v.id', $id)
                        ->get();
                            
        return response()->json($detail);
    }
    
    public function pedidos_seguimiento($id){
        $id = intval($id);
        $seguimiento = DB::table('ventas_seguimientos as vs')
                            ->join('ventas_estados as ve', 've.id', 'vs.venta_estado_id')
                            ->select(DB::RAW('DATE_FORMAT(vs.created_at, "%H:%i") as hora, DATE_FORMAT(vs.created_at, "%d %b, %Y") as fecha, ve.nombre'))
                            ->where('vs.venta_id', $id)->get();
                            
        return response()->json($seguimiento);
    }
    
    // ===============API de Delivery=================
    
    public function pedidos_pendientes($id){
        $empleado = DB::table('empleados as e')->select('e.id')->where('e.user_id', $id)->first();
        if($empleado){
            $pedidos = DB::table('repartidores_pedidos as rp')
                            ->join('ventas as v', 'v.id', 'rp.pedido_id')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->join('users as u', 'u.cliente_id', 'c.id')
                            ->select('v.id', 'c.id as cliente_id', 'u.name', 'c.movil', 'u.avatar', 'rp.estado', 'v.deleted_at as detalle', 'rp.created_at', 'v.deleted_at as location', 'v.cobro_adicional', 'v.subtotal', 'v.descuento', 'v.importe_base')
                            ->where('rp.repartidor_id', $empleado->id)
                            ->where('rp.estado', '<>', 3)
                            ->where('v.deleted_at', NULL)
                            ->get();
            $cont = 0;
            foreach($pedidos as $item){
                $detalle = DB::table('ventas_detalles as vd')
                                ->join('productos as p', 'p.id', 'vd.producto_id')
                                ->select('p.id', DB::raw('FORMAT(vd.cantidad, 0) as cantidad'), 'p.nombre', 'p.imagen', 'vd.precio')
                                ->where('vd.venta_id', $item->id)->get();
                                
                $location = DB::table('clientes_coordenadas as co')
                                    ->select('co.lat', 'co.lon', 'co.descripcion')
                                    ->where('cliente_id', $item->cliente_id)
                                    ->where('ultima_ubicacion', 1)
                                    ->first();
                                
                $pedidos[$cont]->detalle = $detalle;
                $pedidos[$cont]->location = $location;
                $pedidos[$cont]->created_at = Carbon::parse($item->created_at)->diffForHumans();
                $cont++;
            }
            
            return response()->json(['pedidos'=>$pedidos]);
        }else{
            return response()->json(['pedidos'=>[]]);
        }
        
    }
    
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
            return 1;
        } catch (\Exception $e) {
            DB::rollback();
            return 0;
        }
    }
    
    // ================================================
    
    // Obtener email de usuario mediante numero de celular
    protected function getEmail($phone){
        if(!$phone){
            return null;
        }
        return DB::table('users as u')
                    ->join('clientes as c', 'c.id', 'u.cliente_id')
                    ->select('u.email')->where('c.movil', $phone)->first();
    }
    
    // Obtener datos del usuario según ID
    protected function getUser($id){
        if(!$id){
            return null;
        }
        return DB::table('users as u')
                    ->join('clientes as c', 'c.id', 'u.cliente_id')
                    ->select('u.id', 'u.name', 'u.email', 'u.avatar', 'u.cliente_id', 'c.razon_social', 'c.nit', 'c.movil')
                    ->where('u.id', $id)->first();
    }
    
    protected function getEmpleado($id){
        if(!$id){
            return null;
        }else{
            return DB::table('users as u')
                            ->join('empleados as e', 'e.user_id', 'u.id')
                            ->select('u.id', 'e.id as empleado_id', 'u.name', 'u.email', 'u.avatar', 'e.movil', 'e.direccion')
                            ->where('u.id', $id)->first();
        }
    }
}
