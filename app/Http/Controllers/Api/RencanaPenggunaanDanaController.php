<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\IconRencanaPenggunaanDana;
use App\Models\RencanaPenggunaanDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RencanaPenggunaanDanaController extends Controller
{
    public function decreementDonation($nominal, $penggunaan): int {
        $value = $nominal;
        foreach ($penggunaan as $item) {
            if($item->is_percent) {
                $value -= $nominal * $item->biaya / 100;
            } else {
                $value -= $item->biaya;
            }
        }
        return $value;
    }

    public function index($campaign_id) {
        $campaign = Campaign::find($campaign_id);
        $total_donasi = $campaign->donations()->get(DB::raw('SUM(donasi) as total_donasi'));

        $rencana_penggunaan = RencanaPenggunaanDana::with('icon')->orderBy('created_at', 'desc')->where('campaign_id', $campaign_id)->get();

        $decrementDonation = $this->decreementDonation($total_donasi[0]->total_donasi, $rencana_penggunaan);

        $for_program = [
            'judul' => 'Donasi untuk program',
            'biaya' => "$decrementDonation",
            'is_percent' => false,
            'icon' => IconRencanaPenggunaanDana::first()
        ];

        return response()->json([
            'target_donasi' => $campaign->nominal_campaign,
            'donasi_terkumpul' => $total_donasi[0]->total_donasi,
            'rencana' => $rencana_penggunaan,
            'untuk_program' => $for_program
        ]);
    }
}
