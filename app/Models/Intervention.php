<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'assigned_technician_id',
        'description',
        'device_type',
        'priority',
        'status',
        'scheduled_date',
        'internal_notes',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
    ];

    /**
     * Relation avec le client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation avec le technicien assigné
     */
    public function assignedTechnician()
    {
        return $this->belongsTo(User::class, 'assigned_technician_id');
    }

    /**
     * Relation avec les images
     */
    public function images()
    {
        return $this->hasMany(InterventionImage::class);
    }

    /**
     * Vérifie si l'intervention est assignée
     */
    public function isAssigned(): bool
    {
        return !is_null($this->assigned_technician_id);
    }

    /**
     * Vérifie si l'intervention est terminée
     */
    public function isCompleted(): bool
    {
        return in_array($this->status, ['termine', 'non_reparable']);
    }

    /**
     * Scope pour les interventions assignées à un technicien
     */
    public function scopeAssignedTo($query, $technicianId)
    {
        return $query->where('assigned_technician_id', $technicianId);
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope pour filtrer par priorité
     */
    public function scopeWithPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }
}
