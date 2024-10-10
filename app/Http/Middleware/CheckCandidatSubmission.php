<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Candidat;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCandidatSubmission
{
    public function handle(Request $request, Closure $next): Response
    {
        $codeExetat = session('code_exetat'); 
        if ($codeExetat && Candidat::where('code_exetat', $codeExetat)->exists()) {
            return redirect()->route('success'); // Redirection vers la page de confirmation
        }

        return $next($request);
    }
}
