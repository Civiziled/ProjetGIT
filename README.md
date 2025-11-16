# 🔧 Atelier 404 - Système de Gestion des Interventions

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC.svg)
![SQLite](https://img.shields.io/badge/SQLite-003B57.svg)

**Une solution complète de gestion d'interventions pour repair café étudiant**

[🚀 Installation](#-installation-rapide) • [📊 Diagramme UML](#-diagramme-uml) • [📦 Livrables](#-livrables) • [🧪 Tests](#-tests-automatisés)

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

## 📊 Diagramme UML

### Modèle de Données

Le système est modélisé avec les classes suivantes :

#### 1. **role** (Énumération)
- **Attributs :**
  - `+admin`
  - `+technicien`

#### 2. **Clients**
- **Attributs :**
  - `+id: int`
  - `+nom: string`
  - `+email: string`
  - `+adresse: string`
  - `+telephone: string`
  - `+created_at: datetime`
  - `+updated_at: datetime`
- **Opérations :**
  - `+historiqueIntervention(): list<intervention>`
  - `+filtrerIntervention(): filtrer<intervention>`

#### 3. **User**
- **Attributs :**
  - `+id: int`
  - `+nom: string`
  - `+email: string`
  - `+mot_de_passe: string`
  - `+role: role`
  - `+created_at: datetime`
  - `+updated_at: datetime`
- **Opérations :**
  - `+assignerintervention()`
  - `+VoirsesInterventions()`

#### 4. **Priorité** (Énumération)
- **Attributs :**
  - `+Basse` (Low)
  - `+Moyenne` (Medium)
  - `+Haute` (High)
  - `+Urgente` (Urgent)

#### 5. **Status_Intervention** (Énumération)
- **Attributs :**
  - `+nouvelle_demande`
  - `+diagnostic`
  - `+en_reparation`
  - `+termine`
  - `+non_reparable`

#### 6. **Intervention**
- **Attributs :**
  - `+id: int`
  - `+client_id: int` (FK vers Clients)
  - `+technicien_id: int` (FK vers User)
  - `+type_appareil: string`
  - `+description_probleme: text`
  - `+statut: status_intervention`
  - `+priorité: priorité`
  - `+date_prévu: date`
  - `+created_at: date`
- **Opérations :**
  - `+interventionImage()`
  - `+i()`

#### 7. **Contact**
- **Attributs :**
  - `+nom: string`
  - `+email: string`
  - `+telephone: string`
  - `+type_appareil: string`
  - `+description_probleme: text`
- **Opérations :**
  - `+validerFormulaire()`
  - `+créerClientEtIntervention()`

### Relations

- **User** → **role** : Un utilisateur a un rôle (admin ou technicien)
- **Intervention** → **Clients** : Une intervention appartient à un client (via `client_id`)
- **Intervention** → **User** : Une intervention est assignée à un technicien (via `technicien_id`)
- **Intervention** → **Status_Intervention** : Une intervention a un statut
- **Intervention** → **Priorité** : Une intervention a une priorité

### Diagramme UML

Le diagramme UML complet est disponible dans le repository :
- **Format** : PDF ou Image (voir section [Livrables](#-livrables))
- **Contenu** : Diagramme de classes complet avec toutes les relations et énumérations

---

## 📦 Livrables

Ce repository GitHub contient tous les éléments suivants :

### ✅ 1. Code Source Complet

Le code source complet de l'application Laravel est disponible dans ce repository :

**Structure principale :**
```
ProjetGIT/
├── app/
│   ├── Http/Controllers/      # Contrôleurs (Intervention, Client, Dashboard, etc.)
│   ├── Models/                 # Modèles Eloquent (User, Client, Intervention, etc.)
│   ├── Policies/               # Policies d'autorisation
│   ├── Services/               # Services métier
│   └── Mail/                   # Classes Mail (notifications)
├── database/
│   ├── migrations/             # Migrations de base de données
│   └── seeders/                # Seeders pour données de démonstration
├── resources/views/            # Vues Blade
├── routes/                     # Routes web et authentification
├── tests/
│   ├── Browser/                # Tests Dusk
│   ├── Feature/                # Tests de fonctionnalités
│   └── Unit/                   # Tests unitaires
└── .env.example                # Configuration d'environnement
```

### ✅ 2. Diagramme UML (Format PDF ou Image)

Le diagramme UML complet est disponible en format :
- **PDF** : `diagramme_uml.pdf` (à générer)
- **Image** : `diagramme_uml.png` (à générer)

**Pour générer le diagramme depuis le code Mermaid :**

```bash
# Installation de Mermaid CLI
npm install -g @mermaid-js/mermaid-cli

# Génération en PDF
mmdc -i diagramme.mmd -o diagramme_uml.pdf

# Génération en PNG
mmdc -i diagramme.mmd -o diagramme_uml.png
```

**Ou utiliser Mermaid Live Editor :** [https://mermaid.live](https://mermaid.live)

Le diagramme inclut :
- Toutes les classes (role, Clients, User, Priorité, Status_Intervention, Intervention, Contact)
- Tous les attributs et opérations
- Toutes les relations entre les classes
- Les énumérations (role, Priorité, Status_Intervention)

### ✅ 3. Suite de Tests Dusk Fonctionnels

Tests Dusk complets disponibles dans `tests/Browser/` :

1. **`AdminDashboardTest.php`**
   - Test de connexion admin
   - Test d'affichage du dashboard
   - Test de gestion des interventions
   - Test de création d'intervention
   - Test de gestion des clients
   - Test d'export CSV

2. **`TechnicianDashboardTest.php`**
   - Test de connexion technicien
   - Test d'affichage du dashboard
   - Test de visualisation des interventions assignées
   - Test de modification d'intervention
   - Test de changement de statut
   - Test des restrictions d'accès

3. **`PublicContactTest.php`**
   - Test du formulaire de contact public
   - Test de création automatique client/intervention

4. **`ImageUploadTest.php`**
   - Test d'upload d'images
   - Test d'affichage et suppression

5. **`SearchAndFilterTest.php`**
   - Test de recherche et filtrage

**Exécution des tests :**
```bash
# Tests Dusk (nécessite ChromeDriver)
php artisan dusk

# Tests unitaires
php artisan test
```

### ✅ 4. Fichier .env.example Configuré

Le fichier `.env.example` est présent à la racine avec toutes les variables d'environnement nécessaires :

- Configuration de l'application (APP_NAME, APP_ENV, APP_DEBUG, etc.)
- Configuration de la base de données (SQLite par défaut, options MySQL/PostgreSQL)
- Configuration mail (SMTP ou log)
- Configuration session et cache
- Configuration filesystem
- Variables d'environnement complètes

**Utilisation :**
```bash
cp .env.example .env
php artisan key:generate
```

### ✅ 5. Seeders pour Données de Démonstration

Seeders complets disponibles dans `database/seeders/` :

1. **`UserSeeder.php`**
   - Crée 1 administrateur : `admin@atelier404.com` / `password`
   - Crée 4 techniciens avec des comptes de démonstration

2. **`ClientSeeder.php`**
   - Crée 8 clients avec données complètes (nom, email, téléphone, adresse)

3. **`InterventionSeeder.php`**
   - Crée 8 interventions avec différents statuts
   - Différentes priorités (Basse, Moyenne, Haute, Urgente)
   - Différents types d'appareils
   - Assignations aux techniciens

**Exécution des seeders :**
```bash
# Exécuter tous les seeders
php artisan db:seed

# Ou réinitialiser et réexécuter
php artisan migrate:fresh --seed
```

**Comptes de démonstration :**
- **Admin** : `admin@atelier404.com` / `password`
- **Techniciens** : `marie.dubois@atelier404.com` / `password`

---

## 🚀 Installation Rapide

### Prérequis
- PHP 8.2+
- Composer
- Node.js et npm
- SQLite/MySQL/PostgreSQL

### Installation
```bash
# Cloner le repository
git clone [url-du-repo]
cd ProjetGIT

# Installer les dépendances
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
touch database/database.sqlite  # Pour SQLite
php artisan migrate
php artisan db:seed
php artisan storage:link

# Build des assets
npm run build

# Lancer le serveur
php artisan serve
```

Accéder à l'application : `http://localhost:8000`

---

## 📋 Fonctionnalités

### 🏠 Page d'Accueil Publique
- Formulaire de contact avec validation
- Création automatique de client et intervention
- Design responsive et moderne

### 👥 Gestion des Utilisateurs
- **Authentification** : Laravel Breeze
- **Rôles** : Admin et Technicien
- **Permissions** : Gates/Policies pour la sécurité

### 👤 Gestion des Clients
- **CRUD complet** pour les clients
- **Recherche et filtrage** avancés
- **Historique** des interventions par client
- **Restrictions** : Seuls les admins peuvent gérer

### 🔧 Gestion des Interventions
- **CRUD complet** avec assignation aux techniciens
- **Statuts** : Nouvelle demande → Diagnostic → En réparation → Terminé → Non réparable
- **Priorités** : Basse, Moyenne, Haute, Urgente
- **Upload multiple** d'images avec thumbnails
- **Notes internes** pour les techniciens
- **Recherche et filtrage** avancés

### 📊 Tableaux de Bord
- **Admin** : Vue globale, statistiques, interventions non assignées
- **Technicien** : Interventions assignées uniquement
- **Export CSV** des interventions (admin)

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
