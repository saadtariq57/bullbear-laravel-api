<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;

class GoogleMeetService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        $this->client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getAuthUrl()
    {
        $this->client->setAccessType('offline');
        return $this->client->createAuthUrl();
    }

    public function authenticate($code)
    {
        $this->client->authenticate($code);
        $accessToken = $this->client->getAccessToken();
        session(['access_token' => $accessToken['access_token']]);
        session(['refresh_token' => $accessToken['refresh_token']]); // Store the refresh token

        // Log both tokens for debugging
        \Log::info('Access token: ' . $accessToken['access_token']);
        \Log::info('Refresh token: ' . $accessToken['refresh_token']);
        \Log::info('Session data: ', session()->all()); // Log the entire session data
    }

    public function createMeetLink($eventDetails)
    {
        // Set the access token
        $this->client->setAccessToken(session('access_token'));

        // Check if the access token is expired
        if ($this->client->isAccessTokenExpired()) {
            // Check if the refresh token is available
            if (session('refresh_token')) {
                \Log::info('Using refresh token: ' . session('refresh_token'));
                // Fetch new access token using refresh token
                $newAccessToken = $this->client->fetchAccessTokenWithRefreshToken(session('refresh_token'));
                session(['access_token' => $newAccessToken['access_token']]);
            } else {
                \Log::error('Refresh token is not available.');
                throw new \Exception('Refresh token is not available.');
            }
        }

        // Proceed with event creation once the token is refreshed
        $service = new Google_Service_Calendar($this->client);
        $event = new \Google_Service_Calendar_Event($eventDetails);

        try {
            $event = $service->events->insert('primary', $event, [
                'conferenceDataVersion' => 1,
                'sendNotifications' => true,
            ]);
            return $event->getHangoutLink();
        } catch (\Exception $e) {
            \Log::error('Error creating Google Meet link: ' . $e->getMessage());
            throw $e;
        }
    }
}