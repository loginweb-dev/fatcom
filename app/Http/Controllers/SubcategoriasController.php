<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Subcategoria;

class SubcategoriasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }

    public function create_new($nombre)
    {
        $subcategoria = new Subcategoria;
        $subcategoria->nombre = $nombre;
        $subcategoria->save();
        return Subcategoria::all();
    }
}
