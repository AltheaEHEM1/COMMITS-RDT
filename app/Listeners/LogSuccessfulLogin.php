<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\Facades\Activity;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        Activity::causedBy($event->user)
            ->log('logged in');
    }
}
