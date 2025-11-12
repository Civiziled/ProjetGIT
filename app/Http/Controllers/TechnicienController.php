<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class TechnicienController extends Controller
{
   /*public function index()
{
    Gate::authorize('viewAny', User::class);
    $techniciens = User::where('role', 'technicien')->paginate(10);
    return view('techniciens.index', compact('techniciens'));
}*/

/**
     * Список всех техников
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', User::class);

        $query = User::where('role', 'technicien');

        // Поиск
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $techniciens = $query->orderBy('name')->paginate(15);

        return view('techniciens.index', compact('techniciens'));
    }

    /**
     * Форма создания нового техника
     */
    public function create()
    {
        Gate::authorize('create', User::class);

        return view('techniciens.create');
    }

    /**
     * Сохранение нового техника
     */
    public function store(Request $request)
    {
        Gate::authorize('create', User::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $validated['role'] = 'technicien';
        $validated['password'] = bcrypt('password123'); // временный пароль

        $technicien = User::create($validated);

        return redirect()->route('techniciens.show', $technicien)
                         ->with('success', 'Technicien créé avec succès.');
    }

    /**
     * Просмотр деталей техника
     */
    public function show(User $technicien)
    {
        Gate::authorize('view', $technicien);

        // Можно добавить загрузку связанных данных, если есть, например interventions
        $technicien->load('interventions');

        return view('techniciens.show', compact('technicien'));
    }

    /**
     * Форма редактирования техника
     */
    public function edit(User $technicien)
    {
        Gate::authorize('update', $technicien);

        return view('techniciens.edit', compact('technicien'));
    }

    /**
     * Обновление техника
     */
    public function update(Request $request, User $technicien)
    {
        Gate::authorize('update', $technicien);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $technicien->id,
        
        ]);

        $technicien->update($validated);

        return redirect()->route('techniciens.show', $technicien)
                         ->with('success', 'Technicien mis à jour avec succès.');
    }

    /**
     * Удаление техника
     */
    public function destroy(User $technicien)
    {
        Gate::authorize('delete', $technicien);

        // Можно добавить проверку на связанные данные, например interventions
        // if ($technicien->interventions()->count() > 0) {
        //     return redirect()->back()->with('error', 'Impossible de supprimer ce technicien car il a des interventions associées.');
        // }

        $technicien->delete();

        return redirect()->route('techniciens.index')
                         ->with('success', 'Technicien supprimé avec succès.');
    }
   
}
