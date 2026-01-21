<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Lead $lead
    ) {
        //
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
        $message = (new MailMessage)
            ->subject('New Lead: ' . $this->lead->restaurant_name)
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line('A new lead has been submitted for **' . $this->lead->restaurant_name . '**.')
            ->line('**Contact Information:**')
            ->line('Name: ' . ($this->lead->contact_full_name ?: 'N/A'))
            ->line('Email: ' . ($this->lead->email ?: 'N/A'))
            ->line('Phone: ' . ($this->lead->phone ?: 'N/A'));

        if ($this->lead->city || $this->lead->state) {
            $message->line('Location: ' . trim(($this->lead->city ?? '') . ', ' . ($this->lead->state ?? ''), ', '));
        }

        if ($this->lead->business_type) {
            $message->line('Business Type: ' . $this->lead->business_type);
        }

        if ($this->lead->cuisine_type) {
            $message->line('Cuisine Type: ' . $this->lead->cuisine_type);
        }

        if ($this->lead->source) {
            $message->line('Source: ' . ucfirst(str_replace('_', ' ', $this->lead->source)));
        }

        $message->action('View Lead', route('super-admin.leads.show', $this->lead))
            ->line('You can view and manage this lead in the admin panel.');

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
            'lead_id' => $this->lead->id,
            'restaurant_name' => $this->lead->restaurant_name,
        ];
    }
}
