<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Intervention;
use App\Services\InterventionNotificationService;

class PublicController extends Controller
{
    function store(Request $request){

        // Validation des champs du formulaire public
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'device_type' => 'required|string|max:255',
        'problem_description' => 'required|string|max:1000',
    ]);

    // Création automatique du client (ou récupération s’il existe déjà)
    $client = Client::firstOrCreate(
        ['email' => $validated['email']], // clé unique
        [
            'name' => $validated['name'],
            'phone' => $validated['phone']
        ]
    );

    // Création automatique de l’intervention
    $intervention = Intervention::create([
        'client_id' => $client->id,
        'device_type' => $validated['device_type'],
        'description' => $validated['problem_description'],
        'status' => 'nouvelle_demande', // statut initial
        'priority' => 'medium',
    ]);

    InterventionNotificationService::notifyCreation($intervention);

    return redirect()->back()->with('success', 'Votre demande a été envoyée avec succès !');
}

    }
