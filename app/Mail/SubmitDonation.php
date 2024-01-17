<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
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

    protected $bank_name;

    protected $judul_campaign;

    public function __construct($nama_lengkap, $nominal, $bank_name, $judul_campaign)
    {
        $this->nama_lengkap = $nama_lengkap;
        $this->nominal = number_format(floatval($nominal));
        $this->bank_name = $bank_name;
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
        ->from('noreplyinvoluntir@gmail.com', 'Involuntir')
            ->view('emails.instruksi')->with([
                'nama' => $this->nama_lengkap,
                'nominal' => $this->nominal,
                'bank_name' => $this->bank_name,
                'judul' => $this->judul_campaign,
                'hari' => $besok,
            ]);
    }
}