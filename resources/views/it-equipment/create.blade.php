@extends('layouts.app')

@section('title', 'Dodaj sprzęt IT')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Dodaj nowy sprzęt IT</h2>
    <a href="{{ route('it-equipment.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do listy
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('it-equipment.store') }}">
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
                                <option value="laptop" {{ old('type') == 'laptop' ? 'selected' : '' }}>Laptop</option>
                                <option value="desktop" {{ old('type') == 'desktop' ? 'selected' : '' }}>Komputer</option>
                                <option value="monitor" {{ old('type') == 'monitor' ? 'selected' : '' }}>Monitor</option>
                                <option value="printer" {{ old('type') == 'printer' ? 'selected' : '' }}>Drukarka</option>
                                <option value="server" {{ old('type') == 'server' ? 'selected' : '' }}>Serwer</option>
                                <option value="tablet" {{ old('type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                <option value="phone" {{ old('type') == 'phone' ? 'selected' : '' }}>Telefon</option>
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
                            <label for="asset_tag" class="form-label">Tag inwentarzowy</label>
                            <input type="text" class="form-control @error('asset_tag') is-invalid @enderror" 
                                   id="asset_tag" name="asset_tag" value="{{ old('asset_tag') }}">
                            @error('asset_tag')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Numer seryjny</label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" 
                                   id="serial_number" name="serial_number" value="{{ old('serial_number') }}">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="operating_system" class="form-label">System operacyjny</label>
                            <input type="text" class="form-control @error('operating_system') is-invalid @enderror" 
                                   id="operating_system" name="operating_system" value="{{ old('operating_system') }}"
                                   placeholder="np. Windows 11, macOS, Linux">
                            @error('operating_system')
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

                    <div class="mb-3">
                        <label for="specifications" class="form-label">Specyfikacja techniczna</label>
                        <textarea class="form-control @error('specifications') is-invalid @enderror" 
                                  id="specifications" name="specifications" rows="3"
                                  placeholder="np. RAM: 16GB, CPU: Intel i7, SSD: 512GB">{{ old('specifications') }}</textarea>
                        @error('specifications')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status and Location -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktywne</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nieaktywne</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Naprawa</option>
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
                                   placeholder="np. Biuro IT, Sala konferencyjna">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Network Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ip_address" class="form-label">Adres IP</label>
                            <input type="text" class="form-control @error('ip_address') is-invalid @enderror" 
                                   id="ip_address" name="ip_address" value="{{ old('ip_address') }}"
                                   placeholder="np. 192.168.1.100">
                            @error('ip_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="mac_address" class="form-label">Adres MAC</label>
                            <input type="text" class="form-control @error('mac_address') is-invalid @enderror" 
                                   id="mac_address" name="mac_address" value="{{ old('mac_address') }}"
                                   placeholder="np. 00:11:22:33:44:55">
                            @error('mac_address')
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="warranty_expiry" class="form-label">Wygaśnięcie gwarancji</label>
                            <input type="date" class="form-control @error('warranty_expiry') is-invalid @enderror" 
                                   id="warranty_expiry" name="warranty_expiry" value="{{ old('warranty_expiry') }}">
                            @error('warranty_expiry')
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
                        <a href="{{ route('it-equipment.index') }}" class="btn btn-secondary me-2">Anuluj</a>
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
                    <li><strong>Laptop:</strong> przenośne komputery</li>
                    <li><strong>Komputer:</strong> stacjonarne PC</li>
                    <li><strong>Monitor:</strong> wyświetlacze LCD/LED</li>
                    <li><strong>Drukarka:</strong> urządzenia drukujące</li>
                    <li><strong>Serwer:</strong> serwery i NAS</li>
                </ul>
                
                <h6 class="mt-3">Statusy</h6>
                <ul class="small">
                    <li><span class="badge bg-success">Aktywne</span> - w użyciu</li>
                    <li><span class="badge bg-warning">Nieaktywne</span> - niekorzystane</li>
                    <li><span class="badge bg-danger">Naprawa</span> - w serwisie</li>
                    <li><span class="badge bg-secondary">Wycofane</span> - do wymiany</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection