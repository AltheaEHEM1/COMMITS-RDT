<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Login and logout events are now handled directly in UserController
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
