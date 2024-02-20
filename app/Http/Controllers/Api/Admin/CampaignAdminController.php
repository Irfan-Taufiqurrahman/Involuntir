<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CampaignAdminController extends Controller
{
    public function index()
    {
        $campaigns = DB::table('activity')
            ->leftJoin('users', 'user_id', '=', 'users.id')
            ->leftJoin('donations', 'activity.id', '=', 'donations.activity_id')
            ->groupBy('activity.id')
            ->orderBy('activity.created_at', 'DESC')
            ->select('activity.id',
                'judul_activity',
                'users.name',
                'nominal',
                DB::raw("SUM(
                                            IF(
                                               donations.status_donasi = 'Approved',
                                               donations.donasi,
                                               0)
                                          )
                                          as total_donasi,
                                          IF(
                                            (batas_waktu_campaign < CURRENT_DATE),
                                             '-',
                                             CONCAT(DATEDIFF(batas_waktu_campaign, CURRENT_DATE), ' hari')
                                          )
                                          as sisa_waktu"),
                'activity.status')
            ->get();

        return response()->json(['data' => $campaigns]);
    }
}
