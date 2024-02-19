<?php

namespace RLI\Booking\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use RLI\Booking\Models\Voucher;
use Illuminate\Bus\Queueable;
use RLI\Booking\Mail\Invoice;

class InvoiceBuyerNotification extends Notification
{
    use Queueable;

    public string $invoiceFilePath;

    public Voucher $voucher;

    public function __construct(Voucher $voucher, string $invoiceFilePath)
    {
        $this->voucher = $voucher;
        $this->invoiceFilePath = $invoiceFilePath;
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

    public function toMail(object $notifiable): Invoice
    {
        return new Invoice($notifiable);
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
