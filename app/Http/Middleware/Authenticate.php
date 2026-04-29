<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to.
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {

            abort(401, 'Silakan login terlebih dahulu.');
        }

        return null;
    }
}