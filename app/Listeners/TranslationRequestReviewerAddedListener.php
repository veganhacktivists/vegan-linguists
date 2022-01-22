<?php

namespace App\Listeners;

use App\Events\TranslationRequestReviewerAddedEvent;
use App\Notifications\TranslationRequestReviewerAddedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TranslationRequestReviewerAddedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TranslationRequestReviewerAddedEvent $event)
    {
        $translationRequest = $event->translationRequest;
        $reviewer = $event->reviewer;

        $translationRequest->translator->notify(
            new TranslationRequestReviewerAddedNotification(
                $translationRequest,
                $reviewer
            )
        );

        $translationRequest->source->author->notify(
            new TranslationRequestReviewerAddedNotification(
                $translationRequest,
                $reviewer
            )
        );
    }
}
