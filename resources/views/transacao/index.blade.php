@extends('layouts.app') <!-- Ou o nome do seu layout principal -->

@section('content')
<div class="container my-5">
    <!-- Título e botão de nova transação -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary">Transações</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
            <i class="bi bi-plus-circle me-1"></i> Nova Transação
        </button>
    </div>

    <!-- Filtros de transações -->
    <div class="row mb-4">
        <div class="col-md-3">
            <input type="date" class="form-control" placeholder="Data">
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option value="">Categoria</option>
                <option value="alimentacao">Alimentação</option>
                <option value="transporte">Transporte</option>
                <option value="lazer">Lazer</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option value="">Tipo</option>
                <option value="receita">Receita</option>
                <option value="despesa">Despesa</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-secondary w-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-filter me-2"></i>
                Filtrar
            </button>
        </div>

    </div>

    <!-- Tabela de transações -->
    @if (isset($transacoes) && count($transacoes) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transacoes as $transacao)
                        <tr>
                            <td>{{$transacao->getDataFormatada()}}</td>
                            <td>{{$transacao->descricao}}</td>
                            <td>{{$transacao->categoria}}</td>
                            <td @class([
                        'text-danger' => $transacao->tipo === 'despesa',
                        'text-success' => $transacao->tipo === 'receita'
                    ])>{{$transacao->tipo}}</td>
                            <td>{{$transacao->getValorFormatado()}}</td>
                            <td>
                                <button class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhuma transação cadastrada.</p>
    @endif
</div>

<!-- Modal de Nova Transação -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Adicionar Nova Transação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="{{route("transacao-store")}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="date" class="form-label">Data</label>
                        <input type="date" class="form-control" id="date" name="data" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <input type="text" class="form-control" name="descricao" id="description"
                            placeholder="Descrição da transação" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Categoria</label>
                        <select id="category" class="form-select" name="categoria" required>
                            <option value="">Selecione...</option>
                            <option value="alimentacao">Alimentação</option>
                            <option value="transporte">Transporte</option>
                            <option value="lazer">Lazer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipo</label>
                        <select id="type" class="form-select" name="tipo" required>
                            <option value="receita">Receita</option>
                            <option value="despesa">Despesa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Valor</label>
                        <input type="number" class="form-control" name="valor" id="amount"
                            placeholder="Valor da transação" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Adicionar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection