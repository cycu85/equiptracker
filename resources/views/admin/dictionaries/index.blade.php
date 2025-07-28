@extends('layouts.app')

@section('title', 'Zarządzanie słownikami')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-book"></i> Zarządzanie słownikami</h2>
    <a href="{{ route('admin.dictionaries.create', ['category' => $selectedCategory]) }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Dodaj element
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Category Tabs -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <h6>Kategorie słowników:</h6>
                <div class="btn-group flex-wrap" role="group">
                    @foreach($categories as $key => $name)
                        <a href="{{ route('admin.dictionaries.index', ['category' => $key]) }}" 
                           class="btn btn-sm {{ $selectedCategory === $key ? 'btn-primary' : 'btn-outline-primary' }}">
                            {{ $name }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.dictionaries.index') }}">
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="search" 
                               value="{{ request('search') }}" placeholder="Wyszukaj...">
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.dictionaries.index', ['category' => $selectedCategory]) }}" 
                               class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Dictionary Items -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-list"></i> {{ $categories[$selectedCategory] ?? $selectedCategory }}</h5>
    </div>
    <div class="card-body">
        @if($dictionaries->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover" id="dictionaryTable">
                    <thead>
                        <tr>
                            <th width="50">
                                <i class="fas fa-arrows-alt-v text-muted" title="Przeciągnij aby zmienić kolejność"></i>
                            </th>
                            <th>Klucz</th>
                            <th>Wartość</th>
                            <th>Opis</th>
                            <th width="80">Status</th>
                            <th width="100">Typ</th>
                            <th width="120">Akcje</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-dictionary">
                        @foreach($dictionaries as $dictionary)
                        <tr data-id="{{ $dictionary->id }}" data-sort="{{ $dictionary->sort_order }}">
                            <td class="handle text-center">
                                <i class="fas fa-grip-vertical text-muted"></i>
                            </td>
                            <td>
                                <code>{{ $dictionary->key }}</code>
                            </td>
                            <td>
                                <strong>{{ $dictionary->value }}</strong>
                            </td>
                            <td>
                                <small class="text-muted">{{ $dictionary->description ?? '-' }}</small>
                            </td>
                            <td>
                                @if($dictionary->is_active)
                                    <span class="badge bg-success">Aktywny</span>
                                @else
                                    <span class="badge bg-secondary">Nieaktywny</span>
                                @endif
                            </td>
                            <td>
                                @if($dictionary->is_system)
                                    <span class="badge bg-warning">Systemowy</span>
                                @else
                                    <span class="badge bg-info">Własny</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.dictionaries.edit', $dictionary) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$dictionary->is_system)
                                        <form method="POST" action="{{ route('admin.dictionaries.destroy', $dictionary) }}" 
                                              class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć ten element?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled title="Elementu systemowego nie można usunąć">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($dictionaries->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $dictionaries->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Brak elementów w tej kategorii</h5>
                <p class="text-muted">Dodaj pierwszy element do słownika</p>
                <a href="{{ route('admin.dictionaries.create', ['category' => $selectedCategory]) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Dodaj element
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Help Card -->
<div class="card mt-4">
    <div class="card-header">
        <h6><i class="fas fa-question-circle"></i> Informacje o słownikach</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Typy elementów:</h6>
                <ul class="small">
                    <li><span class="badge bg-warning">Systemowy</span> - nie można usunąć, podstawowy element systemu</li>
                    <li><span class="badge bg-info">Własny</span> - dodany przez użytkownika, można edytować i usuwać</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6>Funkcje:</h6>
                <ul class="small">
                    <li>Przeciągnij rzędy aby zmienić kolejność wyświetlania</li>
                    <li>Nieaktywne elementy nie są wyświetlane w formularzach</li>
                    <li>Klucz musi być unikalny w obrębie kategorii</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('sortable-dictionary');
    if (tbody) {
        new Sortable(tbody, {
            animation: 150,
            handle: '.handle',
            onEnd: function(evt) {
                updateSortOrder();
            }
        });
    }
});

function updateSortOrder() {
    const rows = document.querySelectorAll('#sortable-dictionary tr[data-id]');
    const items = [];
    
    rows.forEach((row, index) => {
        items.push({
            id: parseInt(row.dataset.id),
            sort_order: index + 1
        });
    });
    
    fetch('{{ route("admin.dictionaries.sort") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ items: items })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Optional: show success message
            console.log('Kolejność została zaktualizowana');
        }
    })
    .catch(error => {
        console.error('Błąd podczas aktualizacji kolejności:', error);
    });
}
</script>
@endsection