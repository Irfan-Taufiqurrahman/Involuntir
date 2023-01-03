<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        $galangdana = DB::table("campaigns")->leftJoin("donations", "donations.campaign_id", "=", "campaigns.id")->groupBy("campaigns.id")->where("judul_campaign", "like", "%" . $request->keyword . "%")->get(['campaigns.id', "judul_campaign", "campaigns.judul_slug", "foto_campaign", "nominal_campaign", "batas_waktu_campaign", DB::raw('sum(donasi) as total_donasi')]);
        $users = User::where("name", "like", "%" . $request->keyword . "%")->get(["id", "name", "status_akun", "created_at"]);
        return response()->json(["error" => false, "data" => ["users" => $users, "galangdana" => $galangdana]], 200);
    }
}
