<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupMailSchool extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $loginId;
    public $pass;
    public $code;

    public function __construct($user_name,$user_loginId,$user_pass,$code)
    {
        $this->name = $user_name;
        $this->loginId = $user_loginId;
        $this->pass = $user_pass;
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Welcome to National Automobile Olympiad (NAO) 2025 – School Registration Successful')
                    ->view('emails.school_registration_confirmation');
    }
}
