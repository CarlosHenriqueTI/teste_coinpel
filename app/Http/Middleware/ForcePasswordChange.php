<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if ($user && $user->must_change_password) {
            $allowedRoutes = [
                'change-password',
                'password.update', 
                'logout'
            ];
            
            if (!in_array($request->route()->getName(), $allowedRoutes)) {
                return redirect()->route('change-password')->with('warning', 'Você deve alterar sua senha antes de continuar.');
            }
        }
        
        return $next($request);
    }
}
