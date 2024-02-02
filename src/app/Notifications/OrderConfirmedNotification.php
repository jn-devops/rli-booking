<?php

namespace RLI\Booking\Notifications;

use NotificationChannels\Webhook\{WebhookChannel, WebhookMessage};
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;

//TODO: use voucher instead of order
class OrderConfirmedNotification extends Notification
{
    use Queueable;

    const CUSTOM_HEADER = 'X-Krayin-Bagisto-Signature';
    const ENTITY_TYPE = 'checkout.property.kyc.authenticate.after';

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
        $data = 'X-Krayin-Bagisto-Signature';
        $secret = config('booking.webhook.client_secret');
        $signature = hash_hmac('sha256', $data, $secret);
        $application = config('app.name');
        $payload = $this->getPayload($notifiable);

        return WebhookMessage::create()
            ->data([
                'payload' => $payload,
                'entity_type' => self::ENTITY_TYPE
            ])
            ->userAgent($application)
            ->header(self::CUSTOM_HEADER, $signature)
            ->header('Accept', 'application/json')
            ;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'payload' => $this->getPayload($notifiable)
        ];
    }

    public function getPayload(object $notifiable): array
    {
        return $notifiable->getAttributes();
    }
}
