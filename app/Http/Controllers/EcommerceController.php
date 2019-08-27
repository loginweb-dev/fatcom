<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\LoginwebController as LW;

use App\Localidade;
use App\EcommerceProducto;
use App\EcommerceEnvio;


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
                            ->select('p.id', 'p.nombre', 'p.imagen', 's.nombre as subcategoria', 'e.id as ecommerce_id', 'e.updated_at', 'e.escasez', 'e.tags')
                            ->where('e.deleted_at', NULL)
                            ->orderBy('e.id', 'DESC')
                            ->paginate(10);
        $value = '';

        return view('inventarios/ecommerce/ecommerce_index', compact('registros', 'value'));
    }

    public function search($value)
    {
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('ecommerce_productos as e', 'e.producto_id', 'p.id')
                            ->select('p.id', 'p.nombre', 'p.imagen', 's.nombre as subcategoria', 'e.id as ecommerce_id', 'e.updated_at', 'e.escasez', 'e.tags')
                            ->whereRaw("p.deleted_at is null and
                                            (p.codigo like '%".$value."%' or
                                            s.nombre like '%".$value."%')
                                        ")
                            ->orderBy('e.id', 'DESC')
                            ->paginate(10);
        return view('inventarios/ecommerce/ecommerce_index', compact('registros', 'value'));
    }

    public function view($id){

    }

    public function create(){

        $categorias = DB::table('categorias as c')
                            ->join('subcategorias as s', 's.categoria_id', 'c.id')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('c.*')
                            ->where('p.deleted_at', NULL)
                            ->where('c.deleted_at', NULL)
                            ->where('c.id', '>', 1)
                            ->distinct()
                            ->get();
        $localidades = Localidade::where('deleted_at', NULL)->where('activo', 1)->get();

        $productos = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->select('p.id', 'p.nombre', 's.nombre as subcategoria')
                            // ->where('deleted_at', NULL)
                            ->whereNotIn('p.id', function($q){
                                $q->select('producto_id')->from('ecommerce_productos')->where('deleted_at', null);
                            })
                            ->get();
        return view('inventarios/ecommerce/ecommerce_create', compact('productos', 'categorias', 'localidades'));
    }

    public function store(Request $data){
        // dd($data);
        $data->validate([
            'producto_id' => 'required'
        ]);

        for ($i=0; $i < count($data->producto_id); $i++) {
            $query = EcommerceProducto::create([
                                        'producto_id' => $data->producto_id[$i],
                                        'escasez' => $data->escasez[$i],
                                        'tags' => $data->tags[$i]
                                    ]);
            for ($j=0; $j < count($data->localidad_id); $j++) {
                if($data->precio[$j] != ''){
                    EcommerceEnvio::create([
                        'ecommerce_producto_id' => $query->id,
                        'producto_id' => $data->producto_id[$i],
                        'localidad_id' => $data->localidad_id[$j],
                        'precio' => $data->precio[$j]
                    ]);
                }
            }
        }
        if($query){
            return redirect()->route('ecommerce_index')->with(['message' => 'Productos agregados al E-Commerce exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('ecommerce_index')->with(['message' => 'Ocurrio un problema al agregar los productos al E-Commerce.', 'alert-type' => 'error']);
        }
    }

    public function edit($id){
        $localidades = Localidade::where('deleted_at', NULL)->where('activo', 1)->get();
        $ecommerce = DB::table('ecommerce_productos as e')
                            ->join('productos as p', 'p.id', 'e.producto_id')
                            ->select('e.*', 'p.nombre')
                            ->where('e.id', $id)
                            ->first();
        $envios = EcommerceEnvio::where('deleted_at', NULL)->where('ecommerce_producto_id', $id)->get();
        return view('inventarios/ecommerce/ecommerce_edit', compact('localidades', 'ecommerce', 'envios'));

    }

    public function update(Request $data){
        $query = DB::table('ecommerce_productos')
                    ->where('id', $data->id)
                    ->update(['tags' => $data->tags, 'updated_at' => Carbon::now()]);
        if($query){
            DB::table('ecommerce_envios')->where('ecommerce_producto_id', $data->id)->update(['deleted_at' => Carbon::now()]);
            for ($j=0; $j < count($data->localidad_id); $j++) {
                if($data->precio[$j] != ''){
                    EcommerceEnvio::create([
                        'ecommerce_producto_id' => $data->id,
                        'producto_id' => $data->producto_id,
                        'localidad_id' => $data->localidad_id[$j],
                        'precio' => $data->precio[$j]
                    ]);
                }
            }
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
