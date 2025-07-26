<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;

class InstallController extends Controller
{
    public function index()
    {
        // Check if already installed
        if ($this->isInstalled()) {
            return redirect('/')->with('error', 'EquipTracker jest już zainstalowany.');
        }

        return view('install.welcome');
    }

    public function requirements()
    {
        $requirements = $this->checkRequirements();
        return view('install.requirements', compact('requirements'));
    }

    public function database()
    {
        return view('install.database');
    }

    public function testDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required|string',
            'db_port' => 'required|integer',
            'db_name' => 'required|string',
            'db_username' => 'required|string',
            'db_password' => 'nullable|string',
        ]);

        try {
            // Test database connection
            $pdo = new \PDO(
                "mysql:host={$request->db_host};port={$request->db_port};dbname={$request->db_name}",
                $request->db_username,
                $request->db_password
            );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // Store database config in session
            session([
                'install_db_config' => [
                    'host' => $request->db_host,
                    'port' => $request->db_port,
                    'database' => $request->db_name,
                    'username' => $request->db_username,
                    'password' => $request->db_password,
                ]
            ]);

            return response()->json(['success' => true, 'message' => 'Połączenie z bazą danych udane!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Błąd połączenia: ' . $e->getMessage()]);
        }
    }

    public function admin()
    {
        if (!session('install_db_config')) {
            return redirect()->route('install.database')->with('error', 'Skonfiguruj najpierw bazę danych.');
        }

        return view('install.admin');
    }

    public function modules()
    {
        return view('install.modules');
    }

    public function install(Request $request)
    {
        $request->validate([
            'admin_username' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|string|min:6|confirmed',
            'admin_first_name' => 'required|string|max:255',
            'admin_last_name' => 'required|string|max:255',
            'install_demo_data' => 'boolean',
            'modules' => 'array',
        ]);

        try {
            // Step 1: Update .env file
            $this->updateEnvFile(session('install_db_config'));

            // Step 2: Run migrations
            Artisan::call('migrate:fresh', ['--force' => true]);

            // Step 3: Create admin user
            User::updateOrCreate(
                ['username' => $request->admin_username],
                [
                    'username' => $request->admin_username,
                    'email' => $request->admin_email,
                    'password' => bcrypt($request->admin_password),
                    'first_name' => $request->admin_first_name,
                    'last_name' => $request->admin_last_name,
                    'role' => 'admin',
                    'auth_type' => 'local',
                    'is_active' => true,
                ]
            );

            // Step 4: Seed modules
            Artisan::call('db:seed', ['--class' => 'ModuleSeeder', '--force' => true]);

            // Step 5: Update selected modules
            if ($request->modules) {
                DB::table('modules')->update(['is_enabled' => false]);
                DB::table('modules')->whereIn('name', $request->modules)->update(['is_enabled' => true]);
            }

            // Step 6: Install demo data if requested
            if ($request->install_demo_data) {
                Artisan::call('db:seed', ['--force' => true]);
            }

            // Step 7: Create install lock file
            File::put(storage_path('installed'), date('Y-m-d H:i:s'));

            // Clear session
            session()->forget('install_db_config');

            return view('install.complete', [
                'admin_email' => $request->admin_email,
                'admin_username' => $request->admin_username
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Błąd instalacji: ' . $e->getMessage())->withInput();
        }
    }

    protected function isInstalled()
    {
        return File::exists(storage_path('installed'));
    }

    protected function checkRequirements()
    {
        return [
            'php_version' => [
                'required' => '8.1',
                'current' => PHP_VERSION,
                'status' => version_compare(PHP_VERSION, '8.1', '>=')
            ],
            'extensions' => [
                'pdo' => extension_loaded('pdo'),
                'pdo_mysql' => extension_loaded('pdo_mysql'),
                'openssl' => extension_loaded('openssl'),
                'mbstring' => extension_loaded('mbstring'),
                'tokenizer' => extension_loaded('tokenizer'),
                'xml' => extension_loaded('xml'),
                'ctype' => extension_loaded('ctype'),
                'json' => extension_loaded('json'),
                'curl' => extension_loaded('curl'),
            ],
            'permissions' => [
                'storage' => is_writable(storage_path()),
                'storage_app' => is_writable(storage_path('app')),
                'storage_logs' => is_writable(storage_path('logs')),
                'bootstrap_cache' => is_writable(base_path('bootstrap/cache')),
            ]
        ];
    }

    protected function updateEnvFile($dbConfig)
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        $replacements = [
            'DB_CONNECTION=.*' => 'DB_CONNECTION=mysql',
            'DB_HOST=.*' => 'DB_HOST=' . $dbConfig['host'],
            'DB_PORT=.*' => 'DB_PORT=' . $dbConfig['port'],
            'DB_DATABASE=.*' => 'DB_DATABASE=' . $dbConfig['database'],
            'DB_USERNAME=.*' => 'DB_USERNAME=' . $dbConfig['username'],
            'DB_PASSWORD=.*' => 'DB_PASSWORD=' . $dbConfig['password'],
        ];

        foreach ($replacements as $pattern => $replacement) {
            $envContent = preg_replace('/^' . $pattern . '$/m', $replacement, $envContent);
        }

        File::put($envPath, $envContent);
    }
}
