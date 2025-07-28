@extends('layouts.app')

@section('title', 'Harmonogram przeglądów zestawów sprzętu wysokościowego')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-calendar-check"></i> Harmonogram przeglądów zestawów</h2>
    <div>
        <a href="{{ route('height-equipment-sets.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i> Powrót do listy
        </a>
        <a href="{{ route('height-equipment.inspections') }}" class="btn btn-outline-info me-2">
            <i class="fas fa-calendar"></i> Przeglądy elementów
        </a>
        <a href="{{ route('height-equipment-sets.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj zestaw
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
                <small class="text-muted">Z przeterminowanymi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h4 class="text-warning mb-0">{{ $stats['due_soon'] }}</h4>
                <small class="text-muted">Z pilnymi (30 dni)</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                <h4 class="text-info mb-0">{{ $stats['upcoming'] }}</h4>
                <small class="text-muted">Z nadchodzącymi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <i class="fas fa-question fa-2x text-secondary mb-2"></i>
                <h4 class="text-secondary mb-0">{{ $stats['no_date'] }}</h4>
                <small class="text-muted">Bez dat</small>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('height-equipment-sets.inspections') }}" class="row g-3">
            <div class="col-md-4">
                <label for="filter" class="form-label">Filtruj według statusu</label>
                <select class="form-select" id="filter" name="filter">
                    <option value="">Wszystkie zestawy</option>
                    <option value="overdue" {{ request('filter') == 'overdue' ? 'selected' : '' }}>Z przeterminowanymi elementami</option>
                    <option value="due_soon" {{ request('filter') == 'due_soon' ? 'selected' : '' }}>Z pilnymi elementami (30 dni)</option>
                    <option value="upcoming" {{ request('filter') == 'upcoming' ? 'selected' : '' }}>Z nadchodzącymi (90 dni)</option>
                    <option value="no_date" {{ request('filter') == 'no_date' ? 'selected' : '' }}>Z elementami bez dat</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-filter"></i> Filtruj
                </button>
                <a href="{{ route('height-equipment-sets.inspections') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Sets Inspections Table -->
