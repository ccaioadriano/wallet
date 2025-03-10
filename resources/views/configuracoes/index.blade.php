@extends('layouts.app')

@section('content')
<div class="my-5">
    <h2 class="mb-4">Configurações</h2>

    <div class="row">

        <!-- Fomulário para adicionar uma nova categoria -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <span class="fw-bold">Adicionar categoria</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('configuracao-adiciona-categoria') }}" method="POST">
                        @csrf


                        <div class="mb-3">
                            <label for="categoriaNome" class="form-label">Nome da categoria</label>
                            <input type="text" name="categoriaNome" id="categoriaNome" class="form-control" required>
                        </div>

                        <div class="mb-3 w-25">
                            <label for="color" class="form-label">Cor</label>
                            <input type="color" name="color" id="color" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary float-end">Adicionar categoria</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Fomulário para atualizar a foto de perfil -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <span class="fw-bold">Atualizar foto de perfil</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('configuracao-atualiza-foto-perfil') }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="row mb-3">
                            <input id="profile_image" type="file"
                                class="form-control @error('profile_image') is-invalid @enderror" name="profile_image">

                        </div>
                        <button type="submit" class="btn btn-primary float-end">Atualizar imagem</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function randomColor() {
        // Gera um número aleatório entre 0 e 16777215 (0xFFFFFF em hexadecimal)
        const randomNum = Math.floor(Math.random() * 16777215);

        // Converte o número para hexadecimal e garante que tenha 6 dígitos
        const hexColor = "#" + randomNum.toString(16).padStart(6, "0");
        return hexColor;
    }
    $(document).ready(function () {
        $("#color").val(randomColor())
    })
</script>
@endsection