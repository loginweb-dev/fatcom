<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Http\Controllers\ProductosController as Productos;

class DepositosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $registros = DB::table('depositos')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->paginate(10);
        $sucursales = array();
        foreach ($registros as $item) {
            $sucursal = DB::table('sucursales')
                            ->select('nombre')
                            ->where('deleted_at', NULL)
                            ->where('id', $item->sucursal_id)
                            ->first();
            if($sucursal){
                $nombre_sucursal = $sucursal->nombre;
            }else{
                $nombre_sucursal = 'Ninguna';
            }
            array_push($sucursales, array('nombre' => $nombre_sucursal));
        }
        $value = '';
        return view('inventarios/depositos/depositos_index', compact('registros', 'sucursales', 'value'));
    }

    public function search($value)
    {
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('depositos as d')
                            ->select('*')
                            ->whereRaw("d.deleted_at is null and
                                        (
                                            d.nombre like '%".$value."%' or
                                            d.direccion like '%".$value."%'
                                        )")
                            ->paginate(10);

        $sucursales = array();
        foreach ($registros as $item) {
            $sucursal = DB::table('sucursales')
                            ->select('nombre')
                            ->where('deleted_at', NULL)
                            ->where('id', $item->sucursal_id)
                            ->first();
            if($sucursal){
                $nombre_sucursal = $sucursal->nombre;
            }else{
                $nombre_sucursal = 'Ninguna';
            }
            array_push($sucursales, array('nombre' => $nombre_sucursal));
        }

        return view('inventarios/depositos/depositos_index', compact('registros', 'sucursales', 'value'));
    }

    public function view($id){
        $registros = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('productos_depositos as d', 'd.producto_id', 'p.id')
                            ->select('p.*', 's.nombre as subcategoria', 'd.stock as cantidad')
                            // ->where('deleted_at', NULL)
                            ->where('d.deposito_id', $id)
                            // ->where('d.stock', '>', 0)
                            ->orderBy('p.id', 'DESC')
                            ->paginate(20);
        $imagenes = [];
        $precios = [];
        if(count($registros)>0){
            // Obtener imagenes del producto
            foreach ($registros as $item) {
                $producto_imagen = DB::table('producto_imagenes')
                            ->select('imagen')
                            ->where('producto_id', $item->id)
                            ->where('tipo', 'principal')
                            ->first();
                if($producto_imagen){
                    $imagen = $producto_imagen->imagen;
                }else{
                    $imagen = '';
                }
                array_push($imagenes, ['nombre' => $imagen]);
            }

            // Obtener precios del producto
            foreach ($registros as $item) {
                $producto_unidades = DB::table('producto_unidades as p')
                                        ->join('unidades as u', 'u.id', 'p.unidad_id')
                                        ->select('p.*', 'u.nombre as unidad')
                                        ->where('producto_id', $item->id)
                                        ->first();
                if($producto_unidades){
                    $precio = ['precio' => $producto_unidades->precio, 'unidad' => $producto_unidades->unidad];
                }else{
                    $precio = ['precio' => 0, 'unidad' => 'No definida'];
                }
                array_push($precios, $precio);
            }
        }

        $value = '';
        return view('inventarios/depositos/depositos_view', compact('id', 'registros', 'value', 'imagenes', 'precios'));
    }

    public function view_search($id, $value){
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('productos_depositos as d', 'd.producto_id', 'p.id')
                            ->select('p.*', 's.nombre as subcategoria', 'd.stock as cantidad')
                            // ->where('deleted_at', NULL)
                            ->whereRaw("d.deposito_id = $id and d.stock > 0 and
                                            (   p.codigo like '%".$value."%' or
                                                p.nombre like '%".$value."%' or
                                                s.nombre like '%".$value."%')
                                        ")
                            ->paginate(10);
        $imagenes = [];
        $precios = [];
        if(count($registros)>0){
            // Obtener imagenes del producto
            foreach ($registros as $item) {
                $producto_imagen = DB::table('producto_imagenes')
                            ->select('imagen')
                            ->where('producto_id', $item->id)
                            ->where('tipo', 'principal')
                            ->first();
                if($producto_imagen){
                    $imagen = $producto_imagen->imagen;
                }else{
                    $imagen = '';
                }
                array_push($imagenes, ['nombre' => $imagen]);
            }

            // Obtener precios del producto
            foreach ($registros as $item) {
                $producto_unidades = DB::table('producto_unidades as p')
                                        ->join('unidades as u', 'u.id', 'p.unidad_id')
                                        ->select('p.*', 'u.nombre as unidad')
                                        ->where('producto_id', $item->id)
                                        ->first();
                if($producto_unidades){
                    $precio = ['precio' => $producto_unidades->precio, 'unidad' => $producto_unidades->unidad];
                }else{
                    $precio = ['precio' => 0, 'unidad' => 'No definida'];
                }
                array_push($precios, $precio);
            }
        }

        return view('inventarios/depositos/depositos_view', compact('id', 'registros', 'value', 'imagenes', 'precios'));
    }

    public function create(){
        return view('inventarios/depositos/depositos_create');
    }

    public function store(Request $data){
        $data->validate([
            'nombre' => 'required|unique:depositos|max:50'
        ]);
        $query = DB::table('depositos')
                        ->insert([
                            'nombre' => $data->nombre,
                            'direccion' => $data->direccion,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
        if($query){
            return redirect()->route('depositos_index')->with(['message' => 'Deposito guardado exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('depositos_index')->with(['message' => 'Ocurrio un problema al guardar el deposito.', 'alert-type' => 'error']);
        }
    }

    public function edit($id){
        $registro = DB::table('depositos')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', $id)
                            ->first();
        return view('inventarios/depositos/depositos_edit', compact('registro'));
    }

    public function update(Request $data){
        $inventario = isset($data->inventario) ? 1 : 0;

        $query = DB::table('depositos')
                        ->where('id', $data->id)
                        ->update([
                            'nombre' => $data->nombre,
                            'direccion' => $data->direccion,
                            'inventario' => $inventario,
                            'updated_at' => Carbon::now()
                        ]);
        if($query){
            return redirect()->route('depositos_index')->with(['message' => 'Deposito editado exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('depositos_index')->with(['message' => 'Ocurrio un problema al editar el deposito.', 'alert-type' => 'error']);
        }
    }

    public function delete(Request $data){

    }

    // ============================================================
    public function create_producto($deposito_id){
        $codigo_grupo = (new Productos)->ultimo_producto() + 1;

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
                                    // ->where('id', '>', 1)
                                    ->where('categoria_id', $categorias[0]->id)
                                    ->get();
        }

        $marcas = DB::table('marcas')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            // ->where('id', '>', 1)
                            ->get();
        $tallas = DB::table('tallas')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            // ->where('id', '>', 1)
                            ->get();
        $colores = DB::table('colores')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            // ->where('id', '>', 1)
                            ->get();
        $generos = DB::table('generos')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            // ->where('id', '>', 1)
                            ->get();
        $usos = DB::table('usos')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            // ->where('id', '>', 1)
                            ->get();
        $unidades = DB::table('unidades')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            // ->where('id', '>', 1)
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

        switch (setting('admin.modo_sistema')) {
            case 'boutique':
                return view('inventarios/depositos/boutique/depositos_create_producto', compact('codigo_grupo', 'deposito_id', 'categorias', 'subcategorias', 'insumos', 'marcas', 'tallas', 'colores', 'generos', 'usos', 'unidades'));
                break;
            case 'electronica_computacion':
            return view('inventarios/depositos/electronica_computacion/depositos_create_producto', compact('codigo_grupo', 'deposito_id', 'subcategorias', 'marcas', 'monedas'));
                break;
            default:
                # code...
                break;
        }
    }

    public function store_producto(Request $data){
        $producto = (new Productos)->crear_producto($data);
        if($producto){
            DB::table('productos_depositos')
                    ->insert([
                        'producto_id' => $producto,
                        'deposito_id' => $data->deposito_id,
                        'stock' => $data->stock,
                        'stock_inicial' => $data->stock,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            $response = 1;
        }else{
            $response = 0;
        }

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

        $reload = 0;
        $nuevo_grupo = 0;
        if(isset($data->clear)){
            $reload = $data->clear;
            $nuevo_grupo = (new Productos)->ultimo_producto()+1;
        }
        

        switch (setting('admin.modo_sistema')) {
            case 'boutique':
                return response()->json(['success' => $response, 'nuevo_grupo' => $nuevo_grupo, 'reload' => $reload]);
                break;
            case 'electronica_computacion':
                return response()->json(['success' => $response, 'nuevo_grupo' => $nuevo_grupo, 'subcategorias' => $subcategorias, 'marcas' =>$marcas, 'reload' => $reload]);
                break;
            default:
                # code...
                break;
        }
    }
}
