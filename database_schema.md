# Schéma de Base de Données - Atelier 404

## Tables Principales

### 1. users (étendue)
- id (primary key)
- name
- email (unique)
- email_verified_at
- password
- role (enum: 'admin', 'technicien')
- remember_token
- created_at
- updated_at

### 2. clients
- id (primary key)
- name
- email
- phone
- address (nullable)
- created_at
- updated_at

### 3. interventions
- id (primary key)
- client_id (foreign key -> clients.id)
- assigned_technician_id (foreign key -> users.id, nullable)
- description
- device_type
- priority (enum: 'low', 'medium', 'high', 'urgent')
- status (enum: 'nouvelle_demande', 'diagnostic', 'en_reparation', 'termine', 'non_reparable')
- scheduled_date (nullable)
- internal_notes (text, nullable)
- created_at
- updated_at

### 4. intervention_images
- id (primary key)
- intervention_id (foreign key -> interventions.id)
- filename
- original_name
- path
- size
- mime_type
- created_at
- updated_at

## Relations

- User (1) -> (N) Intervention (assigned_technician_id)
- Client (1) -> (N) Intervention (client_id)
- Intervention (1) -> (N) InterventionImage (intervention_id)

## Énumérations

### Rôles utilisateur
- admin
- technicien

### Statuts d'intervention
- nouvelle_demande
- diagnostic
- en_reparation
- termine
- non_reparable

### Priorités
- low
- medium
- high
- urgent

