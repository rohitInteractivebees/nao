<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PublishResultLevel extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function build()
    {
        return $this->view('emails.publishresultlevel')
                    ->subject('Level 2 Digital Prototype Results Announced!')
                    ->with([
                        'name' => $this->name,
                    ]);
    }
}
