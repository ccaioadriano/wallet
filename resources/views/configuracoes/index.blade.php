@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Configurações</h2>

    <div class="row">

        <!-- Fomulário para adicionar uma nova categoria -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    Adicionar Categoria
                </div>
                <div class="card-body">
                    <form action="{{ route('adiciona-categoria') }}" method="POST">
                        @csrf


                        <div class="mb-3">
                            <label for="categoriaNome" class="form-label">Nome da categoria</label>
                            <input type="text" name="categoriaNome" id="categoriaNome" class="form-control" required>
                        </div>

                        <div class="mb-3 w-25">
                            <label for="color" class="form-label">Cor</label>
                            <input type="color" name="color" id="color" class="form-control" value="#e66465">
                        </div>

                        <button type="submit" class="btn btn-danger">Adicionar categoria</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection