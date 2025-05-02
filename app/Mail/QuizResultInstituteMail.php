<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizResultInstituteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('emails.quizresultmailinstitute')
                    ->subject('Level 1 Results of the BYD EV Quiz Competition Announced!');
    }
}
