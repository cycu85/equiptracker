@extends('layouts.app')

@section('title', 'Pracownicy')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users"></i> Zarządzanie pracownikami</h2>
    <a href="{{ route('employees.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Dodaj pracownika
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('employees.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Wyszukaj</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Imię, nazwisko, email...">
            </div>
            <div class="col-md-2">
                <label for="department" class="form-label">Dział</label>
                <select class="form-select" id="department" name="department">
                    <option value="">Wszystkie</option>
                    @foreach($departments as $key => $value)
                        <option value="{{ $key }}" {{ request('department') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Wszystkie</option>
                    @foreach($statuses as $key => $value)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="position" class="form-label">Stanowisko</label>
                <input type="text" class="form-control" id="position" name="position" 
                       value="{{ request('position') }}" placeholder="Kierownik, pracownik...">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-search"></i> Filtruj
                </button>
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Employees Table -->
<div class="card">
    <div class="card-body">
        @if($employees->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <x-sortable-header field="id" title="ID" />
                            <x-sortable-header field="last_name" title="Pracownik" />
                            <x-sortable-header field="email" title="Email" />
                            <x-sortable-header field="position" title="Stanowisko" />
                            <x-sortable-header field="department" title="Dział" />
                            <th>Telefon</th>
                            <x-sortable-header field="status" title="Status" />
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>
                                <a href="{{ route('employees.show', $employee) }}" class="text-decoration-none">
                                    <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong>
                                </a>
                                @if($employee->employee_number)
                                    <br><small class="text-muted">Nr: {{ $employee->employee_number }}</small>
                                @endif
                            </td>
                            <td>{{ $employee->email ?? 'Brak' }}</td>
                            <td>{{ $employee->position ?? 'Nieokreślone' }}</td>
                            <td>
                                @if($employee->department)
                                    <span class="badge bg-info">{{ $employee->department }}</span>
                                @else
                                    <span class="text-muted">Brak</span>
                                @endif
                            </td>
                            <td>{{ $employee->phone ?? 'Brak' }}</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Brak pracowników do wyświetlenia</h5>
                <p class="text-muted">Dodaj pierwszego pracownika do systemu</p>
                <a href="{{ route('employees.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Dodaj pracownika
                </a>
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
</script>
@endsection