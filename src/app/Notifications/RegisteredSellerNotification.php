<?php

namespace RLI\Booking\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use RLI\Booking\Mail\RegisteredSeller;
use RLI\Booking\Models\Seller;
use Illuminate\Bus\Queueable;

class RegisteredSellerNotification extends Notification
{
    use Queueable;
    public Seller $seller;
    protected $password;
    /**
     * Create a new notification instance.
     */
    public function __construct(Seller $seller, $password)
    {
        $this->seller = $seller;
        $this->password = $password;
        // dd($this->password);
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
    public function toMail(object $notifiable): RegisteredSeller
    {
        return new RegisteredSeller($notifiable, $this->seller, $this->password);
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
