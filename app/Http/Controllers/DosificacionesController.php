<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\LoginwebController as LW;

use App\Dosificacione;

class DosificacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Actualizar estado de dosificaciones vecidas
        $fecha_actual = date('Y-m-d');
        Dosificacione::where('fecha_limite', '<', $fecha_actual)->where('activa', 1)->update(['activa' => 0]);

        $registros = DB::table('dosificaciones as d')
                            ->select('d.*')
                            ->where('d.deleted_at', NULL)
                            ->orderBy('d.id', 'DESC')
                            ->paginate(10);
        $value = '';
        return view('dosificaciones/dosificaciones_index', compact('registros', 'value'));
    }

    public function view($id){
        $dosificacion = DB::table('dosificaciones as d')
                            ->select('d.*')
                            ->where('d.id', $id)
                            ->first();
        return view('dosificaciones/dosificaciones_view', compact('dosificacion'));
    }

    public function create(){
        return view('dosificaciones/dosificaciones_create');
    }

    public function store(Request $data){

        $data->validate([
            'nro_autorizacion' => 'required|max:50',
            'llave_dosificacion' => 'required|max:100',
            'fecha_limite' => 'required',
            'numero_inicial' => 'required'
        ]);

        $fecha_actual = date('Y-m-d');
        if($data->fecha_limite <= $fecha_actual){
            return redirect()->route('dosificaciones_create')->with(['message' => 'La fecha límite ingresada debe ser mayor a la actual.', 'alert-type' => 'error']);;
        }

        $dosificacion = Dosificacione::where('activa', 1)->select('id')->first();
        if($dosificacion){
            return redirect()->route('dosificaciones_index')->with(['message' => 'Existe una dosificación activa.', 'alert-type' => 'error']);
        }

        $query = Dosificacione::create([
                    'nro_autorizacion' => $data->nro_autorizacion,
                    'llave_dosificacion' => $data->llave_dosificacion,
                    'fecha_limite' => $data->fecha_limite,
                    'numero_inicial' => $data->numero_inicial,
                    'numero_actual' => $data->numero_inicial,
                    'activa' => 1,
                ]);

        if($query){
            return redirect()->route('dosificaciones_index')->with(['message' => 'Dosificación guardada exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('dosificaciones_index')->with(['message' => 'Ocurrió un error al guardar la dosificación.', 'alert-type' => 'error']);
        }

    }

    public function edit($id){
        $dosificacion = DB::table('dosificaciones as d')
                            ->select('d.*')
                            ->where('d.id', $id)
                            ->first();
        return view('dosificaciones/dosificaciones_edit', compact('dosificacion'));
    }

    public function update(Request $data){
        $data->validate([
            'nro_autorizacion' => 'required|max:50',
            'llave_dosificacion' => 'required|max:100',
            'fecha_limite' => 'required',
            'numero_inicial' => 'required'
        ]);

        // Si se trata de activar la dosificación verificar si no existe una activa actualmente
        $estado = isset($data->estado) ? 1 : 0;
        if($estado){
            $dosificacion = Dosificacione::where('activa', 1)->where('id', '<>', $data->id)->select('id')->first();
            if($dosificacion){
                return redirect()->route('dosificaciones_index')->with(['message' => 'Existe una dosificación activa.', 'alert-type' => 'error']);
            }
        }

        $query = Dosificacione::where('id', $data->id)->update([
            'nro_autorizacion' => $data->nro_autorizacion,
            'llave_dosificacion' => $data->llave_dosificacion,
            'fecha_limite' => $data->fecha_limite,
            'activa' => $estado,
        ]);

        if($query){
            return redirect()->route('dosificaciones_index')->with(['message' => 'Dosificación editada exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('dosificaciones_index')->with(['message' => 'Ocurrió un error al editar la dosificación.', 'alert-type' => 'error']);
        }
    }

    public function delete(Request $data){
        $query = Dosificacione::where('id', $data->id)->update(['activa' => 0, 'deleted_at' => Carbon::now()]);

        if($query){
            return redirect()->route('dosificaciones_index')->with(['message' => 'Dosificación eliminada exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('dosificaciones_index')->with(['message' => 'Ocurrió un error al eliminar la dosificación.', 'alert-type' => 'error']);
        }
    }

    // Otros medodos=======================

    public function get_dosificacion(){
        $fecha_actual = date('Y-m-d');
        return Dosificacione::where('activa', 1)->where('fecha_limite', '>', $fecha_actual)->select('id')->first();
    }

}
