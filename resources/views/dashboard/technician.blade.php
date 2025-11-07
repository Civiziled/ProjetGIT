@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tableau de bord - Technicien</h1>
                <p class="text-gray-600 mt-1">Vos interventions et tâches en cours</p>
            </div>
        </div>
    </div>

    <!-- Statistiques du technicien -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Mes interventions</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['my_interventions'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">En cours</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['in_progress'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Terminées aujourd'hui</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['completed_today'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">En attente</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Mes interventions en cours -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <h3 class="text-base font-semibold text-gray-900">Mes interventions en cours</h3>
            </div>
            <div class="p-4">
                @if($myInterventions->count() > 0)
                    <div class="space-y-3">
                        @foreach($myInterventions as $intervention)
                            <div class="border rounded-lg p-3">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $intervention->client->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $intervention->device_type }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($intervention->priority === 'urgent') bg-red-100 text-red-800
                                            @elseif($intervention->priority === 'high') bg-orange-100 text-orange-800
                                            @elseif($intervention->priority === 'medium') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst($intervention->priority) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-3">{{ Str::limit($intervention->description, 150) }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($intervention->status === 'nouvelle_demande') bg-yellow-100 text-yellow-800
                                        @elseif($intervention->status === 'diagnostic') bg-blue-100 text-blue-800
                                        @elseif($intervention->status === 'en_reparation') bg-orange-100 text-orange-800
                                        @elseif($intervention->status === 'termine') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $intervention->status)) }}
                                    </span>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('interventions.show', $intervention) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                            Voir
                                        </a>
                                        <a href="{{ route('interventions.edit', $intervention) }}" class="text-green-600 hover:text-green-800 text-sm">
                                            Modifier
                                        </a>
                                    </div>
                                </div>
                                
                                @if($intervention->images->count() > 0)
                                    <div class="mt-3">
                                        <p class="text-xs text-gray-500">{{ $intervention->images->count() }} image(s) attachée(s)</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucune intervention en cours</p>
                @endif
            </div>
        </div>

        <!-- Interventions récemment terminées -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Récemment terminées</h3>
            </div>
            <div class="p-4">
                @if($recentCompleted->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentCompleted as $intervention)
                            <div class="flex justify-between items-center py-2 border-b last:border-b-0">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $intervention->client->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $intervention->device_type }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($intervention->status === 'termine') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $intervention->status)) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $intervention->updated_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucune intervention terminée récemment</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('interventions.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Voir toutes mes interventions
            </a>
            <a href="{{ route('interventions.index', ['status' => 'nouvelle_demande']) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-300">
                Nouvelles demandes
            </a>
            <a href="{{ route('interventions.index', ['status' => 'diagnostic']) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                En diagnostic
            </a>
            <a href="{{ route('interventions.index', ['status' => 'en_reparation']) }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition duration-300">
                En réparation
            </a>
        </div>
    </div>
@endsection
