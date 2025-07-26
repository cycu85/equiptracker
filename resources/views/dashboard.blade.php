@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Narzędzia</h5>
                        <h2 class="mb-0">{{ $stats['tools'] ?? 0 }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tools fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Sprzęt wysokościowy</h5>
                        <h2 class="mb-0">{{ $stats['height_equipment'] ?? 0 }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-hard-hat fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Sprzęt IT</h5>
                        <h2 class="mb-0">{{ $stats['it_equipment'] ?? 0 }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-laptop fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Pracownicy</h5>
                        <h2 class="mb-0">{{ $stats['employees'] ?? 0 }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Transfers -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-exchange-alt"></i> Ostatnie przekazania</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">Zobacz wszystkie</a>
            </div>
            <div class="card-body">
                @if($recentTransfers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nr protokołu</th>
                                    <th>Przedmiot</th>
                                    <th>Od</th>
                                    <th>Do</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTransfers as $transfer)
                                <tr>
                                    <td>{{ $transfer->transfer_number }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst($transfer->item_type) }}</span>
                                        #{{ $transfer->item_id }}
                                    </td>
                                    <td>{{ $transfer->fromEmployee->full_name ?? 'Magazyn' }}</td>
                                    <td>{{ $transfer->toEmployee->full_name }}</td>
                                    <td>{{ $transfer->transfer_date->format('d.m.Y') }}</td>
                                    <td>
                                        @switch($transfer->status)
                                            @case('active')
                                                <span class="badge bg-success">Aktywny</span>
                                                @break
                                            @case('returned')
                                                <span class="badge bg-info">Zwrócony</span>
                                                @break
                                            @case('permanent')
                                                <span class="badge bg-warning">Stały</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>Brak ostatnich przekazań</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Upcoming Inspections -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-check"></i> Nadchodzące przeglądy</h5>
            </div>
            <div class="card-body">
                @if($upcomingInspections->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($upcomingInspections as $tool)
                        <div class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $tool->name }}</h6>
                                <small class="text-muted">{{ $tool->brand }} {{ $tool->model }}</small>
                            </div>
                            <div class="text-end">
                                <small class="text-{{ $tool->next_inspection_date->isPast() ? 'danger' : ($tool->next_inspection_date->diffInDays() < 7 ? 'warning' : 'muted') }}">
                                    {{ $tool->next_inspection_date->format('d.m.Y') }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <p>Brak nadchodzących przeglądów</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Active Transfers Summary -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Podsumowanie aktywnych przekazań</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h3 class="text-primary">{{ $stats['active_transfers'] ?? 0 }}</h3>
                                <p class="mb-0">Aktywne przekazania</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h3 class="text-success">{{ $stats['tools'] - ($stats['active_transfers'] ?? 0) }}</h3>
                                <p class="mb-0">Dostępne narzędzia</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h3 class="text-info">{{ round(($stats['active_transfers'] ?? 0) / max($stats['tools'], 1) * 100) }}%</h3>
                                <p class="mb-0">Stopień wykorzystania</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h3 class="text-warning">{{ $upcomingInspections->where('next_inspection_date', '<', now()->addDays(7))->count() }}</h3>
                                <p class="mb-0">Przeglądy w tym tygodniu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection