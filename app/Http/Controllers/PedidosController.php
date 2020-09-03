<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Sucursale;
use App\UsersSucursale;
use App\Cliente;
use App\IeCaja;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;

class PedidosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // Obetener el tamaño de la factura o recibo
         $tamanio = DB::table('settings')
         ->select('value')
         ->where('id', 26)
         ->first()->value;

        $delivery = DB::table('empleados as e')
                ->join('users as u', 'u.id', 'e.user_id')
                ->select('e.*', 'u.name as nombre')
                // Repartidores es rol 7
                ->where('u.role_id', 7)
                ->where('e.deleted_at', NULL)
                ->get();

        // Obtener ultima sucursal del usuario
        $sucursal_actual = $this->get_user_sucursal();

        $sucursales = Sucursale::where('deleted_at', NULL)->select('id', 'nombre')->get();

        // Verificar si el usuario tiene permiso de cambiar de sucursal
        $cambiar_sucursal = false;
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3){
        $cambiar_sucursal = true;
        }

        $value = '';
        return view('pedidos.index', compact('value', 'delivery', 'tamanio', 'sucursal_actual', 'sucursales', 'cambiar_sucursal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $data)
    {
        // Obetener el tamaño de la factura o recibo
        $tamanio = DB::table('settings')
                            ->select('value')
                            ->where('id', 26)
                            ->first()->value;
        // Obtener ultima sucursal del usuario
        $sucursal_actual = $this->get_user_sucursal();

        $sucursales = Sucursale::where('deleted_at', NULL)->select('id', 'nombre')->get();

        // Verificar si el usuario tiene permiso de cambiar de sucursal
        $cambiar_sucursal = false;
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3){
            $cambiar_sucursal = true;
        }

        $categorias = DB::table('categorias as c')
                            ->join('subcategorias as s', 's.categoria_id', 'c.id')
                            ->join('productos as p', 'p.subcategoria_id', 's.id')
                            ->select('c.*')
                            ->where('p.deleted_at', NULL)
                            ->where('c.deleted_at', NULL)
                            ->where('c.id', '>', 1)
                            ->distinct()
                            ->get();

        // En caso de recibir un variable de tipo Request la asignamos a proforma_id
        $proforma_id = $data->query('proforma');
        return view('pedidos.create', compact('categorias', 'tamanio', 'sucursales', 'sucursal_actual', 'proforma_id', 'cambiar_sucursal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $data)
    {
         // validar si exiten productos en la venta
         if(!isset($data->producto_id)){
            return null;
        }
        // Actualizar nit del cliente si lo editó y si no es el cliente por defecto
        if($data->cliente_id > 1){
            $cliente = Cliente::find($data->cliente_id);
            $cliente->nit = $data->nit;
            $cliente->save();
        }

        // insertar y obtener el ultimo pedido
        $pedido_id = $this->crear_pedido($data);

        // insertar detalle del pedido
        if($pedido_id != ''){
            for ($i=0; $i < count($data->producto_id); $i++) {
                if(!is_null($data->producto_id[$i])){
                    
                    $detalle_pedido = DetallePedido::create([
                        'pedido_id' => $pedido_id,
                        'producto_id' => $data->producto_id[$i],
                        'precio' => $data->precio[$i],
                        'cantidad' => $data->cantidad[$i],
                        'observacion' => $data->observacion[$i]
                    ]);
                }
            }
            return $pedido_id;
        }else{
            return null;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Pedido::findOrFail($id);
        return view('pedidos.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
    // Obtener la sucursal asignada al empleado (Si no tiene ninguna se le asigna para evitar erro 500)
    public function get_user_sucursal(){
        $sucursal_user = DB::table('users_sucursales')->select('sucursal_id')->where('user_id', Auth::user()->id)->where('deleted_at', NULL)->first();
        if($sucursal_user){
            $sucursal_actual = $sucursal_user->sucursal_id;
        }else{
            $sucursal_actual = Sucursale::all()->first()->id;
            UsersSucursale::create([
                'user_id' => Auth::user()->id,
                'sucursal_id' => $sucursal_actual,
            ]);
        }
        return $sucursal_actual;
    }
    public function pedidos_list($sucursal_id, $search){
        $filtro_sucursal = $sucursal_id != 'all' ? "p.sucursal_id = $sucursal_id" : 1;

        $filtro_search = $search != 'all' ? "(  c.razon_social like '%".$search."%')" : 1;

        $registros = DB::table('pedidos as p')
                            ->join('clientes as c', 'c.id', 'p.cliente_id')
                            ->select('p.*', 'c.razon_social as cliente', 'c.movil as cliente_movil')
                            ->whereRaw($filtro_sucursal)
                            ->whereRaw($filtro_search)
                            ->orderBy('p.id', 'DESC')
                            ->paginate(20);
        return view('pedidos.partials.pedidos_lista', compact('registros'));
    }

    // Función creada para utilizarla tanto para crear una venta normal o realizar un pedido por parte de un cliente
    public function crear_pedido($data){
        $subtotal = $data->importe;
        $descuento = isset($data->descuento) ? $data->descuento : 0;
        $importe_base = $subtotal - $descuento;
        $pedido = new Pedido;

        $pedido->sucursal_id = $data->sucursal_id;
        $pedido->cliente_id = $data->cliente_id;
        $pedido->estado = 'R';
        $pedido->total = $importe_base;
        $pedido->user_id = auth()->user()->id;
        $pedido->observacion = $data->observacion;
        $pedido->save();

        return $pedido->id;
    }
}
