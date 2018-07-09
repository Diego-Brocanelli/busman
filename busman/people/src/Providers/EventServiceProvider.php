<?php

namespace Busman\People\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        // Customers Events
        'Busman\People\Events\Customers\CustomerCreated' => [
            'Busman\People\Listeners\Customers\CustomerCreatedNotification'
        ],

        'Busman\People\Events\Customers\CustomerUpdated' => [
            'Busman\People\Listeners\Customers\CustomerUpdatedNotification'
        ],

        'Busman\People\Events\Customers\CustomerDeleted' => [
            'Busman\People\Listeners\Customers\CustomerDeletedNotification'
        ],

        // Employees Events
        'Busman\People\Events\Employees\EmployeeCreated' => [
            'Busman\People\Listeners\Employees\EmployeeCreatedNotification'
        ],

        'Busman\People\Events\Employees\EmployeeUpdated' => [
            'Busman\People\Listeners\Employees\EmployeeUpdatedNotification'
        ],

        'Busman\People\Events\Employees\EmployeeDeleted' => [
            'Busman\People\Listeners\Employees\EmployeeDeletedNotification'
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
