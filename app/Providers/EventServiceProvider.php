<?php

namespace App\Providers;

use App\Events\CommentCreatedEvent;
use App\Events\CommentDeletedEvent;
use App\Events\CommentUpdatedEvent;
use App\Events\SourceDeletingEvent;
use App\Events\TranslationRequestApprovedEvent;
use App\Events\TranslationRequestDeletingEvent;
use App\Events\TranslationRequestReviewerAddedEvent;
use App\Events\TranslationRequestUpdatedEvent;
use App\Events\UserDeletingEvent;
use App\Listeners\CommentCreatedListener;
use App\Listeners\CommentDeletedListener;
use App\Listeners\CommentUpdatedListener;
use App\Listeners\SourceDeletingListener;
use App\Listeners\TranslationRequestApprovedListener;
use App\Listeners\TranslationRequestDeletingListener;
use App\Listeners\TranslationRequestReviewerAddedListener;
use App\Listeners\TranslationRequestUpdatedListener;
use App\Listeners\UserDeletingListener;
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
        CommentUpdatedEvent::class => [
            CommentUpdatedListener::class,
        ],
        CommentDeletedEvent::class => [
            CommentDeletedListener::class,
        ],
        SourceDeletingEvent::class => [
            SourceDeletingListener::class,
        ],
        TranslationRequestApprovedEvent::class => [
            TranslationRequestApprovedListener::class,
        ],
        TranslationRequestUpdatedEvent::class => [
            TranslationRequestUpdatedListener::class,
        ],
        TranslationRequestDeletingEvent::class => [
            TranslationRequestDeletingListener::class,
        ],
        TranslationRequestReviewerAddedEvent::class => [
            TranslationRequestReviewerAddedListener::class,
        ],
        UserDeletingEvent::class => [
            UserDeletingListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }
}
