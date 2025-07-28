@extends('layouts.app')

@section('title', 'Panel Administracyjny')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-cogs"></i> Panel Administracyjny</h2>
    <div>
        <a href="{{ route('admin.modules') }}" class="btn btn-outline-primary">
            <i class="fas fa-puzzle-piece"></i> Moduły
        </a>
        <a href="{{ route('admin.system-info') }}" class="btn btn-outline-info">
            <i class="fas fa-info-circle"></i> System
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Użytkownicy</h6>
                        <h2 class="mb-0">{{ $stats['users'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Pracownicy</h6>
                        <h2 class="mb-0">{{ $stats['employees'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-tie fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Narzędzia</h6>
                        <h2 class="mb-0">{{ $stats['tools'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tools fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Aktywne transfery</h6>
                        <h2 class="mb-0">{{ $stats['active_transfers'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exchange-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Equipment Statistics -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-ladder"></i> Sprzęt wysokościowy</h5>
            </div>
            <div class="card-body text-center">
                <h3 class="text-primary">{{ $stats['height_equipment'] }}</h3>
                <p class="text-muted mb-0">sztuk w systemie</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-laptop"></i> Sprzęt IT</h5>
            </div>
            <div class="card-body text-center">
                <h3 class="text-success">{{ $stats['it_equipment'] }}</h3>
                <p class="text-muted mb-0">sztuk w systemie</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-line"></i> Wszystkie transfery</h5>
            </div>
            <div class="card-body text-center">
                <h3 class="text-warning">{{ $stats['transfers'] }}</h3>
                <p class="text-muted mb-0">łącznie wykonanych</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Modules Status -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-puzzle-piece"></i> Status modułów</h5>
            </div>
            <div class="card-body">
                @if($modules->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($modules as $module)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <i class="{{ $module->icon }} me-2"></i>
                                <strong>{{ $module->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $module->description }}</small>
                            </div>
                            <div>
                                @if($module->is_enabled)
                                    <span class="badge bg-success">Aktywny</span>
                                @else
                                    <span class="badge bg-secondary">Nieaktywny</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.modules') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-cog"></i> Zarządzaj modułami
                        </a>
                    </div>
                @else
                    <p class="text-muted">Brak modułów w systemie</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Users -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user-plus"></i> Ostatnio zarejestrowani</h5>
            </div>
            <div class="card-body">
                @if($recentUsers->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentUsers as $user)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <strong>{{ $user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                    {{ $user->role === 'admin' ? 'Admin' : 'Użytkownik' }}
                                </span>
                                <br>
                                <small class="text-muted">{{ $user->created_at->format('d.m.Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Brak ostatnio zarejestrowanych użytkowników</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-bolt"></i> Szybkie akcje</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('admin.modules') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-puzzle-piece d-block mb-2"></i>
                            Zarządzaj modułami
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.data-management') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-database d-block mb-2"></i>
                            Zarządzanie danymi
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.system-info') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-info-circle d-block mb-2"></i>
                            Informacje o systemie
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left d-block mb-2"></i>
                            Powrót do dashboardu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection