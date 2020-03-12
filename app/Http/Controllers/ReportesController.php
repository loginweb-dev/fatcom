<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Sucursale;

// Exportación a Excel
use App\Exports\ReporteVentaExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ventas_reporte(){
        return view('reportes.tablas.ventas_reporte');
    }

    public function ventas_reporte_generar(Request $datos){
        $ventas = $this->get_ventas($datos->filtro ,$datos->inicio, $datos->fin, $datos->tipo);
        if($datos->type){
            $inicio = $datos->inicio;
            $fin = $datos->fin;
            if($datos->type === 'pdf'){
                // return view('reportes.tablas.ventas_reporte_por_venta_pdf', compact('ventas', 'inicio', 'fin'));
                $vista = view('reportes.tablas.ventas_reporte_por_venta_pdf', compact('ventas', 'inicio', 'fin'));
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($vista)->setPaper('letter', 'landscape');
                $pdf->loadHTML($vista);
                return $pdf->stream();
            }else{
                session(['ventasReporteExcel' => $ventas]);
                return Excel::download(new ReporteVentaExport, 'Ventas desde '.$inicio.' al '.$fin.'.xlsx');
            }
            
        }
        return $datos->filtro == 1 ?
                view('reportes.tablas.ventas_reporte_por_venta', compact('ventas')) :
                view('reportes.tablas.ventas_reporte_por_producto', compact('ventas'));
    }

    public function get_ventas($filtro, $inicio, $fin, $tipo){
        switch ($tipo) {
            case 1:
                $filtro_tipo = "v.nro_factura is null";
                break;
            case 2:
                $filtro_tipo = "v.nro_factura is not null";
                break;
            default:
                $filtro_tipo = 1;
                break;
        }
        if($filtro==1){
            $ventas = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select('v.id', 'v.fecha', 'c.razon_social as cliente', 'v.deleted_at as detalle', 'v.importe', 'v.cobro_adicional', 'v.descuento', 'v.importe_base')
                            ->whereBetween('v.fecha', [$inicio, $fin])
                            ->where('v.estado', 'V')->where('v.deleted_at', NULL)
                            ->orderBy('v.id', 'DESC')
                            ->whereRaw($filtro_tipo)
                            ->get();
            $cont = 0;
            foreach ($ventas as $item) {
                $detalle = DB::table('productos as p')
                                ->join('ventas_detalles as vd', 'vd.producto_id', 'p.id')
                                ->select('p.nombre', 'vd.cantidad', 'vd.precio')
                                ->where('vd.venta_id', $item->id)->get();
                $ventas[$cont]->detalle = $detalle;
                $cont++;
            }
            return $ventas;
        }else{
            return $ventas = DB::table('ventas as v')
                                    ->join('ventas_detalles as d', 'd.venta_id', 'v.id')
                                    ->join('productos as p', 'p.id', 'd.producto_id')
                                    ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                    ->select('p.nombre', 'd.precio', 'p.imagen', DB::raw('SUM(d.cantidad) as cantidad'), 's.nombre as subcategoria')
                                    ->whereBetween('v.fecha', [$inicio, $fin])
                                    ->where('v.estado', 'V')->where('v.deleted_at', NULL)
                                    ->whereRaw($filtro_tipo)
                                    ->groupBy('p.id')->orderBy('d.producto_id', 'DESC')
                                    ->get();
            // dd($ventas);
        }
    }

    public function ganancia_producto_reporte(){
        return view('reportes.tablas.ganancia_producto_reporte');
    }

    public function ganancia_producto_reporte_generar(Request $data){
        $productos = DB::table('productos')
                                ->select('*')
                                ->where('deleted_at', NULL)
                                ->get();
        $datos = [];
        foreach ($productos as $item) {
            $ventas = DB::table('ventas as v')
                            ->join('ventas_detalles as d', 'd.venta_id', 'v.id')
                            ->select(DB::raw('avg(d.precio) as precio, SUM(d.cantidad) as cantidad'))
                            ->where('d.producto_id', $item->id)
                            ->whereBetween('v.fecha', [$data->inicio, $data->fin])
                            ->first();

            $compras = DB::table('compras as c')
                            ->join('compras_detalles as d', 'd.compra_id', 'c.id')
                            ->select(DB::raw('avg(d.precio) as precio'))
                            ->where('d.producto_id', $item->id)
                            ->whereBetween('c.fecha', [$data->inicio, $data->fin])
                            ->first();

            $precio_compra = $compras->precio;

            if(!$precio_compra){
                $compras = DB::table('compras as c')
                                ->join('compras_detalles as d', 'd.compra_id', 'c.id')
                                ->select('d.precio')
                                ->where('d.producto_id', $item->id)
                                ->where('c.fecha', '<', $data->inicio)
                                ->orderBy('c.fecha', 'DESC')
                                ->first();
                if($compras){
                    $precio_compra = $compras->precio;
                }
            }

            if($ventas->precio){
                array_push($datos, array([
                    'producto'=>$item->nombre,
                    'precio_venta'=>$ventas->precio,
                    'cantidad_venta'=>$ventas->cantidad,
                    'precio_compra'=>$precio_compra
                ]));
            }
            
        }
        // dd($datos);
        return view('reportes.tablas.ganancia_producto_reporte_generar', compact('datos'));
    }

    public function graficos_index()
    {
        $sucursales = Sucursale::where('deleted_at', NULL)->select('id', 'nombre')->get();
        return view('reportes.graficos.graficos_index', compact('sucursales'));
    }

    public function graficos_generar(Request $data)
    {
        switch ($data->tipo) {
            case 'mensual':
                $sentencia_sucursal = $data->sucursal_id_mensual ? "v.sucursal_id=".$data->sucursal_id_mensual : 1;
                $registros  = DB::table('ventas as v')
                                    ->select(DB::raw('SUM(v.importe_base) as monto, DAY(v.fecha) as dia, v.fecha'))
                                    ->whereMonth('v.fecha', $data->mes)
                                    ->whereYear('v.fecha', $data->anio_mes)
                                    ->where('v.deleted_at', NULL)->where('v.estado', 'V')
                                    ->groupBy('dia', 'fecha')
                                    ->whereRaw($sentencia_sucursal)
                                    ->get();
                return response()->json($registros);
                case 'anual':
                    $sentencia_sucursal = $data->sucursal_id_anual ? "v.sucursal_id=".$data->sucursal_id_anual : 1;
                $registros  = DB::table('ventas as v')
                                    ->select(DB::raw('SUM(v.importe_base) as monto, MONTH(v.fecha) as mes'))
                                    ->whereYear('v.fecha', $data->anio_anual)
                                    ->where('v.deleted_at', NULL)->where('v.estado', 'V')
                                    ->whereRaw($sentencia_sucursal)
                                    ->groupBy('mes')
                                    ->get();
                return response()->json($registros);
                case 'productos':
                    
                    $sentencia_sucursal = $data->sucursal_id_productos ? "v.sucursal_id=".$data->sucursal_id_productos : 1;
                    $sentencia_mes = $data->mes_productos ? "MONTH(v.created_at)=".$data->mes_productos : 1;
                    
                    switch ($data->group_by) {
                        case 'productos':
                            $display_name = ', p.nombre as nombre';
                            $groupBy = 'p.codigo_grupo';
                        break;
                        case 'categorias':
                            $display_name = ', c.nombre as nombre';
                            $groupBy = 'c.id';
                        break;
                        case 'subcategorias':
                            $display_name = ', s.nombre as nombre';
                            $groupBy = 's.id';
                        break;
                        default:
                            $display_name = ', CONCAT(p.nombre," - ",s.nombre) as nombre';
                            $groupBy = 'p.id';
                            break;
                    }

                    $registros  = DB::table('ventas as v')
                                        ->join('ventas_detalles as vd', 'vd.venta_id', 'v.id')
                                        ->join('productos as p', 'p.id', 'vd.producto_id')
                                        ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                                        ->join('categorias as c', 'c.id', 's.categoria_id')
                                        ->select(DB::raw('p.id, SUM(vd.cantidad) as cantidad'.$display_name))
                                        ->whereYear('v.fecha', $data->anio_productos)
                                        ->where('v.deleted_at', NULL)->where('v.estado', 'V')
                                        ->whereRaw($sentencia_sucursal)
                                        ->whereRaw($sentencia_mes)
                                        ->groupBy($groupBy)
                                        ->get();
                    return response()->json($registros);
        }
    }

    public function productos_escasez(){
        $productos = DB::table('productos as p')
                            ->join('subcategorias as s', 's.id', 'p.subcategoria_id')
                            ->select(
                                        'p.codigo', 'p.nombre', 'p.stock', 'p.stock_minimo', 's.nombre as subcategoria',
                                        DB::raw("(SELECT c.created_at FROM compras_detalles as d, compras as c where c.id = d.compra_id and d.producto_id = p.id order by c.id DESC limit 1) as ultima_compra")
                                    )
                            ->where('p.se_almacena', 1)->where('p.deleted_at', NULL)
                            ->whereColumn('p.stock', '<', 'p.stock_minimo')
                            ->where('p.stock_minimo', '>', 0)
                            ->get();
        return view('reportes.tablas.producto_escasez_reporte', compact('productos'));
    }
}
