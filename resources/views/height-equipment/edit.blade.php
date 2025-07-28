@extends('layouts.app')

@section('title', 'Edytuj sprzęt wysokościowy')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit"></i> Edytuj sprzęt wysokościowy</h2>
    <a href="{{ route('height-equipment.show', $heightEquipment) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót
    </a>
</div>

<form method="POST" action="{{ route('height-equipment.update', $heightEquipment) }}">
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
                                   id="name" name="name" value="{{ old('name', $heightEquipment->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="brand" class="form-label">Marka</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand', $heightEquipment->brand) }}">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model', $heightEquipment->model) }}">
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Numer seryjny</label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" 
                                   id="serial_number" name="serial_number" value="{{ old('serial_number', $heightEquipment->serial_number) }}">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="asset_tag" class="form-label">Tag zasobu</label>
                            <input type="text" class="form-control @error('asset_tag') is-invalid @enderror" 
                                   id="asset_tag" name="asset_tag" value="{{ old('asset_tag', $heightEquipment->asset_tag) }}">
                            @error('asset_tag')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Typ <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Wybierz typ</option>
                                @foreach($types as $key => $value)
                                    <option value="{{ $key }}" {{ old('type', $heightEquipment->type) == $key ? 'selected' : '' }}>{{ $value }}</option>
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
                                    <option value="{{ $key }}" {{ old('status', $heightEquipment->status) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Lokalizacja</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location', $heightEquipment->location) }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $heightEquipment->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notatki</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes', $heightEquipment->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-tools"></i> Specyfikacja techniczna</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="working_height" class="form-label">Wysokość robocza (m)</label>
                            <input type="number" step="0.1" class="form-control @error('working_height') is-invalid @enderror" 
                                   id="working_height" name="working_height" value="{{ old('working_height', $heightEquipment->working_height) }}">
                            @error('working_height')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="load_capacity" class="form-label">Nośność (kg)</label>
                            <input type="number" class="form-control @error('load_capacity') is-invalid @enderror" 
                                   id="load_capacity" name="load_capacity" value="{{ old('load_capacity', $heightEquipment->load_capacity) }}">
                            @error('load_capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="certifications" class="form-label">Certyfikaty</label>
                        <textarea class="form-control @error('certifications') is-invalid @enderror" 
                                  id="certifications" name="certifications" rows="2">{{ old('certifications', $heightEquipment->certifications) }}</textarea>
                        @error('certifications')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                                   id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $heightEquipment->purchase_date) }}">
                            @error('purchase_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="purchase_price" class="form-label">Cena zakupu (zł)</label>
                            <input type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror" 
                                   id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $heightEquipment->purchase_price) }}">
                            @error('purchase_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="warranty_expiry" class="form-label">Koniec gwarancji</label>
                            <input type="date" class="form-control @error('warranty_expiry') is-invalid @enderror" 
                                   id="warranty_expiry" name="warranty_expiry" value="{{ old('warranty_expiry', $heightEquipment->warranty_expiry) }}">
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
                        <i class="fas fa-ladder fa-3x text-primary me-3"></i>
                        <div>
                            <strong>{{ $heightEquipment->name }}</strong><br>
                            <small class="text-muted">{{ $heightEquipment->brand }} {{ $heightEquipment->model }}</small>
                        </div>
                    </div>
                    
                    <h6 class="mt-3">Statystyki</h6>
                    <ul class="small">
                        <li>Utworzony: {{ $heightEquipment->created_at->format('d.m.Y') }}</li>
                        <li>Ostatnia aktualizacja: {{ $heightEquipment->updated_at->format('d.m.Y') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('height-equipment.show', $heightEquipment) }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Anuluj
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Zapisz zmiany
        </button>
    </div>
</form>
@endsection