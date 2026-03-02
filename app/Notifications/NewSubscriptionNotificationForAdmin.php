<?php

namespace App\Notifications;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubscriptionNotificationForAdmin extends Notification
{
    use Queueable;

    public function __construct(
        public Website $website
    ) {
        $this->website->load('user');
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $recipientName = $notifiable->full_name ?: $notifiable->email;
        $websiteUrl = route('admin.websites.show', $this->website);

        return (new MailMessage)
            ->subject('Your subscription is active – ' . $this->website->name)
            ->view('emails.subscription-admin', [
                'website' => $this->website,
                'recipientName' => $recipientName,
                'websiteUrl' => $websiteUrl,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'website_id' => $this->website->id,
            'website_name' => $this->website->name,
            'plan' => $this->website->plan,
        ];
    }
}
