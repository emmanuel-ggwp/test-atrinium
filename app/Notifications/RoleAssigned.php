<?php
namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class RoleAssigned extends Notification// implements ShouldQueue
{
    //use Queueable;

    public function __construct(
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
        \Log::info('Enviando correo RoleAssigned');
        return (new MailMessage)
            ->line('You have been assigned the roles: ' . implode(', ',$this->roles))
            ->action('Go to the system', url('/'))
            ->line('Thank you for using our application!');
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