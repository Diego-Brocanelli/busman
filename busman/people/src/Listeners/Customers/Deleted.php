<?php

namespace Busman\People\Listeners\Customers;

use Busman\People\Events\Customers\Deleted as CustomerDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Deleted implements ShouldQueue
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
     * @param  CustomerDeleted  $event
     * @return void
     */
    public function handle(CustomerDeleted $event)
    {
        //
    }
}
