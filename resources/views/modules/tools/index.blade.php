@extends('layouts.app')

@section('title', 'Narzędzia')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tools"></i> Zarządzanie narzędziami</h2>
    <a href="{{ route('tools.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Dodaj narzędzie
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('tools.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Wyszukaj</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nazwa, marka, model...">
            </div>
            <div class="col-md-2">
                <label for="category" class="form-label">Kategoria</label>
                <select class="form-select" id="category" name="category">
                    <option value="">Wszystkie</option>
                    <option value="narzędzia ręczne" {{ request('category') == 'narzędzia ręczne' ? 'selected' : '' }}>Narzędzia ręczne</option>
                    <option value="elektronarzędzia" {{ request('category') == 'elektronarzędzia' ? 'selected' : '' }}>Elektronarzędzia</option>
                    <option value="maszyny" {{ request('category') == 'maszyny' ? 'selected' : '' }}>Maszyny</option>
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
                       value="{{ request('location') }}" placeholder="Magazyn, budova...">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-search"></i> Filtruj
                </button>
                <a href="{{ route('tools.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tools Table -->
<div class="card">
    <div class="card-body">
        @if($tools->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <x-sortable-header field="id" title="ID" />
                            <x-sortable-header field="name" title="Nazwa" />
                            <x-sortable-header field="brand" title="Marka/Model" />
                            <x-sortable-header field="category" title="Kategoria" />
                            <x-sortable-header field="status" title="Status" />
                            <x-sortable-header field="location" title="Lokalizacja" />
                            <th>Następny przegląd</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tools as $tool)
                        <tr>
                            <td>{{ $tool->id }}</td>
                            <td>
                                <a href="{{ route('tools.show', $tool) }}" class="text-decoration-none">
                                    <strong>{{ $tool->name }}</strong>
                                </a>
                                @if($tool->serial_number)
                                    <br><small class="text-muted">S/N: {{ $tool->serial_number }}</small>
                                @endif
                            </td>
                            <td>
                                @if($tool->brand || $tool->model)
                                    {{ $tool->brand }} {{ $tool->model }}
                                @else
                                    <span class="text-muted">Brak danych</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $tool->category }}</span>
                            </td>
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
                            <td>{{ $tool->location ?? 'Nieznana' }}</td>
                            <td>
                                @if($tool->next_inspection_date)
                                    <span class="text-{{ $tool->next_inspection_date->isPast() ? 'danger' : ($tool->next_inspection_date->diffInDays() < 30 ? 'warning' : 'muted') }}">
                                        {{ $tool->next_inspection_date->format('d.m.Y') }}
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
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $tools->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tools fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Brak narzędzi do wyświetlenia</h5>
                <p class="text-muted">Dodaj pierwsze narzędzie do systemu</p>
                <a href="{{ route('tools.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Dodaj narzędzie
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
</script>
@endsection