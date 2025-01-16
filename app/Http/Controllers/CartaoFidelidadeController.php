<?php

namespace App\Http\Controllers;

use App\Models\CartaoFidelidade;
use App\Models\LogCarimbo;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class CartaoFidelidadeController extends Controller
{
    public function __construct(Request $request){

        try {
            $this->middleware('auth:api');
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao processar a requisição'], 500);
        }
	}

    public function carimbar(Request $request){
        try {
            $user = JWTAuth::user();

            if($user){
                $cartao = CartaoFidelidade::find($request->id);

                if($cartao->qtd_carimbos < 10){
                    $cartao->qtd_carimbos = (int) $cartao->qtd_carimbos + 1;

                    $ultimoCorte = LogCarimbo::create([
                        'usuario_id' => $user->id,
                        'cartao_id' => $cartao->id,
                        'referencia' => 'carimbo ' . $cartao->qtd_carimbos
                    ]);
                } else {
                    $cartao->finalizado = 1;

                    $ultimoCorte =  LogCarimbo::create([
                        'usuario_id' => $user->id,
                        'cartao_id' => $cartao->id,
                        'referencia' => 'cartao finalizado'
                    ]);

                    $newCartao = CartaoFidelidade::create([
                        'cliente_id' => $cartao->cliente_id,
                        'finalizado' => 0,
                        'qtd_carimbos' => 0
                    ]);
                }

                $totalCortes = LogCarimbo::
                join('cartao_fidelidades', 'cartao_fidelidades.id' , '=', 'log_carimbos.cartao_id')
                ->where('cliente_id', $cartao->cliente_id)
                ->count();

                $ultimoCorte = Carbon::parse($ultimoCorte->updated_at)
                ->format('d/m/Y H:i');
                
                $result = $cartao->save();

                if ($result) {
                    return response()->json([
                        'cartao' => $cartao,
                        'newCartao' => $newCartao ?? null,
                        'totalCortes' => $totalCortes,
                        'ultimoCorte' => $ultimoCorte
                    ]);
                }
            } else {
                return response()->json(['error' => 'User not found'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao carimbar cartao'], 500);
        }
    }
}
