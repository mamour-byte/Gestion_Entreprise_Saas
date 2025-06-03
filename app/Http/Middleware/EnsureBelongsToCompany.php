<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBelongsToCompany
{
    public function handle(Request $request, Closure $next): Response
    {
        $record = $request->route('record');

        if ($record && auth()->check() && $record->company_id !== auth()->user()->company_id) {
            abort(403, 'Accès interdit – Données non autorisées.');
        }

        return $next($request);
    }
}
