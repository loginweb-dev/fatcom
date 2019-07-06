<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\LoginwebController as LW;


class EcommerceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $registros = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->select('p.id', 'p.nombre', 's.nombre as subcategoria', 'e.updated_at', 'e.escasez', 'e.precio_envio', 'e.precio_envio_rapido', 'e.tags')
                            ->where('e.deleted_at', NULL)
                            ->paginate(10);
        $imagenes = [];
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
        }
        $value = '';

        return view('inventarios/ecommerce/ecommerce_index', compact('registros', 'imagenes', 'value'));
    }

    public function search($value)
    {

    }

    public function view($id){

    }

    public function create(){

        $categorias = DB::table('categorias')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();
        $marcas = DB::table('marcas')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', '>', 1)
                            ->get();

        $productos = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->select('p.id', 'p.nombre')
                            // ->where('deleted_at', NULL)
                            ->whereNotIn('p.id', function($q){
                                $q->select('producto_id')->from('ecommerce_productos')->where('deleted_at', null);
                            })
                            ->get();
        return view('inventarios/ecommerce/ecommerce_create', compact('productos', 'categorias', 'marcas'));
    }

    public function store(Request $data){
        $data->validate([
            'producto_id' => 'required'
        ]);
        for ($i=0; $i < count($data->producto_id); $i++) {
            $query = DB::table('ecommerce_productos')
                            ->insert([
                                'producto_id' => $data->producto_id[$i],
                                'escasez' => $data->escasez[$i],
                                'precio_envio' => $data->envio[$i],
                                'precio_envio_rapido' => $data->envio_rapido[$i],
                                'tags' => $data->tags[$i],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
        }
        if($query){
            return redirect()->route('ecommerce_index')->with(['message' => 'Productos agregados al E-Commerce exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('ecommerce_index')->with(['message' => 'Ocurrio un problema al agregar los productos al E-Commerce.', 'alert-type' => 'error']);
        }
    }

    public function edit($id){
        $ecommerce = DB::table('ecommerce_productos as e')
                            ->join('productos as p', 'p.id', 'e.producto_id')
                            ->select('e.*', 'p.nombre')
                            ->where('p.id', $id)
                            ->first();
        return view('inventarios/ecommerce/ecommerce_edit', compact('ecommerce'));

    }

    public function update(Request $data){
        $query = DB::table('ecommerce_productos')
                    ->where('id', $data->id)
                    ->update([
                        'escasez' => $data->escasez,
                        'precio_envio' => $data->envio,
                        'precio_envio_rapido' => $data->envio_rapido,
                        'tags' => $data->tags,
                        'updated_at' => Carbon::now()
                    ]);

        if($query){
            return redirect()->route('ecommerce_index')->with(['message' => 'Producto de E-Commerce editado exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('ecommerce_index')->with(['message' => 'Ocurrio un problema al editar el producto del E-Commerce.', 'alert-type' => 'error']);
        }
    }

    public function delete(Request $data){
        $query = DB::table('ecommerce_productos')
                    ->where('id', $data->id)
                    ->update(['deleted_at' => Carbon::now()]);

        if($query){
            return redirect()->route('ecommerce_index')->with(['message' => 'Producto de E-Commerce eliminado exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('ecommerce_index')->with(['message' => 'Ocurrio un problema al eliminar el producto del E-Commerce.', 'alert-type' => 'error']);
        }
    }

    // =========================================
    public function filtro_simple($categoria, $subcategoria, $marca){

        $filtro_categoria = ($categoria != 'all') ? " s.categoria_id = $categoria " : ' 1 ';
        $filtro_subcategoria = ($subcategoria != 'all') ? " and  p.subcategoria_id = $subcategoria " : ' and 1';
        $filtro_marca = ($marca != 'all') ? " and p.marca_id = $marca " : ' and 1';

        return DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('categorias as c', 'c.id', 's.categoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->select('p.id', 'p.nombre')
                            ->whereRaw($filtro_categoria.$filtro_subcategoria.$filtro_marca)
                            // ->where('deleted_at', NULL)
                            ->whereNotIn('p.id', function($q){
                                $q->select('producto_id')->from('ecommerce_productos')->where('deleted_at', null);
                            })
                            ->get();
    }

}
