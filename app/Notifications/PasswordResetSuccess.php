<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetSuccess extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Password Has Been Reset Successfully')
            ->markdown('emails.password_reset_success', [
                'user' => $notifiable,
                'loginUrl' => url('/login'),
            ]);
    }
}
