@extends('layouts.app')

@section('title', 'Dodaj zestaw narzędzi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Dodaj nowy zestaw narzędzi</h2>
    <a href="{{ route('toolsets.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do listy
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('toolsets.store') }}">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label">Nazwa zestawu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="code" class="form-label">Kod zestawu</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                   id="code" name="code" value="{{ old('code') }}" placeholder="np. ZES-001">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis zestawu</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status and Location -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktywny</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nieaktywny</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Konserwacja</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Lokalizacja</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}" 
                                   placeholder="np. Magazyn A, Budowa 1, Warsztat">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label">Notatki</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tools Selection -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><i class="fas fa-tools"></i> Narzędzia w zestawie</h5>
                        </div>
                        <div class="card-body">
                            <div id="tools-container">
                                <div class="tool-row mb-3" style="display: none;" id="tool-template">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-select" name="tools[0][tool_id]">
                                                <option value="">Wybierz narzędzie</option>
                                                @foreach($availableTools as $tool)
                                                    <option value="{{ $tool->id }}">{{ $tool->name }} ({{ $tool->brand }} {{ $tool->model }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control" name="tools[0][quantity]" 
                                                   placeholder="Ilość" min="1" value="1">
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tools[0][is_required]" value="1" checked>
                                                <label class="form-check-label">Wymagane</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="tools[0][notes]" placeholder="Notatki">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm remove-tool">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary" id="add-tool">
                                <i class="fas fa-plus"></i> Dodaj narzędzie
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('toolsets.index') }}" class="btn btn-secondary me-2">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Zapisz zestaw
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
                    <li>Nazwa zestawu</li>
                    <li>Status</li>
                </ul>
                
                <h6 class="mt-3">Statusy zestawu</h6>
                <ul class="small">
                    <li><span class="badge bg-success">Aktywny</span> - gotowy do użycia</li>
                    <li><span class="badge bg-warning">Nieaktywny</span> - tymczasowo niedostępny</li>
                    <li><span class="badge bg-danger">Konserwacja</span> - w trakcie przeglądu</li>
                </ul>

                <h6 class="mt-3">Typy narzędzi</h6>
                <ul class="small">
                    <li><span class="badge bg-danger">Wymagane</span> - niezbędne do pracy</li>
                    <li><span class="badge bg-secondary">Opcjonalne</span> - pomocnicze</li>
                </ul>
                
                <div class="alert alert-info mt-3">
                    <small><i class="fas fa-lightbulb"></i> Możesz dodawać narzędzia do zestawu klikając przycisk "Dodaj narzędzie".</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let toolIndex = 0;

document.getElementById('add-tool').addEventListener('click', function() {
    const template = document.getElementById('tool-template');
    const clone = template.cloneNode(true);
    
    // Update IDs and names
    clone.id = 'tool-row-' + toolIndex;
    clone.style.display = 'block';
    clone.querySelectorAll('select, input').forEach(element => {
        if (element.name) {
            element.name = element.name.replace('[0]', '[' + toolIndex + ']');
        }
    });
    
    // Add remove functionality
    clone.querySelector('.remove-tool').addEventListener('click', function() {
        clone.remove();
    });
    
    document.getElementById('tools-container').appendChild(clone);
    toolIndex++;
});

// Handle remove tool buttons
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-tool') || e.target.parentElement.classList.contains('remove-tool')) {
        e.preventDefault();
        const row = e.target.closest('.tool-row');
        if (row && row.id !== 'tool-template') {
            row.remove();
        }
    }
});
</script>
@endsection