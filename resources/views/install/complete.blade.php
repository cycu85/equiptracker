@extends('install.layout', ['steps' => [
    ['status' => 'completed'],
    ['status' => 'completed'],
    ['status' => 'completed'],
    ['status' => 'completed'],
    ['status' => 'completed']
]])

@section('content')
<div class="text-center">
    <div class="mb-4">
        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
    </div>
    
    <h2 class="text-success mb-4">Instalacja zakończona pomyślnie!</h2>
    
    <div class="alert alert-success alert-install">
        <h5><i class="fas fa-party-horn"></i> Gratulacje!</h5>
        <p class="mb-0">
            EquipTracker został pomyślnie zainstalowany i skonfigurowany. 
            System jest gotowy do użycia.
        </p>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informacje o instalacji</h5>
                </div>
                <div class="card-body">
                    <div class="row text-start">
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="fas fa-user-shield"></i> Konto administratora:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Nazwa użytkownika:</strong> {{ $admin_username }}</li>
                                <li><strong>Email:</strong> {{ $admin_email }}</li>
                                <li><strong>Rola:</strong> Administrator</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="fas fa-cubes"></i> Zainstalowane moduły:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-tools text-primary"></i> Narzędzia</li>
                                <li><i class="fas fa-hard-hat text-success"></i> Sprzęt wysokościowy</li>
                                <li><i class="fas fa-laptop text-info"></i> Sprzęt IT</li>
                                <li><i class="fas fa-users text-warning"></i> Pracownicy</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info alert-install mt-4">
        <h6><i class="fas fa-lightbulb"></i> Następne kroki:</h6>
        <ol class="mb-0 text-start">
            <li>Zaloguj się do systemu używając utworzonego konta administratora</li>
            <li>Skonfiguruj ustawienia systemu w panelu administracyjnym</li>
            <li>Dodaj pracowników i sprzęt do systemu</li>
            <li>Rozpocznij zarządzanie sprzętem firmowym!</li>
        </ol>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="d-grid">
                <a href="{{ route('login') }}" class="btn btn-install btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Zaloguj się do systemu
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-grid">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-tachometer-alt"></i> Przejdź do Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h6 class="text-muted">Przydatne linki:</h6>
        <div class="row">
            <div class="col-md-4">
                <a href="/tools" class="btn btn-outline-info btn-sm w-100 mb-2">
                    <i class="fas fa-tools"></i> Narzędzia
                </a>
            </div>
            <div class="col-md-4">
                <a href="/transfers" class="btn btn-outline-success btn-sm w-100 mb-2">
                    <i class="fas fa-exchange-alt"></i> Transfery
                </a>
            </div>
            <div class="col-md-4">
                <a href="/admin" class="btn btn-outline-warning btn-sm w-100 mb-2">
                    <i class="fas fa-cog"></i> Panel Admin
                </a>
            </div>
        </div>
    </div>

    <hr class="mt-5">
    <p class="text-muted small">
        <i class="fas fa-heart text-danger"></i> 
        Dziękujemy za wybór EquipTracker! 
        <br>
        W razie problemów sprawdź dokumentację lub skontaktuj się z pomocą techniczną.
    </p>
</div>
@endsection

@section('scripts')
<script>
// Confetti animation (optional)
document.addEventListener('DOMContentLoaded', function() {
    // Add some celebration effects if needed
    console.log('🎉 EquipTracker installed successfully!');
});
</script>
@endsection