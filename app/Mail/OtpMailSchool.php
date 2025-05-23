<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class OtpMailSchool extends Mailable
{
    public $otp;
    public $name;
    
    public function __construct($otp,$name)
    {
        $this->otp = $otp;
         $this->name = $name;
    }

    public function build()
    {
        return $this->subject('Your One-Time Password (OTP) for Verification')
                    ->view('emails.otp_school')
                    ->with([
                        'otp' => $this->otp,'name' => $this->name
                    ]);
    }
}
