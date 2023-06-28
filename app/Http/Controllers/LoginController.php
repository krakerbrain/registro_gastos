<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function show()
    {
        if(Auth::check()){
            return redirect('/gastos');
        }
        return view ('login.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
        $remember = $request->has('remember'); // Verifica si se seleccionó "Recordarme"
    
        if (Auth::attempt($credentials, $remember)) {
            // Autenticación exitosa
            return $this->authenticated($request, Auth::user());
        }
    
        // Autenticación fallida
        return redirect()->to('/login')->withErrors('login.failed');
    }

    public function authenticated(Request $request, $user)
    {
        return redirect('/gastos');
    }
}