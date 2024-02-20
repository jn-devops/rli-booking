<?php

namespace RLI\Booking\Mail;

use Illuminate\Mail\Mailables\{Attachment, Content, Envelope};
use Illuminate\Queue\SerializesModels;
Use RLI\Booking\Models\Voucher;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;

class Invoice extends Mailable
{
    use Queueable, SerializesModels;
    public Voucher $voucher;
    protected $buyer;
    public $invoiceFilePath;
   
    /**
     * Create a new message instance.
     */
    public function __construct($notifiable, Voucher $voucher, $invoiceFilePath)
    {
        
        
        $this->to($notifiable->email);
        // $this->name = $notifiable->getAttribute('name');
        $this->buyer = $notifiable;
        $this->voucher = $voucher;
        $this->invoiceFilePath = $invoiceFilePath;
        // dd($this->invoiceFilePath);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Raemulan Reservation Acknowledgement',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {                
        $order = $this->voucher->getOrder();
        $product = $order->product;
        // dd($product->brand);
        return new Content(
            markdown: 'mail.invoice', 
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
        return [
            Attachment::fromData(fn () => base64_decode($this->invoiceFilePath), 'Billing Statement.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
