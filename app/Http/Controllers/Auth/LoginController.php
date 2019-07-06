<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtiene la información de Facebook
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderFacebookCallback()
    {
        $auth_user = Socialite::driver('facebook')->user(); // Fetch authenticated user
        if($auth_user){
            if(!empty($auth_user->email)){
                $user = User::where('email', $auth_user->email)->first();

                if($user){
                    Auth::login($user, true);
                }else{
                    $user = User::create([
                                'name' => $auth_user->name,
                                'email' => $auth_user->email,
                                'password' => Hash::make(str_random(10)),
                                'avatar' => $auth_user->avatar,
                                'tipo_login' => 'facebook'
                            ]);
                    Cliente::create([
                        'razon_social' => $auth_user->name,
                        'user_id' => $user->id,
                    ]);

                    Auth::login($user, true);
                }
                return redirect()->route('ecommerce_home');
            }
        }
    }
}
