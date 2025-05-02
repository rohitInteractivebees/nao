<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PublishResultLevelInstitute extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('emails.publishresultlevelInstitute')
                    ->subject('Level 2 Digital Prototype Results Announced!');
    }
}
