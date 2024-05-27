<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewMessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Message Notification'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user.newMessage',
            with: [
                'messageText' => $this->message->text,
                'userName' => $this->message->user->name,
                'group' => $this->message->group->name
            ]
        );
    }
}