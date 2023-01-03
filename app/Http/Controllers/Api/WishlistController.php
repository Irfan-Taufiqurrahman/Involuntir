<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function index() {
        $user = Auth::user();
        $wishlist = Wishlist::with('campaign')->where('user_id', $user->id)->get();
        return response()->json(['data' => $wishlist]);
    }
    
    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        if(!Campaign::find($request->campaign_id)) {
            return response()->json(["message" => "Campaign not found"], 400);
        }

        $user = Auth::user();

        if(Wishlist::where(['user_id' => $user->id, 'campaign_id' => $request->campaign_id])->first()) {
            return response()->json(['message' => 'Wishlist has been added'], 304);
        }

        $wishlist = Wishlist::create([
            'campaign_id' => $request->campaign_id,
            'user_id' => $user->id
        ]);

        return response()->json(['message' => 'successfully created wishlist', 'data' => $wishlist], 201);
    }
    
    public function delete($campaign_id) {
        $wishlist = Wishlist::where(['user_id' => Auth::user()->id, 'campaign_id' => $campaign_id])->first();
        if(!$wishlist) {
            return response()->json(['message' => 'Wishlist not found'], 404);
        }
        $wishlist->delete();
        return response(['message' => 'successfully deleted wishlist'], 200);
    }
}
