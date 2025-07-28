@extends('layouts.app')

@section('title', 'Szczegóły sprzętu wysokościowego')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-ladder"></i> Szczegóły sprzętu wysokościowego</h2>
    <div>
        <a href="{{ route('height-equipment.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
        <a href="{{ route('height-equipment.edit', $heightEquipment) }}" class="btn btn-primary">
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
                <h5><i class="fas fa-info-circle"></i> Informacje podstawowe</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Nazwa:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $heightEquipment->name }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Marka:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $heightEquipment->brand ?? 'Nie podano' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Model:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $heightEquipment->model ?? 'Nie podano' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Numer seryjny:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $heightEquipment->serial_number ?? 'Nie podano' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Tag zasobu:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $heightEquipment->asset_tag ?? 'Nie podano' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Typ:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="badge bg-secondary">{{ $heightEquipment->type }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-sm-9">
                        @php
                            $statusColors = [
                                'available' => 'success',
                                'in_use' => 'primary',
                                'maintenance' => 'warning',
                                'damaged' => 'danger',
                                'retired' => 'secondary'
                            ];
                            $statusLabels = [
                                'available' => 'Dostępny',
                                'in_use' => 'W użyciu',
                                'maintenance' => 'Konserwacja',
                                'damaged' => 'Uszkodzony',
                                'retired' => 'Wycofany'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$heightEquipment->status] ?? 'secondary' }}">
                            {{ $statusLabels[$heightEquipment->status] ?? $heightEquipment->status }}
                        </span>
                    </div>
                </div>

                @if($heightEquipment->description)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Opis:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $heightEquipment->description }}
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Lokalizacja:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $heightEquipment->location ?? 'Nie podano' }}
                    </div>
                </div>

                @if($heightEquipment->notes)
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Notatki:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $heightEquipment->notes }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($heightEquipment->purchase_date || $heightEquipment->purchase_price || $heightEquipment->warranty_expiry)
            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-shopping-cart"></i> Informacje zakupowe</h5>
                </div>
                <div class="card-body">
                    @if($heightEquipment->purchase_date)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Data zakupu:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ \Carbon\Carbon::parse($heightEquipment->purchase_date)->format('d.m.Y') }}
                            </div>
                        </div>
                    @endif

                    @if($heightEquipment->purchase_price)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Cena zakupu:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ number_format($heightEquipment->purchase_price, 2, ',', ' ') }} zł
                            </div>
                        </div>
                    @endif

                    @if($heightEquipment->warranty_expiry)
                        <div class="row">
                            <div class="col-sm-3">
                                <strong>Koniec gwarancji:</strong>
                            </div>
                            <div class="col-sm-9">
                                @php
                                    $warrantyDate = \Carbon\Carbon::parse($heightEquipment->warranty_expiry);
                                    $isExpired = $warrantyDate->isPast();
                                @endphp
                                <span class="badge bg-{{ $isExpired ? 'danger' : 'success' }}">
                                    {{ $warrantyDate->format('d.m.Y') }}
                                    @if($isExpired)
                                        (Wygasła)
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Set Membership -->
        @if($heightEquipment->heightEquipmentSets->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-boxes"></i> Członkostwo w zestawach</h5>
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
                            @foreach($heightEquipment->heightEquipmentSets as $set)
                                <tr>
                                    <td>
                                        <a href="{{ route('height-equipment-sets.show', $set) }}" class="text-decoration-none">
                                            <strong>{{ $set->name }}</strong>
                                        </a>
                                        @if($set->code)
                                            <br><small class="text-muted">Kod: {{ $set->code }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $set->pivot->quantity }}</span>
                                    </td>
                                    <td>
                                        @if($set->pivot->is_required)
                                            <span class="badge bg-danger">Wymagane</span>
                                        @else
                                            <span class="badge bg-secondary">Opcjonalne</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $set->status_badge }}">
                                            {{ $set->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($set->pivot->notes)
                                            <small class="text-muted">{{ $set->pivot->notes }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('height-equipment-sets.show', $set) }}" class="btn btn-sm btn-outline-primary">
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
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-cogs"></i> Akcje</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('height-equipment.edit', $heightEquipment) }}" class="btn btn-primary btn-sm w-100 mb-2">
                    <i class="fas fa-edit"></i> Edytuj sprzęt
                </a>
                <form method="POST" action="{{ route('height-equipment.destroy', $heightEquipment) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100"
                            onclick="return confirm('Czy na pewno chcesz usunąć ten sprzęt?')">
                        <i class="fas fa-trash"></i> Usuń sprzęt
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-clock"></i> Historia</h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <small class="text-muted">Utworzono:</small>
                    </div>
                    <div class="col-6">
                        <small>{{ $heightEquipment->created_at->format('d.m.Y H:i') }}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Aktualizacja:</small>
                    </div>
                    <div class="col-6">
                        <small>{{ $heightEquipment->updated_at->format('d.m.Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>

        @if($heightEquipment->working_height || $heightEquipment->load_capacity || $heightEquipment->certifications)
            <div class="card mt-3">
                <div class="card-header">
                    <h5><i class="fas fa-tools"></i> Specyfikacja techniczna</h5>
                </div>
                <div class="card-body">
                    @if($heightEquipment->working_height)
                        <div class="row mb-2">
                            <div class="col-6">
                                <small class="text-muted">Wysokość robocza:</small>
                            </div>
                            <div class="col-6">
                                <small>{{ $heightEquipment->working_height }} m</small>
                            </div>
                        </div>
                    @endif

                    @if($heightEquipment->load_capacity)
                        <div class="row mb-2">
                            <div class="col-6">
                                <small class="text-muted">Nośność:</small>
                            </div>
                            <div class="col-6">
                                <small>{{ $heightEquipment->load_capacity }} kg</small>
                            </div>
                        </div>
                    @endif

                    @if($heightEquipment->certifications)
                        <div class="row">
                            <div class="col-12">
                                <small class="text-muted">Certyfikaty:</small><br>
                                <small>{{ $heightEquipment->certifications }}</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection