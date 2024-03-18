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
    protected $name;
    protected $nominal;
    protected $judul_activity;
    protected $link_wa;

    public function __construct($payment_channel, $name, $nominal, $judul_activity, $link_wa)
    {
        $this->payment_channel = $payment_channel;
        $this->name = $name;
        $this->nominal = $nominal;
        $this->judul_activity = $judul_activity;
        $this->link_wa = $link_wa;
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
                'nama_donatur' => $this->name,
                'nominal' => number_format(floatval($this->nominal)),
                'metode' => $this->payment_channel,
                'judul' => $this->judul_activity,
                'tautan'=> $this->link_wa,
            ]);
    }
}