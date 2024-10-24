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

        // Check if the request path starts with any asset prefix
        foreach ($assetPrefixes as $prefix) {
            if ($request->is($prefix . '*')) {
                // Skip meta injection for asset requests
                return $next($request);
            }
        }

        $meta = [];
        switch ($request->path()) {
            case 'about-us':
                $meta = [
                    'title' => 'About Us | RichTv',
                    'description' => 'Learn more about RichTv.',
                ];
                break;
            case 'privacy-policy':
                $meta = [
                    'title' => 'Privacy Policy | RichTv',
                    'description' => 'Read our privacy policy.',
                ];
                break;
            case 'contact-us':
                $meta = [
                    'title' => 'Contact Us | RichTv',
                    'description' => 'Get in touch with RichTv.',
                ];
                break;
        }

        View::share('meta', $meta);

        return $next($request);
    }
}