<?php

namespace RLI\Booking\Mail;

use Illuminate\Mail\Mailables\{Attachment, Content, Envelope};
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
Use RLI\Booking\Models\Voucher;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;

class PaymentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public Voucher $voucher;
    protected $seller;
    /**
     * Create a new message instance.
     */
    public function __construct($notifiable, Voucher $voucher)
    {
        $this->to($notifiable->email);
        $this->cc("sales@enclaves.com.ph");
        $this->seller = $notifiable;
        $this->voucher = $voucher;
        // dd($this->invoiceFilePath);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Raemulan Payment Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $order = $this->voucher->getOrder();
        $product = $order->product;
        $buyer = $order->buyer;

        return new Content(
            markdown: 'mail.paymentconfirmed',
            with: [
                'seller' => $this->seller,
                'voucher' => $this->voucher,
                'order'=> $order,
                'product'=> $product,
                'buyer' => $buyer,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
