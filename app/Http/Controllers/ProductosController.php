<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\LoginwebController as LW;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

use App\Http\Controllers\VentasController as Ventas;
use App\Http\Controllers\OfertasController as Ofertas;

use App\Categoria;
use App\Subcategoria;
use App\Uso;
use App\Genero;
use App\Unidade;
use App\Marca;
use App\Talla;
use App\Colore;
use App\Moneda;
use App\Modelo;
use App\Producto;
use App\ProductoUnidade;
use App\ProductoImagene;
use App\ProductosDeposito;
use App\Deposito;
use App\ProductosInsumo;
use App\Extra;
use App\ProductosExtra;

// Exportación a Excel
use App\Exports\CatalogoProductosExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categorias = DB::table('categorias as c')
                            ->join('subcategorias as s', 's.categoria_id', 'c.id')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('c.*')
                            ->where('p.deleted_at', NULL)
                            ->where('c.deleted_at', NULL)
                            ->where('c.id', '>', 1)
                            ->distinct()
                            ->get();
        $count_productos = Producto::where('deleted_at', NULL)->count();
        $value = '';
        return view('inventarios/productos/productos_index', compact('value', 'categorias', 'count_productos'));
    }

    public function productos_list($categoria, $subcategoria, $marca, $talla, $genero, $color, $search,$order="id",$typeOrder="desc", $cantpaginada = 10){
        $filtro_categoria = ($categoria != 'all') ? " s.categoria_id = $categoria " : ' 1 ';
        $filtro_subcategoria = ($subcategoria != 'all') ? " and  p.subcategoria_id = $subcategoria " : ' and 1';
        $filtro_marca = ($marca != 'all') ? " and p.marca_id = $marca " : ' and 1';
        $filtro_talla = ($talla != 'all') ? " and p.talla_id = $talla " : ' and 1';
        $filtro_genero = ($genero != 'all') ? " and p.genero_id = $genero " : ' and 1';
        $filtro_color = ($color != 'all') ? " and p.color_id = $color " : ' and 1';
        $filtro_search = ($search != 'all') ? "(p.codigo like '%$search%' or p.nombre like '%$search%' or p.codigo_barras = '$search')" : ' 1 ';

        $registros = DB::table('productos as p')
                                ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                ->join('categorias as c', 'c.id', 's.categoria_id')
                                ->join('marcas as m', 'm.id', 'p.marca_id')
                                ->join('tallas as t', 't.id', 'p.talla_id')
                                ->join('colores as co', 'co.id', 'p.color_id')
                                ->join('generos as g', 'g.id', 'p.genero_id')
                                ->join('monedas as mn', 'mn.id', 'p.moneda_id')
                                ->select(   'p.*',
                                            'c.nombre as categoria',
                                            's.nombre as subcategoria',
                                            'm.nombre as marca',
                                            't.nombre as talla',
                                            'co.nombre as color',
                                            'g.nombre as genero',
                                            'mn.abreviacion as moneda'
                                        )
                                ->whereRaw($filtro_categoria.$filtro_subcategoria.$filtro_marca.$filtro_talla.$filtro_genero.$filtro_color)
                                ->whereRaw($filtro_search)
                                ->where('p.deleted_at', NULL)
                                ->orderBy('p.'.$order, $typeOrder)
                                ->paginate($cantpaginada);

        return view('inventarios/productos/productos_list', compact('registros'));
    }

    public function view_simple($id){
        $producto = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->join('usos as u', 'u.id', 'p.uso_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('monedas as mn', 'mn.id', 'p.moneda_id')
                            ->join('categorias as ca', 'ca.id', 's.categoria_id')
                            ->select('p.*', 'ca.nombre as categoria', 's.nombre as subcategoria', 'm.nombre as marca', 'mn.abreviacion as moneda', 'm.nombre as marca', 'u.nombre as uso', 'c.nombre as color', 'g.nombre as genero', 't.nombre as talla')
                            ->where('p.id', $id)
                            ->first();

        return view('inventarios/productos/productos_view_simple', compact('producto'));
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
                            ->select('p.*', 'ca.nombre as categoria', 's.nombre as subcategoria', 'm.nombre as marca', 'mn.abreviacion as moneda', 't.nombre as talla', 'u.nombre as uso', 'c.nombre as color', 'g.nombre as genero')
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
        $productos_extras = DB::table('productos_extras as pe')
                                    ->join('extras as e', 'e.id', 'pe.extra_id')
                                    ->select('e.nombre', 'e.precio')
                                    ->where('pe.producto_id', $id)
                                    ->where('pe.deleted_at', NULL)
                                    ->get();

        switch (setting('admin.modo_sistema')) {
            case 'repuestos':
                return view('inventarios/productos/repuestos/productos_view', compact('producto', 'imagenes', 'id', 'precios_venta', 'precios_compra'));
                break;
            case 'electronica_computacion':
                return view('inventarios/productos/electronica_computacion/productos_view', compact('producto', 'imagenes', 'id', 'precios_venta', 'precios_compra'));
                break;
            case 'restaurante':
                return view('inventarios/productos/restaurante/productos_view', compact('producto', 'imagenes', 'id', 'precios_venta', 'precios_compra', 'insumos_productos', 'productos_extras'));
                break;
            case 'boutique':
                return view('inventarios/productos/boutique/productos_view', compact('producto', 'imagenes', 'id', 'precios_venta', 'precios_compra', 'insumos_productos'));
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
            $subcategorias = Subcategoria::where('deleted_at', NULL)->where('id', '>', 1)->where('categoria_id', $categorias[0]->id)->get();
        }

        $marcas = Marca::where('deleted_at', NULL)->where('id', '>', 1)->get();
        $tallas = Talla::where('deleted_at', NULL)->where('id', '>', 1)->get();
        $colores = Colore::where('deleted_at', NULL)->where('id', '>', 1)->get();
        $generos = Genero::where('deleted_at', NULL)->where('id', '>', 1)->get();
        $usos = Uso::where('deleted_at', NULL)->where('id', '>', 1)->get();
        $unidades = Unidade::where('deleted_at', NULL)->where('id', '>', 1)->get();
        $monedas = Moneda::where('deleted_at', NULL)->where('id', '>', 1)->get();
        $extras = Extra::where('deleted_at', NULL)->where('estado', 1)->get();

        $insumos = DB::table('insumos as i')
                            ->join('unidades as u', 'u.id', 'i.unidad_id')
                            ->select('i.*', 'u.abreviacion as unidad')
                            ->where('i.deleted_at', NULL)
                            // ->where('id', '>', 1)
                            ->get();

        // Obtener el primer deposito registrado, en caso de ser mas de uno se debe especificar
        // de alguna forma que deposito se debe obtener
        $depositos = DB::table('depositos')
                            ->select('id', 'inventario')
                            ->where('deleted_at', NULL)
                            ->where('inventario', 1)
                            ->first();

        switch (setting('admin.modo_sistema')) {
            case 'repuestos':
            return view('inventarios/productos/repuestos/productos_create', compact('codigo_grupo', 'categorias', 'subcategorias', 'marcas', 'tallas', 'colores', 'generos', 'usos', 'unidades', 'monedas', 'depositos'));
                break;
            case 'electronica_computacion':
                return view('inventarios/productos/electronica_computacion/productos_create', compact('codigo_grupo', 'categorias', 'subcategorias', 'marcas', 'monedas', 'depositos'));
                break;
            case 'restaurante':
                return view('inventarios/productos/restaurante/productos_create', compact('codigo_grupo', 'categorias', 'subcategorias', 'insumos', 'depositos', 'extras'));
                break;
            case 'boutique':
                return view('inventarios/productos/boutique/productos_create', compact('codigo_grupo', 'categorias', 'subcategorias', 'insumos', 'depositos', 'marcas', 'tallas', 'colores', 'generos', 'usos', 'unidades', 'depositos'));
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
            $response = 1;
        }else{
            $response = 0;
        }

        $reload = 0;
        $nuevo_grupo = 0;
        if(isset($data->clear)){
            $reload = $data->clear;
            $nuevo_grupo = $this->ultimo_producto()+1;
        }

        return response()->json(['success' => $response, 'nuevo_grupo' => $nuevo_grupo, 'reload' => $reload]);

        // if($query){
        //     if(isset($data->permanecer)){
        //         return redirect()->route('productos_create')->with(['message' => 'Producto guardado exitosamenete.', 'alert-type' => 'success']);
        //     }else{
        //         return redirect()->route('productos_index')->with(['message' => 'Producto guardado exitosamenete.', 'alert-type' => 'success']);
        //     }
        // }else{
        //     return redirect()->route('productos_index')->with(['message' => 'Ocurrio un problema al guardar el producto.', 'alert-type' => 'error']);
        // }
    }

    public function copy(Request $request){
        $id = $request->id;
        $p = DB::table('productos')->where('id', $id)->first();
        $producto = Producto::create([
                        'nombre' => $p->nombre,
                        'descripcion_small' => $p->descripcion_small,
                        'descripcion_long' => $p->descripcion_long,
                        'precio_venta' => $p->precio_venta,
                        'precio_minimo' => $p->precio_minimo,
                        'ultimo_precio_compra' => $p->ultimo_precio_compra,
                        'codigo' => $p->codigo,
                        'codigo_grupo' => $p->codigo_grupo,
                        'codigo_barras' => $p->codigo_barras,
                        'estante' => $p->estante,
                        'bloque' => $p->bloque,
                        'stock' => $request->stock ?? 0,
                        'stock_minimo' => $p->stock_minimo,
                        'codigo_interno' => $p->codigo_interno,
                        'subcategoria_id' => $p->subcategoria_id,
                        'marca_id' => $p->marca_id,
                        'talla_id' => $p->talla_id,
                        'color_id' => $p->color_id,
                        'genero_id' => $p->genero_id,
                        'unidad_id' => $p->unidad_id,
                        'uso_id' => $p->uso_id,
                        'modelo' => $p->modelo,
                        'moneda_id' => $p->moneda_id,
                        'garantia' => $p->garantia,
                        'catalogo' => $p->catalogo,
                        'nuevo' => $p->nuevo,
                        'imagen' => $p->imagen,
                        'vistas' => $p->vistas
                        ]);

        // Actualizar los codigos del nuevo producto
        Producto::where('id', $producto->id)
                    ->update([
                        'codigo' => setting('admin.prefijo_codigo').'-'.str_pad($producto->id, 5, "0", STR_PAD_LEFT),
                        'codigo_barras' => date('Ymd').str_pad($producto->id, 5, "0", STR_PAD_LEFT),
                    ]);
        // Obtener los detalles de los precios por unidades del producto que se ha duplicado
        $p_u = DB::table('producto_unidades')->where('producto_id', $id)->where('deleted_at', NULL)->get();

        // Recorrer los precios ingresados y crear nuevos registros con el ID del nuevo producto
        foreach ($p_u as $item) {
            ProductoUnidade::create([
                'precio' => $item->precio,
                'precio_minimo' => $item->precio_minimo,
                'cantidad_minima' => $item->cantidad_minima,
                'unidad_id' => $item->unidad_id,
                'producto_id' => $producto->id,
                'cantidad_unidad' => $item->cantidad_unidad
            ]);
        }

        return redirect()->route('productos_index')->with(['message' => 'Copia del producto guardada exitosamenete.', 'alert-type' => 'success']);
    }

    public function edit($id){
        $categorias = DB::table('categorias')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            // ->where('id', '>', 1)
                            ->get();
        $subcategorias = DB::table('subcategorias')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            // ->where('id', '>', 1)
                            ->get();

        $marcas = Marca::where('deleted_at', NULL)->get();
        $tallas = Talla::where('deleted_at', NULL)->get();
        $colores = Colore::where('deleted_at', NULL)->get();
        $generos = Genero::where('deleted_at', NULL)->get();
        $usos = Uso::where('deleted_at', NULL)->get();
        $unidades = Unidade::where('deleted_at', NULL)->get();
        $monedas = Moneda::where('deleted_at', NULL)->get();
        $extras = Extra::where('deleted_at', NULL)->where('estado', 1)->get();

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
        $productos_extras = ProductosExtra::where('producto_id', $id)
                                ->where('deleted_at', NULL)
                                ->get();

        switch (setting('admin.modo_sistema')) {
            case 'repuestos':
            return view('inventarios/productos/repuestos/productos_edit', compact('producto', 'imagen', 'precio_venta', 'precio_compra', 'categorias', 'subcategorias', 'marcas', 'unidades'));
                break;
            case 'electronica_computacion':
                return view('inventarios/productos/electronica_computacion/productos_edit', compact('producto', 'imagen', 'precio_venta', 'precio_compra', 'categorias', 'subcategorias', 'marcas', 'monedas'));
                break;
            case 'restaurante':
                return view('inventarios/productos/restaurante/productos_edit', compact('producto', 'imagen', 'categorias', 'subcategorias', 'precio_venta', 'insumos', 'insumos_productos', 'extras', 'productos_extras'));
                break;
            case 'boutique':
                return view('inventarios/productos/boutique/productos_edit', compact('producto', 'imagen', 'precio_venta', 'precio_compra', 'categorias', 'subcategorias', 'marcas', 'tallas', 'colores', 'generos', 'usos', 'unidades'));
                break;
            default:
                # code...
                break;
        }

    }

    public function update_stock(Request $data){
        // dd($data);
        $stock_actual = DB::table('productos_depositos')
                            ->select('stock')
                            ->where('deposito_id', $data->deposito_id)
                            ->where('producto_id', $data->id)
                            ->first()->stock;

        DB::beginTransaction();

        try {

            // Actualizar el stock total del producto
            if($stock_actual > $data->stock){
                DB::table('productos')->where('id', $data->id)->decrement('stock', $stock_actual - $data->stock);
            }else{
                DB::table('productos')->where('id', $data->id)->increment('stock', $data->stock - $stock_actual);
            }

            // Actualizar stock del producto en el deposito seleccionado
            DB::table('productos_depositos')
                ->where('deposito_id', $data->deposito_id)
                ->where('producto_id', $data->id)
                ->update(['stock' => $data->stock]);

            DB::commit();
            return redirect()->route('productos_index')->with(['message' => 'Stock  de producto editado exitosamenete.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('productos_index')->with(['message' => 'Ocurrio un problema al editar el stock producto.', 'alert-type' => 'error']);
        }
    }

    public function update(Request $data){
        // dd($data);
        $data->validate([
            'nombre' => 'required|max:191',
            'precio_venta' => 'required|max:10',
            'descripcion_small' => 'required'
        ]);

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

        // si la marca no existe crearla
        if(!is_numeric($data->marca_id)){
            $marca = new Marca;
            $marca->nombre = $data->marca_id;
            $marca->save();
            $data->marca_id = Marca::all()->last()->id;
        }

        // Obtener valos si es un producto nuevo
        $nuevo = (isset($data->nuevo)) ? 1: NULL;

        $precio_venta = isset($data->precio_venta[0]) ? $data->precio_venta[0] : 0;
        $precio_minimo = isset($data->precio_minimo[0]) ? $data->precio_minimo[0] : 0;

        // DB::beginTransaction();

        // try {

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
                            'precio_venta' => $precio_venta,
                            'precio_minimo' => $precio_minimo,
                            'stock_minimo' => $data->stock_minimo,
                            'subcategoria_id' => $data->subcategoria_id,
                            'marca_id' => $data->marca_id,
                            'talla_id' => $data->talla_id,
                            'color_id' => $data->color_id,
                            'genero_id' => $data->genero_id,
                            'unidad_id' => $data->unidad_id[0],
                            'uso_id' => $data->uso_id,
                            'moneda_id' => $data->moneda_id,
                            'modelo' => $data->modelo,
                            'nuevo' => $nuevo,
                            'updated_at' => Carbon::now()
                        ]);

            // Guardar precios de venta (si existen)
            if(isset($data->precio_venta)){
                DB::table('producto_unidades')
                        ->where('producto_id', $data->id)->update(['deleted_at' => Carbon::now()]);
                for ($i=0; $i < count($data->precio_venta); $i++) {
                    $query = DB::table('producto_unidades')
                                    ->insert([
                                        'unidad_id' => $data->unidad_id[$i],
                                        'producto_id' => $data->id,
                                        'precio' => $data->precio_venta[$i],
                                        'precio_minimo' => $data->precio_minimo[$i],
                                        'cantidad_minima' => $data->cantidad_minima_venta[$i],
                                        'cantidad_unidad' => 1,
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
                    ProductosInsumo::create([
                        'producto_id' => $data->id,
                        'insumo_id' => $data->insumo_id[$i],
                        'cantidad' => $data->cantidad_insumo[$i],
                    ]);
                }
            }

            // Guardar insumos (si existen)
            if(isset($data->extra_id)){
                DB::table('productos_extras')
                        ->where('producto_id', $data->id)->update(['deleted_at' => Carbon::now()]);
                for ($i=0; $i < count($data->extra_id); $i++) {
                    ProductosExtra::create([
                        'producto_id' => $data->id,
                        'extra_id' => $data->extra_id[$i],
                    ]);
                }
            }

            if($query){
                return redirect()->route('productos_index')->with(['message' => 'Producto editado exitosamenete.', 'alert-type' => 'success']);
            }else{
                return redirect()->route('productos_index')->with(['message' => 'Ocurrio un problema al editar el producto.', 'alert-type' => 'error']);
            }

        //     DB::commit();

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return redirect()->route('productos_index')->with(['message' => 'Ocurrio un problema al editar el producto.', 'alert-type' => 'error']);
        // }

    }

    function ofertas_index(){

    }

    public function imprimir_codigo_barras(Request $request){
        $productos = DB::table('productos')->select('codigo', 'codigo_barras')->whereIn('id', $request->input_print)->get();
        $cantidad = $request->cantidad ?? 1;
        return view('inventarios.productos.partials.print_bar_code', compact('productos', 'cantidad'));
    }

    public function delete(Request $data){
        $producto_depositos = DB::table('productos_depositos')
                                    ->select('id')
                                    ->where('producto_id', $data->id)->where('deleted_at', NULL)
                                    ->first();
        if($producto_depositos){
            return redirect()->route('productos_index')->with(['message' => 'No se puede eliminar el producto debido a que se encuentra en almacen.', 'alert-type' => 'error']);
        }

        try {
            DB::table('productos')
                    ->where('id', $data->id)
                    ->update(['deleted_at' => Carbon::now()]);
            DB::commit();
            return redirect()->route('productos_index')->with(['message' => 'Producto eliminado correctamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('productos_index')->with(['message' => 'Ocurrió un problema al eliminar el producto.', 'alert-type' => 'error']);
        }
    }

    public function lista_imagenes($producto_id){
        $imagenes = DB::table('producto_imagenes')
                            ->select('id', 'imagen', 'tipo')
                            ->where('producto_id', $producto_id)
                            ->where('deleted_at', NULL)
                            ->get();
        return view('inventarios.productos.partials.producto_images', compact('imagenes', 'producto_id'));
    }

    public function add_imagen($id, Request $request){
        if($request->hasFile('file')) {
            try{
                $imagen = $this->agregar_imagenes($request->file('file'));
                if($imagen){
                    ProductoImagene::create([
                        'producto_id' => $id,
                        'imagen' => $imagen,
                        'tipo' => 'secundaria'
                    ]);
                }
                return response()->json(['data'=>'success']);
            }catch (\Throwable $th) {
                return response()->json(['data'=>$th]);
            }
        }else{
            return response()->json(['error'=>"Archivo no válido"]);
        }
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
        DB::beginTransaction();

        try {
            $slug = Producto::find($data->id)->slug;
            DB::table('productos_puntuaciones')
                ->insert([
                    'producto_id' => $data->id,
                    'user_id' => Auth::user()->id,
                    'puntos' => ($data->puntos/20),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            DB::commit();
            if($data->ajax){
                $puntuacion = $this->obtener_puntos($data->id);
                return ceil($puntuacion*20);
            }
            $alerta = 'producto_puntuado';
            return redirect()->route('detalle_producto_ecommerce', ['producto'=>$slug])->with(compact('alerta'));
        } catch (\Exception $e) {
            DB::rollback();
            if($data->ajax){
                return 0;
            }
            return redirect()->route('detalle_producto_ecommerce', ['producto'=>$slug])->with(compact('alerta'));        }
    }

    // *************funciones adicionales*************

    public function crear_parametros($tipo, $valor){
        $valor = str_replace('---', '/', $valor);
        switch ($tipo) {
            case 'categoria_id':
                return Categoria::create(['nombre'=>$valor]);
            case 'marca_id':
                return Marca::create(['nombre'=>$valor]);
            case 'talla_id':
                return Talla::create(['nombre'=>$valor]);
            case 'color_id':
                return Colore::create(['nombre'=>$valor]);
            case 'uso_id':
                return Uso::create(['nombre'=>$valor]);
            case 'genero_id':
                return Genero::create(['nombre'=>$valor]);
            case 'unidad_id':
                return Unidade::create(['nombre'=>$valor]);

            default:
                return response()->json(['error'=>'Error desconocido']);
        }
        return response()->json(['tipo'=>$tipo,'valor'=>$valor]);
    }

    // Se debe crear una función aparte debido a que la sub categoría tiene llave foranea de categoría
    public function crear_subcategoria($categoria_id, $valor){
        return Subcategoria::create(['categoria_id' => $categoria_id,'nombre'=>$valor]);
    }

    public function crear_producto($data){

        // Set datos no requeridos
        $nuevo = (isset($data->nuevo)) ? 1: NULL;
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
        $producto->stock = $data->stock ?? 0;
        $producto->stock_minimo = $data->stock_minimo ?? 0;
        $producto->garantia = $data->garantia;
        $producto->subcategoria_id = $data->subcategoria_id;
        $producto->marca_id = $data->marca_id;
        $producto->talla_id = $data->talla_id;
        $producto->color_id = $data->color_id;
        $producto->genero_id = $data->genero_id;
        $producto->moneda_id = $data->moneda_id;
        $producto->unidad_id = $data->unidad_id[0];
        $producto->modelo = $data->modelo;
        $producto->uso_id = $data->uso_id;
        $producto->codigo_grupo = $data->codigo_grupo;
        $producto->nuevo = $nuevo;
        $producto->se_almacena = $se_almacena;
        $producto->precio_venta = $precio_venta;
        $producto->precio_minimo = $precio_minimo;
        $producto->save();

        // Obtener el ultmimo ingresado
        $producto_id = $producto->id;
        // $producto_id = $this->ultimo_producto();

        $catalogo = '';
        if ($data->hasFile('catalogo')) {
            $file = $data->file('catalogo');
            $filename = str_random(20).'.'.$file->getClientOriginalExtension();
            $path = 'catalogos/'.date('F').date('Y').'/'.$filename;
            \Storage::disk('local')->put('public/'.$path,  \File::get($file));
            $catalogo = $path;
        }

        // guardar precio de de venta del prodcuto
        if(isset($data->precio_venta)){
            for ($i=0; $i < count($data->precio_venta); $i++) {
                DB::table('producto_unidades')
                        ->insert([
                            'unidad_id' => $data->unidad_id[$i],
                            'producto_id' => $producto_id,
                            'precio' => $data->precio_venta[$i],
                            'precio_minimo' => $data->precio_minimo[$i],
                            'cantidad_minima' => 1,
                            'cantidad_unidad' => $data->cantidad_unidad[$i],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
            }
        }

        // Guardar precios de compra (si existen)
        if(isset($data->monto)){
            DB::table('precios_compras')
                    ->insert([
                        'producto_id' => $producto_id,
                        'monto' => $data->monto,
                        'cantidad_minima' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
        }

        // Guardar insumos si existen
        if(isset($data->insumo_id)){
            for ($i=0; $i < count($data->insumo_id); $i++) {
                ProductosInsumo::create([
                            'producto_id' => $producto_id,
                            'insumo_id' => $data->insumo_id[$i],
                            'cantidad' => $data->cantidad_insumo[$i],
                        ]);
            }
        }

        // Guardar extras si existen
        if(isset($data->extra_id)){
            for ($i=0; $i < count($data->extra_id); $i++) {
                ProductosExtra::create([
                    'producto_id' => $producto_id,
                    'extra_id' => $data->extra_id[$i],
                ]);
            }
        }

        $imagen_portada = '';
        try {
            // agregar imagenes
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
        } catch (\Throwable $th) {
            //throw $th;
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

        if($producto){
            return $producto_id;
        }else{
            return 0;
        }
    }

    public function agregar_imagenes($file){
        Storage::makeDirectory('/public/productos/'.date('F').date('Y'));
        $base_name = str_random(20);

        // imagen normal
        $filename = $base_name.'.'.$file->getClientOriginalExtension();
        $image_resize = Image::make($file->getRealPath())->orientate();
        $image_resize->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $path =  'productos/'.date('F').date('Y').'/'.$filename;
        $image_resize->save(public_path('../storage/app/public/'.$path));
        $imagen = $path;

        // imagen mediana
        $filename_medium = $base_name.'_medium.'.$file->getClientOriginalExtension();
        $image_resize = Image::make($file->getRealPath())->orientate();
        $image_resize->resize(650, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $path_medium = 'productos/'.date('F').date('Y').'/'.$filename_medium;
        $image_resize->save(public_path('../storage/app/public/'.$path_medium));

        // imagen pequeña
        $filename_small = $base_name.'_small.'.$file->getClientOriginalExtension();
        $image_resize = Image::make($file->getRealPath())->orientate();
        $image_resize->resize(260, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $path_small = 'productos/'.date('F').date('Y').'/'.$filename_small;
        $image_resize->save(public_path('../storage/app/public/'.$path_small));

        return $imagen;
    }

    public function get_producto($id){
        $sucursal_id = (new Ventas)->get_user_sucursal();
        // Verificar que el producto se almacena en stock
        $producto = DB::table('productos as p')
                            ->join('monedas as m', 'm.id', 'p.moneda_id')
                            ->join('producto_unidades as pu', 'pu.producto_id', 'p.id')
                            ->join('productos_depositos as pd', 'pd.producto_id', 'p.id')
                            ->join('depositos as d', 'd.id', 'pd.deposito_id')
                            ->select(DB::raw('p.id, p.nombre, pu.precio, p.precio_minimo, pu.precio as precio_antiguo, p.imagen, p.se_almacena, (pd.stock + pd.stock_compra) as stock, p.descripcion_small as descripcion, m.abreviacion as moneda,
                                            (select AVG(puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos, p.deleted_at as unidades'))
                            ->where('p.id', $id)
                            ->where('p.se_almacena', 1)
                            ->where('d.sucursal_id', $sucursal_id)
                            ->where('p.stock', '>', 0)
                            ->where('pu.deleted_at', NULL)
                            ->first();

        // Si no se almacena mostrar la infomación
        $producto = $producto ?? DB::table('productos as p')
                                        ->join('monedas as m', 'm.id', 'p.moneda_id')
                                        ->join('producto_unidades as pu', 'pu.producto_id', 'p.id')
                                        ->select(DB::raw('p.id, p.nombre, pu.precio, p.precio_minimo, pu.precio as precio_antiguo, p.imagen, p.se_almacena, p.stock, p.descripcion_small as descripcion, m.abreviacion as moneda,
                                                        (select AVG(puntos) from productos_puntuaciones as pp where pp.producto_id = p.id) as puntos, p.deleted_at as unidades'))
                                        ->where('p.id', $id)
                                        ->where('pu.deleted_at', NULL)
                                        ->first();

        if($producto){
            // Obtener si el producto está en oferta
            $oferta = (new Ofertas)->obtener_oferta($producto->id);
            $precio_venta = $producto->precio;
            if($oferta){
                if($oferta->tipo_descuento=='porcentaje'){
                    $precio_venta -= ($precio_venta*($oferta->monto/100));
                }else{
                    $precio_venta -= $oferta->monto;
                }
                $producto->precio = $precio_venta;
            }

            // Obtener unidades del producto
            $producto_aux = ProductoUnidade::with('unidad')
                                ->where('producto_id', $id)
                                ->where('deleted_at', NULL)
                                ->get();
            if($producto_aux){
                $producto->unidades = $producto_aux;
            }

            return response()->json($producto);
        }else{
            return null;
        }
    }

    public function get_price_producto_units ($id, $unit_id = null){
      $producto =   $unit_id ?
                    ProductoUnidade::with('unidad')
                                    ->where('producto_id', $id)
                                   ->where('unidad_id', $unit_id)
                                   ->where('deleted_at', NULL)
                                   ->first() :
                    ProductoUnidade::with('unidad')
                                    ->where('producto_id', $id)
                                    ->where('deleted_at', NULL)
                                   ->get();
      return response()->json($producto);
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

    // Filtros
    public function filtro_simple($filtro, $categoria, $subcategoria, $marca, $talla, $genero, $color){

        // dd($filtro);
        $filtro_categoria = ($categoria != 'all') ? " s.categoria_id = $categoria " : ' 1 ';
        $filtro_subcategoria = ($subcategoria != 'all') ? " and  p.subcategoria_id = $subcategoria " : ' and 1';
        $filtro_marca = ($marca != 'all') ? " and p.marca_id = $marca " : ' and 1';
        $filtro_talla = ($talla != 'all') ? " and p.talla_id = $talla " : ' and 1';
        $filtro_genero = ($genero != 'all') ? " and p.genero_id = $genero " : ' and 1';
        $filtro_color = ($color != 'all') ? " and p.color_id = $color " : ' and 1';

        if($filtro == 'all'){
            return DB::table('productos as p')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('monedas as mo', 'mo.id', 'p.moneda_id')
                            ->select('p.id','p.codigo_interno', 'p.codigo', 'p.nombre', 'p.imagen', 'p.precio_venta','p.descripcion_small', 'm.nombre as marca', 't.nombre as talla', 'g.nombre as genero', 's.nombre as subcategoria', 'c.nombre as color', 'mo.abreviacion as moneda')
                            ->whereRaw($filtro_categoria.$filtro_subcategoria.$filtro_marca.$filtro_talla.$filtro_genero.$filtro_color)
                            ->where('p.deleted_at', NULL)
                            ->get();
        }else{
            return DB::table('productos as p')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('tallas as t', 't.id', 'p.talla_id')
                            ->join('colores as c', 'c.id', 'p.color_id')
                            ->join('generos as g', 'g.id', 'p.genero_id')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('monedas as mo', 'mo.id', 'p.moneda_id')
                            ->select('p.id', 'p.codigo_interno', 'p.codigo', 'p.nombre', 'p.imagen', 'p.precio_venta','p.descripcion_small', 'm.nombre as marca', 't.nombre as talla', 'g.nombre as genero', 's.nombre as subcategoria', 'c.nombre as color', 'mo.abreviacion as moneda')
                            ->whereRaw($filtro_categoria.$filtro_subcategoria.$filtro_marca.$filtro_talla.$filtro_genero.$filtro_color)
                            ->where('p.deleted_at', NULL)
                            ->whereNotIn('p.id', function($q) use($filtro){
                                $q->select('producto_id')->from($filtro)->where('deleted_at', null);
                            })
                            ->get();
        }
    }

    // Obtener las subcategorias de una categoría
    public function subcategorias_categoria($categoria_id){
        return DB::table('subcategorias as s')
                        ->select('s.*')
                        ->where('s.deleted_at', NULL)
                        ->where('s.categoria_id', $categoria_id)
                        ->distinct()
                        ->get();
    }

    public function subcategorias_list($categoria_id){
        return DB::table('subcategorias as s')
                        ->join('productos as p', 'p.subcategoria_id', 's.id')
                        ->select('s.*')
                        ->where('s.deleted_at', NULL)
                        ->where('s.categoria_id', $categoria_id)
                        ->distinct()
                        ->get();
    }

    public function marcas_list($subcategoria_id){
        return DB::table('marcas as m')
                        ->join('productos as p', 'p.marca_id', 'm.id')
                        ->select('m.*')
                        ->where('m.deleted_at', NULL)
                        ->where('p.subcategoria_id', $subcategoria_id)
                        ->distinct()
                        ->get();
    }

    public function tallas_list($subcategoria_id, $marca_id){
        return DB::table('tallas as t')
                        ->join('productos as p', 'p.talla_id', 't.id')
                        ->select('t.*')
                        ->where('t.deleted_at', NULL)
                        ->where('p.subcategoria_id', $subcategoria_id)
                        ->where('p.marca_id', $marca_id)
                        ->distinct()
                        ->get();
    }

    public function generos_list($subcategoria_id, $marca_id, $talla_id){
        return DB::table('generos as g')
                        ->join('productos as p', 'p.genero_id', 'g.id')
                        ->select('g.*')
                        ->where('g.deleted_at', NULL)
                        ->where('p.subcategoria_id', $subcategoria_id)
                        ->where('p.marca_id', $marca_id)
                        ->where('p.talla_id', $talla_id)
                        ->distinct()
                        ->get();
    }

    public function colores_list($subcategoria_id, $marca_id, $talla_id, $genero_id){
        return DB::table('colores as c')
                        ->join('productos as p', 'p.color_id', 'c.id')
                        ->select('c.*')
                        ->where('c.deleted_at', NULL)
                        ->where('p.subcategoria_id', $subcategoria_id)
                        ->where('p.marca_id', $marca_id)
                        ->where('p.talla_id', $talla_id)
                        ->distinct()
                        ->get();
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

    public function ultimo_codigo_interno($id){
        $result = DB::table('productos as p')
                    ->select('p.codigo_interno')
                    ->where('p.subcategoria_id', $id)
                    ->orderBy('p.codigo_interno', 'DESC')
                    ->first();
        return response()->json($result);
    }

    public function generar_catalogo($inicio, $cantidad){
        // return Excel::download(new CatalogoProductosExport, 'Catálogo de productos '.date('YmdHis').'.xlsx');
        $productos = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'subcategoria_id')
                            ->select('p.id', 'p.codigo', 'p.nombre', 's.nombre as categoria', 'p.precio_venta as precio', DB::raw("CONCAT(p.estante,' ',p.bloque) as ubicacion"))
                            ->where('p.deleted_at', NULL)
                            ->orderBy('p.nombre')
                            ->skip($inicio)->take($cantidad)->get();
        $vista = view('inventarios.productos.productos_catalogo_pdf', compact('productos'));
        // return $vista;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista)->setPaper('letter', 'landscape');
        $pdf->loadHTML($vista);
        return $pdf->stream();
    }

    public function lista_extras_productos($id, $sucursal_id = 0){
        if($sucursal_id == 0){
            return DB::table('extras as e')
                    ->join('productos_extras as pe', 'pe.extra_id', 'e.id')
                    ->select('e.id', 'e.nombre', 'e.precio', 'e.imagen', 'e.estado')
                    ->where('pe.producto_id', $id)->where('e.deleted_at', NULL)
                    ->where('pe.deleted_at', NULL)->get();
        }else{
            return DB::table('extras as e')
                    ->join('productos_extras as pe', 'pe.extra_id', 'e.id')
                    ->join('extras_depositos as ed', 'ed.extra_id', 'e.id')
                    ->join('depositos as d', 'd.id', 'ed.deposito_id')
                    ->select('e.id', 'e.nombre', 'e.precio', 'e.imagen', 'e.estado', 'ed.stock')
                    ->where('pe.producto_id', $id)->where('d.sucursal_id', $sucursal_id)
                    ->where('ed.stock', '>', 0)->where('e.deleted_at', NULL)->where('pe.deleted_at', NULL)->get();
        }

    }
}
