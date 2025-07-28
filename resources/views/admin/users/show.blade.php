@extends('layouts.app')

@section('title', 'Szczegóły użytkownika')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user"></i> Szczegóły użytkownika</h2>
    <div>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edytuj
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- User Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-user"></i> Informacje użytkownika</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">ID:</th>
                                <td>#{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>Imię i nazwisko:</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Rola:</th>
                                <td>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} fs-6">
                                        {{ $user->role === 'admin' ? 'Administrator' : 'Użytkownik' }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Data rejestracji:</th>
                                <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Ostatnia aktualizacja:</th>
                                <td>{{ $user->updated_at->format('d.m.Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Czas w systemie:</th>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-info">To Twoje konto</span>
                                    @else
                                        <span class="badge bg-success">Aktywny</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Reset Section -->
        @if($user->id !== auth()->id())
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-key"></i> Reset hasła</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Ustaw nowe hasło dla użytkownika {{ $user->name }}.</p>
                
                <form method="POST" action="{{ route('admin.users.reset-password', $user) }}">
                    @csrf
                    
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
                            <label for="password_confirmation" class="form-label">Potwierdź hasło</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Czy na pewno chcesz zresetować hasło tego użytkownika?')">
                        <i class="fas fa-key"></i> Resetuj hasło
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-cogs"></i> Akcje</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edytuj użytkownika
                    </a>
                    
                    @if($user->id !== auth()->id())
                        <button class="btn btn-outline-danger" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                            <i class="fas fa-trash"></i> Usuń użytkownika
                        </button>
                    @else
                        <div class="alert alert-info small mb-0">
                            <i class="fas fa-info-circle"></i>
                            Nie możesz usunąć swojego własnego konta.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Stats -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar"></i> Statystyki</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-4x text-{{ $user->role === 'admin' ? 'danger' : 'primary' }} mb-2"></i>
                    <h5>{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-6">
                        <h4 class="text-primary">{{ $user->id }}</h4>
                        <small class="text-muted">ID użytkownika</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ $user->created_at->diffInDays() }}</h4>
                        <small class="text-muted">dni w systemie</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Information -->
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-shield-alt"></i> Uprawnienia</h5>
            </div>
            <div class="card-body">
                <h6 class="text-center">
                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} fs-6">
                        {{ $user->role === 'admin' ? 'Administrator' : 'Użytkownik' }}
                    </span>
                </h6>
                
                <hr>
                
                @if($user->role === 'admin')
                <div class="small">
                    <h6>Uprawnienia administratora:</h6>
                    <ul class="mb-0">
                        <li>Zarządzanie użytkownikami</li>
                        <li>Zarządzanie modułami</li>
                        <li>Czyszczenie danych</li>
                        <li>Informacje systemowe</li>
                    </ul>
                </div>
                @else
                <div class="small">
                    <h6>Uprawnienia użytkownika:</h6>
                    <ul class="mb-0">
                        <li>Dostęp do dashboardu</li>
                        <li>Zarządzanie sprzętem</li>
                        <li>Zarządzanie pracownikami</li>
                        <li>Edycja profilu</li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Potwierdź usunięcie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Czy na pewno chcesz usunąć użytkownika <strong id="userName"></strong>?
                <br><small class="text-muted">Tej operacji nie można cofnąć.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Usuń użytkownika</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(userId, userName) {
    document.getElementById('userName').textContent = userName;
    document.getElementById('deleteForm').action = '/admin/users/' + userId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection