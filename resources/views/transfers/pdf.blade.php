<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Protokół przekazania {{ $transfer->transfer_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .document-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
        .transfer-number {
            font-size: 14px;
            color: #666;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .info-row {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }
        .label {
            font-weight: bold;
            width: 40%;
            display: inline-block;
        }
        .value {
            width: 55%;
            display: inline-block;
        }
        .item-details {
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            margin: 10px 0;
        }
        .signatures {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 45%;
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 10px;
            margin-top: 60px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">EquipTracker - System Zarządzania Sprzętem</div>
        <div class="document-title">PROTOKÓŁ PRZEKAZANIA SPRZĘTU</div>
        <div class="transfer-number">Nr: {{ $transfer->transfer_number }}</div>
    </div>

    <div class="section">
        <div class="section-title">Informacje o przekazaniu</div>
        <table>
            <tr>
                <td class="label">Data przekazania:</td>
                <td class="value">{{ $transfer->transfer_date->format('d.m.Y') }}</td>
            </tr>
            <tr>
                <td class="label">Status:</td>
                <td class="value">
                    @switch($transfer->status)
                        @case('active') Aktywne @break
                        @case('returned') Zwrócone @break
                        @case('permanent') Stałe @break
                    @endswitch
                </td>
            </tr>
            @if($transfer->return_date)
            <tr>
                <td class="label">Planowana data zwrotu:</td>
                <td class="value">{{ $transfer->return_date->format('d.m.Y') }}</td>
            </tr>
            @endif
            <tr>
                <td class="label">Utworzono przez:</td>
                <td class="value">{{ $transfer->creator->full_name }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Strony przekazania</div>
        <table>
            <tr>
                <td class="label">Przekazuje:</td>
                <td class="value">
                    @if($transfer->fromEmployee)
                        {{ $transfer->fromEmployee->full_name }}
                        <br><small>{{ $transfer->fromEmployee->department }} - {{ $transfer->fromEmployee->position }}</small>
                    @else
                        Magazyn
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Otrzymuje:</td>
                <td class="value">
                    {{ $transfer->toEmployee->full_name }}
                    <br><small>{{ $transfer->toEmployee->department }} - {{ $transfer->toEmployee->position }}</small>
                    <br><small>Nr pracownika: {{ $transfer->toEmployee->employee_number }}</small>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Szczegóły przekazywanego przedmiotu</div>
        <div class="item-details">
            @if($transfer->item)
                <table>
                    <tr>
                        <td class="label">Typ przedmiotu:</td>
                        <td class="value">
                            @switch($transfer->item_type)
                                @case('tool') Narzędzie @break
                                @case('height_equipment') Sprzęt wysokościowy @break
                                @case('it_equipment') Sprzęt IT @break
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Nazwa:</td>
                        <td class="value"><strong>{{ $transfer->item->name }}</strong></td>
                    </tr>
                    @if($transfer->item->brand || $transfer->item->model)
                    <tr>
                        <td class="label">Marka/Model:</td>
                        <td class="value">{{ $transfer->item->brand }} {{ $transfer->item->model }}</td>
                    </tr>
                    @endif
                    @if($transfer->item->serial_number)
                    <tr>
                        <td class="label">Numer seryjny:</td>
                        <td class="value">{{ $transfer->item->serial_number }}</td>
                    </tr>
                    @endif
                    @if(isset($transfer->item->asset_tag))
                    <tr>
                        <td class="label">Nr inwentarzowy:</td>
                        <td class="value">{{ $transfer->item->asset_tag }}</td>
                    </tr>
                    @endif
                    @if($transfer->item->location)
                    <tr>
                        <td class="label">Lokalizacja:</td>
                        <td class="value">{{ $transfer->item->location }}</td>
                    </tr>
                    @endif
                </table>
            @else
                <p>Brak szczegółowych informacji o przedmiocie (ID: {{ $transfer->item_id }})</p>
            @endif
        </div>
    </div>

    @if($transfer->reason)
    <div class="section">
        <div class="section-title">Cel przekazania</div>
        <p>{{ $transfer->reason }}</p>
    </div>
    @endif

    @if($transfer->condition_notes)
    <div class="section">
        <div class="section-title">Stan techniczny / Uwagi</div>
        <p>{{ $transfer->condition_notes }}</p>
    </div>
    @endif

    <div class="section">
        <div class="section-title">Oświadczenia</div>
        <p><strong>Przekazujący oświadcza, że:</strong></p>
        <ul>
            <li>Przekazywany sprzęt jest sprawny i nadaje się do użytku</li>
            <li>Zostały przekazane wszystkie niezbędne dokumenty i instrukcje</li>
            <li>Odbiorca został poinformowany o zasadach użytkowania</li>
        </ul>
        
        <p><strong>Odbiorca oświadcza, że:</strong></p>
        <ul>
            <li>Otrzymał sprzęt w stanie zgodnym z opisem</li>
            <li>Zapoznał się z instrukcją obsługi i zasadami BHP</li>
            <li>Zobowiązuje się do odpowiedzialnego użytkowania sprzętu</li>
        </ul>
    </div>

    <div class="signatures">
        <div class="signature-box">
            <div>Podpis przekazującego</div>
            @if($transfer->fromEmployee)
                <div><small>{{ $transfer->fromEmployee->full_name }}</small></div>
            @else
                <div><small>Magazyn</small></div>
            @endif
        </div>
        <div class="signature-box">
            <div>Podpis odbierającego</div>
            <div><small>{{ $transfer->toEmployee->full_name }}</small></div>
        </div>
    </div>

    <div class="footer">
        Dokument wygenerowany automatycznie przez system EquipTracker w dniu {{ now()->format('d.m.Y H:i') }}
        <br>Protokół nr {{ $transfer->transfer_number }}
    </div>
</body>
</html>