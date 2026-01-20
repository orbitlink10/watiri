<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminBasicAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = (string) env('ADMIN_USER', '');
        $password = (string) env('ADMIN_PASSWORD', '');

        if ($user === '' || $password === '') {
            abort(403, 'Admin credentials are not configured.');
        }

        $providedUser = (string) $request->getUser();
        $providedPassword = (string) $request->getPassword();

        if (! hash_equals($user, $providedUser) || ! hash_equals($password, $providedPassword)) {
            return response('Unauthorized', 401, [
                'WWW-Authenticate' => 'Basic realm="Watiri Designs Admin"',
            ]);
        }

        return $next($request);
    }
}

