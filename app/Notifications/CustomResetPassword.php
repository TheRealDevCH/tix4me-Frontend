<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPasswordBase
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $resetUrl = $this->getResetUrl($notifiable);

        return (new MailMessage)
            ->subject('Passwort zurücksetzen - Tix4me')
            ->view('emails.reset-password', [
                'user' => $notifiable,
                'resetUrl' => $resetUrl,
                'token' => $this->token,
            ]);
    }

    /**
     * Get the password reset URL.
     */
    protected function getResetUrl($notifiable): string
    {
        $frontendUrl = config('app.frontend_url', 'http://localhost:8000');
        
        return $frontendUrl . '/reset-password/' . $this->token . '?email=' . urlencode($notifiable->getEmailForPasswordReset());
    }
}

