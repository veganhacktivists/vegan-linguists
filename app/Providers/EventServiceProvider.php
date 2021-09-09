<?php

namespace App\Providers;

use App\Events\TranslationRequestDeletedEvent;
use App\Events\TranslationRequestUpdatedEvent;
use App\Listeners\TranslationRequestDeletedListener;
use App\Listeners\TranslationRequestUpdatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        TranslationRequestUpdatedEvent::class => [
            TranslationRequestUpdatedListener::class,
        ],
        TranslationRequestDeletedEvent::class => [
            TranslationRequestDeletedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
