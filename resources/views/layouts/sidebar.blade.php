{{-- resources/views/layouts/sidebar.blade.php --}}
<div class="d-flex flex-column flex-shrink-0 p-3 vh-100" style="width: 200px; background-color: #593E75; overflow: visible !important;">
    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="d-flex justify-content-center align-items-center mb-3 p-2 text-white text-decoration-none">
        {{-- Usamos um filtro CSS para tornar o logo original branco, uma solução flexível --}}
        <img src="{{ asset('images/logo.png') }}" alt="CoinPel Logo" style="width: 140px; filter: brightness(0) invert(1);">
    </a>
    
    {{-- Lista de links de navegação --}}
    <ul class="nav nav-pills flex-column mb-auto mt-3" style="overflow: visible !important;">
        @php
            // Array para simplificar a criação dos links da sidebar
            $navLinks = [
                ['route' => '#', 'icon' => 'people', 'label' => 'Clientes'],
                ['route' => 'drivers.*', 'icon' => 'person-vcard', 'label' => 'Motoristas'],
                ['route' => '#', 'icon' => 'bar-chart-line', 'label' => 'Estatísticas'],
                ['route' => 'vehicles.*', 'icon' => 'truck', 'label' => 'Veículos'],
                ['route' => 'trips.*', 'icon' => 'geo-alt', 'label' => 'Viagens'],
                ['route' => '#', 'icon' => 'file-earmark-text', 'label' => 'Contratos'],
                ['route' => '#', 'icon' => 'box-seam', 'label' => 'Pacotes'],
            ];
        @endphp

        @foreach ($navLinks as $link)
            @php
                // Verifica se o link está ativo
                $isActive = request()->routeIs($link['route']);
            @endphp
            <li class="nav-item mb-2">
                {{-- O link fica com a classe 'active' e o ícone '-fill' se a rota corresponder --}}
                <a href="{{ $link['route'] !== '#' ? route(str_replace('.*', '.index', $link['route'])) : '#' }}" 
                   class="nav-link text-white d-flex align-items-center py-2 px-3 fw-medium {{ $isActive ? 'active' : '' }}">
                    <i class="bi bi-{{ $link['icon'] }}{{ $isActive ? '-fill' : '' }} fs-5 me-3"></i>
                    <span>{{ $link['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