<div class="card">
    <div class="card-body">
        @if($heightEquipmentSets->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Zestaw</th>
                            <th>Lokalizacja</th>
                            <th>Elementy w zestawie</th>
                            <th>Status przeglądów</th>
                            <th>Najwcześniejszy przegląd</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($heightEquipmentSets as $set)
                        <tr>
                            <td>
                                <a href="{{ route('height-equipment-sets.show', $set) }}" class="text-decoration-none">
                                    <strong>{{ $set->name }}</strong>
                                </a>
                                @if($set->code)
                                    <br><small class="text-muted">Kod: {{ $set->code }}</small>
                                @endif
                                @if($set->description)
                                    <br><small class="text-muted">{{ Str::limit($set->description, 40) }}</small>
                                @endif
                            </td>
                            <td>{{ $set->location ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $set->heightEquipment->count() }}</span>
                                <br><small class="text-muted">elementów</small>
                            </td>
                            <td>
                                @php
                                    $overdueCount = $set->heightEquipment->where('next_inspection_date', '<', now())->count();
                                    $dueSoonCount = $set->heightEquipment->whereBetween('next_inspection_date', [now(), now()->addDays(30)])->count();
                                    $upcomingCount = $set->heightEquipment->whereBetween('next_inspection_date', [now()->addDays(30), now()->addDays(90)])->count();
                                    $noDateCount = $set->heightEquipment->whereNull('next_inspection_date')->count();
                                @endphp
                                
                                @if($overdueCount > 0)
                                    <span class="badge bg-danger">{{ $overdueCount }} przeterminowane</span><br>
                                @endif
                                @if($dueSoonCount > 0)
                                    <span class="badge bg-warning">{{ $dueSoonCount }} pilne</span><br>
                                @endif
                                @if($upcomingCount > 0)
                                    <span class="badge bg-info">{{ $upcomingCount }} nadchodzące</span><br>
                                @endif
                                @if($noDateCount > 0)
                                    <span class="badge bg-secondary">{{ $noDateCount }} bez daty</span><br>
                                @endif
                                
                                @if($overdueCount == 0 && $dueSoonCount == 0 && $upcomingCount == 0 && $noDateCount == 0)
                                    <span class="badge bg-success">Wszystkie aktualne</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $nextInspection = $set->heightEquipment
                                        ->whereNotNull('next_inspection_date')
                                        ->sortBy('next_inspection_date')
                                        ->first();
                                @endphp
                                
                                @if($nextInspection)
                                    @php
                                        $daysUntil = now()->diffInDays($nextInspection->next_inspection_date, false);
                                        $isOverdue = $daysUntil < 0;
                                        $isDueSoon = $daysUntil >= 0 && $daysUntil <= 30;
                                        $badgeClass = $isOverdue ? 'danger' : ($isDueSoon ? 'warning' : 'success');
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">
                                        {{ $nextInspection->next_inspection_date->format('d.m.Y') }}
                                    </span>
                                    @if($isOverdue)
                                        <br><small class="text-danger">{{ abs($daysUntil) }} dni temu</small>
                                    @elseif($isDueSoon)
                                        <br><small class="text-warning">Za {{ $daysUntil }} dni</small>
                                    @endif
                                    <br><small class="text-muted">{{ $nextInspection->name }}</small>
                                @else
                                    <span class="badge bg-secondary">Brak dat</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $needsInspection = $overdueCount > 0 || $dueSoonCount > 0 || $noDateCount > 0;
                                @endphp
                                
                                <button type="button" class="btn btn-sm btn-outline-{{ $needsInspection ? 'warning' : 'primary' }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#setInspectionModal"
                                        onclick="openSetInspectionModal({{ $set->id }}, '{{ $set->name }}', {{ $set->heightEquipment->count() }})">
                                    <i class="fas fa-calendar-check"></i> 
                                    @if($needsInspection)
                                        Pilny przegląd
                                    @else
                                        Przegląd zestawu
                                    @endif
                                </button>
                                <a href="{{ route('height-equipment-sets.show', $set) }}" class="btn btn-sm btn-outline-secondary">
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
                {{ $heightEquipmentSets->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Brak zestawów do wyświetlenia</h5>
                <p class="text-muted">Zmień filtry lub dodaj nowy zestaw sprzętu wysokościowego</p>
            </div>
        @endif
    </div>
</div>

<!-- Set Inspection Modal -->
<div class="modal fade" id="setInspectionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Przegląd zestawu sprzętu wysokościowego</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="setInspectionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Uwaga:</strong> Przegląd zestawu zaktualizuje daty przeglądu dla <strong id="equipmentCount">0</strong> elementów sprzętu w tym zestawie.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Zestaw</label>
                        <input type="text" class="form-control" id="setName" readonly>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="set_last_inspection_date" class="form-label">Data wykonania przeglądu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="set_last_inspection_date" name="last_inspection_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="set_next_inspection_date" class="form-label">Data następnego przeglądu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="set_next_inspection_date" name="next_inspection_date" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="set_inspection_notes" class="form-label">Uwagi z przeglądu</label>
                        <textarea class="form-control" id="set_inspection_notes" name="inspection_notes" rows="4" 
                                  placeholder="Opcjonalne uwagi dotyczące przeglądu całego zestawu..."></textarea>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Ważne:</strong> Ta operacja zaktualizuje daty przeglądu dla wszystkich elementów w zestawie. Informacja o przeglądzie zostanie dodana do notatek każdego elementu oraz zestawu.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i> Przeprowadź przegląd zestawu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openSetInspectionModal(setId, setName, equipmentCount) {
    document.getElementById('setName').value = setName;
    document.getElementById('equipmentCount').textContent = equipmentCount;
    document.getElementById('setInspectionForm').action = '/height-equipment-sets/' + setId + '/inspection';
    
    // Set today's date for last inspection
    document.getElementById('set_last_inspection_date').value = new Date().toISOString().split('T')[0];
    
    // Calculate next inspection date (12 months from today)
    const nextDate = new Date();
    nextDate.setFullYear(nextDate.getFullYear() + 1);
    document.getElementById('set_next_inspection_date').value = nextDate.toISOString().split('T')[0];
    
    // Clear previous notes
    document.getElementById('set_inspection_notes').value = '';
}

// Auto-calculate next inspection date when last inspection changes
document.getElementById('set_last_inspection_date').addEventListener('change', function() {
    const lastDate = new Date(this.value);
    const nextDate = new Date(lastDate);
    nextDate.setFullYear(nextDate.getFullYear() + 1);
    document.getElementById('set_next_inspection_date').value = nextDate.toISOString().split('T')[0];
});
</script>
@endsection