<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CampaignReport;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class CampaignReportController extends Controller
{
    public function report(Campaign $campaign)
    {
        try
        {
            $report = CampaignReport::create([
                'campaign_id' => $campaign->id,
                'user_id' => Auth::user()->id
            ]);
        }
        catch (Exception $ex)
        {
            return response()->json(['message' => $ex->getMessage()]);
        }

        return response()->json(['message' => 'Berhasil melaporkan galang dana',
                                 'campaign_id' => $report->campaign_id,
                                 'user_id' => $report->user_id,
                                 'error'   => false]);
    }

    public function cancelReport(Campaign $campaign)
    {
        try
        {
            $report = CampaignReport::where(['campaign_id' => $campaign->id, 'user_id' => Auth::user()->id])->firstOrFail();
        }
        catch (Exception $ex)
        {
            return response()->json(['message' => $ex->getMessage()]);
        }

        $report->delete();

        return response()->json(['message' => 'Berhasil batalkan laporan galang dana',
                                 'campaign_id' => $report->campaign_id,
                                 'user_id' => $report->user_id,
                                 'error'   => false]);
    }
}
