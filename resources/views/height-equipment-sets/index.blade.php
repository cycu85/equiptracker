@extends('layouts.app')

@section('title', 'Zestawy sprzętu wysokościowego')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-hard-hat"></i> Zarządzanie zestawami sprzętu wysokościowego</h2>
    <div>
        <a href="{{ route('height-equipment-sets.inspections') }}" class="btn btn-outline-warning me-2">
            <i class="fas fa-calendar-check"></i> Harmonogram przeglądów
        </a>
        <a href="{{ route('height-equipment-sets.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj zestaw
        </a>
    </div>
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
                            <th>Status przeglądów</th>
                            <th>Akcje</th>
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
                                @php
                                    $overdueCount = $set->heightEquipment->where('next_inspection_date', '<', now())->count();
                                    $dueSoonCount = $set->heightEquipment->whereBetween('next_inspection_date', [now(), now()->addDays(30)])->count();
                                    $noDateCount = $set->heightEquipment->whereNull('next_inspection_date')->count();
                                    $totalCount = $set->heightEquipment->count();
                                    
                                    if ($overdueCount > 0) {
                                        $badgeClass = 'danger';
                                        $statusText = "Przeterminowane ({$overdueCount})";
                                    } elseif ($dueSoonCount > 0) {
                                        $badgeClass = 'warning';
                                        $statusText = "Pilne ({$dueSoonCount})";
                                    } elseif ($noDateCount > 0) {
                                        $badgeClass = 'secondary';
                                        $statusText = "Brak dat ({$noDateCount})";
                                    } else {
                                        $badgeClass = 'success';
                                        $statusText = 'Aktualne';
                                    }
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $statusText }}</span>
                                @if($totalCount > 0)
                                    <br><small class="text-muted">{{ $totalCount }} elementów</small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group-vertical btn-group-sm" role="group">
                                    @php
                                        $needsInspection = $overdueCount > 0 || $dueSoonCount > 0 || $noDateCount > 0;
                                    @endphp
                                    
                                    <button type="button" class="btn btn-outline-{{ $needsInspection ? 'warning' : 'primary' }} btn-sm mb-1" 
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
                                    
                                    <a href="{{ route('height-equipment-sets.show', $set) }}" class="btn btn-outline-secondary btn-sm mb-1">
                                        <i class="fas fa-eye"></i> Szczegóły
                                    </a>
                                    
                                    <a href="{{ route('height-equipment-sets.edit', $set) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edytuj
                                    </a>
                                </div>
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