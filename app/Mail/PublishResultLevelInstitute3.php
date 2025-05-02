<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PublishResultLevelInstitute3 extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('emails.publishresultlevelInstitute3')
                    ->subject('Level 3 Physical Prototype and Sales Presentation Results Announced!');
    }
}
