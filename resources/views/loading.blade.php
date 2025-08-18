<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo à CoinPel</title>
    <style>
        /* Reseta estilos padrão e prepara o corpo da página */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: sans-serif;
            overflow: hidden; /* Evita barras de rolagem */
        }

        /* Container principal da tela de carregamento */
        .loading-screen {
            height: 100%;
            width: 100%;
            position: relative;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 30vh 0 0 10vw;
            box-sizing: border-box;
            background-image: url("{{ asset('images/background.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            /* Animação de entrada */
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Overlay roxo semi-transparente */
        .loading-screen::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #6C397A;
            opacity: 0.59;
            z-index: 1;
        }

        /* Estilização do logo */
        .logo {
            position: relative;
            z-index: 2;
            width: 35vw;
            max-width: 660px;
        }
        
        /* Animação de entrada */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Animação de saída */
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        /* Classe para aplicar a animação de saída */
        .fade-out {
            animation: fadeOut 0.8s ease-in-out forwards;
        }
    </style>
</head>
<body>

    <div class="loading-screen" id="loadingScreen">
        <img src="{{ asset('images/logo.png') }}" alt="Logo da CoinPel" class="logo">
    </div>

    <script>
        // Redirecionar após 3 segundos com efeito de fade out
        setTimeout(function() {
            const loadingScreen = document.getElementById('loadingScreen');
            loadingScreen.classList.add('fade-out');
            
            // Aguardar a animação de fade out completar antes de redirecionar
            setTimeout(function() {
                // Redireciona para a página de login. Se não existir, vai para a raiz.
                window.location.href = '{{ route("login") }}'; 
            }, 800); // 800ms, a mesma duração da animação fadeOut

        }, 4000); // 4000ms = 4 segundos
    </script>
</body>
</html>
