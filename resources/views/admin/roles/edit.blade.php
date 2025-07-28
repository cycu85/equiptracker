@extends('layouts.app')

@section('title', 'Edytuj rolę: ' . $role->display_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit"></i> Edytuj rolę: {{ $role->display_name }}</h2>
    <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót
    </a>
</div>

<form method="POST" action="{{ route('admin.roles.update', $role) }}">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle"></i> Podstawowe informacje</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nazwa roli <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $role->name) }}" required>
                            <small class="text-muted">Nazwa systemowa (np. manager, supervisor)</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="display_name" class="form-label">Nazwa wyświetlana <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                   id="display_name" name="display_name" value="{{ old('display_name', $role->display_name) }}" required>
                            <small class="text-muted">Nazwa widoczna dla użytkowników</small>
                            @error('display_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $role->description) }}</textarea>
                        <small class="text-muted">Opcjonalny opis roli</small>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-key"></i> Uprawnienia</h5>
                </div>
                <div class="card-body">
                    @foreach($permissions as $module => $modulePermissions)
                        <div class="mb-4">
                            <h6 class="text-primary">
                                <i class="fas fa-cube"></i> {{ $modules[$module] ?? $module }}
                            </h6>
                            <div class="row">
                                @foreach($modulePermissions as $permission)
                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="permissions[]" value="{{ $permission->id }}" 
                                                   id="permission_{{ $permission->id }}"
                                                   {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->display_name }}
                                                @if($permission->description)
                                                    <small class="text-muted d-block">{{ $permission->description }}</small>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle"></i> Informacje o roli</h5>
                </div>
                <div class="card-body">
                    <h6>Obecna rola</h6>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-user-shield fa-2x text-primary me-3"></i>
                        <div>
                            <strong>{{ $role->display_name }}</strong><br>
                            <small class="text-muted">{{ $role->name }}</small><br>
                            @if($role->is_system)
                                <span class="badge bg-warning">Systemowa</span>
                            @else
                                <span class="badge bg-success">Niestandardowa</span>
                            @endif
                        </div>
                    </div>
                    
                    <h6 class="mt-3">Statystyki</h6>
                    <ul class="small">
                        <li>Użytkowników: {{ $role->users->count() }}</li>
                        <li>Obecnych uprawnień: {{ $role->permissions->count() }}</li>
                        <li>Utworzona: {{ $role->created_at->format('d.m.Y') }}</li>
                        <li>Ostatnia aktualizacja: {{ $role->updated_at->format('d.m.Y') }}</li>
                    </ul>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5><i class="fas fa-lightbulb"></i> Wskazówki</h5>
                </div>
                <div class="card-body">
                    <h6>Edycja ról</h6>
                    <ul class="small">
                        <li>Zmiana uprawnień wpłynie na wszystkich użytkowników z tą rolą</li>
                        <li>Usuń tylko uprawnienia, które nie są potrzebne</li>
                        <li>Sprawdź wpływ zmian przed zapisaniem</li>
                    </ul>
                    
                    <h6 class="mt-3">Bezpieczeństwo</h6>
                    <ul class="small">
                        <li>Przypisuj minimalne niezbędne uprawnienia</li>
                        <li>Regularnie przeglądaj uprawnienia ról</li>
                        <li>Dokumentuj zmiany w opisie</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Anuluj
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Zapisz zmiany
        </button>
    </div>
</form>
@endsection