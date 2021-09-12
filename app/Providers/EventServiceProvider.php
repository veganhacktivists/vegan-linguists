<?php

namespace App\Providers;

use App\Events\CommentCreatedEvent;
use App\Events\CommentDeletedEvent;
use App\Events\TranslationRequestDeletedEvent;
use App\Events\TranslationRequestUpdatedEvent;
use App\Events\UserDeletedEvent;
use App\Listeners\CommentCreatedListener;
use App\Listeners\CommentDeletedListener;
use App\Listeners\TranslationRequestDeletedListener;
use App\Listeners\TranslationRequestUpdatedListener;
use App\Listeners\UserDeletedListener;
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
        CommentCreatedEvent::class => [
            CommentCreatedListener::class,
        ],
        CommentDeletedEvent::class => [
            CommentDeletedListener::class,
        ],
        TranslationRequestUpdatedEvent::class => [
            TranslationRequestUpdatedListener::class,
        ],
        TranslationRequestDeletedEvent::class => [
            TranslationRequestDeletedListener::class,
        ],
        UserDeletedEvent::class => [
            UserDeletedListener::class,
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
