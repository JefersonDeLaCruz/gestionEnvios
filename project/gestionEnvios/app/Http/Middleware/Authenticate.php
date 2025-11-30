<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * A dónde redirigir si NO está autenticado.
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            // aquí puedes mandar al login que ya tienes
            return route('login');
        }

        return null;
    }
}
