@extends('layouts.app')

@section('title', 'Sprzęt wysokościowy')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-ladder"></i> Zarządzanie sprzętem wysokościowym</h2>
    <a href="{{ route('height-equipment.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Dodaj sprzęt
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('height-equipment.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Wyszukaj</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nazwa, marka, model...">
            </div>
            <div class="col-md-2">
                <label for="type" class="form-label">Typ</label>
                <select class="form-select" id="type" name="type">
                    <option value="">Wszystkie</option>
                    <option value="ladder" {{ request('type') == 'ladder' ? 'selected' : '' }}>Drabina</option>
                    <option value="scaffold" {{ request('type') == 'scaffold' ? 'selected' : '' }}>Rusztowanie</option>
                    <option value="platform" {{ request('type') == 'platform' ? 'selected' : '' }}>Platforma</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Wszystkie</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Dostępne</option>
                    <option value="in_use" {{ request('status') == 'in_use' ? 'selected' : '' }}>W użyciu</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Naprawa</option>
                    <option value="damaged" {{ request('status') == 'damaged' ? 'selected' : '' }}>Uszkodzone</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="location" class="form-label">Lokalizacja</label>
                <input type="text" class="form-control" id="location" name="location" 
                       value="{{ request('location') }}" placeholder="Magazyn, budowa...">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-search"></i> Filtruj
                </button>
                <a href="{{ route('height-equipment.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Height Equipment Table -->
<div class="card">
    <div class="card-body">
        @if($heightEquipment->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <x-sortable-header field="id" title="ID" />
                            <x-sortable-header field="name" title="Nazwa" />
                            <x-sortable-header field="brand" title="Marka/Model" />
                            <x-sortable-header field="type" title="Typ" />
                            <x-sortable-header field="status" title="Status" />
                            <x-sortable-header field="location" title="Lokalizacja" />
                            <th>Zestawy</th>
                            <th>Następny przegląd</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($heightEquipment as $equipment)
                        <tr>
                            <td>{{ $equipment->id }}</td>
                            <td>
                                <a href="{{ route('height-equipment.show', $equipment) }}" class="text-decoration-none">
                                    <strong>{{ $equipment->name }}</strong>
                                </a>
                                @if($equipment->serial_number)
                                    <br><small class="text-muted">S/N: {{ $equipment->serial_number }}</small>
                                @endif
                            </td>
                            <td>
                                @if($equipment->brand || $equipment->model)
                                    {{ $equipment->brand }} {{ $equipment->model }}
                                @else
                                    <span class="text-muted">Brak danych</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $equipment->type }}</span>
                            </td>
                            <td>
                                @switch($equipment->status)
                                    @case('available')
                                        <span class="badge bg-success">Dostępne</span>
                                        @break
                                    @case('in_use')
                                        <span class="badge bg-warning">W użyciu</span>
                                        @break
                                    @case('maintenance')
                                        <span class="badge bg-danger">Naprawa</span>
                                        @break
                                    @case('damaged')
                                        <span class="badge bg-dark">Uszkodzone</span>
                                        @break
                                    @case('retired')
                                        <span class="badge bg-secondary">Wycofane</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $equipment->location ?? 'Nieznana' }}</td>
                            <td>
                                @if($equipment->heightEquipmentSets->count() > 0)
                                    <span class="badge bg-info">{{ $equipment->heightEquipmentSets->count() }}</span>
                                    <small class="text-muted d-block">
                                        {{ $equipment->heightEquipmentSets->pluck('name')->take(2)->join(', ') }}
                                        @if($equipment->heightEquipmentSets->count() > 2)
                                            <br>+{{ $equipment->heightEquipmentSets->count() - 2 }} więcej
                                        @endif
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($equipment->next_inspection_date)
                                    <span class="text-{{ $equipment->next_inspection_date->isPast() ? 'danger' : ($equipment->next_inspection_date->diffInDays() < 30 ? 'warning' : 'muted') }}">
                                        {{ $equipment->next_inspection_date->format('d.m.Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">Brak</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-ladder fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Brak sprzętu wysokościowego do wyświetlenia</h5>
                <p class="text-muted">Dodaj pierwszy sprzęt do systemu</p>
                <a href="{{ route('height-equipment.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Dodaj sprzęt
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Potwierdź usunięcie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Czy na pewno chcesz usunąć sprzęt <strong id="equipmentName"></strong>?
                <br><small class="text-muted">Tej operacji nie można cofnąć.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Usuń</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(equipmentId, equipmentName) {
    document.getElementById('equipmentName').textContent = equipmentName;
    document.getElementById('deleteForm').action = '/height-equipment/' + equipmentId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection