<?php

namespace App\Http\Controllers;

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
        $transacoes = Auth::user()->transacoes()->get();
        return view(view: "transacao.index", data: compact(var_name: "transacoes"));
    }

    public function store(Request $request)
    {
        $transacao = new Transacao();
        $transacao->data = $request->input('data');
        $transacao->descricao = $request->input('descricao');
        $transacao->categoria = $request->input('categoria');
        $transacao->tipo = $request->input('tipo');
        $transacao->valor = $request->input('valor');
        $transacao->user_id = Auth::user()->id;
        $transacao->save();
        return redirect()->route('transacao-index')->with('success', 'Transação cadastrada com sucesso!');
    }
}
