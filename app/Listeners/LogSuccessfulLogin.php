<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\Facades\Activity;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Cache;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        
        Activity::causedBy($event->user)
            ->log('logged in');
            
    }
}
