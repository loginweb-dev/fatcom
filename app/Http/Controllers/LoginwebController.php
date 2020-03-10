<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginwebController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public static function userAgent(){
        $miuseragent=$_SERVER['HTTP_USER_AGENT'];
        $moviles=array("Mobile","iPhone","iPod","BlackBerry","Opera Mini","Sony","MOT","Nokia","samsung");
        $detector=0;
        $numMoviles=count($moviles);
        for ($i=0;$i<$numMoviles;$i++) {
            $comprobar=strpos($miuseragent,$moviles[$i]);
            if ($comprobar!="") {
                $detector=1;
            }
        }
        if ($detector==1) {
            return 'movil';
        }else{
            return 'pc';
        }
    }

    public function distanciaEnKm($point1_lat, $point1_long, $point2_lat, $point2_long) {
        // Cálculo de la distancia en grados
        $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
        $distance = $degrees * 111.13384;
        return round($distance, 2);
    }
}
