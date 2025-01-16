<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmpresaController extends Controller
{
    public function __construct(Request $request){

        try {
            $this->middleware('auth:api');
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao processar a requisição'], 500);
        }
	}

    public function index()
    {
        try {
            $user = JWTAuth::user();

            if($user){
                $empresas = Empresa::get();
        
                return response()->json($empresas);
    
            } else {
                return response()->json(['error' => 'User not found'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao carregar empresas'], 500);
        }
    }

    public function store(Request $request){
        try {
            $user = JWTAuth::user();

            if($user){
                $data = $request->all();
                $data['empresa_id'] = $user->empresa_id;
    
                $result = Empresa::create([
                    'nome' => $data['nomeEmpresa']
                ]);

                if($result){
                    User::create([
                        'empresa_id' => $result->id,
                        'name' => $data['nomeUsuario'],
                        'password' => bcrypt($data['senhaUsuario']),
                        'email' => $data['emailUsuario']
                    ]);
                }
 
                return response()->json($result);
            } else {
                return response()->json(['error' => 'User not found'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao salvar cliente'], 500);
        }

    }
}
