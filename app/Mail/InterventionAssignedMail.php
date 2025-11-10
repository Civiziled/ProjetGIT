<?php

namespace App\Mail;

use App\Models\Intervention;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterventionAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Intervention $intervention,
        public string $recipientType,
        public ?User $actor = null
    ) {
        $this->intervention->loadMissing(['client', 'assignedTechnician']);
    }

    public function build(): self
    {
        return $this
            ->subject($this->buildSubject())
            ->markdown('emails.interventions.assigned', [
                'intervention' => $this->intervention,
                'recipientType' => $this->recipientType,
                'actor' => $this->actor,
            ]);
    }

    protected function buildSubject(): string
    {
        return match ($this->recipientType) {
            'technician' => 'Nouvelle intervention assignée',
            'client' => 'Technicien assigné à votre intervention',
            'admin' => 'Intervention assignée à un technicien',
            default => 'Intervention assignée',
        };
    }
}


