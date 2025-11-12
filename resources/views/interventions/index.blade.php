@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Interventions</h1>
                <p class="text-gray-600 mt-2">Gestion des interventions de réparation</p>
            </div>
            @can('create', App\Models\Intervention::class)
                <a href="{{ route('interventions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Nouvelle intervention
                </a>
            @endcan
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('interventions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Client, description, type d'appareil..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les statuts</option>
                    <option value="nouvelle_demande" {{ request('status') === 'nouvelle_demande' ? 'selected' : '' }}>Nouvelle demande</option>
                    <option value="diagnostic" {{ request('status') === 'diagnostic' ? 'selected' : '' }}>Diagnostic</option>
                    <option value="en_reparation" {{ request('status') === 'en_reparation' ? 'selected' : '' }}>En réparation</option>
                    <option value="termine" {{ request('status') === 'termine' ? 'selected' : '' }}>Terminé</option>
                    <option value="non_reparable" {{ request('status') === 'non_reparable' ? 'selected' : '' }}>Non réparable</option>
                </select>
            </div>

            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priorité</label>
                <select id="priority" name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Toutes les priorités</option>
                    <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Élevée</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Moyenne</option>
                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Faible</option>
                </select>
            </div>

            @if(auth()->user()->isAdmin())
                <div>
                    <label for="technician" class="block text-sm font-medium text-gray-700 mb-2">Technicien</label>
                    <select id="technician" name="technician" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les techniciens</option>
                        @foreach($technicians as $technician)
                            <option value="{{ $technician->id }}" {{ request('technician') == $technician->id ? 'selected' : '' }}>
                                {{ $technician->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="flex items-end">
                <button type="submit" class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des interventions -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($interventions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appareil</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priorité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technicien</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($interventions as $intervention)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $intervention->client->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $intervention->client->email }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $intervention->device_type }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($intervention->description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($intervention->status === 'nouvelle_demande') bg-yellow-100 text-yellow-800
                                        @elseif($intervention->status === 'diagnostic') bg-blue-100 text-blue-800
                                        @elseif($intervention->status === 'en_reparation') bg-orange-100 text-orange-800
                                        @elseif($intervention->status === 'termine') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $intervention->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($intervention->priority === 'urgent') bg-red-100 text-red-800
                                        @elseif($intervention->priority === 'high') bg-orange-100 text-orange-800
                                        @elseif($intervention->priority === 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($intervention->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $intervention->assignedTechnician ? $intervention->assignedTechnician->name : 'Non assigné' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $intervention->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <!--<a href="{{ route('interventions.show', $intervention) }}" class="text-blue-600 hover:text-blue-900">
                                            Voir
                                        </a>-->
                                         <a href="{{ route('interventions.show', ['intervention' => $intervention->id, 'from' => 'interventions']) }}" class="text-blue-600 hover:text-blue-900">
                                            Voir
                                        </a>

                                        @can('update', $intervention)
                                            <a href="{{ route('interventions.edit', $intervention) }}" class="text-green-600 hover:text-green-900">
                                                Modifier
                                            </a>
                                        @endcan
                                        @can('delete', $intervention)
                                            <form method="POST" action="{{ route('interventions.destroy', $intervention) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette intervention ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Supprimer
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $interventions->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune intervention</h3>
                <p class="mt-1 text-sm text-gray-500">Commencez par créer une nouvelle intervention.</p>
                @can('create', App\Models\Intervention::class)
                    <div class="mt-6">
                        <a href="{{ route('interventions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Nouvelle intervention
                        </a>
                    </div>
                @endcan
            </div>
        @endif
    </div>
@endsection
