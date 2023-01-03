<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\KabarTerbaru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KabarTerbaruController extends Controller
{
    public function upload(Request $request) {
        $fileName = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs("/kabar_terbaru", $fileName, 'public');
        return response()->json(['location' => "/storage/$path"]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'judul'     => 'required',
            'body'      => 'required',
            'campaign_id'      => 'required'
        ]);

        $user = auth('api')->user();

        if($validator->fails()) {
            return response()->json(['data' => null, 'error' => $validator->errors()], 400);
        }

        $kabar_terbaru = KabarTerbaru::create([
            'judul'     => $request->judul,
            'body'      => $request->body,
            'user_id'   => $user->id,
            'campaign_id'  => $request->campaign_id
        ]);

        return response()->json(['data' => $kabar_terbaru, 'error' => false], 201);
    }
}
