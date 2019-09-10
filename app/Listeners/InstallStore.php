<?php

namespace App\Listeners;

use App\Events\StoreActivated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\InstallOrdersPending;
use App\Jobs\InstallCheckoutAbandoned;
use App\Jobs\InstallWebHooks;

class InstallStore
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StoreCreated  $event
     * @return void
     */
    public function handle(StoreActivated $event)
    {
        InstallOrdersPending::dispatchNow($event->store);
        InstallCheckoutAbandoned::dispatchNow($event->store);
        InstallWebHooks::dispatchNow($event->store);
    }
}
