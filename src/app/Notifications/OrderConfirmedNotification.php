<?php

namespace RLI\Booking\Notifications;

use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;

class OrderConfirmedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [ WebhookChannel::class ];
    }

    public function toWebhook($notifiable): WebhookMessage
    {
        return WebhookMessage::create()
            ->data([
                'payload' => [
                    'webhook' => $notifiable->toArray()
                ]
            ])
            ->userAgent("Custom-User-Agent")
            ->header('X-Custom', 'Custom-Header');
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
