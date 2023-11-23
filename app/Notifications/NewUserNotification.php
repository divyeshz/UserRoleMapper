<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user;
    protected $adminEmail;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $adminEmail)
    {
        $this->user = $user;
        $this->adminEmail = $adminEmail;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Activate New User Account')
            ->line('A new user account needs activation.')
            ->line('User: ' . $this->user->first_name .' '. $this->user->last_name)
            ->action('Activate User', route('activate.user', $this->user->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
