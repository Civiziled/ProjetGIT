# Atelier 404 - Système de Gestion des Interventions

## Résumé du Projet

Le système de gestion de l'Atelier 404 est une application web complète développée avec Laravel pour gérer les interventions de réparation d'équipements informatiques dans un repair café étudiant.

## Fonctionnalités Implémentées

### ✅ Page d'accueil publique
- Formulaire de contact avec validation
- Création automatique de client et intervention
- Informations sur l'Atelier 404
- Design responsive avec Tailwind CSS

### ✅ Authentification et rôles
- Système d'authentification Laravel Breeze
- Deux rôles : Admin et Technicien
- Gestion des permissions avec Gates/Policies
- Protection des routes selon les rôles

### ✅ Gestion des clients
- CRUD complet pour les clients
- Recherche et filtrage
- Historique des interventions par client
- Seuls les admins peuvent créer/modifier/supprimer

### ✅ Gestion des interventions
- CRUD complet avec assignation aux techniciens
- Statuts : Nouvelle demande → Diagnostic → En réparation → Terminé → Non réparable
- Priorités : Faible, Moyenne, Élevée, Urgente
- Upload multiple d'images avec thumbnails
- Notes internes pour les techniciens
- Recherche et filtrage avancés

### ✅ Tableaux de bord
- **Admin** : Vue globale, statistiques, interventions non assignées
- **Technicien** : Interventions assignées uniquement
- Export CSV des interventions (admin)
- Actions rapides contextuelles

### ✅ Gestion des fichiers
- Upload d'images (max 5MB, formats JPG/PNG/GIF)
- Génération automatique de thumbnails
- Stockage sécurisé dans le storage public
- Suppression des fichiers associés

### ✅ Tests automatisés
- Tests Dusk pour le formulaire public
- Tests de gestion des interventions
- Tests de permissions par rôle
- Tests d'upload et suppression d'images
- Tests de recherche et filtrage
- Couverture des cas d'erreur

## Architecture Technique

### Backend
- **Framework** : Laravel 12
- **Base de données** : SQLite (développement) / MySQL (production)
- **Authentification** : Laravel Breeze
- **Images** : Intervention Image
- **Tests** : Laravel Dusk + PHPUnit

### Frontend
- **Templates** : Blade
- **CSS** : Tailwind CSS
- **JavaScript** : Alpine.js (via Breeze)
- **Design** : Responsive, moderne

### Sécurité
- Protection CSRF sur tous les formulaires
- Validation côté serveur
- Gates/Policies pour les permissions
- Upload sécurisé des fichiers

## Structure des Données

### Modèles
- **User** : Utilisateurs avec rôles (admin/technicien)
- **Client** : Clients de l'Atelier 404
- **Intervention** : Interventions de réparation
- **InterventionImage** : Images associées aux interventions

### Relations
- User (1) → (N) Intervention (technicien assigné)
- Client (1) → (N) Intervention
- Intervention (1) → (N) InterventionImage

## Permissions

### Admin
- ✅ Créer/modifier/supprimer des clients
- ✅ Gérer toutes les interventions
- ✅ Assigner des techniciens
- ✅ Exporter les données
- ✅ Voir toutes les statistiques

### Technicien
- ✅ Voir ses interventions assignées
- ✅ Modifier ses interventions
- ✅ Ajouter des notes et images
- ✅ Changer le statut de ses interventions
- ❌ Gérer les clients
- ❌ Assigner des interventions

## Tests Implémentés

### Tests Dusk
1. **PublicContactTest** : Formulaire de contact public
2. **AdminDashboardTest** : Tableau de bord administrateur
3. **TechnicianDashboardTest** : Tableau de bord technicien
4. **ImageUploadTest** : Upload et gestion des images
5. **SearchAndFilterTest** : Recherche et filtrage

### Couverture des Tests
- ✅ Soumission du formulaire public
- ✅ Création automatique client/intervention
- ✅ Processus complet de gestion d'intervention
- ✅ Vérification des permissions par rôle
- ✅ Upload et suppression d'images
- ✅ Changements de statut
- ✅ Recherche et filtrage
- ✅ Cas d'erreur et validation

## Installation et Déploiement

### Prérequis
- PHP 8.2+
- Composer
- Node.js et npm
- SQLite/MySQL/PostgreSQL

### Installation
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm run build
```

### Comptes de Démonstration
- **Admin** : admin@atelier404.com / password
- **Techniciens** : marie.dubois@atelier404.com / password

## Livrables

### ✅ Code Source
- Application Laravel complète
- Modèles, contrôleurs, vues
- Routes et middleware
- Policies et Gates

### ✅ Diagramme UML
- Diagramme de classes complet
- Relations et multiplicités
- Énumérations (statuts, rôles, priorités)
- Méthodes principales

### ✅ Tests
- Suite de tests Dusk fonctionnels
- Tests unitaires
- Couverture des fonctionnalités principales

### ✅ Documentation
- README d'installation
- Documentation des fonctionnalités
- Guide d'utilisation

### ✅ Données de Démonstration
- Seeders avec données réalistes
- Utilisateurs, clients, interventions
- Images d'exemple

## Conformité aux Exigences

### ✅ Stack Obligatoire
- Laravel avec Blade ✓
- Laravel Breeze ✓
- Base de données relationnelle ✓
- PHP 8.2+ ✓

### ✅ Sécurité
- Protection CSRF ✓
- Validation côté serveur ✓
- Gates/Policies ✓
- Permissions par rôle ✓

### ✅ Gestion des Fichiers
- Upload dans storage public ✓
- Validation des types ✓
- Taille maximale 5MB ✓
- Génération de thumbnails ✓

### ✅ Tests Dusk
- Couverture minimale requise ✓
- Tests par fonctionnalité ✓
- Factories pour les données ✓
- Base de test dédiée ✓

## Points Forts du Projet

1. **Architecture solide** : Respect des bonnes pratiques Laravel
2. **Sécurité** : Permissions granulaires et validation stricte
3. **UX/UI** : Interface moderne et intuitive
4. **Tests** : Couverture complète des fonctionnalités
5. **Documentation** : Guide d'installation et d'utilisation
6. **Extensibilité** : Code modulaire et maintenable

Le projet répond entièrement aux exigences du cahier des charges et fournit une solution complète pour la gestion de l'Atelier 404.
