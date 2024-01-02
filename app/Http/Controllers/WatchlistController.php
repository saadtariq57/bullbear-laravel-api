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
        if (Auth::check()) {
            $user_id = Auth::id();
            $records = UserWatchlist::where('user_id', $user_id);
            if ($records->exists()){
                $records = UserWatchlist::where('user_id', $user_id)
                    ->orderBy('position')
                    ->with(['watchlistSymbols' => function ($query) {
                    $query->orderBy('position');
                }, 'watchlistSymbols.symbol'])->get();
            }else{
                $records = UserWatchlist::where('featured', 1)
                    ->orderBy('position')
                    ->with(['watchlistSymbols' => function ($query) {
                        $query->orderBy('position');
                    }, 'watchlistSymbols.symbol'])->get();
            }
            
            // $records = UserWatchlist::where('user_id', $user_id)->orderBy('position');
            // if (!$records->exists()) {
            //     $records = UserWatchlist::where('featured', 1)->orderBy('position')->get();
            // } else {
            //     $records = $records->orderBy('position')->get();
            // }
            // $records->each(function ($watchlist) {
            //     $watchlist->watchlistSymbols->each(function ($watchlistSymbol)  {
            //         $symbol = $watchlistSymbol->symbol;
            //     });
            // });
    
            return response()->json($records);
        }
        else{
            $records = UserWatchlist::where('featured', 1)
            ->orderBy('position')
            ->with(['watchlistSymbols' => function ($query) {
                $query->orderBy('position');
            }, 'watchlistSymbols.symbol'])->get();
            return response()->json($records);
            // return response()->json(['error' => 'User not authenticated'], 401);
        }
        
    }
    public function getSymbols($watchlistId)
    {
        $watchlist = $this->getWatchListAllData($watchlistId);

        if ($watchlist) {
            $symbolNames = $watchlist->watchlistSymbols->pluck('symbol.name');
            $stats = $this->getSymbolsStats($symbolNames->join(','));

            $watchlist->watchlistSymbols->each(function ($watchlistSymbol) use ($stats) {
                $symbol = $watchlistSymbol->symbol;
                $symbol->stats = array_merge($symbol->toArray(), $stats[$symbol->name] ?? []);
            });

            return response()->json($watchlist);
        } else {
            return response()->json(['error' => 'Watchlist not found'], 404);
        }
    }
    public function getSymbolsStats($symbols){
        $url = config('thirdparty.rapidapi.quoetsurl');
        $url .= $symbols;

        $headers = [
            'X-RapidAPI-Key' => config('thirdparty.rapidapi.key'),
            'X-RapidAPI-Host' => config('thirdparty.rapidapi.host')
        ];
        // $response = $this->httpClient->request('GET', $url, ['headers' => $headers, 'debug' => true]);
        try {
            $response = $this->httpClient->request('GET', $url, ['headers' => $headers]);
            $data = $response->getBody()->getContents();
            $data = json_decode($data, true);
            return collect($data['body'])->pluck(null, 'symbol')->all();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
           // \Log::error('Error in getSymbolsStats: ' . $e->getMessage());
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
        if (Auth::check()) {
            $user_id = Auth::id();
            // $user = Auth::user();
            $watchlists = UserWatchlist::where('user_id', $user_id) 
            ->get();
            return view('watchlist.manage', compact('watchlists'));
        }else{
            return response()->json(['error' => 'User not authenticated'], 401);
        }
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
    public function update(Request $request, UserWatchlist $watchlist)
    {
        try {
            if ($request->has('symbol_positions')) {
                $symbolPositions = $request->input('symbol_positions');
                foreach ($symbolPositions as $symbolPosition) {
                    $watchlistSymbol = WatchlistSymbol::find($symbolPosition['id']);
                    
                    if ($watchlistSymbol) {
                        $watchlistSymbol->update([
                            'position' => $symbolPosition['position'],
                        ]);
                    }
                }
                return response()->json(['position' => $watchlistSymbol->position]);
            }else{
                $request->validate([
                    'title' => 'required|string|max:255|regex:/\S/',
                ]);
    
                $watchlist->update([
                    'title' => $request->input('title'),
                ]);
                return response()->json(['title' => $watchlist->title]);
            }
        } catch (\Exception $e) {
            // Add this line to log the validation errors
            \Log::error('Validation Errors: ' . json_encode($request->errors()->all()));

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function updatePositions(Request $request)
    {
        $positions = $request->input('positions');

        foreach ($positions as $position) {
            $watchlist = UserWatchlist::find($position['id']);
            
            if ($watchlist) {
                $watchlist->update([
                    'position' => $position['position'],
                ]);
            }
        }

        return response()->json(['message' => 'Positions updated successfully']);
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


    public function getWatchListAllData($watchlistId)
    {
        return UserWatchlist::where('id', $watchlistId)
            ->with(['watchlistSymbols' => function ($query) {
                $query->orderBy('position');
            }, 'watchlistSymbols.symbol'])
            ->first();
    }
    
}
