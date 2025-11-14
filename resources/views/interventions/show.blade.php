@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Intervention #{{ $intervention->id }}</h1>
                <p class="text-gray-600 mt-2">{{ $intervention->client->name }} - {{ $intervention->device_type }}</p>
            </div>
            <div class="flex space-x-3">
                @can('update', $intervention)
                    <a href="{{ route('interventions.edit', $intervention) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300 w-70 h-10 mt-8">
                        Modifier
                    </a>
                @endcan
                <!--<a href="{{route('interventions.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                    Retour à la liste
                </a>-->
                <div class="mt-8 flex items-center justify-center">
    @if ($from === 'technicien')
        <a href="{{ route('techniciens.show', $intervention->assignedTechnician->id) }}"
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
           Retour au profil du technicien
        </a>
    @else
        <a href="{{ route('interventions.index') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-300 ">
           Retour à la liste des interventions
        </a>
    @endif
</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Détails de l'intervention -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails de l'intervention</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statut</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($intervention->status === 'nouvelle_demande') bg-yellow-100 text-yellow-800
                                @elseif($intervention->status === 'diagnostic') bg-blue-100 text-blue-800
                                @elseif($intervention->status === 'en_reparation') bg-orange-100 text-orange-800
                                @elseif($intervention->status === 'termine') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $intervention->status)) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Priorité</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($intervention->priority === 'urgent') bg-red-100 text-red-800
                                @elseif($intervention->priority === 'high') bg-orange-100 text-orange-800
                                @elseif($intervention->priority === 'medium') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($intervention->priority) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type d'appareil</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $intervention->device_type }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date prévue</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $intervention->scheduled_date ? $intervention->scheduled_date->format('d/m/Y H:i') : 'Non définie' }}
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">Description du problème</label>
                    <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $intervention->description }}</p>
                </div>

                @if($intervention->internal_notes)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700">Notes internes</label>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $intervention->internal_notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Historique des modifications -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Historique des modifications</h3>

                @php
                    $history = DB::table('intervention_history')
                        ->where('intervention_id', $intervention->id)
                        ->orderByDesc('date_modification')
                        ->get();
                @endphp
                                                    
                @if($history->isEmpty())
                    <p class="text-sm text-gray-500">Aucune modification enregistrée pour cette intervention.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($history as $event)
                            <li class="py-2">
                                <p class="text-sm text-gray-900">
                                    <strong>{{ $event->utilisateur }}</strong> — {{ $event->action }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($event->date_modification)->format('d/m/Y H:i') }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Images -->
            @if($intervention->images->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Images ({{ $intervention->images->count() }})</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($intervention->images as $image)
                            <div class="relative group">
                                <img src="{{ $image->url }}" alt="{{ $image->original_name }}" class="w-full h-32 object-cover rounded-lg">
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                    <div class="flex space-x-2">
                                        <a href="{{ $image->url }}" target="_blank" class="text-white hover:text-blue-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        @can('delete', $intervention)
                                            <form method="POST" action="{{ route('intervention-images.delete', $image) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white hover:text-red-300">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Informations client et technicien -->
        <div class="space-y-6">
            <!-- Informations client -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Client</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $intervention->client->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $intervention->client->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $intervention->client->phone }}</p>
                    </div>
                    @if($intervention->client->address)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Adresse</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $intervention->client->address }}</p>
                        </div>
                    @endif
                </div>
                <div class="mt-4">
                    <a href="{{ route('clients.show', $intervention->client) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        Voir le profil client →
                    </a>
                </div>
            </div>

            <!-- Technicien assigné -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Technicien assigné</h3>
                @if($intervention->assignedTechnician)
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $intervention->assignedTechnician->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $intervention->assignedTechnician->email }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-500">Aucun technicien assigné</p>
                    @can('assign', $intervention)
                        <div class="mt-4">
                            <a href="{{ route('interventions.edit', $intervention) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Assigner un technicien →
                            </a>
                        </div>
                    @endcan
                @endif
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
                <div class="space-y-3">
                    @can('update', $intervention)
                        <!-- Changement de statut -->
                        <form method="POST" action="{{ route('interventions.status', $intervention) }}">
                            @csrf
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Changer le statut</label>
                                <div class="flex space-x-2">
                                    <select name="status" id="status" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="nouvelle_demande" {{ $intervention->status === 'nouvelle_demande' ? 'selected' : '' }}>Nouvelle demande</option>
                                        <option value="diagnostic" {{ $intervention->status === 'diagnostic' ? 'selected' : '' }}>Diagnostic</option>
                                        <option value="en_reparation" {{ $intervention->status === 'en_reparation' ? 'selected' : '' }}>En réparation</option>
                                        <option value="termine" {{ $intervention->status === 'termine' ? 'selected' : '' }}>Terminé</option>
                                        <option value="non_reparable" {{ $intervention->status === 'non_reparable' ? 'selected' : '' }}>Non réparable</option>
                                    </select>
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                        Mettre à jour
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endcan

                    @if($intervention->assignedTechnician && $intervention->assigned_technician_id === auth()->id())
                        <div class="pt-4 border-t">
                            <p class="text-sm text-gray-600 mb-2">Vous êtes assigné à cette intervention</p>
                            <a href="{{ route('interventions.edit', $intervention) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Ajouter des notes ou images →
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Créée le:</span> {{ $intervention->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div>
                        <span class="font-medium">Modifiée le:</span> {{ $intervention->updated_at->format('d/m/Y H:i') }}
                    </div>
                    @if($intervention->scheduled_date)
                        <div>
                            <span class="font-medium">Date prévue:</span> {{ $intervention->scheduled_date->format('d/m/Y H:i') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
