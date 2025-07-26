@extends('layouts.auth')

@section('title', 'Logowanie')
@section('subtitle', 'Zaloguj się do systemu')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="mb-3">
        <label for="username" class="form-label">
            <i class="fas fa-user"></i> Nazwa użytkownika lub email
        </label>
        <input type="text" 
               class="form-control @error('username') is-invalid @enderror" 
               id="username" 
               name="username" 
               value="{{ old('username') }}" 
               required 
               autofocus>
        @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">
            <i class="fas fa-lock"></i> Hasło
        </label>
        <input type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               id="password" 
               name="password" 
               required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">
            Zapamiętaj mnie
        </label>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="auth_type" id="local" value="local" checked>
                <label class="form-check-label" for="local">
                    <i class="fas fa-database"></i> Logowanie lokalne
                </label>
            </div>
        </div>
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="auth_type" id="ldap" value="ldap">
                <label class="form-check-label" for="ldap">
                    <i class="fas fa-network-wired"></i> Logowanie LDAP
                </label>
            </div>
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-sign-in-alt"></i> Zaloguj się
        </button>
    </div>
</form>

<div class="text-center mt-3">
    <a href="{{ route('register') }}" class="text-decoration-none">
        <i class="fas fa-user-plus"></i> Nie masz konta? Zarejestruj się
    </a>
</div>

<div class="text-center mt-2">
    <a href="{{ route('password.request') }}" class="text-muted text-decoration-none">
        <i class="fas fa-key"></i> Zapomniałeś hasła?
    </a>
</div>
@endsection