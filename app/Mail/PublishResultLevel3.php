<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PublishResultLevel3 extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function build()
    {
        return $this->view('emails.publishresultlevel3')
                    ->subject('Level 3 Physical Prototype and Sales Presentation Results Announced!')
                    ->with([
                        'name' => $this->name,
                    ]);
    }
}
