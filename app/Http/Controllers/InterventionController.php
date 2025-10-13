<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Client;
use App\Models\User;
use App\Models\InterventionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Intervention::with(['client', 'assignedTechnician', 'images']);

        // Filtrage selon le rôle
        if (Auth::user()->isTechnician()) {
            $query->assignedTo(Auth::id());
        }

        // Filtres de recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('device_type', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->withStatus($request->status);
        }

        if ($request->filled('priority')) {
            $query->withPriority($request->priority);
        }

        if ($request->filled('technician')) {
            $query->where('assigned_technician_id', $request->technician);
        }

        $interventions = $query->orderBy('created_at', 'desc')->paginate(15);

        $technicians = User::where('role', 'technicien')->get();
        
        return view('interventions.index', compact('interventions', 'technicians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Intervention::class);
        
        $clients = Client::orderBy('name')->get();
        $technicians = User::where('role', 'technicien')->get();
        
        return view('interventions.create', compact('clients', 'technicians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Intervention::class);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'assigned_technician_id' => 'nullable|exists:users,id',
            'description' => 'required|string|max:1000',
            'device_type' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:nouvelle_demande,diagnostic,en_reparation,termine,non_reparable',
            'scheduled_date' => 'nullable|date|after:now',
            'internal_notes' => 'nullable|string|max:2000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $intervention = Intervention::create($validated);

        // Gestion des images
        if ($request->hasFile('images')) {
            $this->handleImageUpload($request->file('images'), $intervention);
        }

        return redirect()->route('interventions.show', $intervention)
                        ->with('success', 'Intervention créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Intervention $intervention)
    {
        Gate::authorize('view', $intervention);
        
        $intervention->load(['client', 'assignedTechnician', 'images']);
        
        return view('interventions.show', compact('intervention'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Intervention $intervention)
    {
        Gate::authorize('update', $intervention);
        
        $clients = Client::orderBy('name')->get();
        $technicians = User::where('role', 'technicien')->get();
        
        return view('interventions.edit', compact('intervention', 'clients', 'technicians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intervention $intervention)
    {
        Gate::authorize('update', $intervention);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'assigned_technician_id' => 'nullable|exists:users,id',
            'description' => 'required|string|max:1000',
            'device_type' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:nouvelle_demande,diagnostic,en_reparation,termine,non_reparable',
            'scheduled_date' => 'nullable|date',
            'internal_notes' => 'nullable|string|max:2000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $intervention->update($validated);

        // Gestion des nouvelles images
        if ($request->hasFile('images')) {
            $this->handleImageUpload($request->file('images'), $intervention);
        }

        return redirect()->route('interventions.show', $intervention)
                        ->with('success', 'Intervention mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intervention $intervention)
    {
        Gate::authorize('delete', $intervention);

        // Supprimer les images associées
        foreach ($intervention->images as $image) {
            Storage::disk('public')->delete($image->path);
            $thumbnailPath = dirname($image->path) . '/thumbnails/' . pathinfo($image->filename, PATHINFO_FILENAME) . '_thumb.' . pathinfo($image->filename, PATHINFO_EXTENSION);
            Storage::disk('public')->delete($thumbnailPath);
        }

        $intervention->delete();

        return redirect()->route('interventions.index')
                        ->with('success', 'Intervention supprimée avec succès.');
    }

    /**
     * Assigner une intervention à un technicien
     */
    public function assign(Request $request, Intervention $intervention)
    {
        Gate::authorize('assign', $intervention);

        $validated = $request->validate([
            'assigned_technician_id' => 'required|exists:users,id'
        ]);

        $intervention->update($validated);

        return redirect()->route('interventions.show', $intervention)
                        ->with('success', 'Intervention assignée avec succès.');
    }

    /**
     * Mettre à jour le statut d'une intervention
     */
    public function updateStatus(Request $request, Intervention $intervention)
    {
        Gate::authorize('update', $intervention);

        $validated = $request->validate([
            'status' => 'required|in:nouvelle_demande,diagnostic,en_reparation,termine,non_reparable'
        ]);

        $intervention->update($validated);

        return redirect()->route('interventions.show', $intervention)
                        ->with('success', 'Statut mis à jour avec succès.');
    }

    /**
     * Supprimer une image d'intervention
     */
    public function deleteImage(InterventionImage $image)
    {
        Gate::authorize('delete', $image->intervention);

        // Supprimer le fichier et le thumbnail
        Storage::disk('public')->delete($image->path);
        $thumbnailPath = dirname($image->path) . '/thumbnails/' . pathinfo($image->filename, PATHINFO_FILENAME) . '_thumb.' . pathinfo($image->filename, PATHINFO_EXTENSION);
        Storage::disk('public')->delete($thumbnailPath);

        $image->delete();

        return redirect()->back()->with('success', 'Image supprimée avec succès.');
    }

    /**
     * Gérer l'upload des images
     */
    private function handleImageUpload(array $images, Intervention $intervention)
    {
        foreach ($images as $image) {
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('interventions/' . $intervention->id, $filename, 'public');

            InterventionImage::create([
                'intervention_id' => $intervention->id,
                'filename' => $filename,
                'original_name' => $image->getClientOriginalName(),
                'path' => $path,
                'size' => $image->getSize(),
                'mime_type' => $image->getMimeType(),
            ]);

            // Créer un thumbnail
            $this->createThumbnail($image, $path);
        }
    }

    /**
     * Créer un thumbnail pour l'image
     */
    private function createThumbnail($image, $path)
    {
        $thumbnailPath = dirname($path) . '/thumbnails/' . pathinfo($path, PATHINFO_FILENAME) . '_thumb.' . pathinfo($path, PATHINFO_EXTENSION);
        
        // Créer le dossier thumbnails s'il n'existe pas
        Storage::disk('public')->makeDirectory(dirname($thumbnailPath));

        // Redimensionner l'image (150x150)
        $img = \Intervention\Image\Facades\Image::make($image);
        $img->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        Storage::disk('public')->put($thumbnailPath, $img->encode());
    }
}
