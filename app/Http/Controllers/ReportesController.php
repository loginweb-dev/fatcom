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
