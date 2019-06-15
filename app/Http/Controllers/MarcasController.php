<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class MarcasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }

    public function marcas_list($subcategoria_id)
    {
        return DB::table('marcas as m')
                        ->join('productos as p', 'p.marca_id', 'm.id')
                        ->select('m.*')
                        ->where('deleted_at', NULL)
                        ->where('p.subcategoria_id', $subcategoria_id)
                        ->get();
    }
}
