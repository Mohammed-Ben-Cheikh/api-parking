<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(){
        return $this->succes('','User logged in successfully');
    }

    public function register(Request $request){ 
        return $this->succes($request->all(), 'User registered successfully');
    }

    public function logout(Request $request){ 
        return $this->succes($request->all(), 'User logout successfully');
    }
}
