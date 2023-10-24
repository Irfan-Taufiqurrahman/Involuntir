<?php

namespace App\Mail\Participation;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ParticipationFailed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $participation;

    protected $transaction;

    public function __construct($participation, $transaction)
    {
        $this->participation = $participation;
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pembayaran aktivitas gagal! ' . $this->participation->activity->judul_activity)
            ->from('noreply@involuntir.com', 'Involuntir')
            ->view('emails.participation.gagal')->with([
                'nama' => $this->participation->user->name,
                'judul' => $this->participation->activity->judul_activity,
                'nama_pembuat' => $this->participation->activity->user->name,
                'nominal' => number_format(floatval($this->transaction->amount)),
                'metode' => $this->participation->metode_pembayaran,
            ]);
    }
}
