<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ably\AblyRest;

class AblyController extends Controller
{
    public function authenticate(Request $request)
    {
        $ably = new AblyRest(env('ABLY_KEY'));
        $clientId = (string) $request->user()->id;

        $capabilities = [
            'user.notifications.'.$clientId => ['subscribe'],
            'private:feed.posts.updates.'.$clientId  => ['subscribe'],
            'private:group.posts.updates.*' => ['subscribe'],
            'private:groups.chat.*' => ['publish', 'subscribe', 'presence'],
        ];

        $tokenRequestData = $ably->auth->createTokenRequest([
            'clientId' => $clientId,
            'capability' => $capabilities,
        ]);

        return response()->json($tokenRequestData);
    }
}