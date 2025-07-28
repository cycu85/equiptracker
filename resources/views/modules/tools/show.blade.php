@extends('layouts.app')

@section('title', 'Szczegóły narzędzia')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tools"></i> Szczegóły narzędzia</h2>
    <div>
        <a href="{{ route('tools.edit', $tool) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edytuj
        </a>
        <a href="{{ route('tools.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>

<div class="row">
    <!-- Basic Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Informacje podstawowe</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Nazwa:</th>
                                <td>{{ $tool->name }}</td>
                            </tr>
                            <tr>
                                <th>Marka:</th>
                                <td>{{ $tool->brand ?? 'Brak danych' }}</td>
                            </tr>
                            <tr>
                                <th>Model:</th>
                                <td>{{ $tool->model ?? 'Brak danych' }}</td>
                            </tr>
                            <tr>
                                <th>Numer seryjny:</th>
                                <td>{{ $tool->serial_number ?? 'Brak danych' }}</td>
                            </tr>
                            <tr>
                                <th>Kategoria:</th>
                                <td>
                                    @if($tool->category)
                                        <span class="badge bg-info">{{ $tool->category }}</span>
                                    @else
                                        Brak danych
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Status:</th>
                                <td>
                                    @switch($tool->status)
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
                            </tr>
                            <tr>
                                <th>Lokalizacja:</th>
                                <td>{{ $tool->location ?? 'Nieznana' }}</td>
                            </tr>
                            <tr>
                                <th>Data zakupu:</th>
                                <td>{{ $tool->purchase_date ? $tool->purchase_date->format('d.m.Y') : 'Brak danych' }}</td>
                            </tr>
                            <tr>
                                <th>Cena zakupu:</th>
                                <td>{{ $tool->purchase_price ? number_format($tool->purchase_price, 2) . ' zł' : 'Brak danych' }}</td>
                            </tr>
                            <tr>
                                <th>Utworzono:</th>
                                <td>{{ $tool->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($tool->description)
                <div class="mt-3">
                    <h6>Opis:</h6>
                    <p class="text-muted">{{ $tool->description }}</p>
                </div>
                @endif
                
                @if($tool->notes)
                <div class="mt-3">
                    <h6>Notatki:</h6>
                    <p class="text-muted">{{ $tool->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Inspection Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-search"></i> Informacje o przeglądach</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>Ostatni przegląd:</h6>
                        <p class="text-muted">
                            {{ $tool->last_inspection_date ? $tool->last_inspection_date->format('d.m.Y') : 'Brak danych' }}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h6>Następny przegląd:</h6>
                        <p class="{{ $tool->next_inspection_date && $tool->next_inspection_date->isPast() ? 'text-danger' : ($tool->next_inspection_date && $tool->next_inspection_date->diffInDays() < 30 ? 'text-warning' : 'text-muted') }}">
                            {{ $tool->next_inspection_date ? $tool->next_inspection_date->format('d.m.Y') : 'Brak danych' }}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h6>Interwał przeglądów:</h6>
                        <p class="text-muted">
                            {{ $tool->inspection_interval_months ? $tool->inspection_interval_months . ' miesięcy' : 'Brak danych' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toolset Membership -->
        @if($tool->toolsets->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-toolbox"></i> Członkostwo w zestawach</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Zestaw</th>
                                <th>Ilość</th>
                                <th>Typ</th>
                                <th>Status zestawu</th>
                                <th>Notatki</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tool->toolsets as $toolset)
                                <tr>
                                    <td>
                                        <a href="{{ route('toolsets.show', $toolset) }}" class="text-decoration-none">
                                            <strong>{{ $toolset->name }}</strong>
                                        </a>
                                        @if($toolset->code)
                                            <br><small class="text-muted">Kod: {{ $toolset->code }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $toolset->pivot->quantity }}</span>
                                    </td>
                                    <td>
                                        @if($toolset->pivot->is_required)
                                            <span class="badge bg-danger">Wymagane</span>
                                        @else
                                            <span class="badge bg-secondary">Opcjonalne</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $toolset->status_badge }}">
                                            {{ $toolset->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($toolset->pivot->notes)
                                            <small class="text-muted">{{ $toolset->pivot->notes }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('toolsets.show', $toolset) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Status and Actions -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-cogs"></i> Akcje</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('tools.edit', $tool) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edytuj narzędzie
                    </a>
                    
                    @if($tool->status === 'available')
                        <button class="btn btn-warning" onclick="changeStatus('in_use')">
                            <i class="fas fa-play"></i> Wydaj narzędzie
                        </button>
                    @elseif($tool->status === 'in_use')
                        <button class="btn btn-success" onclick="changeStatus('available')">
                            <i class="fas fa-check"></i> Zwróć narzędzie
                        </button>
                    @endif
                    
                    @if($tool->status !== 'maintenance')
                        <button class="btn btn-warning" onclick="changeStatus('maintenance')">
                            <i class="fas fa-wrench"></i> Prześlij do naprawy
                        </button>
                    @endif
                    
                    <button class="btn btn-outline-danger" onclick="confirmDelete({{ $tool->id }}, '{{ $tool->name }}')">
                        <i class="fas fa-trash"></i> Usuń narzędzie
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar"></i> Statystyki</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <p class="mb-1"><strong>ID narzędzia</strong></p>
                    <h4 class="text-primary">#{{ $tool->id }}</h4>
                </div>
                
                @if($tool->next_inspection_date)
                <hr>
                <div class="text-center">
                    <p class="mb-1"><strong>Dni do przeglądu</strong></p>
                    <h4 class="{{ $tool->next_inspection_date->isPast() ? 'text-danger' : ($tool->next_inspection_date->diffInDays() < 30 ? 'text-warning' : 'text-success') }}">
                        @if($tool->next_inspection_date->isPast())
                            Przeterminowany!
                        @else
                            {{ $tool->next_inspection_date->diffInDays() }}
                        @endif
                    </h4>
                </div>
                @endif
            </div>
        </div>
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
                Czy na pewno chcesz usunąć narzędzie <strong id="toolName"></strong>?
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
function confirmDelete(toolId, toolName) {
    document.getElementById('toolName').textContent = toolName;
    document.getElementById('deleteForm').action = '/tools/' + toolId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function changeStatus(newStatus) {
    if (confirm('Czy na pewno chcesz zmienić status tego narzędzia?')) {
        // This would typically send an AJAX request to update the status
        // For now, we'll just redirect to edit page
        window.location.href = '{{ route("tools.edit", $tool) }}';
    }
}
</script>
@endsection