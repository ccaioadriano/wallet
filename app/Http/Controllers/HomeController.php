<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

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

    public function recuperaInformacaoGrafico(Request $request)
    {

        $categoriasUsuario = collect(Auth::user()->categorias);

        //buscar transações
        $transacoesUsuario = Auth::user()->transacoes()
            ->select('categoria', DB::raw('SUM(valor) as total'))
            ->where('tipo', '=', 'despesa')
            ->groupBy('categoria')->get();

        $data = $transacoesUsuario->mapWithKeys(function ($transacao) use ($categoriasUsuario) {
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
