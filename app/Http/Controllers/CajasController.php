<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\IeCaja;

class CajasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Cajas=============================================
    function cajas_index(){
        $cajas = DB::table('ie_cajas as c')
                        ->select('c.*')
                        ->orderBy('id', 'DESC')
                        ->paginate(15);
        $aux = DB::table('ie_cajas as c')
                        ->select('c.*')
                        ->where('c.abierta', 1)
                        ->first();
        $abierta = false;
        if($aux){
            $abierta = true;
        }
        $value = '';
        return view('cajas.cajas_index', compact('cajas', 'value', 'abierta'));
    }

    function cajas_buscar($value){
        $value = ($value != 'all') ? $value : '';
        $cajas = DB::table('ie_cajas as c')
                        ->select('c.*')
                        ->whereRaw("c.fecha_apertura like '%".$value."%'")
                        ->orderBy('c.id', 'DESC')
                        ->paginate(15);
        $aux = DB::table('ie_cajas as c')
                        ->select('c.*')
                        ->where('c.abierta', 1)
                        ->first();
        $abierta = false;
        if($aux){
            $abierta = true;
        }
        return view('cajas.cajas_index', compact('cajas', 'value', 'abierta'));
    }

    function cajas_view($id){
        $caja = DB::table('ie_cajas as c')
                        ->select('c.*')
                        ->where('id', $id)
                        ->first();
        $ingresos = DB::table('ie_asientos')
                        ->select('*')
                        // ->where('deleted_at', null)
                        ->where('tipo', 'ingreso')
                        ->where('caja_id', $id)
                        ->get();
        $egresos = DB::table('ie_asientos')
                        ->select('*')
                        // ->where('deleted_at', null)
                        ->where('tipo', 'egreso')
                        ->where('caja_id', $id)
                        ->get();
        return view('cajas.cajas_view', compact('caja' , 'ingresos', 'egresos', 'id'));
    }

    function cajas_create(){
        // $cajas = DB::table('ie_cajas')
        //                 ->select('*')
        //                 ->where('abierta', 1)
        //                 ->get();
        return view('cajas.cajas_create');
    }

    function cajas_store(Request $datos){
        // dd($datos);
        $insert = DB::table('ie_cajas')
                        ->insert([
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'nombre' => $datos->nombre,
                            'fecha_apertura' => $datos->fecha,
                            'hora_apertura' => $datos->hora,
                            'monto_inicial' => $datos->monto,
                            'monto_final' => $datos->monto,
                            'total_ingresos' => 0,
                            'total_egresos' => 0,
                            'abierta' => 1,
                            'user_id' => Auth::user()->id
                        ]);
        if($insert){
            return redirect()->route('cajas_index')->with(['message' => 'Caja aperturada exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('cajas_index')->with(['message' => 'Ocurrio un error al aperturar la caja.', 'alert-type' => 'error']);
        }
    }

    function cajas_close(Request $data){
        $update = DB::table('ie_cajas')
                        ->where('id', $data->id)
                        ->update([
                            'updated_at' => Carbon::now(),
                            'fecha_cierre' => date('Y-m-d'),
                            'hora_cierre' => date('H:i'),
                            'observaciones' => $data->observaciones,
                            'abierta' => 0,
                            'monto_real' => $data->total,
                            'monto_faltante' => $data->faltante
                        ]);
        if($update){
            return redirect()->route('cajas_index')->with(['message' => 'Cierre de caja registrado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('cajas_index')->with(['message' => 'Ocurrio un error al cerrar la caja.', 'alert-type' => 'error']);
        }
    }

    // ==================================Asientos=================================
    function asientos_index(){
        $asientos = DB::table('ie_asientos as i')
                        ->join('ie_cajas as c', 'c.id', 'i.caja_id')
                        ->join('users as u', 'u.id', 'i.user_id')
                        ->select('i.*', 'u.name', 'c.abierta')
                        // ->where('i.deleted_at', NULL)
                        ->orderBy('i.id', 'DESC')
                        ->paginate(20);
        $value = '';
        return view('cajas.asientos_index', compact('asientos', 'value'));
    }

    function asientos_buscar($value){
        $value = ($value != 'all') ? $value : '';
        $asientos = DB::table('ie_asientos as i')
                        ->join('ie_cajas as c', 'c.id', 'i.caja_id')
                        ->join('users as u', 'u.id', 'i.user_id')
                        ->select('i.*', 'u.name', 'c.abierta')
                        ->whereRaw("i.fecha like '%".$value."%'")
                        ->orderBy('i.id', 'DESC')
                        ->paginate(20);
        return view('cajas.asientos_index', compact('asientos', 'value'));
    }

    function asientos_create(){
        $cajas = DB::table('ie_cajas')
                        ->select('*')
                        ->where('abierta', 1)
                        ->get();
        return view('cajas.asientos_create', compact('cajas'));
    }

    function asientos_store(Request $data){
        if($data->tipo=='egreso'){
            $caja = IeCaja::where('abierta', 1)->first();
            $monto_caja = $caja ? $caja->monto_final : 0;
            if($data->monto > $monto_caja){
                return redirect()->route('asientos_create')->with(['message' => 'El monto ingresado supera al saldo actual en caja.', 'alert-type' => 'error']);
            }
        }
        $insert = DB::table('ie_asientos')
                        ->insert([
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'caja_id' => $data->caja_id,
                            'fecha' => $data->fecha,
                            'hora' => $data->hora,
                            'concepto' => $data->concepto,
                            'tipo' => $data->tipo,
                            'monto' => $data->monto,
                            'user_id' => Auth::user()->id
                        ]);
        if($insert){
            if($data->tipo=='ingreso'){
                DB::table('ie_cajas')->where('id', $data->caja_id)->increment('monto_final', $data->monto);
                DB::table('ie_cajas')->where('id', $data->caja_id)->increment('total_ingresos', $data->monto);
            }else{
                DB::table('ie_cajas')->where('id', $data->caja_id)->decrement('monto_final', $data->monto);
                DB::table('ie_cajas')->where('id', $data->caja_id)->increment('total_egresos', $data->monto);
            }
            return redirect()->route('asientos_index')->with(['message' => 'Ingreso a caja registrado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('asientos_index')->with(['message' => 'Ocurrio un error al registrar el ingreso a caja.', 'alert-type' => 'error']);
        }
    }

    function asientos_delete(Request $datos){
        // dd($datos);
        $insert = DB::table('ie_asientos')
                        ->where('id', $datos->id)
                        ->update([
                            'deleted_at' => Carbon::now()
                        ]);
        if($insert){
            if($datos->tipo == 'ingreso'){
                DB::table('ie_cajas')->where('id', $datos->caja_id)->decrement('monto_final', $datos->monto);
                DB::table('ie_cajas')->where('id', $datos->caja_id)->decrement('total_ingresos', $datos->monto);
            }else{
                DB::table('ie_cajas')->where('id', $datos->caja_id)->increment('monto_final', $datos->monto);
                DB::table('ie_cajas')->where('id', $datos->caja_id)->decrement('total_egresos', $datos->monto);
            }
            return redirect()->route('asientos_index')->with(['message' => 'Ingreso a caja anulado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('asientos_index')->with(['message' => 'Ocurrio un error al anular el ingreso a caja.', 'alert-type' => 'error']);
        }
    }

}
