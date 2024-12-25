<?php

namespace App\Http\Controllers;

use Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function recuperaInformacaoGrafico()
    {
        try {
            $categoriasUsuario = collect(Auth::user()->categorias);
            $user = Auth::user();

            //busca o total de despesas por categoria
            $despesasUsuario = $user->getTotalDespesaByCategoria();
            
            $data = $despesasUsuario->mapWithKeys(function ($transacao) use ($categoriasUsuario) {
                $categoriaInfo = $categoriasUsuario->firstWhere('nome', $transacao->categoria);
                return [
                    $transacao->categoria => [
                        'categoria' => $transacao->categoria,
                        'total' => $transacao->total,
                        'color' => $categoriaInfo['color']
                    ]
                ];
            });

            return response()->json($data); // Retorna os dados como JSON
        } catch (\Exception $e) {
            \Log::error("Erro ao recuperar informações do gráfico", [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'request' => request()->all()
            ]);
            return response()->json(['error' => 'Ocorreu um erro ao recuperar as informações do gráfico.'], 500);
        }
    }
}
