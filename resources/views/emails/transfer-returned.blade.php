@extends('emails.layout')

@section('title', 'Zwrot sprzętu')

@section('content')
<h2>📥 Zwrot sprzętu</h2>

<div class="success-box">
    <h4>✅ Sprzęt został zwrócony pomyślnie</h4>
    <p>Transfer został zamknięty i sprzęt jest ponownie dostępny.</p>
</div>

<div class="equipment-details">
    <h4>📋 Szczegóły zwrotu</h4>
    
    <div class="detail-row">
        <span class="detail-label">Numer transferu:</span>
        <span class="detail-value">#{{ $transfer->id }}</span>
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Data transferu:</span>
        <span class="detail-value">{{ $transfer->transfer_date->format('d.m.Y H:i') }}</span>
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Data zwrotu:</span>
        <span class="detail-value">{{ $transfer->return_date->format('d.m.Y H:i') }}</span>
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Czas użytkowania:</span>
        <span class="detail-value">{{ $transfer->transfer_date->diffForHumans($transfer->return_date, true) }}</span>
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Typ sprzętu:</span>
        <span class="detail-value">
            @switch($transfer->equipment_type)
                @case('tool')
                    🔧 Narzędzie
                    @break
                @case('height_equipment')
                    🪜 Sprzęt wysokościowy
                    @break
                @case('it_equipment')
                    💻 Sprzęt IT
                    @break
                @default
                    📦 Sprzęt
            @endswitch
        </span>
    </div>
</div>

<div class="equipment-details">
    <h4>👤 Pracownik</h4>
    
    <div class="detail-row">
        <span class="detail-label">Imię i nazwisko:</span>
        <span class="detail-value">{{ $employee->first_name }} {{ $employee->last_name }}</span>
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Stanowisko:</span>
        <span class="detail-value">{{ $employee->position }}</span>
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Dział:</span>
        <span class="detail-value">{{ $employee->department }}</span>
    </div>
</div>

@if($equipment)
<div class="equipment-details">
    <h4>🔧 Zwrócony sprzęt</h4>
    
    <div class="detail-row">
        <span class="detail-label">Nazwa:</span>
        <span class="detail-value">{{ $equipment->name }}</span>
    </div>
    
    @if($equipment->serial_number)
    <div class="detail-row">
        <span class="detail-label">Numer seryjny:</span>
        <span class="detail-value">{{ $equipment->serial_number }}</span>
    </div>
    @endif
    
    @if($equipment->model)
    <div class="detail-row">
        <span class="detail-label">Model:</span>
        <span class="detail-value">{{ $equipment->model }}</span>
    </div>
    @endif
    
    <div class="detail-row">
        <span class="detail-label">Aktualny status:</span>
        <span class="detail-value">
            @switch($equipment->status)
                @case('available')
                    ✅ Dostępny
                    @break
                @case('in_use')
                    🔄 W użyciu
                    @break
                @case('maintenance')
                    🔧 W serwisie
                    @break
                @case('retired')
                    ❌ Wycofany
                    @break
                @default
                    {{ $equipment->status }}
            @endswitch
        </span>
    </div>
</div>
@endif

@if($transfer->return_condition)
<div class="info-box">
    <h4>📋 Stan przy zwrocie</h4>
    <p>{{ $transfer->return_condition }}</p>
</div>
@endif

@if($transfer->notes)
<div class="info-box">
    <h4>📝 Uwagi do transferu</h4>
    <p>{{ $transfer->notes }}</p>
</div>
@endif

<div class="success-box">
    <h4>✅ Potwierdzenie zwrotu</h4>
    <p>
        Sprzęt został pomyślnie zwrócony do magazynu i jest ponownie dostępny 
        dla innych pracowników. Dziękujemy za odpowiedzialne użytkowanie sprzętu firmowego.
    </p>
</div>

<p style="text-align: center; margin-top: 30px;">
    <a href="{{ route('transfers.show', $transfer) }}" class="button">
        📋 Zobacz szczegóły transferu
    </a>
</p>
@endsection