<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 

class RegistroUsuario extends Controller
{
    //
    public function show(){
        if(Auth::check()){
            return redirect('/gastos');
        }
        return view("login.register");
    }

    public function register(RegisterRequest $request){
        $user = User::create($request->validated());
        return redirect('/login')->with('success', 'Account created successfully');
    }
}
