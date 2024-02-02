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

    const CUSTOM_HEADER = 'X-Krayin-Bagisto-Signature';
    const ENTITY_TYPE = 'checkout.property.kyc.authenticate.after';

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
        $data = 'X-Krayin-Bagisto-Signature';
        $secret = config('booking.webhook.client_secret');
//        $signature = hash_hmac('sha256', $data, $secret);
        $signature = '2b91413f1c973ca506c64f0894790aca4d08697d136c959fb485c0e5c11670ab';
        $application = config('app.name');

        return WebhookMessage::create()
            ->data([
                'entity_type' => self::ENTITY_TYPE,
                'payload' => $this->getPayload(),
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
            'payload' => $this->getPayload()
        ];
    }

    public function getPayload(): VoucherResource
    {
        return new VoucherResource($this->voucher);
    }
}
