@extends('layouts.app')

@section('title', 'Dodaj nową rolę')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Dodaj nową rolę</h2>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót
    </a>
</div>

<form method="POST" action="{{ route('admin.roles.store') }}">
    @csrf
    
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
                                   id="name" name="name" value="{{ old('name') }}" required>
                            <small class="text-muted">Nazwa systemowa (np. manager, supervisor)</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="display_name" class="form-label">Nazwa wyświetlana <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                   id="display_name" name="display_name" value="{{ old('display_name') }}" required>
                            <small class="text-muted">Nazwa widoczna dla użytkowników</small>
                            @error('display_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
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
                                                   {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
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
                    <h5><i class="fas fa-lightbulb"></i> Wskazówki</h5>
                </div>
                <div class="card-body">
                    <h6>Tworzenie ról</h6>
                    <ul class="small">
                        <li>Nazwa roli musi być unikalna</li>
                        <li>Używaj prostych nazw bez spacji</li>
                        <li>Przypisuj tylko niezbędne uprawnienia</li>
                        <li>Opis pomoże innym administratorom</li>
                    </ul>
                    
                    <h6 class="mt-3">Typy uprawnień</h6>
                    <ul class="small">
                        <li><strong>Przeglądanie:</strong> Dostęp do listy</li>
                        <li><strong>Tworzenie:</strong> Dodawanie nowych</li>
                        <li><strong>Edycja:</strong> Modyfikacja istniejących</li>
                        <li><strong>Usuwanie:</strong> Kasowanie elementów</li>
                        <li><strong>Zarządzanie:</strong> Pełny dostęp</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Anuluj
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Utwórz rolę
        </button>
    </div>
</form>
@endsection