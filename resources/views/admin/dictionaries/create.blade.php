@extends('layouts.app')

@section('title', 'Dodaj element słownika')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Dodaj element słownika</h2>
    <a href="{{ route('admin.dictionaries.index', ['category' => $selectedCategory]) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do listy
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.dictionaries.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategoria <span class="text-danger">*</span></label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" name="category" required>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}" {{ old('category', $selectedCategory) === $key ? 'selected' : '' }}>
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
                                   id="key" name="key" value="{{ old('key') }}" required>
                            <div class="form-text">Unikalny identyfikator używany w kodzie (np. "available", "in_use")</div>
                            @error('key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="value" class="form-label">Wartość <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('value') is-invalid @enderror" 
                                   id="value" name="value" value="{{ old('value') }}" required>
                            <div class="form-text">Tekst wyświetlany użytkownikowi (np. "Dostępne", "W użyciu")</div>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        <div class="form-text">Opcjonalny opis elementu</div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label">Kolejność sortowania</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            <div class="form-text">Określa kolejność wyświetlania (mniejsza liczba = wyższa pozycja)</div>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Element aktywny
                                </label>
                                <div class="form-text">Nieaktywne elementy nie są wyświetlane w formularzach</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.dictionaries.index', ['category' => $selectedCategory]) }}" 
                           class="btn btn-secondary me-2">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Zapisz element
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-info-circle"></i> Informacje</h6>
            </div>
            <div class="card-body">
                <h6>Wymagane pola</h6>
                <ul class="small">
                    <li>Kategoria - do jakiego modułu należy element</li>
                    <li>Klucz - unikalny identyfikator w kodzie</li>
                    <li>Wartość - tekst wyświetlany użytkownikowi</li>
                </ul>
                
                <h6 class="mt-3">Przykłady kluczy</h6>
                <ul class="small">
                    <li><code>available</code> → "Dostępne"</li>
                    <li><code>in_use</code> → "W użyciu"</li>
                    <li><code>maintenance</code> → "Konserwacja"</li>
                </ul>
                
                <div class="alert alert-warning mt-3">
                    <small><i class="fas fa-exclamation-triangle"></i> Klucz musi być unikalny w obrębie kategorii i nie może zawierać spacji ani znaków specjalnych.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection