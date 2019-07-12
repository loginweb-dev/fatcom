<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Http\Controllers\LoginwebController as LW;
use App\Http\Controllers\OfertasController as Ofertas;
use App\Http\Controllers\ProductosController as Productos;

use App\UsersCoordenada;
use App\PasarelaPago;
use App\Venta;

class LandingPageController extends Controller
{
    public function index(){

        $productos_categoria = [];
        $categorias = DB::table('categorias as c')
                            ->join('subcategorias as s', 's.categoria_id', 'c.id')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->join('ecommerce_productos as ec', 'ec.producto_id', 'p.id')
                            ->select('c.*')
                            // ->where('p.deleted_at', NULL)
                            ->where('c.deleted_at', NULL)
                            // ->orderBy('c.nombre', 'DESC')
                            ->distinct()
                            ->limit(5)
                            ->get();
        $subcategorias = [];
        if(count($categorias)>0){
            // Obtener subcategotia de los productos
            foreach ($categorias as $item) {
                $aux = DB::table('subcategorias')
                            ->select('*')
                            ->where('categoria_id', $item->id)
                            ->where('deleted_at', NULL)
                            ->get();
                if(count($aux)>0){
                    $subcategoria = $aux;
                }else{
                    $subcategoria = [];
                }
                array_push($subcategorias, ['subcategoria' => $subcategoria]);
            }
        }

        $marcas = DB::table('marcas as m')
                            ->join('productos as p', 'p.marca_id', 'm.id')
                            ->join('ecommerce_productos as ec', 'ec.producto_id', 'p.id')
                            ->select(DB::raw('m.id, m.nombre, count(p.id) as productos'))
                            ->where('m.deleted_at', NULL)
                            ->groupBy('id', 'nombre')
                            ->orderBy('productos', 'DESC')
                            ->limit(5)
                            ->get();

        $ofertas = DB::table('productos as p')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('ofertas_detalles as od', 'od.producto_id', 'p.id')
                            ->join('ofertas as o', 'o.id', 'od.oferta_id')
                            ->join('monedas as mo', 'mo.id', 'p.moneda_id')
                            ->select('p.id', 'p.nombre', 'p.nuevo', 'p.imagen', 'm.nombre as m', 'od.monto as descuento', 'od.tipo_descuento', 'mo.abreviacion as moneda')
                            // ->where('p.deleted_at', NULL)
                            ->where('o.deleted_at', NULL)
                            ->where('e.deleted_at', NULL)
                            ->where('od.deleted_at', NULL)
                            ->where('o.inicio', '<', Carbon::now())
                            ->whereRaw(" (o.fin is NULL or o.fin > '".Carbon::now()."')")
                            ->limit(10)
                            ->get();

        $subcategoria_productos = DB::table('subcategorias as s')
                                    ->join('productos as p', 'p.subcategoria_id', 's.id')
                                    ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                                    ->select('s.id', 's.nombre')
                                    ->where('s.deleted_at', NULL)
                                    ->distinct()
                                    ->get();
        foreach ($subcategoria_productos as $item) {
            $aux = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->select('p.id', 'p.nombre', 'p.imagen', 'p.nuevo')
                            // ->where('deleted_at', NULL)
                            ->where('s.id', $item->id)
                            ->where('e.deleted_at', NULL)
                            ->get();

            array_push($productos_categoria, $aux);
        }

        switch (setting('admin.modo_sistema')) {
            case 'boutique':

                break;
            case 'electronica_computacion':
            return view('ecommerce/computacion_electronica/index', compact('ofertas', 'subcategoria_productos', 'productos_categoria', 'marcas', 'categorias', 'subcategorias'));
                break;
            case 'restaurante':
            return view('ecommerce/restaurante/index', compact('ofertas', 'subcategoria_productos', 'productos_categoria', 'marcas', 'categorias', 'subcategorias'));
                break;
            default:
                # code...
                break;
        }
    }

