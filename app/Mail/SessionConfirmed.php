<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\Models\PersonalSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SessionConfirmed extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $emailBody;
    public $session;
    /**
     * Create a new message instance.
     */
    public function __construct($user, PersonalSession $session)
    {
        $this->user = $user;
        $this->session = $session;

        $template = EmailTemplate::where('name', 'session_confirmed')->first();
        $this->emailBody = $this->parseTemplate($template->body ?: $template->default_body, $user, $session);
    }

    protected function parseTemplate($templateBody, $user, PersonalSession $session)
    {
        $bookingDetails = "Session ID: {$session->id}\n" .
                          "Scheduled At: {$session->scheduled_at}\n" .
                          "Status: {$session->status}\n" .
                          "Feature: {$session->feature}";
        // if ($session->meet_link) {
        //     $bookingDetails .= "\nMeet Link: {$session->meet_link}";
        // }

        $placeholders = [
            '{{name}}' => $user->name,
            '{{email}}' => $user->email,
            '{{booking_details}}' => $bookingDetails,
            '{{meet_link}}' => $session->meet_link ?? 'Not available',
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $templateBody);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Session Booking Confirmed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.sessions.booking_confirmation',
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
