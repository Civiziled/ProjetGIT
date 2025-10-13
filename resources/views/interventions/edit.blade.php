@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Modifier l'intervention #{{ $intervention->id }}</h1>
                <p class="text-gray-600 mt-2">{{ $intervention->client->name }} - {{ $intervention->device_type }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('interventions.show', $intervention) }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                    Voir les détails
                </a>
                <a href="{{ route('interventions.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('interventions.update', $intervention) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de base</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Client *
                        </label>
                        <select id="client_id" name="client_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('client_id') border-red-500 @enderror" required>
                            <option value="">Sélectionnez un client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ (old('client_id', $intervention->client_id) == $client->id) ? 'selected' : '' }}>
                                    {{ $client->name }} ({{ $client->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="assigned_technician_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Technicien assigné
                        </label>
                        <select id="assigned_technician_id" name="assigned_technician_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('assigned_technician_id') border-red-500 @enderror">
                            <option value="">Non assigné</option>
                            @foreach($technicians as $technician)
                                <option value="{{ $technician->id }}" {{ (old('assigned_technician_id', $intervention->assigned_technician_id) == $technician->id) ? 'selected' : '' }}>
                                    {{ $technician->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('assigned_technician_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="device_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type d'appareil *
                    </label>
                    <input type="text" 
                           id="device_type" 
                           name="device_type" 
                           value="{{ old('device_type', $intervention->device_type) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('device_type') border-red-500 @enderror"
                           placeholder="Ex: Ordinateur portable, Smartphone, Tablette..."
                           required>
                    @error('device_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description du problème *
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                              placeholder="Décrivez en détail le problème rencontré..."
                              required>{{ old('description', $intervention->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Configuration</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                            Priorité *
                        </label>
                        <select id="priority" name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('priority') border-red-500 @enderror" required>
                            <option value="low" {{ old('priority', $intervention->priority) === 'low' ? 'selected' : '' }}>Faible</option>
                            <option value="medium" {{ old('priority', $intervention->priority) === 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="high" {{ old('priority', $intervention->priority) === 'high' ? 'selected' : '' }}>Élevée</option>
                            <option value="urgent" {{ old('priority', $intervention->priority) === 'urgent' ? 'selected' : '' }}>Urgente</option>
                        </select>
                        @error('priority')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Statut *
                        </label>
                        <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                            <option value="nouvelle_demande" {{ old('status', $intervention->status) === 'nouvelle_demande' ? 'selected' : '' }}>Nouvelle demande</option>
                            <option value="diagnostic" {{ old('status', $intervention->status) === 'diagnostic' ? 'selected' : '' }}>Diagnostic</option>
                            <option value="en_reparation" {{ old('status', $intervention->status) === 'en_reparation' ? 'selected' : '' }}>En réparation</option>
                            <option value="termine" {{ old('status', $intervention->status) === 'termine' ? 'selected' : '' }}>Terminé</option>
                            <option value="non_reparable" {{ old('status', $intervention->status) === 'non_reparable' ? 'selected' : '' }}>Non réparable</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="scheduled_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Date prévue
                    </label>
                    <input type="datetime-local" 
                           id="scheduled_date" 
                           name="scheduled_date" 
                           value="{{ old('scheduled_date', $intervention->scheduled_date ? $intervention->scheduled_date->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('scheduled_date') border-red-500 @enderror">
                    @error('scheduled_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notes et images</h3>
                
                <div class="mb-6">
                    <label for="internal_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Notes internes
                    </label>
                    <textarea id="internal_notes" 
                              name="internal_notes" 
                              rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('internal_notes') border-red-500 @enderror"
                              placeholder="Notes techniques, observations, etc. (non visibles au client)">{{ old('internal_notes', $intervention->internal_notes) }}</textarea>
                    @error('internal_notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Images existantes -->
                @if($intervention->images->count() > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Images actuelles ({{ $intervention->images->count() }})
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($intervention->images as $image)
                                <div class="relative group">
                                    <img src="{{ $image->url }}" alt="{{ $image->original_name }}" class="w-full h-24 object-cover rounded-lg">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                        <a href="{{ $image->url }}" target="_blank" class="text-white hover:text-blue-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                        Ajouter des images
                    </label>
                    <input type="file" 
                           id="images" 
                           name="images[]" 
                           multiple 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('images.*') border-red-500 @enderror">
                    <p class="text-sm text-gray-500 mt-1">Formats acceptés: JPG, PNG, GIF. Taille max: 5MB par fichier.</p>
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('interventions.show', $intervention) }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition duration-300">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
@endsection
