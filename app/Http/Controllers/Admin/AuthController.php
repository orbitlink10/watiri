<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $user = (string) env('ADMIN_USER', '');
        $password = (string) env('ADMIN_PASSWORD', '');

        if ($user === '' || $password === '') {
            abort(403, 'Admin credentials are not configured.');
        }

        if (! hash_equals($user, $validated['username']) || ! hash_equals($password, $validated['password'])) {
            return back()
                ->withErrors(['username' => 'Invalid credentials.'])
                ->onlyInput('username');
        }

        $request->session()->regenerate();
        $request->session()->put('admin_logged_in', true);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

