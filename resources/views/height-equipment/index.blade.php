@extends('layouts.app')

@section('title', 'Sprzęt wysokościowy')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-ladder"></i> Zarządzanie sprzętem wysokościowym</h2>
    <div>
        <a href="{{ route('height-equipment.inspections') }}" class="btn btn-outline-warning me-2">
            <i class="fas fa-calendar-check"></i> Harmonogram przeglądów
        </a>
        <a href="{{ route('height-equipment.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj sprzęt
        </a>
    </div>
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
                    @foreach($types as $key => $value)
                        <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Wszystkie</option>
                    @foreach($statuses as $key => $value)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
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
                <table class="table table-hover table-striped">
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
                            <th>Akcje</th>
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
                                    @php
                                        $daysUntil = now()->diffInDays($equipment->next_inspection_date, false);
                                        $isOverdue = $daysUntil < 0;
                                        $isDueSoon = $daysUntil >= 0 && $daysUntil <= 30;
                                        $badgeClass = $isOverdue ? 'danger' : ($isDueSoon ? 'warning' : 'success');
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">
                                        {{ $equipment->next_inspection_date->format('d.m.Y') }}
                                    </span>
                                    @if($isOverdue)
                                        <br><small class="text-danger">Przeterminowany o {{ abs($daysUntil) }} dni</small>
                                    @elseif($isDueSoon)
                                        <br><small class="text-warning">Za {{ $daysUntil }} dni</small>
                                    @endif
                                    @if($equipment->last_inspection_date)
                                        <br><small class="text-muted">Ostatni: {{ $equipment->last_inspection_date->format('d.m.Y') }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Nie ustawiono</span>
                                    <br><small class="text-muted">Brak harmonogramu</small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group-vertical btn-group-sm" role="group">
                                    @php
                                        $needsInspection = !$equipment->next_inspection_date || $equipment->next_inspection_date->isPast() || $equipment->next_inspection_date->diffInDays() <= 30;
                                    @endphp
                                    
                                    <button type="button" class="btn btn-outline-{{ $needsInspection ? 'warning' : 'primary' }} btn-sm mb-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#inspectionModal"
                                            onclick="openInspectionModal({{ $equipment->id }}, '{{ $equipment->name }}', '{{ $equipment->last_inspection_date?->format('Y-m-d') }}', '{{ $equipment->next_inspection_date?->format('Y-m-d') }}')">
                                        <i class="fas fa-calendar-check"></i>
                                        @if($needsInspection)
                                            Pilny przegląd
                                        @else
                                            Przegląd
                                        @endif
                                    </button>
                                    
                                    <a href="{{ route('height-equipment.show', $equipment) }}" class="btn btn-outline-secondary btn-sm mb-1">
                                        <i class="fas fa-eye"></i> Szczegóły
                                    </a>
                                    
                                    <a href="{{ route('height-equipment.edit', $equipment) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edytuj
                                    </a>
                                </div>
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

<!-- Inspection Modal -->
<div class="modal fade" id="inspectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejestracja przeglądu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="inspectionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Sprzęt</label>
                        <input type="text" class="form-control" id="equipmentName" readonly>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="last_inspection_date" class="form-label">Data wykonania przeglądu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="last_inspection_date" name="last_inspection_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="next_inspection_date" class="form-label">Data następnego przeglądu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="next_inspection_date" name="next_inspection_date" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="inspection_notes" class="form-label">Uwagi z przeglądu</label>
                        <textarea class="form-control" id="inspection_notes" name="inspection_notes" rows="3" 
                                  placeholder="Opcjonalne uwagi dotyczące przeglądu..."></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informacja:</strong> Przegląd zostanie zarejestrowany, a informacje o nim zostaną dodane do notatek sprzętu.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Zapisz przegląd
                    </button>
                </div>
            </form>
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

function openInspectionModal(equipmentId, equipmentName, lastInspection, nextInspection) {
    document.getElementById('equipmentName').value = equipmentName;
    document.getElementById('inspectionForm').action = '/height-equipment/' + equipmentId + '/inspection';
    
    // Set today's date for last inspection
    document.getElementById('last_inspection_date').value = new Date().toISOString().split('T')[0];
    
    // Calculate next inspection date (12 months from today)
    const nextDate = new Date();
    nextDate.setFullYear(nextDate.getFullYear() + 1);
    document.getElementById('next_inspection_date').value = nextDate.toISOString().split('T')[0];
    
    // Clear previous notes
    document.getElementById('inspection_notes').value = '';
}

// Auto-calculate next inspection date when last inspection changes
document.getElementById('last_inspection_date').addEventListener('change', function() {
    const lastDate = new Date(this.value);
    const nextDate = new Date(lastDate);
    nextDate.setFullYear(nextDate.getFullYear() + 1);
    document.getElementById('next_inspection_date').value = nextDate.toISOString().split('T')[0];
});
</script>
@endsection