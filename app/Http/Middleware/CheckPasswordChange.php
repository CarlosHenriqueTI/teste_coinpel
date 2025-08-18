<?php
// app/Http/Middleware/CheckPasswordChange.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o utilizador está logado e se precisa de trocar a senha
        if (auth()->check() && auth()->user()->must_change_password) {
            
            // Permite que o utilizador aceda à página de edição de perfil (onde pode trocar a senha) e à função de logout
            if (! $request->routeIs('profile.edit') && ! $request->routeIs('profile.update')) {
                
                // Se tentar aceder a qualquer outra página, redireciona-o para a edição de perfil com um aviso
                return redirect()->route('profile.edit')->with('status', 'Por favor, atualize a sua senha para continuar.');
            }
        }

        return $next($request);
    }
}
