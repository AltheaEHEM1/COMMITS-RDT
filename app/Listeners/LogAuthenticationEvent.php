<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogAuthenticationEvent
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Log::info('Failed login event triggered');

        if ($event instanceof Failed) {
            $email = $event->credentials['email'] ?? 'unknown';
            $key = 'login_attempts:' . $email;
        
            // Increment attempt count
            $attempts = cache()->increment($key);
        
            // Optionally expire the count after 10 minutes
            cache()->put($key, $attempts, now()->addMinutes(10));
        
            activity('auth')
                ->withProperties([
                    'email' => $email,
                    'attempts' => $attempts
                ])
                ->log("Failed login attempt #$attempts");
        }
        
    }
}