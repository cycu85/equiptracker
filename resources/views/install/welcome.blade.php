@extends('install.layout')

@section('content')
<div class="text-center">
    <h2 class="mb-4">Witaj w instalatorze EquipTracker!</h2>
    
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title text-primary">
                        <i class="fas fa-rocket"></i> Profesjonalny system zarządzania sprzętem
                    </h5>
                    
                    <p class="card-text text-muted mb-4">
                        EquipTracker to kompleksowe rozwiązanie do zarządzania narzędziami, 
                        sprzętem wysokościowym, urządzeniami IT i pracownikami w Twojej firmie.
                    </p>
                    
                    <div class="row text-start">
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="fas fa-check"></i> Główne funkcjonalności:</h6>
                            <ul class="list-unstyled small">
                                <li><i class="fas fa-tools text-primary"></i> Zarządzanie narzędziami</li>
                                <li><i class="fas fa-hard-hat text-primary"></i> Sprzęt wysokościowy</li>
                                <li><i class="fas fa-laptop text-primary"></i> Sprzęt IT</li>
                                <li><i class="fas fa-users text-primary"></i> Baza pracowników</li>
                                <li><i class="fas fa-file-pdf text-primary"></i> Protokoły PDF</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="fas fa-cog"></i> Funkcje systemowe:</h6>
                            <ul class="list-unstyled small">
                                <li><i class="fas fa-shield-alt text-primary"></i> System autoryzacji</li>
                                <li><i class="fas fa-cubes text-primary"></i> Architektura modułowa</li>
                                <li><i class="fas fa-bell text-primary"></i> Powiadomienia email</li>
                                <li><i class="fas fa-chart-bar text-primary"></i> Raporty i statystyki</li>
                                <li><i class="fas fa-mobile-alt text-primary"></i> Responsive design</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info alert-install mt-4">
                <h6><i class="fas fa-info-circle"></i> Przed rozpoczęciem instalacji upewnij się, że:</h6>
                <ul class="mb-0 text-start">
                    <li>Masz dostęp do serwera MySQL/MariaDB</li>
                    <li>PHP w wersji 8.1 lub wyższej jest zainstalowane</li>
                    <li>Katalogi aplikacji mają odpowiednie uprawnienia zapisu</li>
                    <li>Kompozer jest zainstalowany i skonfigurowany</li>
                </ul>
            </div>
            
            <div class="d-grid gap-2 mt-4">
                <a href="{{ route('install.requirements') }}" class="btn btn-install btn-lg">
                    <i class="fas fa-arrow-right"></i> Rozpocznij instalację
                </a>
            </div>
            
            <p class="text-muted small mt-3">
                Proces instalacji zajmie około 5-10 minut w zależności od konfiguracji serwera.
            </p>
        </div>
    </div>
</div>
@endsection