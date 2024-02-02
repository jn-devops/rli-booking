<?php

namespace RLI\Booking\Notifications;

use NotificationChannels\Webhook\{WebhookChannel, WebhookMessage};
use RLI\Booking\Http\Resources\VoucherResource;
use Illuminate\Notifications\Notification;
use RLI\Booking\Models\Voucher;
use Illuminate\Bus\Queueable;

class OrderConfirmedNotification extends Notification
{
    use Queueable;

    protected Voucher $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
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
        $application = config('app.name');

        return WebhookMessage::create()
            ->data([
                'entity_type' => $this->getEntityType(),
                'payload' => $this->getPayload(),
            ])
            ->userAgent($application)
            ->header($this->getCustomHeader(),  $this->getSignature())
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
            'payload' => $this->getPayload()
        ];
    }

    public function getPayload(): VoucherResource
    {
        return new VoucherResource($this->voucher);
    }

    public function getEntityType(): string
    {
        return 'checkout.property.kyc.authenticate.after';
    }

    public function getCustomHeader(): string
    {
        return 'X-Krayin-Bagisto-Signature';
    }


    public function getSignature(): string
    {
        $data = $this->getCustomHeader();
        $secret = config('booking.webhook.client_secret');

        return hash_hmac('sha256', $data, $secret);
    }
}
