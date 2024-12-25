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

    public function index(Request $request)
    {

        $filter = new \stdClass();
        $user = Auth::user();

        $query = $this->aplicaFiltros($user->transacoes(), $request);


        $transacoes = $query->paginate(10);

        $categorias = $user->categorias ?? [];
        return view('transacao.index', compact('transacoes', 'categorias'));
    }

    private function aplicaFiltros($query, Request $request)
    {
        if ($request->filled('data')) {
            $query->where('data', $request->data);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        return $query;
    }

    public function store(StoreTrasacaoRequest $request)
    {
        try {
            // Adiciona o ID do usuário autenticado aos dados validados
            $validatedData = $request->validated();
            $validatedData['user_id'] = Auth::id();

            // Cria a transação no banco de dados
            Transacao::create($validatedData);

            return redirect()->route('transacao-index')->with('success', 'Transação cadastrada com sucesso!');
        } catch (\Exception $e) {
            \Log::error("Erro ao cadastrar transação", [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);
            return redirect()->route('transacao-index')->with('erro', 'Algo deu errado ao cadastrar a transação!');
        }
    }

    public function edit(int $transacaoId)
    {
        try {
            $user = Auth::user();
            $transacao = $user->transacoes()->findOrFail($transacaoId);
            $categorias = $user->categorias ?? [];
            return view("transacao.edit", compact("transacao", "categorias"));
        } catch (\Exception $e) {
            \Log::error("Erro ao editar transação", [
                'user_id' => Auth::id(),
                'transacao_id' => $transacaoId,
                'error' => $e->getMessage(),
                'request' => request()->all()
            ]);
            return redirect()->route('transacao-index')->with('erro', 'Erro ao editar a transação!');
        }
    }

    public function update(StoreTrasacaoRequest $request, int $transacaoId)
    {
        try {
            $user = Auth::user();
            $transacao = $user->transacoes()->findOrFail($transacaoId);
            $transacao->update($request->validated());
            return redirect()->route('transacao-index')->with('success', 'Transação atualizada com sucesso!');
        } catch (\Exception $e) {
            \Log::error("Erro ao atualizar transação", [
                'user_id' => Auth::id(),
                'transacao_id' => $transacaoId,
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);
            return redirect()->route('transacao-index')->with('erro', 'Erro ao atualizar a transação!');
        }
    }

    public function delete(int $transacaoId)
    {
        try {
            $user = Auth::user();
            $transacao = $user->transacoes()->findOrFail($transacaoId);
            $transacao->delete();
            return redirect()->route('transacao-index')->with('success', 'Transação deletada com sucesso!');
        } catch (\Exception $e) {
            \Log::error("Erro ao deletar transação", [
                'user_id' => Auth::id(),
                'transacao_id' => $transacaoId,
                'error' => $e->getMessage(),
                'request' => request()->all()
            ]);
            return redirect()->route('transacao-index')->with('erro', 'Erro ao deletar a transação!');
        }
    }
}
