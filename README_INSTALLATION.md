# Atelier 404 - Système de Gestion des Interventions

## Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js et npm
- SQLite (ou MySQL/PostgreSQL)

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd atelier-404
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances Node.js**
```bash
npm install
```

4. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configuration de la base de données**
```bash
# Pour SQLite (recommandé pour le développement)
touch database/database.sqlite

# Ou pour MySQL/PostgreSQL, configurer les variables DB_* dans .env
```

6. **Exécuter les migrations**
```bash
php artisan migrate
```

7. **Peupler la base de données avec les données de démonstration**
```bash
php artisan db:seed
```

8. **Créer le lien symbolique pour le stockage**
```bash
php artisan storage:link
```

9. **Compiler les assets**
```bash
npm run build
```

10. **Démarrer le serveur de développement**
```bash
php artisan serve
```

## Comptes de démonstration

### Administrateur
- **Email:** admin@atelier404.com
- **Mot de passe:** password

### Techniciens
- **Email:** marie.dubois@atelier404.com
- **Mot de passe:** password

- **Email:** pierre.martin@atelier404.com
- **Mot de passe:** password

- **Email:** sophie.laurent@atelier404.com
- **Mot de passe:** password

- **Email:** thomas.bernard@atelier404.com
- **Mot de passe:** password

## Fonctionnalités

### Page publique
- Formulaire de contact pour demander une réparation
- Création automatique de client et intervention
- Informations sur l'Atelier 404

### Tableau de bord administrateur
- Vue d'ensemble des statistiques
- Gestion des clients
- Gestion des interventions
- Attribution aux techniciens
- Export CSV des interventions

### Tableau de bord technicien
- Interventions assignées
- Mise à jour des statuts
- Ajout de notes et images
- Historique des interventions

### Gestion des permissions
- Seuls les admins peuvent créer/modifier/supprimer des clients
- Les techniciens ne voient que leurs interventions assignées
- Seul l'admin peut réassigner une intervention

### Gestion des images
- Upload multiple d'images (max 5MB par fichier)
- Génération automatique de thumbnails
- Formats supportés: JPG, PNG, GIF

## Tests

### Tests Dusk (navigateur)
```bash
php artisan dusk
```

### Tests unitaires
```bash
php artisan test
```

## Structure du projet

```
app/
├── Http/Controllers/
│   ├── ClientController.php
│   ├── DashboardController.php
│   ├── InterventionController.php
│   └── PublicController.php
├── Models/
│   ├── Client.php
│   ├── Intervention.php
│   ├── InterventionImage.php
│   └── User.php
└── Policies/
    ├── ClientPolicy.php
    └── InterventionPolicy.php

resources/views/
├── layouts/
│   ├── app.blade.php
│   └── public.blade.php
├── dashboard/
│   ├── admin.blade.php
│   └── technician.blade.php
├── interventions/
│   ├── index.blade.php
│   ├── show.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── clients/
│   ├── index.blade.php
│   ├── show.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── public/
    └── index.blade.php
```

## Technologies utilisées

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Base de données:** SQLite/MySQL/PostgreSQL
- **Authentification:** Laravel Breeze
- **Images:** Intervention Image
- **Tests:** Laravel Dusk, PHPUnit
