@extends('layouts.app')

@section('title', 'Szczegóły zestawu: ' . $heightEquipmentSet->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-hard-hat"></i> {{ $heightEquipmentSet->name }}</h2>
    <div>
        <a href="{{ route('height-equipment-sets.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
        <a href="{{ route('height-equipment-sets.edit', $heightEquipmentSet) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edytuj
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Informacje o zestawie</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Nazwa:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $heightEquipmentSet->name }}
                    </div>
                </div>

                @if($heightEquipmentSet->code)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Kod zestawu:</strong>
                        </div>
                        <div class="col-sm-9">
                            <code>{{ $heightEquipmentSet->code }}</code>
                        </div>
                    </div>
                @endif

                @if($heightEquipmentSet->description)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Opis:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $heightEquipmentSet->description }}
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="badge {{ $heightEquipmentSet->status_badge }}">
                            {{ $heightEquipmentSet->status_label }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Kompletność:</strong>
                    </div>
                    <div class="col-sm-9">
                        @if($heightEquipmentSet->completion_status === 'complete')
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> Zestaw kompletny
                            </span>
                        @else
                            <span class="badge bg-warning">
                                <i class="fas fa-exclamation-triangle"></i> Zestaw niekompletny
                            </span>
                        @endif
                    </div>
                </div>

                @if($heightEquipmentSet->location)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Lokalizacja:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $heightEquipmentSet->location }}
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Utworzony:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $heightEquipmentSet->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <strong>Ostatnia aktualizacja:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $heightEquipmentSet->updated_at->format('d.m.Y H:i') }}
                    </div>
                </div>

                @if($heightEquipmentSet->notes)
                    <div class="row mt-3">
                        <div class="col-sm-3">
                            <strong>Notatki:</strong>
                        </div>
                        <div class="col-sm-9">
                            <div class="bg-light p-3 rounded">
                                {{ $heightEquipmentSet->notes }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-hard-hat"></i> Sprzęt w zestawie ({{ $heightEquipmentSet->heightEquipment->count() }})</h5>
            </div>
            <div class="card-body">
                @if($heightEquipmentSet->heightEquipment->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Sprzęt</th>
                                    <th>Ilość</th>
                                    <th>Typ</th>
                                    <th>Status</th>
                                    <th>Lokalizacja</th>
                                    <th>Certyfikacja</th>
                                    <th>Notatki</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($heightEquipmentSet->heightEquipment as $equipment)
                                    <tr>
                                        <td>
                                            <a href="{{ route('height-equipment.show', $equipment) }}" class="text-decoration-none">
                                                <strong>{{ $equipment->name }}</strong>
                                            </a>
                                            @if($equipment->brand || $equipment->model)
                                                <br><small class="text-muted">{{ $equipment->brand }} {{ $equipment->model }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $equipment->pivot->quantity }}</span>
                                        </td>
                                        <td>
                                            @if($equipment->pivot->is_required)
                                                <span class="badge bg-danger">Wymagane</span>
                                            @else
                                                <span class="badge bg-secondary">Opcjonalne</span>
                                            @endif
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
                                                    <span class="badge bg-danger">Konserwacja</span>
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
                                            @if($equipment->certification_expiry)
                                                <small class="text-{{ $equipment->certification_expiry->isPast() ? 'danger' : ($equipment->certification_expiry->diffInDays() < 30 ? 'warning' : 'muted') }}">
                                                    {{ $equipment->certification_expiry->format('d.m.Y') }}
                                                </small>
                                            @else
                                                <span class="text-muted">Brak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($equipment->pivot->notes)
                                                <small class="text-muted">{{ $equipment->pivot->notes }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-hard-hat fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Brak sprzętu w zestawie</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar"></i> Statystyki</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="mb-2">
                            <i class="fas fa-hard-hat fa-2x text-primary"></i>
                        </div>
                        <h4 class="mb-0">{{ $heightEquipmentSet->heightEquipment->count() }}</h4>
                        <small class="text-muted">Różnych urządzeń</small>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <i class="fas fa-cubes fa-2x text-info"></i>
                        </div>
                        <h4 class="mb-0">{{ $heightEquipmentSet->total_equipment_count }}</h4>
                        <small class="text-muted">Łączna ilość</small>
                    </div>
                </div>
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="mb-2">
                            <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                        </div>
                        <h4 class="mb-0">{{ $heightEquipmentSet->requiredEquipment->count() }}</h4>
                        <small class="text-muted">Wymaganych</small>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <i class="fas fa-plus-circle fa-2x text-secondary"></i>
                        </div>
                        <h4 class="mb-0">{{ $heightEquipmentSet->optionalEquipment->count() }}</h4>
                        <small class="text-muted">Opcjonalnych</small>
                    </div>
                </div>
                
                @if($heightEquipmentSet->calculated_total_value > 0)
                    <hr>
                    <div class="text-center">
                        <div class="mb-2">
                            <i class="fas fa-euro-sign fa-2x text-success"></i>
                        </div>
                        <h4 class="mb-0">{{ number_format($heightEquipmentSet->calculated_total_value, 2, ',', ' ') }} zł</h4>
                        <small class="text-muted">Łączna wartość</small>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-cogs"></i> Akcje</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('height-equipment-sets.edit', $heightEquipmentSet) }}" class="btn btn-primary btn-sm w-100 mb-2">
                    <i class="fas fa-edit"></i> Edytuj zestaw
                </a>
                <form method="POST" action="{{ route('height-equipment-sets.destroy', $heightEquipmentSet) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100"
                            onclick="return confirm('Czy na pewno chcesz usunąć ten zestaw sprzętu wysokościowego?')">
                        <i class="fas fa-trash"></i> Usuń zestaw
                    </button>
                </form>
            </div>
        </div>

        @if($heightEquipmentSet->heightEquipment->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5><i class="fas fa-clipboard-check"></i> Status sprzętu</h5>
                </div>
                <div class="card-body">
                    @php
                        $statusCounts = $heightEquipmentSet->heightEquipment->countBy('status');
                    @endphp
                    @foreach(['available' => 'Dostępne', 'in_use' => 'W użyciu', 'maintenance' => 'Konserwacja', 'damaged' => 'Uszkodzone'] as $status => $label)
                        @if($statusCounts->get($status, 0) > 0)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>{{ $label }}:</span>
                                <span class="badge bg-info">{{ $statusCounts->get($status, 0) }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection