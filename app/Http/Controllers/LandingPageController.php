<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Http\Controllers\LoginwebController as LW;
use App\Http\Controllers\OfertasController as Ofertas;
use App\Http\Controllers\ProductosController as Productos;
use App\Http\Controllers\SucursalesController as Sucursales;

use App\User;
use App\ClientesCoordenada;
use App\PasarelaPago;
use App\Venta;
use App\Producto;
use App\Oferta;
use App\Categoria;
use App\Subcategoria;
use App\Marca;
use App\Sucursale;
use App\Localidade;
use App\Cliente;
use App\IeCaja;

class LandingPageController extends Controller
{
    public function index(){
        $categorias = Categoria::with('subcategorias.productos')->where('deleted_at', NULL)->where('id', '>', 1)->get();

        $marcas = DB::table('marcas as m')
                            ->join('productos as p', 'p.marca_id', 'm.id')
                            ->join('ecommerce_productos as ec', 'ec.producto_id', 'p.id')
                            ->select(DB::raw('m.id, m.nombre, count(p.id) as productos, m.logo, m.slug'))
                            ->where('m.deleted_at', NULL)
                            ->groupBy('id', 'nombre')
                            ->orderBy('productos', 'DESC')
                            ->limit(10)
                            ->get();
        $oferta = (new Ofertas)->get_oferta_random();   
        $ofertas = (new Ofertas)->get_productos_oferta();
            
        $lista_subcategorias = DB::table('subcategorias as s')
                                    ->join('productos as p', 'p.subcategoria_id', 's.id')
                                    ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                                    ->select('s.id', 's.nombre', 's.slug')
                                    ->where('s.deleted_at', NULL)
                                    ->distinct()
                                    ->get();
        $subcategoria_productos = collect();
        // Recorrer las subcategorias     
        foreach ($lista_subcategorias as $item) {
            $collect_aux = collect($item);
            // Recorrer los productos que no esten en oferta de la subcategoría
            $lista_productos = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->select('p.id', 'p.nombre', 'p.imagen', 'p.nuevo', 'p.slug')
                            ->whereNotIn('p.id', function($q){
                                $dia_semana = date('N');
                                $dia_mes = date('j');
                                $q->from('productos as p')
                                    ->join('ofertas_detalles as df', 'df.producto_id', 'p.id')
                                    ->join('ofertas as o', 'o.id', 'df.oferta_id')
                                    ->select('p.id')
                                    ->whereRaw("( (o.tipo_duracion = 'rango' and o.inicio < '".Carbon::now()."' and (o.fin is NULL or o.fin > '".Carbon::now()."')) or (o.tipo_duracion = 'semanal' and o.dia = $dia_semana) or (o.tipo_duracion = 'mensual' and o.dia = $dia_mes) )")
                                    ->where('df.deleted_at', NULL)
                                    ->where('o.deleted_at', NULL)->get();
                            })
                            ->where('s.id', $item->id)->where('e.deleted_at', NULL)
                            ->get();
            // Si existe al menos un producto se lo agrega a la colección
            if(count($lista_productos)){
                $collect_aux->put('productos',$lista_productos);
                $subcategoria_productos->push($collect_aux);
            }
        }

        // SE USA EN LA VISTA DE RESTAURANTES V1
        $mas_vendidos = $this->get_mas_vendidos(9);

        $populares = $this->get_populares();

        $oferta_princial = Oferta::all()->where('deleted_at', NULL)->first();

        $sucursales = Sucursale::where('deleted_at', null)->get();

        return view('ecommerce.'.setting('admin.ecommerce').'index', compact('categorias', 'marcas', 'oferta', 'ofertas', 'subcategoria_productos', 'mas_vendidos', 'populares', 'oferta_princial', 'sucursales'));
    }

