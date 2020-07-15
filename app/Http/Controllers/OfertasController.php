<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\LoginwebController as LW;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

use App\Http\Controllers\ProductosController as Productos;

use App\Oferta;
use App\OfertasDetalle;


class OfertasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $registros = DB::table('ofertas as o')
                            ->select('o.*')
                            ->where('deleted_at', NULL)
                            ->paginate(10);
        $value = '';
        return view('inventarios/ofertas/ofertas_index', compact('registros', 'value'));
    }

    public function search($value)
    {
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('ofertas as o')
                            ->select('o.*')
                            ->where('o.deleted_at', NULL)
                            ->where('o.nombre', 'like', "%$value%")
                            ->paginate(10);
        return view('inventarios/ofertas/ofertas_index', compact('registros', 'value'));
    }

    public function view($id){
        $oferta = DB::table('ofertas')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', $id)
                            ->first();
        $detalle = DB::table('ofertas_detalles as o')
                            ->join('productos as p', 'p.id', 'o.producto_id')
                            ->join('monedas as m', 'm.id', 'p.moneda_id')
                            ->select('o.*', 'p.id as producto_id', 'p.nombre', 'm.abreviacion as moneda')
                            ->where('o.deleted_at', NULL)
                            ->where('o.oferta_id', $id)
                            ->get();
        $precios = [];
        foreach ($detalle as $item) {
            // Obtener precios de venta del producto
            $producto_unidades =  (new Productos)->obtener_precios_venta($item->producto_id);
            $precio = (count($producto_unidades)>0) ? ['precio' => $producto_unidades[0]->precio, 'unidad' => $producto_unidades[0]->unidad] : ['precio' => 0, 'unidad' => 'No definida'];
            array_push($precios, $precio);

        }
        return view('inventarios/ofertas/ofertas_view', compact('oferta', 'detalle', 'precios', 'id'));
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

        $productos = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('monedas as mo', 'mo.id', 'p.moneda_id')
                            ->select('p.*', 's.nombre as subcategoria', 'm.nombre as marca', 'mo.abreviacion as moneda')
                            // ->where('deleted_at', NULL)
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
                            ->get();
        return view('inventarios/ofertas/ofertas_create', compact('productos', 'categorias'));
    }

    public function store(Request $data){

        $data->validate([
            'producto_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $imagen = null;
            if($data->hasFile('imagen')){
                $file = $data->file('imagen');
                Storage::makeDirectory('public/ofertas/'.date('F').date('Y'));
                $base_name = str_random(20);

                // imagen normal
                $filename = $base_name.'.'.$file->getClientOriginalExtension();
                $image_resize = Image::make($file->getRealPath())->orientate();
                $image_resize->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $path =  'ofertas/'.date('F').date('Y').'/'.$filename;
                $image_resize->save('storage/'.$path);
                $imagen = $path;
            }

            // Si el tipo de duración es diferente de rango se debe obtener ya sea el dia de la semana o el dia del mes
            if($data->tipo_duracion == 'rango'){
                $dia = null;
            }else{
                $dia = ($data->tipo_duracion == 'semanal') ? $data->dia_semana : $data->dia_mes;
            }

            $oferta = new Oferta;
            $oferta->tipo_oferta = $data->tipo_oferta;
            $oferta->nombre = $data->nombre;
            $oferta->descripcion = $data->descripcion;
            $oferta->tipo_duracion = $data->tipo_duracion;
            $oferta->dia = $dia;
            $oferta->inicio = $data->inicio.' 00:00:00';
            $oferta->fin = (!empty($data->fin)) ? $data->fin.' 23:00:00' : $data->fin;
            $oferta->imagen = $imagen;
            $oferta->estado = isset($data->estado) ? 1 : 0;
            $oferta->save();

            for ($i=0; $i < count($data->producto_id); $i++) {
                $detalle_oferta = new OfertasDetalle;
                $detalle_oferta->oferta_id = $oferta->id;
                $detalle_oferta->producto_id = $data->producto_id[$i];
                if($data->tipo_oferta == 1){
                    $detalle_oferta->tipo_descuento = $data->tipo[$i];
                    $detalle_oferta->monto = $data->monto[$i];
                }
                $detalle_oferta->save();
            }
            DB::commit();
            return redirect()->route('ofertas_index')->with(['message' => 'Campaña de oferta creada exitosamenete.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('ofertas_index')->with(['message' => 'Ocurrio un problema al crear la campaña de oferta.', 'alert-type' => 'error']);
        }
    }

    public function edit($id){
        $oferta = DB::table('ofertas as o')
                        ->select('o.*')
                        ->where('o.deleted_at', NULL)
                        ->where('o.id', $id)
                        ->first();
        $detalle_oferta = DB::table('ofertas_detalles as d')
                        ->join('productos as p', 'p.id', 'd.producto_id')
                        ->select('d.*', 'p.nombre as producto')
                        ->where('d.deleted_at', NULL)
                        ->where('d.oferta_id', $id)
                        ->get();
        $precios = [];
        foreach ($detalle_oferta as $item) {
            // Obtener precios de venta del producto
            $producto_unidades =  (new Productos)->obtener_precios_venta($item->producto_id);
            $precio = (count($producto_unidades)>0) ? ['precio' => $producto_unidades[0]->precio, 'cantidad_minima' => $producto_unidades[0]->cantidad_minima, 'moneda' => $producto_unidades[0]->moneda] : ['precio' => 0, 'cantidad_minima' => 'No definida', 'moneda' => 'No definida'];
            array_push($precios, $precio);
        }
        $cantidad_productos = count($detalle_oferta);
        $categorias = DB::table('categorias as c')
                            ->join('subcategorias as s', 's.categoria_id', 'c.id')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('c.*')
                            ->where('p.deleted_at', NULL)
                            ->where('c.deleted_at', NULL)
                            ->where('c.id', '>', 1)
                            ->distinct()
                            ->get();

        $productos = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->join('marcas as m', 'm.id', 'p.marca_id')
                            ->join('monedas as mo', 'mo.id', 'p.moneda_id')
                            ->select('p.*', 's.nombre as subcategoria', 'm.nombre as marca', 'mo.abreviacion as moneda')
                            // ->where('deleted_at', NULL)
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
                            ->get();
        return view('inventarios/ofertas/ofertas_edit', compact('oferta', 'detalle_oferta', 'precios', 'cantidad_productos', 'productos', 'categorias'));
    }

    public function update(Request $data){
        $data->validate([
            'producto_id' => 'required'
        ]);

        $path = '';
        if($data->hasFile('imagen')){
            $file = $data->file('imagen');
            Storage::makeDirectory('public/ofertas/'.date('F').date('Y'));
            $base_name = str_random(20);

            // imagen normal
            $filename = $base_name.'.'.$file->getClientOriginalExtension();
            $image_resize = Image::make($file->getRealPath())->orientate();
            $image_resize->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path =  'ofertas/'.date('F').date('Y').'/'.$filename;
            $image_resize->save('storage/'.$path);
        }

        // Si el tipo de duración es diferente de rango se debe obtener ya sea el dia de la semana o el dia del mes
        if($data->tipo_duracion == 'rango'){
            $dia = null;
        }else{
            $dia = ($data->tipo_duracion == 'semanal') ? $data->dia_semana : $data->dia_mes;
        }

        $oferta = Oferta::find($data->id);
        $oferta->nombre = $data->nombre;
        $oferta->descripcion = $data->descripcion;
        $oferta->tipo_duracion = $data->tipo_duracion;
        $oferta->dia = $dia;
        $oferta->inicio = $data->inicio.' 00:00:00';
        $oferta->fin = (!empty($data->fin)) ? $data->fin.' 23:00:00' : $data->fin;
        if($path!=''){
            $oferta->imagen = $path;
        }
        $oferta->estado = isset($data->estado) ? 1 : 0;
        $oferta->save();
        DB::table('ofertas_detalles')->where('oferta_id', $data->id)->update(['deleted_at' => Carbon::now()]);
        for ($i=0; $i < count($data->producto_id); $i++) {
            $query = DB::table('ofertas_detalles')
                            ->insert([
                                'oferta_id' => $data->id,
                                'producto_id' => $data->producto_id[$i],
                                'tipo_descuento' => $data->tipo[$i],
                                'monto' => $data->monto[$i],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
        }

        if($query){
            return redirect()->route('ofertas_index')->with(['message' => 'Campaña de oferta editada exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('ofertas_index')->with(['message' => 'Ocurrio un problema al editar la campaña de oferta.', 'alert-type' => 'error']);
        }
    }

    public function delete(Request $data){
        $query = DB::table('ofertas')->where('id', $data->id)->update(['deleted_at' => Carbon::now()]);
        if($query){
            $query = DB::table('ofertas_detalles')->where('oferta_id', $data->id)->update(['deleted_at' => Carbon::now()]);
            return redirect()->route('ofertas_index')->with(['message' => 'Campaña de oferta eliminada exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('ofertas_index')->with(['message' => 'Ocurrio un problema al eliminar la campaña de oferta.', 'alert-type' => 'error']);
        }
    }

// Obtener datos varios
    public function get_productos_oferta(){

        $dia_semana = date('N');
        $dia_mes = date('j');
        $ofertas = DB::table('productos as p')
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
                    ->select('p.id', 'p.nombre', 'p.imagen', 'p.modelo', 'p.garantia', 'p.descripcion_small', 'p.slug', 's.nombre as subcategoria', 'm.nombre as marca', 'mn.abreviacion as moneda', 'u.nombre as uso', 'co.nombre as color', 'g.nombre as genero', 'df.monto as descuento', 'df.tipo_descuento', 'df.monto as monto_descuento', 'p.nuevo')
                    ->whereRaw("( (o.tipo_duracion = 'rango' and o.inicio < '".Carbon::now()."' and (o.fin is NULL or o.fin > '".Carbon::now()."')) or (o.tipo_duracion = 'semanal' and o.dia = $dia_semana) or (o.tipo_duracion = 'mensual' and o.dia = $dia_mes) )")
                    ->where('s.deleted_at', NULL)
                    ->where('m.deleted_at', NULL)
                    ->where('e.deleted_at', NULL)
                    ->where('e.activo', 1)
                    ->where('df.deleted_at', NULL)
                    ->where('o.deleted_at', NULL)
                    ->where('o.estado', 1)->where('o.tipo_oferta', 1)
                    ->paginate(5);

        return $ofertas;
    }

    public function obtener_oferta($id){
        $dia_semana = date('N');
        $dia_mes = date('j');
        return DB::table('ofertas_detalles as d')
                    ->join('ofertas as o', 'o.id', 'd.oferta_id')
                    ->select('d.tipo_descuento', 'd.monto', 'o.fin')
                    ->where('d.producto_id', $id)
                    ->where('d.deleted_at', NULL)
                    ->where('o.deleted_at', NULL)
                    ->where('o.estado', 1)->where('o.tipo_oferta', 1)
                    ->whereRaw("( (o.tipo_duracion = 'rango' and o.inicio < '".Carbon::now()."' and (o.fin is NULL or o.fin > '".Carbon::now()."')) or (o.tipo_duracion = 'semanal' and o.dia = $dia_semana) or (o.tipo_duracion = 'mensual' and o.dia = $dia_mes) )")
                    ->first();
    }

    public function get_oferta_random(){
        return  DB::table('ofertas')
                    ->inRandomOrder()
                    ->first();
    }

}
