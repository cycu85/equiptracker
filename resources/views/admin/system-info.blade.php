@extends('layouts.app')

@section('title', 'Informacje o systemie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-info-circle"></i> Informacje o systemie</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót do panelu
    </a>
</div>

<div class="row">
    <!-- Application Information -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-cog"></i> Aplikacja</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Nazwa aplikacji:</strong></td>
                        <td>{{ config('app.name') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Wersja Laravel:</strong></td>
                        <td>
                            <span class="badge bg-success">{{ $info['laravel_version'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Środowisko:</strong></td>
                        <td>
                            <span class="badge bg-{{ $info['app_env'] === 'production' ? 'success' : ($info['app_env'] === 'local' ? 'warning' : 'info') }}">
                                {{ strtoupper($info['app_env']) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tryb debug:</strong></td>
                        <td>
                            <span class="badge bg-{{ $info['app_debug'] ? 'warning' : 'success' }}">
                                {{ $info['app_debug'] ? 'Włączony' : 'Wyłączony' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Strefa czasowa:</strong></td>
                        <td>{{ $info['timezone'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Język:</strong></td>
                        <td>{{ $info['locale'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>URL aplikacji:</strong></td>
                        <td><code>{{ config('app.url') }}</code></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Server Information -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-server"></i> Serwer</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Wersja PHP:</strong></td>
                        <td>
                            <span class="badge bg-info">{{ $info['php_version'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Serwer WWW:</strong></td>
                        <td>{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Nieznany' }}</td>
                    </tr>
                    <tr>
                        <td><strong>System operacyjny:</strong></td>
                        <td>{{ PHP_OS }}</td>
                    </tr>
                    <tr>
                        <td><strong>Architektura:</strong></td>
                        <td>{{ php_uname('m') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Limit pamięci:</strong></td>
                        <td>{{ ini_get('memory_limit') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Czas wykonania:</strong></td>
                        <td>{{ ini_get('max_execution_time') }}s</td>
                    </tr>
                    <tr>
                        <td><strong>Upload max:</strong></td>
                        <td>{{ ini_get('upload_max_filesize') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Database Information -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-database"></i> Baza danych</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Typ bazy:</strong></td>
                        <td>
                            <span class="badge bg-success">{{ strtoupper($info['database']) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Host:</strong></td>
                        <td>{{ config('database.connections.' . $info['database'] . '.host') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Port:</strong></td>
                        <td>{{ config('database.connections.' . $info['database'] . '.port') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Baza danych:</strong></td>
                        <td>{{ config('database.connections.' . $info['database'] . '.database') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Użytkownik:</strong></td>
                        <td>{{ config('database.connections.' . $info['database'] . '.username') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status połączenia:</strong></td>
                        <td>
                            @try
                                @php DB::connection()->getPdo(); @endphp
                                <span class="badge bg-success">Połączono</span>
                            @catch(Exception $e)
                                <span class="badge bg-danger">Błąd połączenia</span>
                            @endtry
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <!-- PHP Extensions -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-plug"></i> Rozszerzenia PHP</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $required_extensions = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'fileinfo'];
                        $loaded_extensions = get_loaded_extensions();
                    @endphp
                    
                    @foreach($required_extensions as $extension)
                        <div class="col-6 mb-2">
                            @if(in_array($extension, $loaded_extensions))
                                <span class="badge bg-success w-100">{{ $extension }}</span>
                            @else
                                <span class="badge bg-danger w-100">{{ $extension }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <hr>
                
                <small class="text-muted">
                    Załadowanych rozszerzeń: {{ count($loaded_extensions) }}
                </small>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Cache Information -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-tachometer-alt"></i> Cache i Storage</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Cache driver:</strong></td>
                        <td>{{ config('cache.default') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Session driver:</strong></td>
                        <td>{{ config('session.driver') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Queue driver:</strong></td>
                        <td>{{ config('queue.default') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Storage disk:</strong></td>
                        <td>{{ config('filesystems.default') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Mail driver:</strong></td>
                        <td>{{ config('mail.default') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Disk Space -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-hdd"></i> Przestrzeń dyskowa</h5>
            </div>
            <div class="card-body">
                @php
                    $bytes_total = disk_total_space('.');
                    $bytes_free = disk_free_space('.');
                    $bytes_used = $bytes_total - $bytes_free;
                    $percent_used = round(($bytes_used / $bytes_total) * 100, 2);
                @endphp
                
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Całkowita:</strong></td>
                        <td>{{ number_format($bytes_total / 1024 / 1024 / 1024, 2) }} GB</td>
                    </tr>
                    <tr>
                        <td><strong>Używana:</strong></td>
                        <td>{{ number_format($bytes_used / 1024 / 1024 / 1024, 2) }} GB</td>
                    </tr>
                    <tr>
                        <td><strong>Wolna:</strong></td>
                        <td>{{ number_format($bytes_free / 1024 / 1024 / 1024, 2) }} GB</td>
                    </tr>
                    <tr>
                        <td><strong>Wykorzystanie:</strong></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar bg-{{ $percent_used > 90 ? 'danger' : ($percent_used > 75 ? 'warning' : 'success') }}" 
                                     style="width: {{ $percent_used }}%">
                                    {{ $percent_used }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- System Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tools"></i> Akcje systemowe</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-info w-100" onclick="location.reload()">
                            <i class="fas fa-sync-alt"></i><br>
                            Odśwież informacje
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-warning w-100" onclick="clearCache()">
                            <i class="fas fa-broom"></i><br>
                            Wyczyść cache
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-success w-100" onclick="showPhpInfo()">
                            <i class="fas fa-info"></i><br>
                            PHP Info
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="downloadSystemInfo()">
                            <i class="fas fa-download"></i><br>
                            Pobierz raport
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function clearCache() {
    if (confirm('Czy na pewno chcesz wyczyścić cache aplikacji?')) {
        alert('Funkcja czyszczenia cache będzie dostępna w przyszłych wersjach.');
    }
}

function showPhpInfo() {
    window.open('data:text/html;charset=utf-8,' + encodeURIComponent('<?php phpinfo(); ?>'), '_blank');
}

function downloadSystemInfo() {
    const info = {
        application: {
            name: '{{ config("app.name") }}',
            laravel_version: '{{ $info["laravel_version"] }}',
            environment: '{{ $info["app_env"] }}',
            debug: {{ $info['app_debug'] ? 'true' : 'false' }},
            timezone: '{{ $info["timezone"] }}',
            locale: '{{ $info["locale"] }}'
        },
        server: {
            php_version: '{{ $info["php_version"] }}',
            server_software: '{{ $_SERVER["SERVER_SOFTWARE"] ?? "Unknown" }}',
            operating_system: '{{ PHP_OS }}',
            architecture: '{{ php_uname("m") }}'
        },
        database: {
            type: '{{ $info["database"] }}',
            host: '{{ config("database.connections." . $info["database"] . ".host") }}',
            port: '{{ config("database.connections." . $info["database"] . ".port") }}'
        }
    };
    
    const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(info, null, 2));
    const downloadAnchorNode = document.createElement('a');
    downloadAnchorNode.setAttribute("href", dataStr);
    downloadAnchorNode.setAttribute("download", "system_info_" + new Date().toISOString().slice(0,10) + ".json");
    document.body.appendChild(downloadAnchorNode);
    downloadAnchorNode.click();
    downloadAnchorNode.remove();
}
</script>
@endsection