<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegistroUsuario extends Controller
{
    //
    public function show(){
        return view("login.register");
    }

    public function register(RegisterRequest $request){
        $user = User::create($request->validated());
        return redirect('/login')->with('success', 'Account created successfully');
    }
}
