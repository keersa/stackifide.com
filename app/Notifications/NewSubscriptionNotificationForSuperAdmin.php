<?php

namespace App\Notifications;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubscriptionNotificationForSuperAdmin extends Notification
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
        $owner = $this->website->user;
        $ownerName = $owner ? ($owner->full_name ?: $owner->email) : 'N/A';
        $ownerEmail = $owner?->email ?? 'N/A';

        return (new MailMessage)
            ->subject('New subscription: ' . $this->website->name . ' (' . ucfirst($this->website->plan) . ')')
            ->view('emails.subscription-super-admin', [
                'website' => $this->website,
                'recipientName' => $notifiable->full_name ?: $notifiable->email,
                'websiteUrl' => route('admin.websites.show', $this->website),
                'ownerName' => $ownerName,
                'ownerEmail' => $ownerEmail,
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
