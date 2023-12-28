<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;
use App\Models\UserWatchlist;
use App\Models\WatchlistSymbol;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function getWatchLists()
    {
        //TO DO
        
        // $records = UserWatchlist::where('user_id', Auth::id())
        //     ->orWhere('featured', 1)
        //     ->get();
        //return $records;
        if (Auth::check()) {
            $user_id = 681;
    
            $records = UserWatchlist::where('user_id', $user_id)->orWhere('featured', 1)->get();
    
            $records->each(function ($watchlist) {
                $symbolNames = $watchlist->watchlistSymbols->pluck('symbol.name');
                $stats = $this->getSymbolsStats($symbolNames->join(','));
    
                $watchlist->watchlistSymbols->each(function ($watchlistSymbol) use ($stats) {
                    $symbol = $watchlistSymbol->symbol;
                    $symbol->stats = array_merge($symbol->toArray(), $stats[$symbol->name] ?? []);
                });
            });
    
            return response()->json($records);
        }
        else{
            // Handle the case when the user is not authenticated.
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        
    }

    public function getSymbolsStats($symbols){
        $url = config('thirdparty.rapidapi.quoetsurl');
        $url .= $symbols;

        $headers = [
            'X-RapidAPI-Key' => config('thirdparty.rapidapi.key'),
            'X-RapidAPI-Host' => config('thirdparty.rapidapi.host')
        ];

        try {
            $response = $this->httpClient->request('GET', $url, ['headers' => $headers]);
            $data = $response->getBody()->getContents();
            $data = json_decode($data, true);
            return collect($data['body'])->pluck(null, 'symbol')->all();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return [];
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('watchlist.index', compact('user'));
    }

    public function manage(){
        // $user = Auth::user();
        $watchlist = UserWatchlist::where('user_id', Auth::id()) //TO DO
        // $watchlists = UserWatchlist::where('user_id', 2)
        ->get();
        return view('watchlist.manage', compact('watchlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TO DO
        $userWatchlistCount = UserWatchlist::where('user_id', Auth::id())->count();
        // $userWatchlistCount = UserWatchlist::where('user_id', 2)->count();
        $newWatchlistName = "My Watchlist " . ($userWatchlistCount + 1);
        $data = [
            'user_id' => Auth::id(),
            'title' => $newWatchlistName,
            'who_can_view' => 'Everyone'
        ];
        $watchlist = UserWatchlist::create($data);
        return redirect()->route('watchlist.edit', $watchlist);
    }

    /**
     * Display the specified resource.
     */
    public function show(Watchlist $watchlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserWatchlist $watchlist)
    {
        $watchlist = $this->getWatchListAllData($watchlist->id);
        return view('watchlist.edit', compact('watchlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Watchlist $watchlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserWatchlist $watchlist)
    {
        $watchlist->delete();
        return redirect()->route('watchlist.manage');
    }

    public function storeWatchListSymbol(Request $request){
        $response = false;
        $data = $request->all();
        if($data){
            WatchlistSymbol::create($data);
            $response = $this->getWatchListAllData($data['watchlist_id']);
        }
        return response()->json($response);   
    }

    public function deleteWatchListSymbol(Request $request){
        $response = false;
        $id = $request->input('id');
        $watchlistId = $request->input('watchlist_id');
        if($id && $watchlistId){
            WatchlistSymbol::destroy($id);
            $response = $this->getWatchListAllData($watchlistId);
        }
        return response()->json($response);   
    }


    public function getWatchListAllData($watchlistId){
        return UserWatchlist::where('id', $watchlistId)
        ->with('watchlistSymbols', 'watchlistSymbols.symbol')
        ->first();
    }
    
}