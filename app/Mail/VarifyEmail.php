<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VarifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function build()
    {
        return $this->view('emails.varifyemail')
                    ->subject('Welcome to BYD EV Innovate-a-thon 2024! Your Registration is Verified')
                    ->with([
                        'name' => $this->name,
                    ]);
    }
}
