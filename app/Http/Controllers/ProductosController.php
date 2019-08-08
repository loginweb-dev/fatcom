<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\LoginwebController as LW;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

use App\Categoria;
use App\Subcategoria;
use App\Uso;
use App\Genero;
use App\Unidade;
use App\Marca;
use App\Talla;
use App\Colore;
use App\Modelo;
use App\Producto;

class ProductosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $registros = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->select('p.*', 's.nombre as subcategoria')
                            // ->where('deleted_at', NULL)
                            ->orderBy('p.id', 'DESC')
                            ->paginate(10);
        $precios = [];
        $cantidades = [];
        if(count($registros)>0){

            foreach ($registros as $item) {
                // Obtener precios de venta del producto
                $producto_unidades = $this->obtener_precios_venta($item->id);

                if(count($producto_unidades)>0){
                    $precio = ['precio' => $producto_unidades[0]->precio, 'unidad' => $producto_unidades[0]->unidad];
                }else{
                    $precio = ['precio' => 0, 'unidad' => 'No definida'];
                }
                array_push($precios, $precio);

                // // Obtener stock actual del producto en todos los deposito
                // $productos_depositos = DB::table('productos_depositos as d')
                //                         ->select(DB::raw('sum(d.stock) as stock'))
                //                         ->where('producto_id', $item->id)
                //                         ->first();
                // if($productos_depositos){
                //     if($productos_depositos->stock){
                //         $cantidad = ['cantidad' => $productos_depositos->stock];
                //     }else{
                //         $cantidad = ['cantidad' => 0];
                //     }
                // }else{
                //     $cantidad = ['cantidad' => 0];
                // }
                // array_push($cantidades, $cantidad);
            }
        }

        $value = '';
        return view('inventarios/productos/productos_index', compact('registros', 'value', 'precios', 'cantidades'));
    }

    public function search($value)
    {
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->select('p.*', 's.nombre as subcategoria')
                            ->whereRaw("
                                            p.codigo like '%".$value."%' or
                                            p.nombre like '%".$value."%' or
                                            s.nombre like '%".$value."%'
                                        ")
                            ->paginate(10);
        $precios = [];
        $cantidades = [];
        if(count($registros)>0){

            // Obtener precios del producto
            foreach ($registros as $item) {
                $producto_unidades = $this->obtener_precios_venta($item->id);

                if(count($producto_unidades)>0){
                    $precio = ['precio' => $producto_unidades[0]->precio, 'unidad' => $producto_unidades[0]->unidad];
                }else{
                    $precio = ['precio' => 0, 'unidad' => 'No definida'];
                }
                array_push($precios, $precio);
            }

            // // Obtener cantidad del producto
            // foreach ($registros as $item) {
            //     $productos_depositos = DB::table('productos_depositos as d')
            //                             ->select(DB::raw('sum(d.stock) as stock'))
            //                             ->where('producto_id', $item->id)
            //                             ->first();
            //     if($productos_depositos){
            //         $cantidad = ['cantidad' => $productos_depositos->stock];
            //     }else{
            //         $cantidad = ['cantidad' => 0];
            //     }
            //     array_push($cantidades, $cantidad);
            // }
        }

        return view('inventarios/productos/productos_index', compact('registros', 'value', 'precios', 'cantidades'));
    }

    public function view($id){
        $producto = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->join('usos as u', 'u.id', 'p.uso_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('monedas as mn', 'mn.id', 'p.moneda_id')
                            ->join('categorias as ca', 'ca.id', 's.categoria_id')
                            ->select('p.*', 'ca.nombre as categoria', 's.nombre as subcategoria', 'm.nombre as marca', 'mn.abreviacion as moneda', 'm.nombre as marca', 'u.nombre as uso', 'c.nombre as color', 'g.nombre as genero')
                            // ->where('deleted_at', NULL)
                            ->where('p.id', $id)
                            ->first();
        $imagenes = DB::table('producto_imagenes')
                            ->select('imagen')
                            ->where('producto_id', $id)
                            ->where('deleted_at', NULL)
                            // ->where('tipo', 'principal')
                            ->get();
        $precios_venta = DB::table('producto_unidades as p')
                                ->join('unidades as u', 'u.id', 'p.unidad_id')
                                ->select('p.*', 'u.nombre as unidad')
                                ->where('p.producto_id', $id)
                                ->where('p.deleted_at', NULL)
                                ->get();

        $precios_compra = DB::table('precios_compras as p')
                                ->select('p.*')
                                ->where('p.producto_id', $id)
                                ->where('deleted_at', NULL)
                                ->get();
        $insumos_productos = DB::table('insumos as i')
                                ->join('productos_insumos as pi', 'pi.insumo_id', 'i.id')
                                ->join('unidades as u', 'u.id', 'i.unidad_id')
                                ->select('i.*', 'pi.cantidad', 'u.abreviacion as unidad')
                                ->where('pi.producto_id', $id)
                                ->where('pi.deleted_at', NULL)
                                ->get();

        switch (setting('admin.modo_sistema')) {
            case 'boutique':
                return view('inventarios/productos/boutique/productos_view', compact('producto', 'imagenes', 'id', 'precios'));
                break;
            case 'electronica_computacion':
                return view('inventarios/productos/electronica_computacion/productos_view', compact('producto', 'imagenes', 'id', 'precios_venta', 'precios_compra'));
                break;
            case 'restaurante':
                return view('inventarios/productos/restaurante/productos_view', compact('producto', 'imagenes', 'id', 'precios_venta', 'precios_compra', 'insumos_productos'));
                break;
            default:
                # code...
                break;
        }
    }

    public function create(){
        $codigo_grupo = $this->ultimo_producto() + 1;
        $categorias = DB::table('categorias')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $subcategorias = [];
        if(count($categorias)>0){
            $subcategorias = DB::table('subcategorias')
                                    ->select('*')
                                    ->where('deleted_at', NULL)
                                    ->where('id', '>', 1)
                                    ->where('categoria_id', $categorias[0]->id)
                                    ->get();
        }

        $marcas = DB::table('marcas')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $tallas = DB::table('tallas')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $colores = DB::table('colores')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $generos = DB::table('generos')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $usos = DB::table('usos')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $unidades = DB::table('unidades')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $monedas = DB::table('monedas')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $insumos = DB::table('insumos as i')
                            ->join('unidades as u', 'u.id', 'i.unidad_id')
                            ->select('i.*', 'u.abreviacion as unidad')
                            ->where('i.deleted_at', NULL)
                            // ->where('id', '>', 1)
                            ->get();

        // Obtener el primer deposito registrado, en caso de ser mas de uno se debe especificar 
        // de alguna forma que deposito se debe obtener
        $depositos = DB::table('depositos')
                            ->select('id')
                            ->where('deleted_at', NULL)
                            ->first();

        switch (setting('admin.modo_sistema')) {
            case 'boutique':
            return view('inventarios/productos/boutique/productos_create', compact('codigo_grupo', 'categorias', 'subcategorias', 'marcas', 'tallas', 'colores', 'generos', 'usos', 'unidades', 'depositos'));
                break;
            case 'electronica_computacion':
                return view('inventarios/productos/electronica_computacion/productos_create', compact('codigo_grupo', 'categorias', 'subcategorias', 'marcas', 'tallas', 'colores', 'generos', 'usos', 'unidades', 'monedas', 'depositos'));
                break;
            case 'restaurante':
                return view('inventarios/productos/restaurante/productos_create', compact('codigo_grupo', 'categorias', 'subcategorias', 'insumos', 'depositos'));
                break;
            default:
                # code...
                break;
        }
    }

    public function store(Request $data){
        // dd($data);
        $data->validate([
            'nombre' => 'required|max:191',
            'precio_venta' => 'required|max:10',
            'descripcion_small' => 'required'
        ]);

        $query = $this->crear_producto($data);

        if($query){
            if(isset($data->permanecer)){
                return redirect()->route('productos_create')->with(['message' => 'Producto guardado exitosamenete.', 'alert-type' => 'success']);
            }else{
                return redirect()->route('productos_index')->with(['message' => 'Producto guardado exitosamenete.', 'alert-type' => 'success']);
            }
        }else{
            return redirect()->route('productos_index')->with(['message' => 'Ocurrio un problema al guardar el producto.', 'alert-type' => 'error']);
        }
    }

    public function edit($id){
        $categorias = DB::table('categorias')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $subcategorias = DB::table('subcategorias')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $marcas = DB::table('marcas')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $tallas = DB::table('tallas')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $colores = DB::table('colores')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $generos = DB::table('generos')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $usos = DB::table('usos')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $unidades = DB::table('unidades')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $monedas = DB::table('monedas')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $insumos = DB::table('insumos as i')
                            ->join('unidades as u', 'u.id', 'i.unidad_id')
                            ->select('i.*', 'u.abreviacion as unidad')
                            ->where('i.deleted_at', NULL)
                            // ->where('id', '>', 1)
                            ->get();

        $producto = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->select('p.*', 's.categoria_id')
                            // ->where('deleted_at', NULL)
                            ->where('p.id', $id)
                            ->first();
        $imagen = DB::table('producto_imagenes')
                            ->select('id', 'imagen')
                            ->where('producto_id', $id)
                            ->where('deleted_at', NULL)
                            ->orderBy('tipo', 'ASC')
                            // ->where('tipo', 'principal')
                            ->get();
        $precio_venta = DB::table('producto_unidades')
                            ->select('*')
                            ->where('producto_id', $id)
                            ->where('deleted_at', NULL)
                            ->get();
        $precio_compra = DB::table('precios_compras')
                            ->select('*')
                            ->where('producto_id', $id)
                            ->where('deleted_at', NULL)
                            ->get();
        $insumos_productos = DB::table('insumos as i')
                                ->join('productos_insumos as pi', 'pi.insumo_id', 'i.id')
                                ->join('unidades as u', 'u.id', 'i.unidad_id')
                                ->select('i.*', 'pi.cantidad', 'u.abreviacion as unidad')
                                ->where('pi.producto_id', $id)
                                ->where('pi.deleted_at', NULL)
                                ->get();

        switch (setting('admin.modo_sistema')) {
            case 'boutique':
            return view('inventarios/productos/boutique/productos_edit', compact('producto', 'imagen', 'precio_venta', 'categorias', 'subcategorias', 'marcas', 'tallas', 'colores', 'generos', 'usos', 'unidades'));
                break;
            case 'electronica_computacion':
                return view('inventarios/productos/electronica_computacion/productos_edit', compact('producto', 'imagen', 'precio_venta', 'precio_compra', 'categorias', 'subcategorias', 'marcas', 'monedas'));
                break;
            case 'restaurante':
                return view('inventarios/productos/restaurante/productos_edit', compact('producto', 'imagen', 'categorias', 'subcategorias', 'precio_venta', 'insumos', 'insumos_productos'));
                break;
            default:
                # code...
                break;
        }

    }

    public function update(Request $data){
        // dd($data);
        $data->validate([
            'nombre' => 'required|max:100',
            'precio_venta' => 'required|max:10',
            'descripcion_small' => 'required'
        ]);

        // Obtener valos si es un producto nuevo
        $nuevo = (isset($data->nuevo)) ? 1: NULL;

        // Obtener valos si es un producto nuevo
        $se_almacena = (isset($data->se_almacena)) ? 1: NULL;

        $query = DB::table('productos')
                    ->where('id', $data->id)
                    ->update([
                        'codigo_interno' => $data->codigo_interno,
                        'nombre' => $data->nombre,
                        'descripcion_small' => $data->descripcion_small,
                        'descripcion_long' => $data->descripcion_long,
                        'estante' => $data->estante,
                        'bloque' => $data->bloque,
                        'garantia' => $data->garantia,
                        // 'stock_minimo' => $data->stock_minimo,
                        'subcategoria_id' => $data->subcategoria_id,
                        'marca_id' => $data->marca_id,
                        'talla_id' => $data->talla_id,
                        'color_id' => $data->color_id,
                        'genero_id' => $data->genero_id,
                        'uso_id' => $data->uso_id,
                        'moneda_id' => $data->moneda_id,
                        'modelo' => $data->modelo,
                        'nuevo' => $nuevo,
                        'se_almacena' => $se_almacena,
                        // 'created_at' => Carbon::now(),
                        // 'updated_at' => Carbon::now()
                    ]);
        if(isset($data->precio_venta)){
            DB::table('producto_unidades')
                    ->where('producto_id', $data->id)->update(['deleted_at' => Carbon::now()]);
            for ($i=0; $i < count($data->precio_venta); $i++) {
                $query = DB::table('producto_unidades')
                                ->insert([
                                    'unidad_id' => $data->unidad_id,
                                    'producto_id' => $data->id,
                                    'precio' => $data->precio_venta[$i],
                                    'precio_minimo' => $data->precio_minimo[$i],
                                    'cantidad_minima' => $data->cantidad_minima_venta[$i],
                                    'cantidad_pieza' => 1,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
            }
        }

        // Guardar precios de compra (si existen)
        if(isset($data->monto)){
            DB::table('precios_compras')
                    ->where('producto_id', $data->id)->update(['deleted_at' => Carbon::now()]);
            for ($i=0; $i < count($data->monto); $i++) {
                $query = DB::table('precios_compras')
                                ->insert([
                                    'producto_id' => $data->id,
                                    'monto' => $data->monto[$i],
                                    'cantidad_minima' => $data->cantidad_minima_compra[$i],
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
            }
        }

        // guardar imagen si se agregó
        if($data->file('imagen')!=NULL){
            for ($i=0; $i < count($data->file('imagen')); $i++) {
                $imagen = $this->agregar_imagenes($data->file('imagen')[$i]);
                DB::table('producto_imagenes')
                        ->insert([
                                    'producto_id' => $data->id,
                                    'imagen' => $imagen,
                                    'tipo' => 'secundaria',
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
            }
        }

        // Editar catalogo
        if ($data->hasFile('catalogo')) {
            $file = $data->file('catalogo');
            $filename = str_random(20).'.'.$file->getClientOriginalExtension();
            $path = 'catalogos/'.date('F').date('Y').'/'.$filename;
            \Storage::disk('local')->put('public/'.$path,  \File::get($file));

            $query = DB::table('productos')
                            ->where('id', $data->id)
                            ->update([
                                'catalogo' => $path
                            ]);
        }

        // Guardar insumos (si existen)
        if(isset($data->insumo_id)){
            DB::table('productos_insumos')
                    ->where('producto_id', $data->id)->update(['deleted_at' => Carbon::now()]);
            for ($i=0; $i < count($data->insumo_id); $i++) {
                DB::table('productos_insumos')
                        ->insert([
                            'producto_id' => $data->id,
                            'insumo_id' => $data->insumo_id[$i],
                            'cantidad' => $data->cantidad_insumo[$i],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
            }
        }

        if($query){
            return redirect()->route('productos_index')->with(['message' => 'Producto editado exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('productos_index')->with(['message' => 'Ocurrio un problema al editar el producto.', 'alert-type' => 'error']);
        }
    }

    function ofertas_index(){

    }

    public function delete(Request $data){

    }

    public function cambiar_imagen($producto_id, $imagen_id){
        // Actualizar tipo de todas las imagenes a "secundaria"
        DB::table('producto_imagenes')
                ->where('producto_id', $producto_id)
                ->update(["tipo" => 'secundaria']);

        // Obetener imagen seleccionada
        $imagen = DB::table('producto_imagenes')
                        ->select('imagen')
                        ->where('id', $imagen_id)
                        ->first();

        // Actualizar imagen principal en tabla de productos
        if($imagen){
            DB::table('productos')
                ->where('id', $producto_id)
                ->update(["imagen" => $imagen->imagen]);
        }

        // Actualizar tipo de imagen seleccionada a "primaria"
        $query = DB::table('producto_imagenes')
                        ->where('id', $imagen_id)
                        ->update(["tipo" => 'principal']) ? 1 : 0;
        return $query;
    }

    public function delete_imagen(Request $data){
        $query = DB::table('producto_imagenes')
                        ->where('id', $data->id)
                        ->update(["deleted_at" => Carbon::now()]) ? 1 : 0;
        return $query;
    }

    public function puntuar(Request $data){
        $query = DB::table('productos_puntuaciones')
                        ->insert([
                            'producto_id' => $data->id,
                            'user_id' => Auth::user()->id,
                            'puntos' => ($data->puntos/20),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
        $alerta = 'producto_puntuado';
        return redirect()->route('detalle_producto_ecommerce', ['id'=>$data->id])->with(compact('alerta'));
    }

    // *************funciones adicionales*************

    public function crear_producto($data){
        // for ($i=0; $i < count($data->nombre); $i++) {

            // si la categoria no existe crearla
            if(!is_numeric($data->categoria_id)){
                $categoria = new Categoria;
                $categoria->nombre = $data->categoria_id;
                $categoria->save();
                $data->categoria_id = Categoria::all()->last()->id;
            }

            // si la subcategoria no existe crearla
            if(!is_numeric($data->subcategoria_id)){
                $subcategoria = new Subcategoria;
                $subcategoria->nombre = $data->subcategoria_id;
                $subcategoria->categoria_id = $data->categoria_id;
                $subcategoria->save();
                $data->subcategoria_id = Subcategoria::all()->last()->id;
            }

            // si el uso no existe crearla
            if(!is_numeric($data->uso_id)){
                $uso = new Uso;
                $uso->nombre = $data->uso_id;
                $uso->save();
                $data->uso_id = Uso::all()->last()->id;
            }

            // si el uso no existe crearla
            if(!is_numeric($data->genero_id)){
                $genero = new Genero;
                $genero->nombre = $data->genero_id;
                $genero->save();
                $data->genero_id = Genero::all()->last()->id;
            }

            // si la unidad no existe crearla
            if(!is_numeric($data->unidad_id)){
                $unidad = new Unidade;
                $unidad->nombre = $data->unidad_id;
                $unidad->save();
                $data->unidad_id = Unidade::all()->last()->id;
            }

            // si la marca no existe crearla
            if(!is_numeric($data->marca_id)){
                $marca = new Marca;
                $marca->nombre = $data->marca_id;
                $marca->save();
                $data->marca_id = Marca::all()->last()->id;
            }

            // si la talla no existe crearla
            if(!is_numeric($data->talla_id)){
                $talla = new Talla;
                $talla->nombre = $data->talla_id;
                $talla->save();
                $data->talla_id = Talla::all()->last()->id;
            }

            // si la color no existe crearla
            if(!is_numeric($data->color_id)){
                $color = new Colore;
                $color->nombre = $data->color_id;
                $color->save();
                $data->color_id = Colore::all()->last()->id;
            }

            // Obtener valos si es un producto nuevo
            $nuevo = (isset($data->nuevo)) ? 1: NULL;

            // Obtener valos si el producto se almacena
            $se_almacena = (isset($data->se_almacena)) ? 1: NULL;

            // Obtener primer precio ingresado
            $precio_venta = 0;
            $precio_minimo = 0;
            if(isset($data->precio_venta)){
                $precio_venta = $data->precio_venta[0];
                $precio_minimo = $data->precio_minimo[0];
            }

            $producto = new Producto;
            $producto->codigo_interno = $data->codigo_interno;
            $producto->nombre = $data->nombre;
            $producto->descripcion_small = $data->descripcion_small;
            $producto->descripcion_long = $data->descripcion_long;
            $producto->estante = $data->estante;
            $producto->bloque = $data->bloque;
            $producto->stock = $data->stock;
            $producto->garantia = $data->garantia;
            $producto->subcategoria_id = $data->subcategoria_id;
            $producto->marca_id = $data->marca_id;
            $producto->talla_id = $data->talla_id;
            $producto->color_id = $data->color_id;
            $producto->genero_id = $data->genero_id;
            $producto->moneda_id = $data->moneda_id;
            $producto->modelo = $data->modelo;
            $producto->uso_id = $data->uso_id;
            $producto->codigo_grupo = $data->codigo_grupo;
            $producto->nuevo = $nuevo;
            $producto->se_almacena = $se_almacena;
            $producto->precio_venta = $precio_venta;
            $producto->precio_minimo = $precio_minimo;
            $producto->save();

            // $query = DB::table('productos')
            //     ->insert([
            //         'codigo_interno' => $data->codigo_interno,
            //         'nombre' => $data->nombre,
            //         'descripcion_small' => $data->descripcion_small,
            //         'descripcion_long' => $data->descripcion_long,
            //         'estante' => $data->estante,
            //         'bloque' => $data->bloque,
            //         'stock' => $data->stock,
            //         'garantia' => $data->garantia,
            //         // 'stock_minimo' => $data->stock_minimo,
            //         'subcategoria_id' => $data->subcategoria_id,
            //         'marca_id' => $data->marca_id,
            //         'talla_id' => $data->talla_id,
            //         'color_id' => $data->color_id,
            //         'genero_id' => $data->genero_id,
            //         'moneda_id' => $data->moneda_id,
            //         'modelo' => $data->modelo,
            //         'uso_id' => $data->uso_id,
            //         'codigo_grupo' => $data->codigo_grupo,
            //         'nuevo' => $nuevo,
            //         'se_almacena' => $se_almacena,
            //         'precio_venta' => $precio_venta,
            //         'precio_minimo' => $precio_minimo,
            //         // 'created_at' => Carbon::now(),
            //         // 'updated_at' => Carbon::now()
            //     ]);

            // Obtener el ultmimo ingresado
            $producto_id = Producto::all()->last()->id;
            // $producto_id = $this->ultimo_producto();

            // agregar imagenes
            $imagen_portada = '';
            if($data->file('imagen')!=NULL){
                $tipo_imagen = 'principal';
                for ($i=0; $i < count($data->file('imagen')); $i++) {
                    $imagen = $this->agregar_imagenes($data->file('imagen')[$i]);
                    DB::table('producto_imagenes')
                            ->insert([
                                        'producto_id' => $producto_id,
                                        'imagen' => $imagen,
                                        'tipo' => $tipo_imagen,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                    if($tipo_imagen=='principal'){
                        $imagen_portada = $imagen;
                    }
                    $tipo_imagen = 'secundaria';
                }
            }
            $catalogo = '';
            if ($data->hasFile('catalogo')) {
                $file = $data->file('catalogo');
                $filename = str_random(20).'.'.$file->getClientOriginalExtension();
                $path = 'catalogos/'.date('F').date('Y').'/'.$filename;
                \Storage::disk('local')->put('public/'.$path,  \File::get($file));
                $catalogo = $path;
            }

            // guardar precio de la unidad ingresada
            if(isset($data->precio_venta)){
                for ($i=0; $i < count($data->precio_venta); $i++) {
                    DB::table('producto_unidades')
                            ->insert([
                                'unidad_id' => $data->unidad_id,
                                'producto_id' => $producto_id,
                                'precio' => $data->precio_venta[$i],
                                'precio_minimo' => $data->precio_minimo[$i],
                                'cantidad_minima' => $data->cantidad_minima_venta[$i],
                                'cantidad_pieza' => 1,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                }
            }

            // Guardar precios de compra (si existen)
            if(isset($data->monto)){
                for ($i=0; $i < count($data->monto); $i++) {
                    DB::table('precios_compras')
                            ->insert([
                                'producto_id' => $producto_id,
                                'monto' => $data->monto[$i],
                                'cantidad_minima' => $data->cantidad_minima_compra[$i],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                }
            }

            // Guardar insumos si existen
            if(isset($data->insumo_id)){
                for ($i=0; $i < count($data->insumo_id); $i++) {
                    DB::table('productos_insumos')
                            ->insert([
                                'producto_id' => $producto_id,
                                'insumo_id' => $data->insumo_id[$i],
                                'cantidad' => $data->cantidad_insumo[$i],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                }
            }

            // Agregar stock a almacen si el producto es almacenable
            if($se_almacena){
                DB::table('productos_depositos')
                            ->insert([
                                'deposito_id' => $data->deposito_id,
                                'producto_id' => $producto_id,
                                'stock' => $data->stock,
                                'stock_inicial' => $data->stock,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
            }

            // Editar codigos del producto
            DB::table('productos')
                    ->where('id', $producto_id)
                    ->update([
                                'codigo' => setting('admin.prefijo_codigo').'-'.str_pad($producto_id, 5, "0", STR_PAD_LEFT),
                                'codigo_barras' => date('Ymd').str_pad($producto_id, 5, "0", STR_PAD_LEFT),
                                'catalogo' => $catalogo,
                                'imagen' => $imagen_portada
                            ]);
        // }

        if($producto){
            return $producto_id;
        }else{
            return 0;
        }
    }

    public function agregar_imagenes($file){
        Storage::makeDirectory('public/productos/'.date('F').date('Y'));
        $base_name = str_random(20);

        // imagen normal
        $filename = $base_name.'.'.$file->getClientOriginalExtension();
        $image_resize = Image::make($file->getRealPath())->orientate();
        $image_resize->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $path =  'productos/'.date('F').date('Y').'/'.$filename;
        $image_resize->save('storage/'.$path);
        $imagen = $path;

        // imagen mediana
        $filename_medium = $base_name.'_medium.'.$file->getClientOriginalExtension();
        $image_resize = Image::make($file->getRealPath())->orientate();
        $image_resize->resize(650, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $path_medium = 'productos/'.date('F').date('Y').'/'.$filename_medium;
        $image_resize->save('storage/'.$path_medium);

        // imagen pequeña
        $filename_small = $base_name.'_small.'.$file->getClientOriginalExtension();
        $image_resize = Image::make($file->getRealPath())->orientate();
        $image_resize->resize(260, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $path_small = 'productos/'.date('F').date('Y').'/'.$filename_small;
        $image_resize->save('storage/'.$path_small);

        return $imagen;
    }

    public function get_producto($id){
        $producto = DB::table('productos as p')
                            ->join('producto_unidades as pu', 'pu.producto_id', 'p.id')
                            ->select('p.*', 'pu.precio')
                            ->where('p.id', $id)
                            ->first();
        if($producto){
            return response()->json($producto);
        }else{
            return null;
        }
    }

    public function ultimo_producto(){
        $producto = DB::table('productos')
                            ->select('id')
                            ->orderBy('id', 'DESC')
                            ->first();
        if($producto){
            return $producto->id;
        }else{
            return 0;
        }
    }

    public function obtener_precios_venta($id){
        return DB::table('producto_unidades as p')
                        ->join('productos as pr', 'pr.id', 'p.producto_id')
                        ->join('unidades as u', 'u.id', 'p.unidad_id')
                        ->join('monedas as m', 'm.id', 'pr.moneda_id')
                        ->select('p.precio', 'p.cantidad_minima', 'm.abreviacion as moneda', 'u.nombre as unidad')
                        ->where('p.producto_id', $id)
                        ->where('p.deleted_at', NULL)
                        ->get();
    }

    public function obtener_puntos($id){
        return DB::table('productos_puntuaciones')
                    ->where('producto_id', $id)
                    ->where('deleted_at', NULL)
                    ->avg('puntos');
    }

    // ===================================================
    public function cargar_vista($tabla){
        switch ($tabla) {
            case 'categoria':
            $categorias = DB::table('categorias')
                                    ->select('*')
                                    ->where('deleted_at', NULL)
                                    ->get();
                return view('inventarios/productos/form-addcategoria', compact('categorias'));
                break;

            default:
                # code...
                break;
        }
    }
}
