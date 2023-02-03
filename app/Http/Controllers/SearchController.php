<?php

namespace App\Http\Controllers;

use App\Models\Activity;
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

        $activities = Activity::leftJoin("participations", "participations.activity_id", "=", "activities.id")
        ->groupBy("activities.id")
        ->orderBy('created_at', 'DESC')
        ->where('status_publish', 'published')
        ->where('judul_activity', 'like', '%'.$request->keyword.'%')
        ->orWhere('status_publish', NULL)
        ->get([
            'activities.id', 
            "judul_activity", 
            "judul_slug", 
            "foto_activity", 
            "batas_waktu", 
            "activities.created_at", 
            DB::raw("CONCAT(DATEDIFF(batas_waktu, CURRENT_DATE), ' hari') as sisa_waktu"),
            DB::raw("COUNT(participations.id) as total_volunteer")
        ]);
        $users = User::where("name", "like", "%" . $request->keyword . "%")->get(["id", "name", "status_akun", "created_at"]);
        return response()->json(["error" => false, "data" => ["users" => $users, "galangdana" => $activities]], 200);
    }
}
