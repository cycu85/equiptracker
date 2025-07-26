@extends('install.layout', ['steps' => [
    ['status' => 'completed'],
    ['status' => 'completed'],
    ['status' => 'active'],
    ['status' => ''],
    ['status' => '']
]])

@section('content')
<h3 class="mb-4"><i class="fas fa-database"></i> Konfiguracja bazy danych</h3>

<div class="alert alert-info alert-install">
    <h6><i class="fas fa-info-circle"></i> Informacje o bazie danych</h6>
    <p class="mb-0">
        EquipTracker wymaga bazy danych MySQL lub MariaDB. Upewnij się, że baza danych została utworzona
        i masz prawidłowe dane dostępowe.
    </p>
</div>

<form id="databaseForm">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="db_host" class="form-label">
                    <i class="fas fa-server"></i> Host bazy danych
                </label>
                <input type="text" class="form-control" id="db_host" name="db_host" 
                       value="127.0.0.1" required>
                <div class="form-text">Zazwyczaj 'localhost' lub '127.0.0.1'</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="db_port" class="form-label">
                    <i class="fas fa-plug"></i> Port
                </label>
                <input type="number" class="form-control" id="db_port" name="db_port" 
                       value="3306" required>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="db_name" class="form-label">
            <i class="fas fa-database"></i> Nazwa bazy danych
        </label>
        <input type="text" class="form-control" id="db_name" name="db_name" 
               value="equiptracker" required>
        <div class="form-text">Baza danych musi już istnieć</div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="db_username" class="form-label">
                    <i class="fas fa-user"></i> Nazwa użytkownika
                </label>
                <input type="text" class="form-control" id="db_username" name="db_username" 
                       value="root" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="db_password" class="form-label">
                    <i class="fas fa-key"></i> Hasło
                </label>
                <input type="password" class="form-control" id="db_password" name="db_password">
                <div class="form-text">Pozostaw puste jeśli brak hasła</div>
            </div>
        </div>
    </div>

    <div class="d-grid mb-3">
        <button type="button" class="btn btn-outline-primary" id="testConnection">
            <i class="fas fa-plug"></i> Testuj połączenie
        </button>
    </div>

    <div id="connectionResult"></div>
</form>

<div class="d-flex justify-content-between mt-4">
    <a href="{{ route('install.requirements') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Poprzedni krok
    </a>
    <a href="{{ route('install.admin') }}" class="btn btn-install" id="nextStep" style="display: none;">
        Konto administratora <i class="fas fa-arrow-right"></i>
    </a>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('testConnection').addEventListener('click', function() {
    const btn = this;
    const form = document.getElementById('databaseForm');
    const formData = new FormData(form);
    const resultDiv = document.getElementById('connectionResult');
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testowanie...';
    
    fetch('{{ route("install.test-database") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = `
                <div class="alert alert-success alert-install">
                    <i class="fas fa-check-circle"></i> ${data.message}
                </div>
            `;
            document.getElementById('nextStep').style.display = 'inline-block';
        } else {
            resultDiv.innerHTML = `
                <div class="alert alert-danger alert-install">
                    <i class="fas fa-exclamation-circle"></i> ${data.message}
                </div>
            `;
            document.getElementById('nextStep').style.display = 'none';
        }
    })
    .catch(error => {
        resultDiv.innerHTML = `
            <div class="alert alert-danger alert-install">
                <i class="fas fa-exclamation-circle"></i> Błąd podczas testowania połączenia
            </div>
        `;
        document.getElementById('nextStep').style.display = 'none';
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-plug"></i> Testuj połączenie';
    });
});
</script>
@endsection