<?php

namespace App\Listeners;

use App\Events\TranslationRequestDeletingEvent;
use App\Models\Comment;
use App\Models\Source;
use App\Models\TranslationRequest;
use App\Models\User;
use App\Notifications\ClaimedTranslationRequestDeletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TranslationRequestDeletingListener
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
     * @param  TranslationRequestDeletingEvent  $event
     * @return void
     */
    public function handle(TranslationRequestDeletingEvent $event)
    {
        $translationRequest = $event->translationRequest;
        $translationRequestId = $translationRequest->id;

        DatabaseNotification::whereRaw(
            "json_extract(data, '$.translation_request_id') = {$translationRequestId}"
        )->delete();

        $translationRequest->comments->each->delete();

        if (
            $translationRequest->translator &&
            ($translationRequest->isClaimed() || $translationRequest->isUnderReview())
        ) {
            $translationRequest->translator->notify(new ClaimedTranslationRequestDeletedNotification(
                $translationRequest->source->title,
                $translationRequest->language->name,
                ClaimedTranslationRequestDeletedNotification::RELATIONSHIP_TRANSLATOR,
            ));
        }

        if ($translationRequest->isUnderReview()) {
            $translationRequest->reviewers->each->notify(new ClaimedTranslationRequestDeletedNotification(
                $translationRequest->source->title,
                $translationRequest->language->name,
                ClaimedTranslationRequestDeletedNotification::RELATIONSHIP_REVIEWER,
            ));
        }

        $translationRequest->reviewers()->detach();
    }
}
