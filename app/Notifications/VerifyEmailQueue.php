<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmailQueue extends VerifyEmailNotification implements ShouldQueue
{
    use Queueable;
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->user->notify(new VerifyEmailNotification);
    }
}
