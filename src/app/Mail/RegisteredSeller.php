<?php

namespace RLI\Booking\Mail;

use Illuminate\Mail\Mailables\{Attachment, Content, Envelope};
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
Use RLI\Booking\Models\Seller;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;

class RegisteredSeller extends Mailable
{
    use Queueable, SerializesModels;

    public Seller $seller;
    protected $password;
    /**
     * Create a new message instance.
     */
    public function __construct($notifiable, Seller $seller, $password)
    {
        $this->to($notifiable->personal_email);
        $this->cc("sales@enclaves.com.ph");
        $this->seller = $notifiable;
        $this->password = $password;
        // dd($this->password);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sellers Portal Activation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        
        return new Content(
            markdown: 'mail.registeredseller',        
            with: [
                'seller' => $this->seller,
                'password'=> $this->password,
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
