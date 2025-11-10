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
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

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

        .service-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
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
        .contact-form textarea,
        .contact-form select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #b3cde0;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            box-sizing: border-box;
        }

        .contact-form input:focus,
        .contact-form textarea:focus,
        .contact-form select:focus {
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
            transition: background-color 0.3s ease;
        }

        .contact-form button:hover {
            background-color: #005f99;
        }

        .infos {
    background-color: #f9fafb;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    line-height: 1.7;
    color: #333;
    max-width: 800px; 
    margin: 40px auto; 
    text-align: left;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.infos:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.infos h2 {
    margin-top:0;
    margin-bottom:15px;
}

.infos ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.infos > ul > li {
    margin-bottom: 14px;
    font-weight: 500;
    font-size: 1.05rem;
}

.infos ul ul {
    margin-top: 10px;
    margin-left: 25px;
    list-style-type: none;
    color: #444;
    font-weight: 400;
    font-size: 0.95rem;
}

.infos p {
    margin-top: 25px;
    text-align: center;
    color: #222;
    font-size: 1rem;
    font-style: italic;
}

details {
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

details:hover {
    background-color: #f0f4fa;
}

summary {
    font-weight: 600;
    color: #1a3e75;
    list-style: none;
}

summary::-webkit-details-marker {
    display: none; 
}

details[open] {
    background-color: #f9fafb;
    border-color: #c9d7e3;
}

details p {
    margin-top: 10px;
    color: #333;
    font-weight: 400;
    font-size: 0.95rem;
}


        .footer {
            background-color: #1e3a8a;
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

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    {{ $slot }}
    
    <footer class="footer">
        <div class="footer-content">
            <p>© 2025 Atelier 404 — Tous droits réservés</p>
            <p>Projet réalisé par les étudiants en informatique du Campus</p>
            <div class="footer-links">
                <a href="#">Mentions légales</a>
                <a href="#">Politique de confidentialité</a>
                <a href="#">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>
