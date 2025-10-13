# Diagramme UML - Système de Gestion Atelier 404

## Diagramme de Classes

```mermaid
classDiagram
    class User {
        +id: int
        +name: string
        +email: string
        +email_verified_at: datetime
        +password: string
        +role: enum
        +remember_token: string
        +created_at: datetime
        +updated_at: datetime
        +isAdmin(): bool
        +isTechnician(): bool
        +assignedInterventions(): HasMany
    }

    class Client {
        +id: int
        +name: string
        +email: string
        +phone: string
        +address: string
        +created_at: datetime
        +updated_at: datetime
        +interventions(): HasMany
    }

    class Intervention {
        +id: int
        +client_id: int
        +assigned_technician_id: int
        +description: string
        +device_type: string
        +priority: enum
        +status: enum
        +scheduled_date: datetime
        +internal_notes: text
        +created_at: datetime
        +updated_at: datetime
        +client(): BelongsTo
        +assignedTechnician(): BelongsTo
        +images(): HasMany
    }

    class InterventionImage {
        +id: int
        +intervention_id: int
        +filename: string
        +original_name: string
        +path: string
        +size: int
        +mime_type: string
        +created_at: datetime
        +updated_at: datetime
        +intervention(): BelongsTo
    }

    class Role {
        <<enumeration>>
        ADMIN
        TECHNICIAN
    }

    class InterventionStatus {
        <<enumeration>>
        NOUVELLE_DEMANDE
        DIAGNOSTIC
        EN_REPARATION
        TERMINE
        NON_REPARABLE
    }

    class Priority {
        <<enumeration>>
        LOW
        MEDIUM
        HIGH
        URGENT
    }

    %% Relations
    User ||--o{ Intervention : "assigned_technician_id"
    Client ||--o{ Intervention : "client_id"
    Intervention ||--o{ InterventionImage : "intervention_id"
    
    %% Enums
    User --> Role : "role"
    Intervention --> InterventionStatus : "status"
    Intervention --> Priority : "priority"
```

## Enums

### Role
- `admin` : Administrateur avec tous les droits
- `technicien` : Technicien avec droits limités

### InterventionStatus
- `nouvelle_demande` : Nouvelle demande reçue
- `diagnostic` : En cours de diagnostic
- `en_reparation` : En cours de réparation
- `termine` : Réparation terminée avec succès
- `non_reparable` : Non réparable

### Priority
- `low` : Priorité faible
- `medium` : Priorité moyenne
- `high` : Priorité élevée
- `urgent` : Priorité urgente

## Relations

1. **User → Intervention** (1:N)
   - Un utilisateur peut être assigné à plusieurs interventions
   - Une intervention est assignée à un seul technicien

2. **Client → Intervention** (1:N)
   - Un client peut avoir plusieurs interventions
   - Une intervention appartient à un seul client

3. **Intervention → InterventionImage** (1:N)
   - Une intervention peut avoir plusieurs images
   - Une image appartient à une seule intervention

## Contraintes Métier

- Seuls les admins peuvent créer/modifier/supprimer des clients
- Les techniciens ne voient que leurs interventions assignées
- Seul l'admin peut réassigner une intervention
- Le formulaire public crée automatiquement client + intervention
- Upload d'images limité à 5MB par fichier
- Types d'images autorisés : jpg, jpeg, png, gif
