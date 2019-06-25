<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProveedoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_proveedor($nit){
        $proveedor = DB::table('proveedores')
                        ->select('nombre')
                        ->where('nit', $nit)
                        ->first();
        if($proveedor){
            return $proveedor->nombre;
        }
        return null;
    }

}
