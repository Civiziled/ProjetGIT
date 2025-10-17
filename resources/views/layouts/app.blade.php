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
    <body class="font-sans text-gray-900 antialiased">
        <!-- Background avec gradient et pattern -->
        <div class="min-h-screen relative overflow-hidden">
            <!-- Background décoratif -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50"></div>
            
            <!-- Formes géométriques décoratives -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
                <div class="absolute top-20 left-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse"></div>
                <div class="absolute top-40 right-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
                <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse" style="animation-delay: 4s;"></div>
            </div>

            <!-- Contenu principal -->
            <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
                <!-- Logo et titre -->
                <div class="text-center mb-8 fade-in">
                    <a href="/" class="inline-block">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-300 icon-bounce">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2 fade-in-delay-1">Atelier 404</h1>
                    <p class="text-gray-600 fade-in-delay-2">Système de gestion des interventions</p>
                </div>

                <!-- Carte de formulaire -->
                <div class="w-full max-w-md fade-in-delay-3">
                    <div class="auth-card bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                        <!-- Header de la carte -->
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white text-center">
                                @if(request()->routeIs('login'))
                                    Connexion
                                @elseif(request()->routeIs('register'))
                                    Inscription
                                @else
                                    Authentification
                                @endif
                            </h2>
                        </div>
                        
                        <!-- Contenu du formulaire -->
                        <div class="px-6 py-8">
                             {{$slot}}
                        </div>
                    </div>
                    
                    <!-- Liens supplémentaires -->
                    <div class="mt-6 text-center">
                        @if(request()->routeIs('login'))
                            <p class="text-gray-600">
                                Pas encore de compte ? 
                                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                                    Créer un compte
                                </a>
                            </p>
                        @elseif(request()->routeIs('register'))
                            <p class="text-gray-600">
                                Déjà un compte ? 
                                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                                    Se connecter
                                </a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        
    </body>
</html> 