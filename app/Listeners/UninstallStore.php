<?php

namespace App\Listeners;

use App\Events\StoreDeactivated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ConectaWhats\Auth\Domain\Models\User;

class UninstallStore
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
     * @param  StoreDeactivated  $event
     * @return void
     */
    public function handle(StoreDeactivated $event)
    {
        $user = User::findOrFail($event->store->user_id);
        $event->store->user_id = null;
        $event->store->save();
        $user->delete();
    }
}
