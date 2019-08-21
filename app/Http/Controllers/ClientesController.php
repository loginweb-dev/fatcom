<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Cliente;

class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $registros = DB::table('clientes as c')
                            ->select('c.*')
                            ->where('c.deleted_at', NULL)
                            ->where('c.id', '>', 1)
                            ->paginate(10);
        $users = [];
        foreach ($registros as $item) {
            $aux =  DB::table('users as u')
                            ->select('u.*')
                            ->where('u.cliente_id', $item->id)
                            ->first();
            if($aux){
                $user = ['usuario'=>$aux->name,'email'=>$aux->email,'avatar'=>$aux->avatar,'tipo_login'=>$aux->tipo_login];
            }else{
                $user = ['usuario'=>'No definido','email'=>'No definido','avatar'=>'','tipo_login'=>''];
            }
            array_push($users, $user);
        }
        $value = '';
        return view('clientes.clientes_index', compact('registros', 'users', 'value'));
    }

    public function search($value)
    {
        $value = ($value != 'all') ? $value : '';
        $registros = DB::table('clientes as c')
                            ->select('c.*')
                            ->where('c.deleted_at', NULL)
                            ->whereRaw("c.id > 1 and
                                            (c.razon_social like '%".$value."%' or
                                             c.nit like '%".$value."%' or
                                             c.movil like '%".$value."%')
                                        ")
                            ->paginate(10);
        $users = [];
        foreach ($registros as $item) {
            $aux =  DB::table('users as u')
                            ->select('u.*')
                            ->where('u.cliente_id', $item->id)
                            ->first();
            if($aux){
                $user = ['usuario'=>$aux->name,'email'=>$aux->email,'avatar'=>$aux->avatar,'tipo_login'=>$aux->tipo_login];
            }else{
                $user = ['usuario'=>'No definido','email'=>'No definido','avatar'=>'','tipo_login'=>''];
            }
            array_push($users, $user);
        }

        return view('clientes.clientes_index', compact('registros', 'users', 'value'));
    }

    public function create(){
        return view('clientes.clientes_create');
    }

    public function store(Request $data){
        $data->validate([
            'razon_social' => 'required|max:50',
            'nit' => 'max:20',
            'movil' => 'max:20',
            'nickname' => 'max:20',
            'email' => 'unique:users|max:50',
            'password' => 'max:20'
        ]);

        $cliente = Cliente::create([
            'razon_social' => $data->razon_social,
            'nit' => $data->nit,
            'movil' => $data->movil
        ]);
        
        if(!empty($data->email) && !empty($data->password)){
            User::create([
                'name' => !empty($data->nickname) ? $data->nickname : $data->razon_social,
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'avatar' => 'users/default.png',
                'tipo_login' => 'dashboard',
                'cliente_id' => $cliente->id
            ]);
        }

        $ruta = (isset($data->permanecer)) ? 'clientes_create' : 'clientes_index';

        if($cliente){
            return redirect()->route($ruta)->with(['message' => 'Cliente registrado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route($ruta)->with(['message' => 'Ocurrio un error al registrar al cliente.', 'alert-type' => 'error']);
        }
    }

    public function edit($id){
        $cliente = DB::table('clientes as c')
                        ->select('c.*')
                        ->where('c.id', $id)
                        ->first();
        $user = DB::table('clientes as c')
                        ->join('users as u', 'u.cliente_id', 'c.id')
                        ->select('u.*')
                        ->where('c.id', $id)
                        ->first();
        return view('clientes.clientes_edit', compact('cliente', 'user'));
    }

    public function update(Request $data){
        $data->validate([
            'razon_social' => 'required|max:50',
            'nit' => 'max:20',
            'movil' => 'max:20',
            'nickname' => 'max:20',
            'email' => 'max:50',
            'password' => 'max:20'
        ]);
        $cliente =  Cliente::where('id', $data->id)
                                ->update([
                                    'razon_social' => $data->razon_social,
                                    'nit' => $data->nit,
                                    'movil' => $data->movil,
                                ]);
        


        if(empty($data->user_id)){
            if(!empty($data->email) && !empty($data->password)){
                $user = User::create([
                            'name' => !empty($data->nickname) ? $data->nickname : $data->razon_social,
                            'email' => $data->email,
                            'password' => Hash::make($data->password),
                            'avatar' => 'users/default.png',
                            'tipo_login' => 'dashboard',
                            'cliente_id' => $data->id
                        ]);
            }
        }else{
            if(!empty($data->nickname) && !empty($data->email)){
                $user = User::find($data->user_id);
                $user->name = $data->nickname;
                $user->email = $data->email;
                if(!empty($data->password)){
                    $user->password = Hash::make($data->password);
                }
                $user->save();
            }
        }

        if($cliente){
            return redirect()->route('clientes_index')->with(['message' => 'Cliente editado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('clientes_index')->with(['message' => 'Ocurrio un error al editar al cliente.', 'alert-type' => 'error']);
        }
    }

    // =================================================

    // Obtener lista de clientes
    public function clientes_list(){
        return Cliente::where('deleted_at', NULL)->select(DB::raw("id, CONCAT(razon_social, CASE WHEN movil is NULL THEN '' ELSE CONCAT(' CEL:', movil) END) as nombre"))->get();
    }

    public function get_cliente($id){
        return Cliente::find($id);
    }

    // Crear un usuario desde el formulario de nueva venta
    public function createUserFromVentas(Request $data){
        return $cliente = Cliente::create([
                                'razon_social' => $data->razon_social,
                                'nit' => $data->nit,
                                'movil' => $data->movil
                            ]);
    }
}
