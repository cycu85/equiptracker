@extends('layouts.app')

@section('title', 'Szczegóły pracownika')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-tie"></i> Szczegóły pracownika</h2>
    <div>
        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edytuj
        </a>
        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>

<div class="row">
    <!-- Personal Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-user"></i> Informacje osobowe</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Imię:</th>
                                <td>{{ $employee->first_name }}</td>
                            </tr>
                            <tr>
                                <th>Nazwisko:</th>
                                <td>{{ $employee->last_name }}</td>
                            </tr>
                            <tr>
                                <th>ID pracownika:</th>
                                <td>
                                    @if($employee->employee_id)
                                        <code>{{ $employee->employee_id }}</code>
                                    @else
                                        <span class="text-muted">Brak danych</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @switch($employee->status)
                                        @case('active')
                                            <span class="badge bg-success">Aktywny</span>
                                            @break
                                        @case('inactive')
                                            <span class="badge bg-secondary">Nieaktywny</span>
                                            @break
                                        @default
                                            <span class="badge bg-success">Aktywny</span>
                                    @endswitch
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Email:</th>
                                <td>
                                    @if($employee->email)
                                        <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
                                    @else
                                        <span class="text-muted">Brak danych</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Telefon:</th>
                                <td>
                                    @if($employee->phone)
                                        <a href="tel:{{ $employee->phone }}">{{ $employee->phone }}</a>
                                    @else
                                        <span class="text-muted">Brak danych</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Data zatrudnienia:</th>
                                <td>{{ $employee->hire_date ? $employee->hire_date->format('d.m.Y') : 'Brak danych' }}</td>
                            </tr>
                            <tr>
                                <th>Staż pracy:</th>
                                <td>
                                    @if($employee->hire_date)
                                        {{ $employee->hire_date->diffForHumans() }}
                                    @else
                                        <span class="text-muted">Brak danych</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($employee->address)
                <div class="mt-3">
                    <h6>Adres:</h6>
                    <p class="text-muted">{{ $employee->address }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Job Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-briefcase"></i> Informacje zawodowe</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Stanowisko:</th>
                                <td>{{ $employee->position ?? 'Nieokreślone' }}</td>
                            </tr>
                            <tr>
                                <th>Dział:</th>
                                <td>
                                    @if($employee->department)
                                        <span class="badge bg-info">{{ $employee->department }}</span>
                                    @else
                                        <span class="text-muted">Brak danych</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Wynagrodzenie:</th>
                                <td>
                                    @if($employee->salary)
                                        {{ number_format($employee->salary, 2) }} PLN
                                    @else
                                        <span class="text-muted">Poufne</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Utworzono:</th>
                                <td>{{ $employee->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        @if($employee->emergency_contact_name || $employee->emergency_contact_phone)
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-phone-alt"></i> Kontakt awaryjny</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Osoba kontaktowa:</h6>
                        <p>{{ $employee->emergency_contact_name ?? 'Brak danych' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Telefon:</h6>
                        <p>
                            @if($employee->emergency_contact_phone)
                                <a href="tel:{{ $employee->emergency_contact_phone }}">{{ $employee->emergency_contact_phone }}</a>
                            @else
                                Brak danych
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($employee->notes)
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-sticky-note"></i> Notatki</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">{{ $employee->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-cogs"></i> Akcje</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edytuj pracownika
                    </a>
                    
                    @if($employee->status === 'active')
                        <button class="btn btn-warning" onclick="changeStatus('inactive')">
                            <i class="fas fa-user-slash"></i> Dezaktywuj
                        </button>
                    @else
                        <button class="btn btn-success" onclick="changeStatus('active')">
                            <i class="fas fa-user-check"></i> Aktywuj
                        </button>
                    @endif
                    
                    <button class="btn btn-outline-danger" onclick="confirmDelete({{ $employee->id }}, '{{ $employee->first_name }} {{ $employee->last_name }}')">
                        <i class="fas fa-trash"></i> Usuń pracownika
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar"></i> Statystyki</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <h4 class="text-primary">#{{ $employee->id }}</h4>
                    <small class="text-muted">ID w systemie</small>
                </div>
                
                @if($employee->hire_date)
                <hr>
                <div>
                    <h4 class="text-success">{{ $employee->hire_date->diffInYears() }}</h4>
                    <small class="text-muted">{{ $employee->hire_date->diffInYears() == 1 ? 'rok' : ($employee->hire_date->diffInYears() < 5 ? 'lata' : 'lat') }} w firmie</small>
                </div>
                @endif
            </div>
        </div>

        <!-- Department Info -->
        @if($employee->department)
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-building"></i> Informacje o dziale</h5>
            </div>
            <div class="card-body">
                <h6 class="text-center">
                    <span class="badge bg-info fs-6">{{ $employee->department }}</span>
                </h6>
                
                @if($employee->position)
                <hr>
                <div class="text-center">
                    <small class="text-muted">Stanowisko:</small><br>
                    <strong>{{ $employee->position }}</strong>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Potwierdź usunięcie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Czy na pewno chcesz usunąć pracownika <strong id="employeeName"></strong>?
                <br><small class="text-muted">Tej operacji nie można cofnąć.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Usuń</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(employeeId, employeeName) {
    document.getElementById('employeeName').textContent = employeeName;
    document.getElementById('deleteForm').action = '/employees/' + employeeId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function changeStatus(newStatus) {
    if (confirm('Czy na pewno chcesz zmienić status tego pracownika?')) {
        // This would typically send an AJAX request to update the status
        // For now, we'll just redirect to edit page
        window.location.href = '{{ route("employees.edit", $employee) }}';
    }
}
</script>
@endsection