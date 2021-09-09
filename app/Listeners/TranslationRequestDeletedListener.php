<?php

namespace App\Listeners;

use App\Events\TranslationRequestDeletedEvent;
use App\Models\Comment;
use App\Models\Source;
use App\Models\TranslationRequest;
use App\Models\TranslationRequestStatus;
use App\Models\User;
use App\Notifications\ClaimedTranslationRequestDeletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Queue\InteractsWithQueue;

class TranslationRequestDeletedListener
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
     * @param  TranslationRequestDeletedEvent  $event
     * @return void
     */
    public function handle(TranslationRequestDeletedEvent $event)
    {
        $translationRequest = $event->translationRequest;
        $status = $translationRequest->getOriginal('status');
        $translatorId = $translationRequest->getOriginal('translator_id');
        $translationRequestId = $translationRequest->getOriginal('id');

        DatabaseNotification::whereRaw(
            "json_extract(data, '$.translation_request_id') = {$translationRequestId}"
        )->delete();

        Comment::where('commentable_type', TranslationRequest::class)
            ->where('commentable_id', $translationRequestId)
            ->delete();

        if ($status !== TranslationRequestStatus::CLAIMED || !$translatorId) {
            return;
        }

        $translator = User::find($translationRequest->getOriginal('translator_id'));
        $sourceId = $translationRequest->getOriginal('source_id');

        $translationRequestTitle = Source::find($sourceId)->title;

        $translator->notify(new ClaimedTranslationRequestDeletedNotification(
            $translationRequestTitle,
        ));
    }
}
