@extends('layouts.app') <!-- Ou o nome do seu layout principal -->

@section('content')
<div class="container my-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center mb-4">Formulário de Edição de Transação</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('transacao-update', $transacao->id) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        <!-- Data -->
                        <div class="col-md-6">
                            <label for="date" class="form-label">Data</label>
                            <input type="date" class="form-control" id="date" name="data"
                                value="{{ old('data', \Carbon\Carbon::parse($transacao->data)->format('Y-m-d')) }}">
                        </div>

                        <!-- Descrição -->
                        <div class="col-md-6">
                            <label for="description" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="description" name="descricao"
                                placeholder="Descrição da transação"
                                value="{{ old('descricao', $transacao->descricao) }}">
                        </div>

                        <!-- Categoria -->
                        <div class="col-md-6">
                            <label for="category" class="form-label">Categoria</label>
                            <select id="category" class="form-select" name="categoria">
                                <option value="">Selecione...</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{$transacao['categoria']}}" {{  old('categoria', $transacao['categoria']) == $categoria['nome'] ? 'selected' : '' }}>
                                        {{$categoria['nome']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tipo -->
                        <div class="col-md-6">
                            <label for="type" class="form-label">Tipo</label>
                            <select id="type" class="form-select" name="tipo">
                                <option value="receita" {{ old('tipo', $transacao->tipo) == 'receita' ? 'selected' : '' }}>Receita</option>
                                <option value="despesa" {{ old('tipo', $transacao->tipo) == 'despesa' ? 'selected' : '' }}>Despesa</option>
                            </select>
                        </div>

                        <!-- Valor -->
                        <div class="col-12">
                            <label for="amount" class="form-label">Valor</label>
                            <input type="text" class="form-control" id="amount" name="valor"
                                placeholder="Valor da transação" value="{{ old('valor', $transacao->valor)}}">
                        </div>

                        <!-- Botão -->
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary w-20 float-end">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection