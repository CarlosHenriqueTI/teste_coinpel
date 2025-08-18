<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CoinPel</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="d-flex">
        @include('layouts.sidebar')

        <div class="w-100">
            {{-- A estrutura da barra de navegação --}}
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3">
                <div class="container-fluid px-4">
                    {{-- Esta é a área que será preenchida pelos botões de cada página --}}
                    @yield('header-actions')

                    <div class="d-flex align-items-center ms-auto">
                        {{-- Formulário de Pesquisa --}}
                        <form class="d-flex" role="search">
                            <div class="input-group">
                                <input class="form-control" type="search" placeholder="Pesquisar..." aria-label="Search">
                                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>

                        {{-- Ícone de Notificações --}}
                        <ul class="navbar-nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link position-relative" href="#">
                                    <i class="bi bi-bell fs-5"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                </a>
                            </li>
                        </ul>

                        {{-- Dropdown do Utilizador --}}
                        <div class="dropdown ms-4">
                            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://i.pravatar.cc/40?u={{ auth()->user()->id }}" alt="" width="40" height="40" class="rounded-circle">
                                <div class="ms-2 text-start">
                                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">Administrador</div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard') }}"><i class="bi bi-people me-2"></i> Usuários</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i> Sair
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Área de Conteúdo Principal --}}
            <main>
                <div class="container-fluid px-0">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    
    {{-- Stack de scripts personalizados --}}
    @stack('scripts')
</body>
</html>
