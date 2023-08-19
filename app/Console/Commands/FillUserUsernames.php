<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class FillUserUsernames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:usernames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menganti semua username kosong dengan username dari email';

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

        $users = User::whereNull('username')->get();

        foreach ($users as $user) {
            $username = explode('@', $user->email)[0];
            $user->username = $username;
            $user->save();
        }

        $this->info('Usernames filled successfully.');
    }
}
