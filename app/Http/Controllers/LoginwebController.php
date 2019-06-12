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
}
