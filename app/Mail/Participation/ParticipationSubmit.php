<?php

namespace App\Mail\Participation;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ParticipationSubmit extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $nama;

    protected $nominal;

    protected $metode;

    protected $judul_activity;

    public function __construct($nama, $nominal, $metode, $judul_activity)
    {
        $this->nama = $nama;
        $this->nominal = number_format(floatval($nominal));
        $this->metode = $metode;
        $this->judul_activity = $judul_activity;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $besok = Carbon::tomorrow(new \DateTimeZone('Asia/Jakarta'))->isoFormat('dddd, D MMMM Y');

        return $this->subject('Instruksi Pembarayan Aktivitas')
            ->from('noreply@involuntir.com', 'Involuntir')
            ->view('emails.participation.instruksi')->with([
                'nama' => $this->nama,
                'nominal' => $this->nominal,
                'metode' => $this->metode,
                'judul' => $this->judul_activity,
                'hari' => $besok,
            ]);
    }
}
