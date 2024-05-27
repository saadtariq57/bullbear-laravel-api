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
    'private:feed.posts.updates.' . $clientId => ['subscribe'],
    'private:*' => ['presence', 'publish', 'subscribe'],
    'private:group.posts.updates.*' => ['subscribe'],
    'user.notifications.' . $clientId => ['subscribe']
];

/*$capabilities = [
    '*' => ['*']
];*/




        $tokenRequestData = $ably->auth->createTokenRequest([
            'clientId' => $clientId,
            'capability' => $capabilities,
        ]);

        return response()->json($tokenRequestData);
    }
}

// Response samples below with every refresh token changes, is it normel?
/*{
    "token": "bYyyRQ.A1xIQpg8vDHLFWHaFGdRAVnv-6CDe42C3x5VtS_WZ3prpVpfsc",
    "keyName": "bYyyRQ.1xIQpg",
    "issued": 1715161680796,
    "expires": 1715165280796,
    "capability": "{\"private:feed.posts.updates.1\":[\"subscribe\"],\"private:group.chat.*\":[\"presence\",\"publish\",\"subscribe\"],\"private:group.posts.updates.*\":[\"subscribe\"],\"user.notifications.1\":[\"subscribe\"]}",
    "clientId": "1"
}

{
    "token": "bYyyRQ.A1xIQpgPhQyQJSsqixfNjqWx6JSqlMbmaJ_Had5q5VrKsmwJHA",
    "keyName": "bYyyRQ.1xIQpg",
    "issued": 1715162372424,
    "expires": 1715165972424,
    "capability": "{\"private:feed.posts.updates.1\":[\"subscribe\"],\"private:group.chat.*\":[\"presence\",\"publish\",\"subscribe\"],\"private:group.posts.updates.*\":[\"subscribe\"],\"user.notifications.1\":[\"subscribe\"]}",
    "clientId": "1"
}

{
    "token": "bYyyRQ.A1xIQpgA81h0Kg2W-_ovfSk3FpUAkNpPNeCAbJXBiN19-8OQEQ",
    "keyName": "bYyyRQ.1xIQpg",
    "issued": 1715162390826,
    "expires": 1715165990826,
    "capability": "{\"private:feed.posts.updates.1\":[\"subscribe\"],\"private:group.chat.*\":[\"presence\",\"publish\",\"subscribe\"],\"private:group.posts.updates.*\":[\"subscribe\"],\"user.notifications.1\":[\"subscribe\"]}",
    "clientId": "1"
}*/