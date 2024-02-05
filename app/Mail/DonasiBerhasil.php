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

    public function __construct($data)
    {
        $this->data = $data;
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
                'nama_donatur' => $this->data->nama,
                'nama_fundraiser' => $this->data->nama_fundraiser,
                'nominal' => number_format(floatval($this->data->donasi)),
                'metode' => $this->data->payment_channel,
                'judul' => $this->data->activity->judul_activity,
                'tautan'=>$this->data->tautan,
            ]);
    }
}