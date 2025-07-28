@extends('layouts.app')

@section('title', 'Profil użytkownika')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-circle"></i> Profil użytkownika</h2>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do dashboardu
    </a>
</div>

<div class="row">
    <!-- Profile Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-user"></i> Informacje osobowe</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') ?? '#' }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Imię i nazwisko</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="role" class="form-label">Rola</label>
                            <input type="text" class="form-control" id="role" 
                                   value="{{ auth()->user()->role === 'admin' ? 'Administrator' : 'Użytkownik' }}" 
                                   readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="created_at" class="form-label">Konto utworzone</label>
                            <input type="text" class="form-control" id="created_at" 
                                   value="{{ auth()->user()->created_at->format('d.m.Y H:i') }}" readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Zapisz zmiany
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-lock"></i> Zmiana hasła</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password') ?? '#' }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="current_password" class="form-label">Obecne hasło</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Nowe hasło</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Potwierdź nowe hasło</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Zmień hasło
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile Stats -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar"></i> Statystyki konta</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-4x text-primary mb-2"></i>
                    <h5>{{ auth()->user()->name }}</h5>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-6">
                        <h4 class="text-primary">{{ auth()->user()->id }}</h4>
                        <small class="text-muted">ID użytkownika</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ auth()->user()->created_at->diffInDays() }}</h4>
                        <small class="text-muted">dni w systemie</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Security -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-shield-alt"></i> Bezpieczeństwo</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Rola:</span>
                    <span class="badge bg-{{ auth()->user()->role === 'admin' ? 'danger' : 'primary' }}">
                        {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Użytkownik' }}
                    </span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Status konta:</span>
                    <span class="badge bg-success">Aktywne</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <span>Ostatnia aktualizacja:</span>
                    <small class="text-muted">{{ auth()->user()->updated_at->format('d.m.Y') }}</small>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-bolt"></i> Szybkie akcje</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">
                            <i class="fas fa-cogs"></i> Panel admin
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-sign-out-alt"></i> Wyloguj się
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
        <div class="toast show" role="alert">
            <div class="toast-header">
                <i class="fas fa-check-circle text-success me-2"></i>
                <strong class="me-auto">Sukces</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
        <div class="toast show" role="alert">
            <div class="toast-header">
                <i class="fas fa-exclamation-circle text-danger me-2"></i>
                <strong class="me-auto">Błąd</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script>
// Auto-hide toasts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(function(toast) {
        setTimeout(function() {
            const bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
        }, 5000);
    });
});
</script>
@endsection