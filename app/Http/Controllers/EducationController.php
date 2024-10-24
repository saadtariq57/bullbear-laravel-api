<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Gate;
use App\Models\Course;
use App\Models\Ebook;
use Illuminate\Support\Facades\Storage;

class EducationController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::all();
        return response()->json($ebooks);
    }
    
    public function getRecommendedEbooks(Request $request)
    {
        // Example Logic:
        // Recommend the latest 5 e-books.
        $ebooks = Ebook::orderBy('created_at', 'desc')->take(5)->get();

        return response()->json($ebooks);
    }

    public function download($id)
    {
        // Authenticate the user
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Retrieve the e-book by ID
        $ebook = Ebook::find($id);

        if (!$ebook) {
            return response()->json(['message' => 'E-book not found'], 404);
        }

        $fileRelativePath = $ebook->file_path;

        if (!Storage::disk('public')->exists($fileRelativePath)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $filePath = Storage::disk('public')->path($fileRelativePath);

        return response()->download($filePath, $this->sanitizeFileName($ebook->title) . '.pdf');
    }
    
    protected function sanitizeFileName($title)
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $title));
    }


    public function getVideosByPlaylist(Request $request)
    {
        $playlistId = $request->query('playlist_id');
        $limit = $request->query('limit');

        if (!$playlistId) {
            return response()->json(['error' => 'playlist_id is required'], 400);
        }

        $query = Video::where('playlist_id', $playlistId)
                      ->orderBy('published_at', 'desc');

        // Apply limit if given, otherwise fetch all results
        if ($limit) {
            $query->limit($limit);
        }

        $videos = $query->get();

        return response()->json(['videos' => $videos]);
    }


    public function courseIndex()
    {
        $user = auth()->user();
        
        if (!Gate::allows('access-feature', 'exclusive_market_intelligence') && 
            !Gate::allows('access-feature', 'educational_content')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $courses = Course::all();

        return response()->json($courses);
    }

}
