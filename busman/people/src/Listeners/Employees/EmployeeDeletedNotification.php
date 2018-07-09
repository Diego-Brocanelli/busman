<?php

namespace Busman\People\Listeners\Employees;

use Busman\People\Events\Employees\EmployeeDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeDeletedNotification implements ShouldQueue
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
     * @param  EmployeeDeleted  $event
     * @return void
     */
    public function handle(EmployeeDeleted $event)
    {
        //
    }
}
