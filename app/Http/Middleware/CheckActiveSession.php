<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveSession
{
    /**
     * Vérifie que l'utilisateur en session est toujours valide.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Cas 1 : l'utilisateur a été supprimé de la base
            // (auth()->user() devrait toujours exister, mais on sécurise)
            if (!$user) {
                return $this->logout($request);
            }

            // Cas 2 : l'utilisateur a été désactivé
            // Décommentez et adaptez si vous avez un champ "statut" ou "is_active"
            //
            // if (isset($user->statut) && $user->statut !== 'actif') {
            //     return $this->logout($request);
            // }
            //
            // if (isset($user->is_active) && !$user->is_active) {
            //     return $this->logout($request);
            // }

            // Cas 3 : session expirée côté Laravel (géré automatiquement)
            // Rien à faire ici, Laravel s'en charge via la config session lifetime.
        }

        return $next($request);
    }

    /**
     * Déconnecte proprement l'utilisateur.
     */
    protected function logout(Request $request): Response
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('session_expired', true);
    }
}