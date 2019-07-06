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
        return view('clientes.clientes_index', compact('registros', 'users', 'value'));
    }

    public function create(){
        return view('clientes.clientes_create');
    }

    public function store(Request $data){
        $data->validate([
            'razon_social' => 'required|max:50',
            'nit' => 'required|unique:clientes|max:20',
            'movil' => 'required|max:20',
            'nickname' => 'required|max:20',
            'email' => 'required|unique:users|max:50',
            'password' => 'required|max:20'
        ]);

        $user = User::create([
            'name' => $data->nickname,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'avatar' => 'users/default.png',
            'tipo_login' => 'dashboard'
        ]);
        Cliente::create([
            'razon_social' => $data->razon_social,
            'nit' => $data->nit,
            'movil' => $data->movil,
            'user_id' => $user->id,
        ]);
        if($user){
            return redirect()->route('clientes_index')->with(['message' => 'Cliente registrado exitosamente.', 'alert-type' => 'success']);
        }else{
            return redirect()->route('clientes_index')->with(['message' => 'Ocurrio un error al registrar al cliente.', 'alert-type' => 'error']);
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
