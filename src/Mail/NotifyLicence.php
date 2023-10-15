<?php

namespace Susheelbhai\Laratrack\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyLicence extends Mailable
{
    use Queueable, SerializesModels;

    public $env;
    public $config;
    public function __construct($env, $config)
    {
        $this->env = $env;
        $this->config = $config;
    }

    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your website copy is now live on ". Request::root(),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'laratrack::mail.notify-licence',
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
