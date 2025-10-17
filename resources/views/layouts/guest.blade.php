<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Icons -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>

            .title h1{
                text-align:center;
                font-weight:bold;
                font-size:30px;
                padding-top:200px;
            }
            .title p{
                text-align:center;
                width:50%;
                margin:auto;
                padding-top:50px;
            }
            h2{
                font-weight:bold;
                font-size:23px;
                text-align:center;
                margin-top:20px;
                margin-bottom:10px;

            }
            .title{
                background-image:
                linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                url('/storage/images/Motherboard.png');
                color:white;
                height:70vh;
                background-size: cover; 
                background-position: center;
                background-repeat: no-repeat;
            }
            
         nav {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 10;
    display: flex;
    justify-content: flex-end;
    gap: 40px;
    padding: 20px 40px;
    background-color: rgba(255, 255, 255, 0.75);
    
}


nav a {
    color: #003366;
    text-decoration: none;
    font-weight: bold;
    font-size: 1.1rem;
    transition: color 0.3s ease;
}

nav a:hover {
    color: #b9e3ff;
}



.service {
    text-align: center;
    padding: 30px 20px;
    background-color: #f9fafb;
}

.service-grid {
    margin-top: 70px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 40px;
    justify-items: center;
}

.service-item {
    display: flex;
    flex-direction: column;
    justify-content: center;   
    align-items: center;       
    background-color: #daeafbff;
    border-radius: 50%;
    width: 190px;
    height: 190px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.service-item i {
    font-size:35px;
    color: #003366;
    margin-bottom: 10px; 
}

.service-item p {
    font-size: 14px;
    color: #1a1a1a;
    text-align: center;
    max-width: 130px;
    line-height: 1.3;
    margin: 0;
}
.contact-section {
    background-color: #e6f2ff; 
    padding: 30px 20px;
    text-align: center;
}
.contact-section p {
    font-size: 16px;
    color: #1a1a1a;
    margin-bottom: 40px;
}
.contact-form {
    max-width: 500px;
    margin: 0 auto;
    background: white;
    padding: 30px 40px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    text-align: left;
}
.contact-form div {
    margin-bottom: 20px;
}
.contact-form label {
    display: block;
    font-weight: 600;
    color: #003366;
    margin-bottom: 8px;
}
.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #b3cde0;
    border-radius: 8px;
    font-size: 15px;
    outline: none;
}
.contact-form input:focus,
.contact-form textarea:focus {
    border-color: #007acc;
}
.contact-form button {
    display: block;
    width: 100%;
    background-color: #007acc;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
}
.contact-form button:hover {
    background-color: #005f99;
}

.infos {
    background-color: #f9fafb;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    line-height: 1.6;
    color: #333;
}

.infos ul {
    list-style-type: none;
    padding: 0;
}

.infos > ul > li {
    margin-bottom: 12px;
    font-weight: 500;
}

.infos ul ul {
    margin-top: 10px;
    margin-left: 20px;
    list-style-type: disc;
    color: #444;
    font-weight: 400;
}

.infos p {
    margin-top: 20px;
    text-align: center;
    color: #222;
    font-size: 1rem;
}
.footer {
    background-color: #1e3a8a; /* глубокий синий */
    color: #f1f5f9;
    text-align: center;
    padding: 30px 20px;
  
}

.footer-content {
    max-width: 900px;
    margin: 0 auto;
}

.footer p {
    margin: 6px 0;
    font-size: 0.95rem;
}

.footer-links {
    margin-top: 15px;
}

.footer-links a {
    color: #93c5fd;
    text-decoration: none;
    margin: 0 10px;
    transition: color 0.3s ease;
    font-weight: 500;
}

.footer-links a:hover {
    color: #fff;
}

        </style>
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
                            {{ $slot }}
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
        <div class="min-h-screen flex flex-col pt-6 sm:pt-0 bg-gray-100 ">
           

            <main class="w-full bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </main>
        </div>
    </body>
<footer class="footer">
    <div class="footer-content">
        <p>© 2025 Atelier 404 — Tous droits réservés</p>
        <p>Projet réalisé par les étudiants en informatique du Campus [Nom du campus]</p>
        <div class="footer-links">
            <a href="#">Mentions légales</a>
            <a href="#">Politique de confidentialité</a>
            <a href="#">Contact</a>
        </div>
    </div>
</footer>
</html>


