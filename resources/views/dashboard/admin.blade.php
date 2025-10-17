@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tableau de bord - Administrateur</h1>
                <p class="text-gray-600 mt-1">Vue d'ensemble des interventions et statistiques</p>
            </div>
        </div>
    </div>

    <!-- Statistiques générales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Total interventions</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['total_interventions'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Nouvelles demandes</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['new_requests'] }}</p>
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
                    <p class="text-xs font-medium text-gray-600">Terminées</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['completed'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Total clients</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['total_clients'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Techniciens</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['total_technicians'] }}</p>
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
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
        <!-- Interventions non assignées -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <h3 class="text-base font-semibold text-gray-900">Interventions non assignées</h3>
            </div>
            <div class="p-4">
                @if($unassignedInterventions->count() > 0)
                    <div class="space-y-3">
                        @foreach($unassignedInterventions as $intervention)
                            <div class="border rounded-lg p-3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $intervention->client->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $intervention->device_type }}</p>
                                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($intervention->description, 100) }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $intervention->priority }}
                                    </span>
                                </div>
                                <div class="mt-3 flex space-x-2">
                                    <a href="{{ route('interventions.show', $intervention) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                        Voir détails
                                    </a>
                                    <a href="{{ route('interventions.edit', $intervention) }}" class="text-green-600 hover:text-green-800 text-sm">
                                        Assigner
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucune intervention non assignée</p>
                @endif
            </div>
        </div>

        <!-- Interventions récentes -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Interventions récentes</h3>
            </div>
            <div class="p-4">
                @if($recentInterventions->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentInterventions as $intervention)
                            <div class="flex justify-between items-center py-2 border-b last:border-b-0">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $intervention->client->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $intervention->device_type }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($intervention->status === 'nouvelle_demande') bg-yellow-100 text-yellow-800
                                        @elseif($intervention->status === 'diagnostic') bg-blue-100 text-blue-800
                                        @elseif($intervention->status === 'en_reparation') bg-orange-100 text-orange-800
                                        @elseif($intervention->status === 'termine') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $intervention->status)) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $intervention->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucune intervention récente</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('interventions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Nouvelle intervention
            </a>
            <a href="{{ route('clients.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                Nouveau client
            </a>
            <a href="{{ route('interventions.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                Voir toutes les interventions
            </a>
            <a href="{{ route('admin.export') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-300">
                Exporter CSV
            </a>
        </div>
    </div>
@endsection
