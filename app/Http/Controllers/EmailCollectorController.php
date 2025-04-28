<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class EmailCollectorController extends Controller
{
    protected $contactApi;
    protected $segmentApi;

    public function __construct(\Mautic\Api\Contacts $contactApi, \Mautic\Api\Segments $segmentApi)
    {
        $this->contactApi = $contactApi;
        $this->segmentApi = $segmentApi;
    }

    public function collect(Request $request)
    {
        // Rate limiting by IP address
        $ipKey = 'email_collector_ip_' . md5($request->ip());
        if (RateLimiter::tooManyAttempts($ipKey, 3)) { // 3 attempts per minute
            $seconds = RateLimiter::availableIn($ipKey);
            return response()->json([
                'success' => false,
                'message' => 'Too many attempts. Please try again in ' . $seconds . ' seconds.'
            ], 429);
        }
        RateLimiter::hit($ipKey, 60); // Keep in cache for 60 seconds
        
        // Validation
        $request->validate([
            'mauticform.email' => [
                'required',
                'email:rfc,dns',  // Removed 'spoof' here
                'max:255',
                function ($attribute, $value, $fail) {
                    $disposableDomains = [
                        'skylersclass.live', 'fakeinbox.com', 'spamgourmet.com', 'tempinbox.com', 'emailondeck.com', 'mohmal.com', 'mintemail.com', 'dispostable.com', 'mailcatch.com', 'mailnesia.com', 'temp-mail.org', 'easipro.com', 'letterguard.net', 'inbox888.com', 'mailsac.com', 'indigobook.com', 'mixzu.net', 'sharklasers.com', 'traitus.com', 'truemr.com', 'vwhins.com', 'weboors.com', 'yopmail.com', 'thetechnext.net', 'rhyta.com', 'cuvox.de', 'dayrep.com', 'einrot.com', 'fleckens.hu', 'gustr.com', 'superrito.com', 'jourrapide.com', 'teleworm.us', 'armyspy.com', 'mailinator.com', 'trashmail.com', '10minutemail.com', 'tempmail.net', 'tempmail.com', 'guerrillamail.com', 'getnada.com', 'maildrop.cc', 'burnermail.com', 'throwawaymail'
                    ];
                    $domain = explode('@', $value)[1] ?? '';
                    
                    if (in_array(strtolower($domain), $disposableDomains)) {
                        $fail('Please use a non-disposable email address. We cannot send alerts to temporary email services.');
                    }
                    if (preg_match('/([a-z0-9])\1{5,}/', $value)) {
                        $fail('This email address appears to be invalid. Please use your regular email address.');
                    }
                    
                    // Check for sequential patterns
                    if (preg_match('/abcdef|123456|qwerty/', strtolower($value))) {
                        $fail('This email address appears to be invalid. Please use your regular email address.');
                    }
                },
            ],
            'mauticform.consent_box' => 'required|in:1',
            'honeypot' => 'nullable|size:0',
        ], [
            'mauticform.email.required' => 'Please enter your email address to receive stock pick alerts.',
            'mauticform.email.email' => 'Please enter a valid email address.',
            'mauticform.email.max' => 'Email address is too long.',
            'mauticform.consent_box.required' => 'Please agree to receive newsletters and email alerts.',
            'mauticform.consent_box.in' => 'Please check the consent box to continue.',
            'honeypot.size' => 'Invalid submission detected.'
        ]);

        try {
            $email = $request->input('mauticform.email');
            
            // Rate limiting by email address
            $emailKey = 'email_collector_email_' . md5($email);
            if (RateLimiter::tooManyAttempts($emailKey, 10)) { // 10 attempts per day
                return response()->json([
                    'success' => false,
                    'message' => 'This email has been submitted too many times today.'
                ], 429);
            }
            RateLimiter::hit($emailKey, 60 * 60 * 24); // Keep in cache for 24 hours
            
            $segmentId = 185;
            
            // Create or update contact in Mautic
            $contactData = [
                'email' => $email,
                'tags' => ['website_footer_subscription'],
                'ipAddress' => $request->ip(),
                'consent' => true
            ];
            
            // Log::info('Creating/updating contact', ['email' => $email]);
            
            // Let Mautic handle duplicate detection
            $contact = $this->contactApi->create($contactData);
            
            if (isset($contact['contact']['id'])) {
                $contactId = $contact['contact']['id'];
                
                // Add contact to the segment
                // Log::info('Adding contact to segment', [
                //     'contact_id' => $contactId,
                //     'segment_id' => $segmentId
                // ]);
                
                $this->segmentApi->addContact($segmentId, $contactId);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Email collected successfully!'
                ]);
            } else {
                // Log::error('Contact ID not found in response', ['response' => $contact]);
                throw new \Exception('Failed to create/update contact in Mautic');
            }
        } catch (\Exception $e) {
            // Log::error('Error adding contact to Mautic', [
            //     'email' => $request->input('mauticform.email'),
            //     'error' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString()
            // ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
}