<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\UserWatchlist;
use App\Models\WatchlistSymbol;
use App\Models\Symbol;
use App\Services\featureService;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    private $featureService;
    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }
    public function getWatchLists(Request $request)
    {
        
        if (Auth::check()) {
            $user_id = null;
            $loggedInUser = Auth::user();
            $user_id = $request->input('user_id');
            $records = UserWatchlist::where('user_id', $user_id);
            $RequestedFeature = 'Watchlist Limit';
            $watchlists = [];

            // if ($user->can('isFeaturePermission', [User::class, $RequestedFeature])) {
            //     $featureDetails = $this->featureService->getFeatures($user, $RequestedFeature);
            //     $watchlists['featureDetails'] = $featureDetails;
            // } else {
            //     $watchlists['featureLimit'] = 'this feature is disabled for this plan';
            // }

            if ($records->exists()) {
                $records = UserWatchlist::where('user_id', $user_id)
                    ->orderBy('position')
                    ->with([
                        'watchlistSymbols' => function ($query) {
                            $query->orderBy('position');
                        },
                        'watchlistSymbols.symbol'
                    ])->get();
                $watchlists['watchlistDetails'] = $records;
                $watchlists['hasUserWatchlist'] = true;
            } else {
                $records = UserWatchlist::where('featured', 1)
                    ->orderBy('position')
                    ->with([
                        'watchlistSymbols' => function ($query) {
                            $query->orderBy('position');
                        },
                        'watchlistSymbols.symbol'
                    ])->get();
                $watchlists['watchlistDetails'] = $records;
                $watchlists['hasUserWatchlist'] = false;
            }
            
            return response()->json($watchlists);
        } else {
            $records = UserWatchlist::where('featured', 1)
                ->orderBy('position')
                ->with([
                    'watchlistSymbols' => function ($query) {
                        $query->orderBy('position');
                    },
                    'watchlistSymbols.symbol'
                ])->get();
            $watchlists['watchlistDetails'] = $records;
            return response()->json($watchlists);
        }

    }
    public function getSymbols($watchlistId)
    {
        $watchlist = $this->getWatchListAllData($watchlistId);

        if ($watchlist) {
            $symbolNames = $watchlist->watchlistSymbols->pluck('symbol.symbol')->toArray();
            $symbolExchanges = $watchlist->watchlistSymbols->pluck('symbol.exchange')->toArray();
            $stats = $this->getSymbolsStats($symbolNames);
            $news = $this->getSymbolNews($symbolNames, $symbolExchanges);
            $watchlist->watchlistSymbols->each(function ($watchlistSymbol) use ($stats, $news) {
                $symbol = $watchlistSymbol->symbol;
                $symbol->stats = $stats[$symbol->symbol] ?? [];
                $symbol->news = $news[$symbol->symbol] ?? [];
            });

            return response()->json($watchlist);
        } else {
            return response()->json(['error' => 'Watchlist not found'], 404);
        }
    }

    public function getSymbolsStats($symbols)
    {
        $url = config('thirdparty.mboum.base_url');
        $url .= config('thirdparty.mboum.quote_endpoint');
        $url .= implode(',', $symbols);
        $url .= config('thirdparty.mboum.api_key');

        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            $stats = [];
            foreach ($data['data'] as $symbolData) {
                $stats[$symbolData['symbol']] = $symbolData;
            }

            return $stats;
        } catch (Exception $e) {
            \Log::error('Error in getSymbolsStats: ' . $e->getMessage());
            return [];
        }
    }

    public function getSymbolNews($symbols, $exchanges)
    {
        $wordpressApiUrl = config('services.wordpresstags.api_url');
        $tags = [];

        foreach ($symbols as $index => $symbol) {
            $tags[] = $symbol . ':' . $exchanges[$index];
        }
        $tagsParam = implode(',', $tags);

        $wordpressApiUrl .= $tagsParam . '/?secret_key=H2F1aR6nJR7K91MmD3Fe4Q';

        try {
            $response = file_get_contents($wordpressApiUrl);
            $posts = json_decode($response, true);
            $symbolNews = [];
            foreach ($posts as $newsData) {
                $symbolNews[$newsData['symbol']] = $newsData;
            }
            return $symbolNews;
        } catch (\Exception $e) {
            \Log::error('Error fetching WordPress posts: ' . $e->getMessage());
            return [];
        }
    }

    public function getWatchListAllData($watchlistId)
    {
        return UserWatchlist::where('id', $watchlistId)
            ->with([
                'watchlistSymbols' => function ($query) {
                    $query->orderBy('position');
                },
                'watchlistSymbols.symbol'
            ])
            ->first();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('watchlist.index', compact('user'));
    }

    public function manage()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            // $user = Auth::user();
            $watchlists = UserWatchlist::where('user_id', $user_id)
                ->get();
            return view('watchlist.manage', compact('watchlists'));
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user_id = $user->id;
            $userWatchlistCount = UserWatchlist::where('user_id', $user_id)->count();
            // if ($this->authorize('isAdmin', $user)) {
            if ($user->can('isAdmin')) {
                $featured = 1;
            } else {
                $featured = 0;
            }
            // $userWatchlistCount = UserWatchlist::where('user_id', 2)->count();
            // if ($user->can('isFeaturePermission', [User::class, 'Watchlist Limit'])) {
            //     $featureDetails = $this->featureService->getFeatures($user, 'Watchlist Limit');
            //     $watchlistLimit = $featureDetails['limit'];
            //     if ($userWatchlistCount < $watchlistLimit) {
                    $newWatchlistName = "My Watchlist " . ($userWatchlistCount + 1);
                    
                    $data = [
                        'user_id' => $user_id,
                        'title' => $newWatchlistName,
                        'who_can_view' => 'Everyone',
                        'featured' => $featured,
                        'symbol_count' => 0
                    ];
                    
                    $watchlist = UserWatchlist::create($data);
                    return redirect()->route('watchlist.edit', $watchlist);
                // } else {
                //     $message = 'you have exceeded the limit to create watchlist';
                //     return redirect()->route('watchlist.index')->withErrors($message);
                // }
            // } else {
            //     $message = 'this feature is disabled for this plan';
            //     return redirect()->route('watchlist.index')->withErrors($message);
            // }
        }
    }

    public function storeWatchListSymbol(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json('unauthorized request', 401);
        }

        $data = $request->all();
        $symbolId = null;

        if (!empty($data['symbol_id'])) {
            $symbolId = $data['symbol_id'];
        } elseif (!empty($data['symbol'])) {
            $symbol = Symbol::where('symbol', $data['symbol'])->first();
            if ($symbol) {
                $symbolId = $symbol->id;
            }
        }

        if (!$symbolId) {
            return response()->json('Invalid symbol', 400);
        }

        if (empty($data['watchlist_id'])) {
            return response()->json('Watchlist ID is required', 400);
        }

        try {
            WatchlistSymbol::create([
                'user_id' => $user->id,
                'watchlist_id' => $data['watchlist_id'],
                'symbol_id' => $symbolId,
            ]);

            $userWatchlist = UserWatchlist::find($data['watchlist_id']);
            if ($userWatchlist) {
                $userWatchlist->increment('symbol_count');
                $userWatchlist->save();
            }

            $response = $this->getWatchListAllData($data['watchlist_id']);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json('Error adding symbol to watchlist: ' . $e->getMessage(), 500);
        }
    }


    public function copyWatchlist(Request $request)
    {
        $data = $request->all();
        $requestedUserId = $data['userid'];
        $user = Auth::user();
        if ($user && $requestedUserId != $user->id) {
            $newWatchlistName = "Copy " . ($data['watchlist_name']);
            $newWatchlistData = [
                'user_id' => $user->id,
                'title' => $newWatchlistName,
                'who_can_view' => 'Everyone',
                'featured' => 0,
                'symbol_count' => 0
            ];
            
            $newWatchlist = UserWatchlist::create($newWatchlistData);
            if($newWatchlist){
                $watchlistData = [
                    'watchlist_id' => $newWatchlist->id,
                    'symbol_id' => $data['symbol_id'] ?? []
                ];
                $storeSymbols = $this->storeWatchListSymbol((new Request())->merge((array)$watchlistData));
                return response()->json($storeSymbols);
            }
        }else{
            return response()->json('not allowed');
        }
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
        $user = Auth::user();
        if ($user) {
            $user_id = $user->id;
            $userWatchlist = UserWatchlist::where('user_id', $user_id)->where('id', $watchlist->id)->first();
            if ($userWatchlist) {
                // $watchlist = $this->getWatchListAllData($watchlist->id);
                return view('watchlist.edit');
            } else {
                return redirect()->route('watchlist.index')->with('error', 'You are not authorized to edit this watchlist.');
            }
        } else {
            return redirect()->route('watchlist.index')->with('error', 'You are not authorized to edit this watchlist.');
        }
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
            } else {
                $request->validate([
                    'title' => 'required|string|max:255|regex:/\S/',
                ]);

                $watchlist->update([
                    'title' => $request->input('title'),
                ]);
                return response()->json(['title' => $watchlist]);
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

    public function updatePrivacy(Request $request)
    {
        $selectedPrivacy = $request->input('privacy_option');
        $watchlistID = $request->input('watchlist_id');
        $userWatchlist = UserWatchlist::where('id', $watchlistID)->first();
        if($userWatchlist){
            $userWatchlist->update([
                'who_can_view' => $selectedPrivacy,
            ]);
            return response()->json(['message' => 'watchlist privacy updated', 'selectedPrivacy' => $selectedPrivacy]);
        }else{
            return response()->json(['message' => 'Watchlist does not exist']);
        }
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function deleteWatchList(Request $request)
    {
        $watchlistId = $request->input('id');
        try {
            UserWatchlist::where('id', $watchlistId)->delete();

            WatchlistSymbol::where('watchlist_id', $watchlistId)->delete();

            return response()->json(['message' => 'Watchlist deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error Deleting Watchlist']);
        }
    }


    public function deleteWatchListSymbol(Request $request)
    {
        $response = false;
        $id = $request->input('id');
        $watchlistId = $request->input('watchlist_id');
        $userWatchlist = UserWatchlist::find($watchlistId);
        if ($id && $watchlistId) {
            WatchlistSymbol::destroy($id);
            if ($userWatchlist && $userWatchlist->symbol_count > 0) {
                $userWatchlist->decrement('symbol_count');
                $userWatchlist->save();
            }
            $response = $this->getWatchListAllData($watchlistId);
        }
        return response()->json($response);
    }

    // Admin panel Routes Below
    // public function AdminIndex(Request $request)
    // {
    //     if (Auth::check()) {
    //         $user = Auth::user();
    //         $user_id = $user->id;
    //         $records = UserWatchlist::where('user_id', $user_id);
    //         $watchlists = [];

    //         if ($records->exists()) {
    //             $records = UserWatchlist::where('featured', 1)
    //                 ->orderBy('position')
    //                 ->with([
    //                     'watchlistSymbols' => function ($query) {
    //                         $query->orderBy('position');
    //                     },
    //                     'watchlistSymbols.symbol'
    //                 ])->get();
    //             $watchlists['watchlistDetails'] = $records;
    //         }
    //         // return response()->json($watchlists);
    //         return view('admin.watchlist.index', compact('watchlists'));
    //      } 
    // }
    // public function WatchlistCreate()
    // {
    //     return view('admin.watchlist.create');
    // }
    // public function WatchlistEdit()
    // {
    //     return view('admin.watchlist.edit');
    // }
}

