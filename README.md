# 🔧 Atelier 404 - Système de Gestion des Interventions

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC.svg)
![SQLite](https://img.shields.io/badge/SQLite-003B57.svg)

**Une solution complète de gestion d'interventions pour repair café étudiant**

[🚀 Installation](#-installation-rapide) • [📋 Fonctionnalités](#-fonctionnalités) • [🏗️ Architecture](#️-architecture-technique) • [🧪 Tests](#-tests-automatisés)

</div>

---

## 🎯 À Propos du Projet

**Atelier 404** est une application web moderne développée avec Laravel pour gérer efficacement les interventions de réparation d'équipements informatiques dans un repair café étudiant. L'application offre une interface intuitive pour les administrateurs et techniciens, avec un système de gestion complet des clients, interventions et fichiers.

### 🌟 Points Forts

- ✅ **Interface moderne** avec Tailwind CSS et design responsive
- ✅ **Système de rôles** (Admin/Technicien) avec permissions granulaires
- ✅ **Gestion complète** des clients et interventions
- ✅ **Upload d'images** avec génération automatique de thumbnails
- ✅ **Tests automatisés** avec Laravel Dusk
- ✅ **Sécurité renforcée** avec Gates/Policies et validation stricte

---

## 🚀 Installation Rapide

### Prérequis
- PHP 8.2+
- Composer
- Node.js et npm
- SQLite/MySQL/PostgreSQL

### Installation
```bash
# Cloner le projet
git clone [url-du-repo]
cd ProjetGIT

# Installer les dépendances
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
php artisan migrate
php artisan db:seed
php artisan storage:link

# Build des assets
npm run build

# Lancer le serveur
php artisan serve
```

### 🔑 Comptes de Démonstration
- **Admin** : `admin@atelier404.com` / `password`
- **Technicien** : `marie.dubois@atelier404.com` / `password`

---

## 📋 Fonctionnalités

### 🏠 Page d'Accueil Publique
- Formulaire de contact avec validation
- Création automatique de client et intervention
- Informations sur l'Atelier 404
- Design responsive et moderne

### 👥 Gestion des Utilisateurs
- **Authentification** : Laravel Breeze
- **Rôles** : Admin et Technicien
- **Permissions** : Gates/Policies pour la sécurité
- **Protection** : Routes sécurisées par rôle

### 👤 Gestion des Clients
- **CRUD complet** pour les clients
- **Recherche et filtrage** avancés
- **Historique** des interventions par client
- **Restrictions** : Seuls les admins peuvent gérer

### 🔧 Gestion des Interventions
- **CRUD complet** avec assignation aux techniciens
- **Statuts** : Nouvelle demande → Diagnostic → En réparation → Terminé → Non réparable
- **Priorités** : Faible, Moyenne, Élevée, Urgente
- **Upload multiple** d'images avec thumbnails
- **Notes internes** pour les techniciens
- **Recherche et filtrage** avancés

### 📊 Tableaux de Bord
- **Admin** : Vue globale, statistiques, interventions non assignées
- **Technicien** : Interventions assignées uniquement
- **Export CSV** des interventions (admin)
- **Actions rapides** contextuelles

### 📁 Gestion des Fichiers
- **Upload d'images** (max 5MB, formats JPG/PNG/GIF)
- **Génération automatique** de thumbnails
- **Stockage sécurisé** dans le storage public
- **Suppression** des fichiers associés

---

## 🏗️ Architecture Technique

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
- **Protection CSRF** sur tous les formulaires
- **Validation** côté serveur
- **Gates/Policies** pour les permissions
- **Upload sécurisé** des fichiers

---

## 🗄️ Structure des Données

### Modèles Principaux
- **User** : Utilisateurs avec rôles (admin/technicien)
- **Client** : Clients de l'Atelier 404
- **Intervention** : Interventions de réparation
- **InterventionImage** : Images associées aux interventions

### Relations
- User (1) → (N) Intervention (technicien assigné)
- Client (1) → (N) Intervention
- Intervention (1) → (N) InterventionImage

### Permissions par Rôle

#### 🔑 Admin
- ✅ Créer/modifier/supprimer des clients
- ✅ Gérer toutes les interventions
- ✅ Assigner des techniciens
- ✅ Exporter les données
- ✅ Voir toutes les statistiques

#### 👨‍💻 Technicien
- ✅ Voir ses interventions assignées
- ✅ Modifier ses interventions
- ✅ Ajouter des notes et images
- ✅ Changer le statut de ses interventions
- ❌ Gérer les clients
- ❌ Assigner des interventions

---

## 🧪 Tests Automatisés

### Tests Dusk Implémentés
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

### Lancer les Tests
```bash
# Tests Dusk (navigateur)
php artisan dusk

# Tests unitaires
php artisan test
```

---

## 📈 Conformité aux Exigences

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

---

## 🎨 Interface Utilisateur

L'application propose une interface moderne et intuitive avec :

- **Design responsive** adapté à tous les écrans
- **Navigation claire** avec menus contextuels
- **Formulaires optimisés** avec validation en temps réel
- **Tableaux interactifs** avec recherche et filtrage
- **Upload d'images** avec aperçu immédiat
- **Notifications** pour les actions importantes

---

## 🚀 Déploiement

### Production
```bash
# Optimisation pour la production
composer install --optimize-autoloader --no-dev
npm run build

# Configuration de la base de données
# Mettre à jour .env avec les paramètres de production

# Migrations
php artisan migrate --force

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📚 Documentation

- [Guide d'installation détaillé](README_INSTALLATION.md)
- [Schéma de base de données](database_schema.md)
- [Diagramme UML](uml_diagram.md)
- [Résumé complet du projet](PROJET_SUMMARY.md)

---

## 🤝 Contribution

Ce projet a été développé dans le cadre d'un projet académique. Pour toute question ou suggestion, n'hésitez pas à ouvrir une issue.

---

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

<div align="center">

**Développé avec ❤️ pour l'Atelier 404**

*Une solution complète de gestion d'interventions pour repair café étudiant*

</div>
