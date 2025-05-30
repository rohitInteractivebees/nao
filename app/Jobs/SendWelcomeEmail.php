<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\SignupMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name,$loginId,$pass,$pdf;

    public function __construct($user_name,$user_loginId,$user_pass,$pdf)
    {
        $this->name = $user_name;
        $this->loginId = $user_loginId;
        $this->pass = $user_pass;
        $this->pdf = $pdf;
    }

    public function handle()
    {
        try {
            $AdminEmail = User::where('is_admin', 1)->value('email');
            Mail::to($this->loginId)->cc($AdminEmail)->send(new SignupMail($this->name, $this->loginId, $this->pass, $this->pdf));
        } catch (\Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
        }
    }
}
