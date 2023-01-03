<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\UrgentCampaign;
use Illuminate\Support\Facades\DB;

class UrgentCampaignsController extends Controller
{
    public function index() {
        $urgentCampaign = UrgentCampaign::join('campaigns', 'campaigns.id', '=', 'urgent_campaigns.campaign_id')->join('users', 'users.id', '=', 'campaigns.user_id')->leftJoin('donations', 'donations.campaign_id', '=', 'urgent_campaigns.campaign_id')->groupBy('urgent_campaigns.id')->get(['urgent_campaigns.id as id', 'campaigns.id as campaign_id', 'judul_campaign', 'campaigns.judul_slug', 'foto_campaign', 'nominal_campaign', 'name', 'batas_waktu_campaign', DB::raw("SUM(IF(donations.status_donasi = 'Approved', donations.donasi, 0)) as current_donation, sum(if(donations.status_donasi = 'Approved', 1, 0)) as donations_count")]);
        return response()->json(["error" => false, "data" => $urgentCampaign], 200);
    }
    
    public function add(Campaign $campaign) {
        if(UrgentCampaign::where("campaign_id", $campaign->id)->count() > 0) {
            return response()->json(["error" => false], 204);
        }
        
        UrgentCampaign::create([
            "campaign_id" => $campaign->id
        ]);
        
        return response()->json(["data" => UrgentCampaign::all()]);
    }
}
