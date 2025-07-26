@extends('layouts.auth')

@section('title', 'Rejestracja')
@section('subtitle', 'Utwórz nowe konto')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="first_name" class="form-label">
                <i class="fas fa-user"></i> Imię
            </label>
            <input type="text" 
                   class="form-control @error('first_name') is-invalid @enderror" 
                   id="first_name" 
                   name="first_name" 
                   value="{{ old('first_name') }}" 
                   required 
                   autofocus>
            @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="last_name" class="form-label">
                <i class="fas fa-user"></i> Nazwisko
            </label>
            <input type="text" 
                   class="form-control @error('last_name') is-invalid @enderror" 
                   id="last_name" 
                   name="last_name" 
                   value="{{ old('last_name') }}" 
                   required>
            @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">
            <i class="fas fa-at"></i> Nazwa użytkownika
        </label>
        <input type="text" 
               class="form-control @error('username') is-invalid @enderror" 
               id="username" 
               name="username" 
               value="{{ old('username') }}" 
               required>
        @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">
            <i class="fas fa-envelope"></i> Email
        </label>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email') }}" 
               required>
        @error('email')
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

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">
            <i class="fas fa-lock"></i> Potwierdź hasło
        </label>
        <input type="password" 
               class="form-control" 
               id="password_confirmation" 
               name="password_confirmation" 
               required>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-user-plus"></i> Zarejestruj się
        </button>
    </div>
</form>

<div class="text-center mt-3">
    <a href="{{ route('login') }}" class="text-decoration-none">
        <i class="fas fa-sign-in-alt"></i> Masz już konto? Zaloguj się
    </a>
</div>
@endsection