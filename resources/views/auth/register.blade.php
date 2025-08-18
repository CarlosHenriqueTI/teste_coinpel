<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - CoinPel</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <style>
        /* Estilos personalizados para cores e alinhamento */
        .btn-custom-purple {
            background-color: #4A1D7B;
            color: white;
        }
        .btn-custom-purple:hover {
            background-color: #3a1761;
            color: white;
        }
        /* Estilos para o container da ilustração */
        .illustration-container {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden; /* Garante que as imagens não ultrapassem a coluna */
            /* A cor de fundo é usada para tingir as imagens com o mix-blend-mode */
            background-color: #593675;
        }

        /* Estilo base para todos os elementos da ilustração */
        .illustration-element {
            position: absolute;
            /* mix-blend-mode tinge o elemento com a cor de fundo do seu container */
            mix-blend-mode: luminosity;
            opacity: 0.17;
        }

        /* Posições específicas para cada imagem, baseadas no Figma */
        .img-city {
            width: 100%;
            top: 40.63%;
            z-index: 1;
        }
        .rectangle-floor {
            width: 100.5%;
            height: 13.5%;
            top: 86.78%;
            background-color: #E9E9E9;
            z-index: 2;
        }
        .img-bus {
            width: 72%;
            top: 62%;
            left: 14.7%;
            z-index: 3;
        }
        .img-woman { /* Humaaans Standing 1 */
            width: 21%;
            top: 69%;
            left: 6%;
            z-index: 4;
        }
        .img-woman2 { /* Humaaans Standing 2 */
            width: 21%;
            top: 69%;
            left: 32%;
            z-index: 4;
        }

        /* Responsividade */
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

        /* Responsividade para as ilustrações */
        @media (max-width: 1200px) {
            .img-bus {
                width: 75%;
                top: 60%;
                left: 12.5%;
            }
            .img-woman {
                width: 22%;
                top: 67%;
                left: 5%;
            }
            .img-woman2 {
                width: 22%;
                top: 67%;
                left: 30%;
            }
        }

        @media (max-width: 992px) {
            .img-city {
                top: 35%;
            }
            .img-bus {
                width: 80%;
                top: 58%;
                left: 10%;
            }
            .img-woman {
                width: 24%;
                top: 65%;
                left: 4%;
            }
            .img-woman2 {
                width: 24%;
                top: 65%;
                left: 28%;
            }
            .rectangle-floor {
                top: 85%;
                height: 15%;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            {{-- Coluna Esquerda: Formulário de Cadastro --}}
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center bg-light">
                <div class="w-75" style="max-width: 400px;">
                    
                    {{-- Logo --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo CoinPel" style="max-width: 200px;">
                    </div>

                    {{-- Título do Formulário --}}
                    <p class="mb-4">Crie sua conta:</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Campo de Nome --}}
                        <div class="mb-3">
                            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nome Completo">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo de Email --}}
                        <div class="mb-3">
                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="E-mail">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo de Senha --}}
                        <div class="mb-3">
                            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" placeholder="Senha">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo de Confirmação de Senha --}}
                        <div class="mb-3">
                            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Senha">
                        </div>

                        <div class="d-flex justify-content-end align-items-center mb-3">
                            <a href="{{ route('login') }}" class="text-decoration-none text-muted small">Já possui uma conta?</a>
                        </div>

                        {{-- Botão de Cadastrar --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-custom-purple">
                                Cadastrar
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
