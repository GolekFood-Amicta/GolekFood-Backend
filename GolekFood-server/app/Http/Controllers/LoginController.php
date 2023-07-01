<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function index()
    {
        //
        if(Auth::check()){
            return redirect()->intended('dashboard-admin');
        }
        return view('login');
    }

    


    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        
        if (Auth::attempt($credentials)) {

            if(Auth::user()->roles_id != 2){
                Auth::logout();
                return back()->with([
                    'loginError' => 'Login gagal, Anda tidak mempunyai akses',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            
            return redirect()->intended('dashboard-admin');
        }
 
        return back()->with([
            'loginError' => 'Login gagal, Cek kembali Email dan password anda',
        ])->onlyInput('email');
    }


}
