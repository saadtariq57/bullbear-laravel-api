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
        foreach ($watchlistData as $watchlist) {
            $title = htmlspecialchars($watchlist['title']);
            $watchlistHtml .= "<h3 style='margin-bottom: 10px; text-align:center;'>{$title}</h3>";
            $watchlistHtml .= "<table border='1' style='margin-bottom: 35px;'>";
            $watchlistHtml .= "<thead>";
            $watchlistHtml .= "<tr>
                                    <th>Company</th>
                                    <th>Price</th>
                                    <th>Day Range</th>
                                    <th>Fifty Two Weeks Performance</th>
                                    <th>Volume</th>
                                </tr>";
            $watchlistHtml .= "</thead><tbody>";
            if (isset($watchlist['watchlist_symbols']) && is_array($watchlist['watchlist_symbols'])) {
                $symbols = $watchlist['watchlist_symbols'];
                
                if (!empty($symbols)) {
                    foreach ($symbols as $symbolData) {
                        $symbol = $symbolData['symbol'];
                        $symbolLogo = htmlspecialchars($symbol['quote']['logo'] ?? '');
                        $symbolName = htmlspecialchars($symbol['name']);
                        $symbolTicker = htmlspecialchars($symbol['symbol']); // Assuming 'symbol' is the ticker
                        $symbolExchange = htmlspecialchars($symbol['exchange']);
                        $symbolPrice = htmlspecialchars($symbol['quote']['price'] ?? 'N/A');
                        $symbolDayRange = htmlspecialchars($symbol['quote']['regularMarketDayRange'] ?? 'N/A');
                        $symbolfiftyTwoWeekHigh = htmlspecialchars($symbol['quote']['fiftyTwoWeekHigh'] ?? 'N/A');
                        $symbolfiftyTwoWeekLow = htmlspecialchars($symbol['quote']['fiftyTwoWeekLow'] ?? 'N/A');
                        $symbolChangePrice = htmlspecialchars($symbol['quote']['regular_market_change'] ?? 'N/A');
                        $symbolChangePercent = htmlspecialchars($symbol['quote']['change_percent'] ?? 'N/A');
                        $symbolVolume = htmlspecialchars($symbol['quote']['volume'] ?? 'N/A');
                        $symbolCurrency = htmlspecialchars($symbol['currency']);

                        $watchlistHtml .= "<tr>";
                        $watchlistHtml .= "<td>{$symbolTicker}:{$symbolExchange}<br>{$symbolName}</td>";
                        $watchlistHtml .= "<td>{$symbolPrice}<br>{$symbolChangePrice} | {$symbolChangePercent}</td>";
                        $watchlistHtml .= "<td>{$symbolDayRange}</td>";
                        $watchlistHtml .= "<td>High: {$symbolfiftyTwoWeekHigh}<br>Low: {$symbolfiftyTwoWeekLow}</td>";
                        $watchlistHtml .= "<td>{$symbolVolume}</td>";
                        $watchlistHtml .= "</tr>";
                    }
                } else {
                    $watchlistHtml .= "<tr><td colspan='5'>No symbols available in this watchlist.</td></tr>";
                }
            } else {
                $watchlistHtml .= "<tr><td colspan='5'>No symbols available in this watchlist.</td></tr>";
            }
            $watchlistHtml .= "</tbody></table>";
        }

        $placeholders = [
            '{{name}}' => htmlspecialchars($user->name),
            '{{email}}' => htmlspecialchars($user->email),
            '{{watchlist_details}}' => $watchlistHtml,
        ];

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
