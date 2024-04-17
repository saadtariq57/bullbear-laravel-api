<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\UserWatchlist;
use App\Models\WatchlistSymbol;
use App\Services\featureService;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    private $featureService;
    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }
    public function getWatchLists()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
            $records = UserWatchlist::where('user_id', $user_id);
            $RequestedFeature = 'Watchlist Limit';
            $watchlists = [];

            if ($user->can('isFeaturePermission', [User::class, $RequestedFeature])) {
                $featureDetails = $this->featureService->getFeatures($user, $RequestedFeature);
                $watchlists['featureDetails'] = $featureDetails;
            } else {
                $watchlists['featureLimit'] = 'this feature is disabled for this plan';
            }

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
            $stats = $this->getSymbolsStats($symbolNames);

            $watchlist->watchlistSymbols->each(function ($watchlistSymbol) use ($stats) {
                $symbol = $watchlistSymbol->symbol;
                $symbol->stats = $stats[$symbol->symbol] ?? [];
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
            // $userWatchlistCount = UserWatchlist::where('user_id', 2)->count();
            if ($user->can('isFeaturePermission', [User::class, 'Watchlist Limit'])) {
                $featureDetails = $this->featureService->getFeatures($user, 'Watchlist Limit');
                $watchlistLimit = $featureDetails['limit'];
                if ($userWatchlistCount < $watchlistLimit) {
                    $newWatchlistName = "My Watchlist " . ($userWatchlistCount + 1);
                    $data = [
                        'user_id' => $user_id,
                        'title' => $newWatchlistName,
                        'who_can_view' => 'Everyone'
                    ];
                    $watchlist = UserWatchlist::create($data);
                    return redirect()->route('watchlist.edit', $watchlist);
                } else {
                    $message = 'you have exceeded the limit to create watchlist';
                    return redirect()->route('watchlist.index')->withErrors($message);
                }
            } else {
                $message = 'this feature is disabled for this plan';
                return redirect()->route('watchlist.index')->withErrors($message);
            }
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
                $watchlist = $this->getWatchListAllData($watchlist->id);
                return view('watchlist.edit', compact('watchlist'));
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

    public function storeWatchListSymbol(Request $request)
    {
        $response = false;
        $data = $request->all();
        if ($data) {
            WatchlistSymbol::create($data);
            $response = $this->getWatchListAllData($data['watchlist_id']);
        }
        return response()->json($response);
    }

    public function deleteWatchListSymbol(Request $request)
    {
        $response = false;
        $id = $request->input('id');
        $watchlistId = $request->input('watchlist_id');
        if ($id && $watchlistId) {
            WatchlistSymbol::destroy($id);
            $response = $this->getWatchListAllData($watchlistId);
        }
        return response()->json($response);
    }

    // Admin panel Routes Below
    public function AdminIndex(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $watchlists = UserWatchlist::where('title', 'LIKE', "%{$search}%")
                // ... add other fields if needed
                ->paginate(10);
        } else {
            $watchlists = UserWatchlist::paginate(10);
        }

        return view('admin.watchlist.index', compact('watchlists'));
    }
    public function WatchlistCreate()
    {
        // $watchlists = watchlists::all();
        return view('admin.watchlist.create');
    }
}

