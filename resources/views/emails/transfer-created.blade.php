@extends('emails.layout')

@section('title', 'Nowy transfer sprzętu')

@section('content')
<h2>📤 Nowy transfer sprzętu</h2>

<div class="success-box">
    <h4>✅ Transfer został utworzony pomyślnie</h4>
    <p>Sprzęt został przekazany pracownikowi do użytkowania.</p>
</div>

<div class="equipment-details">
    <h4>📋 Szczegóły transferu</h4>
    
    <div class="detail-row">
        <span class="detail-label">Numer transferu:</span>
        <span class="detail-value">#{{ $transfer->id }}</span>
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Data transferu:</span>
        <span class="detail-value">{{ $transfer->transfer_date->format('d.m.Y H:i') }}</span>
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
    
    @if($employee->email)
    <div class="detail-row">
        <span class="detail-label">Email:</span>
        <span class="detail-value">{{ $employee->email }}</span>
    </div>
    @endif
</div>

@if($equipment)
<div class="equipment-details">
    <h4>🔧 Szczegóły sprzętu</h4>
    
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
        <span class="detail-label">Status:</span>
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
    
    @if($equipment->next_inspection_date)
    <div class="detail-row">
        <span class="detail-label">Następny przegląd:</span>
        <span class="detail-value">{{ $equipment->next_inspection_date->format('d.m.Y') }}</span>
    </div>
    @endif
</div>
@endif

@if($transfer->notes)
<div class="info-box">
    <h4>📝 Uwagi</h4>
    <p>{{ $transfer->notes }}</p>
</div>
@endif

<div class="info-box">
    <h4>ℹ️ Informacje dodatkowe</h4>
    <ul>
        <li>Pracownik jest odpowiedzialny za powierzony sprzęt</li>
        <li>W przypadku uszkodzenia należy niezwłocznie zgłosić to do działu IT/BHP</li>
        <li>Sprzęt należy zwrócić w nienaruszonym stanie</li>
        @if($equipment && $equipment->next_inspection_date)
        <li>Pamiętaj o terminach przeglądów technicznych</li>
        @endif
    </ul>
</div>

<p style="text-align: center; margin-top: 30px;">
    <a href="{{ route('transfers.show', $transfer) }}" class="button">
        📋 Zobacz szczegóły transferu
    </a>
</p>
@endsection