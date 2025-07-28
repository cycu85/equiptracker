@extends('layouts.app')

@section('title', 'Dodaj pracownika')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Dodaj nowego pracownika</h2>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do listy
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('employees.store') }}">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">Imię <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Nazwisko <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="employee_id" class="form-label">ID pracownika</label>
                            <input type="text" class="form-control @error('employee_id') is-invalid @enderror" 
                                   id="employee_id" name="employee_id" value="{{ old('employee_id') }}"
                                   placeholder="np. EMP001">
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktywny</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nieaktywny</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}"
                                   placeholder="pracownik@firma.pl">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Telefon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}"
                                   placeholder="np. +48 123 456 789">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Job Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="position" class="form-label">Stanowisko</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                   id="position" name="position" value="{{ old('position') }}"
                                   placeholder="np. Kierownik projektu">
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="form-label">Dział</label>
                            <select class="form-select @error('department') is-invalid @enderror" id="department" name="department">
                                <option value="">Wybierz dział</option>
                                <option value="IT" {{ old('department') == 'IT' ? 'selected' : '' }}>IT</option>
                                <option value="HR" {{ old('department') == 'HR' ? 'selected' : '' }}>HR</option>
                                <option value="Finansowy" {{ old('department') == 'Finansowy' ? 'selected' : '' }}>Finansowy</option>
                                <option value="Produkcja" {{ old('department') == 'Produkcja' ? 'selected' : '' }}>Produkcja</option>
                                <option value="Sprzedaż" {{ old('department') == 'Sprzedaż' ? 'selected' : '' }}>Sprzedaż</option>
                                <option value="Marketing" {{ old('department') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Biuro" {{ old('department') == 'Biuro' ? 'selected' : '' }}>Biuro</option>
                                <option value="Warsztat" {{ old('department') == 'Warsztat' ? 'selected' : '' }}>Warsztat</option>
                                <option value="Magazyn" {{ old('department') == 'Magazyn' ? 'selected' : '' }}>Magazyn</option>
                                <option value="Inne" {{ old('department') == 'Inne' ? 'selected' : '' }}>Inne</option>
                            </select>
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hire_date" class="form-label">Data zatrudnienia</label>
                            <input type="date" class="form-control @error('hire_date') is-invalid @enderror" 
                                   id="hire_date" name="hire_date" value="{{ old('hire_date') }}">
                            @error('hire_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="salary" class="form-label">Wynagrodzenie (PLN)</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('salary') is-invalid @enderror" 
                                   id="salary" name="salary" value="{{ old('salary') }}">
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Adres</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3"
                                  placeholder="Ulica, numer domu/mieszkania, kod pocztowy, miasto">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Emergency Contact -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="emergency_contact_name" class="form-label">Kontakt awaryjny - osoba</label>
                            <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                   id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}"
                                   placeholder="Imię i nazwisko">
                            @error('emergency_contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="emergency_contact_phone" class="form-label">Kontakt awaryjny - telefon</label>
                            <input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                   id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}"
                                   placeholder="Numer telefonu">
                            @error('emergency_contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Uwagi</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary me-2">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Zapisz pracownika
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
                <h6>Wymagane pola</h6>
                <ul class="small">
                    <li>Imię</li>
                    <li>Nazwisko</li>
                    <li>Status</li>
                </ul>
                
                <h6 class="mt-3">Działy</h6>
                <ul class="small">
                    <li><strong>IT:</strong> informatyka, systemy</li>
                    <li><strong>HR:</strong> zasoby ludzkie</li>
                    <li><strong>Produkcja:</strong> wytwarzanie</li>
                    <li><strong>Sprzedaż:</strong> handel, klienci</li>
                    <li><strong>Warsztat:</strong> naprawa, serwis</li>
                </ul>
                
                <h6 class="mt-3">Statusy</h6>
                <ul class="small">
                    <li><span class="badge bg-success">Aktywny</span> - zatrudniony</li>
                    <li><span class="badge bg-secondary">Nieaktywny</span> - zwolniony/urlop</li>
                </ul>
                
                <h6 class="mt-3">Informacje</h6>
                <p class="small text-muted">
                    Dane osobowe są chronione zgodnie z RODO. 
                    Wprowadzaj tylko niezbędne informacje.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection