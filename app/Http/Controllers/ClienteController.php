<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\LogCarimbo;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClienteController extends Controller
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
                $clientes = Cliente::
                where('empresa_id', $user->empresa_id)
                ->get();

                foreach($clientes as $c){
                    $c->cartoes;

                    $ultimoCartao = $c->cartoes()->latest('update_at')->first();
                    if ($ultimoCartao) {
                        $c->ultimoCorte = Carbon::parse($ultimoCartao->updated_at)
                        ->format('d/m/Y H:i');
                    } else {
                        $c->ultimoCorte = null;
                    }

                    $c->totalCortes = LogCarimbo::
                    join('cartao_fidelidades', 'cartao_fidelidades.id' , '=', 'log_carimbos.cartao_id')
                    ->where('cliente_id', $c->id)
                    ->count();
                }
        
                return response()->json($clientes);
    
            } else {
                return response()->json(['error' => 'User not found'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao carregar clientes'], 500);
        }
    }

    public function store(Request $request){
        try {
            $user = JWTAuth::user();

            if($user){
                $data = $request->all();
                $data['empresa_id'] = $user->empresa_id;
    
                $result = Cliente::create($data);
 
                return response()->json($result);
            } else {
                return response()->json(['error' => 'User not found'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao salvar cliente'], 500);
        }

    }


}
