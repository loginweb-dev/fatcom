<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Empleado;

class EmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $registros = DB::table('empleados as e')
                            ->select('e.*')
                            ->where('e.deleted_at', NULL)
                            ->paginate(10);
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
        $value = '';
        return view('empleados.empleados_index', compact('registros', 'users', 'value'));
    }

    public function create(){
        $roles = DB::table('roles as r')
                        ->select('r.*')
                        ->where('r.id', '>', 2)
                        ->get();
        return view('empleados.empleados_create', compact('roles'));
    }

    public function store(Request $data){

        $data->validate([
            'nombre' => 'required|max:50',
            'movil' => 'max:20',
            'direccion' => 'required|max:150',
            'email' => 'required|unique:users|max:20',
            'password' => 'required|max:20'
        ]);

        $user_id = NULL;
        if(!empty($data->nombre) && !empty($data->email) && !empty($data->email)){
            $user = User::create([
                'name' => $data->nombre,
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'avatar' => 'users/default.png',
                'tipo_login' => 'dashboard'
            ]);
            $user_id = $user->id;
        }

        Empleado::create([
            'nombre' => $data->nombre,
            'movil' => $data->movil,
            'direccion' => $data->direccion,
            'user_id' => $user_id,
        ]);
        if($user){
            return redirect()->route('empleados_index')->with(['message' => 'Empleado registrado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('empleados_index')->with(['message' => 'Ocurrio un error al registrar al empleado.', 'alert-type' => 'error']);
        }
    }

    public function edit($id){
        $cliente = DB::table('clientes as c')
                        ->select('c.*')
                        ->where('c.id', $id)
                        ->first();
        $user = DB::table('clientes as c')
                        ->join('users as u', 'u.id', 'c.user_id')
                        ->select('u.*')
                        ->where('c.id', $id)
                        ->first();
        return view('clientes.clientes_edit', compact('cliente', 'user'));
    }

    public function update(Request $data){
        $data->validate([
            'razon_social' => 'required|max:50',
            'nit' => 'required|max:20',
            'movil' => 'required|max:20',
            'nickname' => 'required|max:20',
            'email' => 'required|max:20',
            'password' => 'max:20'
        ]);
        $cliente =  Cliente::where('id', $data->id)
                                ->update([
                                    'razon_social' => $data->razon_social,
                                    'nit' => $data->nit,
                                    'movil' => $data->movil,
                                ]);
        if(empty($data->user_id)){
            $user = User::create([
                        'name' => $data->name,
                        'email' => $data->email,
                        'password' => Hash::make($data->password),
                        'avatar' => 'users/default.png',
                        'tipo_login' => 'dashboard'
                    ]);
            Cliente::where('id', $data->id)
                        ->update([
                            'user_id' => $user->id
                        ]);
        }else{
            $user = User::find($data->user_id);
            $user->name = $data->nickname;
            $user->email = $data->email;
            if(!empty($data->password)){
                $user->password = Hash::make($data->password);
            }
            $user->save();
            $user = User::all()->last()->id;
        }

        if($user && $cliente){
            return redirect()->route('clientes_index')->with(['message' => 'Cliente editado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('clientes_index')->with(['message' => 'Ocurrio un error al editar al cliente.', 'alert-type' => 'error']);
        }
    }
}
