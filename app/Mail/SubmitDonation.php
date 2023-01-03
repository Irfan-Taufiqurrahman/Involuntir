<?php

namespace App\Mail;

use Carbon\Carbon;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmitDonation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $nama_lengkap;
    protected $nominal;
    protected $metode;
    protected $judul_campaign;

    public function __construct($nama_lengkap, $nominal, $metode, $judul_campaign)
    {
        $this->nama_lengkap = $nama_lengkap;
        $this->nominal = number_format(floatval($nominal));
        $this->metode = $metode;
        $this->judul_campaign = $judul_campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        
        $besok = Carbon::tomorrow(new \DateTimeZone('Asia/Jakarta'))->isoFormat('dddd, D MMMM Y');
        
        return $this->subject('Instruksi Transaksi')
            ->from('noreply@peduly.com', 'Peduly')
            ->view('emails.instruksi')->with([
                'nama' => $this->nama_lengkap,
                'nominal' => $this->nominal,
                'metode' => $this->metode,
                'judul' => $this->judul_campaign,
                'hari' => $besok
            ]);
    }
}
