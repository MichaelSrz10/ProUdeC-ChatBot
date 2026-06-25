<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{ 
    public function create(){
        return view('auth.login');
    }
    public function store(Request $request){
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|string'
            ]
        );
        if(!auth()->attempt($credentials)){
            throw ValidationException::withMessages([
                'email' => 'Credenciales Incorrectas'
            ]);
        }
        $request -> session()->regenerate();//rengenerate

        return redirect()->route('dashboard');
    }
    public function destroy(Request $request){
        Auth::logout();
        $request->session()->invalidate(); //invalidate
        $request->session()->regenerateToken(); //regenerate
        return redirect('/');
    }
}
