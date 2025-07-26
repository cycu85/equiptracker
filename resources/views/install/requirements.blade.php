@extends('install.layout', ['steps' => [
    ['status' => 'completed'],
    ['status' => 'active'],
    ['status' => ''],
    ['status' => ''],
    ['status' => '']
]])

@section('content')
<h3 class="mb-4"><i class="fas fa-list-check"></i> Sprawdzenie wymagań systemowych</h3>

<!-- PHP Version -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-code"></i> Wersja PHP</h5>
    </div>
    <div class="card-body">
        <div class="requirement-item">
            <div>
                <strong>PHP {{ $requirements['php_version']['required'] }}+</strong>
                <small class="text-muted d-block">Wymagana minimalna wersja PHP</small>
            </div>
            <div>
                @if($requirements['php_version']['status'])
                    <span class="badge bg-success">
                        <i class="fas fa-check"></i> {{ $requirements['php_version']['current'] }}
                    </span>
                @else
                    <span class="badge bg-danger">
                        <i class="fas fa-times"></i> {{ $requirements['php_version']['current'] }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- PHP Extensions -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-puzzle-piece"></i> Rozszerzenia PHP</h5>
    </div>
    <div class="card-body">
        @foreach($requirements['extensions'] as $extension => $status)
        <div class="requirement-item">
            <div>
                <strong>{{ strtoupper($extension) }}</strong>
                <small class="text-muted d-block">Rozszerzenie PHP {{ $extension }}</small>
            </div>
            <div>
                @if($status)
                    <span class="badge bg-success"><i class="fas fa-check"></i> Zainstalowane</span>
                @else
                    <span class="badge bg-danger"><i class="fas fa-times"></i> Brak</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Directory Permissions -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-folder-open"></i> Uprawnienia katalogów</h5>
    </div>
    <div class="card-body">
        @foreach($requirements['permissions'] as $directory => $writable)
        <div class="requirement-item">
            <div>
                <strong>{{ str_replace('_', '/', $directory) }}</strong>
                <small class="text-muted d-block">Katalog musi mieć uprawnienia zapisu</small>
            </div>
            <div>
                @if($writable)
                    <span class="badge bg-success"><i class="fas fa-check"></i> Zapisywalny</span>
                @else
                    <span class="badge bg-danger"><i class="fas fa-times"></i> Brak uprawnień</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Summary -->
@php
    $allRequirementsMet = $requirements['php_version']['status'] && 
                         !in_array(false, $requirements['extensions']) && 
                         !in_array(false, $requirements['permissions']);
@endphp

@if($allRequirementsMet)
    <div class="alert alert-success alert-install">
        <h5><i class="fas fa-check-circle"></i> Wszystkie wymagania są spełnione!</h5>
        <p class="mb-0">Serwer jest gotowy do instalacji EquipTracker. Możesz przejść do następnego kroku.</p>
    </div>
    
    <div class="d-flex justify-content-between">
        <a href="{{ route('install.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
        <a href="{{ route('install.database') }}" class="btn btn-install">
            Konfiguracja bazy danych <i class="fas fa-arrow-right"></i>
        </a>
    </div>
@else
    <div class="alert alert-danger alert-install">
        <h5><i class="fas fa-exclamation-triangle"></i> Nie wszystkie wymagania są spełnione</h5>
        <p class="mb-2">Przed kontynuowaniem instalacji należy spełnić wszystkie wymagania systemowe:</p>
        <ul class="mb-0">
            @if(!$requirements['php_version']['status'])
                <li>Zaktualizuj PHP do wersji {{ $requirements['php_version']['required'] }} lub nowszej</li>
            @endif
            @foreach($requirements['extensions'] as $extension => $status)
                @if(!$status)
                    <li>Zainstaluj rozszerzenie PHP: {{ $extension }}</li>
                @endif
            @endforeach
            @foreach($requirements['permissions'] as $directory => $writable)
                @if(!$writable)
                    <li>Nadaj uprawnienia zapisu dla katalogu: {{ str_replace('_', '/', $directory) }}</li>
                @endif
            @endforeach
        </ul>
    </div>
    
    <div class="d-flex justify-content-between">
        <a href="{{ route('install.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
        <a href="{{ route('install.requirements') }}" class="btn btn-warning">
            <i class="fas fa-sync-alt"></i> Sprawdź ponownie
        </a>
    </div>
@endif
@endsection