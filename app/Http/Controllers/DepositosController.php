<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Deposito;
use App\ProductosDeposito;

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
                            ->select('id', 'nombre', 'direccion', 'inventario', 'sucursal_id', 'deleted_at as sucursal')
                            ->where('deleted_at', NULL)
                            ->paginate(10);
        $cont = 0;
        foreach ($registros as $item) {
            $sucursal = DB::table('sucursales')
                            ->select('nombre')
                            ->where('deleted_at', NULL)
                            ->where('id', $item->sucursal_id)->first();

            $registros[$cont]->sucursal = $sucursal ? $sucursal->nombre : 'Ninguna';
            $cont++;
        }
        $value = '';
        return view('inventarios/depositos/depositos_index', compact('registros', 'value'));
    }

    public function search($value)
    {
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('depositos as d')
                            ->select('id', 'nombre', 'direccion', 'inventario', 'sucursal_id', 'deleted_at as sucursal')
                            ->whereRaw("d.deleted_at is null and
                                        (
                                            d.nombre like '%".$value."%' or
                                            d.direccion like '%".$value."%'
                                        )")
                            ->paginate(10);

        $cont = 0;
        foreach ($registros as $item) {
            $sucursal = DB::table('sucursales')
                            ->select('nombre')
                            ->where('deleted_at', NULL)
                            ->where('id', $item->sucursal_id)->first();

            $registros[$cont]->sucursal = $sucursal ? $sucursal->nombre : 'Ninguna';
            $cont++;
        }

        return view('inventarios/depositos/depositos_index', compact('registros', 'value'));
    }

    public function view($id){
        $deposito = Deposito::find($id);
        $registros = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('productos_depositos as d', 'd.producto_id', 'p.id')
                            ->select('p.*', 's.nombre as subcategoria', 'd.stock as cantidad')
                            ->where('p.deleted_at', NULL)
                            ->where('d.deposito_id', $id)
                            // ->where('d.stock', '>', 0)
                            ->where('d.deleted_at', NULL)
                            ->orderBy('p.id', 'DESC')
                            ->paginate(20);

        $productos = DB::table('productos as p')
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
                            ->whereNotIn('p.id', function($q)use($id){
                                $q->select('producto_id')->from('productos_depositos as pd')
                                ->where('deposito_id', $id)->where('deleted_at', null);
                            })
                            // ->where('p.se_almacena', NULL)
                            ->where('p.deleted_at', NULL)->get();
        
        $stock = DB::table('productos as p')
                            ->join('productos_depositos as d', 'd.producto_id', 'p.id')
                            ->select(DB::raw('d.id as id, p.precio_venta, p.precio_minimo, sum(d.stock_compra + d.stock) as cantidad'))
                            ->groupBy('id', 'precio_venta', 'precio_minimo')
                            ->where('p.deleted_at', NULL)
                            ->get();
        $total_compra = 0;
        $total_venta = 0;
        foreach ($stock as $item) {
            $total_compra += $item->precio_minimo * $item->cantidad;
            $total_venta += $item->precio_venta * $item->cantidad;
        }

        $value = '';
        return view('inventarios/depositos/depositos_view', compact('id', 'deposito', 'registros', 'value', 'productos', 'total_compra', 'total_venta'));
    }

    public function view_search($id, $value){
        $value = ($value != 'all') ? $value : '';
        $deposito = Deposito::find($id);
        $registros = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('productos_depositos as d', 'd.producto_id', 'p.id')
                            ->select('p.*', 's.nombre as subcategoria', 'd.stock as cantidad')
                            ->where('p.deleted_at', NULL)
                            ->where('d.deleted_at', NULL)
                            ->whereRaw("d.deposito_id = $id and d.stock > 0 and
                                            (   p.codigo like '%".$value."%' or
                                                p.nombre like '%".$value."%' or
                                                s.nombre like '%".$value."%')
                                        ")
                            ->paginate(10);

        $productos = DB::table('productos as p')
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
                            ->whereNotIn('p.id', function($q)use($id){
                                $q->select('producto_id')->from('productos_depositos as pd')
                                ->where('deposito_id', $id)->where('deleted_at', null);
                            })
                            // ->where('p.se_almacena', NULL)
                            ->where('p.deleted_at', NULL)->get();

        $stock = DB::table('productos as p')
                            ->join('productos_depositos as d', 'd.producto_id', 'p.id')
                            ->select(DB::raw('d.id as id, p.precio_venta, p.precio_minimo, sum(d.stock_compra + d.stock) as cantidad'))
                            ->groupBy('id', 'precio_venta', 'precio_minimo')
                            ->where('p.deleted_at', NULL)
                            ->get();
        $total_compra = 0;
        $total_venta = 0;
        foreach ($stock as $item) {
            $total_compra += $item->precio_minimo * $item->cantidad;
            $total_venta += $item->precio_venta * $item->cantidad;
        }

        return view('inventarios/depositos/depositos_view', compact('id', 'registros', 'value', 'productos', 'deposito', 'total_compra', 'total_venta'));
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
            case 'repuestos':
                return view('inventarios/depositos/repuestos/depositos_create_producto', compact('codigo_grupo', 'deposito_id', 'categorias', 'subcategorias', 'marcas', 'unidades'));
                break;
            case 'boutique':
                return view('inventarios/depositos/boutique/depositos_create_producto', compact('codigo_grupo', 'deposito_id', 'categorias', 'subcategorias', 'marcas', 'tallas', 'colores', 'generos', 'usos', 'unidades'));
                break;
            case 'electronica_computacion':
                return view('inventarios/depositos/electronica_computacion/depositos_create_producto', compact('codigo_grupo', 'deposito_id', 'subcategorias', 'marcas', 'monedas'));
                break;
            case 'restaurante':
                return view('inventarios/depositos/restaurante/depositos_create_producto', compact('codigo_grupo', 'deposito_id', 'categorias', 'subcategorias', 'insumos'));
                break;
            default:
                # code...
                break;
        }
    }

    public function store_producto(Request $data){
        if(isset($data->producto_id)){
            // Por seguridad anular todos los registros en la tabla productos_depositos del producto y deposito seleccionado
            DB::table('productos_depositos')
                    ->where('deposito_id', $data->deposito_id)->where('producto_id', $data->producto_id)
                    ->update(['deleted_at' => Carbon::now()]);
 
            ProductosDeposito::create([
                'deposito_id' => $data->deposito_id,
                'producto_id' => $data->producto_id,
                'stock' => $data->stock,
                'stock_inicial' => $data->stock,
                'stock_compra' => 0
            ]);

            // Editar datos del producto
            DB::table('productos')
                    ->where('id', $data->producto_id)
                    ->update(['se_almacena' => 1]);
            // Incrementar stock total del producto
            if($data->stock > 0){
                DB::table('productos')->where('id', $data->producto_id)->increment('stock', $data->stock);
            }

            return redirect()->route('depositos_view', ['id' => $data->deposito_id])->with(['message' => 'Producto registrado exitosamenete.', 'alert-type' => 'success']);
        }else{
            $producto = (new Productos)->crear_producto($data);
            if($producto){
                ProductosDeposito::create([
                    'deposito_id' => $data->deposito_id,
                    'producto_id' => $producto,
                    'stock' => $data->stock,
                    'stock_inicial' => $data->stock,
                    'stock_compra' => 0
                ]);
                $response = 1;
            }else{
                $response = 0;
            }

            $reload = 0;
            $nuevo_grupo = 0;
            if(isset($data->clear)){
                $reload = $data->clear;
                $nuevo_grupo = (new Productos)->ultimo_producto()+1;
            }
            
            return response()->json(['success' => $response, 'nuevo_grupo' => $nuevo_grupo, 'reload' => $reload]);
        }
    }

    public function update_producto(Request $request){
        // Obtener datos del producto en almacen
        $producto_deposito = DB::table('productos_depositos')
                                ->where('deposito_id', $request->deposito_id)->where('producto_id', $request->producto_id)->where('deleted_at', NULL)
                                ->first();

        // Si el stock ingresado es mayor al stock actual se hace un simple increment
        if($request->stock > $request->stock_actual){
            DB::table('productos')->where('id', $request->producto_id)->increment('stock', ($request->stock - $request->stock_actual));
            $this->edit_producto_deposito($request->deposito_id, $request->producto_id, 'stock', $request->stock);
        }else{
            DB::table('productos')->where('id', $request->producto_id)->decrement('stock', ($request->stock_actual - $request->stock));
            // Si el stock ingresado es menor al stock (no de compra) del almacen se actualiza
            // Si no se pone el stock en cero y se le decrementa al stock de compra 
            if($request->stock <= $producto_deposito->stock){
                $this->edit_producto_deposito($request->deposito_id, $request->producto_id, 'stock', $request->stock);
            }else{
                $this->edit_producto_deposito($request->deposito_id, $request->producto_id, 'stock', 0);
                $this->edit_producto_deposito($request->deposito_id, $request->producto_id, 'stock_compra', ($producto_deposito->stock - $request->stock));
            }
        }
        return redirect()->route('depositos_view', ['id' => $request->deposito_id])->with(['message' => 'Stock de producto actualizado exitosamenete.', 'alert-type' => 'success']);
    }

    public function delete_producto(Request $request){
        try {
            // Eliminar productos del deposito
            DB::table('productos_depositos')
                    ->where('deposito_id', $request->deposito_id)->where('producto_id', $request->producto_id)
                    ->update(['deleted_at' => Carbon::now()]);

            // Editar stock global del producto
            DB::table('productos')->where('id', $request->producto_id)->decrement('stock', $request->stock_actual);

            // Obtener los depositos en los que existe el producto
            $producto_depositos = DB::table('productos_depositos')
                                        ->select('id')
                                        ->where('deposito_id', $request->deposito_id)->where('producto_id', $request->producto_id)->where('deleted_at', NULL)
                                        ->first();
            // Si el producto no existe en ningún otro deposito se actualiza como NO ALMACENABLE
            if(!$producto_depositos){
                DB::table('productos')->where('id', $request->producto_id)->update(['se_almacena' => 0]);
            }

            DB::commit();
            return redirect()->route('depositos_view', ['id' => $request->deposito_id])->with(['message' => 'Producto de almacen eliminado exitosamenete.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('depositos_view', ['id' => $request->deposito_id])->with(['message' => 'Ocurrió un error al eliminar el producto del almacen.', 'alert-type' => 'error']);
        }
    }

    public function edit_producto_deposito($deposito_id, $producto_id, $campo, $stock){
        // Por seguridad anular todos los registros en la tabla productos_depositos del producto y deposito seleccionado
        DB::table('productos_depositos')
                ->where('deposito_id', $deposito_id)->where('producto_id', $producto_id)
                ->update([$campo => $stock, 'updated_at' => Carbon::now()]);
    }
}