    public function filter(){
        $marca_filtro = \Request::query('brand') ? Marca::where('slug', \Request::query('brand'))->first() : null;
        $subcategoria_filtro = \Request::query('subcategory') ? Subcategoria::where('slug', \Request::query('subcategory'))->first() : null;

        $categorias = Categoria::with('subcategorias')->where('deleted_at', NULL)->where('id', '>', 1)->get();
        $marcas = DB::table('marcas as m')
                            ->join('productos as p', 'p.marca_id', 'm.id')
                            ->join('ecommerce_productos as ec', 'ec.producto_id', 'p.id')
                            ->select(DB::raw('m.id, m.nombre, count(p.id) as productos, m.logo'))
                            ->where('m.deleted_at', NULL)
                            ->groupBy('id', 'nombre')
                            ->orderBy('productos', 'DESC')
                            ->limit(5)
                            ->get();
        return view('ecommerce.'.setting('admin.ecommerce').'filter', compact('marcas', 'categorias', 'marca_filtro', 'subcategoria_filtro'));
    }

    public function list($cantidad = 12){
        $productos = DB::table('productos as p')
                    ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                    ->select(DB::raw('p.id, p.nombre, p.precio_venta, p.nuevo, p.imagen, p.vistas, (select AVG(puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos, p.slug'))
                    ->orderBy('vistas', 'DESC')
                    ->where('e.deleted_at', NULL)
                    ->where('e.activo', 1)
                    ->paginate($cantidad);
        return view('ecommerce.'.setting('admin.ecommerce').'lista', compact('productos'));
    }

