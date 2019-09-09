<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestMail extends Mailable
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
        return $this->from('requestappointment.sp@gmail.com', 'Mail Request')
        ->subject('Request an appointment')
        ->with([
            'name' => 'Cancel Request',
            'link' => 'https://apm.taybol.com/cancel-appointment'
        ])
        ->markdown('email.request-email',compact("e_message"));
    }
}
