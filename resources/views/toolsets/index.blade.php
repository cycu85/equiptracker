@extends('layouts.app')

@section('title', 'Zestawy narzędzi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-toolbox"></i> Zarządzanie zestawami narzędzi</h2>
    <a href="{{ route('toolsets.create') }}" class="btn btn-primary">
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
        <form method="GET" action="{{ route('toolsets.index') }}" class="row g-3">
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
                <a href="{{ route('toolsets.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Toolsets Table -->
<div class="card">
    <div class="card-body">
        @if($toolsets->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <x-sortable-header field="id" title="ID" />
                            <x-sortable-header field="name" title="Nazwa" />
                            <x-sortable-header field="code" title="Kod" />
                            <th>Narzędzia</th>
                            <x-sortable-header field="status" title="Status" />
                            <th>Kompletność</th>
                            <x-sortable-header field="location" title="Lokalizacja" />
                            <th>Wartość</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($toolsets as $toolset)
                        <tr>
                            <td>{{ $toolset->id }}</td>
                            <td>
                                <a href="{{ route('toolsets.show', $toolset) }}" class="text-decoration-none">
                                    <strong>{{ $toolset->name }}</strong>
                                </a>
                                @if($toolset->description)
                                    <br><small class="text-muted">{{ Str::limit($toolset->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($toolset->code)
                                    <code>{{ $toolset->code }}</code>
                                @else
                                    <span class="text-muted">Brak</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $toolset->tools->count() }}</span>
                                @if($toolset->total_tools_count != $toolset->tools->count())
                                    <small class="text-muted">({{ $toolset->total_tools_count }} szt.)</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $toolset->status_badge }}">
                                    {{ $toolset->status_label }}
                                </span>
                            </td>
                            <td>
                                @if($toolset->completion_status === 'complete')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Kompletny
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Niekompletny
                                    </span>
                                @endif
                            </td>
                            <td>{{ $toolset->location ?? 'Nieznana' }}</td>
                            <td>
                                @if($toolset->calculated_total_value > 0)
                                    {{ number_format($toolset->calculated_total_value, 2, ',', ' ') }} zł
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
                    Wyświetlono {{ $toolsets->firstItem() }}-{{ $toolsets->lastItem() }} z {{ $toolsets->total() }} zestawów
                </div>
                {{ $toolsets->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-toolbox fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Brak zestawów narzędzi do wyświetlenia</h5>
                <p class="text-muted">Dodaj pierwszy zestaw do systemu</p>
                <a href="{{ route('toolsets.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Dodaj zestaw
                </a>
            </div>
        @endif
    </div>
</div>
@endsection