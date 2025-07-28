@extends('layouts.app')

@section('title', 'Edytuj sprzęt IT')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit"></i> Edytuj sprzęt IT</h2>
    <a href="{{ route('it-equipment.show', $itEquipment) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót
    </a>
</div>

<form method="POST" action="{{ route('it-equipment.update', $itEquipment) }}">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle"></i> Informacje podstawowe</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nazwa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $itEquipment->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="brand" class="form-label">Marka</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand', $itEquipment->brand) }}">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model', $itEquipment->model) }}">
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Numer seryjny</label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" 
                                   id="serial_number" name="serial_number" value="{{ old('serial_number', $itEquipment->serial_number) }}">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="asset_tag" class="form-label">Tag zasobu</label>
                            <input type="text" class="form-control @error('asset_tag') is-invalid @enderror" 
                                   id="asset_tag" name="asset_tag" value="{{ old('asset_tag', $itEquipment->asset_tag) }}">
                            @error('asset_tag')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Typ <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Wybierz typ</option>
                                @foreach($types as $key => $value)
                                    <option value="{{ $key }}" {{ old('type', $itEquipment->type) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                @foreach($statuses as $key => $value)
                                    <option value="{{ $key }}" {{ old('status', $itEquipment->status) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Lokalizacja</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location', $itEquipment->location) }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $itEquipment->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notatki</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes', $itEquipment->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-microchip"></i> Specyfikacja techniczna</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="operating_system" class="form-label">System operacyjny</label>
                            <select class="form-select @error('operating_system') is-invalid @enderror" id="operating_system" name="operating_system">
                                <option value="">Wybierz system</option>
                                @foreach($operatingSystems as $key => $value)
                                    <option value="{{ $key }}" {{ old('operating_system', $itEquipment->operating_system) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('operating_system')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="specifications" class="form-label">Specyfikacja</label>
                            <input type="text" class="form-control @error('specifications') is-invalid @enderror" 
                                   id="specifications" name="specifications" value="{{ old('specifications', $itEquipment->specifications) }}">
                            @error('specifications')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mac_address" class="form-label">Adres MAC</label>
                            <input type="text" class="form-control @error('mac_address') is-invalid @enderror" 
                                   id="mac_address" name="mac_address" value="{{ old('mac_address', $itEquipment->mac_address) }}"
                                   placeholder="00:1B:63:84:45:E6">
                            @error('mac_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="ip_address" class="form-label">Adres IP</label>
                            <input type="text" class="form-control @error('ip_address') is-invalid @enderror" 
                                   id="ip_address" name="ip_address" value="{{ old('ip_address', $itEquipment->ip_address) }}"
                                   placeholder="192.168.1.100">
                            @error('ip_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-shopping-cart"></i> Informacje zakupowe</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="purchase_date" class="form-label">Data zakupu</label>
                            <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                                   id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $itEquipment->purchase_date) }}">
                            @error('purchase_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="purchase_price" class="form-label">Cena zakupu (zł)</label>
                            <input type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror" 
                                   id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $itEquipment->purchase_price) }}">
                            @error('purchase_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="warranty_expiry" class="form-label">Koniec gwarancji</label>
                            <input type="date" class="form-control @error('warranty_expiry') is-invalid @enderror" 
                                   id="warranty_expiry" name="warranty_expiry" value="{{ old('warranty_expiry', $itEquipment->warranty_expiry) }}">
                            @error('warranty_expiry')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle"></i> Informacje</h5>
                </div>
                <div class="card-body">
                    <h6>Edytowany sprzęt</h6>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-laptop fa-3x text-primary me-3"></i>
                        <div>
                            <strong>{{ $itEquipment->name }}</strong><br>
                            <small class="text-muted">{{ $itEquipment->brand }} {{ $itEquipment->model }}</small>
                        </div>
                    </div>
                    
                    <h6 class="mt-3">Statystyki</h6>
                    <ul class="small">
                        <li>Utworzony: {{ $itEquipment->created_at->format('d.m.Y') }}</li>
                        <li>Ostatnia aktualizacja: {{ $itEquipment->updated_at->format('d.m.Y') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('it-equipment.show', $itEquipment) }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Anuluj
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Zapisz zmiany
        </button>
    </div>
</form>
@endsection