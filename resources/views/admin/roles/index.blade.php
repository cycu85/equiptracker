@extends('layouts.app')

@section('title', 'Zarządzanie rolami')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-shield"></i> Zarządzanie rolami</h2>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i> Panel admina
        </a>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj rolę
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($roles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nazwa</th>
                            <th>Nazwa wyświetlana</th>
                            <th>Opis</th>
                            <th>Uprawnienia</th>
                            <th>Użytkownicy</th>
                            <th>Typ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>
                                    <a href="{{ route('admin.roles.show', $role) }}" class="text-decoration-none">
                                        <strong>{{ $role->name }}</strong>
                                    </a>
                                </td>
                                <td>{{ $role->display_name }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ Str::limit($role->description, 50) }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $role->permissions->count() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $role->users->count() }}
                                    </span>
                                </td>
                                <td>
                                    @if($role->is_system)
                                        <span class="badge bg-warning">Systemowa</span>
                                    @else
                                        <span class="badge bg-success">Niestandardowa</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Wyświetlono {{ $roles->firstItem() }}-{{ $roles->lastItem() }} z {{ $roles->total() }} ról
                </div>
                {{ $roles->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-shield fa-3x text-muted mb-3"></i>
                <h5>Brak ról</h5>
                <p class="text-muted">Nie ma jeszcze żadnych ról w systemie.</p>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Dodaj pierwszą rolę
                </a>
            </div>
        @endif
    </div>
</div>
@endsection