<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class LikeController extends Controller
{
    public function like(Feed $feed)
    {
        try
        {
            $like = Like::create([
                'feed_id' => $feed->id,
                'user_id' => Auth::user()->id
            ]);
        }
        catch (Exception $ex)
        {
            return response()->json(['message' => $ex->getMessage()]);
        }

        return response()->json(['message' => 'Berhasil menyukai feed',
                                 'feed_id' => $like->feed_id,
                                 'user_id' => $like->user_id,
                                 'error'   => false]);
    }

    public function unlike(Feed $feed)
    {
        try
        {
            $like = Like::where(['feed_id' => $feed->id, 'user_id' => Auth::user()->id])->firstOrFail();
        }
        catch (Exception $ex)
        {
            return response()->json(['message' => $ex->getMessage()]);
        }

        $like->delete();

        return response()->json(['message' => 'Berhasil batalkan menyukai feed',
                                 'feed_id' => $like->feed_id,
                                 'user_id' => $like->user_id,
                                 'error'   => false]);
    }
}
