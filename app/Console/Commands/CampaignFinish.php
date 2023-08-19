<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CampaignFinish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengganti status pada campaign yang telah selesai';

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

        Campaign::whereDate('batas_waktu_campaign', '<', $now)->update([
            'status' => 'Selesai',

        ]);
        Log::info($now);

    }
}
