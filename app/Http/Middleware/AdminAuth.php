<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = (string) env('ADMIN_USER', '');
        $password = (string) env('ADMIN_PASSWORD', '');

        if ($user === '' || $password === '') {
            abort(403, 'Admin credentials are not configured.');
        }

        if ($request->session()->get('admin_logged_in') === true) {
            return $next($request);
        }

        $providedUser = (string) $request->getUser();
        $providedPassword = (string) $request->getPassword();

        if ($providedUser !== '' || $providedPassword !== '') {
            if (hash_equals($user, $providedUser) && hash_equals($password, $providedPassword)) {
                $request->session()->put('admin_logged_in', true);
                return $next($request);
            }

            return response('Unauthorized', 401, [
                'WWW-Authenticate' => 'Basic realm="Watiri Designs Admin"',
            ]);
        }

        return redirect()->guest(route('login'));
    }
}

