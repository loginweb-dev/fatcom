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
use App\Http\Controllers\ProductosController as Productos;
use App\Http\Controllers\VentasController as Ventas;
use App\Http\Controllers\DosificacionesController as Dosificacion;
use App\Http\Controllers\FacturasController as Facturacion;
use App\Http\Controllers\LoginwebController as Loginweb;
use App\Http\Controllers\SucursalesController as Sucursales;

use App\User;
use App\Cliente;
use App\ClientesCoordenada;
use App\Producto;
use App\Venta;
use App\VentasDetalle;
use App\VentasDetallesExtra;
use App\ProductosLike;
use App\RepartidoresPedido;
use App\VentasSeguimiento;
use App\Empleado;
use App\Sucursale;

// Eventos
use App\Events\pedidoNuevo;

class ApiController extends Controller
{
    public function login(Request $request){
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

    public function login_v2(Request $request){
        DB::beginTransaction();
        try {
            $name = $request->name;
            $email = $request->email;
            $codePhone = $request->codePhone;
            $phone = $request->numberPhone;
            $nit = $request->nit;
            $avatar = $request->avatar ?? 'users/default.png';
            $type = $request->type;
            $tokenDevice = $request->tokenDevice;

            $user = User::where('email', $email)->with('cliente')->first();
            
            // Si no existe el usuario se debe crear
            if(!$user){
                // Registrar datos de cliente
                $cliente = Cliente::create([
                    'razon_social' => $name,
                    'nit' => $nit,
                    'code_movil' => $codePhone,
                    'movil' => $phone
                ]);
                // Crear usuario
                $user = User::create([
                    'role_id' => 2,
                    'cliente_id' => $cliente->id,
                    // Por defecto santísima trinidad
                    'localidad_id' => 1,
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make(str_random(10)),
                    'avatar' => $avatar,
                    'tipo_login' => $type
                ]);
            }else{
                // Si existe el ususario pero no está asociado a un cliente
                if(!$user->cliente_id){
                    $cliente = new Cliente;
                    $cliente->razon_social = $user->name;
                    $cliente->save();
                    User::where('id', $user->id)->update(['cliente_id' => $cliente->id]);
                    $user = User::where('email', $email)->with('cliente')->first();
                }
            }

            // Actualizar token de firebase
            if($request->tokenDevice){
                $user_token = User::find($user->id);
                $user_token->firebase_token = $request->tokenDevice;
                $user_token->save();
            }

            // Definir formato de respuesta
            $user_response = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'codePhone' => $user->cliente->code_movil,
                'numberPhone' => $user->cliente->movil,
                'avatar' => $user->avatar,
                'businessName' => $user->cliente->razon_social,
                'nit' => $user->cliente->nit,
            ];
            DB::commit();
            return response()->json(['user' => $user_response]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrió un problema en nuestro servidor :(']);
        }
    }

    public function update_user_profile_v2(Request $request){
        DB::beginTransaction();
        try {
            $user = User::find($request->id);
            if($request->name) {$user->name = $request->name;}
            if($request->email) {$user->email = $request->email;}
            $user->save();

            $cliente = Cliente::find($user->cliente_id);
            if($request->businessName) {$cliente->razon_social = $request->businessName;}
            if($request->nit) {$cliente->nit = $request->nit;}
            if($request->codePhone) {$cliente->code_movil = $request->codePhone;}
            if($request->numberPhone) {$cliente->movil = $request->numberPhone;}
            $cliente->save();

            $user = User::where('id', $request->id)->with('cliente')->first();
            $user_response = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'codePhone' => $user->cliente->code_movil,
                'numberPhone' => $user->cliente->movil,
                'avatar' => $user->avatar,
                'businessName' => $user->cliente->razon_social,
                'nit' => $user->cliente->nit,
            ];
            DB::commit();
            return response()->json(['user' => $user_response]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrió un problema en nuestro servidor :(']);
        }
    }
    public function update_user_avatar_v2(Request $request, $id){
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
            return response()->json(['avatar' => $path]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrio un error al actualizar su imagen.']);
        }
    }
    
    public function register(Request $request){
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
    
    public function update_profile(Request $request){
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
    
    public function confirm_profile(Request $request){
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
    
    public function update_profile_delivery(Request $request){
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
    
    public function update_profile_delivery_avatar(Request $request, $id){
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
    
    public function login_social(Request $request){
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
    
    public function login_delivery(Request $request){
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

    public function index_v2(){
        $categories_list = $this->categories_list_v2(10);
        $current_offer = $this->current_offer_v2();
        if($current_offer){
            $offer = [
                "id" => $current_offer->id,
                "title" => $current_offer->nombre,
                "subtitle" => $current_offer->descripcion,
                "image" => $current_offer->imagen,
                "type" => "offer"
            ];
            $categories_list->prepend($offer);
        }
        $products_list = (new LandingPage)->get_mas_vendidos(10);
        return response()->json(['categoriesList' => $categories_list, 'productsList' => $this->format_products_list_v2($products_list)]);
    }

    public function index_alt_v2(){
        $categories_list = $this->categories_list_v2(10);
        $current_offer = $this->current_offer_v2();
        if($current_offer){
            $offer = [
                "id" => $current_offer->id,
                "title" => $current_offer->nombre,
                "subtitle" => $current_offer->descripcion,
                "image" => $current_offer->imagen,
                "type" => "offer"
            ];
            $categories_list->prepend($offer);
        }
        return response()->json(['categoriesList' => $categories_list]);
    }

    public function filter_products_v2(Request $request){
        $key = $request->key;
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 10;

        $products_list = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->select(DB::raw('p.id, p.codigo_grupo, p.nombre, s.nombre as subcategoria, m.nombre as marca, c.nombre as color, p.descripcion_small, p.precio_venta, p.precio_venta as precio_venta_antiguo, p.imagen, p.slug'))
                            ->orderBy('precio_venta', 'ASC')
                            ->where('e.deleted_at', NULL)->where('e.activo', 1)
                            ->whereRaw("(p.nombre like '%$key%' or s.nombre like '%$key%' or m.nombre like '%$key%' or c.nombre like '%$key%')")
                            ->offset($offset)->limit($limit)->get();
        $cont = 0;
        foreach ($products_list as $item) {
            // Obtener si el producto está en oferta
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            if($oferta){
                $precio_venta = $item->precio_venta;
                if($oferta->tipo_descuento=='porcentaje'){
                    $precio_venta -= ($precio_venta*($oferta->monto/100));
                }else{
                    $precio_venta -= $oferta->monto;
                }
                $products_list[$cont]->precio_venta = number_format($precio_venta, 2, ',', '');
            }
            $cont++;
        }
        return response()->json(['productsList' => $this->format_products_list_v2($products_list)]);
    }

    public function category_products_v2($category_id, $offset = 0, $limit = 20){
        $products_list = $this->category_products_list_v2($category_id, $offset, $limit);
        return response()->json(['productsList' => $this->format_products_list_v2($products_list)]);
    }

    public function offer_products_v2($offer_id, $offset = 0, $limit = 20){
        $products_list = $this->offer_products_list_v2($offer_id, $offset, $limit);
        return response()->json(['productsList' => $this->format_products_list_v2($products_list)]);
    }
    
    public function get_oferta_actual(){
        $dia_semana = date('N');
        $dia_mes = date('j');
        $ofertas = DB::table('ofertas as o')
                    ->select('o.id', 'o.nombre', 'o.descripcion', 'o.imagen', 'tipo_oferta')
                    ->whereRaw("( (o.tipo_duracion = 'rango' and o.inicio < '".Carbon::now()."' and (o.fin is NULL or o.fin > '".Carbon::now()."')) or (o.tipo_duracion = 'semanal' and o.dia = $dia_semana) or (o.tipo_duracion = 'mensual' and o.dia = $dia_mes) )")
                    ->where('o.estado', 1)
                    ->where('o.deleted_at', NULL)
                    ->first();
        return response()->json(['oferta'=>$ofertas]);
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
                            ->where('e.deleted_at', NULL)->where('e.activo', 1)
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
                            ->where('e.deleted_at', NULL)->where('e.activo', 1)
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
                            ->where('e.deleted_at', NULL)->where('e.activo', 1)
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

        // Obtener sucursales habilitadas para delivery y que hayan abierto caja
        $sucursales = (new Sucursales)->get_sucursales_activas();

        // Verificar si hay al menos una sucursal activa para el servicio de delvery
        if(count($sucursales)==0){
            return response()->json(["error" => 'Servicio de delivery no disponible.']);
        }
        
        // Si existe mas de una sucursal activa para delivery se obtiene la más cercana, sino se elige la primera
        if(count($sucursales)>1){
            $sucursal_id = (new Sucursales)->get_sucursal_cercana($sucursales, $data->lat, $data->lon);
        }else{
            $sucursal_id = $sucursales[0]->id;
        }

        // Emitir evento de nuevo pedido
        try {
            event(new pedidoNuevo($sucursal_id));
        } catch (\Throwable $th) {
            //throw $th;
        }

        DB::beginTransaction();
        try {
            // Crear registro de venta
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
                'sucursal_id' => $sucursal_id
            ]);

            Venta::where('id', $venta->id)->update(['nro_venta' => $venta->id]);
            
            foreach ($request->cart as $item) {
                VentasDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['id'],
                    'precio' => $item['precio'],
                    'cantidad' => $item['cantidad']
                ]);
            }
            
            // registrar seguimiento del pedido
            VentasSeguimiento::create([ 'venta_id' => $venta->id, 'venta_estado_id' => 1]);
                
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
            
            DB::commit();
            return response()->json(["error" => null, "venta_id" => $venta->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => 'error desconocido']);
        }
    }

    public function order_register_v2(Request $request){
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->id)->first();
            
            // Devolver todos los pedidos pendientes, validos y que no hayan sido elimiados
            $pendiente = DB::table('ventas')
                            ->select('id')
                            ->where('cliente_id', $user->cliente_id)->where('estado', 'V')
                            ->where('deleted_at', NULL)->where('venta_estado_id', '<', 5)
                            ->where('venta_tipo_id', 3)->count();
            if($pendiente>1){
                return response()->json(['error' => 'Has llegado al límite de pedidos pendientes que puedes tener.']);
            }

            if(count($request->cart)==0){
                return response()->json(["error" => 'Su carrito de compra está vacío.']);
            }

            // Actualizar coordenada actual
            ClientesCoordenada::where('cliente_id', $user->cliente_id)->update(['ultima_ubicacion' => NULL]);
            $location_user = ClientesCoordenada::firstOrNew([
                'cliente_id' => $user->cliente_id,
                'nombre' =>  $request->location['name'],
                'lat' => $request->location['coor']['lat'],
                'lon' => $request->location['coor']['lon'],
                'descripcion' => $request->location['description']
            ]);
            if (!$location_user->exists) {
                $location_user->fill([
                    'concurrencia' => 1, 'ultima_ubicacion' => 1,
                ])->save();
            }else{
                $location_user->concurrencia++;
                $location_user->ultima_ubicacion = 1;
                $location_user->save();
            }
            // =============================

            // Obtener sucursales habilitadas para delivery y que hayan abierto caja
            $sucursales = (new Sucursales)->get_sucursales_activas();

            // Verificar si hay al menos una sucursal activa para el servicio de delivery
            if(count($sucursales)==0){
                return response()->json(['error' => 'Nuestro servicio de delivery está fuera de servicio en esté momento, se te notificará cuando esté activo.']);
            }

            // Si existe mas de una sucursal activa para delivery se obtiene la más cercana, sino se elige la primera
            if(count($sucursales)>1){
                $sucursal_id = (new Sucursales)->get_sucursal_cercana($sucursales, $location_user->lat, $location_user->lon);
            }else{
                $sucursal_id = $sucursales[0]->id;
            }

            $cash = 1;
            // Crear registro de venta
            $order = Venta::create([
                'cliente_id' => $user->cliente_id,
                'importe' => 0,
                'estado' => 'V',
                'subtotal' => 0,
                'importe_base' => 0,
                'fecha' => date('Y-m-d'),
                'venta_tipo_id' => 3,
                'venta_estado_id' => 1,
                'efectivo' => $cash,
                'sucursal_id' => $sucursal_id,
                'observaciones' => $request->cartObservations
            ]);
            
            // Registrar detalle de pedido
            $amountCart = 0;
            foreach ($request->cart as $product) {
                $order_detail = VentasDetalle::create([
                    'venta_id' => $order->id,
                    'producto_id' => $product['id'],
                    'precio' => $product['price'],
                    'cantidad' => $product['count']
                ]);

                $amountCart += str_replace(',', '.', $product['subtotal']);
                
                // Registrar extras si existen
                foreach ($product['extras'] as $extra) {
                    VentasDetallesExtra::create([
                        'venta_detalle_id' => $order_detail->id,
                        'extra_id' => $extra['id'],
                        'cantidad' => $extra['count'],
                        'precio' => $extra['price']
                    ]);

                    // Actualizar el precio del producto añandiendo el precio de los extras
                    $order_detail = VentasDetalle::find($order_detail->id);
                    $order_detail->precio += ($extra['count'] * $extra['price']);
                    $order_detail->save();
                }
            }

            // Actualizar monto total de venta
            Venta::where('id', $order->id)
                ->update([
                    'nro_venta' => $order->id,
                    'importe' => $amountCart,
                    'subtotal' => $amountCart,
                    'importe_base' => $amountCart,
                ]);
            
            // registrar seguimiento del pedido
            VentasSeguimiento::create([ 'venta_id' => $order->id, 'venta_estado_id' => 1]);
                
            // Facturación
            if($request->billValue){
                $dosificacion = (new Dosificacion)->get_dosificacion();
                // si hay dosificaciones generamos codigo de control e incrementamos el numero de factura actual
                if($dosificacion){
                    $venta = Venta::find($order->id);
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

            $newOrder = Venta::where('id', $order->id)->get();
            $order_response = $this->format_order_list_v2($newOrder)->first();

            // Si se puede realizar pedidos fuera de horario de atención,
            // verificar que la sucursal donde se hizo el pedido esté abierta
            $sucursal_activa = DB::table('sucursales as s')
                                    ->join('ie_cajas as c', 'c.sucursal_id', 's.id')
                                    ->select('s.*')
                                    ->where('c.abierta', 1)->where('s.deleted_at', NULL)
                                    ->where('s.id', $sucursal_id)->where('s.delivery', 1)->first();
            $abierta = $sucursal_activa ? true : false;
            $mensaje = $abierta ? '' : 'Su pedido será enviado dentro del horario de atención. '.setting('delivery.message_company_closed');
            
            DB::commit();
            
            // Emitir evento de nuevo pedido
            try {
                event(new pedidoNuevo($sucursal_id));
            } catch (\Throwable $th) {
                //throw $th;
            }
            return response()->json(['order' => $order_response, 'sucursal' => ['open' => $abierta, 'message' => $mensaje ]]);
            // return response()->json(['order' => $order_response]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrió un error inesperado, por favor intenta nuevamente', 'res' => $e]);
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

    public function orders_list_v2($id){
        $user = User::find($id);
        $orders_list = [];
        if($user){
            $orders = Venta::where('cliente_id', $user->cliente_id)->orderBy('id', 'DESC')->limit(10)->get();
            $orders_list = $this->format_order_list_v2($orders);
        }
       
        return response()->json(['ordersList' => $orders_list]);
    }

    public function order_details_v2($order_id){
        $data = Venta::where('id', $order_id)->get();
        $orders = $this->format_order_list_v2($data);
        return $orders->first();
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

    public function get_params_v2($param){
        switch ($param) {
            case 'sucursal_active':
                $sucursales = (new Sucursales)->get_sucursales_activas();
                $abierta = count($sucursales) > 0 ? true: false;
                $mensaje = $abierta ? '' : 'No puede realizar pedidos en este momento. '.setting('delivery.message_company_closed');
                return response()->json(['open' => $abierta, 'message' => $mensaje ]);
                break;
            
            default:
                return response()->json(['error' => 'Error desconocido.']);
                break;
        }
    }

    // ================= Funciones auxiliares =================
    public function format_products_list_v2($list){
        $products_list = collect();
        foreach ($list as $product) {
            $extras = collect();
            $similar = $this->products_group($product->codigo_grupo);
            foreach ((new Productos)->lista_extras_productos($product->id) as $extra) {
                $extras->push([
                    'id' => $extra->id,
                    'name' => $extra->nombre,
                    'price' => $extra->precio,
                    'ckecked' => false
                ]);
            }

            $products_list->push([
                'id' => $product->id,
                'name' => $product->nombre,
                'category' => $product->subcategoria,
                'color' => $product->color,
                'brand' => $product->marca,
                'details' => $product->descripcion_small,
                'price' => $product->precio_venta,
                'oldPrice' => $product->precio_venta_antiguo,
                'image' => $product->imagen,
                'similar' => $similar,
                'extras' => $extras,
                'slug' => $product->slug,
            ]);
        }
        return $products_list;
    }

    public function categories_list_v2($quantity = null){
        return $quantity ?
            DB::table('productos as p')
                    ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                    ->join('categorias as c', 'c.id', 's.categoria_id')
                    ->select('c.id', 'c.nombre as title', 'c.descripcion as subtitle', 'c.imagen as image', DB::raw('"category" as type'))
                    ->whereIn('p.id', function($q){
                        $q->select('producto_id')->from('ecommerce_productos')->where('deleted_at', null)->where('activo', 1);
                    })
                    ->groupBy('c.id', 'c.nombre', 'c.descripcion', 'c.imagen')
                    ->limit($quantity)
                    ->get() :
            DB::table('productos as p')
                    ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                    ->join('categorias as c', 'c.id', 's.categoria_id')
                    ->select('c.id', 'c.nombre as title', 'c.descripcion as subtitle', 'c.imagen as image', DB::raw('"category" as type'))
                    ->whereIn('p.id', function($q){
                        $q->select('producto_id')->from('ecommerce_productos')->where('deleted_at', null)->where('activo', 1);
                    })
                    ->groupBy('c.id', 'c.nombre', 'c.descripcion', 'c.imagen')
                    ->get();
    }

    public function category_products_list_v2($category_id, $offset, $limit){
        $products_list = DB::table('productos as p')
                                ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                                ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                ->join('categorias as c', 'c.id', 's.categoria_id')
                                ->join('marcas as m', 'm.id', 'p.marca_id')
                                ->join('colores as co', 'co.id', 'p.color_id')
                                ->select(DB::raw('p.id, p.codigo_grupo, p.nombre, s.nombre as subcategoria, m.nombre as marca, co.nombre as color, p.descripcion_small, p.precio_venta, p.precio_venta as precio_venta_antiguo, p.imagen, p.slug'))
                                ->where('s.deleted_at', NULL)
                                ->where('e.deleted_at', NULL)
                                ->where('e.activo', 1)
                                ->where('c.id', $category_id)
                                ->groupBy('codigo_grupo')
                                ->offset($offset)->limit($limit)->get();
        $cont = 0;
        foreach ($products_list as $item) {
            // Obtener si el producto está en oferta
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            if($oferta){
                $precio_venta = $item->precio_venta;
                if($oferta->tipo_descuento=='porcentaje'){
                    $precio_venta -= ($precio_venta*($oferta->monto/100));
                }else{
                    $precio_venta -= $oferta->monto;
                }
                $products_list[$cont]->precio_venta = number_format($precio_venta, 2, ',', '');
            }
            $cont++;
        }
        return $products_list;
    }

    public function products_group($codigo_grupo){
        $similares = DB::table('productos as p')
                                ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                ->join('marcas as m', 'm.id', 'p.marca_id')
                                ->join('colores as c', 'c.id', 'p.color_id')
                                ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                                ->select(DB::raw('p.id, p.nombre as name, s.nombre as category, m.nombre as brand, c.nombre as color, p.descripcion_small as details, precio_venta as price, precio_venta as oldPrice, p.imagen as image, p.slug, p.deleted_at as extras'))
                                ->orderBy('precio_venta', 'ASC')
                                ->where('e.deleted_at', NULL)->where('e.activo', 1)
                                ->where('p.codigo_grupo', $codigo_grupo)
                                ->get();
        $cont = 0;
        foreach ($similares as $item) {
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            if($oferta){
                $precio_venta = $item->price;
                if($oferta->tipo_descuento=='porcentaje'){
                    $precio_venta -= ($precio_venta*($oferta->monto/100));
                }else{
                    $precio_venta -= $oferta->monto;
                }
                $similares[$cont]->price = number_format($precio_venta, 2, ',', '');
            }

            // Obtener los extras
            $extras = collect();
            foreach ((new Productos)->lista_extras_productos($item->id) as $extra) {
                $extras->push([
                    'id' => $extra->id,
                    'name' => $extra->nombre,
                    'price' => $extra->precio,
                    'ckecked' => false
                ]);
            }
            $similares[$cont]->extras = $extras;

            $cont++;
        }
        return $similares;
    }

    public function format_order_list_v2($orders){
        if(count($orders) > 0){
            $orders_list = collect();
            foreach ($orders as $order) {
                $details = '';
                foreach ($order->items as $product) {
                    $details .= $product->producto->nombre.', ';
                }
                $order_item = [
                    'id' => $order->id,
                    'code' => str_pad($order->nro_venta, 6, "0", STR_PAD_LEFT),
                    'details' => substr($details, 0, -2).'.',
                    'amount' => $order->importe_base,
                    'status' => $order->estado == 'V' ? 1 : 0,
                    'statusName' => $order->estadoventa->nombre,
                    'tracking' => [],
                    'date' => Carbon::parse($order->created_at)->diffForHumans(),
                ];

                // Obtener el seguimiento del pedido
                $tracking = collect();
                foreach ($order->ventaseguimientos as $track) {
                    $track_item = [
                        'time' => date('H:i', strtotime($track->created_at)),
                        'title' => $track->ventaestado->nombre,
                        'description' => date('d M, Y', strtotime($track->created_at))
                    ];
                    $tracking->push($track_item);
                }
                $order_item['tracking'] = $tracking;
                // ----------------------------------

                $orders_list->push($order_item);
            }
        }else{
            $orders_list = [];
        }

        return $orders_list;
    }

    public function current_offer_v2(){
        $dia_semana = date('N');
        $dia_mes = date('j');
        return DB::table('ofertas as o')
                    ->select('o.id', 'o.nombre', 'o.descripcion', 'o.imagen', 'tipo_oferta')
                    ->whereRaw("( (o.tipo_duracion = 'rango' and o.inicio < '".Carbon::now()."' and (o.fin is NULL or o.fin > '".Carbon::now()."')) or (o.tipo_duracion = 'semanal' and o.dia = $dia_semana) or (o.tipo_duracion = 'mensual' and o.dia = $dia_mes) )")
                    ->where('o.estado', 1)
                    ->where('o.deleted_at', NULL)
                    ->first();
    }

    public function offer_products_list_v2($offer_id, $offset, $limit){
        $products = DB::table('productos as p')
                                ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                ->join('marcas as m', 'm.id', 'p.marca_id')
                                ->join('colores as c', 'c.id', 'p.color_id')
                                ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                                ->join('ofertas_detalles as o', 'o.producto_id', 'p.id')
                                ->select(DB::raw('p.id, p.codigo_grupo, p.nombre, s.nombre as subcategoria, m.nombre as marca, c.nombre as color, p.descripcion_small, p.precio_venta, p.precio_venta as precio_venta_antiguo, p.imagen, p.slug'))
                                ->orderBy('precio_venta', 'ASC')
                                ->where('e.deleted_at', NULL)
                                ->where('e.activo', 1)
                                ->where('o.oferta_id', $offer_id)
                                ->where('o.deleted_at', NULL)
                                ->groupBy('p.codigo_grupo')
                                ->offset($offset)->limit($limit)->get();
        $cont = 0;
        foreach ($products as $item) {
            // Obtener si el producto está en oferta
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            if($oferta){
                $precio_venta = $item->precio_venta;
                if($oferta->tipo_descuento=='porcentaje'){
                    $precio_venta -= ($precio_venta*($oferta->monto/100));
                }else{
                    $precio_venta -= $oferta->monto;
                }
                $products[$cont]->precio_venta = number_format($precio_venta, 2, ',', '');
            }
            $cont++;
        }
        return $products;
    }
    // =========================================================
    
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
