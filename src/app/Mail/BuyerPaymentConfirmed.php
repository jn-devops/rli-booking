<?php

namespace RLI\Booking\Mail;

use Illuminate\Mail\Mailables\{Attachment, Content, Envelope};
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
Use RLI\Booking\Models\Voucher;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;

class BuyerPaymentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public Voucher $voucher;
    protected $buyer;
    //public $receiptFilePath;
    /**
     * Create a new message instance.
     */
  
     //public function __construct($notifiable, Voucher $voucher, $receiptFilePath)
     public function __construct($notifiable, Voucher $voucher)
     {
         $this->to($notifiable->email);
         $this->cc("sales@enclaves.com.ph");
        $this->buyer = $notifiable;
        $this->voucher = $voucher;
        //$this->receiptFilePath = $receiptFilePath;
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

        return new Content(
            markdown: 'mail.buyerpaymentconfirmed',
            with: [
                'buyer' => $this->buyer,
                'voucher' => $this->voucher,
                'order'=> $order,
                'product'=> $product,
            ],);
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
