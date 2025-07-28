@extends('layouts.app')

@section('title', 'Zarządzanie danymi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-database"></i> Zarządzanie danymi</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do panelu
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Statistics Overview -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h4>{{ $stats['users'] }}</h4>
                <small class="text-muted">Użytkownicy</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-user-tie fa-2x text-success mb-2"></i>
                <h4>{{ $stats['employees'] }}</h4>
                <small class="text-muted">Pracownicy</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-tools fa-2x text-warning mb-2"></i>
                <h4>{{ $stats['tools'] }}</h4>
                <small class="text-muted">Narzędzia</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-ladder fa-2x text-info mb-2"></i>
                <h4>{{ $stats['height_equipment'] }}</h4>
                <small class="text-muted">Sprzęt wys.</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-laptop fa-2x text-secondary mb-2"></i>
                <h4>{{ $stats['it_equipment'] }}</h4>
                <small class="text-muted">Sprzęt IT</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-exchange-alt fa-2x text-danger mb-2"></i>
                <h4>{{ $stats['transfers'] }}</h4>
                <small class="text-muted">Transfery</small>
            </div>
        </div>
    </div>
</div>

<!-- Clear Data Section -->
<div class="row">
    <div class="col-md-8">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle"></i> Czyszczenie danych
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>UWAGA!</strong> Czyszczenie danych jest operacją nieodwracalną. 
                    Wszystkie wybrane dane zostaną trwale usunięte z systemu.
                </div>
                
                <form method="POST" action="{{ route('admin.clear-data') }}" id="clearDataForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Wybierz dane do wyczyszczenia:</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="clear_type" 
                                           id="clear_tools" value="tools">
                                    <label class="form-check-label" for="clear_tools">
                                        <i class="fas fa-tools text-warning"></i> Tylko narzędzia ({{ $stats['tools'] }})
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="clear_type" 
                                           id="clear_height_equipment" value="height_equipment">
                                    <label class="form-check-label" for="clear_height_equipment">
                                        <i class="fas fa-ladder text-info"></i> Tylko sprzęt wysokościowy ({{ $stats['height_equipment'] }})
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="clear_type" 
                                           id="clear_it_equipment" value="it_equipment">
                                    <label class="form-check-label" for="clear_it_equipment">
                                        <i class="fas fa-laptop text-secondary"></i> Tylko sprzęt IT ({{ $stats['it_equipment'] }})
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="clear_type" 
                                           id="clear_employees" value="employees">
                                    <label class="form-check-label" for="clear_employees">
                                        <i class="fas fa-user-tie text-success"></i> Tylko pracownicy ({{ $stats['employees'] }})
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="clear_type" 
                                           id="clear_transfers" value="transfers">
                                    <label class="form-check-label" for="clear_transfers">
                                        <i class="fas fa-exchange-alt text-danger"></i> Tylko transfery ({{ $stats['transfers'] }})
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="clear_type" 
                                           id="clear_all" value="all">
                                    <label class="form-check-label" for="clear_all">
                                        <i class="fas fa-trash-alt text-danger"></i> <strong>Wszystkie dane</strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('clear_type')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Potwierdź hasłem administratora:
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required 
                               placeholder="Wprowadź swoje hasło">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmClear" required>
                            <label class="form-check-label" for="confirmClear">
                                Potwierdzam, że rozumiem konsekwencje tej operacji i chcę trwale usunąć wybrane dane
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-danger" id="clearButton" disabled>
                        <i class="fas fa-trash-alt"></i> Wyczyść wybrane dane
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informacje</h6>
            </div>
            <div class="card-body">
                <h6>Co zostanie usunięte:</h6>
                <ul class="small">
                    <li><strong>Narzędzia:</strong> wszystkie narzędzia i powiązane transfery</li>
                    <li><strong>Sprzęt wysokościowy:</strong> wszystkie urządzenia i transfery</li>
                    <li><strong>Sprzęt IT:</strong> wszystkie urządzenia IT i transfery</li>
                    <li><strong>Pracownicy:</strong> wszyscy pracownicy i wszystkie transfery</li>
                    <li><strong>Transfery:</strong> wszystkie transfery (sprzęt wraca do stanu "dostępny")</li>
                    <li><strong>Wszystkie dane:</strong> kompletne wyczyszczenie systemu (z wyjątkiem administratorów)</li>
                </ul>
                
                <hr>
                
                <h6>Bezpieczeństwo:</h6>
                <ul class="small">
                    <li>Wymagane jest hasło administratora</li>
                    <li>Operacja jest nieodwracalna</li>
                    <li>Konta administratorów nie są usuwane</li>
                    <li>Struktura bazy danych pozostaje nienaruszona</li>
                </ul>
            </div>
        </div>
        
        <div class="card border-success mt-3">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-download"></i> Kopia zapasowa</h6>
            </div>
            <div class="card-body">
                <p class="small">Przed czyszczeniem danych zaleca się wykonanie kopii zapasowej bazy danych.</p>
                <div class="d-grid">
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="alert('Funkcja kopii zapasowej będzie dostępna w przyszłych wersjach')">
                        <i class="fas fa-download"></i> Utwórz kopię zapasową
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('clearDataForm');
    const confirmCheckbox = document.getElementById('confirmClear');
    const clearButton = document.getElementById('clearButton');
    const radioButtons = document.querySelectorAll('input[name="clear_type"]');
    
    // Enable/disable button based on confirmation
    function updateButtonState() {
        const isTypeSelected = Array.from(radioButtons).some(radio => radio.checked);
        const isConfirmed = confirmCheckbox.checked;
        clearButton.disabled = !(isTypeSelected && isConfirmed);
    }
    
    confirmCheckbox.addEventListener('change', updateButtonState);
    radioButtons.forEach(radio => {
        radio.addEventListener('change', updateButtonState);
    });
    
    // Form submission confirmation
    form.addEventListener('submit', function(e) {
        const selectedType = document.querySelector('input[name="clear_type"]:checked');
        if (!selectedType) {
            e.preventDefault();
            alert('Wybierz dane do wyczyszczenia');
            return;
        }
        
        const typeLabels = {
            'tools': 'narzędzia',
            'height_equipment': 'sprzęt wysokościowy',
            'it_equipment': 'sprzęt IT',
            'employees': 'pracowników',
            'transfers': 'transfery',
            'all': 'WSZYSTKIE DANE'
        };
        
        const typeLabel = typeLabels[selectedType.value];
        const confirmMessage = `Czy na pewno chcesz usunąć ${typeLabel}?\n\nTa operacja jest NIEODWRACALNA!`;
        
        if (!confirm(confirmMessage)) {
            e.preventDefault();
        }
    });
});
</script>
@endsection