<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ETicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $barcode;

    public function __construct($booking, $barcode)
    {
        $this->booking = $booking;
        $this->barcode = $barcode;
    }

    public function build()
    {
        return $this->subject('E-Ticket Sundara Trans')
                    ->view('emails.eticket')
                    ->with([
                        'kode_booking' => $this->booking->kode_booking,
                        'nama_pemesan' => $this->booking->nama_pemesan,
                        'email' => $this->booking->email,
                        'no_handphone' => $this->booking->no_handphone,
                        'total_pembayaran' => $this->booking->total_pembayaran,
                        'ticket' => $this->booking->ticket,
                        'nama_penumpang' => json_decode($this->booking->nama_penumpang),
                        'selected_seats' => json_decode($this->booking->kursi),
                        'barcode' => $this->barcode, // Pastikan barcode dikirim
                        'status' => $this->booking->status, // Kirim status booking
                    ]);
    }
}
