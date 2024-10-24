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

class SessionReminder extends Mailable
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

        $template = EmailTemplate::where('name', 'session_reminder')->first();
        $this->emailBody = $this->parseTemplate($template->body ?: $template->default_body, $user, $session);
    }

    protected function parseTemplate($templateBody, $user, PersonalSession $session)
    {
        $sessionDateTime = $session->scheduled_at->format('F j, Y \a\t g:i A');
        
        $bookingDetails = "Session ID: {$session->id}\n" .
                          "Scheduled At: {$sessionDateTime}\n" .
                          "Feature: {$session->feature}";

        // if ($session->meet_link) {
        //     $bookingDetails .= "\nMeet Link: {$session->meet_link}";
        // }

        $placeholders = [
            '{{name}}' => $user->name,
            '{{email}}' => $user->email,
            '{{booking_details}}' => $bookingDetails,
            '{{session_date}}' => $sessionDateTime,
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
            subject: 'Reminder: Your Session is Tomorrow',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.sessions.session_reminder',
            with: [
                'body' => $this->emailBody,
                'user' => $this->user,
                'session' => $this->session,
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
