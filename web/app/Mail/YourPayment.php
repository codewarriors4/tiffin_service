<?php

namespace TiffinService\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class YourPayment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->from('codewarriors4@tiffinservice.com')->view('mails.payment_notification_email');
    }
}