    public function search(Request $data, $cantidad = 10){
        // dd($data);
        $sentencia = '1';
        $precio_min = $data->min;
        $precio_max = $data->max;

        if($data->tipo_busqueda=='click'){
            $filtro_marca = ($data->marca_id != '') ? ' p.marca_id = '.$data->marca_id : ' 1';
            $filtro_subcategoria = ($data->subcategoria_id != '') ? ' and p.subcategoria_id = '.$data->subcategoria_id : ' and 1';
            $filtro_categoria = ($data->categoria_id != '') ? ' and s.categoria_id = '.$data->categoria_id : ' and 1';
            $sentencia = $filtro_marca.$filtro_subcategoria.$filtro_categoria;

            // filtro de precios
            if(empty($precio_min) && !empty($precio_max)){
                $sentencia .= " and p.precio_venta < $precio_max";
            }else if(!empty($precio_min) && empty($precio_max)){
                $sentencia .= " and p.precio_venta > $precio_min";
            }else if(!empty($precio_min) && !empty($precio_max)){
                $sentencia .= " and p.precio_venta between $precio_min and $precio_max ";
            }

        }
        // Sentencia
        if($data->tipo_busqueda=='text'){
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
                            ->select(DB::raw('p.id, p.nombre, p.precio_venta, p.imagen, p.modelo, p.garantia,
                                            p.descripcion_small, p.vistas, p.slug, s.nombre as subcategoria, m.nombre as marca,
                                            mn.abreviacion as moneda, u.nombre as uso, co.nombre as color, g.nombre as genero, p.codigo_grupo, p.nuevo,
                                            (select AVG(puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos, p.deleted_at as monto_oferta, p.deleted_at as tipo_descuento, p.deleted_at as fin_descuento'))
                            // ->where('deleted_at', NULL)
                            ->whereRaw($sentencia)
                            ->where('s.deleted_at', NULL)
                            ->where('m.deleted_at', NULL)
                            ->where('e.deleted_at', NULL)
                            ->where('e.activo', 1)
                            ->groupBy('p.id', 'p.nombre', 'p.precio_venta', 'p.imagen', 'p.modelo', 'p.garantia', 'p.descripcion_small', 'p.vistas', 'p.slug', 's.nombre', 'm.nombre', 'mn.abreviacion', 'u.nombre', 'co.nombre', 'g.nombre', 'p.codigo_grupo', 'p.deleted_at')
                            ->paginate($cantidad);
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

        // Obtener el tipo de vista
        $view = $data->view_type ?? 'normal';

        return view('ecommerce.'.setting('admin.ecommerce').'resultados', compact('productos', 'precio_min', 'precio_max', 'view'));
    }

    public function search_product($busqueda, $cantidad = 10){
        $busqueda = $busqueda == 'all' ? '' : $busqueda;
        return  DB::table('productos as p')
                        ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                        ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                        ->join('categorias as c', 'c.id', 's.categoria_id')
                        ->select(   'p.nombre', 'p.precio_venta', 'p.vistas', 's.nombre as subcategoria', 'p.slug', 'p.imagen', 'p.descripcion_small',
                                    DB::raw('(select AVG(pp.puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos'))
                        ->where('p.deleted_at', NULL)->where('s.deleted_at', NULL)->where('s.deleted_at', NULL)
                        ->whereRaw("(p.nombre like '%$busqueda%' or s.nombre like '%$busqueda%' or c.nombre like '%$busqueda%')")
                        ->groupBy('p.nombre', 'p.precio_venta', 'p.vistas', 's.nombre', 'p.slug')
                        ->orderBy('p.vistas', 'DESC')->orderBy('p.precio_venta', 'ASC')->limit($cantidad)->get();
    }

    public function ofertas(){
        $productos = (new Ofertas)->get_productos_oferta();
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
                                ->select('p.id', 'p.nombre', 'p.imagen', 'p.slug')
                                ->where('o.inicio', '<', Carbon::now())
                                ->whereRaw(" (o.fin is NULL or o.fin > '".Carbon::now()."')")
                                ->where('df.deleted_at', NULL)
                                ->where('o.deleted_at', NULL)
                                ->limit(10)
                                ->get();

        return view('ecommerce/ofertas', compact('productos', 'precios', 'puntuaciones', 'recomendaciones'));
    }

    public function subcategorias(Subcategoria $subcategoria){
        $id = $subcategoria->id;
        $subcategoria = DB::table('subcategorias')->select('nombre', 'slug')->where('id', $id)->first();

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
                            ->select('p.id', 'p.nombre', 'p.imagen', 'modelo', 'p.garantia', 'p.descripcion_small', 'p.slug', 's.nombre as subcategoria', 'm.nombre as marca', 'mn.abreviacion as moneda', 'u.nombre as uso', 'co.nombre as color', 'g.nombre as genero')
                            // ->where('deleted_at', NULL)
                            ->where('s.deleted_at', NULL)
                            ->where('m.deleted_at', NULL)
                            ->where('e.deleted_at', NULL)
                            ->where('e.activo', 1)
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
                                ->select('p.id', 'p.nombre', 'p.imagen', 'p.slug')
                                ->where('p.subcategoria_id', $id)
                                ->limit(10)
                                ->get();

        return view('ecommerce/subcategorias', compact('productos', 'precios', 'ofertas', 'puntuaciones', 'recomendaciones', 'subcategoria', 'id'));
    }

    public function detalle_producto(Producto $producto){
        $id = $producto->id;
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
                            ->select(DB::raw('p.id, p.nombre, p.precio_venta, p.imagen, p.modelo, p.garantia, p.descripcion_small, p.descripcion_long, p.vistas, p.catalogo, p.slug,
                                            s.nombre as subcategoria, m.nombre as marca, mn.abreviacion as moneda, u.nombre as uso, c.nombre as color, g.nombre as genero,
                                            ec.tags, p.nuevo, (select AVG(puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos, p.codigo_grupo'))
                            // ->where('deleted_at', NULL)
                            ->where('p.id', $id)
                            ->first();
        // Nota: Lo ideal seria que los productos (pizzas) se diferencien por tallas (tamaño)
        $presentaciones = DB::table('productos as p')
                                ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                ->select('p.*', 's.nombre as subcategoria')
                                ->where('p.codigo_grupo', $producto->codigo_grupo)->where('p.deleted_at', NULL)->orderBy('p.precio_venta', 'ASC')->get();

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
                                        ->where('producto_id', $id)->where('deleted_at', NULL)->first();
        }

        // Recomendaciones================
        $tags = explode(',', $producto->tags);
        $recomendaciones = [];
        foreach ($tags as $item) {
            $array = DB::table('productos as p')
                            ->join('ecommerce_productos as ec', 'ec.producto_id', 'p.id')
                            ->select(DB::raw('p.id, p.nombre, p.imagen, p.slug, (select AVG(puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos, p.codigo_grupo'))
                            ->where('ec.tags', 'like', "%$item%")
                            ->where('p.id', '<>', $id)
                            ->groupBy('p.id', 'p.nombre', 'p.imagen', 'p.slug', 'p.codigo_grupo')
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
                    array_push($recomendaciones, ['id'=>$item2->id, 'nombre'=>$item2->nombre, 'imagen'=>$item2->imagen, 'slug'=>$item2->slug, 'puntos'=>$item2->puntos, 'coincidencias'=>1]);
                }
            }
        }
        // Ordenar lista segun las coincidencias
        for ($i=0; $i < count($recomendaciones); $i++) {
            for ($j=$i+1; $j < count($recomendaciones); $j++) {
                if($recomendaciones[$i]['coincidencias'] < $recomendaciones[$j]['coincidencias']){

                    $aux = $recomendaciones[$i]['id'];
                    $recomendaciones[$i]['id'] = $recomendaciones[$j]['id'];
                    $recomendaciones[$j]['id'] = $aux;

                    $aux = $recomendaciones[$i]['nombre'];
                    $recomendaciones[$i]['nombre'] = $recomendaciones[$j]['nombre'];
                    $recomendaciones[$j]['nombre'] = $aux;

                    $aux = $recomendaciones[$i]['imagen'];
                    $recomendaciones[$i]['imagen'] = $recomendaciones[$j]['imagen'];
                    $recomendaciones[$j]['imagen'] = $aux;

                    $aux = $recomendaciones[$i]['slug'];
                    $recomendaciones[$i]['slug'] = $recomendaciones[$j]['slug'];
                    $recomendaciones[$j]['slug'] = $aux;

                    $aux = $recomendaciones[$i]['puntos'];
                    $recomendaciones[$i]['puntos'] = $recomendaciones[$j]['puntos'];
                    $recomendaciones[$j]['puntos'] = $aux;

                    $aux = $recomendaciones[$i]['coincidencias'];
                    $recomendaciones[$i]['coincidencias'] = $recomendaciones[$j]['coincidencias'];
                    $recomendaciones[$j]['coincidencias'] = $aux;
                }
            }
        }
        // ===============

        // Costo de envío segun la localidad en la que se encuentre el cliente
        // NOTA: Si el cliente no se encuentra logueado no se mostrará ningun dato
        $envio = NULL;
        if(Auth::user()){
            if(Auth::user()->localidad_id){
                $ubicacion = DB::table('ecommerce_envios as e')
                                    ->join('localidades as l', 'l.id', 'e.localidad_id')
                                    ->join('ecommerce_productos as ep', 'ep.id', 'e.ecommerce_producto_id')
                                    ->select('l.*', 'e.precio')
                                    ->where('localidad_id', Auth::user()->localidad_id)
                                    ->where('ep.producto_id', $id)
                                    ->where('l.deleted_at', NULL)->where('e.deleted_at', NULL)->first();
                if($ubicacion){
                    $envio = $ubicacion;
                }else{
                    $envio = 'no definido';
                }
            }else{
                $envio = 'no asignado';
            }
        }

        $oferta = (new Ofertas)->obtener_oferta($id);
        $dispositivo = LW::userAgent();

        $localidades_disponibles = DB::table('ecommerce_productos as ep')
                                    ->join('ecommerce_envios as ee', 'ee.ecommerce_producto_id', 'ep.id')
                                    ->join('localidades as l', 'l.id', 'ee.localidad_id')
                                    ->select('l.localidad as ciudad', 'ee.precio')
                                    ->where('l.deleted_at', NULL)->where('ep.deleted_at', NULL)->where('ee.deleted_at', NULL)
                                    ->where('l.activo', 1)->where('ep.producto_id', $id)
                                    ->get();
        return view('ecommerce.'.setting('admin.ecommerce').'detalle', compact('producto', 'presentaciones', 'imagenes', 'precios_venta', 'puntuacion', 'oferta', 'id', 'habilitar_puntuar', 'recomendaciones', 'dispositivo', 'envio', 'localidades_disponibles'));
    }

    public function cantidad_carrito(){
        $carrito = session()->has('carrito_compra') ? session()->get('carrito_compra') : array();
        return count($carrito);
    }

    public function cantidad_pedidos(){
        $pedidos = DB::table('ventas as v')
                        ->join('clientes as c', 'c.id', 'v.cliente_id')
                        ->join('users as u', 'u.cliente_id', 'c.id')
                        ->select('v.id')
                        ->where('u.id', Auth::user()->id)
                        ->where('v.venta_estado_id', '<=', 4)
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
        $cliente_id = isset(Auth::user()->id) ? User::find(Auth::user()->id)->cliente_id : 0;

        $user_coords =  ClientesCoordenada::where('cliente_id', $cliente_id)->where('descripcion', '<>', '')->orderBy('concurrencia', 'DESC')->limit(5)->get();
        $pasarela_pago = PasarelaPago::where('deleted_at', NULL)->get();

        $carrito = session()->has('carrito_compra') ? session()->get('carrito_compra') : array();
        // dd($carrito);
        $precios = [];
        $ofertas = [];
        foreach ($carrito as $item) {
            // Ver si esta en oferta
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            array_push($ofertas, $oferta);
        }

        // Obtener sucursales habilitadas para delivery y que hayan abierto caja
        $sucursales = (new Sucursales)->get_sucursales_activas();
        $count_sucursales = count($sucursales);

        $disponibles = [];
        foreach ($carrito as $item) {
            $envios = DB::table('ecommerce_productos as ep')
                            ->join('ecommerce_envios as ee', 'ee.ecommerce_producto_id', 'ep.id')
                            ->select('ep.producto_id as id', 'ee.precio as costo_envio', 'ee.localidad_id')
                            ->where('ep.producto_id', $item->id)->where('ee.deleted_at', NULL)->get();
            if($envios){
                array_push($disponibles, $envios);
            }
        }

        $mas_vendidos = $this->get_mas_vendidos(9);

        $pedido_pendiente = 0;
        if(Auth::user()){
            $pedido_pendiente = $this->cantidad_pedidos();
        }

        // dd($disponibles);
        return view('ecommerce.'.setting('admin.ecommerce').'carrito', compact('carrito', 'precios', 'ofertas', 'user_coords', 'pasarela_pago', 'cliente_id', 'sucursales', 'disponibles', 'mas_vendidos', 'pedido_pendiente', 'count_sucursales'));
    }

    public function get_precio($id, $cantidad){
        $aux = DB::table('producto_unidades as pu')
                        ->join('productos as p', 'p.id', 'pu.producto_id')
                        ->join('monedas as m', 'm.id', 'p.moneda_id')
                        ->select('pu.precio', 'pu.cantidad_minima', 'm.abreviacion as moneda')
                        ->where('pu.producto_id', $id)
                        ->where('pu.cantidad_minima', '>=', $cantidad)
                        ->orderBy('pu.cantidad_minima', 'ASC')
                        ->first();
        if($aux){
            if($aux->cantidad_minima == $cantidad){
                return response()->json($aux);
            }else{
                $registro = DB::table('producto_unidades as pu')
                            ->join('productos as p', 'p.id', 'pu.producto_id')
                            ->join('monedas as m', 'm.id', 'p.moneda_id')
                            ->select('pu.precio', 'pu.cantidad_minima', 'm.abreviacion as moneda')
                            ->where('pu.producto_id', $id)
                            ->where('pu.cantidad_minima', '<', $aux->cantidad_minima)
                            ->orderBy('pu.cantidad_minima', 'DESC')
                            ->first();
                return response()->json($registro);
            }
        }
        $registro = DB::table('producto_unidades as pu')
                            ->join('productos as p', 'p.id', 'pu.producto_id')
                            ->join('monedas as m', 'm.id', 'p.moneda_id')
                            ->select('pu.precio', 'pu.cantidad_minima', 'm.abreviacion as moneda')
                            ->where('pu.producto_id', $id)
                            ->orderBy('pu.cantidad_minima', 'DESC')
                            ->first();
            return response()->json($registro);
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
                            ->select('p.id', 'p.codigo', 'p.nombre', 'p.precio_venta', 'p.imagen', 'p.modelo', 'p.garantia', 'p.descripcion_small', 'p.slug', 's.nombre as subcategoria', 'm.nombre as marca', 'mn.abreviacion as moneda', 'u.nombre as uso', 'c.nombre as color', 'g.nombre as genero', 'p.deleted_at as cantidad')
                            // ->where('deleted_at', NULL)
                            ->where('p.id', $id)
                            ->first();
        $producto->cantidad = 1;

        $oferta = (new Ofertas)->obtener_oferta($id);
        if($oferta){
            $precio_venta = $producto->precio_venta;
            if($oferta->tipo_descuento=='porcentaje'){
                $precio_venta -= ($precio_venta*($oferta->monto/100));
            }else{
                $precio_venta -= $oferta->monto;
            }
            $producto->precio_venta = $precio_venta;
        }
        if($producto){
            $carrito[$id] = $producto;
            session()->put('carrito_compra', $carrito);
            return 1;
        }else{
            return 0;
        }
    }

    public function carrito_editar($id, $cantidad){
        $carrito = session()->has('carrito_compra') ? session()->get('carrito_compra') : array();
        $carrito[$id]->cantidad = $cantidad;
        session()->put('carrito_compra', $carrito);
    }

    public function carrito_borrar($id){
        $carrito = session()->has('carrito_compra') ? session()->get('carrito_compra') : array();
        $carrito_aux = array();
        foreach ($carrito as $item) {
            if($item->id != $id){
                $carrito_aux[$item->id] = $item;
            }
        }
        session()->put('carrito_compra', $carrito_aux);
        return 1;
    }

    public function pedidos_index($id){
        $sentencia = ($id!='last') ? " v.id = $id" : 1;
        $ultimo_pedido = DB::table('ventas as v')
                                ->join('clientes as c', 'c.id', 'v.cliente_id')
                                ->join('users as u', 'u.cliente_id', 'c.id')
                                ->join('sucursales as s', 's.id', 'v.sucursal_id')
                                ->join('ventas_estados as ve', 've.id', 'v.venta_estado_id')
                                ->select('v.id', 'v.venta_estado_id', 'v.venta_tipo_id', 's.latitud', 's.longitud', 've.nombre as nombre_estado', 've.etiqueta as etiqueta_estado')
                                ->where('u.id', Auth::user()->id)
                                ->whereRaw($sentencia)
                                ->orderBy('id', 'DESC')
                                ->first();
        if($ultimo_pedido){
            $mi_ubicacion = DB::table('clientes_coordenadas as cc')
                                ->join('clientes as c', 'c.id', 'cc.cliente_id')
                                ->join('users as u', 'u.cliente_id', 'c.id')
                                ->select('cc.lat', 'cc.lon')
                                ->where('u.id', Auth::user()->id)
                                ->where('cc.ultima_ubicacion', 1)
                                ->first();

            $detalle_pedido = DB::table('ventas_detalles as dv')
                                    ->join('productos as p', 'p.id', 'dv.producto_id')
                                    ->join('monedas as m', 'm.id', 'p.moneda_id')
                                    ->select('p.*', 'dv.cantidad as cantidad_pedido', 'dv.precio as precio_pedido', 'm.abreviacion as moneda')
                                    ->where('dv.venta_id', $ultimo_pedido->id)
                                    ->get();

            $pedidos = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->join('users as u', 'u.cliente_id', 'c.id')
                            ->select('v.id', 'v.venta_estado_id', 'v.created_at')
                            ->where('u.id', Auth::user()->id)
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
            return view('ecommerce.'.setting('admin.ecommerce').'pedidos', compact('ultimo_pedido', 'mi_ubicacion', 'detalle_pedido', 'pedidos', 'productos_pedidos'));
        }
        
        return view('ecommerce.'.setting('admin.ecommerce').'pedidos', compact('ultimo_pedido'));
    }

    public function ecommerce_policies(){
        return view('ecommerce.'.setting('admin.ecommerce').'policies');
    }


    public function profile(){

        // Verificar si el usuario tiene un cliente asignado
        $user = User::find(Auth::user()->id);
        $user->localidad_id = $user->localidad_id ?? 1;

        if(!$user->cliente_id){
            $cliente = Cliente::create(['razon_social' => $user->name]);
            $user->cliente_id = $cliente->id;
        }
        $user->save();

        $registro = DB::table('users as u')
                            ->join('clientes as c', 'c.id', 'u.cliente_id')
                            ->select('c.*', 'u.localidad_id', 'u.name', 'u.email', 'avatar', 'tipo_login')
                            ->where('c.deleted_at', NULL)->where('u.id', $user->id)->first();
        $localidad = $registro->localidad_id ? Localidade::find($registro->localidad_id) : NULL;

        $localidades = Localidade::where('deleted_at', NULL)->get();

        switch (setting('admin.ecommerce')) {
            case 'restaurante_v1.':
                return view('ecommerce.'.setting('admin.ecommerce').'auth.profile', compact('registro', 'localidad', 'localidades'));
                break;
            
            default:
                return view('auth.profile', compact('registro', 'localidad', 'localidades'));
                break;
        }
    }

    public function profile_update(Request $data){
        // actualizar datos de usuario
        $user = User::find(Auth::user()->id);
        $user->name = $data->name;
        $user->email = $data->email;
        $user->localidad_id = $data->localidad_id;
        if(!empty($data->password) && !empty($data->new_password) && !empty($data->repeat_password)){
            if($data->new_password != $data->repeat_password){
                $alerta = '';
                return redirect()->route('profile')->with(compact('alerta'));
            }
            dd($data);
        }
        $user->save();

        // Actualizar datos de cliente
        $cliente = Cliente::find(Auth::user()->cliente_id);
        $cliente->razon_social = $data->razon_social;
        $cliente->nit = $data->nit;
        $cliente->movil = $data->movil;
        $cliente->save();

        $alerta = 'cliente_editado';
        return redirect()->route('profile')->with(compact('alerta'));
    }

    public function payments_index(){
        return view('ecommerce.'.setting('admin.ecommerce').'formas_pago');
    }


    // ====================================================

    public function get_producto($id){
        $producto = DB::table('productos as p')
                            ->join('monedas as m', 'm.id', 'p.moneda_id')
                            ->join('producto_unidades as pu', 'pu.producto_id', 'p.id')
                            ->select(DB::raw('p.id, p.nombre, pu.precio, pu.precio as precio_antiguo, p.imagen, p.se_almacena, p.stock, p.descripcion_small as descripcion, m.abreviacion as moneda,
                                            (select AVG(puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos'))
                            ->where('p.id', $id)
                            ->where('pu.deleted_at', NULL)
                            ->first();

        if($producto){
            // Obtener si el producto está en oferta
            $oferta = (new Ofertas)->obtener_oferta($producto->id);
            if($oferta){
                $precio_venta = $producto->precio;
                if($oferta->tipo_descuento=='porcentaje'){
                    $precio_venta -= ($precio_venta*($oferta->monto/100));
                }else{
                    $precio_venta -= $oferta->monto;
                }
                $producto->precio = $precio_venta;
            }

            return response()->json($producto);
        }else{
            return null;
        }
    }

    public function get_populares($cantidad = 9){
        $populares = DB::table('productos as p')
                                ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                                ->join('monedas as mn', 'mn.id', 'p.moneda_id')
                                ->select(DB::raw('p.id, p.nombre, s.nombre as subcategoria, p.precio_venta, p.precio_venta as precio_venta_antiguo, p.nuevo, p.imagen, p.vistas, (select AVG(puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos,
                                                mn.abreviacion as moneda, p.slug, p.deleted_at as monto_oferta, p.deleted_at as tipo_descuento, p.deleted_at as fin_descuento'))
                                ->orderBy('vistas', 'DESC')
                                ->where('e.deleted_at', NULL)
                                ->where('e.activo', 1)
                                ->limit($cantidad)->get();
        $cont = 0;
        foreach ($populares as $item) {
            // Obtener si el producto está en oferta
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            if($oferta){
                $precio_venta = $item->precio_venta;
                if($oferta->tipo_descuento=='porcentaje'){
                    $precio_venta -= ($precio_venta*($oferta->monto/100));
                }else{
                    $precio_venta -= $oferta->monto;
                }
                $populares[$cont]->precio_venta = number_format($precio_venta, 2, '.', '');
            }
            $cont++;
        }
        return $populares;
    }

    public function get_mas_vendidos($cantidad){
        $mas_vendidos = DB::table('productos as p')
                                ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                ->join('marcas as m', 'm.id', 'p.marca_id')
                                ->join('colores as c', 'c.id', 'p.color_id')
                                ->join('ventas_detalles as vd', 'vd.producto_id', 'p.id')
                                ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                                ->join('monedas as mn', 'mn.id', 'p.moneda_id')
                                ->select(DB::raw('p.id, p.codigo_grupo, p.nombre, p.descripcion_small, s.nombre as subcategoria, p.precio_venta, p.precio_venta as precio_venta_antiguo, p.nuevo, p.imagen, count(vd.id) as cantidad,
                                                    (select AVG(puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos, m.nombre as marca, c.nombre as color,
                                                    mn.abreviacion as moneda, p.slug, p.deleted_at as monto_oferta, p.deleted_at as tipo_descuento, p.deleted_at as fin_descuento'))
                                ->groupBy('p.id', 'p.codigo_grupo', 'p.nombre', 'p.descripcion_small', 'subcategoria', 'precio_venta', 'precio_venta_antiguo', 'nuevo', 'imagen', 'puntos', 'mn.abreviacion', 'slug', 'p.deleted_at')
                                ->orderBy('cantidad', 'DESC')
                                ->where('e.deleted_at', NULL)
                                ->where('e.activo', 1)
                                ->whereYear('vd.created_at', date('Y'))
                                ->limit($cantidad)->get();
        $cont = 0;
        foreach ($mas_vendidos as $item) {
            // Obtener si el producto está en oferta
            $oferta = (new Ofertas)->obtener_oferta($item->id);
            if($oferta){
                $precio_venta = $item->precio_venta;
                if($oferta->tipo_descuento=='porcentaje'){
                    $precio_venta -= ($precio_venta*($oferta->monto/100));
                }else{
                    $precio_venta -= $oferta->monto;
                }
                $mas_vendidos[$cont]->precio_venta = number_format($precio_venta, 2, '.', '');
            }
            $cont++;
        }

        return $mas_vendidos;
    }
}


