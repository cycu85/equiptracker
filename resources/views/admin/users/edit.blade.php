@extends('layouts.app')

@section('title', 'Edytuj użytkownika')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit"></i> Edytuj użytkownika</h2>
    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót
    </a>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Imię i nazwisko <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="role_id" class="form-label">Rola <span class="text-danger">*</span></label>
                        <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required
                                @if($user->id === auth()->id()) disabled @endif>
                            <option value="">Wybierz rolę</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
                        @if($user->id === auth()->id())
                            <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                            <small class="text-muted">Nie możesz zmienić swojej własnej roli.</small>
                        @endif
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($user->id === auth()->id())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informacja:</strong> Edytujesz swoje własne konto. Niektóre opcje mogą być ograniczone.
                    </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Anuluj
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Zapisz zmiany
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Informacje</h5>
            </div>
            <div class="card-body">
                <h6>Edytowane konto</h6>
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-user-circle fa-3x text-{{ $user->role && $user->role->name === 'administrator' ? 'danger' : 'primary' }} me-3"></i>
                    <div>
                        <strong>{{ $user->name }}</strong><br>
                        <small class="text-muted">{{ $user->email }}</small><br>
                        <span class="badge bg-{{ $user->role && $user->role->name === 'administrator' ? 'danger' : 'primary' }}">
                            {{ $user->role ? $user->role->display_name : 'Brak roli' }}
                        </span>
                    </div>
                </div>
                
                <h6 class="mt-3">Dostępne role</h6>
                <ul class="small">
                    @foreach($roles as $role)
                        <li><strong>{{ $role->display_name }}:</strong> {{ $role->description }}</li>
                    @endforeach
                </ul>
                
                <h6 class="mt-3">Statystyki</h6>
                <ul class="small mb-0">
                    <li>Zarejestrowany: {{ $user->created_at->format('d.m.Y') }}</li>
                    <li>Ostatnia aktualizacja: {{ $user->updated_at->format('d.m.Y') }}</li>
                    <li>Czas w systemie: {{ $user->created_at->diffInDays() }} dni</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection