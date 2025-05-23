<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestimonialMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('New Testimonial Submission – National Automobile Olympiad 2025')
                    ->view('emails.testimonial_mail');
    }
}
