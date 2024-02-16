<?php

namespace RLI\Booking\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use RLI\Booking\Models\Voucher;
use Illuminate\Bus\Queueable;

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

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
