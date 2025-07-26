@extends('install.layout', ['steps' => [
    ['status' => 'completed'],
    ['status' => 'completed'],
    ['status' => 'completed'],
    ['status' => 'active'],
    ['status' => '']
]])

@section('content')
<h3 class="mb-4"><i class="fas fa-user-shield"></i> Konto administratora</h3>

<div class="alert alert-warning alert-install">
    <h6><i class="fas fa-exclamation-triangle"></i> Ważne!</h6>
    <p class="mb-0">
        Utwórz konto głównego administratora systemu. Ten użytkownik będzie miał pełne uprawnienia
        do zarządzania systemem, modułami i wszystkimi danymi.
    </p>
</div>

<form method="POST" action="{{ route('install.install') }}">
    @csrf
    
    <!-- Administrator Account -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-user-cog"></i> Dane administratora</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="admin_first_name" class="form-label">Imię *</label>
                        <input type="text" class="form-control @error('admin_first_name') is-invalid @enderror" 
                               id="admin_first_name" name="admin_first_name" value="{{ old('admin_first_name') }}" required>
                        @error('admin_first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="admin_last_name" class="form-label">Nazwisko *</label>
                        <input type="text" class="form-control @error('admin_last_name') is-invalid @enderror" 
                               id="admin_last_name" name="admin_last_name" value="{{ old('admin_last_name') }}" required>
                        @error('admin_last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="admin_username" class="form-label">Nazwa użytkownika *</label>
                        <input type="text" class="form-control @error('admin_username') is-invalid @enderror" 
                               id="admin_username" name="admin_username" value="{{ old('admin_username', 'admin') }}" required>
                        @error('admin_username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="admin_email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('admin_email') is-invalid @enderror" 
                               id="admin_email" name="admin_email" value="{{ old('admin_email') }}" required>
                        @error('admin_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="admin_password" class="form-label">Hasło *</label>
                        <input type="password" class="form-control @error('admin_password') is-invalid @enderror" 
                               id="admin_password" name="admin_password" required>
                        <div class="form-text">Minimum 6 znaków</div>
                        @error('admin_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="admin_password_confirmation" class="form-label">Potwierdź hasło *</label>
                        <input type="password" class="form-control" 
                               id="admin_password_confirmation" name="admin_password_confirmation" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Module Selection -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-cubes"></i> Wybór modułów</h5>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">Wybierz moduły, które chcesz włączyć w systemie:</p>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="Tools" 
                               id="module_tools" name="modules[]" checked>
                        <label class="form-check-label" for="module_tools">
                            <i class="fas fa-tools text-primary"></i> <strong>Narzędzia</strong>
                            <small class="d-block text-muted">Zarządzanie narzędziami warsztatowymi</small>
                        </label>
                    </div>
                    
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="HeightEquipment" 
                               id="module_height" name="modules[]" checked>
                        <label class="form-check-label" for="module_height">
                            <i class="fas fa-hard-hat text-success"></i> <strong>Sprzęt wysokościowy</strong>
                            <small class="d-block text-muted">Sprzęt do pracy na wysokości</small>
                        </label>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="ITEquipment" 
                               id="module_it" name="modules[]" checked>
                        <label class="form-check-label" for="module_it">
                            <i class="fas fa-laptop text-info"></i> <strong>Sprzęt IT</strong>
                            <small class="d-block text-muted">Komputery, drukarki, telefony</small>
                        </label>
                    </div>
                    
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="Employees" 
                               id="module_employees" name="modules[]" checked>
                        <label class="form-check-label" for="module_employees">
                            <i class="fas fa-users text-warning"></i> <strong>Pracownicy</strong>
                            <small class="d-block text-muted">Baza danych pracowników</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Demo Data -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-database"></i> Dane demonstracyjne</h5>
        </div>
        <div class="card-body">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" 
                       id="install_demo_data" name="install_demo_data" checked>
                <label class="form-check-label" for="install_demo_data">
                    <strong>Zainstaluj przykładowe dane</strong>
                    <small class="d-block text-muted">
                        Dodaje przykładowych pracowników, narzędzia i transfery do celów demonstracyjnych.
                        Można je później usunąć z panelu administracyjnego.
                    </small>
                </label>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('install.database') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Poprzedni krok
        </a>
        <button type="submit" class="btn btn-install btn-lg">
            <i class="fas fa-rocket"></i> Zainstaluj EquipTracker
        </button>
    </div>
</form>
@endsection

@section('scripts')
<script>
// Show/hide password
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Instalowanie...';
    });
});
</script>
@endsection