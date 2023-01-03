<?php

namespace App\Console\Commands;

use App\Mail\DonasiGagal;
use App\Models\Donation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use DB;

class DonationFail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donation:Fail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email when User not pay until deadline date';
 
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Dapatkan tanggal hari ini
        $now = Carbon::now()->format('Y-m-d');
        
        //Dapat data donasi user dengan deadline hari ini
        $data = Donation::whereDate('deadline', $now)->get();

        //Mengirim email bagi user yang donasi dengan deadline hari ini
        foreach ($data as $key => $value) {
            if ($value->status_donasi == "Pending") {
                
                $nominal = $value->donasi;
                $metode = $value->metode_pembayaran;
                $nama_donatur = $value->nama;
                $email = $value->email;
                
                $judul_campaign = DB::table('campaigns')
                ->select('judul_campaign')
                ->where('id', $value->campaign_id)
                ->first()
                ->judul_campaign;
                
                $nama_fundraiser = DB::table('users')
                ->select('name')
                ->where('id', $value->user_id)
                ->first()
                ->name;

                Log::info($nama_donatur);
                
                Mail::to($email)->send(new DonasiGagal($nominal, $metode, $nama_donatur, $email, $judul_campaign, $nama_fundraiser));
            }
        }
    }
}
