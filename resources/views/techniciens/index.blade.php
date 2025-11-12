@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Techniciens</h1>
                <p class="text-gray-600 mt-2">Gestion des techniciens de l'Atelier 404</p>
            </div>
            @can('create', App\Models\User::class)
                <a href="{{ route('techniciens.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Nouveau technicien
                </a>
            @endcan
        </div>
    </div>

    <!-- Recherche -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('techniciens.index') }}" class="flex space-x-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Rechercher par nom, email, téléphone ou spécialisation..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-300">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Liste des techniciens -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($techniciens->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($techniciens as $technicien)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $technicien->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $technicien->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('techniciens.show', $technicien) }}" class="text-blue-600 hover:text-blue-900">
                                            Voir
                                        </a>
                                        @can('update', $technicien)
                                            <a href="{{ route('techniciens.edit', $technicien) }}" class="text-green-600 hover:text-green-900">
                                                Modifier
                                            </a>
                                        @endcan
                                        @can('delete', $technicien)
                                            <form method="POST" action="{{ route('techniciens.destroy', $technicien) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce technicien ?')">
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
                {{ $techniciens->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun technicien</h3>
                <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouveau technicien.</p>
                @can('create', App\Models\Technicien::class)
                    <div class="mt-6">
                        <a href="{{ route('techniciens.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Nouveau technicien
                        </a>
                    </div>
                @endcan
            </div>
        @endif
    </div>
@endsection
