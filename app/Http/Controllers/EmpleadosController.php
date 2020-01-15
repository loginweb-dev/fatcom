<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Empleado;
use App\Sucursale;
use App\UsersSucursale;

class EmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $registros = DB::table('empleados as e')
                            ->join('users as u', 'u.id', 'e.user_id')
                            ->join('roles as r', 'r.id', 'u.role_id')
                            ->select('e.*', 'e.deleted_at as sucursal', 'u.name as usuario', 'u.email', 'u.avatar', 'u.tipo_login', 'r.display_name as rol')
                            ->where('e.deleted_at', NULL)
                            ->orderBy('id', 'DESC')
                            ->paginate(10);
        $cont = 0;
        foreach ($registros as $item) {
            // Agregar sucursal si está asignada
            $aux = $sucursal_user = DB::table('users_sucursales as us')
                                        ->join('sucursales as s', 's.id', 'us.sucursal_id')
                                        ->select('s.nombre')->where('us.user_id', $item->user_id)->where('us.deleted_at', NULL)->first();
            $registros[$cont]->sucursal = $aux ? $aux->nombre : 'No asiganada';
            $cont++;
        }

        $value = '';
        return view('empleados.empleados_index', compact('registros', 'value'));
    }

    public function search($value)
    {
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('empleados as e')
                            ->select('e.*', 'e.deleted_at as sucursal')
                            ->where('e.deleted_at', NULL)
                            ->whereRaw("    (e.nombre like '%".$value."%' or
                                             e.movil like '%".$value."%')
                                        ")
                            ->orderBy('id', 'DESC')
                            ->paginate(10);
                            $cont = 0;
        foreach ($registros as $item) {
            $aux = $sucursal_user = DB::table('users_sucursales as us')
                                        ->join('sucursales as s', 's.id', 'us.sucursal_id')
                                        ->select('s.nombre')->where('us.user_id', $item->user_id)->where('us.deleted_at', NULL)->first();
            $registros[$cont]->sucursal = $aux ? $aux->nombre : 'No asiganada';
            $cont++;
        }

        $users = [];
        foreach ($registros as $item) {
            $aux =  DB::table('users as u')
                            ->select('u.*')
                            ->where('u.id', $item->user_id)
                            ->first();
            if($aux){
                $user = ['usuario'=>$aux->name,'email'=>$aux->email,'avatar'=>$aux->avatar,'tipo_login'=>$aux->tipo_login];
            }else{
                $user = ['usuario'=>'No definido','email'=>'No definido','avatar'=>'','tipo_login'=>''];
            }
            array_push($users, $user);
        }
        return view('empleados.empleados_index', compact('registros', 'users', 'value'));
    }

    public function create(){
        $roles = DB::table('roles as r')
                        ->select('r.*')
                        ->where('r.id', '>', 2)
                        ->get();
        $sucursales = Sucursale::where('deleted_at', NULL)->select('id', 'nombre')->get();
        return view('empleados.empleados_create', compact('roles', 'sucursales'));
    }

    public function store(Request $data){

        $data->validate([
            'nombre' => 'required|max:50',
            'movil' => 'max:20',
            'direccion' => 'required|max:150',
            'nickname' => 'required|max:20',
            'email' => 'required|unique:users|max:50',
            'password' => 'required|max:20',
            'rol_id' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data->nickname,
                'email' => $data->email,
                'role_id' => $data->rol_id,
                'password' => Hash::make($data->password),
                'avatar' => 'users/default.png',
                'tipo_login' => 'dashboard'
            ]);

            UsersSucursale::create([
                'user_id' => $user->id,
                'sucursal_id' => $data->sucursal_id,
            ]);

            Empleado::create([
                'nombre' => $data->nombre,
                'movil' => $data->movil,
                'direccion' => $data->direccion,
                'user_id' => $user->id,
            ]);

            DB::commit();
            return redirect()->route('empleados_index')->with(['message' => 'Empleado registrado exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('empleados_index')->with(['message' => 'Ocurrio un error al registrar al empleado.', 'alert-type' => 'error']);
        }
    }

    public function edit($id){
        $roles = DB::table('roles as r')
                        ->select('r.*')
                        ->where('r.id', '>', 2)
                        ->get();
        $sucursales = Sucursale::where('deleted_at', NULL)->select('id', 'nombre')->get();
        $empleado = DB::table('empleados as e')
                        ->join('users as u', 'u.id', 'e.user_id')
                        ->select('e.*', 'u.id as user_id', 'u.name', 'u.email', 'u.role_id')
                        ->where('e.id', $id)
                        ->first();
        $sucursal_user = DB::table('users_sucursales')->select('sucursal_id')->where('user_id', $empleado->user_id)->where('deleted_at', NULL)->first();
        return view('empleados.empleados_edit', compact('empleado', 'roles', 'sucursales', 'sucursal_user'));
    }

    public function update(Request $data){
        $data->validate([
            'nombre' => 'required|max:50',
            'movil' => 'max:20',
            'direccion' => 'required|max:150',
            'nickname' => 'required|max:20',
            'email' => 'required|max:50',
            'password' => 'max:20',
            'rol_id' => 'required'
        ]);

        $empleados =  Empleado::where('id', $data->id)
                                ->update([
                                    'nombre' => $data->nombre,
                                    'movil' => $data->movil,
                                    'direccion' => $data->direccion,
                                ]);

        $user = User::find($data->user_id);
        $user->name = $data->nickname;
        $user->role_id = $data->rol_id;
        $user->email = $data->email;
        if(!empty($data->password)){
            $user->password = Hash::make($data->password);
        }
        $user->save();
        $user = User::all()->last()->id;

        $update_sucursal = DB::table('users_sucursales')->where('user_id', $data->user_id)->update(['sucursal_id' => $data->sucursal_id]);
        if(!$update_sucursal){
            UsersSucursale::create([
                'user_id' => $data->user_id,
                'sucursal_id' => $data->sucursal_id,
            ]);
        }

        if($user && $empleados){
            return redirect()->route('empleados_index')->with(['message' => 'Empleado editado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('empleados_index')->with(['message' => 'Ocurrio un error al editar al empleado.', 'alert-type' => 'error']);
        }
    }

    public function delete(Request $data){
        $query =  Empleado::where('id', $data->id)->update(['deleted_at' => Carbon::now()]);
        if($query){
            return redirect()->route('empleados_index')->with(['message' => 'Empleado eliminado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('empleados_index')->with(['message' => 'Ocurrio un error al eliminar al empleado.', 'alert-type' => 'error']);
        }
    }
}
