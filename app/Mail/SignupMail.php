<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $loginId;
    public $pass;
    public $pdf;

    public function __construct($user_name,$user_loginId,$user_pass,$pdf)
    {
        $this->name = $user_name;
        $this->loginId = $user_loginId;
        $this->pass = $user_pass;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Registration Successful – National Automobile Olympiad 2025')
                    ->view('emails.registration_confirmation');
    }
}
