<?php

namespace Busman\People\Listeners\Customers;

use Busman\People\Events\Customers\Created as CustomerCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class Created implements ShouldQueue
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
     * @param  CustomerCreated  $event
     * @return void
     */
    public function handle(CustomerCreated $event)
    {
        // If user is subscribed to this event, send notification
        Notification::send(auth()->user(), new \Busman\People\Notifications\Customers\CustomerCreated($event->customer));
    }
}
