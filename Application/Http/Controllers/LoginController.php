<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
        
    public function index(Request $request)
    {
        $error_message = '';
        
        if ($request->email and $request->password) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->intended('/');
            } else {
                $error_message = "User not found";
            }
        }
        
        return view('layouts/base', [
            'content' => view('login', [
                'error_message' => $error_message
            ]),
            'title' => 'title'
        ]);
    }
}
