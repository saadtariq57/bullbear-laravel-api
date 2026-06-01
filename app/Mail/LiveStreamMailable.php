<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LiveStreamMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $emailBody;
    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
        $template = EmailTemplate::where('name', 'live_stream')->first();
        $this->emailBody = $this->parseTemplate($template->body ?: $template->default_body, $user);
    }

    protected function parseTemplate($templateBody, $user)
    {
        // Define your custom placeholders
        $placeholders = [
            '{{name}}' => $user->name,
            '{{email}}' => $user->email,
            // Add more placeholders if needed
        ];

        // Replace custom placeholders with actual values
        return str_replace(array_keys($placeholders), array_values($placeholders), $templateBody);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name') . ' is Live Now!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.live_stream',
            with: [
                'body' => $this->emailBody,
                'user' => $this->user,
            ]
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
