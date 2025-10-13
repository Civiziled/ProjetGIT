@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Nouvelle intervention</h1>
                <p class="text-gray-600 mt-2">Créer une nouvelle intervention de réparation</p>
            </div>
            <a href="{{ route('interventions.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('interventions.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de base</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Client *
                        </label>
                        <select id="client_id" name="client_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('client_id') border-red-500 @enderror" required>
                            <option value="">Sélectionnez un client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
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
                                <option value="{{ $technician->id }}" {{ old('assigned_technician_id') == $technician->id ? 'selected' : '' }}>
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
                           value="{{ old('device_type') }}"
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
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Configuration</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                            Priorité *
                        </label>
                        <select id="priority" name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('priority') border-red-500 @enderror" required>
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Faible</option>
                            <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>Élevée</option>
                            <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgente</option>
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
                            <option value="nouvelle_demande" {{ old('status') === 'nouvelle_demande' ? 'selected' : '' }}>Nouvelle demande</option>
                            <option value="diagnostic" {{ old('status') === 'diagnostic' ? 'selected' : '' }}>Diagnostic</option>
                            <option value="en_reparation" {{ old('status') === 'en_reparation' ? 'selected' : '' }}>En réparation</option>
                            <option value="termine" {{ old('status') === 'termine' ? 'selected' : '' }}>Terminé</option>
                            <option value="non_reparable" {{ old('status') === 'non_reparable' ? 'selected' : '' }}>Non réparable</option>
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
                           value="{{ old('scheduled_date') }}"
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
                              placeholder="Notes techniques, observations, etc. (non visibles au client)">{{ old('internal_notes') }}</textarea>
                    @error('internal_notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                        Images (optionnel)
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
                <a href="{{ route('interventions.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition duration-300">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Créer l'intervention
                </button>
            </div>
        </form>
    </div>
@endsection
