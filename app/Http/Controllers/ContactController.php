<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http; // Import HTTP facade

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email',
            'address'               => 'nullable|string|max:255',
            'phone'                 => 'nullable|string|max:20',
            'subject'               => 'required|string|max:255',
            'message'               => 'nullable|string',
            'g-recaptcha-response'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Verify reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secret = env('RECAPTCHA_SECRET_KEY');

        if (!$secret) {
            return response()->json([
                'success' => false,
                'message' => 'reCAPTCHA secret key not configured.',
            ], 500);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => $secret,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip(),
        ]);

        $responseBody = $response->json();

        if (!$responseBody['success'] || ($responseBody['score'] ?? 0) < 0.5) {
            return response()->json([
                'success' => false,
                'message' => 'reCAPTCHA verification failed.',
            ], 422);
        }

        // Send email
        try {
            Mail::send('emails.contact', ['data' => $request->all()], function ($message) use ($request) {
                $message->to('abservicesground@gmail.com')
                        ->subject('New Contact Form Submission: ' . $request->subject)
                        ->replyTo($request->email, $request->name);
            });

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            Log::error('Contact Form Submission Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email.',
            ], 500);
        }
    }
}
