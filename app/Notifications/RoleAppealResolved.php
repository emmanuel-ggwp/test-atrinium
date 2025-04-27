<?php

namespace App\Notifications;

use App\Enums\RoleAppealStatusEnum;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class RoleAppealResolved extends Notification// implements ShouldQueue
{
    //use Queueable;

    public function __construct(
        public string $result,
        public array $roles,
        public ?User $assignedBy = null
    ) {
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->line('Your role appeal has been: ' . $this->result);

        if ($this->result == RoleAppealStatusEnum::STATUS_ACEPTED->value) {
            $mail->line('You have been assigned the roles: ' . implode(', ', $this->roles));
        }

        $mail
            ->action('Go to the system', url('/'))
            ->line('Thank you for using our application!');

        return $mail;
    }

    public function toDatabase($notifiable)
    {
        \Log::info('Notification stored in database');
        return [
            'roles' => $this->roles,
            'assigned_by' => $this->assignedBy?->id
        ];
    }
}