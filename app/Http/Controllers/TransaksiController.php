<?php

namespace App\Http\Controllers;

use App\Models\Donation;

class TransaksiController extends Controller
{
    public function transaksi()
    {   
        $dataDonatur = Donation::all();
        return view('admin.pages.transaksi.transaksi', compact('dataDonatur'));
    }
    
    public function fundraiser()
    {   
        $dataFundraiser = Donation::join('users', 'users.id', '=', 'donations.prantara_donasi')
            ->where('metode_pembayaran', '=', 'Fundraiser')
            ->selectRaw('*, SUM(donasi) as total_donasi')
            ->groupBy('prantara_donasi')
            ->get(['users.name', 'donations.*']) ;
        
        // dd($dataFundraiser->toArray());


        return view('admin.pages.transaksi.fundraiser', compact('dataFundraiser'));
    }
}
