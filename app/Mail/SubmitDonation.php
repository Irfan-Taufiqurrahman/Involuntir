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
    protected $judul_activity;
    protected $user;
    protected $deadline;
    protected $donation;

    public function __construct($nama_lengkap, $nominal, $payment_channel, $judul_activity, $deadline, $user, $donation)
    {
        $this->nama_lengkap = $nama_lengkap;
        $this->nominal = number_format(floatval($nominal));
        $this->bank_name = $payment_channel;
        $this->judul_activity = $judul_activity;
        $this->deadline=$deadline;
        $this->user = $user;
        $this->donation = $donation;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        return $this->subject('Instruksi Transaksi')
        ->from('noreplyinvoluntir@gmail.com', 'Involuntir')
            ->view('emails.instruksi')->with([
                'nama' => $this->nama_lengkap,
                'nominal' => $this->nominal,
                'bank_name' => $this->bank_name,
                'judul' => $this->judul_activity,
                'hari' => $this->deadline,
                'creator_activity' => $this->user->name,
                'id_donation' => $this->donation->id,
            ]);
    }
}