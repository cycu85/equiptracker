@extends('layouts.app')

@section('title', 'Zestawy sprzętu wysokościowego')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-hard-hat"></i> Zarządzanie zestawami sprzętu wysokościowego</h2>
    <a href="{{ route('height-equipment-sets.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Dodaj zestaw
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('height-equipment-sets.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Wyszukaj</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nazwa, kod, opis...">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Wszystkie</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktywny</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nieaktywny</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Konserwacja</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="location" class="form-label">Lokalizacja</label>
                <input type="text" class="form-control" id="location" name="location" 
                       value="{{ request('location') }}" placeholder="Magazyn, budowa...">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-search"></i> Filtruj
                </button>
                <a href="{{ route('height-equipment-sets.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Height Equipment Sets Table -->
<div class="card">
    <div class="card-body">
        @if($heightEquipmentSets->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <x-sortable-header field="id" title="ID" />
                            <x-sortable-header field="name" title="Nazwa" />
                            <x-sortable-header field="code" title="Kod" />
                            <th>Sprzęt</th>
                            <x-sortable-header field="status" title="Status" />
                            <th>Kompletność</th>
                            <x-sortable-header field="location" title="Lokalizacja" />
                            <th>Wartość</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($heightEquipmentSets as $set)
                        <tr>
                            <td>{{ $set->id }}</td>
                            <td>
                                <a href="{{ route('height-equipment-sets.show', $set) }}" class="text-decoration-none">
                                    <strong>{{ $set->name }}</strong>
                                </a>
                                @if($set->description)
                                    <br><small class="text-muted">{{ Str::limit($set->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($set->code)
                                    <code>{{ $set->code }}</code>
                                @else
                                    <span class="text-muted">Brak</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $set->heightEquipment->count() }}</span>
                                @if($set->total_equipment_count != $set->heightEquipment->count())
                                    <small class="text-muted">({{ $set->total_equipment_count }} szt.)</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $set->status_badge }}">
                                    {{ $set->status_label }}
                                </span>
                            </td>
                            <td>
                                @if($set->completion_status === 'complete')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Kompletny
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Niekompletny
                                    </span>
                                @endif
                            </td>
                            <td>{{ $set->location ?? 'Nieznana' }}</td>
                            <td>
                                @if($set->calculated_total_value > 0)
                                    {{ number_format($set->calculated_total_value, 2, ',', ' ') }} zł
                                @else
                                    <span class="text-muted">Brak danych</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Wyświetlono {{ $heightEquipmentSets->firstItem() }}-{{ $heightEquipmentSets->lastItem() }} z {{ $heightEquipmentSets->total() }} zestawów
                </div>
                {{ $heightEquipmentSets->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-hard-hat fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Brak zestawów sprzętu wysokościowego do wyświetlenia</h5>
                <p class="text-muted">Dodaj pierwszy zestaw do systemu</p>
                <a href="{{ route('height-equipment-sets.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Dodaj zestaw
                </a>
            </div>
        @endif
    </div>
</div>
@endsection