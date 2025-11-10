@component('mail::message')
# Intervention créée

@switch($recipientType)
    @case('client')
        Bonjour {{ $intervention->client?->name ?? 'cher client' }},

        Votre demande concernant l'appareil « {{ $intervention->device_type }} » a bien été enregistrée. Nous vous tiendrons informé·e des prochaines étapes.
        @break

    @case('technician')
        Bonjour {{ $intervention->assignedTechnician?->name ?? 'technicien' }},

        Une nouvelle intervention vient d'être créée et pourrait nécessiter votre attention.
        @break

    @case('admin')
        Bonjour,

        Une nouvelle intervention a été créée dans l'outil.
        @break
@endswitch

@component('mail::panel')
- Client : {{ $intervention->client?->name }}
- Appareil : {{ $intervention->device_type }}
- Priorité : {{ ucfirst($intervention->priority) }}
- Statut : {{ ucfirst(str_replace('_', ' ', $intervention->status)) }}
- Description : {{ $intervention->description }}
@endcomponent

@if($actor)
Action réalisée par : **{{ $actor->name }}** ({{ $actor->email }})
@endif

@component('mail::button', ['url' => route('interventions.show', $intervention)])
Voir l'intervention
@endcomponent

Merci,
L'équipe Atelier 404
@endcomponent

