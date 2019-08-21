<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\IeCaja;
use App\Sucursale;

class CajasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Cajas=============================================
    function cajas_index(){
        
        if(Auth::user()->role_id <= 3){
            $cajas_abiertas = DB::table('ie_cajas as c')
                                    ->join('sucursales as s', 's.id', 'c.sucursal_id')
                                    ->select('c.id')
                                    ->where('c.abierta', 1)
                                    ->where('s.deleted_at', NULL)
                                    ->count();
            $cont_suscursales = Sucursale::where('deleted_at', NULL)->select('id')->count();

            $abiertas = ($cajas_abiertas < $cont_suscursales) ? false : true;

            $cajas = DB::table('ie_cajas as c')
                        ->select('c.*')
                        ->orderBy('id', 'DESC')
                        ->paginate(15);
        }else{
            // Si el usuario no es administrador solo puede abrir la caja de la ultima sucursal en la que estuvo
            $s_u = DB::table('users_sucursales')->select('sucursal_id')->where('user_id', Auth::user()->id)->first();
            $sucursal_user = $s_u ? "sucursal_id = $s_u->sucursal_id" : 1;
            
            $abiertas = DB::table('ie_cajas as c')
                        ->select('c.*')
                        ->where('c.abierta', 1)
                        ->whereRaw($sucursal_user)
                        ->first() ? true : false;

            $cajas = DB::table('ie_cajas as c')
                        ->select('c.*')
                        ->whereRaw($sucursal_user)
                        ->orderBy('id', 'DESC')
                        ->paginate(15);
        }
        
        $value = '';
        return view('cajas.cajas_index', compact('cajas', 'value', 'abiertas'));
    }

    function cajas_buscar($value){
        $value = ($value != 'all') ? $value : '';
        $cajas = DB::table('ie_cajas as c')
                        ->select('c.*')
                        ->whereRaw("c.fecha_apertura like '%".$value."%'")
                        ->orderBy('c.id', 'DESC')
                        ->paginate(15);
        if(Auth::user()->role_id <= 3){
            $cajas_abiertas = DB::table('ie_cajas as c')
                                    ->join('sucursales as s', 's.id', 'c.sucursal_id')
                                    ->select('c.id')
                                    ->where('c.abierta', 1)
                                    ->where('s.deleted_at', NULL)
                                    ->count();
            $cont_suscursales = Sucursale::where('deleted_at', NULL)->select('id')->count();

            $abiertas = ($cajas_abiertas < $cont_suscursales) ? false : true;

        }else{
            // Si el usuario no es administrador solo puede abrir la caja de la ultima sucursal en la que estuvo
            $s_u = DB::table('users_sucursales')->select('sucursal_id')->where('user_id', Auth::user()->id)->first();
            $sucursal_user = $s_u ? "sucursal_id = $s_u->sucursal_id" : 1;
            
            $abiertas = DB::table('ie_cajas as c')
                        ->select('c.*')
                        ->where('c.abierta', 1)
                        ->whereRaw($sucursal_user)
                        ->first() ? true : false;
        }
        return view('cajas.cajas_index', compact('cajas', 'value', 'abiertas'));
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
        if(Auth::user()->role_id <= 3){
            $sucursales = Sucursale::where('deleted_at', NULL)
                            ->whereNotIn('id', function($q){
                                $q->select('sucursal_id')->from('ie_cajas')->where('abierta', 1);
                            })
                            ->select('*')->get();
        }else{
            $s_u = DB::table('users_sucursales')->select('sucursal_id')->where('user_id', Auth::user()->id)->first();
            $sucursal_user = $s_u ? "id = $s_u->sucursal_id" : 0;
            $sucursales = Sucursale::where('deleted_at', NULL)
                            ->whereNotIn('id', function($q){
                                $q->select('sucursal_id')->from('ie_cajas')->where('abierta', 1);
                            })
                            ->whereRaw($sucursal_user)
                            ->select('*')->get();
        }
        
        return view('cajas.cajas_create', compact('sucursales'));
    }

    function cajas_store(Request $data){
        // dd($datos);
        $query = IeCaja::create([
            'sucursal_id' => $data->sucursal_id,
            'nombre' => $data->nombre,
            'fecha_apertura' => $data->fecha,
            'hora_apertura' => $data->hora,
            'monto_inicial' => $data->monto,
            'monto_final' => $data->monto,
            'total_ingresos' => 0,
            'total_egresos' => 0,
            'abierta' => 1,
            'user_id' => Auth::user()->id
        ]);
        
        if($query){
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
        if(Auth::user()->role_id <= 3){
            $cajas = DB::table('ie_cajas as c')
                            ->join('sucursales as s', 's.id', 'c.sucursal_id')
                            ->select('c.*', 's.nombre as sucursal')
                            ->where('c.abierta', 1)
                            ->get();
        }else{
            $s_u = DB::table('users_sucursales')->select('sucursal_id')->where('user_id', Auth::user()->id)->first();
            $sucursal_user = $s_u ? "s.id = $s_u->sucursal_id" : 0;
            $cajas = DB::table('ie_cajas as c')
                            ->join('sucursales as s', 's.id', 'c.sucursal_id')
                            ->select('c.*', 's.nombre as sucursal')
                            ->where('c.abierta', 1)
                            ->whereRaw($sucursal_user)
                            ->get();
        }
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
