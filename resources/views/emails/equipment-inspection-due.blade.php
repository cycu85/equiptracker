@extends('emails.layout')

@section('title', 'Przypomnienie o przeglądzie sprzętu')

@section('content')
<h2>⚠️ Przypomnienie o przeglądzie sprzętu</h2>

<div class="warning-box">
    <h4>🔔 Uwaga! Zbliża się termin przeglądu</h4>
    <p>
        Następujący sprzęt typu <strong>{{ $typeName }}</strong> wymaga przeglądu technicznego w najbliższym czasie.
        Prosimy o podjęcie odpowiednich działań.
    </p>
</div>

<div class="equipment-details">
    <h4>📋 Sprzęt wymagający przeglądu</h4>
    
    <table>
        <thead>
            <tr>
                <th>Nazwa sprzętu</th>
                <th>Nr seryjny</th>
                <th>Status</th>
                <th>Termin przeglądu</th>
                <th>Dni pozostałe</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipment as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->serial_number ?? 'Brak' }}</td>
                <td>
                    @switch($item->status)
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
                            {{ $item->status }}
                    @endswitch
                </td>
                <td>{{ $item->next_inspection_date->format('d.m.Y') }}</td>
                <td>
                    @php
                        $daysRemaining = now()->diffInDays($item->next_inspection_date, false);
                    @endphp
                    @if($daysRemaining < 0)
                        <span style="color: #dc3545; font-weight: bold;">
                            {{ abs($daysRemaining) }} dni temu ⚠️
                        </span>
                    @elseif($daysRemaining == 0)
                        <span style="color: #ffc107; font-weight: bold;">
                            Dziś! 🚨
                        </span>
                    @elseif($daysRemaining <= 7)
                        <span style="color: #fd7e14; font-weight: bold;">
                            {{ $daysRemaining }} dni ⏰
                        </span>
                    @else
                        <span style="color: #28a745;">
                            {{ $daysRemaining }} dni
                        </span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="info-box">
    <h4>📝 Wymagane działania</h4>
    <ol>
        <li><strong>Pilne przeględy</strong> - sprzęt z przekroczonym terminem wymaga natychmiastowej kontroli</li>
        <li><strong>Zaplanuj przeględy</strong> - umów wizyty serwisowe dla sprzętu z nadchodzącymi terminami</li>
        <li><strong>Sprawdź dostępność</strong> - upewnij się czy sprzęt jest dostępny do przeglądu</li>
        <li><strong>Dokumentacja</strong> - przygotuj dokumenty i historię serwisową</li>
        <li><strong>Aktualizuj system</strong> - po wykonaniu przeglądu zaktualizuj daty w systemie</li>
    </ol>
</div>

@switch($equipmentType)
    @case('height_equipment')
        <div class="warning-box">
            <h4>⚠️ Ważne - Sprzęt wysokościowy</h4>
            <p>
                Przeglądy sprzętu wysokościowego są obowiązkowe zgodnie z przepisami BHP. 
                Niedotrzymanie terminów może skutkować zakazem użytkowania sprzętu i naruszeniem przepisów bezpieczeństwa.
            </p>
        </div>
        @break
    
    @case('tool')
        <div class="info-box">
            <h4>🔧 Narzędzia</h4>
            <p>
                Regularne przeglądy narzędzi zapewniają bezpieczeństwo pracy i wydajność. 
                Sprawdź stan techniczny, kalibrację i certyfikaty.
            </p>
        </div>
        @break
    
    @case('it_equipment')
        <div class="info-box">
            <h4>💻 Sprzęt IT</h4>
            <p>
                Przeglądy sprzętu IT obejmują aktualizacje oprogramowania, czyszczenie, 
                sprawdzanie wydajności i zabezpieczeń.
            </p>
        </div>
        @break
@endswitch

<div class="success-box">
    <h4>📊 Statystyki</h4>
    <ul>
        <li><strong>Łącznie sprzętu do przeglądu:</strong> {{ $equipment->count() }}</li>
        <li><strong>Przeterminowane:</strong> {{ $equipment->filter(fn($item) => $item->next_inspection_date->isPast())->count() }}</li>
        <li><strong>W tym tygodniu:</strong> {{ $equipment->filter(fn($item) => $item->next_inspection_date->isAfter(now()) && $item->next_inspection_date->isBefore(now()->addWeek()))->count() }}</li>
    </ul>
</div>

<p style="text-align: center; margin-top: 30px;">
    <a href="{{ route('dashboard') }}" class="button">
        📊 Przejdź do panelu zarządzania
    </a>
</p>

<div class="footer" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
    <p style="color: #666; font-size: 12px;">
        To przypomnienie zostało wysłane automatycznie przez system EquipTracker.<br>
        Następne przypomnienie zostanie wysłane za tydzień, jeśli przeglądy nie zostaną wykonane.
    </p>
</div>
@endsection