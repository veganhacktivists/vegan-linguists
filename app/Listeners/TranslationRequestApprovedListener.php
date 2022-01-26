<?php

namespace App\Listeners;

use App\Models\TranslationRequestStatus;
use App\Notifications\TranslationRequestApprovedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TranslationRequestApprovedListener
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
    public function handle($event)
    {
        $translationRequest = $event->translationRequest;
        $reviewer = $event->reviewer;

        if ($translationRequest->num_approvals === $translationRequest->num_approvals_required) {
            $translationRequest->update(['status' => TranslationRequestStatus::COMPLETE]);
        }

        if ($translationRequest->translator) {
            $translationRequest->translator->notify(
                new TranslationRequestApprovedNotification(
                    $translationRequest,
                    $reviewer
                )
            );
        }

        $translationRequest->source->author->notify(
            new TranslationRequestApprovedNotification(
                $translationRequest,
                $reviewer
            )
        );
    }
}
