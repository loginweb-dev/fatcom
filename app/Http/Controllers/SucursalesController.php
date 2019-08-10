<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\LoginwebController as LW;

use App\Sucursale;

class SucursalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $registros = DB::table('sucursales')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->paginate(10);
        $value = '';
        return view('inventarios/sucursales/sucursales_index', compact('registros', 'value'));
    }

    public function search($value)
    {
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('sucursales as s')
                            ->select('*')
                            ->whereRaw("s.deleted_at is null and
                                        (
                                            s.nombre like '%".$value."%' or
                                            s.telefono like '%".$value."%' or
                                            s.celular like '%".$value."%' or
                                            s.direccion like '%".$value."%'
                                        )")
                            ->paginate(10);
        return view('inventarios/sucursales/sucursales_index', compact('registros', 'value'));
    }

    public function view($id){
        $registro = DB::table('sucursales')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', $id)
                            ->first();
        return view('inventarios/sucursales/sucursales_view', compact('registro', 'id'));
    }

    public function create(){
        return view('inventarios/sucursales/sucursales_create');
    }

    public function store(Request $data){
        $data->validate([
            'nombre' => 'required|unique:depositos|max:50'
        ]);

        $sucursal = new Sucursale;
        $sucursal->nombre = $data->nombre;
        $sucursal->direccion = $data->direccion;
        $sucursal->telefono = $data->telefono;
        $sucursal->celular = $data->celular;
        $sucursal->latitud = $data->latitud;
        $sucursal->longitud = $data->longitud;
        $sucursal->save();

        $id = Sucursale::all()->last()->id;

        if($id){
            DB::table('depositos')
                    ->insert([
                        'nombre' => 'Deposito - '.$data->nombre,
                        'ubicacion' => $data->direccion,
                        'sucursal_id' => $id,
                        'inventario' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            return redirect()->route('sucursales_index')->with(['message' => 'Sucursal guardada exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('sucursales_index')->with(['message' => 'Ocurrio un problema al guardar la sucursal.', 'alert-type' => 'error']);
        }
    }

    public function edit($id){
        $registro = DB::table('sucursales')
                            ->select('*')
                            ->where('deleted_at', NULL)
                            ->where('id', $id)
                            ->first();
        return view('inventarios/sucursales/sucursales_edit', compact('registro'));
    }

    public function update(Request $data){
        $query = DB::table('sucursales')
                        ->where('id', $data->id)
                        ->update([
                            'nombre' => $data->nombre,
                            'telefono' => $data->telefono,
                            'celular' => $data->celular,
                            'direccion' => $data->direccion,
                            'latitud' => $data->latitud,
                            'longitud' => $data->longitud,
                            'updated_at' => Carbon::now()
                        ]);
        if($query){
            return redirect()->route('sucursales_index')->with(['message' => 'Deposito editado exitosamenete.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('sucursales_index')->with(['message' => 'Ocurrio un problema al editar el deposito.', 'alert-type' => 'error']);
        }
    }

    public function delete(Request $data){

    }
}
