@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $client->name }}</h1>
                <p class="text-gray-600 mt-2">Profil client et historique des interventions</p>
            </div>
            <div class="flex space-x-3">
                @can('update', $client)
                    <a href="{{ route('clients.edit', $client) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                        Modifier
                    </a>
                @endcan
                <a href="{{ route('clients.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Informations client -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations client</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $client->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $client->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $client->phone }}</p>
                    </div>
                    
                    @if($client->address)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Adresse</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $client->address }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Client depuis</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $client->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Total interventions</span>
                        <span class="text-sm font-bold text-gray-900">{{ $client->interventions->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historique des interventions -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Historique des interventions</h3>
                </div>
                
                <div class="p-6">
                    @if($client->interventions->count() > 0)
                        <div class="space-y-4">
                            @foreach($client->interventions as $intervention)
                                <div class="border rounded-lg p-4 hover:bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <h4 class="text-sm font-medium text-gray-900">#{{ $intervention->id }}</h4>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($intervention->status === 'nouvelle_demande') bg-yellow-100 text-yellow-800
                                                    @elseif($intervention->status === 'diagnostic') bg-blue-100 text-blue-800
                                                    @elseif($intervention->status === 'en_reparation') bg-orange-100 text-orange-800
                                                    @elseif($intervention->status === 'termine') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $intervention->status)) }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($intervention->priority === 'urgent') bg-red-100 text-red-800
                                                    @elseif($intervention->priority === 'high') bg-orange-100 text-orange-800
                                                    @elseif($intervention->priority === 'medium') bg-yellow-100 text-yellow-800
                                                    @else bg-green-100 text-green-800 @endif">
                                                    {{ ucfirst($intervention->priority) }}
                                                </span>
                                            </div>
                                            
                                            <p class="text-sm text-gray-600 mt-1">{{ $intervention->device_type }}</p>
                                            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($intervention->description, 100) }}</p>
                                            
                                            <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500">
                                                <span>Créée le {{ $intervention->created_at->format('d/m/Y') }}</span>
                                                @if($intervention->assignedTechnician)
                                                    <span>• Assignée à {{ $intervention->assignedTechnician->name }}</span>
                                                @endif
                                                @if($intervention->images->count() > 0)
                                                    <span>• {{ $intervention->images->count() }} image(s)</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="ml-4">
                                            <a href="{{ route('interventions.show', $intervention) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                Voir détails
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune intervention</h3>
                            <p class="mt-1 text-sm text-gray-500">Ce client n'a pas encore d'interventions.</p>
                            @can('create', App\Models\Intervention::class)
                                <div class="mt-6">
                                    <a href="{{ route('interventions.create', ['client_id' => $client->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        Créer une intervention
                                    </a>
                                </div>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