    public function search(Request $data){
        // dd($data);
        $sentencia = '1';

        if($data->tipo_busqueda=='click'){
            $filtro_marca = ($data->marca_id != '') ? ' p.marca_id = '.$data->marca_id : ' 1';
            $filtro_subcategoria = ($data->subcategoria_id != '') ? ' and p.subcategoria_id = '.$data->subcategoria_id : ' and 1';
            $sentencia = $filtro_marca.$filtro_subcategoria;
        }

        if($data->tipo_busqueda=='text'){
            // dd($data);
            if($data->tipo_dato=='all'){
                $sentencia = "( p.nombre like '%".$data->dato."%' or c.nombre like '%".$data->dato."%' or m.nombre like '%".$data->dato."%')";
            }else{
                $sentencia = " ".$data->tipo_dato.".nombre like '%".$data->dato."%' ";
            }
        }

        $productos = DB::table('productos as p')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as c', 'c.id', 's.categoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as co', 'co.id', 'p.color_id')
                            ->join('usos as u', 'u.id', 'p.uso_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('monedas as mn', 'mn.id', 'p.moneda_id')
                            ->select('p.id', 'p.nombre', 'p.imagen', 'modelo', 'p.garantia', 'p.descripcion_small', 'p.vistas', 's.nombre as subcategoria', 'm.nombre as marca', 'mn.abreviacion as moneda', 'u.nombre as uso', 'co.nombre as color', 'g.nombre as genero')
                            // ->where('deleted_at', NULL)
                            ->whereRaw($sentencia)
                            ->where('s.deleted_at', NULL)
                            ->where('m.deleted_at', NULL)
                            ->where('e.deleted_at', NULL)
                            ->paginate(5);
        $precios = [];
        $ofertas = [];
        $puntuaciones = [];
        foreach ($productos as $item) {
            // Obtener precios de venta del producto
            $producto_unidades =  (new Productos)->obtener_precios_venta($item->id);
            $precio = (count($producto_unidades)>0) ? ['precio' => $producto_unidades[0]->precio, 'unidad' => $producto_unidades[0]->unidad] : ['precio' => 0, 'unidad' => 'No definida'];
            array_push($precios, $precio);

            // Obtener si el producto está en oferta
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            array_push($ofertas, ['oferta'=>$oferta]);

            // Obtener puntuaciones
            $puntuacion = (new Productos)->obtener_puntos($item->id);
            array_push($puntuaciones, ['puntos'=>$puntuacion]);
        }

        $precio_min = $data->min;
        $precio_max = $data->max;

        switch (setting('admin.modo_sistema')) {
            case 'boutique':

                break;
            case 'electronica_computacion':
            return view('ecommerce/computacion_electronica/busqueda', compact('productos', 'precios', 'ofertas', 'precio_min', 'precio_max', 'puntuaciones'));
                break;
            case 'restaurante':
            return view('ecommerce/restaurante/busqueda', compact('productos', 'precios', 'ofertas', 'precio_min', 'precio_max', 'puntuaciones'));
                break;
            default:
                # code...
                break;
        }
    }

    public function ofertas(){
        $productos = DB::table('productos as p')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as c', 'c.id', 's.categoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as co', 'co.id', 'p.color_id')
                            ->join('usos as u', 'u.id', 'p.uso_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('monedas as mn', 'mn.id', 'p.moneda_id')
                            ->join('ofertas_detalles as df', 'df.producto_id', 'p.id')
                            ->join('ofertas as o', 'o.id', 'df.oferta_id')
                            ->select('p.id', 'p.nombre', 'p.imagen', 'modelo', 'p.garantia', 'p.descripcion_small', 's.nombre as subcategoria', 'm.nombre as marca', 'mn.abreviacion as moneda', 'u.nombre as uso', 'co.nombre as color', 'g.nombre as genero', 'df.tipo_descuento', 'df.monto as monto_descuento')
                            // ->where('deleted_at', NULL)
                            ->where('o.inicio', '<', Carbon::now())
                            ->whereRaw(" (o.fin is NULL or o.fin > '".Carbon::now()."')")
                            ->where('s.deleted_at', NULL)
                            ->where('m.deleted_at', NULL)
                            ->where('e.deleted_at', NULL)
                            ->where('df.deleted_at', NULL)
                            ->where('o.deleted_at', NULL)
                            ->paginate(5);
        $precios = [];
        $puntuaciones = [];
        foreach ($productos as $item) {
            // Obtener precios de venta del producto
            $producto_unidades =  (new Productos)->obtener_precios_venta($item->id);
            $precio = (count($producto_unidades)>0) ? ['precio' => $producto_unidades[0]->precio, 'unidad' => $producto_unidades[0]->unidad] : ['precio' => 0, 'unidad' => 'No definida'];
            array_push($precios, $precio);

            // Obtener puntuaciones
            $puntuacion = (new Productos)->obtener_puntos($item->id);
            array_push($puntuaciones, ['puntos'=>$puntuacion]);
        }

        $recomendaciones = DB::table('productos as p')
                                ->join('ofertas_detalles as df', 'df.producto_id', 'p.id')
                                ->join('ofertas as o', 'o.id', 'df.oferta_id')
                                ->select('p.id', 'p.nombre', 'p.imagen')
                                ->where('o.inicio', '<', Carbon::now())
                                ->whereRaw(" (o.fin is NULL or o.fin > '".Carbon::now()."')")
                                ->where('df.deleted_at', NULL)
                                ->where('o.deleted_at', NULL)
                                ->limit(10)
                                ->get();

        switch (setting('admin.modo_sistema')) {
            case 'boutique':

                break;
            case 'electronica_computacion':
            return view('ecommerce/computacion_electronica/ofertas', compact('productos', 'precios', 'puntuaciones', 'recomendaciones'));
                break;
            case 'restaurante':
            return view('ecommerce/restaurante/ofertas', compact('productos', 'precios', 'puntuaciones', 'recomendaciones'));
                break;
            default:
                # code...
                break;
        }
    }

    public function categorias($id){
        $subcategoria = DB::table('subcategorias')->select('nombre')->where('id', $id)->first()->nombre;

        $productos = DB::table('productos as p')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as c', 'c.id', 's.categoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as co', 'co.id', 'p.color_id')
                            ->join('usos as u', 'u.id', 'p.uso_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('monedas as mn', 'mn.id', 'p.moneda_id')
                            ->select('p.id', 'p.nombre', 'p.imagen', 'modelo', 'p.garantia', 'p.descripcion_small', 's.nombre as subcategoria', 'm.nombre as marca', 'mn.abreviacion as moneda', 'u.nombre as uso', 'co.nombre as color', 'g.nombre as genero')
                            // ->where('deleted_at', NULL)
                            ->where('s.deleted_at', NULL)
                            ->where('m.deleted_at', NULL)
                            ->where('e.deleted_at', NULL)
                            ->where('p.subcategoria_id', $id)
                            ->paginate(5);
        $precios = [];
        $ofertas = [];
        $puntuaciones = [];
        foreach ($productos as $item) {
            // Obtener precios de venta del producto
            $producto_unidades =  (new Productos)->obtener_precios_venta($item->id);
            $precio = (count($producto_unidades)>0) ? ['precio' => $producto_unidades[0]->precio, 'unidad' => $producto_unidades[0]->unidad] : ['precio' => 0, 'unidad' => 'No definida'];
            array_push($precios, $precio);

            // Obtener si el producto está en oferta
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            array_push($ofertas, ['oferta'=>$oferta]);

            // Obtener puntuaciones
            $puntuacion = (new Productos)->obtener_puntos($item->id);
            array_push($puntuaciones, ['puntos'=>$puntuacion]);
        }

        $recomendaciones = DB::table('productos as p')
                                ->select('p.id', 'p.nombre', 'p.imagen')
                                ->where('p.subcategoria_id', $id)
                                ->limit(10)
                                ->get();

        switch (setting('admin.modo_sistema')) {
            case 'boutique':

                break;
            case 'electronica_computacion':
            return view('ecommerce/computacion_electronica/categorias', compact('productos', 'precios', 'ofertas', 'puntuaciones', 'recomendaciones', 'subcategoria', 'id'));
                break;
            case 'restaurante':
            return view('ecommerce/restaurante/categorias', compact('productos', 'precios', 'ofertas', 'puntuaciones', 'recomendaciones', 'subcategoria', 'id'));
                break;
            default:
                # code...
                break;
        }
    }

    public function detalle_producto($id){

        // Incrementar numero de vistas a producto
        DB::table('productos')->where('id', $id)->increment('vistas', 1);

        $producto = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->join('usos as u', 'u.id', 'p.uso_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('monedas as mn', 'mn.id', 'p.moneda_id')
                            ->join('ecommerce_productos as ec', 'ec.producto_id', 'p.id')
                            ->select('p.id', 'p.nombre', 'p.imagen', 'p.modelo', 'p.garantia', 'p.descripcion_small', 'p.descripcion_long', 'p.vistas', 'p.catalogo', 's.nombre as subcategoria', 'm.nombre as marca', 'mn.abreviacion as moneda', 'u.nombre as uso', 'c.nombre as color', 'g.nombre as genero', 'ec.tags')
                            // ->where('deleted_at', NULL)
                            ->where('p.id', $id)
                            ->first();
        $imagenes = DB::table('producto_imagenes')
                            ->select('imagen')
                            ->where('producto_id', $id)
                            ->where('deleted_at', NULL)
                            ->orderBy('tipo', 'ASC')
                            // ->where('tipo', 'principal')
                            ->get();
        $precios_venta = (new Productos)->obtener_precios_venta($id);

        $puntuacion = (new Productos)->obtener_puntos($id);

        $habilitar_puntuar = null;
        if(isset(Auth::user()->id)){
            $habilitar_puntuar = DB::table('productos_puntuaciones')
                                        ->select('id')
                                        ->where('user_id', Auth::user()->id)
                                        ->where('producto_id', $id)
                                        ->where('deleted_at', NULL)
                                        ->first();
        }

        // Recomendaciones
        $tags = explode(',', $producto->tags);
        $recomendaciones = [];
        foreach ($tags as $item) {
            $array = DB::table('productos as p')
                            ->join('ecommerce_productos as ec', 'ec.producto_id', 'p.id')
                            ->select('p.id', 'p.nombre', 'p.imagen')
                            ->where('ec.tags', 'like', "%$item%")
                            ->where('p.id', '<>', $id)
                            ->get();
            foreach ($array as $item2) {
                $existe = false;
                $indice = 0;
                for($i=0; $i<count($recomendaciones); $i++){
                    if($recomendaciones[$i]['id']==$item2->id){
                        $existe = true;
                        $indice = $i;
                    }
                }

                if($existe){
                    $recomendaciones[$indice]['coincidencias']++;
                }else{
                    array_push($recomendaciones, ['id'=>$item2->id, 'nombre'=>$item2->nombre, 'imagen'=>$item2->imagen, 'coincidencias'=>1]);
                }
            }
        }
        // Ordenar lista segun las coincidencias
        for ($i=0; $i < count($recomendaciones); $i++) {
            for ($j=$i+1; $j < count($recomendaciones); $j++) {
                if($recomendaciones[$i]['coincidencias'] < $recomendaciones[$j]['coincidencias']){

                    $aux_id = $recomendaciones[$i]['id'];
                    $recomendaciones[$i]['id'] = $recomendaciones[$j]['id'];
                    $recomendaciones[$j]['id'] = $aux_id;

                    $aux_nombre = $recomendaciones[$i]['nombre'];
                    $recomendaciones[$i]['nombre'] = $recomendaciones[$j]['nombre'];
                    $recomendaciones[$j]['nombre'] = $aux_nombre;

                    $aux_imagen = $recomendaciones[$i]['imagen'];
                    $recomendaciones[$i]['imagen'] = $recomendaciones[$j]['imagen'];
                    $recomendaciones[$j]['imagen'] = $aux_imagen;

                    $aux_coincidencia = $recomendaciones[$i]['coincidencias'];
                    $recomendaciones[$i]['coincidencias'] = $recomendaciones[$j]['coincidencias'];
                    $recomendaciones[$j]['coincidencias'] = $aux_coincidencia;
                }
            }
        }
        // ===============

        $oferta = (new Ofertas)->obtener_oferta($id);
        $dispositivo = LW::userAgent();

        switch (setting('admin.modo_sistema')) {
            case 'boutique':

                break;
            case 'electronica_computacion':
            return view('ecommerce/computacion_electronica/detalle', compact('producto', 'imagenes', 'precios_venta', 'puntuacion', 'oferta', 'id', 'habilitar_puntuar', 'recomendaciones', 'dispositivo'));
                break;
            case 'restaurante':
            return view('ecommerce/restaurante/detalle', compact('producto', 'imagenes', 'precios_venta', 'puntuacion', 'oferta', 'id', 'habilitar_puntuar', 'recomendaciones', 'dispositivo'));
                break;
            default:
                # code...
                break;
        }
    }

    public function cantidad_carrito(){
        $carrito = session()->has('carrito_compra') ? session()->get('carrito_compra') : array();
        return count($carrito);
    }

    public function cantidad_pedidos(){
        $pedidos = DB::table('ventas as v')
                        ->join('clientes as c', 'c.id', 'v.cliente_id')
                        ->select('v.id')
                        ->where('c.user_id', Auth::user()->id)
                        ->where('v.tipo_estado', '<=', 4)
                        ->get();
        return count($pedidos);
    }

    public function carrito_comprar($id){
        $query =  $this->carrito_agregar($id);
        if($query){
            return redirect()->route('carrito_compra');
        }else{
            return redirect()->route('detalle_producto_ecommerce', ['id' => $id]);
        }
    }

    public function carrito_index(){
        // session()->forget('carrito_compra');
        $user_id = isset(Auth::user()->id) ? Auth::user()->id : 0;

        $user_coords =  UsersCoordenada::where('user_id', $user_id)->where('descripcion', '<>', '')->orderBy('concurrencia', 'DESC')->limit(5)->get();
        $pasarela_pago = PasarelaPago::where('deleted_at', NULL)->get();

        $carrito = session()->has('carrito_compra') ? session()->get('carrito_compra') : array();
        $precios = [];
        $ofertas = [];
        foreach ($carrito as $item) {
            // Obetener precios
            $producto_unidades = (new Productos)->obtener_precios_venta($item->id);

            if(count($producto_unidades)>0){
                $precio = ['precio' => $producto_unidades[0]->precio, 'unidad' => $producto_unidades[0]->unidad, 'moneda' => $producto_unidades[0]->moneda];
            }else{
                $precio = ['precio' => 0, 'unidad' => 'No definida', 'moneda' => 'No definida'];
            }
            array_push($precios, $precio);

            // Ver si esta en oferta
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            array_push($ofertas, $oferta);
        }

        switch (setting('admin.modo_sistema')) {
            case 'boutique':

                break;
            case 'electronica_computacion':
            return view('ecommerce/computacion_electronica/carrito', compact('carrito', 'precios', 'ofertas', 'user_coords', 'pasarela_pago'));
                break;
            case 'restaurante':
            return view('ecommerce/restaurante/carrito', compact('carrito', 'precios', 'ofertas', 'user_coords', 'pasarela_pago'));
                break;
            default:
                # code...
                break;
        }
    }

    public function carrito_agregar($id){
        $carrito = session()->has('carrito_compra') ? session()->get('carrito_compra') : array();

        $producto = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->join('usos as u', 'u.id', 'p.uso_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('monedas as mn', 'mn.id', 'p.moneda_id')
                            ->join('ecommerce_productos as ec', 'ec.producto_id', 'p.id')
                            ->select('p.id', 'p.codigo', 'p.nombre', 'p.imagen', 'p.modelo', 'p.garantia', 'm.nombre as marca', 'mn.abreviacion as moneda', 'u.nombre as uso', 'c.nombre as color', 'g.nombre as genero')
                            // ->where('deleted_at', NULL)
                            ->where('p.id', $id)
                            ->first();
        if($producto){
            $carrito[$id] = $producto;
            session()->put('carrito_compra', $carrito);
            return 1;
        }else{
            return 0;
        }
    }

    public function carrito_borrar($id){
        // session()->forget('carrito_compra');
        $carrito = session()->has('carrito_compra') ? session()->get('carrito_compra') : array();
        $carrito_aux = array();
        foreach ($carrito as $item) {
            if($item->id!=$id){
                array_push($carrito_aux, $item);
            }
        }
        session()->put('carrito_compra', $carrito_aux);
        $alerta = 'producto_eliminado';
        return redirect()->route('carrito_compra')->with(compact('alerta'));
    }

    public function pedidos_index($id){
        $sentencia = ($id!='last') ? " v.id = $id" : 1;
        $ultimo_pedido = DB::table('ventas as v')
                                ->join('clientes as c', 'c.id', 'v.cliente_id')
                                ->select('v.id', 'v.tipo_estado')
                                ->where('c.user_id', Auth::user()->id)
                                ->whereRaw($sentencia)
                                ->first();
        if($ultimo_pedido){
            $mi_ubicacion = DB::table('users_coordenadas as u')
                                ->select('u.lat', 'u.lon')
                                ->where('u.user_id', Auth::user()->id)
                                ->where('u.ultima_ubicacion', 1)
                                ->first();
            $detalle_pedido = DB::table('ventas_detalles as dv')
                                    ->join('productos as p', 'p.id', 'dv.producto_id')
                                    ->join('monedas as m', 'm.id', 'p.moneda_id')
                                    ->select('p.*', 'dv.cantidad as cantidad_pedido', 'dv.precio as precio_pedido', 'm.abreviacion as moneda')
                                    ->where('dv.venta_id', $ultimo_pedido->id)
                                    ->get();

            $pedidos = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.id', 'v.tipo_estado', 'v.created_at')
                            ->where('c.user_id', Auth::user()->id)
                            ->orderBy('id', 'DESC')
                            ->get();
            $productos_pedidos = [];
            foreach ($pedidos as $item) {
                $aux = DB::table('ventas_detalles as dv')
                            ->join('productos as p', 'p.id', 'dv.producto_id')
                            ->select('p.nombre')
                            ->where('dv.venta_id', $item->id)
                            ->get();
                array_push($productos_pedidos, $aux);
            }
        }

        switch (setting('admin.modo_sistema')) {
            case 'boutique':

                break;
            case 'electronica_computacion':
                if($ultimo_pedido){
                    return view('ecommerce/restaurante/pedidos', compact('ultimo_pedido', 'mi_ubicacion', 'detalle_pedido', 'pedidos', 'productos_pedidos'));
                }else{
                    return view('ecommerce/restaurante/pedidos_empty');
                }
                break;
                break;
            case 'restaurante':
                if($ultimo_pedido){
                    return view('ecommerce/restaurante/pedidos', compact('ultimo_pedido', 'mi_ubicacion', 'detalle_pedido', 'pedidos', 'productos_pedidos'));
                }else{
                    return view('ecommerce/restaurante/pedidos_empty');
                }
                break;
            default:
                # code...
                break;
        }
    }

    public function get_estado_pedido($id){
        return DB::table('ventas as v')
                                ->join('clientes as c', 'c.id', 'v.cliente_id')
                                ->select('v.tipo_estado')
                                ->where('c.user_id', Auth::user()->id)
                                ->whereRaw('v.id', $id)
                                ->first()->tipo_estado;
    }

    public function ecommerce_policies(){
        return 'politicas';
    }
}


