<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EquipTracker') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Poppins Font for Velzon theme -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @auth
        @if((auth()->user()->theme_preference ?? 'default') === 'velzon')
            <!-- Velzon Professional Theme -->
            <link href="{{ asset('css/velzon-theme.css') }}" rel="stylesheet">
        @endif
    @endauth
    
    <style>
        @auth
            @if((auth()->user()->theme_preference ?? 'default') === 'default')
                .sidebar {
                    min-height: 100vh;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                }
                .sidebar .nav-link {
                    color: rgba(255,255,255,0.8);
                    transition: all 0.3s;
                    border-radius: 5px;
                    margin: 2px 8px;
                }
                .sidebar .nav-link:hover,
                .sidebar .nav-link.active {
                    color: #fff;
                    background-color: rgba(255,255,255,0.1);
                }
                .sidebar .nav-link.dropdown-toggle::after {
                    float: right;
                    margin-top: 8px;
                }
                .sidebar .submenu {
                    padding-left: 20px;
                    max-height: 0;
                    overflow: hidden;
                    transition: max-height 0.3s ease;
                }
                .sidebar .submenu.show {
                    max-height: 500px;
                }
                .sidebar .submenu .nav-link {
                    font-size: 0.9em;
                    padding: 8px 15px;
                    margin: 1px 8px;
                }
                .sidebar .submenu .nav-link:hover,
                .sidebar .submenu .nav-link.active {
                    background-color: rgba(255,255,255,0.15);
                }
                .main-content {
                    background-color: #f8f9fa;
                    min-height: 100vh;
                }
                .navbar-brand {
                    font-weight: 700;
                    color: #667eea;
                }
            @endif
        @else
            .sidebar {
                min-height: 100vh;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .sidebar .nav-link {
                color: rgba(255,255,255,0.8);
                transition: all 0.3s;
                border-radius: 5px;
                margin: 2px 8px;
            }
            .sidebar .nav-link:hover,
            .sidebar .nav-link.active {
                color: #fff;
                background-color: rgba(255,255,255,0.1);
            }
            .sidebar .nav-link.dropdown-toggle::after {
                float: right;
                margin-top: 8px;
            }
            .sidebar .submenu {
                padding-left: 20px;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }
            .sidebar .submenu.show {
                max-height: 500px;
            }
            .sidebar .submenu .nav-link {
                font-size: 0.9em;
                padding: 8px 15px;
                margin: 1px 8px;
            }
            .sidebar .submenu .nav-link:hover,
            .sidebar .submenu .nav-link.active {
                background-color: rgba(255,255,255,0.15);
            }
            .main-content {
                background-color: #f8f9fa;
                min-height: 100vh;
            }
            .navbar-brand {
                font-weight: 700;
                color: #667eea;
            }
        @endauth
    </style>
    
    @auth
        @if((auth()->user()->theme_preference ?? 'default') === 'velzon')
            <!-- Velzon Theme Override Styles -->
            <style>
                .sidebar {
                    background: #2a3042 !important;
                    box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
                    border-right: 1px solid rgba(255, 255, 255, 0.1);
                }
                .sidebar .nav-link {
                    color: rgba(255, 255, 255, 0.8) !important;
                    padding: 0.75rem 1.25rem !important;
                    margin: 0.125rem 0.75rem !important;
                    border-radius: 0.375rem !important;
                    transition: all 0.15s ease-in-out !important;
                    font-weight: 500 !important;
                }
                .sidebar .nav-link:hover,
                .sidebar .nav-link.active {
                    color: #fff !important;
                    background-color: rgba(255, 255, 255, 0.1) !important;
                    transform: translateX(2px);
                }
                .sidebar .submenu .nav-link {
                    padding-left: 2.5rem !important;
                    font-size: 0.875rem !important;
                    color: rgba(255, 255, 255, 0.7) !important;
                }
                .sidebar .submenu .nav-link:hover,
                .sidebar .submenu .nav-link.active {
                    background-color: rgba(255, 255, 255, 0.15) !important;
                }
            </style>
        @endif
    @endauth
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white"><i class="fas fa-cogs"></i> EquipTracker</h4>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        @foreach($enabledModules ?? [] as $module)
                            @if($module->name === 'Tools')
                                <!-- Tools with submenu -->
                                <li class="nav-item">
                                    <a class="nav-link dropdown-toggle {{ (request()->routeIs('tools.*') || request()->routeIs('toolsets.*')) ? 'active' : '' }}" 
                                       href="#" role="button" data-toggle="submenu" 
                                       onclick="toggleSubmenu(event, 'tools-submenu')">
                                        <i class="{{ $module->icon }} me-2"></i>
                                        {{ $module->display_name }}
                                    </a>
                                    <ul class="nav flex-column submenu {{ (request()->routeIs('tools.*') || request()->routeIs('toolsets.*')) ? 'show' : '' }}" id="tools-submenu">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('tools.*') ? 'active' : '' }}" href="{{ route('tools.index') }}">
                                                <i class="fas fa-hammer me-2"></i>
                                                Elementy
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('toolsets.*') ? 'active' : '' }}" href="{{ route('toolsets.index') }}">
                                                <i class="fas fa-toolbox me-2"></i>
                                                Zestawy
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @elseif($module->name === 'HeightEquipment')
                                <!-- Height Equipment with submenu -->
                                <li class="nav-item">
                                    <a class="nav-link dropdown-toggle {{ (request()->routeIs('height-equipment.*') || request()->routeIs('height-equipment-sets.*')) ? 'active' : '' }}" 
                                       href="#" role="button" data-toggle="submenu" 
                                       onclick="toggleSubmenu(event, 'height-equipment-submenu')">
                                        <i class="{{ $module->icon }} me-2"></i>
                                        {{ $module->display_name }}
                                    </a>
                                    <ul class="nav flex-column submenu {{ (request()->routeIs('height-equipment.*') || request()->routeIs('height-equipment-sets.*')) ? 'show' : '' }}" id="height-equipment-submenu">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('height-equipment.*') ? 'active' : '' }}" href="{{ route('height-equipment.index') }}">
                                                <i class="fas fa-helmet-safety me-2"></i>
                                                Elementy
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('height-equipment-sets.*') ? 'active' : '' }}" href="{{ route('height-equipment-sets.index') }}">
                                                <i class="fas fa-boxes me-2"></i>
                                                Zestawy
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <!-- Regular single-level modules -->
                                <li class="nav-item">
                                    <a class="nav-link {{ str_contains(request()->url(), $module->route_prefix) ? 'active' : '' }}" 
                                       href="{{ route($module->route_prefix . '.index') }}">
                                        <i class="{{ $module->icon }} me-2"></i>
                                        {{ $module->display_name }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <hr class="text-white-50">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cog me-2"></i>
                                        Panel Admina
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top Navigation -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title', 'Dashboard')</h1>
                    
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @auth
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                    <i class="fas fa-user"></i> {{ auth()->user()->full_name }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-edit"></i> Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt"></i> Wyloguj
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Zaloguj
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Submenu functionality -->
    <script>
        function toggleSubmenu(event, submenuId) {
            event.preventDefault();
            const submenu = document.getElementById(submenuId);
            const toggle = event.currentTarget;
            
            if (submenu.classList.contains('show')) {
                submenu.classList.remove('show');
                toggle.classList.remove('active');
            } else {
                // Close all other submenus
                document.querySelectorAll('.submenu.show').forEach(function(menu) {
                    menu.classList.remove('show');
                });
                document.querySelectorAll('.dropdown-toggle.active').forEach(function(toggle) {
                    toggle.classList.remove('active');
                });
                
                // Open this submenu
                submenu.classList.add('show');
                toggle.classList.add('active');
            }
        }
        
        // Auto-expand submenu if current page is in submenu
        document.addEventListener('DOMContentLoaded', function() {
            const activeSubmenu = document.querySelector('.submenu .nav-link.active');
            if (activeSubmenu) {
                const submenu = activeSubmenu.closest('.submenu');
                const toggle = submenu.previousElementSibling;
                submenu.classList.add('show');
                toggle.classList.add('active');
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>