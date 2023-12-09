<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // dd($request->all());
        $email = $request->get('email');
        $password = $request->get('password');

        if(Auth::attempt(['email' => $email, 'password' => $password])){
            //this means the user credentials is correct

            $user = Auth::user();

            return redirect('dashboard');
        }

        return redirect()->back()->withErrors(['message' => 'The credentials are incorrect.']);
        
    }

}
