<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizPublishMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function build()
    {
        return $this->view('emails.quizpublishmail')
                    ->subject('Join the BYD EV Quiz Competition Now!')
                    ->with([
                        'name' => $this->name,
                    ]);
    }                
}
