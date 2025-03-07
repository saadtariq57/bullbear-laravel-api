<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class InjectSeoMeta
{
    public function handle(Request $request, Closure $next)
    {
        $assetPrefixes = ['build/', 'css/', 'js/', 'images/', 'fonts/'];

        // Skip meta injection for asset requests
        foreach ($assetPrefixes as $prefix) {
            if ($request->is($prefix . '*')) {
                return $next($request);
            }
        }

        $meta = [];

        // Define meta tags for static routes
        switch ($request->path()) {
            case '':
            case '/':
                $meta = [
                    'title' => 'Welcome to RichTv',
                    'description' => 'RichTv offers comprehensive insights into markets, finance, and trading strategies.',
                    'keywords' => 'RichTv, Markets, Finance, Trading, Investing',
                    'og:title' => 'Welcome to RichTv',
                    'og:description' => 'RichTv offers comprehensive insights into markets, finance, and trading strategies.',
                    'og:type' => 'website',
                    'og:url' => url('/'),
                    'og:image' => url('/build/images/OG/logo.svg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => 'Welcome to RichTv',
                    'twitter:description' => 'RichTv offers comprehensive insights into markets, finance, and trading strategies.',
                    'twitter:image' => url('/build/images/OG/richtv.jpg'),
                ];
                break;
                case 'buy-crypto':
                    $meta = [
                        'title' => 'Step-by-Step Guide to Buying Cryptocurrency Safely',
                        'description' => 'Learn how to buy cryptocurrency securely with our easy-to-follow guide. Discover trusted exchanges, wallet setup, and safety tips.',
                        'keywords' => 'Buy Cryptocurrency, Crypto Purchasing Guide, Secure Crypto Transactions, Crypto Wallets, Exchange Platforms',
                        'og:title' => 'Step-by-Step Guide to Buying Cryptocurrency Safely',
                        'og:description' => 'Learn how to buy cryptocurrency securely with our easy-to-follow guide. Discover trusted exchanges, wallet setup, and safety tips.',
                        'og:type' => 'website',
                        'og:url' => url('/how-to-buy-cryptocurrency'),
                        'og:image' => url('/build/images/OG/default-og-image.jpg'), 
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Step-by-Step Guide to Buying Cryptocurrency Safely',
                        'twitter:description' => 'Learn how to buy cryptocurrency securely with our easy-to-follow guide. Discover trusted exchanges, wallet setup, and safety tips.',
                        'twitter:image' => url('/build/images/OG/default-og-image.jpg'),
                    ];
                    break;
                    case '/trading-history':
                        $meta = [
                            'title' => 'RichTv Trading History Reports',
                            'description' => 'Review our verified monthly trading history with profit percentages. Track historical returns, market trends, and strategy performance.',
                            'keywords' => 'Trading History, Monthly Profit Reports, Crypto Returns, Market Analysis, Investment Performance',
                            'og:title' => 'RichTv Monthly Trading History Reports',
                            'og:description' => 'Review our verified monthly trading history with profit percentages. Track historical returns, market trends, and strategy performance.',
                            'og:type' => 'website',
                            'og:url' => url('/trading-history'),
                            'og:image' => url('/build/images/OG/default-og-image.jpg'),
                            'twitter:card' => 'summary_large_image',
                            'twitter:title' => 'RichTv Monthly Trading History Reports',
                            'twitter:description' => 'Review our verified monthly trading history with profit percentages. Track historical returns, market trends, and strategy performance.',
                            'twitter:image' => url('/build/images/OG/default-og-image.jpg'),
                        ];
                        break;

            case 'about-us':
                $meta = [
                    'title' => 'About Us | RichTv',
                    'description' => 'Learn more about RichTv.',
                    'keywords' => 'About RichTv, Company Information, RichTv',
                    'og:title' => 'About Us | RichTv',
                    'og:description' => 'Learn more about RichTv.',
                    'og:type' => 'website',
                    'og:url' => url('/about-us'),
                    'og:image' => url('/build/images/OG/about-us-image.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => 'About Us | RichTv',
                    'twitter:description' => 'Learn more about RichTv.',
                    'twitter:image' => url('/build/images/OG/about-us-image.jpg'),
                ];
                break;

            case 'privacy-policy':
                $meta = [
                    'title' => 'Privacy Policy | RichTv',
                    'description' => 'Read our privacy policy.',
                    'keywords' => 'Privacy Policy, RichTv Privacy',
                    'og:title' => 'Privacy Policy | RichTv',
                    'og:description' => 'Read our privacy policy.',
                    'og:type' => 'website',
                    'og:url' => url('/privacy-policy'),
                    'og:image' => url('/build/images/OG/richtv.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => 'Privacy Policy | RichTv',
                    'twitter:description' => 'Read our privacy policy.',
                    'twitter:image' => url('/build/images/OG/richtv.jpg'),
                ];
                break;
            case 'terms-of-use':
                $meta = [
                    'title' => 'Terms Of Use | RichTv',
                    'description' => 'Read our privacy policy.',
                    'keywords' => 'Privacy Policy, RichTv Privacy',
                    'og:title' => 'Privacy Policy | RichTv',
                    'og:description' => 'Read our privacy policy.',
                    'og:type' => 'website',
                    'og:url' => url('/privacy-policy'),
                    'og:image' => url('/build/images/OG/richtv.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => 'Privacy Policy | RichTv',
                    'twitter:description' => 'Read our privacy policy.',
                    'twitter:image' => url('/build/images/OG/richtv.jpg'),
                ];
                break;

            case 'contact-us':
                $meta = [
                    'title' => 'Contact Us | RichTv',
                    'description' => 'Get in touch with RichTv.',
                    'keywords' => 'Contact RichTv, Support, RichTv Contact',
                    'og:title' => 'Contact Us | RichTv',
                    'og:description' => 'Get in touch with RichTv.',
                    'og:type' => 'website',
                    'og:url' => url('/contact-us'),
                    'og:image' => url('/build/images/OG/richtv.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => 'Contact Us | RichTv',
                    'twitter:description' => 'Get in touch with RichTv.',
                    'twitter:image' => url('/build/images/OG/richtv.jpg'),
                ];
                break;

                case 'exams':
                    $meta = [
                        'title' => 'Exams | RichTv',
                        'description' => 'Prepare for your trading exams with RichTv\'s comprehensive resources and guidance.',
                        'keywords' => 'Exams, Trading Exams, RichTv',
                        'og:title' => 'Exams | RichTv',
                        'og:description' => 'Prepare for your trading exams with RichTv\'s comprehensive resources and guidance.',
                        'og:type' => 'website',
                        'og:url' => url('/exams'),
                        'og:image' => url('/build/images/OG/exams-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Exams | RichTv',
                        'twitter:description' => 'Prepare for your trading exams with RichTv\'s comprehensive resources and guidance.',
                        'twitter:image' => url('/build/images/OG/exams-image.jpg'),
                    ];
                    break;

                case 'stocks-screener':
                    $meta = [
                        'title' => 'Stock Screener | RichTv',
                        'description' => 'Find the best stocks to invest in with RichTv\'s advanced stock screener tool.',
                        'keywords' => 'Stock Screener, Stock Analysis, RichTv',
                        'og:title' => 'Stock Screener | RichTv',
                        'og:description' => 'Find the best stocks to invest in with RichTv\'s advanced stock screener tool.',
                        'og:type' => 'website',
                        'og:url' => url('/stocks-screener'),
                        'og:image' => url('/build/images/OG/stocks-screener-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Stock Screener | RichTv',
                        'twitter:description' => 'Find the best stocks to invest in with RichTv\'s advanced stock screener tool.',
                        'twitter:image' => url('/build/images/OG/stocks-screener-image.jpg'),
                    ];
                    break;

                case 'personal-access':
                    $meta = [
                        'title' => 'Personal Access | RichTv',
                        'description' => 'Gain personalized insights and access exclusive content with RichTv\'s Personal Access.',
                        'keywords' => 'Personal Access, Exclusive Content, RichTv',
                        'og:title' => 'Personal Access | RichTv',
                        'og:description' => 'Gain personalized insights and access exclusive content with RichTv\'s Personal Access.',
                        'og:type' => 'website',
                        'og:url' => url('/personal-access'),
                        'og:image' => url('/build/images/OG/personal-access-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Personal Access | RichTv',
                        'twitter:description' => 'Gain personalized insights and access exclusive content with RichTv\'s Personal Access.',
                        'twitter:image' => url('/build/images/OG/personal-access-image.jpg'),
                    ];
                    break;

                case 'pro-picks':
                    $meta = [
                        'title' => 'Pro Picks | RichTv',
                        'description' => 'Discover top investment picks curated by RichTv\'s experts in Pro Picks.',
                        'keywords' => 'Pro Picks, Investment Picks, RichTv',
                        'og:title' => 'Pro Picks | RichTv',
                        'og:description' => 'Discover top investment picks curated by RichTv\'s experts in Pro Picks.',
                        'og:type' => 'website',
                        'og:url' => url('/pro-picks'),
                        'og:image' => url('/build/images/OG/pro-picks-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Pro Picks | RichTv',
                        'twitter:description' => 'Discover top investment picks curated by RichTv\'s experts in Pro Picks.',
                        'twitter:image' => url('/build/images/OG/pro-picks-image.jpg'),
                    ];
                    break;

                case 'economic-calendar':
                    $meta = [
                        'title' => 'Economic Calendar | RichTv',
                        'description' => 'Stay updated with RichTv\'s Economic Calendar featuring key market events and indicators.',
                        'keywords' => 'Economic Calendar, Market Events, RichTv',
                        'og:title' => 'Economic Calendar | RichTv',
                        'og:description' => 'Stay updated with RichTv\'s Economic Calendar featuring key market events and indicators.',
                        'og:type' => 'website',
                        'og:url' => url('/economic-calendar'),
                        'og:image' => url('/build/images/OG/economic-calendar-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Economic Calendar | RichTv',
                        'twitter:description' => 'Stay updated with RichTv\'s Economic Calendar featuring key market events and indicators.',
                        'twitter:image' => url('/build/images/OG/economic-calendar-image.jpg'),
                    ];
                    break;

                case 'earning-calendar':
                    $meta = [
                        'title' => 'Earnings Calendar | RichTv',
                        'description' => 'Track upcoming earnings reports with RichTv\'s comprehensive Earnings Calendar.',
                        'keywords' => 'Earnings Calendar, Earnings Reports, RichTv',
                        'og:title' => 'Earnings Calendar | RichTv',
                        'og:description' => 'Track upcoming earnings reports with RichTv\'s comprehensive Earnings Calendar.',
                        'og:type' => 'website',
                        'og:url' => url('/earning-calendar'),
                        'og:image' => url('/build/images/OG/earning-calendar-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Earnings Calendar | RichTv',
                        'twitter:description' => 'Track upcoming earnings reports with RichTv\'s comprehensive Earnings Calendar.',
                        'twitter:image' => url('/build/images/OG/earning-calendar-image.jpg'),
                    ];
                    break;

                case 'dividend-calendar':
                    $meta = [
                        'title' => 'Dividend Calendar | RichTv',
                        'description' => 'Stay informed about upcoming dividend payouts with RichTv\'s Dividend Calendar.',
                        'keywords' => 'Dividend Calendar, Dividends, RichTv',
                        'og:title' => 'Dividend Calendar | RichTv',
                        'og:description' => 'Stay informed about upcoming dividend payouts with RichTv\'s Dividend Calendar.',
                        'og:type' => 'website',
                        'og:url' => url('/dividend-calendar'),
                        'og:image' => url('/build/images/OG/dividend-calendar-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Dividend Calendar | RichTv',
                        'twitter:description' => 'Stay informed about upcoming dividend payouts with RichTv\'s Dividend Calendar.',
                        'twitter:image' => url('/build/images/OG/dividend-calendar-image.jpg'),
                    ];
                    break;

                case 'splits-calendar':
                    $meta = [
                        'title' => 'Splits Calendar | RichTv',
                        'description' => 'Monitor stock splits with ease using RichTv\'s detailed Splits Calendar.',
                        'keywords' => 'Splits Calendar, Stock Splits, RichTv',
                        'og:title' => 'Splits Calendar | RichTv',
                        'og:description' => 'Monitor stock splits with ease using RichTv\'s detailed Splits Calendar.',
                        'og:type' => 'website',
                        'og:url' => url('/splits-calendar'),
                        'og:image' => url('/build/images/OG/splits-calendar-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Splits Calendar | RichTv',
                        'twitter:description' => 'Monitor stock splits with ease using RichTv\'s detailed Splits Calendar.',
                        'twitter:image' => url('/build/images/OG/splits-calendar-image.jpg'),
                    ];
                    break;

                case 'ipo-calendar':
                    $meta = [
                        'title' => 'IPO Calendar | RichTv',
                        'description' => 'Keep track of upcoming Initial Public Offerings with RichTv\'s IPO Calendar.',
                        'keywords' => 'IPO Calendar, Initial Public Offerings, RichTv',
                        'og:title' => 'IPO Calendar | RichTv',
                        'og:description' => 'Keep track of upcoming Initial Public Offerings with RichTv\'s IPO Calendar.',
                        'og:type' => 'website',
                        'og:url' => url('/ipo-calendar'),
                        'og:image' => url('/build/images/OG/ipo-calendar-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'IPO Calendar | RichTv',
                        'twitter:description' => 'Keep track of upcoming Initial Public Offerings with RichTv\'s IPO Calendar.',
                        'twitter:image' => url('/build/images/OG/ipo-calendar-image.jpg'),
                    ];
                    break;

                case 'groups':
                    $meta = [
                        'title' => 'Chat Rooms | RichTv',
                        'description' => 'Join RichTv\'s vibrant chat rooms to discuss market trends and strategies with fellow traders.',
                        'keywords' => 'Chat Rooms, Trading Discussions, RichTv',
                        'og:title' => 'Chat Rooms | RichTv',
                        'og:description' => 'Join RichTv\'s vibrant chat rooms to discuss market trends and strategies with fellow traders.',
                        'og:type' => 'website',
                        'og:url' => url('/groups'),
                        'og:image' => url('/build/images/OG/chat-rooms-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Chat Rooms | RichTv',
                        'twitter:description' => 'Join RichTv\'s vibrant chat rooms to discuss market trends and strategies with fellow traders.',
                        'twitter:image' => url('/build/images/OG/chat-rooms-image.jpg'),
                    ];
                    break;

                case 'glossary':
                    $meta = [
                        'title' => 'Glossary | RichTv',
                        'description' => 'Understand financial terms and jargon with RichTv\'s comprehensive Glossary.',
                        'keywords' => 'Glossary, Financial Terms, RichTv',
                        'og:title' => 'Glossary | RichTv',
                        'og:description' => 'Understand financial terms and jargon with RichTv\'s comprehensive Glossary.',
                        'og:type' => 'website',
                        'og:url' => url('/glossary'),
                        'og:image' => url('/build/images/OG/glossary-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Glossary | RichTv',
                        'twitter:description' => 'Understand financial terms and jargon with RichTv\'s comprehensive Glossary.',
                        'twitter:image' => url('/build/images/OG/glossary-image.jpg'),
                    ];
                    break;

                case 'richtv-live':
                    $meta = [
                        'title' => 'RichTv Live | RichTv',
                        'description' => 'Experience real-time market analysis and live trading sessions with RichTv Live.',
                        'keywords' => 'RichTv Live, Live Trading, Market Analysis, RichTv',
                        'og:title' => 'RichTv Live | RichTv',
                        'og:description' => 'Experience real-time market analysis and live trading sessions with RichTv Live.',
                        'og:type' => 'website',
                        'og:url' => url('/richtv-live'),
                        'og:image' => url('/build/images/OG/richtv-live-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'RichTv Live | RichTv',
                        'twitter:description' => 'Experience real-time market analysis and live trading sessions with RichTv Live.',
                        'twitter:image' => url('/build/images/OG/richtv-live-image.jpg'),
                    ];
                    break;

                case 'ceo-interviews':
                    $meta = [
                        'title' => 'CEO Interviews | RichTv',
                        'description' => 'Gain insights from top CEOs through exclusive interviews on RichTv.',
                        'keywords' => 'CEO Interviews, Business Leaders, RichTv',
                        'og:title' => 'CEO Interviews | RichTv',
                        'og:description' => 'Gain insights from top CEOs through exclusive interviews on RichTv.',
                        'og:type' => 'website',
                        'og:url' => url('/ceo-interviews'),
                        'og:image' => url('/build/images/OG/ceo-interviews-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'CEO Interviews | RichTv',
                        'twitter:description' => 'Gain insights from top CEOs through exclusive interviews on RichTv.',
                        'twitter:image' => url('/build/images/OG/ceo-interviews-image.jpg'),
                    ];
                    break;

                case 'watchlist':
                    $meta = [
                        'title' => 'Watchlist | RichTv',
                        'description' => 'Monitor your favorite stocks and track their performance with RichTv\'s Watchlist.',
                        'keywords' => 'Watchlist, Stock Monitoring, RichTv',
                        'og:title' => 'Watchlist | RichTv',
                        'og:description' => 'Monitor your favorite stocks and track their performance with RichTv\'s Watchlist.',
                        'og:type' => 'website',
                        'og:url' => url('/watchlist'),
                        'og:image' => url('/build/images/OG/watchlist-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Watchlist | RichTv',
                        'twitter:description' => 'Monitor your favorite stocks and track their performance with RichTv\'s Watchlist.',
                        'twitter:image' => url('/build/images/OG/watchlist-image.jpg'),
                    ];
                    break;

                case 'trading-education':
                    $meta = [
                        'title' => 'Trading Education | RichTv',
                        'description' => 'Enhance your trading skills with RichTv\'s comprehensive Trading Education programs.',
                        'keywords' => 'Trading Education, Trading Courses, RichTv',
                        'og:title' => 'Trading Education | RichTv',
                        'og:description' => 'Enhance your trading skills with RichTv\'s comprehensive Trading Education programs.',
                        'og:type' => 'website',
                        'og:url' => url('/trading-education'),
                        'og:image' => url('/build/images/OG/trading-education-image.jpg'),
                        'twitter:card' => 'summary_large_image',
                        'twitter:title' => 'Trading Education | RichTv',
                        'twitter:description' => 'Enhance your trading skills with RichTv\'s comprehensive Trading Education programs.',
                        'twitter:image' => url('/build/images/OG/trading-education-image.jpg'),
                    ];
                    break;
        }

        // Handle dynamic routes for blog, author profiles, markets, posts, and user profiles
        if (empty($meta)) {
            $path = $request->path();
            $segments = explode('/', $path);

            if (preg_match('/^quotes\/([A-Za-z0-9]+)\/?$/', $path, $matches)) {
                $symbol = strtoupper($matches[1]);
                // Optional: Fetch additional data for the symbol here
                // Example: $stockData = StockService::getStockData($symbol);
                // For simplicity, we'll use the symbol directly

                $meta = [
                    'title' => "{$symbol} Stock Quote | RichTv",
                    'description' => "Get the latest stock quote, profile, and earnings information for {$symbol} on RichTv.",
                    'keywords' => "{$symbol}, {$symbol} Stock, Stock Quote, RichTv",
                    'og:title' => "{$symbol} Stock Quote | RichTv",
                    'og:description' => "Get the latest stock quote, profile, and earnings information for {$symbol} on RichTv.",
                    'og:type' => 'website',
                    'og:url' => url("/quotes/{$matches[1]}"),
                    'og:image' => url("/build/images/OG/quote-image.jpg"),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => "{$symbol} Stock Quote | RichTv",
                    'twitter:description' => "Get the latest stock quote, profile, and earnings information for {$symbol} on RichTv.",
                    'twitter:image' => url("/build/images/OG/quote-image.jpg"),
                ];
            }
            // Handle Blog Category and Posts
            if (preg_match('/^blog\/([^\/]+)\/?$/', $path, $matches)) {
                $categorySlug = ucfirst(str_replace('-', ' ', $matches[1]));
                $meta = [
                    'title' => "$categorySlug | RichTv Blog",
                    'description' => "Explore articles and insights in the $categorySlug category.",
                    'keywords' => "$categorySlug, RichTv Blog, Articles",
                    'og:title' => "$categorySlug | RichTv Blog",
                    'og:description' => "Explore articles and insights in the $categorySlug category.",
                    'og:type' => 'website',
                    'og:url' => url("/blog/{$matches[1]}"),
                    'og:image' => url('/build/images/OG/blog-category.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => "$categorySlug | RichTv Blog",
                    'twitter:description' => "Explore articles and insights in the $categorySlug category.",
                    'twitter:image' => url('/build/images/OG/blog-category.jpg'),
                ];
            } elseif (preg_match('/^blog\/([^\/]+)\/([^\/]+)\/?$/', $path, $matches)) {
                $categorySlug = ucfirst(str_replace('-', ' ', $matches[1]));
                $postSlug = ucfirst(str_replace('-', ' ', $matches[2]));
                $meta = [
                    'title' => "$postSlug | $categorySlug | RichTv Blog",
                    'description' => "Read '$postSlug' in the $categorySlug category.",
                    'keywords' => "$postSlug, $categorySlug, RichTv Blog",
                    'og:title' => "$postSlug | $categorySlug | RichTv Blog",
                    'og:description' => "Read '$postSlug' in the $categorySlug category.",
                    'og:type' => 'article',
                    'og:url' => url("/blog/{$matches[1]}/{$matches[2]}"),
                    'og:image' => url('/build/images/OG/blog-post.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => "$postSlug | $categorySlug | RichTv Blog",
                    'twitter:description' => "Read '$postSlug' in the $categorySlug category.",
                    'twitter:image' => url('/build/images/OG/blog-post.jpg'),
                ];
            }

            // Handle Author Profiles
            if (preg_match('/^author\/(\d+)\/([^\/]+)\/?$/', $path, $matches)) {
                $authorId = $matches[1];
                $authorName = ucfirst(str_replace('-', ' ', $matches[2]));
                $meta = [
                    'title' => "$authorName | Author at RichTv",
                    'description' => "Read articles by $authorName on RichTv.",
                    'keywords' => "$authorName, Author, RichTv",
                    'og:title' => "$authorName | Author at RichTv",
                    'og:description' => "Read articles by $authorName on RichTv.",
                    'og:type' => 'profile',
                    'og:url' => url("/author/{$matches[1]}/{$matches[2]}"),
                    'og:image' => url('/build/images/OG/author-profile.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => "$authorName | Author at RichTv",
                    'twitter:description' => "Read articles by $authorName on RichTv.",
                    'twitter:image' => url('/build/images/OG/author-profile.jpg'),
                ];
            }

            // Handle Markets Categories and Subcategories
            if (preg_match('/^markets\/([^\/]+)\/?$/', $path, $matches)) {
                $category = ucfirst(str_replace('-', ' ', $matches[1]));
                $meta = [
                    'title' => "$category Markets | RichTv",
                    'description' => "Explore the $category markets with RichTv's comprehensive insights.",
                    'keywords' => "$category, Markets, RichTv",
                    'og:title' => "$category Markets | RichTv",
                    'og:description' => "Explore the $category markets with RichTv's comprehensive insights.",
                    'og:type' => 'website',
                    'og:url' => url("/markets/{$matches[1]}"),
                    'og:image' => url('/build/images/OG/markets-category.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => "$category Markets | RichTv",
                    'twitter:description' => "Explore the $category markets with RichTv's comprehensive insights.",
                    'twitter:image' => url('/build/images/OG/markets-category.jpg'),
                ];
            } elseif (preg_match('/^markets\/([^\/]+)\/([^\/]+)\/?$/', $path, $matches)) {
                $category = ucfirst(str_replace('-', ' ', $matches[1]));
                $subCategory = ucfirst(str_replace('-', ' ', $matches[2]));
                $meta = [
                    'title' => "$subCategory in $category Markets | RichTv",
                    'description' => "Detailed analysis and insights on $subCategory within $category markets.",
                    'keywords' => "$subCategory, $category, Markets, RichTv",
                    'og:title' => "$subCategory in $category Markets | RichTv",
                    'og:description' => "Detailed analysis and insights on $subCategory within $category markets.",
                    'og:type' => 'website',
                    'og:url' => url("/markets/{$matches[1]}/{$matches[2]}"),
                    'og:image' => url('/build/images/OG/markets-subcategory.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => "$subCategory in $category Markets | RichTv",
                    'twitter:description' => "Detailed analysis and insights on $subCategory within $category markets.",
                    'twitter:image' => url('/build/images/OG/markets-subcategory.jpg'),
                ];
            }

            // Handle Single Posts
            if (preg_match('/^post\/([^\/]+)\/(\d+)\/?$/', $path, $matches)) {
                $username = ucfirst(str_replace('-', ' ', $matches[1]));
                $postId = $matches[2];
                $meta = [
                    'title' => "Post by $username | RichTv",
                    'description' => "Read the latest post by $username on RichTv.",
                    'keywords' => "Post, $username, RichTv",
                    'og:title' => "Post by $username | RichTv",
                    'og:description' => "Read the latest post by $username on RichTv.",
                    'og:type' => 'article',
                    'og:url' => url("/post/{$matches[1]}/{$matches[2]}"),
                    'og:image' => url('/build/images/OG/post-image.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => "Post by $username | RichTv",
                    'twitter:description' => "Read the latest post by $username on RichTv.",
                    'twitter:image' => url('/build/images/OG/post-image.jpg'),
                ];
            }

            // Handle User Profiles
            if (preg_match('/^profile\/([^\/]+)\/?$/', $path, $matches)) {
                $userName = ucfirst(str_replace('-', ' ', $matches[1]));
                $meta = [
                    'title' => "$userName's Profile | RichTv",
                    'description' => "View the profile of $userName on RichTv.",
                    'keywords' => "$userName, Profile, RichTv",
                    'og:title' => "$userName's Profile | RichTv",
                    'og:description' => "View the profile of $userName on RichTv.",
                    'og:type' => 'profile',
                    'og:url' => url("/profile/{$matches[1]}"),
                    'og:image' => url('/build/images/OG/user-profile.jpg'),
                    'twitter:card' => 'summary_large_image',
                    'twitter:title' => "$userName's Profile | RichTv",
                    'twitter:description' => "View the profile of $userName on RichTv.",
                    'twitter:image' => url('/build/images/OG/user-profile.jpg'),
                ];
            }
        }

        // Fallback meta tags if none matched
        if (empty($meta)) {
            $meta = [
                'title' => 'RichTv | Your Gateway to Financial Insights',
                'description' => 'RichTv provides in-depth analysis and resources on markets, finance, trading strategies, and more.',
                'keywords' => 'RichTv, Financial Insights, Markets, Trading, Finance, Investing',
                'og:title' => 'RichTv | Your Gateway to Financial Insights',
                'og:description' => 'RichTv provides in-depth analysis and resources on markets, finance, trading strategies, and more.',
                'og:type' => 'website',
                'og:url' => url()->current(),
                'og:image' => url('/build/images/OG/default-og-image.jpg'),
                'twitter:card' => 'summary_large_image',
                'twitter:title' => 'RichTv | Your Gateway to Financial Insights',
                'twitter:description' => 'RichTv provides in-depth analysis and resources on markets, finance, trading strategies, and more.',
                'twitter:image' => url('/build/images/OG/default-og-image.jpg'),
            ];
        }

        // Share meta data with all views
        View::share('meta', $meta);

        return $next($request);
    }
}