<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function build()
    {
        return $this->view('emails.quizresultmail')
                    ->subject('Level 1 Results of the BYD EV Quiz Competition Announced!')
                    ->with([
                        'name' => $this->name,
                    ]);
    }
}
