<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WatchlistAlertsMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $emailBody;
    public $watchlistData;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $watchlistData)
    {
        $this->user = $user;
        $this->watchlistData = $watchlistData;

        $template = EmailTemplate::where('name', 'watchlist_alert')->first();
        $this->emailBody = $this->parseTemplate($template->body ?: $template->default_body, $user, $watchlistData);
    }

    public function parseTemplate($templateBody, $user, $watchlistData)
    {
        $watchlistHtml = '';

        // Check if $watchlistData is an array and has items
        // if (is_array($watchlistData) && count($watchlistData) > 0) {
            foreach ($watchlistData as $watchlist) {
                $watchlistHtml .= "<h3>{$watchlist['title']}</h3><ul>";

                // Check if 'watchlist_symbols' exists and is an array
                if (isset($watchlist['watchlist_symbols']) && is_array($watchlist['watchlist_symbols'])) {
                    foreach ($watchlist['watchlist_symbols'] as $symbolData) {
                        $symbol = $symbolData['symbol'] ?? [];
                        $symbolName = $symbol['symbol'] ?? 'N/A';  // Default to 'N/A' if symbol is missing
                        $symbolDescription = $symbol['name'] ?? 'No description available';
                        $symbolExchange = $symbol['exchange'] ?? 'Unknown Exchange';
                        $symbolCurrency = $symbol['currency'] ?? 'Unknown Currency';

                        // Create list item with the symbol details
                        $watchlistHtml .= "<li>
                            Symbol: {$symbolName} - {$symbolDescription}<br>
                            Exchange: {$symbolExchange}<br>
                            Currency: {$symbolCurrency}
                        </li>";
                    }
                } else {
                    $watchlistHtml .= "<li>No symbols available in this watchlist.</li>";
                }

                $watchlistHtml .= "</ul>";
            }
        // } else {
        //     $watchlistHtml = '<p>No watchlist data available.</p>';
        // }

        // Define your custom placeholders
        $placeholders = [
            '{{name}}' => $user->name,
            '{{email}}' => $user->email,
            '{{watchlist_details}}' => $watchlistHtml,
        ];

        // Replace placeholders in the template body
        return str_replace(array_keys($placeholders), array_values($placeholders), $templateBody);
    }




    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your watchlist is Updated - Just for you!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.watchlist_alert',
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
