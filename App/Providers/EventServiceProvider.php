<?php

namespace Lareon\CMS\App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Lareon\CMS\App\Events\UserRegistrationEvent;
use Lareon\CMS\App\Listeners\UserRegistrationListener;

class EventServiceProvider  extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
            UserRegistrationEvent::class=>[
                UserRegistrationListener::class,
            ]
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void
    {
        //
    }
}
