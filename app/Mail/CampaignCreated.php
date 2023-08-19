<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $campaign;

    public function __construct($campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Selamat! Halaman galang dana berhasil dibuat')
            ->from('noreply@peduly.com', 'Peduly')
            ->view('emails.campaigncreated')
            ->with([
                'campaign_creator' => $this->campaign->user->name,
                'campaign_title' => $this->campaign->judul_campaign,
            ]);
    }
}
