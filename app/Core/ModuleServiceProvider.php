<?php

namespace App\Core;

use App\Models\Module;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('modules', function () {
            try {
                return Module::enabled()->ordered()->get();
            } catch (\Exception $e) {
                return collect();
            }
        });
    }

    public function boot()
    {
        $this->loadModuleRoutes();
        $this->shareModulesWithViews();
    }

    protected function loadModuleRoutes()
    {
        $modules = app('modules');
        
        foreach ($modules as $module) {
            $routeFile = app_path("Modules/{$module->name}/Routes/web.php");
            
            if (file_exists($routeFile)) {
                Route::middleware('web')
                    ->prefix($module->route_prefix)
                    ->namespace("App\\Modules\\{$module->name}\\Controllers")
                    ->group($routeFile);
            }
        }
    }

    protected function shareModulesWithViews()
    {
        View::composer('*', function ($view) {
            $view->with('enabledModules', app('modules'));
        });
    }
}