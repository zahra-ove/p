<?php


namespace App\Services\Notification\Providers;


use App\Services\Notification\Providers\Contracts\Provider;
use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class EmailProvider implements Provider
{
    private $user;
    private $mailable;
    public function __construct(User $user,Mailable $mailable)
    {
        $this->mailable=$mailable;
        $this->user=$user;
    }

    public function send()
    {
        return Mail::to($this->user->email)->send($this->mailable);
    }

}
