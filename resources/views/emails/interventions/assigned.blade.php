@component('mail::message')
# Intervention assignée

@switch($recipientType)
    @case('technician')
        Bonjour {{ $intervention->assignedTechnician?->name ?? 'technicien' }},

        Vous venez d'être assigné·e à une intervention.
        @break

    @case('client')
        Bonjour {{ $intervention->client?->name ?? 'cher client' }},

        Un technicien a été assigné à votre intervention.
        @break

    @case('admin')
        Bonjour,

        Une intervention a été assignée à un technicien.
        @break
@endswitch

@component('mail::panel')
- Client : {{ $intervention->client?->name }}
- Technicien : {{ $intervention->assignedTechnician?->name }}
- Appareil : {{ $intervention->device_type }}
- Statut actuel : {{ ucfirst(str_replace('_', ' ', $intervention->status)) }}
- Priorité : {{ ucfirst($intervention->priority) }}
@endcomponent

@if($actor)
Assignation réalisée par : **{{ $actor->name }}** ({{ $actor->email }})
@endif

@component('mail::button', ['url' => route('interventions.show', $intervention)])
Voir l'intervention
@endcomponent

Merci,
L'équipe Atelier 404
@endcomponent

