<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $senderName,
        public string $senderEmail,
        public string $message
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Contact form: ' . $this->senderName)
            ->replyTo($this->senderEmail, $this->senderName)
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line('Someone submitted the contact form on ' . config('app.name') . '.')
            ->line('**From:** ' . $this->senderName . ' <' . $this->senderEmail . '>')
            ->line('**Message:**')
            ->line($this->message);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'sender_name' => $this->senderName,
            'sender_email' => $this->senderEmail,
        ];
    }
}
