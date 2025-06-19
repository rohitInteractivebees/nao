<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReattemptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    public function __construct($user_name)
    {
        $this->name = $user_name;
    }

    public function build()
    {
        return $this->subject('Re-attempt Approval – National Automobile Olympiad 2025')
                    ->view('emails.reattempt_approval');
    }
}
