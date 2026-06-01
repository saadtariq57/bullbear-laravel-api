<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyNotificationsMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $emailBody;
    public $notifications;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $notifications)
    {
        $this->user = $user;
        $this->notifications = $notifications;

        // Fetch the email template for daily notifications
        $template = EmailTemplate::where('name', 'daily_notifications')->first();
        $this->emailBody = $this->parseTemplate($template->body ?: $template->default_body, $user, $notifications);
    }

    public function parseTemplate($templateBody, $user, $notifications)
    {
        $notificationHtml = '';
        if ($notifications instanceof \Illuminate\Support\Collection) {
            foreach ($notifications as $notification) {
                $description = match ($notification['type']) {
                    'reaction' => htmlspecialchars($notification['title']),
                    'follower' => htmlspecialchars($notification['user']['name']) . " started following you.",
                    'message' => htmlspecialchars($notification['user']['name']) . " sent you a message.",
                    'comment' => htmlspecialchars($notification['user']['name']) . " commented on your post.",
                    'pollVote' => htmlspecialchars($notification['user']['name']) . " voted on your poll.",
                    default => "You have a new notification."
                };

                $absoluteUrl = $this->makeAbsoluteUrl($notification['url'] ?? '');
                $notificationHtml .= "<li><a href='" . htmlspecialchars($absoluteUrl) . "'>$description</a></li>";
            }
        } else {
            Log::error("Expected notifications to be a collection, but got: " . gettype($notifications));
        }

        $placeholders = [
            '{{name}}' => htmlspecialchars($user->name),
            '{{email}}' => htmlspecialchars($user->email),
            '{{notifications}}' => $notificationHtml,
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $templateBody);
    }

    private function makeAbsoluteUrl(string $url): string
    {
        if ($url === '') {
            return rtrim((string) config('app.url'), '/');
        }
        if (preg_match('/^https?:\/\//i', $url) === 1) {
            return $url; // already absolute
        }
        return rtrim((string) config('app.url'), '/') . $url;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name') . ' - Your Daily Notifications',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.daily_notifications', // Assuming you will create this markdown view
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
