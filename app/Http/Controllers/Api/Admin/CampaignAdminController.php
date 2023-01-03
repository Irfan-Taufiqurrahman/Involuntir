<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignAdminController extends Controller
{
    public function index()
    {
        $campaigns = DB::table('campaigns')
                        ->leftJoin('users', 'user_id', '=', 'users.id')
                        ->leftJoin('donations', 'campaigns.id', '=', 'donations.campaign_id')
                        ->groupBy('campaigns.id')
                        ->orderBy('campaigns.created_at', 'DESC')
                        ->select('campaigns.id',
                                 'judul_campaign',
                                 'users.name',
                                 'nominal_campaign',
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
                                 'campaigns.status')
                        ->get();
        return response()->json(['data' => $campaigns]);
    }
}