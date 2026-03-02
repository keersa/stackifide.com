<?php

namespace App\Notifications;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubscriptionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Website $website
    ) {
        $this->website->load('user');
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
        $website = $this->website;
        $owner = $website->user;
        $ownerName = $owner ? ($owner->full_name ?: $owner->email) : 'N/A';
        $ownerEmail = $owner?->email ?? 'N/A';

        $message = (new MailMessage)
            ->subject('New subscription: ' . $website->name . ' (' . ucfirst($website->plan) . ')')
            ->greeting('Hello ' . ($notifiable->full_name ?: $notifiable->email) . '!')
            ->line('A new subscription has been created.')
            ->line('**Website**')
            ->line('Name: ' . $website->name)
            ->line('Domain: ' . ($website->domain ?: '—'))
            ->line('Status: ' . ucfirst($website->status))
            ->line('Description: ' . ($website->description ?: '—'))
            ->line('**Subscription**')
            ->line('Plan: ' . ucfirst($website->plan))
            ->line('Stripe status: ' . ($website->stripe_status ?? '—'))
            ->line('Stripe subscription ID: ' . ($website->stripe_subscription_id ?? '—'))
            ->line('Stripe customer ID: ' . ($website->stripe_id ?? '—'));

        if ($website->subscription_ends_at) {
            $message->line('Next billing date: ' . $website->subscription_ends_at->format('F j, Y'));
        }

        $message
            ->line('**Website owner**')
            ->line('Name: ' . $ownerName)
            ->line('Email: ' . $ownerEmail)
            ->action('View website', route('admin.websites.show', $website))
            ->line('You can manage this website in the admin panel.');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'website_id' => $this->website->id,
            'website_name' => $this->website->name,
            'plan' => $this->website->plan,
        ];
    }
}
