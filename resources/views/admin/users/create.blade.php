@extends('layouts.app')

@section('title', 'Dodaj użytkownika')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Dodaj nowego użytkownika</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do listy
    </a>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Imię i nazwisko <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Hasło <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Potwierdź hasło <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Rola <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Wybierz rolę</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Użytkownik</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Anuluj
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Utworz użytkownika
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
                <h6>Role użytkowników</h6>
                <ul class="small">
                    <li><strong>Użytkownik:</strong> Podstawowy dostęp do systemu</li>
                    <li><strong>Administrator:</strong> Pełny dostęp do panelu administracyjnego</li>
                </ul>
                
                <h6 class="mt-3">Wymagania hasła</h6>
                <ul class="small">
                    <li>Minimum 8 znaków</li>
                    <li>Musi zawierać litery i cyfry</li>
                    <li>Zalecane znaki specjalne</li>
                </ul>
                
                <h6 class="mt-3">Uprawnienia administratora</h6>
                <ul class="small">
                    <li>Zarządzanie użytkownikami</li>
                    <li>Zarządzanie modułami</li>
                    <li>Czyszczenie danych systemu</li>
                    <li>Dostęp do informacji systemowych</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection