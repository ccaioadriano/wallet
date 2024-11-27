<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrasacaoRequest;
use App\Models\Transacao;
use Auth;
use Illuminate\Http\Request;

class TransacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $user = Auth::user();
        $transacoes = $user->transacoes()->orderBy(column: 'data', direction: 'asc')->get();
        $categorias = $user->categorias ?? [];

        return view(view: "transacao.index", data: compact(var_name: ["transacoes", "categorias"]));
    }

    public function store(StoreTrasacaoRequest $request)
    {
        // Adiciona o ID do usuário autenticado aos dados validados
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();

        // Cria a transação no banco de dados
        if(!Transacao::create($validatedData)){
            return redirect()->route('transacao-index')->with('erro', 'Algo deu errado ao cadastrar a transação!');
        }

        return redirect()->route('transacao-index')->with('success', 'Transação cadastrada com sucesso!');
    }
}
