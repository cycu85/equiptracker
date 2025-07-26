<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $moduleName): Response
    {
        $modules = app('modules');
        $module = $modules->where('name', $moduleName)->first();
        
        if (!$module || !$module->is_enabled) {
            abort(404, 'Module not found or disabled');
        }
        
        return $next($request);
    }
}
