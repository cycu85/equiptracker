@extends('layouts.app')

@section('title', 'Harmonogram przeglądów sprzętu wysokościowego')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-calendar-check"></i> Harmonogram przeglądów sprzętu wysokościowego</h2>
    <div>
        <a href="{{ route('height-equipment.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i> Powrót do listy
        </a>
        <a href="{{ route('height-equipment.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj sprzęt
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-danger">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                <h4 class="text-danger mb-0">{{ $stats['overdue'] }}</h4>
                <small class="text-muted">Przeterminowane</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h4 class="text-warning mb-0">{{ $stats['due_soon'] }}</h4>
                <small class="text-muted">W ciągu 30 dni</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                <h4 class="text-info mb-0">{{ $stats['upcoming'] }}</h4>
                <small class="text-muted">W ciągu 90 dni</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <i class="fas fa-question fa-2x text-secondary mb-2"></i>
                <h4 class="text-secondary mb-0">{{ $stats['no_date'] }}</h4>
                <small class="text-muted">Bez daty</small>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('height-equipment.inspections') }}" class="row g-3">
            <div class="col-md-4">
                <label for="filter" class="form-label">Filtruj według statusu</label>
                <select class="form-select" id="filter" name="filter">
                    <option value="">Wszystkie</option>
                    <option value="overdue" {{ request('filter') == 'overdue' ? 'selected' : '' }}>Przeterminowane</option>
                    <option value="due_soon" {{ request('filter') == 'due_soon' ? 'selected' : '' }}>W ciągu 30 dni</option>
                    <option value="upcoming" {{ request('filter') == 'upcoming' ? 'selected' : '' }}>W ciągu 90 dni</option>
                    <option value="no_date" {{ request('filter') == 'no_date' ? 'selected' : '' }}>Bez daty przeglądu</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-filter"></i> Filtruj
                </button>
                <a href="{{ route('height-equipment.inspections') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Inspections Table -->
<div class="card">
    <div class="card-body">
        @if($heightEquipment->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Sprzęt</th>
                            <th>Typ</th>
                            <th>Lokalizacja</th>
                            <th>Ostatni przegląd</th>
                            <th>Następny przegląd</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($heightEquipment as $equipment)
                        <tr>
                            <td>
                                <a href="{{ route('height-equipment.show', $equipment) }}" class="text-decoration-none">
                                    <strong>{{ $equipment->name }}</strong>
                                </a>
                                @if($equipment->brand || $equipment->model)
                                    <br><small class="text-muted">{{ $equipment->brand }} {{ $equipment->model }}</small>
                                @endif
                                @if($equipment->serial_number)
                                    <br><small class="text-muted">S/N: {{ $equipment->serial_number }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $equipment->type }}</span>
                            </td>
                            <td>{{ $equipment->location ?? '-' }}</td>
                            <td>
                                @if($equipment->last_inspection_date)
                                    {{ $equipment->last_inspection_date->format('d.m.Y') }}
                                @else
                                    <span class="text-muted">Brak danych</span>
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
                                        @if($isOverdue)
                                            ({{ abs($daysUntil) }} dni temu)
                                        @elseif($isDueSoon)
                                            (za {{ $daysUntil }} dni)
                                        @endif
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Nie ustawiono</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    if (!$equipment->next_inspection_date) {
                                        $statusClass = 'secondary';
                                        $statusText = 'Nie ustawiono';
                                    } elseif ($equipment->next_inspection_date->isPast()) {
                                        $statusClass = 'danger';
                                        $statusText = 'Przeterminowany';
                                    } elseif ($equipment->next_inspection_date->diffInDays() <= 30) {
                                        $statusClass = 'warning';
                                        $statusText = 'Pilny';
                                    } else {
                                        $statusClass = 'success';
                                        $statusText = 'Aktualny';
                                    }
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#inspectionModal"
                                        onclick="openInspectionModal({{ $equipment->id }}, '{{ $equipment->name }}', '{{ $equipment->last_inspection_date?->format('Y-m-d') }}', '{{ $equipment->next_inspection_date?->format('Y-m-d') }}')">
                                    <i class="fas fa-calendar-check"></i> Przegląd
                                </button>
                                <a href="{{ route('height-equipment.show', $equipment) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $heightEquipment->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Brak sprzętu do wyświetlenia</h5>
                <p class="text-muted">Zmień filtry lub dodaj nowy sprzęt wysokościowy</p>
            </div>
        @endif
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
function openInspectionModal(equipmentId, equipmentName, lastInspection, nextInspection) {
    document.getElementById('equipmentName').value = equipmentName;
    document.getElementById('inspectionForm').action = '/height-equipment/' + equipmentId + '/inspection';
    
    // Set today's date for last inspection if not set
    if (lastInspection) {
        document.getElementById('last_inspection_date').value = lastInspection;
    } else {
        document.getElementById('last_inspection_date').value = new Date().toISOString().split('T')[0];
    }
    
    // Calculate next inspection date (12 months from today)
    const nextDate = new Date();
    nextDate.setFullYear(nextDate.getFullYear() + 1);
    document.getElementById('next_inspection_date').value = nextDate.toISOString().split('T')[0];
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