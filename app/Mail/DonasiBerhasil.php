<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonasiBerhasil extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;

    protected $bank_name;
    protected $emoney_name;
    protected $payment_channel;
    protected $nama_lengkap;
    protected $nominal;
    protected $judul_activity;
    protected $tautan;

    public function __construct($payment_channel, $nama_lengkap, $nominal, $judul_activity, $tautan)
    {
        $this->payment_channel = $payment_channel;
        $this->nama_lengkap = $nama_lengkap;
        $this->nominal = $nominal;
        $this->judul_activity = $judul_activity;
        $this->tautan = $tautan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Konfirmasi donasi')
            ->from('noreplyinvoluntir@gmail.com', 'Involuntir')
            ->view('emails.donasiberhasil')
            ->with([
                'nama_donatur' => $this->nama_lengkap,
                'nominal' => number_format(floatval($this->nominal)),
                'metode' => $this->payment_channel,
                'judul' => $this->judul_activity,
                'tautan'=>$this->tautan,
            ]);
    }
}