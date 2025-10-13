<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir n'importe quel client
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isTechnician();
    }

    /**
     * Détermine si l'utilisateur peut voir le client
     */
    public function view(User $user, Client $client)
    {
        return $user->isAdmin() || $user->isTechnician();
    }

    /**
     * Détermine si l'utilisateur peut créer des clients
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour le client
     */
    public function update(User $user, Client $client)
    {
        return $user->isAdmin();
    }

    /**
     * Détermine si l'utilisateur peut supprimer le client
     */
    public function delete(User $user, Client $client)
    {
        return $user->isAdmin();
    }
}
