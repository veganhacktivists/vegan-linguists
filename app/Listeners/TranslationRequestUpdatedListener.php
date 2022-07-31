<?php

namespace App\Listeners;

use App\Events\TranslationRequestUpdatedEvent;
use App\Models\TranslationRequestStatus;
use App\Models\User;
use App\Notifications\TranslationRequestClaimedNotification;
use App\Notifications\TranslationRequestClaimRevokedNotification;
use App\Notifications\TranslationRequestUnclaimedNotification;
use App\Notifications\TranslationSubmittedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class TranslationRequestUpdatedListener
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
     * @param  TranslationRequestUpdatedEvent  $event
     * @return void
     */
    public function handle(TranslationRequestUpdatedEvent $event)
    {
        $translationRequest = $event->translationRequest;
        $prevStatus = $translationRequest->getOriginal('status');

        if (
            ($translationRequest->isComplete() ||
                $translationRequest->isUnderReview()) &&
            $prevStatus === TranslationRequestStatus::CLAIMED
        ) {
            $translationRequest->source->author->notify(
                new TranslationSubmittedNotification(
                    $translationRequest->translator,
                    $translationRequest
                )
            );
        } elseif (
            $translationRequest->isClaimed() &&
            $prevStatus === TranslationRequestStatus::UNCLAIMED
        ) {
            $translationRequest->source->author->notify(
                new TranslationRequestClaimedNotification(
                    $translationRequest->translator,
                    $translationRequest
                )
            );
        } elseif (
            $translationRequest->isUnclaimed() &&
            $prevStatus === TranslationRequestStatus::CLAIMED
        ) {
            $translator = User::find(
                $translationRequest->getOriginal('translator_id')
            );

            if ($translationRequest->source->author->is(Auth::user())) {
                $translator->notify(
                    new TranslationRequestClaimRevokedNotification(
                        $translationRequest->source->author,
                        $translationRequest
                    )
                );
            } else {
                $translationRequest->source->author->notify(
                    new TranslationRequestUnclaimedNotification(
                        $translator,
                        $translationRequest
                    )
                );
            }
        }
    }
}
