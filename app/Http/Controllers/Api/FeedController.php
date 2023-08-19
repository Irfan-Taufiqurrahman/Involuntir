<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feed;

class FeedController extends Controller
{
    public function index()
    {
        $feeds = Feed::with('user')->withCount('likes')->orderBy('created_at', 'desc')->get();

        return response()->json($feeds);
    }
}
