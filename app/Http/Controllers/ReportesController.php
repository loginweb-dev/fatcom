<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $ventas = DB::table('ventas as v')
                        ->join('ventas_detalles as d', 'd.venta_id', 'v.id')
                        ->join('productos as p', 'p.id', 'd.producto_id')
                        ->select('v.fecha', 'p.nombre', 'd.precio', 'd.cantidad')
                        // ->orderBy('ventas.id', 'DESC')
                        ->whereBetween('v.fecha', [$datos->inicio, $datos->fin])
                        // ->where('v.fecha', $datos->fecha)
                        ->where('v.estado', 'V')
                        ->get();
        $fecha = $datos->fecha;
        return view('reportes.tablas.ventas_reporte_generar', compact('ventas', 'fecha'));
    }

    public function ventas_reporte_pdf(Request $datos){
        $ventas = DB::table('ventas as v')
                        ->join('ventas_detalles as d', 'd.venta_id', 'v.id')
                        ->join('productos as p', 'p.id', 'd.producto_id')
                        ->select('v.fecha', 'p.nombre', 'd.precio', 'd.cantidad')
                        // ->orderBy('ventas.id', 'DESC')
                        ->whereBetween('v.fecha', [$datos->inicio, $datos->fin])
                        // ->where('v.fecha', $datos->fecha)
                        ->where('v.estado', 'V')
                        ->get();
        $fecha = $datos->fecha;
        // return view('reportes.tablas.ventas_reporte_pdf', compact('ventas', 'fecha'));
        $vista = view('reportes.tablas.ventas_reporte_pdf', compact('ventas', 'fecha'));;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista)->setPaper('letter', 'landscape');
        $pdf->loadHTML($vista);
        return $pdf->stream();
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

            array_push($datos, array([  'producto'=>$item->nombre,
                                        'precio_venta'=>$ventas->precio,
                                        'cantidad_venta'=>$ventas->cantidad,
                                        'precio_compra'=>$precio_compra
                                    ]));
        }
        // dd($datos);
        return view('reportes.tablas.ganancia_producto_reporte_generar', compact('datos'));
    }

    public function graficos_index()
    {
        return view('reportes.graficos.graficos_index');
    }

    public function graficos_generar(Request $data)
    {
        switch ($data->tipo) {
            case 'mensual':
                $registros  = DB::table('ventas as v')
                                    ->select(DB::raw('SUM(v.importe_base ) as monto, DAY(v.fecha) as dia, v.fecha'))
                                    ->whereMonth('v.fecha', $data->mes)
                                    ->whereYear('v.fecha', $data->anio_mes)
                                    ->where('v.estado', 'V')
                                    ->groupBy('dia', 'fecha')
                                    ->get();
                return response()->json($registros);
                // return view('reportes.graficos.graficos_mensual', compact('registros'));
                case 'anual':
                $registros  = DB::table('ventas as v')
                                    ->select(DB::raw('SUM(v.importe_base ) as monto, MONTH(v.fecha) as mes'))
                                    ->whereYear('v.fecha', $data->anio_mes)
                                    ->where('v.estado', 'V')
                                    ->groupBy('mes')
                                    ->get();
                return response()->json($registros);

            default:
                # code...
                break;
        }
        
    }
}
