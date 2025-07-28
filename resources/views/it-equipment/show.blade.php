@extends('layouts.app')

@section('title', 'Szczegóły sprzętu IT')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-laptop"></i> Szczegóły sprzętu IT</h2>
    <div>
        <a href="{{ route('it-equipment.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
        <a href="{{ route('it-equipment.edit', $itEquipment) }}" class="btn btn-primary">
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
                        {{ $itEquipment->name }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Marka:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $itEquipment->brand ?? 'Nie podano' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Model:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $itEquipment->model ?? 'Nie podano' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Numer seryjny:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $itEquipment->serial_number ?? 'Nie podano' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Tag zasobu:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $itEquipment->asset_tag ?? 'Nie podano' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Typ:</strong>
                    </div>
                    <div class="col-sm-9">
                        @php
                            $typeLabels = [
                                'computer' => 'Komputer',
                                'laptop' => 'Laptop',
                                'printer' => 'Drukarka',
                                'scanner' => 'Skaner',
                                'phone' => 'Telefon',
                                'tablet' => 'Tablet',
                                'monitor' => 'Monitor',
                                'server' => 'Serwer',
                                'router' => 'Router',
                                'switch' => 'Switch',
                                'other' => 'Inne'
                            ];
                        @endphp
                        <span class="badge bg-secondary">{{ $typeLabels[$itEquipment->type] ?? $itEquipment->type }}</span>
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
                        <span class="badge bg-{{ $statusColors[$itEquipment->status] ?? 'secondary' }}">
                            {{ $statusLabels[$itEquipment->status] ?? $itEquipment->status }}
                        </span>
                    </div>
                </div>

                @if($itEquipment->description)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Opis:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $itEquipment->description }}
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Lokalizacja:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $itEquipment->location ?? 'Nie podano' }}
                    </div>
                </div>

                @if($itEquipment->notes)
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Notatki:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $itEquipment->notes }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($itEquipment->operating_system || $itEquipment->specifications || $itEquipment->mac_address || $itEquipment->ip_address)
            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-microchip"></i> Specyfikacja techniczna</h5>
                </div>
                <div class="card-body">
                    @if($itEquipment->operating_system)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>System operacyjny:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $itEquipment->operating_system }}
                            </div>
                        </div>
                    @endif

                    @if($itEquipment->specifications)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Specyfikacja:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $itEquipment->specifications }}
                            </div>
                        </div>
                    @endif

                    @if($itEquipment->mac_address)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Adres MAC:</strong>
                            </div>
                            <div class="col-sm-9">
                                <code>{{ $itEquipment->mac_address }}</code>
                            </div>
                        </div>
                    @endif

                    @if($itEquipment->ip_address)
                        <div class="row">
                            <div class="col-sm-3">
                                <strong>Adres IP:</strong>
                            </div>
                            <div class="col-sm-9">
                                <code>{{ $itEquipment->ip_address }}</code>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($itEquipment->purchase_date || $itEquipment->purchase_price || $itEquipment->warranty_expiry)
            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-shopping-cart"></i> Informacje zakupowe</h5>
                </div>
                <div class="card-body">
                    @if($itEquipment->purchase_date)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Data zakupu:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ \Carbon\Carbon::parse($itEquipment->purchase_date)->format('d.m.Y') }}
                            </div>
                        </div>
                    @endif

                    @if($itEquipment->purchase_price)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Cena zakupu:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ number_format($itEquipment->purchase_price, 2, ',', ' ') }} zł
                            </div>
                        </div>
                    @endif

                    @if($itEquipment->warranty_expiry)
                        <div class="row">
                            <div class="col-sm-3">
                                <strong>Koniec gwarancji:</strong>
                            </div>
                            <div class="col-sm-9">
                                @php
                                    $warrantyDate = \Carbon\Carbon::parse($itEquipment->warranty_expiry);
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
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-cogs"></i> Akcje</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('it-equipment.edit', $itEquipment) }}" class="btn btn-primary btn-sm w-100 mb-2">
                    <i class="fas fa-edit"></i> Edytuj sprzęt
                </a>
                <form method="POST" action="{{ route('it-equipment.destroy', $itEquipment) }}">
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
                        <small>{{ $itEquipment->created_at->format('d.m.Y H:i') }}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Aktualizacja:</small>
                    </div>
                    <div class="col-6">
                        <small>{{ $itEquipment->updated_at->format('d.m.Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar"></i> Statystyki</h5>
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            @if($itEquipment->purchase_price)
                                <i class="fas fa-euro-sign fa-2x text-success"></i>
                            @else
                                <i class="fas fa-question-circle fa-2x text-muted"></i>
                            @endif
                        </div>
                        <h6>Wartość zakupu</h6>
                        <p class="mb-0">
                            @if($itEquipment->purchase_price)
                                {{ number_format($itEquipment->purchase_price, 0, ',', ' ') }} zł
                            @else
                                Nieznana
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection