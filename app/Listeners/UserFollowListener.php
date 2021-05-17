<?php

namespace App\Listeners;

use App\Events\UserFollowEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserFollowListener
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
     * @param  UserFollowEvent  $event
     * @return void
     */
    public function handle(UserFollowEvent $event)
    {
        //
    }
}
