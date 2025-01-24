<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Empresa;
use App\Models\User;

class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     // Valida os dados fornecidos pelo usuário
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6|confirmed',
    //     ]);

    //     // Cria o usuário no banco de dados
    //     $user = User::create([
    //         'name' => $validatedData['name'],
    //         'email' => $validatedData['email'],
    //         'password' => Hash::make($validatedData['password']),
    //     ]);

    //     // Após criar o usuário, faça login automaticamente
    //     $token = JWTAuth::fromUser($user);

    //     return response()->json([
    //         'message' => 'Usuário registrado com sucesso',
    //         'token' => $token,
    //         'user' => $user
    //     ], 201);
    // }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais inválidas'], 401);
            }

        } catch (JWTException $e) {
            return response()->json(['error' => 'Não foi possível criar o token'], 500);
        }

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
    {
        JWTAuth::invalidate($request->token);
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    public function validaToken(){
        $user = JWTAuth::user(); 
        
        return response()->json($user);
    }

    public function criaUsuarioMaster()
    {
        $empresas = Empresa::first();
        if(!$empresas){
            $empresaMaster =  Empresa::create([
                'nome' => 'ADM System'
            ]);

            $userMaster = User::create([
                'empresa_id' => $empresaMaster->id,
                'name' => 'User ADM',
                'password' => bcrypt('12345'),
                'email' => 'victor7_oliveira@hotmail.com'
            ]);

            if($empresaMaster && $userMaster){
                return response()->json('Criado com sucesso');
            }else {
                return response()->json('Erro');
            }
        }
    }

}
