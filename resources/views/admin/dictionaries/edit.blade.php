@extends('layouts.app')

@section('title', 'Edytuj element słownika')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit"></i> Edytuj element słownika</h2>
    <a href="{{ route('admin.dictionaries.index', ['category' => $dictionary->category]) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do listy
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.dictionaries.update', $dictionary) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategoria <span class="text-danger">*</span></label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" name="category" required>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}" {{ old('category', $dictionary->category) === $key ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="key" class="form-label">Klucz <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('key') is-invalid @enderror" 
                                   id="key" name="key" value="{{ old('key', $dictionary->key) }}" required
                                   {{ $dictionary->is_system ? 'readonly' : '' }}>
                            <div class="form-text">
                                @if($dictionary->is_system)
                                    Klucz systemowy nie może być modyfikowany
                                @else
                                    Unikalny identyfikator używany w kodzie (np. "available", "in_use")
                                @endif
                            </div>
                            @error('key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="value" class="form-label">Wartość <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('value') is-invalid @enderror" 
                                   id="value" name="value" value="{{ old('value', $dictionary->value) }}" required>
                            <div class="form-text">Tekst wyświetlany użytkownikowi (np. "Dostępne", "W użyciu")</div>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $dictionary->description) }}</textarea>
                        <div class="form-text">Opcjonalny opis elementu</div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label">Kolejność sortowania</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $dictionary->sort_order) }}" min="0">
                            <div class="form-text">Określa kolejność wyświetlania (mniejsza liczba = wyższa pozycja)</div>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $dictionary->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Element aktywny
                                </label>
                                <div class="form-text">Nieaktywne elementy nie są wyświetlane w formularzach</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.dictionaries.index', ['category' => $dictionary->category]) }}" 
                           class="btn btn-secondary me-2">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Zapisz zmiany
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-info-circle"></i> Informacje o elemencie</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Status elementu</h6>
                    @if($dictionary->is_system)
                        <span class="badge bg-warning">Systemowy</span>
                        <p class="small text-muted mt-2">Element systemowy - klucz nie może być modyfikowany, ale można zmienić wartość i opis.</p>
                    @else
                        <span class="badge bg-info">Własny</span>
                        <p class="small text-muted mt-2">Element dodany przez użytkownika - można modyfikować wszystkie pola.</p>
                    @endif
                </div>
                
                <div class="mb-3">
                    <h6>Informacje techniczne</h6>
                    <ul class="small">
                        <li><strong>ID:</strong> {{ $dictionary->id }}</li>
                        <li><strong>Kategoria:</strong> {{ $dictionary->category_display_name }}</li>
                        <li><strong>Utworzony:</strong> {{ $dictionary->created_at->format('d.m.Y H:i') }}</li>
                        <li><strong>Modyfikowany:</strong> {{ $dictionary->updated_at->format('d.m.Y H:i') }}</li>
                    </ul>
                </div>
                
                @if($dictionary->is_system)
                    <div class="alert alert-warning">
                        <small><i class="fas fa-exclamation-triangle"></i> Elementów systemowych nie można usuwać, ponieważ są używane przez aplikację.</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection