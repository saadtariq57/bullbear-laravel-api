<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ColoredPost;
use Illuminate\Support\Facades\Auth;
use Embed\Embed;
use App\Models\UserWatchlist;
use App\Models\Post;
use App\Models\Symbol;
use App\Models\Group;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Total Users
        $totalUsers = User::count();
        
        // Active Users
        $activeUsers = User::where('status', 'active')->count();

        // Total Watchlists
        $totalWatchlists = UserWatchlist::count();

        // Active Watchlists
        $activeWatchlists = UserWatchlist::count();

        // Total Posts
        $totalPosts = Post::count();

        // Active Posts
        $activePosts = Post::where('active', true)->count();

        // Total Symbols
        $totalSymbols = Symbol::count();

        // Active Symbols
        $activeSymbols = Symbol::where('active', true)->count();

        // Total Groups
        $totalGroups = Group::count();

        // Active Groups
        $activeGroups = Group::where('active', true)->count();

        // User Growth (Registrations over the last 12 months)
        $userGrowth = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subYear())
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Live Users By Zip
        $liveUsersByZip = User::select('zip', DB::raw('COUNT(*) as count'))
            ->where('status', 'active')
            ->groupBy('zip')
            ->get();

        // Top Contributors (Users with the most posts)
        $topContributors = User::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        // Latest Activities (e.g., new watchlists, posts)
        $latestWatchlists = UserWatchlist::with('user')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $latestPosts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Top Groups (Groups with the most members)
        $topGroups = Group::withCount('members')
            ->orderBy('members_count', 'desc')
            ->take(5)
            ->get();

        // Exam Metrics
        $totalExams = Exam::count();
        $activeExams = Exam::count();
        $totalQuestions = DB::table('exam_questions')->count();
        $averageQuestionsPerExam = $totalExams > 0 ? round($totalQuestions / $totalExams, 2) : 0;

        return view('admin.index', compact(
            'totalUsers',
            'activeUsers',
            'totalWatchlists',
            'activeWatchlists',
            'totalPosts',
            'activePosts',
            'totalSymbols',
            'activeSymbols',
            'totalGroups',
            'activeGroups',
            'userGrowth',
            'liveUsersByZip',
            'topContributors',
            'latestWatchlists',
            'latestPosts',
            'topGroups',
            'totalExams',
            'activeExams',
            'totalQuestions',
            'averageQuestionsPerExam'
        ));
    }

    /**
     * Show the application dashboard for Admins.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*public function index()
    {
        return view('admin.index');
    }*/

    public function feedPage()
    {
        return view('feed');
    }
    public function post()
    {
        return view('single-post');
    }
    public function profilePage($username){
        // return view('profile.index');
        $user = User::where('name', $username)->firstOrFail();
        return view('profile.index', compact('user'));
    }
    public function profileSettings($username)
    {
        $currentUser = Auth::user();
        if ($currentUser->name === $username) {
            return view('profile.setting');
        } else {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
    }
    public function groupPage()
    {
        return view('groups.index');
    }
    public function singleGroupPage()
    {
        return view('groups.single');
    }
    public function colorOptions()
    {
        $colors = ColoredPost::all();
        return response()->json($colors);
    }
    public function fetchLinkData(Request $request)
    {
        // Validate the URL
        $request->validate(['url' => 'required|url']);

        try {
            $embed = new Embed();
            $info = $embed->get($request->input('url'));

            // Extracting the necessary information
            $data = [
                'title' => $info->title,
                'description' => $info->description,
                'url' => $info->url,
                'image' => $info->image,
                'authorName' => $info->authorName,
                'authorUrl' => $info->authorUrl,
                'providerName' => $info->providerName,
                'providerUrl' => $info->providerUrl,
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch link data: ' . $e->getMessage()], 500);
        }
    }
    
}
