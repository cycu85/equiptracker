<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'auth_type' => 'required|in:local,ldap',
        ]);

        if ($request->auth_type === 'local') {
            return $this->attemptLocalLogin($request);
        } else {
            return $this->attemptLdapLogin($request);
        }
    }

    protected function attemptLocalLogin(Request $request)
    {
        $credentials = [
            'password' => $request->password,
        ];

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->username;
        } else {
            $credentials['username'] = $request->username;
        }

        $credentials['is_active'] = true;

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'username' => ['Nieprawidłowe dane logowania.'],
        ]);
    }

    protected function attemptLdapLogin(Request $request)
    {
        throw ValidationException::withMessages([
            'auth_type' => ['Logowanie LDAP nie jest jeszcze dostępne.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
