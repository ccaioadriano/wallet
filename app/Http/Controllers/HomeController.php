<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
    }
}
