<?php

namespace App\Services;

use App\Mail\InterventionAssignedMail;
use App\Mail\InterventionCreatedMail;
use App\Mail\InterventionStatusUpdatedMail;
use App\Models\Intervention;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class InterventionNotificationService
{
    /**
     * Notification lors de la création d'une intervention.
     */
    public static function notifyCreation(Intervention $intervention, ?User $actor = null): void
    {
        $intervention->loadMissing(['client', 'assignedTechnician']);

        static::dispatchToRecipients(
            $intervention,
            fn () => new InterventionCreatedMail($intervention, 'client', $actor),
            'client'
        );

        static::dispatchToRecipients(
            $intervention,
            fn () => new InterventionCreatedMail($intervention, 'technician', $actor),
            'technician'
        );

        static::dispatchToRecipients(
            $intervention,
            fn () => new InterventionCreatedMail($intervention, 'admin', $actor),
            'admin'
        );
    }

    /**
     * Notification lors d'un changement de statut.
     */
    public static function notifyStatusChange(Intervention $intervention, string $previousStatus, ?User $actor = null): void
    {
        $intervention->loadMissing(['client', 'assignedTechnician']);

        static::dispatchToRecipients(
            $intervention,
            fn () => new InterventionStatusUpdatedMail($intervention, $previousStatus, 'client', $actor),
            'client'
        );

        static::dispatchToRecipients(
            $intervention,
            fn () => new InterventionStatusUpdatedMail($intervention, $previousStatus, 'technician', $actor),
            'technician'
        );

        static::dispatchToRecipients(
            $intervention,
            fn () => new InterventionStatusUpdatedMail($intervention, $previousStatus, 'admin', $actor),
            'admin'
        );
    }

    /**
     * Notification lors de l'assignation à un technicien.
     */
    public static function notifyAssignment(Intervention $intervention, ?User $actor = null): void
    {
        $intervention->loadMissing(['client', 'assignedTechnician']);

        static::dispatchToRecipients(
            $intervention,
            fn () => new InterventionAssignedMail($intervention, 'technician', $actor),
            'technician'
        );

        static::dispatchToRecipients(
            $intervention,
            fn () => new InterventionAssignedMail($intervention, 'client', $actor),
            'client'
        );

        static::dispatchToRecipients(
            $intervention,
            fn () => new InterventionAssignedMail($intervention, 'admin', $actor),
            'admin'
        );
    }

    /**
     * Prépare et envoie un mailable aux destinataires pertinents.
     */
    protected static function dispatchToRecipients(Intervention $intervention, callable $mailFactory, string $recipientType): void
    {
        $recipients = static::resolveRecipients($intervention, $recipientType);

        if ($recipients->isEmpty()) {
            return;
        }

        $recipients->unique()
            ->filter()
            ->each(function (string $email) use ($mailFactory) {
                Mail::to($email)->send($mailFactory());
            });
    }

    /**
     * Résout les destinataires selon le type.
     */
    protected static function resolveRecipients(Intervention $intervention, string $recipientType): Collection
    {
        return match ($recipientType) {
            'client' => collect([$intervention->client?->email])->filter(),
            'technician' => collect([$intervention->assignedTechnician?->email])->filter(),
            'admin' => User::where('role', 'admin')->pluck('email')->filter(),
            default => collect(),
        };
    }
}


