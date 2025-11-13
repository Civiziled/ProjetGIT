<?php

namespace App\Mail;

use App\Models\Intervention;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterventionCreatedMail extends Mailable
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
            ->subject($this->getSubject())
            ->markdown('emails.interventions.created', [
                'intervention' => $this->intervention,
                'recipientType' => $this->recipientType,
                'actor' => $this->actor,
            ]);
    }

    protected function getSubject(): string
    {
        return match ($this->recipientType) {
            'client' => 'Nouvelle intervention créée',
            'technician' => 'Une nouvelle intervention vous concerne',
            'admin' => 'Nouvelle intervention enregistrée',
            default => 'Nouvelle intervention',
        };
    }
}


