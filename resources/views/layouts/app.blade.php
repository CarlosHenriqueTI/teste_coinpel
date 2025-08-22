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
    <div class="d-flex" style="overflow: visible !important; height: 100vh;">
        @include('layouts.sidebar')

        <div class="w-100" style="overflow: visible !important;">
            {{-- A estrutura da barra de navegação --}}
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom" style="padding: 1rem 0;">
                <div class="container-fluid" style="padding-left: 0; padding-right: 0;">
                    {{-- Esta é a área que será preenchida pelos botões de cada página --}}
                    <div style="padding-left: 1.5rem;">
                        @yield('header-actions')
                    </div>

                    <div class="d-flex align-items-center ms-auto" style="padding-right: 1.5rem;">
                        {{-- Formulário de Pesquisa --}}
                        <form class="d-flex me-4" role="search" method="GET" action="{{ request()->url() }}">
                            <div class="input-group" style="width: 300px;">
                                @php
                                    $searchPlaceholder = 'Pesquisar';
                                    if (request()->routeIs('users.*')) {
                                        $searchPlaceholder = 'Pesquisar usuário';
                                    } elseif (request()->routeIs('trips.*')) {
                                        $searchPlaceholder = 'Pesquisar viagem';
                                    } elseif (request()->routeIs('drivers.*')) {
                                        $searchPlaceholder = 'Pesquisar motorista';
                                    } elseif (request()->routeIs('vehicles.*')) {
                                        $searchPlaceholder = 'Pesquisar veículo';
                                    }
                                @endphp
                                <input class="form-control" type="search" name="search" placeholder="{{ $searchPlaceholder }}" aria-label="Search" 
                                       value="{{ request('search') }}"
                                       style="border: 1px solid #e2e8f0; border-radius: 8px 0 0 8px; padding: 0.75rem 1rem; font-size: 14px; background-color: #f8f9fa;">
                                <button class="btn" type="submit" style="background-color: #f8f9fa; border: 1px solid #e2e8f0; border-left: none; border-radius: 0 8px 8px 0; color: #718096;">
                                    <i class="bi bi-search"></i>
                                </button>
                                @if(request('search'))
                                    <a href="{{ request()->url() }}" class="btn btn-outline-secondary ms-1" style="border-radius: 8px; padding: 0.75rem; font-size: 14px;" title="Limpar pesquisa">
                                        <i class="bi bi-x"></i>
                                    </a>
                                @endif
                            </div>
                        </form>

                        {{-- Ícone de Notificações com ponto vermelho --}}
                        <button type="button" style="position: relative; background: none; border: none; padding: 8px; margin-right: 1rem; cursor: pointer;">
                            <i class="bi bi-bell" style="font-size: 18px; color: #718096;"></i>
                            <span style="position: absolute; top: 4px; right: 4px; width: 8px; height: 8px; background: #dc3545; border-radius: 4px; display: block;"></span>
                        </button>

                        {{-- Dropdown do Utilizador --}}
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.5rem;">
                                <img src="https://i.pravatar.cc/32?u={{ auth()->user()->id }}" alt="" width="32" height="32" class="rounded-circle me-2">
                                <div class="text-start">
                                    <div class="fw-semibold" style="font-size: 14px; color: #2d3748;">{{ auth()->user()->name }}</div>
                                    <div class="text-muted" style="font-size: 12px; color: #a0aec0;">Administrador</div>
                                </div>
                            </a>
                            
                            <!-- Botões separados fora do dropdown tradicional -->
                            <div class="dropdown-menu dropdown-menu-end" style="border: none; background: transparent; box-shadow: none; padding: 0; margin-top: 0.5rem;">
                                <!-- Botão Usuários -->
                                <a href="{{ route('users.index') }}" style="display: block; padding: 0.75rem 1rem; font-size: 14px; color: #2d3748; border-radius: 8px; background: #ffffff; border: 1px solid #e2e8f0; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-decoration: none; margin-bottom: 0.5rem; width: 160px;">
                                    <i class="bi bi-people me-2" style="font-size: 14px; color: #718096;"></i>
                                    Usuários
                                </a>
                                
                                <!-- Botão Sair -->
                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="display: block; padding: 0.75rem 1rem; font-size: 14px; color: #2d3748; border-radius: 8px; background: #ffffff; border: 1px solid #e2e8f0; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-decoration: none; width: 160px;">
                                        <i class="bi bi-box-arrow-right me-2" style="font-size: 14px; color: #718096;"></i>
                                        Sair
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Área de Conteúdo Principal --}}
            <main class="main-container">
                <div class="w-100" style="margin: 0; padding: 0;">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    
    {{-- Stack de scripts personalizados --}}
    @stack('scripts')
    
    <style>
    /* Estilos para os botões do dropdown como elementos independentes */
    .dropdown-menu a {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        background: #ffffff !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
    }

    .dropdown-menu a:hover {
        background-color: #f8f9fa !important;
        border-color: #d1d5db !important;
        color: #2d3748 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        transform: translateY(-1px) !important;
    }

    .dropdown-menu a:hover i {
        color: #593E75 !important;
    }

    /* Hover do ícone de notificação */
    button:hover i.bi-bell {
        color: #593E75 !important;
    }

    /* Campo de pesquisa */
    .form-control:focus {
        border-color: #593E75 !important;
        box-shadow: 0 0 0 0.2rem rgba(89, 62, 117, 0.25) !important;
    }

    /* Dropdown toggle hover */
    .dropdown-toggle:hover {
        background-color: #f8f9fa !important;
        border-radius: 8px !important;
    }
    
    /* Estilos para botão de limpar pesquisa */
    .btn-outline-secondary:hover {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        color: white !important;
    }
    
    /* Alert de pesquisa */
    .alert-info {
        background-color: #e7f3ff !important;
        border-color: #b3d7ff !important;
        color: #084c61 !important;
    }
    
    /* Remove barras de rolagem desnecessárias */
    .table-responsive {
        overflow: visible !important;
    }
    
    /* Remove scrollbars globalmente apenas em elementos específicos */
    .container-fluid.no-scroll {
        overflow-x: hidden;
    }
    
    /* Garante que tabelas não criem overflow horizontal */
    table {
        table-layout: auto;
        width: 100%;
    }
    
    /* Permite scroll vertical quando necessário */
    html, body {
        overflow-x: hidden;
        overflow-y: auto;
        height: 100vh;
    }
    
    /* Remove scrollbars apenas de elementos específicos que não precisam */
    .no-scrollbar {
        scrollbar-width: none !important; /* Firefox */
        -ms-overflow-style: none !important; /* IE and Edge */
    }
    
    .no-scrollbar::-webkit-scrollbar {
        display: none !important; /* Chrome, Safari and Opera */
    }
    
    /* Força containers principais a gerenciar overflow corretamente */
    .main-container {
        overflow-y: auto;
        overflow-x: hidden;
        height: calc(100vh - 80px);
    }
    
    /* Permite scroll em áreas específicas quando necessário */
    .scrollable-area {
        overflow-y: auto !important;
        overflow-x: hidden !important;
        max-height: calc(100vh - 120px);
    }
    
    /* Estilo específico para modais e offcanvas */
    .offcanvas-body.scrollable {
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }
    
    /* Permite scroll na página de detalhes */
    .trip-details-page {
        overflow-y: auto !important;
        overflow-x: hidden !important;
        height: calc(100vh - 80px) !important;
        max-height: calc(100vh - 80px) !important;
        min-height: auto !important;
    }
    
    /* Utiliza todo o espaço disponível */
    .table {
        margin-bottom: 0 !important;
    }
    
    /* Remove margens e paddings desnecessários */
    .container-fluid {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    
    /* Garante uso completo da largura */
    .w-100 {
        width: 100% !important;
        max-width: 100% !important;
    }
    </style>
</body>
</html>
