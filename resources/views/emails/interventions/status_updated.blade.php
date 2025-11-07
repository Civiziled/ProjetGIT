@component('mail::message')
# Statut mis à jour

@switch($recipientType)
    @case('client')
        Bonjour {{ $intervention->client?->name ?? 'cher client' }},

        Le statut de votre intervention a été mis à jour.
        @break

    @case('technician')
        Bonjour {{ $intervention->assignedTechnician?->name ?? 'technicien' }},

        Le statut d'une intervention dont vous êtes responsable a changé.
        @break

    @case('admin')
        Bonjour,

        Une intervention a changé de statut.
        @break
@endswitch

@component('mail::panel')
- Client : {{ $intervention->client?->name }}
- Appareil : {{ $intervention->device_type }}
- Statut précédent : {{ $previousStatusLabel }}
- Nouveau statut : {{ $currentStatusLabel }}
- Priorité : {{ ucfirst($intervention->priority) }}
@endcomponent

@if($actor)
Statut modifié par : **{{ $actor->name }}** ({{ $actor->email }})
@endif

@component('mail::button', ['url' => route('interventions.show', $intervention)])
Consulter l'intervention
@endcomponent

Merci,
L'équipe Atelier 404
@endcomponent

