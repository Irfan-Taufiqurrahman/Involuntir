<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonasiGagal extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $nominal;

    protected $metode;

    protected $nama_donatur;

    protected $email;

    protected $judul_activity;

    protected $nama_fundraiser;

    public function __construct($donation)
    {
        $this->nama_donatur = $donation->nama;
        $this->nominal = number_format(floatval($donation->donasi));
        $this->metode = $donation->metode_pembayaran;
        $this->email = $donation->email;
        $this->judul_campaign = $donation->activity->judul_activity;
        $this->nama_fundraiser = $donation->nama_fundraiser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Gagal Transaksi')
        ->from('noreplyinvoluntir@gmail.com', 'Involuntir')
            ->view('emails.donasigagal')->with([
                'nama_donatur' => $this->nama_donatur,
                'nama_fundraiser' => $this->nama_fundraiser,
                'nominal' => $this->nominal,
                'metode' => $this->metode,
                'judul' => $this->judul_activity,
            ]);
    }
}
