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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\WatchlistAlertsMailable;
use Illuminate\Support\Facades\Log;
use App\Models\Follower;

class WatchlistController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        // Fetch watchlists with associated user
        $watchlists = UserWatchlist::with('user')->paginate(10);

        return view('admin.watchlists.index', compact('watchlists'));
    }

     public function create()
    {
        // Fetch all users to assign a watchlist to a user
        $users = \App\Models\User::all();

        return view('admin.watchlists.create', compact('users'));
    }
    
   public function store(Request $request)
   {

       $user = Auth::user();
       if (!$user) {
           return redirect()->route('login')->with('error', 'You must be logged in to create a watchlist.');
       }

       // Existing authorization logic
       if ($user->can('isAdmin')) {
           $featured = 1;
       } else {
           $featured = 0;
       }

       $request->validate([
           'user_id'       => 'required|exists:users,id',
           'title'         => 'nullable|string|max:255',
           'who_can_view'  => 'required|string|max:255',
           'featured'      => 'required|boolean',
           'symbol_count'  => 'nullable|integer',
           'position'      => 'nullable|integer',
       ]);

       $userWatchlistCount = UserWatchlist::where('user_id', $request->user_id)->count();
       $title = $request->input('title') ?: "My Watchlist " . ($userWatchlistCount + 1);

       $watchlist = UserWatchlist::create([
           'user_id' => $request->input('user_id'),
           'title' => $title,
           'who_can_view' => $request->input('who_can_view'),
           'featured' => $request->input('featured'),
           'symbol_count' => $request->input('symbol_count', 0),
           'position' => $this->getNextWatchlistPosition($request->input('user_id')),
       ]);

       return redirect()->route('admin.watchlists.edit', $watchlist)->with('success', 'Watchlist created successfully.');
   }

    public function edit(UserWatchlist $watchlist)
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('admin.watchlists.index')
                             ->with('error', 'You must be logged in to edit a watchlist.');
        }

        // Authorization: Admins can edit any watchlist, users can edit their own
        if ($user->can('isAdmin')) {
            // Admin has access to edit any watchlist
        }
        elseif ($user->id !== $watchlist->user_id) {
            // Log the unauthorized access attempt
            Log::warning('Unauthorized edit attempt by user ID ' . $user->id . ' on watchlist ID ' . $watchlist->id);
            
            return redirect()->route('admin.watchlists.index')
                             ->with('error', 'You are not authorized to edit this watchlist.');
        }

        // Fetch all users to assign a watchlist to a user (useful for admins)
        $users = \App\Models\User::all();

        return view('admin.watchlists.edit', compact('watchlist', 'users'));
    }

   public function UserUpdate(Request $request, UserWatchlist $watchlist)
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
                   'title'         => 'nullable|string|max:255',
                   'who_can_view'  => 'nullable|string|max:255',
                   'featured'      => 'nullable|boolean',
                   'symbol_count'  => 'nullable|integer',
                   'position'      => 'nullable|integer',
               ]);

               $watchlist->update($request->all());
               return response()->json(['title' => $watchlist]);
           }
       } catch (\Exception $e) {
           \Log::error('Validation Errors: ' . json_encode($e->getMessage()));
           return response()->json(['error' => $e->getMessage()], 422);
       }
   }

    public function update(Request $request, UserWatchlist $watchlist)
    {
        try {
            // Check if the request has symbol positions to update
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
                // Return the last updated position for the last symbol
                return response()->json(['position' => $watchlistSymbol->position]);
            } else {
                // Validate the request data
                $request->validate([
                    'user_id'       => 'required|exists:users,id',
                    'title'         => 'required|string|max:255',
                    'who_can_view'  => 'required|string|max:255',
                    'featured'      => 'required|boolean',
                    'symbol_count'  => 'nullable|integer',
                    'position'      => 'nullable|integer',
                ]);

                // Update the watchlist with the request data
                $watchlist->update($request->all());

                // Return the updated watchlist details
                return redirect()->route('admin.watchlists.index')->with('success', 'Watchlist Updated successfully.');
            }
        } catch (\Exception $e) {
            \Log::error('Admin Update Error: ' . json_encode($e->getMessage()));
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function destroy(UserWatchlist $watchlist)
    {
        $watchlist->delete();

        return redirect()->route('admin.watchlists.index')->with('success', 'Watchlist deleted successfully.');
    }

    public function symbols(UserWatchlist $watchlist)
    {
        // Fetch symbols with related symbol data
        $symbols = $watchlist->watchlistSymbols()->with('symbol')->get();

        // Pass the watchlist and symbols to the view
        return view('admin.watchlists.symbols', compact('watchlist', 'symbols'));
    }

    public function updateSymbols(Request $request, UserWatchlist $watchlist)
    {
        // Validate incoming request
        $request->validate([
            'symbols' => 'required|array',
            'symbols.*' => 'exists:symbols,id',
        ]);

        // Fetch current symbols associated with the watchlist
        $currentSymbolIds = WatchlistSymbol::where('watchlist_id', $watchlist->id)
                            ->pluck('symbol_id')
                            ->toArray();

        // Merge existing symbols with new symbols, ensuring uniqueness
        $newSymbolIds = array_unique(array_merge($currentSymbolIds, $request->symbols));

        // Enforce a maximum limit of 10 symbols
        if (count($newSymbolIds) > 10) {
            return redirect()
                    ->route('admin.watchlists.symbols', $watchlist)
                    ->with('error', 'You can only have a maximum of 10 symbols in a watchlist.');
        }

        // Determine symbols to add (excluding already existing ones)
        $symbolsToAdd = array_diff($newSymbolIds, $currentSymbolIds);

        // Attach new symbols
        foreach ($symbolsToAdd as $symbol_id) {
            WatchlistSymbol::create([
                'user_id'      => $watchlist->user_id,
                'watchlist_id' => $watchlist->id,
                'symbol_id'    => $symbol_id,
                'position'     => 0,
            ]);
        }

        $watchlist->update([
            'symbol_count' => count($newSymbolIds),
        ]);

        return redirect()
                ->route('admin.watchlists.symbols', $watchlist)
                ->with('success', 'Symbols updated successfully.');
    }
    public function UserStore(Request $request)
    {
        $user = Auth::user();

        if (Gate::denies('access-feature', ['real_time_watchlists'])) {
            return response()->json(['message' => 'Access denied. Upgrade your plan to create more watchlists.'], 403);
        }
        if ($user) {
            $user_id = $user->id;
            $userWatchlistCount = UserWatchlist::where('user_id', $user_id)->count();
            $newWatchlistName = "My Watchlist " . ($userWatchlistCount + 1);
            
            $data = [
                'user_id' => $user_id,
                'title' => $newWatchlistName,
                'who_can_view' => 'Everyone',
                'featured' => 0,
                'symbol_count' => 0,
                'position' => $this->getNextWatchlistPosition($user_id),
            ];
            
            $watchlist = UserWatchlist::create($data);
            return response()->json([
                'watchlistId' => $watchlist->id
            ]);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }

/*    public function edit(UserWatchlist $watchlist)
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
    }*/

    public function getWatchLists(Request $request)
    {
        try {
            // Validate the incoming request to ensure 'user_id' is present and valid
            $request->validate([
                'user_id' => 'required|integer|exists:users,id',
            ]);

            $requestedUserId = $request->input('user_id');
            $isAuthenticated = Auth::check();
            $loggedInUser = $isAuthenticated ? Auth::user() : null;

            // Fetch the requested user
            $requestedUser = User::find($requestedUserId);
            if (!$requestedUser) {
                return response()->json([
                    'error' => 'User not found.'
                ], 404);
            }

            // Initialize variables for authorization
            $canAccessWatchlists = false;
            $errorMessage = null;
            $isOwner = $isAuthenticated && $loggedInUser && $requestedUserId == $loggedInUser->id;
            $viewerIsFollower = false;

            if (!$isOwner && $isAuthenticated && $loggedInUser) {
                $viewerIsFollower = Follower::where('follower_id', $loggedInUser->id)
                    ->where('following_id', $requestedUser->id)
                    ->exists();
            }

            // 1. If Requested userId == Logged In user, allow access
            if ($isOwner) {
                $canAccessWatchlists = true;
            } else {
                // 2. If requested user id is different, check watchlists_privacy
                $watchlistsPrivacy = $requestedUser->watchlists_privacy; // Assuming this field exists

                switch ($watchlistsPrivacy) {
                    case 'Everyone':
                        // 3. If watchlists_privacy is Everyone, allow access
                        $canAccessWatchlists = true;
                        break;

                    case 'Followers':
                        // 4. If watchlists_privacy is Followers, check if logged-in user follows requested user
                        if (!$isAuthenticated) {
                            $errorMessage = 'You need to follow this user to view their watchlists.';
                            break;
                        }

                        if ($viewerIsFollower) {
                            $canAccessWatchlists = true;
                        } else {
                            $errorMessage = 'You need to follow this user to view their watchlists.';
                        }
                        break;

                    case 'Private':
                        // 5. If watchlists_privacy is Private, deny access
                        $errorMessage = 'User Watchlists are Private.';
                        break;

                    default:
                        // Handle unexpected privacy settings
                        $errorMessage = 'Invalid privacy settings.';
                        break;
                }
            }

            if (!$canAccessWatchlists) {
                return response()->json([
                    'error' => 'Unauthorized access.',
                    'message' => $errorMessage
                ], 403);
            }

            // Fetch watchlists for the requested user
            $watchlists = UserWatchlist::where('user_id', $requestedUserId)
                ->orderBy('position')
                ->with(['watchlistSymbols.symbol'])
                ->get();

            if ($watchlists->isEmpty()) {
                // Attempt to fetch 3 featured watchlists where featured = 1
                $featuredWatchlists = UserWatchlist::where('featured', 1)
                    ->orderBy('position')
                    ->with(['watchlistSymbols.symbol'])
                    ->limit(3)
                    ->get();

                if ($featuredWatchlists->isNotEmpty()) {
                    $watchlists = $featuredWatchlists;
                    $hasUserWatchlist = false; // Indicate that these are featured watchlists, not user's own
                } else {
                    // If no featured watchlists are found, return empty response
                    return response()->json([
                        'watchlistDetails' => [],
                        'hasUserWatchlist' => false
                    ]);
                }
            } else {
                $hasUserWatchlist = true; // User has watchlists
            }

            // Filter watchlists based on individual privacy controls
            $watchlists = $watchlists->filter(function ($watchlist) use ($loggedInUser, $isAuthenticated, $viewerIsFollower) {
                return $this->canViewSpecificWatchlist($watchlist, $loggedInUser, $isAuthenticated, $viewerIsFollower);
            })->values();


            // Collect all symbols from watchlists, handling watchlists with no symbols gracefully
            $symbols = $watchlists->pluck('watchlistSymbols')
                ->flatten()
                ->pluck('symbol.symbol')
                ->filter()
                ->unique()
                ->map(function ($symbol) {
                    return strtoupper($symbol);
                })
                ->toArray();

            // Initialize quotes and news arrays
            $quotes = [];
            $news = [];

            if (!empty($symbols)) {
                // Fetch all quotes in a single API call
                $symbolString = implode(',', $symbols);
                $quotesApiUrl = env('STOCKS_API_URL') . "/api/quotes?symbols={$symbolString}";
                $quotesResponse = Http::timeout(15)->get($quotesApiUrl);

                if ($quotesResponse->successful()) {
                    $quotesData = $quotesResponse->json();

                    // Ensure $quotesData is an associative array with uppercase keys
                    if (is_array($quotesData) && !empty($quotesData)) {
                        // Assuming the API returns data as ['SYM' => {...}, ...]
                        $quotes = array_change_key_case($quotesData, CASE_UPPER);
                    } else {
                        // Log unexpected structure
                        Log::error('Quotes API returned unexpected structure.', ['quotes' => $quotesData]);
                    }
                } else {
                    Log::error('Quotes API request failed', [
                        'status' => $quotesResponse->status(),
                        'body' => $quotesResponse->body(),
                        'url' => $quotesApiUrl,
                    ]);
                }

                $news = $this->getSymbolNews($symbols);
            }

            // **Attach quotes and news to each symbol with field mapping**
            foreach ($watchlists as $watchlist) {
                foreach ($watchlist->watchlistSymbols as $watchlistSymbol) {
                    // Check if symbol exists
                    if (!$watchlistSymbol->symbol) {
                        
                        // Check if symbol is an instance of Eloquent Model
                        if ($watchlistSymbol->symbol instanceof \Illuminate\Database\Eloquent\Model) {
                            $watchlistSymbol->symbol->setAttribute('quote', null);
                            $watchlistSymbol->symbol->setAttribute('news', []);
                        } else {

                            continue;
                        }

                        continue;
                    }

                    $symbolName = strtoupper($watchlistSymbol->symbol->symbol);

                    // Attach quote data with field mapping
                    if (isset($quotes[$symbolName])) {
                        $watchlistSymbol->symbol->setAttribute('quote', [
                            'price' => $quotes[$symbolName]['regular_market_price'] ?? null,
                            'change' => $quotes[$symbolName]['regular_market_change'] ?? null,
                            'change_percent' => $quotes[$symbolName]['regular_market_change_percent'] ?? null,
                            'logo' => $quotes[$symbolName]['logo'] ?? null,
                            'regularMarketDayRange' => $quotes[$symbolName]['regular_market_day_range'] ?? null,
                            'fiftyTwoWeekHigh' => $quotes[$symbolName]['fifty_two_week_high'] ?? null,
                            'fiftyTwoWeekLow' => $quotes[$symbolName]['fifty_two_week_low'] ?? null,
                            'updated_at' => $quotes[$symbolName]['updated_at'] ?? null,
                            'currency' => $quotes[$symbolName]['currency'] ?? null,
                            'volume' => $quotes[$symbolName]['volume'] ?? null,
                        ]);
                    } else {
                        Log::warning("No quote data for symbol: {$symbolName}");
                        $watchlistSymbol->symbol->setAttribute('quote', null);
                    }

                    // Attach news data
                    $watchlistSymbol->symbol->setAttribute('news', $news[$symbolName] ?? []);
                }
            }

            $response = [
                'watchlistDetails' => $watchlists
            ];

            // **Modified Section to Set 'hasUserWatchlist'**
            $response['hasUserWatchlist'] = $hasUserWatchlist ?? false;
            // **End of Modification**

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error in WatchlistController@getWatchLists', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }




    public function getFeaturedWatchlists()
    {
        $featuredWatchlists = UserWatchlist::where('featured', true)
            ->orderBy('position')
            ->with([
                'watchlistSymbols' => function ($query) {
                    $query->orderBy('position');
                },
                'watchlistSymbols.symbol'
            ])
            ->get();

        return response()->json([
            'watchlistDetails' => $featuredWatchlists
        ]);
    }

    /**
     * Determine if the current viewer can see a specific watchlist.
     */
    private function canViewSpecificWatchlist(UserWatchlist $watchlist, ?User $viewer, bool $isAuthenticated, bool $viewerIsFollower): bool
    {
        if ($viewer && $watchlist->user_id === $viewer->id) {
            return true;
        }

        if ($viewer && Gate::forUser($viewer)->allows('isAdmin')) {
            return true;
        }

        $visibility = strtolower(trim($watchlist->who_can_view ?? 'everyone'));
        $visibility = str_replace([' ', '_', '-'], '', $visibility);

        switch ($visibility) {
            case 'onlyme':
            case 'private':
                return false;
            case 'followers':
                return $viewerIsFollower;
            case 'everoneloggedin':
            case 'everyoneloggedin':
            case 'loggedin':
            case 'loggedinonly':
                return $isAuthenticated;
            case 'prousers':
            case 'pro':
                return $this->viewerHasProAccess($viewer);
            case 'everyone':
            default:
                return true;
        }
    }

    /**
     * Determine if the viewer has a paid/pro subscription that should grant access.
     */
    private function viewerHasProAccess(?User $viewer): bool
    {
        if (!$viewer) {
            return false;
        }

        $proFeatures = [
            'richpicks_pro_access',
            'richpicks_premium',
            'pro_chatroom_access',
        ];

        foreach ($proFeatures as $feature) {
            if (Gate::forUser($viewer)->allows('access-feature', $feature)) {
                return true;
            }
        }

        return false;
    }

    public function getSymbolNews(array $symbols)
    {
        // Fetch the WordPress API URL from configuration
        $wordpressApiUrl = config('services.wordpresstags.api_url');

        // Validate that symbols array is not empty
        if (empty($symbols)) {
            Log::warning('No symbols provided to fetch news.');
            return [];
        }

        // Convert all symbols to uppercase and ensure uniqueness
        $uniqueSymbols = collect($symbols)
            ->map(function ($symbol) {
                return strtoupper(trim($symbol));
            })
            ->unique()
            ->values()
            ->toArray();

        $tagsParam = implode(',', $uniqueSymbols);

        // Ensure the API URL ends with a slash
        $wordpressApiUrl = rtrim($wordpressApiUrl, '/') . '/';

        $secretKey = config('services.wordpresstags.secret_key');
        $wordpressApiUrl .= $tagsParam . '/?secret_key=' . $secretKey;

        try {
            $response = Http::timeout(15)->get($wordpressApiUrl);

            if ($response->successful()) {
                $posts = $response->json();

                if (!is_array($posts)) {
                    throw new \Exception('Invalid JSON structure received from WordPress API.');
                }

                $symbolNews = [];

                foreach ($posts as $newsData) {
                    if (isset($newsData['symbol'])) {
                        $symbol = strtoupper(trim($newsData['symbol']));

                        // Initialize the array if the symbol key doesn't exist
                        if (!isset($symbolNews[$symbol])) {
                            $symbolNews[$symbol] = [];
                        }

                        // Append the news data to the corresponding symbol
                        $symbolNews[$symbol][] = $newsData;
                    } else {
                        Log::warning('News data missing symbol key.', ['newsData' => $newsData]);
                    }
                }

                return $symbolNews;
            } else {
                // Log detailed error information
                Log::error('WordPress API request failed.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => $wordpressApiUrl,
                ]);

                return [];
            }
        } catch (\Exception $e) {
            // Log the exception message and stack trace
            Log::error('Error fetching WordPress posts: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return [];
        }
    }


    public function getSymbols($watchlistId)
    {
        try {
            // Fetch the watchlist with its symbols
            $watchlist = $this->getWatchListAllData($watchlistId);

            if (!$watchlist) {
                return response()->json(['error' => 'Watchlist not found'], 404);
            }

            // Get symbol names (ticker symbols) and exchanges from the watchlist
            $symbolNames = $watchlist->watchlistSymbols->pluck('symbol.symbol')->toArray();
            $symbolExchanges = $watchlist->watchlistSymbols->pluck('symbol.exchange')->toArray();

            if (empty($symbolNames)) {
                return response()->json(['error' => 'No symbols found in the watchlist'], 404);
            }

            // Fetch quotes for the symbols
            $symbolString = implode(',', $symbolNames); // Convert array to a string
            $apiUrl = env('STOCKS_API_URL') . "/api/quotes?symbols={$symbolString}";
            $response = Http::timeout(15)->get($apiUrl);

            if (!$response->successful()) {
                $errorDetails = [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => $apiUrl,
                ];
                Log::error('API request failed', $errorDetails);
                return response()->json([
                    'error' => 'Failed to fetch quotes from the API',
                    'details' => $errorDetails
                ], 503);
            }

            $quotes = $response->json();

            if (empty($quotes)) {
                return response()->json(['error' => 'No quotes data received from the API'], 404);
            }

            // Fetch news for the symbols
            $news = $this->getSymbolNews($symbolNames, $symbolExchanges);

            // Map the quotes and news to the watchlist symbols
            $watchlist->watchlistSymbols->each(function ($watchlistSymbol) use ($quotes, $news) {
                $symbolData = $watchlistSymbol->symbol->toArray();
                $quoteData = $quotes[$symbolData['symbol']] ?? null;
                $newsData = $news[$symbolData['symbol']] ?? null;

                if (!$quoteData) {
                    Log::warning("No quote data for symbol: {$symbolData['symbol']}");
                } else {
                    // Attach the quote and news data to the symbol object
                    $watchlistSymbol->symbol->quote = [
                        'logo' => $quoteData['logo'] ?? null,
                        'price' => $quoteData['regular_market_price'] ?? null,
                        'change' => $quoteData['regular_market_change'] ?? null,
                        'change_percent' => $quoteData['regular_market_change_percent'] ?? null,
                        'regularMarketDayRange' => $quoteData['regular_market_day_range'] ?? null,
                        'fiftyTwoWeekHigh' => $quoteData['fifty_two_week_high'] ?? null,
                        'fiftyTwoWeekLow' => $quoteData['fifty_two_week_low'] ?? null,
                        'updated_at' => $quoteData['updated_at'] ?? null,
                        'currency' => $quoteData['currency'] ?? null,
                        'volume' => $quoteData['volume'] ?? null,
                    ];

                    // Attach news to the symbol object
                    $watchlistSymbol->symbol->news = $newsData ?? [];
                }
            });

            // Return the watchlist with its symbols, quotes, and news
            return response()->json($watchlist);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Watchlist not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error in WatchlistController@getSymbols', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
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
    public function storeWatchListSymbol(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'error' => 'Unauthorized request',
                'status' => 401
            ], 401);
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
            return response()->json([
                'error' => 'Invalid symbol',
                'status' => 400
            ], 400);
        }

        if (empty($data['watchlist_id'])) {
            return response()->json([
                'error' => 'Watchlist ID is required',
                'status' => 400
            ], 400);
        }

        // Check if the symbol already exists in the watchlist
        $existingSymbol = WatchlistSymbol::where('watchlist_id', $data['watchlist_id'])
            ->where('symbol_id', $symbolId)
            ->first();

        if ($existingSymbol) {
            return response()->json([
                'error' => 'Symbol already exists in watchlist',
                'status' => 409
            ], 409);
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
            return response()->json([
                'error' => 'Error adding symbol to watchlist: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }




    public function copyWatchlist(Request $request)
    {
        $watchlistId = $request->input('watchlist_id');
        $requestedUserId = $request->input('user_id');
        $user = Auth::user();

        if ($user && $requestedUserId) {
            // Find the original watchlist
            $originalWatchlist = UserWatchlist::find($watchlistId);
            if (!$originalWatchlist) {
                return response()->json('Watchlist not found', 404);
            }

            // Create a new watchlist for the user
            $newWatchlistName = "Copy " . $originalWatchlist->title;
            $newWatchlistData = [
                'user_id' => $user->id,
                'title' => $newWatchlistName,
                'who_can_view' => 'Everyone',
                'featured' => 0,
                'symbol_count' => 0,
                'position' => $this->getNextWatchlistPosition($user->id),
            ];

            $newWatchlist = UserWatchlist::create($newWatchlistData);

            if ($newWatchlist) {
                // Get the symbols from the original watchlist
                $symbols = WatchlistSymbol::where('watchlist_id', $watchlistId)->get();

                // Copy the symbols to the new watchlist
                foreach ($symbols as $symbol) {
                    WatchlistSymbol::create([
                        'user_id' => $user->id,
                        'watchlist_id' => $newWatchlist->id,
                        'symbol_id' => $symbol->symbol_id,
                        'position' => $symbol->position
                    ]);
                }

                return response()->json('Watchlist copied successfully');
            }
        } else {
            return response()->json([
                'status' => 'Not allowed',
            ], 403);
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
        $watchlistEmail = $this->sendWatchlistEmails(1);
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

    public function sendWatchlistEmails($userId)
    {
        $user = User::find($userId);
        if ($user && UserWatchlist::where('user_id', $userId)->exists()) {
            $watchlistData = UserWatchlist::where('user_id', $userId)
                ->orderBy('position')
                ->with([
                    'watchlistSymbols' => function ($query) {
                        $query->orderBy('position');
                    },
                    'watchlistSymbols.symbol'
                ])->get();

            $watchlistDetails = []; // Initialize an array to accumulate watchlist details

            foreach ($watchlistData as $watchlist) {
                $watchlistID = $watchlist['id'];
                $currentWatchlist = $this->getWatchListAllData($watchlistID); // Fetch full watchlist data

                // Get symbol names (ticker symbols) and exchanges from the watchlist
                $symbolNames = $currentWatchlist->watchlistSymbols->pluck('symbol.symbol')->toArray();
                $symbolString = implode(',', $symbolNames); // Convert array to a string
                $apiUrl = env('STOCKS_API_URL') . "/api/quotes?symbols={$symbolString}";
                $response = Http::timeout(15)->get($apiUrl);

                // Check for a successful response
                if ($response->successful()) {
                    $quotes = $response->json();

                    // Map the quotes and news to the watchlist symbols
                    $watchlistSymbols = [];
                    foreach ($currentWatchlist->watchlistSymbols as $watchlistSymbol) {
                        $symbolData = $watchlistSymbol->symbol->toArray();
                        $quoteData = $quotes[$symbolData['symbol']] ?? null;

                        if (!$quoteData) {
                            Log::warning("No quote data for symbol: {$symbolData['symbol']}");
                        } else {
                            // Attach the quote and news data to the symbol object
                            $symbolData['quote'] = [
                                'logo' => $quoteData['logo'] ?? null,
                                'price' => $quoteData['regular_market_price'] ?? null,
                                'change' => $quoteData['regular_market_change'] ?? null,
                                'change_percent' => $quoteData['regular_market_change_percent'] ?? null,
                                'regularMarketDayRange' => $quoteData['regular_market_day_range'] ?? null,
                                'fiftyTwoWeekHigh' => $quoteData['fifty_two_week_high'] ?? null,
                                'fiftyTwoWeekLow' => $quoteData['fifty_two_week_low'] ?? null,
                                'updated_at' => $quoteData['updated_at'] ?? null,
                                'currency' => $quoteData['currency'] ?? null,
                                'volume' => $quoteData['volume'] ?? null,
                            ];
                            $watchlistSymbols[] = ['symbol' => $symbolData];
                        }
                    }

                    // Collect current watchlist data for email
                    $watchlistDetails[] = [
                        'id' => $currentWatchlist->id,
                        'title' => $currentWatchlist->title,
                        'watchlist_symbols' => $watchlistSymbols
                    ];
                } else {
                    Log::error("Failed to fetch quotes for user ID: {$userId}, API response: " . $response->body());
                }
            }

            // Log all the watchlist details
            \Log::info("Watchlist Details: " . json_encode($watchlistDetails));

            // Send the email
            Mail::to($user->email)->send(new WatchlistAlertsMailable($user, $watchlistDetails));

        } else {
            // Log warning if no watchlist found
            \Log::warning("No watchlist found for user ID: {$userId}");
        }
    }

    private function getNextWatchlistPosition(int $userId): int
    {
        $maxPosition = UserWatchlist::where('user_id', $userId)->max('position');

        return $maxPosition === null ? 0 : ($maxPosition + 1);
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

