<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ebook;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $ebooks = [
            [
                'title' => 'Candlestick Bible: Mastering Munehisa Homma\'s Techniques',
                'description' => 'Dive deep into the art of candlestick charting with insights inspired by Munehisa Homma. This comprehensive guide covers fundamental and advanced patterns to enhance your trading strategies.',
                'file_path' => 'ebooks/rpd-candlestick.pdf',
                'icon_path' => 'ebook-icons/candlestick-bible.png',
            ],
            [
                'title' => 'Trend Trading Essentials: Strategies for Profitable Market Moves',
                'description' => 'Learn how to identify and capitalize on market trends with this essential guide. Discover proven strategies to trade in alignment with prevailing market directions for consistent profits.',
                'file_path' => 'ebooks/rpd-learn-to-trade-with-the-trend.pdf',
                'icon_path' => 'ebook-icons/trend-trading-essentials.png',
            ],
            [
                'title' => 'Forex Trading Mastery: Comprehensive Training Manual',
                'description' => 'Become a proficient Forex trader with this all-encompassing training manual. Covering everything from basic concepts to advanced trading techniques, this guide is your pathway to success in the Forex market.',
                'file_path' => 'ebooks/rpd-forex-training-manual.pdf',
                'icon_path' => 'ebook-icons/forex-trading-mastery.png',
            ],
            [
                'title' => 'Understanding Share Structures: The Foundation of Corporate Ownership',
                'description' => 'Gain a thorough understanding of share structures and their implications on corporate ownership. This guide explores different share classes, voting rights, and how they influence company governance and investor relations.',
                'file_path' => 'ebooks/rpd-share-structure.pdf',
                'icon_path' => 'ebook-icons/share-structures.png',
            ],
            [
                'title' => 'Momentum Trading Strategies: Riding the Wave of Market Movement',
                'description' => 'Harness the power of momentum with this detailed guide on momentum trading strategies. Learn how to identify high-momentum assets and execute trades that capitalize on swift market movements for maximum gains.',
                'file_path' => 'ebooks/rpd-momentum-trader.pdf',
                'icon_path' => 'ebook-icons/momentum-trading-strategies.png',
            ],
            [
                'title' => 'Fundamentals of Technical Analysis: Building Blocks for Market Success',
                'description' => 'Master the fundamentals of technical analysis with this essential guide. Explore key concepts, chart patterns, and indicators that form the backbone of successful trading strategies.',
                'file_path' => 'ebooks/rpd-technical-analysis.pdf',
                'icon_path' => 'ebook-icons/fundamentals-technical-analysis.png',
            ],
            [
                'title' => 'Stock Market 101: A Beginner\'s Guide to Investing and Trading',
                'description' => 'Embark on your investing journey with this beginner-friendly guide to the stock market. Covering everything from basic terminology to foundational trading strategies, this manual is designed to equip new traders with the knowledge needed to navigate the markets confidently.',
                'file_path' => 'ebooks/rpd-training-manual.pdf',
                'icon_path' => 'ebook-icons/stock-market-101.png',
            ],
        ];

        foreach ($ebooks as $ebook) {
            Ebook::create($ebook);
        }
    }
}
