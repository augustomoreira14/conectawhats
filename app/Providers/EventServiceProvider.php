<?php

namespace App\Providers;

use App\Events\StoreActivated;
use App\Events\StoreCreated;
use App\Events\StoreDeactivated;
use App\Events\UserCreated;
use App\Listeners\InstallStore;
use App\Listeners\SendEmailWelcome;
use App\Listeners\UninstallStore;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreated::class => [
            SendEmailWelcome::class
        ],
        StoreActivated::class => [
            InstallStore::class
        ],
        StoreDeactivated::class => [
            UninstallStore::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
