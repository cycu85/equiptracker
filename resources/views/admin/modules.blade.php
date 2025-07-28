@extends('layouts.app')

@section('title', 'Zarządzanie modułami')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-puzzle-piece"></i> Zarządzanie modułami</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do panelu
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Dostępne moduły systemu</h5>
                <p class="mb-0 text-muted">Zarządzaj modułami aplikacji - włączaj/wyłączaj oraz zmieniaj kolejność wyświetlania</p>
            </div>
            <div class="card-body">
                @if($modules->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="50">Kolejność</th>
                                    <th>Moduł</th>
                                    <th>Opis</th>
                                    <th>Route</th>
                                    <th width="100">Status</th>
                                    <th width="120">Akcje</th>
                                </tr>
                            </thead>
                            <tbody id="modules-table">
                                @foreach($modules->sortBy('sort_order') as $module)
                                <tr data-module-id="{{ $module->id }}">
                                    <td>
                                        <input type="number" class="form-control form-control-sm sort-order" 
                                               value="{{ $module->sort_order }}" min="0" max="99">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="{{ $module->icon }} me-2 text-primary"></i>
                                            <strong>{{ $module->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $module->description }}</small>
                                    </td>
                                    <td>
                                        <code class="small">{{ $module->route_prefix }}</code>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input module-status" type="checkbox" 
                                                   {{ $module->is_enabled ? 'checked' : '' }}
                                                   data-module-id="{{ $module->id }}">
                                            <label class="form-check-label">
                                                {{ $module->is_enabled ? 'Aktywny' : 'Nieaktywny' }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-success save-module" 
                                                    data-module-id="{{ $module->id }}" title="Zapisz zmiany">
                                                <i class="fas fa-save"></i>
                                            </button>
                                            @if($module->route_prefix)
                                                <a href="{{ route($module->route_prefix . '.index') }}" 
                                                   class="btn btn-outline-primary" title="Otwórz moduł">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary" id="save-all-modules">
                            <i class="fas fa-save"></i> Zapisz wszystkie zmiany
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="location.reload()">
                            <i class="fas fa-undo"></i> Przywróć
                        </button>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-puzzle-piece fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Brak modułów w systemie</h5>
                        <p class="text-muted">Moduły nie zostały jeszcze zainicjalizowane</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informacje o modułach</h6>
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li><strong>Aktywne moduły</strong> są widoczne w menu nawigacji</li>
                    <li><strong>Kolejność</strong> określa pozycję w menu (0 = pierwsze miejsce)</li>
                    <li><strong>Route prefix</strong> to prefiks ścieżki URL modułu</li>
                    <li>Zmiany są zapisywane automatycznie po kliknięciu "Zapisz"</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Ostrzeżenia</h6>
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>Wyłączenie modułu ukryje go z menu, ale nie usunie danych</li>
                    <li>Zmiana kolejności wpływa na wszystkich użytkowników</li>
                    <li>Niektóre moduły mogą być wymagane do poprawnego działania</li>
                    <li>Zmiany są widoczne natychmiast po zapisaniu</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Individual module save
    document.querySelectorAll('.save-module').forEach(button => {
        button.addEventListener('click', function() {
            const moduleId = this.dataset.moduleId;
            saveModule(moduleId);
        });
    });
    
    // Save all modules
    document.getElementById('save-all-modules')?.addEventListener('click', function() {
        document.querySelectorAll('[data-module-id]').forEach(row => {
            const moduleId = row.dataset.moduleId;
            if (moduleId) {
                saveModule(moduleId, false);
            }
        });
        showNotification('Wszystkie moduły zostały zaktualizowane', 'success');
    });
    
    // Auto-update status labels
    document.querySelectorAll('.module-status').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const label = this.nextElementSibling;
            label.textContent = this.checked ? 'Aktywny' : 'Nieaktywny';
        });
    });
});

function saveModule(moduleId, showNotification = true) {
    const row = document.querySelector(`[data-module-id="${moduleId}"]`);
    const isEnabled = row.querySelector('.module-status').checked;
    const sortOrder = row.querySelector('.sort-order').value;
    
    fetch(`/admin/modules/${moduleId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            is_enabled: isEnabled,
            sort_order: parseInt(sortOrder)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && showNotification) {
            showNotification(data.message, 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (showNotification) {
            showNotification('Wystąpił błąd podczas zapisywania', 'error');
        }
    });
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>
@endsection