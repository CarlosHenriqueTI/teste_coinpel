<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CoinPel</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    {{-- Importação do Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="d-flex bg-light">
        {{-- A nossa sidebar que já criámos --}}
        @include('layouts.sidebar')

        {{-- Container principal para o conteúdo e a barra de navegação --}}
        <div class="w-100">
            {{-- Barra de Navegação Superior --}}
            @include('layouts.navigation')

            {{-- Área de Conteúdo Principal --}}
            <main class="p-4">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
