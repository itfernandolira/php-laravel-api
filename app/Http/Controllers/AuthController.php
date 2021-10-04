<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {

        //autenticação (email e password)
        $credenciais=$request->all(['email','password']);

        $token=auth('api')->attempt($credenciais);
        //dd($token);

        if ($token) {
            //user autenticado com sucesso
            return response()->json(['token'=>$token]);
        } else {
            return response()->json(['erro'=>'Email ou password incorretos!'],403);
            //401 - pode estar autenticado mas não autenticado!
        }

        //retornar um Json Web Token
        return 'login';
    }

    public function logout() {
        return 'logout';
    }

    public function refresh() {
        //return 'refresh';
        $token=auth('api')->refresh(); //cliente tem de encaminhar um token válido
        return response()->json(["toker"=>$token]);
    }

    public function me() {
        //return 'me';

        //dd(auth()->user());

        return response()->json(auth()->user());
    }
}
