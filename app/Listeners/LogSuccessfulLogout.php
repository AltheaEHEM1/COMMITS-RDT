<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Spatie\Activitylog\Facades\Activity;

class LogSuccessfulLogout
{
    public function handle(Logout $event): void
    {
        Activity::causedBy($event->user)
            ->log('logged out');
    }
}
