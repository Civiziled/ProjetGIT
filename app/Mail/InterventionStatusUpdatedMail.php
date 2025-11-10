<?php

namespace App\Mail;

use App\Models\Intervention;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterventionStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Intervention $intervention,
        public string $previousStatus,
        public string $recipientType,
        public ?User $actor = null
    ) {
        $this->intervention->loadMissing(['client', 'assignedTechnician']);
    }

    public function build(): self
    {
        return $this
            ->subject($this->buildSubject())
            ->markdown('emails.interventions.status_updated', [
                'intervention' => $this->intervention,
                'previousStatusLabel' => $this->statusLabel($this->previousStatus),
                'currentStatusLabel' => $this->statusLabel($this->intervention->status),
                'recipientType' => $this->recipientType,
                'actor' => $this->actor,
            ]);
    }

    protected function buildSubject(): string
    {
        return match ($this->recipientType) {
            'client' => 'Mise à jour de votre intervention',
            'technician' => 'Statut d\'une intervention mis à jour',
            'admin' => 'Intervention mise à jour',
            default => 'Statut d\'intervention mis à jour',
        };
    }

    protected function statusLabel(string $status): string
    {
        return match ($status) {
            'nouvelle_demande' => 'Nouvelle demande',
            'diagnostic' => 'Diagnostic',
            'en_reparation' => 'En réparation',
            'termine' => 'Terminé',
            'non_reparable' => 'Non réparable',
            default => ucfirst(str_replace('_', ' ', $status)),
        };
    }
}


