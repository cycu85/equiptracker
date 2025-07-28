@extends('layouts.app')

@section('title', 'Podgląd roli: ' . $role->display_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-shield"></i> {{ $role->display_name }}</h2>
    <div>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
        @unless($role->is_system)
            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edytuj
            </a>
        @endunless
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Informacje o roli</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Nazwa systemowa:</strong>
                    </div>
                    <div class="col-sm-9">
                        <code>{{ $role->name }}</code>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Nazwa wyświetlana:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $role->display_name }}
                    </div>
                </div>

                @if($role->description)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Opis:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $role->description }}
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Typ:</strong>
                    </div>
                    <div class="col-sm-9">
                        @if($role->is_system)
                            <span class="badge bg-warning">Rola systemowa</span>
                        @else
                            <span class="badge bg-success">Rola niestandardowa</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Utworzona:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $role->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <strong>Ostatnia aktualizacja:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $role->updated_at->format('d.m.Y H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-key"></i> Uprawnienia ({{ $role->permissions->count() }})</h5>
            </div>
            <div class="card-body">
                @if($role->permissions->count() > 0)
                    @php
                        $groupedPermissions = $role->permissions->groupBy('module');
                    @endphp
                    @foreach($groupedPermissions as $module => $modulePermissions)
                        <div class="mb-4">
                            <h6 class="text-primary">
                                <i class="fas fa-cube"></i> {{ $modules[$module] ?? $module }}
                            </h6>
                            <div class="row">
                                @foreach($modulePermissions as $permission)
                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            <div>
                                                <strong>{{ $permission->display_name }}</strong>
                                                @if($permission->description)
                                                    <small class="text-muted d-block">{{ $permission->description }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-key fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Ta rola nie ma przypisanych uprawnień</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-users"></i> Użytkownicy ({{ $role->users->count() }})</h5>
            </div>
            <div class="card-body">
                @if($role->users->count() > 0)
                    @foreach($role->users as $user)
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-user-circle fa-2x text-primary me-3"></i>
                            <div>
                                <strong>{{ $user->name }}</strong><br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-users fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Brak użytkowników z tą rolą</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar"></i> Statystyki</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="mb-2">
                            <i class="fas fa-key fa-2x text-info"></i>
                        </div>
                        <h4 class="mb-0">{{ $role->permissions->count() }}</h4>
                        <small class="text-muted">Uprawnień</small>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                        <h4 class="mb-0">{{ $role->users->count() }}</h4>
                        <small class="text-muted">Użytkowników</small>
                    </div>
                </div>
            </div>
        </div>

        @unless($role->is_system)
            <div class="card mt-3">
                <div class="card-header">
                    <h5><i class="fas fa-cogs"></i> Akcje</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary btn-sm w-100 mb-2">
                        <i class="fas fa-edit"></i> Edytuj rolę
                    </a>
                    @if($role->users->count() == 0)
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100"
                                    onclick="return confirm('Czy na pewno chcesz usunąć tę rolę?')">
                                <i class="fas fa-trash"></i> Usuń rolę
                            </button>
                        </form>
                    @else
                        <button class="btn btn-danger btn-sm w-100" disabled title="Nie można usunąć roli przypisanej do użytkowników">
                            <i class="fas fa-trash"></i> Usuń rolę
                        </button>
                    @endif
                </div>
            </div>
        @endunless
    </div>
</div>
@endsection