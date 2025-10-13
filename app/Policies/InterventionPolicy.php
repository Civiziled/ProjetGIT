<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Intervention;
use Illuminate\Auth\Access\HandlesAuthorization;

class InterventionPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir n'importe quelle intervention
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isTechnician();
    }

    /**
     * Détermine si l'utilisateur peut voir l'intervention
     */
    public function view(User $user, Intervention $intervention)
    {
        // Admin peut voir toutes les interventions
        if ($user->isAdmin()) {
            return true;
        }

        // Technicien ne peut voir que ses interventions assignées
        if ($user->isTechnician()) {
            return $intervention->assigned_technician_id === $user->id;
        }

        return false;
    }

    /**
     * Détermine si l'utilisateur peut créer des interventions
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour l'intervention
     */
    public function update(User $user, Intervention $intervention)
    {
        // Admin peut modifier toutes les interventions
        if ($user->isAdmin()) {
            return true;
        }

        // Technicien ne peut modifier que ses interventions assignées
        if ($user->isTechnician()) {
            return $intervention->assigned_technician_id === $user->id;
        }

        return false;
    }

    /**
     * Détermine si l'utilisateur peut supprimer l'intervention
     */
    public function delete(User $user, Intervention $intervention)
    {
        return $user->isAdmin();
    }

    /**
     * Détermine si l'utilisateur peut assigner l'intervention
     */
    public function assign(User $user, Intervention $intervention)
    {
        return $user->isAdmin();
    }
}
