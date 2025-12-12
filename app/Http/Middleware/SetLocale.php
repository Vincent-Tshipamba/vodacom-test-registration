<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);

        // Nos langues autorisées
        $available = ['fr', 'en', 'ln', 'sw'];

        if (in_array($locale, $available)) {
            app()->setLocale($locale);
        } else {
            // Rediriger vers FR si pas de langue
            return redirect('/fr');
        }

        return $next($request);
    }
}
