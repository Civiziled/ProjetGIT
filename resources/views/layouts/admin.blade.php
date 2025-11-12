<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Atelier 404</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            <!-- Navigation -->
            <nav class="bg-white shadow-sm border-b">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-900">
                                Atelier 404 - Administration
                            </a>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('technician.dashboard') ? 'font-extrabold' : '' }}">Tableau de bord</a>
                            <a href="{{ route('interventions.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('interventions.*') ? 'font-extrabold' : '' }}">Interventions</a>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('clients.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('clients.*') ? 'font-extrabold' : '' }}">Clients</a>
                                     <a href="{{ route('techniciens.index') }}" class="text-gray-600 hover:text-gray-900 {{ request()->routeIs('techniciens.*') ? 'font-extrabold' : '' }}">Techniciens</a>
                                @endif
                            @endauth
                            
                            <!-- Dropdown utilisateur -->
                            <div class="relative">
                                <button class="flex items-center text-sm text-gray-700 hover:text-gray-900 focus:outline-none" id="user-menu-button">
                                    <span class="mr-2">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden" id="user-menu">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Messages flash -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Contenu principal -->
            <main class="min-h-screen bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    @yield('content')
                </div>
            </main>
        </div>
         <script>
            // Gestion du dropdown utilisateur
            document.getElementById('user-menu-button').addEventListener('click', function() {
                const menu = document.getElementById('user-menu');
                menu.classList.toggle('hidden');
            });

            // Fermer le dropdown en cliquant ailleurs
            document.addEventListener('click', function(event) {
                const button = document.getElementById('user-menu-button');
                const menu = document.getElementById('user-menu');
                if (!button.contains(event.target) && !menu.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        </script>
        </body>
</html>

