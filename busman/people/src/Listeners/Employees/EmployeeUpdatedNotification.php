<?php

namespace Busman\People\Listeners\Employees;

use Busman\People\Events\Employees\EmployeeUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeUpdatedNotification implements ShouldQueue
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
     * @param  EmployeeUpdated  $event
     * @return void
     */
    public function handle(EmployeeUpdated $event)
    {
        //
    }
}
