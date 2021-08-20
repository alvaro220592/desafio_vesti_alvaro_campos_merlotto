<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Log; // para os logs

class AuthController extends Controller
{
    public function login(Request $request){
        
        // validação do request:
        $request->validate([
            "email" => 'required|email',
            "password" => 'required'
        ]);

        // Log de registro de operação:
        $user = auth()->user();

        // checando se o usuário existe:
        $user = User::where('email', $request->email)->first();

        // Se o email for incorreto:
        if(! $user){

            Log::channel('logs_loja')->info("Efetuada tentativa de login com email incorreto:$request->email");

            return response()->json(["message" => "Email incorreto"]);
        }

        // Se a senha for incorreta:
        if(! Hash::check($request->password, $user->password)){

            Log::channel('logs_loja')->info("Efetuada tentativa de login com senha incorreta pelo email $request->email");

            return response()->json(["message" => "Senha incorreta"]);
        }

        // se tudo estiver ok, será criado um token:
        $token = $user->createToken($request->email.strtotime("now"))->plainTextToken;

        Log::channel('logs_loja')->info("LOGIN efetuado pelo usuário: EMAIL=$request->email");

        return response()->json([
            "access_token" => $token,
            "token_type" => "bearer"
        ]);
    }

    public function logout(Request $request){

        $user = auth()->user();

        Log::channel('logs_loja')->info("LOGOUT efetuado pelo usuário: NOME=$user->name, EMAIL=$user->email");

        // quebrando o token do usuário
        $request->user()->tokens()->delete();

        // retornando a resposta com o status 201 de logout
        return response()->json(["messgae" => "logout"], 201); //

    }


}
