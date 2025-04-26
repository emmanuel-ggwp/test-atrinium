<?php
// app/Notifications/RoleAssignedNotification.php
namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class RoleAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public array $roles,
        public ?User $assignedBy = null
    ) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        
        return (new MailMessage)
            ->line('You have been assigned the roles: ' . $this->roles)
            ->action('Go to the system', url('/'))
            ->line('Thank you for using our application!');
    }
}