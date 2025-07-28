@extends('layouts.app')

@section('title', 'Dodaj narzędzie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Dodaj nowe narzędzie</h2>
    <a href="{{ route('tools.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do listy
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('tools.store') }}">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label">Nazwa narzędzia <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="category" class="form-label">Kategoria <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Wybierz kategorię</option>
                                @foreach($categories as $key => $value)
                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="brand" class="form-label">Marka</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand') }}">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model') }}">
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="serial_number" class="form-label">Numer seryjny</label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" 
                                   id="serial_number" name="serial_number" value="{{ old('serial_number') }}">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status and Location -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                @foreach($statuses as $key => $value)
                                    <option value="{{ $key }}" {{ old('status', 'available') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Lokalizacja</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}" 
                                   placeholder="np. Magazyn A, Budova 1, Warsztat">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Purchase Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="purchase_date" class="form-label">Data zakupu</label>
                            <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                                   id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                            @error('purchase_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="purchase_price" class="form-label">Cena zakupu (PLN)</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('purchase_price') is-invalid @enderror" 
                                   id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}">
                            @error('purchase_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Inspection Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="next_inspection_date" class="form-label">Data następnego przeglądu</label>
                            <input type="date" class="form-control @error('next_inspection_date') is-invalid @enderror" 
                                   id="next_inspection_date" name="next_inspection_date" value="{{ old('next_inspection_date') }}">
                            @error('next_inspection_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inspection_interval_months" class="form-label">Interwał przeglądów (miesiące)</label>
                            <input type="number" min="1" max="60" class="form-control @error('inspection_interval_months') is-invalid @enderror" 
                                   id="inspection_interval_months" name="inspection_interval_months" value="{{ old('inspection_interval_months', 12) }}">
                            @error('inspection_interval_months')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Uwagi</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('tools.index') }}" class="btn btn-secondary me-2">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Zapisz narzędzie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Informacje</h5>
            </div>
            <div class="card-body">
                <h6>Wymagane pola</h6>
                <ul class="small">
                    <li>Nazwa narzędzia</li>
                    <li>Kategoria</li>
                    <li>Status</li>
                </ul>
                
                <h6 class="mt-3">Kategorie narzędzi</h6>
                <ul class="small">
                    <li><strong>Narzędzia ręczne:</strong> młotki, śrubokręty, klucze</li>
                    <li><strong>Elektronarzędzia:</strong> wiertarki, szlifierki, piły</li>
                    <li><strong>Maszyny:</strong> tokarki, frezarki, prasy</li>
                    <li><strong>Narzędzia pomiarowe:</strong> suwmiarki, mikrometry</li>
                </ul>
                
                <h6 class="mt-3">Statusy</h6>
                <ul class="small">
                    <li><span class="badge bg-success">Dostępne</span> - gotowe do użycia</li>
                    <li><span class="badge bg-warning">W użyciu</span> - przekazane pracownikowi</li>
                    <li><span class="badge bg-danger">Naprawa</span> - w serwisie</li>
                    <li><span class="badge bg-dark">Uszkodzone</span> - niesprawne</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection