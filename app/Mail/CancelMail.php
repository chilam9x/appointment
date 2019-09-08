<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $sub;
    public $mes;
    public function __construct($subject,$message)
    {
        $this->sub=$subject;
        $this->mes=$message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $e_subject=$this->sub;
        $e_message=$this->mes;
        return $this->from('requestappointment.sp@gmail.com', 'Mail Cancel Request')
        ->subject('Cancel an appointment')
        ->with([
            'name' => 'Request an appointment',
            'link' => 'https://apm.taybol.com/appointment'
        ])
        ->view('email.cancel-email',compact("e_message"));
    }
}
