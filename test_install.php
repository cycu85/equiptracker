<?php

// Test instalatora EquipTracker
echo "=== Test Instalatora EquipTracker ===\n\n";

// Test 1: Sprawdzenie wymagań systemowych
echo "1. Sprawdzenie wymagań systemowych:\n";
echo "   PHP Version: " . PHP_VERSION . (version_compare(PHP_VERSION, '8.1', '>=') ? " ✅" : " ❌") . "\n";

$extensions = ['pdo', 'pdo_mysql', 'openssl', 'mbstring', 'tokenizer', 'xml', 'ctype', 'json', 'curl'];
foreach ($extensions as $ext) {
    echo "   Extension $ext: " . (extension_loaded($ext) ? "✅" : "❌") . "\n";
}

// Test 2: Sprawdzenie uprawnień katalogów
echo "\n2. Sprawdzenie uprawnień katalogów:\n";
$directories = [
    'storage' => 'storage',
    'storage/app' => 'storage/app', 
    'storage/logs' => 'storage/logs',
    'bootstrap/cache' => 'bootstrap/cache'
];

foreach ($directories as $name => $path) {
    echo "   $name: " . (is_writable($path) ? "✅ Zapisywalny" : "❌ Brak uprawnień") . "\n";
}

// Test 3: Test struktury aplikacji
echo "\n3. Test struktury aplikacji:\n";
$files = [
    'app/Http/Controllers/InstallController.php',
    'resources/views/install/welcome.blade.php',
    'resources/views/install/layout.blade.php'
];

foreach ($files as $file) {
    echo "   $file: " . (file_exists($file) ? "✅" : "❌") . "\n";
}

// Test 4: Test konfiguracji Laravel
echo "\n4. Test konfiguracji Laravel:\n";
try {
    require 'vendor/autoload.php';
    $app = require 'bootstrap/app.php';
    echo "   Laravel Bootstrap: ✅\n";
    
    echo "   APP_KEY: " . (strlen(env('APP_KEY', '')) > 0 ? "✅" : "❌") . "\n";
    echo "   APP_ENV: " . env('APP_ENV', 'production') . "\n";
} catch (Exception $e) {
    echo "   Laravel Bootstrap: ❌ " . $e->getMessage() . "\n";
}

echo "\n=== Podsumowanie ===\n";
echo "Jeśli wszystkie testy pokazują ✅, instalator powinien działać poprawnie.\n";
echo "Dostęp do instalatora: http://localhost:8000/install\n\n";

// Test 5: Demonstracja URL-i instalatora
echo "5. Dostępne URL-e instalatora:\n";
$routes = [
    '/install' => 'Strona powitalna',
    '/install/requirements' => 'Sprawdzenie wymagań',
    '/install/database' => 'Konfiguracja bazy danych',
    '/install/admin' => 'Tworzenie konta administratora'
];

foreach ($routes as $url => $description) {
    echo "   $url - $description\n";
}

echo "\n✨ Test instalatora zakończony!\n";
?>