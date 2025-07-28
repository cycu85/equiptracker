@extends('layouts.app')

@section('title', 'Dodaj sprzęt wysokościowy')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Dodaj nowy sprzęt wysokościowy</h2>
    <a href="{{ route('height-equipment.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do listy
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('height-equipment.store') }}">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label">Nazwa sprzętu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Typ <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Wybierz typ</option>
                                <option value="ladder" {{ old('type') == 'ladder' ? 'selected' : '' }}>Drabina</option>
                                <option value="scaffold" {{ old('type') == 'scaffold' ? 'selected' : '' }}>Rusztowanie</option>
                                <option value="platform" {{ old('type') == 'platform' ? 'selected' : '' }}>Platforma</option>
                                <option value="lift" {{ old('type') == 'lift' ? 'selected' : '' }}>Podnośnik</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Inne</option>
                            </select>
                            @error('type')
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
                                <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Dostępne</option>
                                <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>W użyciu</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Naprawa</option>
                                <option value="damaged" {{ old('status') == 'damaged' ? 'selected' : '' }}>Uszkodzone</option>
                                <option value="retired" {{ old('status') == 'retired' ? 'selected' : '' }}>Wycofane</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Lokalizacja</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}" 
                                   placeholder="np. Magazyn A, Budowa 1">
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

                    <!-- Technical Specifications -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="max_load_kg" class="form-label">Max. obciążenie (kg)</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('max_load_kg') is-invalid @enderror" 
                                   id="max_load_kg" name="max_load_kg" value="{{ old('max_load_kg') }}">
                            @error('max_load_kg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="working_height_m" class="form-label">Wysokość robocza (m)</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('working_height_m') is-invalid @enderror" 
                                   id="working_height_m" name="working_height_m" value="{{ old('working_height_m') }}">
                            @error('working_height_m')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="inspection_interval_months" class="form-label">Interwał przeglądów (miesiące)</label>
                            <input type="number" min="1" max="60" class="form-control @error('inspection_interval_months') is-invalid @enderror" 
                                   id="inspection_interval_months" name="inspection_interval_months" value="{{ old('inspection_interval_months', 12) }}">
                            @error('inspection_interval_months')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Inspection Information -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="last_inspection_date" class="form-label">Ostatni przegląd</label>
                            <input type="date" class="form-control @error('last_inspection_date') is-invalid @enderror" 
                                   id="last_inspection_date" name="last_inspection_date" value="{{ old('last_inspection_date') }}">
                            @error('last_inspection_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="next_inspection_date" class="form-label">Następny przegląd</label>
                            <input type="date" class="form-control @error('next_inspection_date') is-invalid @enderror" 
                                   id="next_inspection_date" name="next_inspection_date" value="{{ old('next_inspection_date') }}">
                            @error('next_inspection_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="certification_number" class="form-label">Numer certyfikatu</label>
                            <input type="text" class="form-control @error('certification_number') is-invalid @enderror" 
                                   id="certification_number" name="certification_number" value="{{ old('certification_number') }}">
                            @error('certification_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="certification_expiry" class="form-label">Wygaśnięcie certyfikatu</label>
                            <input type="date" class="form-control @error('certification_expiry') is-invalid @enderror" 
                                   id="certification_expiry" name="certification_expiry" value="{{ old('certification_expiry') }}">
                            @error('certification_expiry')
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
                        <a href="{{ route('height-equipment.index') }}" class="btn btn-secondary me-2">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Zapisz sprzęt
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
                    <li>Nazwa sprzętu</li>
                    <li>Typ</li>
                    <li>Status</li>
                </ul>
                
                <h6 class="mt-3">Typy sprzętu</h6>
                <ul class="small">
                    <li><strong>Drabina:</strong> przenośne, stałe</li>
                    <li><strong>Rusztowanie:</strong> ramowe, modułowe</li>
                    <li><strong>Platforma:</strong> robocze, mobilne</li>
                    <li><strong>Podnośnik:</strong> nożycowy, wysięgnikowy</li>
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