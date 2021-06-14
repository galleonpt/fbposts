<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Illuminate\Database\Events\QueryExecuted::class => [
            \App\Listeners\QueryDatabase::class,
        ],
        \App\Events\ExampleEvent::class => [
            \App\Listeners\ExampleListener::class,
        ],
    ];
}
