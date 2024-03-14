<?php

namespace RLI\Booking\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use RLI\Booking\Mail\BuyerPaymentConfirmed;
use Illuminate\Notifications\Notification;
use RLI\Booking\Models\Voucher;
use Illuminate\Bus\Queueable;


class PaymentConfirmedBuyerNotification extends Notification
{
    use Queueable;

    public string $payment_id;
    public Voucher $voucher;
    /**
     * Create a new notification instance.
     */
    public function __construct(Voucher $voucher, $payment_id)
    {
        $this->voucher = $voucher;
        $this->payment_id = $payment_id;
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
    public function toMail(object $notifiable): BuyerPaymentConfirmed
    {
        return new BuyerPaymentConfirmed($notifiable, $this->voucher);
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
