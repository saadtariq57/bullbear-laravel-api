<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $url;
    public $emailBody;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;

        $template = EmailTemplate::where('name', 'password_reset')->first();
        
        $this->emailBody = $this->parseTemplate($template->body ?: $template->default_body, $user, $url);
    }


    /**
     * Parse the email template placeholders.
     *
     * @param $templateBody
     * @param $user
     * @param $url
     * @return string
     */
    protected function parseTemplate($templateBody, $user, $url)
    {
        // Define placeholders and their corresponding values
        $placeholders = [
            '{{name}}' => $user->name,
            '{{email}}' => $user->email,
            '{{reset_url}}' => $url,
        ];

        // Replace placeholders in the template body with actual values
        return str_replace(array_keys($placeholders), array_values($placeholders), $templateBody);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.password_reset',
            with: [
                'body' => $this->emailBody,
                'user' => $this->user,
                'url' => $this->url,
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
