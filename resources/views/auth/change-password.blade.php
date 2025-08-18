<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha - CoinPel</title>
    {{-- Carrega o nosso CSS e JS compilados pelo Vite --}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <style>
        /* Estilos personalizados para cores e alinhamento */
        .btn-custom-purple {
            background-color: #593E75;
            color: white;
        }
        .btn-custom-purple:hover {
            background-color: #4A356A;
            color: white;
        }

        /* Estilos para o container da ilustração */
        .illustration-container {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden; /* Garante que as imagens não ultrapassem a coluna */
            background-color: #593E75; /* Cor de fundo sólida para tingir as imagens */
        }

        /* Estilo base para todos os elementos da ilustração */
        .illustration-element {
            position: absolute;
            /* ALTERAÇÃO: Usamos mix-blend-mode para tingir a imagem com a cor do fundo, sem transparência */
            mix-blend-mode: luminosity;
            opacity: 0.8;
        }

        /* Posições específicas para cada imagem, baseadas no Figma */
        .img-city {
            width: 100%;
            top: 35.5%;
            z-index: 1;
        }
        .rectangle-floor {
            width: 100.5%;
            height: 13.5%;
            top: 86.78%;
            background-color: #D1C4E9; /* Cor sólida para o chão, que será tingida */
            z-index: 2;
        }
        .img-bus {
            width: 72%;
            top: 60%;
            left: 14%;
            z-index: 3;
        }
        .img-woman { /* Humaaans Standing 1 */
            width: 19%;
            top: 69%;
            left: 7%;
            z-index: 4;
        }
        .img-woman2 { /* Humaaans Standing 2 */
            width: 19%;
            top: 69%;
            left: 32.5%;
            z-index: 4;
        }

        /* Responsividade (mantida como no código original) */
        @media (max-width: 768px) {
            .w-75 {
                width: 90% !important;
                padding: 0 15px;
            }
            img[alt="Logo CoinPel"] {
                max-width: 150px !important;
            }
        }
        @media (max-width: 576px) {
            .w-75 {
                width: 95% !important;
                padding: 0 10px;
            }
            img[alt="Logo CoinPel"] {
                max-width: 120px !important;
            }
            .form-control {
                font-size: 16px; /* Evita zoom no iOS */
            }
        }
        @media (max-width: 1200px) {
            .img-bus { width: 75%; top: 60%; left: 12.5%; }
            .img-woman { width: 22%; top: 67%; left: 5%; }
            .img-woman2 { width: 22%; top: 67%; left: 30%; }
        }
        @media (max-width: 992px) {
            .img-city { top: 35%; }
            .img-bus { width: 80%; top: 58%; left: 10%; }
            .img-woman { width: 24%; top: 65%; left: 4%; }
            .img-woman2 { width: 24%; top: 65%; left: 28%; }
            .rectangle-floor { top: 85%; height: 15%; }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            {{-- Coluna Esquerda: Formulário de Mudança de Senha --}}
            <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center bg-light">
                <div class="w-75" style="max-width: 400px;">
                    
                    {{-- Logo --}}
                    <div class="text-center mb-4 ">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo CoinPel" style="max-width: 400px;">
                    </div>

                    {{-- Título do Formulário --}}
                    <p class="mb-1 fw-bold">Crie uma nova senha:</p>
                    <p class="text-muted mb-4 small">No seu primeiro acesso é necessário trocar a senha provisória. É obrigatório que a senha tenha no mínimo 8 caracteres.</p>

                    {{-- Exibir erros de validação --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        {{-- Campo de Senha Atual --}}
                        <div class="mb-3">
                            <input id="current_password" class="form-control @error('current_password') is-invalid @enderror" type="password" name="current_password" required autocomplete="current-password" placeholder="Senha atual">
                            @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Campo de Nova Senha --}}
                        <div class="mb-3">
                            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" placeholder="Nova senha" minlength="8">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Campo de Repetir Senha --}}
                        <div class="mb-3">
                            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repetir senha" minlength="8">
                        </div>

                        {{-- Botão de Confirmar --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-custom-purple">
                                Confirmar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Coluna Direita: Ilustração --}}
            <div class="col-md-6 d-none d-md-flex">
                <div class="illustration-container">
                    <img src="{{ asset('images/city.png') }}" alt="Ilustração da cidade" class="illustration-element img-city">
                    <div class="illustration-element rectangle-floor"></div>
                    <img src="{{ asset('images/bus.png') }}" alt="Ilustração de um autocarro" class="illustration-element img-bus">
                    <img src="{{ asset('images/woman.png') }}" alt="Ilustração de uma mulher" class="illustration-element img-woman">
                    <img src="{{ asset('images/woman2.png') }}" alt="Ilustração de outra mulher" class="illustration-element img-woman2">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
