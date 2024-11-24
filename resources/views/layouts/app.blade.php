<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div id="app" class="d-flex">
        <!-- Menu Lateral -->
        @if (Auth::check())
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-white border-end min-vh-100" style="width: 250px;">
                <ul class="nav nav-pills flex-column mb-auto">

                    <!-- Perfil -->
                    <li class="nav-item mb-3 text-center">
                        <div class="d-flex justify-content-center mb-2">
                            <!-- Imagem de perfil redonda -->
                            <img src="{{ Auth::user()->getProfileImage() }}" alt="Foto de perfil de {{ Auth::user()->name }}" class="rounded-circle"
                                style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <!-- Nome do usuário -->
                        <h3 class="text-center fs-5">Olá, {{ Auth::user()->name }}</h3>
                    </li>
                    <hr>
                    <!-- Dashboard -->
                    <li class="nav-item mb-2">
                        <a href="{{route("home")}}" class="nav-link text-dark d-flex align-items-center">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <!-- Transações -->
                    <li class="nav-item mb-2">
                        <a href="{{route("transacao-index")}}" class="nav-link text-dark d-flex align-items-center">
                            <i class="bi bi-card-list me-2"></i> Transações
                        </a>
                    </li>
                    <!-- Relatórios -->
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark d-flex align-items-center">
                            <i class="bi bi-graph-up-arrow me-2"></i> Relatórios
                        </a>
                    </li>
                    <!-- Configurações -->
                    <li class="nav-item mb-2">
                        <a href="{{route('configuracao-index')}}" class="nav-link text-dark d-flex align-items-center">
                            <i class="bi bi-gear me-2"></i> Configurações
                        </a>
                    </li>
                    <!-- Logout -->
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center text-danger fw-semibold px-3 py-2 rounded"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <!-- Ícone de logout -->
                            <i class="bi bi-box-arrow-left me-2"></i>
                            <!-- Texto de logout -->
                            {{ __('Sair') }}
                        </a>
                        <!-- Formulário de logout escondido -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
                <hr>
                <div class="text-muted small">
                    <p class="mb-0">&copy; {{ config('app.name', 'Laravel') }}</p>
                </div>
            </div>
        @endif

        <main class="container-fluid p-4 justify-content-center align-items-center">
            @yield('content')
        </main>
    </div>
</body>

</html>