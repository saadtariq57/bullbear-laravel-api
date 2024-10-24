<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $courses = [
            [
                'title' => 'Bearish Reversal Patterns in Technical Analysis: Identifying Market Tops',
                'description' => 'Learn to recognize key bearish reversal patterns that signal potential market tops. This course covers essential candlestick formations and chart patterns to help you anticipate downward trends effectively.',
                'drive_link' => 'https://docs.google.com/presentation/d/18PL-EuoQccCEWaBeCn7jPfqH-teKfD5f/embed?start=false&loop=false&delayms=3000',
                'icon_path' => 'course-icons/bearish-reversal.jpg',
            ],
            [
                'title' => 'Bullish Reversal Patterns in Technical Analysis: Spotting Market Bottoms',
                'description' => 'Master the identification of bullish reversal patterns that indicate possible market bottoms. This course delves into various candlestick and chart patterns essential for predicting upward trend reversals.',
                'drive_link' => 'https://docs.google.com/presentation/d/1v4YRHvs-VyztYWGlxpRPx3LSQDZXSpjC/embed?start=false&loop=false&delayms=3000',
                'icon_path' => 'course-icons/bullish-reversal.jpg',
            ],
            [
                'title' => 'Comprehensive Guide to Technical Indicators: Tools for Market Analysis',
                'description' => 'Explore the wide array of technical indicators used in market analysis. This course provides an in-depth look at indicators like Moving Averages, RSI, MACD, and more, enabling you to enhance your trading strategies.',
                'drive_link' => 'https://docs.google.com/presentation/d/1szz7sJJe0ZPclO4USoEYxJbjdvG-1ewB/embed?start=false&loop=false&delayms=3000',
                'icon_path' => 'course-icons/technical-Indicators.jpg',
            ],
            [
                'title' => 'Top 4 Support & Resistance Strategies: Mastering Key Market Levels',
                'description' => 'Gain expertise in the top four support and resistance strategies. This course covers techniques to identify and utilize these critical market levels to improve your trading decisions and enhance profitability.',
                'drive_link' => 'https://docs.google.com/presentation/d/1xr8XZ8RUtOMvbGlp3YlThZPRdKy5ZH-1/edit#slide=id.p1',
                'icon_path' => 'course-icons/support-stratigies.jpg',
            ],
            [
                'title' => 'Leading Continuation Candlestick Patterns: Maintaining Trend Momentum',
                'description' => 'Understand the best continuation candlestick patterns that help in maintaining trend momentum. This course highlights patterns that indicate the continuation of existing trends, aiding in better trade management.',
                'drive_link' => 'https://docs.google.com/presentation/d/1O9tQTcwo8vr_kxt4VF9Kdp4GAtGZW39Y/edit#slide=id.p1',
                'icon_path' => 'course-icons/best-continuation.jpg',
            ],
            [
                'title' => 'Additional Technical Analysis Patterns: Expanding Your Charting Toolkit',
                'description' => 'Expand your technical analysis toolkit with additional charting patterns. This course explores various common patterns beyond the basics, enhancing your ability to analyze and predict market movements.',
                'drive_link' => 'https://docs.google.com/presentation/d/1WEiL24L4JzLf9Fz5ZjFFARPn-xpX80V6/edit#slide=id.p1',
                'icon_path' => 'course-icons/common-stratigies.jpg',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}